<?php

session_name('JIVHALA_ADMIN_SESSION');
session_start();

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Session Timeout - 30 Minutes
|--------------------------------------------------------------------------
*/

$timeout = 30 * 60;

if (
    isset($_SESSION['last_activity']) &&
    (time() - $_SESSION['last_activity']) > $timeout
) {
    session_unset();
    session_destroy();

    header("Location: login.php?timeout=1");
    exit;
}

$_SESSION['last_activity'] = time();

$adminName = $_SESSION['admin_name'] ?? 'Administrator';


/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/

include "../conn.php";


/*
|--------------------------------------------------------------------------
| Variables
|--------------------------------------------------------------------------
*/

$message = '';
$messageType = '';


/*
|--------------------------------------------------------------------------
| Generate Slug
|--------------------------------------------------------------------------
*/

function generateSlug($text)
{
    $text = strtolower(trim($text));

    $text = preg_replace('/[^a-z0-9]+/', '-', $text);

    return trim($text, '-');
}


/*
|--------------------------------------------------------------------------
| Format Indian Currency
|--------------------------------------------------------------------------
*/

function formatIndianCurrency($amount)
{
    if ($amount === null || $amount === '') {
        return '—';
    }

    $amount = (float) $amount;

    $amount = number_format(
        $amount,
        2,
        '.',
        ''
    );

    $parts = explode('.', $amount);

    $number = $parts[0];
    $decimal = $parts[1];

    $lastThree = substr($number, -3);
    $remaining = substr($number, 0, -3);

    if ($remaining !== '') {

        $remaining = preg_replace(
            '/\B(?=(\d{2})+(?!\d))/',
            ',',
            $remaining
        );

        $number = $remaining . ',' . $lastThree;
    } else {

        $number = $lastThree;
    }

    if ($decimal === '00') {
        return $number;
    }

    return $number . '.' . $decimal;
}


/*
|--------------------------------------------------------------------------
| Fetch Equipment Categories
|--------------------------------------------------------------------------
*/

try {

    $categoryStmt = $pdo->query("
        SELECT
            id,
            name
        FROM equipment_categories
        WHERE status = 1
        ORDER BY name ASC
    ");

    $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    $categories = [];

    $message = "Unable to load equipment categories.";
    $messageType = "error";
}


/*
|--------------------------------------------------------------------------
| SAVE EQUIPMENT
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action']) &&
    $_POST['action'] === 'save'
) {

    $categoryId = isset($_POST['category_id'])
        ? (int) $_POST['category_id']
        : 0;

    $name = trim($_POST['name'] ?? '');

    $shortDescription = trim(
        $_POST['short_description'] ?? ''
    );

    $description = trim(
        $_POST['description'] ?? ''
    );

    $technicalSpecifications = trim(
        $_POST['technical_specifications'] ?? ''
    );

    $brands = trim(
        $_POST['brands'] ?? ''
    );

    $purchasePrice = trim(
        $_POST['purchase_price'] ?? ''
    );

    $rentalPrice = trim(
        $_POST['rental_price'] ?? ''
    );

    $rentalPeriod = trim(
        $_POST['rental_period'] ?? ''
    );


    if ($categoryId <= 0) {

        $message = "Please select an equipment category.";
        $messageType = "error";
    } elseif ($name === '') {

        $message = "Equipment name is required.";
        $messageType = "error";
    } else {

        try {

            /*
            |--------------------------------------------------------------------------
            | Verify Category
            |--------------------------------------------------------------------------
            */

            $categoryCheckStmt = $pdo->prepare("
                SELECT id
                FROM equipment_categories
                WHERE id = ?
                  AND status = 1
                LIMIT 1
            ");

            $categoryCheckStmt->execute([
                $categoryId
            ]);


            if (!$categoryCheckStmt->fetch()) {

                $message =
                    "Selected equipment category is invalid.";

                $messageType = "error";
            } else {

                /*
                |--------------------------------------------------------------------------
                | Check Duplicate
                |--------------------------------------------------------------------------
                */

                $checkStmt = $pdo->prepare("
                    SELECT id
                    FROM equipment
                    WHERE category_id = ?
                      AND name = ?
                    LIMIT 1
                ");

                $checkStmt->execute([
                    $categoryId,
                    $name
                ]);


                if ($checkStmt->fetch()) {

                    $message =
                        "This equipment already exists in the selected category.";

                    $messageType = "error";
                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Generate Slug
                    |--------------------------------------------------------------------------
                    */

                    $slug = generateSlug($name);

                    $originalSlug = $slug;
                    $counter = 1;


                    while (true) {

                        $slugCheckStmt = $pdo->prepare("
                            SELECT id
                            FROM equipment
                            WHERE slug = ?
                            LIMIT 1
                        ");

                        $slugCheckStmt->execute([
                            $slug
                        ]);


                        if (!$slugCheckStmt->fetch()) {
                            break;
                        }


                        $slug =
                            $originalSlug .
                            '-' .
                            $counter;

                        $counter++;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Image Upload
                    |--------------------------------------------------------------------------
                    */

                    $imagePath = null;


                    if (
                        isset($_FILES['image']) &&
                        $_FILES['image']['error'] !==
                        UPLOAD_ERR_NO_FILE
                    ) {

                        if (
                            $_FILES['image']['error'] !==
                            UPLOAD_ERR_OK
                        ) {

                            throw new Exception(
                                "There was an error uploading the image."
                            );
                        }


                        $allowedExtensions = [
                            'jpg',
                            'jpeg',
                            'png',
                            'webp'
                        ];


                        $fileName =
                            $_FILES['image']['name'];

                        $tmpName =
                            $_FILES['image']['tmp_name'];

                        $fileSize =
                            $_FILES['image']['size'];


                        $extension = strtolower(
                            pathinfo(
                                $fileName,
                                PATHINFO_EXTENSION
                            )
                        );


                        if (
                            !in_array(
                                $extension,
                                $allowedExtensions,
                                true
                            )
                        ) {

                            throw new Exception(
                                "Only JPG, JPEG, PNG and WEBP images are allowed."
                            );
                        }


                        if (
                            $fileSize >
                            5 * 1024 * 1024
                        ) {

                            throw new Exception(
                                "Image size must be less than 5 MB."
                            );
                        }


                        $uploadDirectory =
                            "../assets/images/equipment/";


                        if (
                            !is_dir(
                                $uploadDirectory
                            )
                        ) {

                            mkdir(
                                $uploadDirectory,
                                0755,
                                true
                            );
                        }


                        $newFileName =
                            $slug .
                            '-' .
                            time() .
                            '-' .
                            uniqid() .
                            '.' .
                            $extension;


                        $destination =
                            $uploadDirectory .
                            $newFileName;


                        if (
                            !move_uploaded_file(
                                $tmpName,
                                $destination
                            )
                        ) {

                            throw new Exception(
                                "Unable to save the uploaded image."
                            );
                        }


                        $imagePath =
                            "assets/images/equipment/" .
                            $newFileName;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Prices
                    |--------------------------------------------------------------------------
                    */

                    $purchasePriceValue =
                        $purchasePrice !== ''
                        ? $purchasePrice
                        : null;

                    $rentalPriceValue =
                        $rentalPrice !== ''
                        ? $rentalPrice
                        : null;


                    /*
                    |--------------------------------------------------------------------------
                    | Insert
                    |--------------------------------------------------------------------------
                    */

                    $insertStmt = $pdo->prepare("
                        INSERT INTO equipment (
                            category_id,
                            name,
                            slug,
                            image,
                            short_description,
                            description,
                            technical_specifications,
                            brands,
                            purchase_price,
                            rental_price,
                            rental_period,
                            status
                        )
                        VALUES (
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            1
                        )
                    ");


                    $insertStmt->execute([
                        $categoryId,
                        $name,
                        $slug,
                        $imagePath,
                        $shortDescription ?: null,
                        $description ?: null,
                        $technicalSpecifications ?: null,
                        $brands ?: null,
                        $purchasePriceValue,
                        $rentalPriceValue,
                        $rentalPeriod ?: null
                    ]);


                    $message =
                        "Equipment details added successfully.";

                    $messageType = "success";

                    $_POST = [];
                }
            }
        } catch (Exception $e) {

            $message =
                $e->getMessage();

            $messageType = "error";
        }
    }
}


/*
|--------------------------------------------------------------------------
| UPDATE EQUIPMENT
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action']) &&
    $_POST['action'] === 'update'
) {

    $equipmentId = isset($_POST['equipment_id'])
        ? (int) $_POST['equipment_id']
        : 0;

    $categoryId = isset($_POST['category_id'])
        ? (int) $_POST['category_id']
        : 0;

    $name = trim($_POST['name'] ?? '');

    $shortDescription = trim(
        $_POST['short_description'] ?? ''
    );

    $description = trim(
        $_POST['description'] ?? ''
    );

    $technicalSpecifications = trim(
        $_POST['technical_specifications'] ?? ''
    );

    $brands = trim(
        $_POST['brands'] ?? ''
    );

    $purchasePrice = trim(
        $_POST['purchase_price'] ?? ''
    );

    $rentalPrice = trim(
        $_POST['rental_price'] ?? ''
    );

    $rentalPeriod = trim(
        $_POST['rental_period'] ?? ''
    );

    $status = isset($_POST['status'])
        ? (int) $_POST['status']
        : 1;


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($equipmentId <= 0) {

        $message = "Invalid equipment.";
        $messageType = "error";
    } elseif ($categoryId <= 0) {

        $message = "Please select an equipment category.";
        $messageType = "error";
    } elseif ($name === '') {

        $message = "Equipment name is required.";
        $messageType = "error";
    } else {

        try {

            /*
            |--------------------------------------------------------------------------
            | Get Existing Equipment
            |--------------------------------------------------------------------------
            */

            $existingStmt = $pdo->prepare("
                SELECT
                    id,
                    name,
                    image,
                    slug
                FROM equipment
                WHERE id = ?
                LIMIT 1
            ");

            $existingStmt->execute([
                $equipmentId
            ]);

            $existingEquipment =
                $existingStmt->fetch(PDO::FETCH_ASSOC);


            if (!$existingEquipment) {

                $message =
                    "Equipment not found.";

                $messageType = "error";
            } else {

                /*
                |--------------------------------------------------------------------------
                | Verify Category
                |--------------------------------------------------------------------------
                */

                $categoryCheckStmt = $pdo->prepare("
                    SELECT id
                    FROM equipment_categories
                    WHERE id = ?
                      AND status = 1
                    LIMIT 1
                ");

                $categoryCheckStmt->execute([
                    $categoryId
                ]);


                if (!$categoryCheckStmt->fetch()) {

                    $message =
                        "Selected equipment category is invalid.";

                    $messageType = "error";
                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Duplicate Check
                    |--------------------------------------------------------------------------
                    */

                    $duplicateStmt = $pdo->prepare("
                        SELECT id
                        FROM equipment
                        WHERE category_id = ?
                          AND name = ?
                          AND id != ?
                        LIMIT 1
                    ");

                    $duplicateStmt->execute([
                        $categoryId,
                        $name,
                        $equipmentId
                    ]);


                    if ($duplicateStmt->fetch()) {

                        $message =
                            "This equipment already exists in the selected category.";

                        $messageType = "error";
                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | Generate Slug
                        |--------------------------------------------------------------------------
                        */

                        $slug = generateSlug($name);

                        $originalSlug = $slug;
                        $counter = 1;


                        while (true) {

                            $slugCheckStmt = $pdo->prepare("
                                SELECT id
                                FROM equipment
                                WHERE slug = ?
                                  AND id != ?
                                LIMIT 1
                            ");

                            $slugCheckStmt->execute([
                                $slug,
                                $equipmentId
                            ]);


                            if (!$slugCheckStmt->fetch()) {
                                break;
                            }


                            $slug =
                                $originalSlug .
                                '-' .
                                $counter;

                            $counter++;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Keep Existing Image
                        |--------------------------------------------------------------------------
                        */

                        $imagePath =
                            $existingEquipment['image'];


                        /*
                        |--------------------------------------------------------------------------
                        | New Image Upload
                        |--------------------------------------------------------------------------
                        */

                        if (
                            isset($_FILES['image']) &&
                            $_FILES['image']['error'] !==
                            UPLOAD_ERR_NO_FILE
                        ) {

                            if (
                                $_FILES['image']['error'] !==
                                UPLOAD_ERR_OK
                            ) {

                                throw new Exception(
                                    "There was an error uploading the new image."
                                );
                            }


                            $allowedExtensions = [
                                'jpg',
                                'jpeg',
                                'png',
                                'webp'
                            ];


                            $fileName =
                                $_FILES['image']['name'];

                            $tmpName =
                                $_FILES['image']['tmp_name'];

                            $fileSize =
                                $_FILES['image']['size'];


                            $extension = strtolower(
                                pathinfo(
                                    $fileName,
                                    PATHINFO_EXTENSION
                                )
                            );


                            if (
                                !in_array(
                                    $extension,
                                    $allowedExtensions,
                                    true
                                )
                            ) {

                                throw new Exception(
                                    "Only JPG, JPEG, PNG and WEBP images are allowed."
                                );
                            }


                            if (
                                $fileSize >
                                5 * 1024 * 1024
                            ) {

                                throw new Exception(
                                    "Image size must be less than 5 MB."
                                );
                            }


                            $uploadDirectory =
                                "../assets/images/equipment/";


                            if (
                                !is_dir(
                                    $uploadDirectory
                                )
                            ) {

                                mkdir(
                                    $uploadDirectory,
                                    0755,
                                    true
                                );
                            }


                            $newFileName =
                                $slug .
                                '-' .
                                time() .
                                '-' .
                                uniqid() .
                                '.' .
                                $extension;


                            $destination =
                                $uploadDirectory .
                                $newFileName;


                            if (
                                !move_uploaded_file(
                                    $tmpName,
                                    $destination
                                )
                            ) {

                                throw new Exception(
                                    "Unable to save the new image."
                                );
                            }


                            $imagePath =
                                "assets/images/equipment/" .
                                $newFileName;


                            /*
                            |--------------------------------------------------------------------------
                            | Delete Old Image
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !empty($existingEquipment['image'])
                            ) {

                                $oldImage =
                                    "../" .
                                    $existingEquipment['image'];


                                if (
                                    file_exists($oldImage) &&
                                    is_file($oldImage)
                                ) {

                                    unlink($oldImage);
                                }
                            }
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Prices
                        |--------------------------------------------------------------------------
                        */

                        $purchasePriceValue =
                            $purchasePrice !== ''
                            ? $purchasePrice
                            : null;

                        $rentalPriceValue =
                            $rentalPrice !== ''
                            ? $rentalPrice
                            : null;


                        /*
                        |--------------------------------------------------------------------------
                        | Update Database
                        |--------------------------------------------------------------------------
                        */

                        $updateStmt = $pdo->prepare("
                            UPDATE equipment
                            SET
                                category_id = ?,
                                name = ?,
                                slug = ?,
                                image = ?,
                                short_description = ?,
                                description = ?,
                                technical_specifications = ?,
                                brands = ?,
                                purchase_price = ?,
                                rental_price = ?,
                                rental_period = ?,
                                status = ?
                            WHERE id = ?
                        ");


                        $updateStmt->execute([
                            $categoryId,
                            $name,
                            $slug,
                            $imagePath,
                            $shortDescription ?: null,
                            $description ?: null,
                            $technicalSpecifications ?: null,
                            $brands ?: null,
                            $purchasePriceValue,
                            $rentalPriceValue,
                            $rentalPeriod ?: null,
                            $status,
                            $equipmentId
                        ]);


                        $message =
                            "Equipment updated successfully.";

                        $messageType = "success";
                    }
                }
            }
        } catch (Exception $e) {

            $message =
                $e->getMessage();

            $messageType = "error";
        }
    }
}


/*
|--------------------------------------------------------------------------
| DELETE EQUIPMENT
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action']) &&
    $_POST['action'] === 'delete'
) {

    $equipmentId = isset($_POST['equipment_id'])
        ? (int) $_POST['equipment_id']
        : 0;


    if ($equipmentId <= 0) {

        $message =
            "Invalid equipment.";

        $messageType = "error";
    } else {

        try {

            /*
            |--------------------------------------------------------------------------
            | Get Equipment
            |--------------------------------------------------------------------------
            */

            $equipmentStmt = $pdo->prepare("
                SELECT
                    id,
                    image
                FROM equipment
                WHERE id = ?
                LIMIT 1
            ");

            $equipmentStmt->execute([
                $equipmentId
            ]);

            $equipment =
                $equipmentStmt->fetch(PDO::FETCH_ASSOC);


            if (!$equipment) {

                $message =
                    "Equipment not found.";

                $messageType = "error";
            } else {

                /*
                |--------------------------------------------------------------------------
                | Delete Database Record
                |--------------------------------------------------------------------------
                */

                $deleteStmt = $pdo->prepare("
                    DELETE FROM equipment
                    WHERE id = ?
                ");

                $deleteStmt->execute([
                    $equipmentId
                ]);


                /*
                |--------------------------------------------------------------------------
                | Delete Image
                |--------------------------------------------------------------------------
                */

                if (
                    !empty($equipment['image'])
                ) {

                    $imageFile =
                        "../" .
                        $equipment['image'];


                    if (
                        file_exists($imageFile) &&
                        is_file($imageFile)
                    ) {

                        unlink($imageFile);
                    }
                }


                $message =
                    "Equipment deleted successfully.";

                $messageType = "success";
            }
        } catch (PDOException $e) {

            if (
                $e->getCode() === '23000'
            ) {

                $message =
                    "This equipment cannot be deleted because it is already linked to another record.";
            } else {

                $message =
                    "Unable to delete equipment.";
            }

            $messageType = "error";
        }
    }
}


/*
|--------------------------------------------------------------------------
| Fetch Saved Equipment
|--------------------------------------------------------------------------
*/

try {

    $equipmentStmt = $pdo->query("
        SELECT
            e.id,
            e.category_id,
            e.name,
            e.image,
            e.short_description,
            e.description,
            e.technical_specifications,
            e.brands,
            e.purchase_price,
            e.rental_price,
            e.rental_period,
            e.status,
            c.name AS category_name
        FROM equipment e
        LEFT JOIN equipment_categories c
            ON e.category_id = c.id
        ORDER BY e.id DESC
    ");

    $equipmentList =
        $equipmentStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    $equipmentList = [];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Equipment Details | Jivhala Healthcare
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body
    class="bg-slate-100 text-slate-800
    antialiased min-h-screen flex flex-col">


    <?php include "header.php"; ?>


    <div class="flex flex-1 relative">


        <?php include "sidebar.php"; ?>


        <!-- =========================================================
         MAIN CONTENT
         ========================================================= -->

        <main
            class="flex-1 p-4 md:p-8
        overflow-x-hidden">

            <div class="max-w-7xl mx-auto">


                <!-- =================================================
                 PAGE HEADER
                 ================================================= -->

                <div class="mb-6">

                    <h1
                        class="text-2xl md:text-3xl
                    font-black text-slate-900">
                        Equipment Details
                    </h1>

                    <p
                        class="mt-1 text-sm text-slate-500">
                        Add and manage detailed medical equipment information.
                    </p>

                </div>


                <!-- =================================================
                 MESSAGE
                 ================================================= -->

                <?php if ($message !== ''): ?>

                    <div
                        class="mb-6 rounded-xl border
                    px-4 py-3 text-sm font-medium
                    <?= $messageType === 'success'
                        ? 'bg-emerald-50 border-emerald-200 text-emerald-700'
                        : 'bg-red-50 border-red-200 text-red-700'; ?>">

                        <?= htmlspecialchars(
                            $message
                        ); ?>

                    </div>

                <?php endif; ?>


                <!-- =================================================
                 ADD EQUIPMENT
                 ================================================= -->

                <div
                    class="bg-white rounded-2xl
                border border-slate-200
                shadow-sm mb-8">

                    <div
                        class="px-6 py-5
                    border-b border-slate-200">

                        <h2
                            class="text-lg font-bold
                        text-slate-900">
                            Add Equipment
                        </h2>

                        <p
                            class="text-sm
                        text-slate-500 mt-1">
                            Select a category and enter the equipment details.
                        </p>

                    </div>


                    <form
                        method="POST"
                        enctype="multipart/form-data"
                        class="p-6">

                        <input
                            type="hidden"
                            name="action"
                            value="save">


                        <div
                            class="grid grid-cols-1
                        md:grid-cols-2 gap-5">


                            <!-- CATEGORY -->

                            <div>

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Equipment Category
                                    <span class="text-red-500">*</span>
                                </label>


                                <select
                                    name="category_id"
                                    required
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                bg-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500">

                                    <option value="">
                                        Select Equipment Category
                                    </option>


                                    <?php foreach (
                                        $categories
                                        as $category
                                    ): ?>

                                        <option
                                            value="<?= (int) $category['id']; ?>"
                                            <?= (
                                                isset(
                                                    $_POST['category_id']
                                                ) &&
                                                $_POST['category_id'] ==
                                                $category['id']
                                            )
                                                ? 'selected'
                                                : ''; ?>>

                                            <?= htmlspecialchars(
                                                $category['name']
                                            ); ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>


                            <!-- NAME -->

                            <div>

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Equipment Name
                                    <span class="text-red-500">*</span>
                                </label>


                                <input
                                    type="text"
                                    name="name"
                                    required
                                    value="<?= htmlspecialchars(
                                                $_POST['name'] ?? ''
                                            ); ?>"
                                    placeholder="e.g. Manual Wheelchair"
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500">

                            </div>


                            <!-- IMAGE -->

                            <div class="md:col-span-2">

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Equipment Image
                                </label>


                                <input
                                    type="file"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                bg-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500">


                                <p
                                    class="text-xs
                                text-slate-400 mt-2">
                                    JPG, JPEG, PNG or WEBP.
                                    Maximum size: 5 MB.
                                </p>

                            </div>


                            <!-- SHORT DESCRIPTION -->

                            <div class="md:col-span-2">

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Short Description
                                </label>


                                <textarea
                                    name="short_description"
                                    rows="3"
                                    placeholder="Enter a short description..."
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                resize-none
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500"><?= htmlspecialchars(
                                                            $_POST['short_description'] ?? ''
                                                        ); ?></textarea>

                            </div>


                            <!-- DESCRIPTION -->

                            <div class="md:col-span-2">

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Description
                                </label>


                                <textarea
                                    name="description"
                                    rows="5"
                                    placeholder="Enter detailed equipment description..."
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                resize-none
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500"><?= htmlspecialchars(
                                                            $_POST['description'] ?? ''
                                                        ); ?></textarea>

                            </div>


                            <!-- TECHNICAL SPECIFICATIONS -->

                            <div class="md:col-span-2">

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Technical Specifications
                                </label>


                                <textarea
                                    name="technical_specifications"
                                    rows="6"
                                    placeholder="Enter technical specifications..."
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                resize-none
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500"><?= htmlspecialchars(
                                                            $_POST['technical_specifications'] ?? ''
                                                        ); ?></textarea>

                            </div>


                            <!-- BRANDS -->

                            <div>

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Brands
                                </label>


                                <input
                                    type="text"
                                    name="brands"
                                    value="<?= htmlspecialchars(
                                                $_POST['brands'] ?? ''
                                            ); ?>"
                                    placeholder="e.g. Philips, ResMed"
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500">

                            </div>


                            <!-- RENTAL PERIOD -->

                            <div>

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Rental Period
                                </label>


                                <input
                                    type="text"
                                    name="rental_period"
                                    value="<?= htmlspecialchars(
                                                $_POST['rental_period'] ?? ''
                                            ); ?>"
                                    placeholder="e.g. Per Day / Per Month"
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500">

                            </div>


                            <!-- PURCHASE PRICE -->

                            <div>

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Purchase Price
                                </label>


                                <input
                                    type="number"
                                    name="purchase_price"
                                    step="0.01"
                                    min="0"
                                    value="<?= htmlspecialchars(
                                                $_POST['purchase_price'] ?? ''
                                            ); ?>"
                                    placeholder="e.g. 25000"
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500">

                            </div>


                            <!-- RENTAL PRICE -->

                            <div>

                                <label
                                    class="block text-sm
                                font-semibold
                                text-slate-700 mb-2">
                                    Rental Price
                                </label>


                                <input
                                    type="number"
                                    name="rental_price"
                                    step="0.01"
                                    min="0"
                                    value="<?= htmlspecialchars(
                                                $_POST['rental_price'] ?? ''
                                            ); ?>"
                                    placeholder="e.g. 500"
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500">

                            </div>

                        </div>


                        <div
                            class="mt-6 flex justify-end">

                            <button
                                type="submit"
                                class="px-6 py-3
                            rounded-xl bg-teal-600
                            text-white text-sm font-bold
                            hover:bg-teal-700
                            transition shadow-sm">
                                Save Equipment
                            </button>

                        </div>

                    </form>

                </div>


                <!-- =========================================================
                 SAVED EQUIPMENT
                 ========================================================= -->

                <div
                    class="bg-white rounded-2xl
                border border-slate-200
                shadow-sm overflow-hidden">

                    <div
                        class="px-6 py-5
    border-b border-slate-200
    flex flex-col md:flex-row
    md:items-center md:justify-between
    gap-4">

                        <div>

                            <h2
                                class="text-lg font-bold
            text-slate-900">
                                Saved Equipment
                            </h2>

                            <p
                                class="text-sm text-slate-500 mt-1">
                                Equipment currently added to the system.
                            </p>

                        </div>


                        <!-- Search -->

                        <div class="relative w-full md:w-80">

                            <div
                                class="absolute inset-y-0 left-0
            pl-3 flex items-center
            pointer-events-none">

                                <svg
                                    class="w-5 h-5 text-slate-400"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />

                                </svg>

                            </div>


                            <input
                                type="text"
                                id="equipmentSearch"
                                placeholder="Search by name or category..."
                                class="w-full rounded-xl
            border border-slate-300
            pl-10 pr-4 py-2.5
            text-sm
            focus:outline-none
            focus:ring-2
            focus:ring-teal-500
            focus:border-teal-500">

                        </div>

                    </div>


                    <?php if (
                        empty($equipmentList)
                    ): ?>

                        <div
                            class="p-10 text-center">

                            <p
                                class="text-sm
                            text-slate-500">
                                No equipment added yet.
                            </p>

                        </div>

                    <?php else: ?>


                        <div
                            class="overflow-x-auto">

                            <table
                                class="w-full text-sm">

                                <thead
                                    class="bg-slate-50
                                border-b
                                border-slate-200">

                                    <tr>

                                        <th
                                            class="px-6 py-4
                                        text-left font-bold
                                        text-slate-600">
                                            Image
                                        </th>

                                        <th
                                            class="px-6 py-4
                                        text-left font-bold
                                        text-slate-600">
                                            Category
                                        </th>

                                        <th
                                            class="px-6 py-4
                                        text-left font-bold
                                        text-slate-600">
                                            Equipment Name
                                        </th>

                                        <th
                                            class="px-6 py-4
                                        text-left font-bold
                                        text-slate-600">
                                            Purchase Price
                                        </th>

                                        <th
                                            class="px-6 py-4
                                        text-left font-bold
                                        text-slate-600">
                                            Rental Price
                                        </th>

                                        <th
                                            class="px-6 py-4
                                        text-left font-bold
                                        text-slate-600">
                                            Status
                                        </th>

                                        <th
                                            class="px-6 py-4
                                        text-center font-bold
                                        text-slate-600">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody
                                    id="equipmentTableBody"
                                    class="divide-y
    divide-slate-100">


                                    <?php foreach (
                                        $equipmentList
                                        as $equipment
                                    ): ?>

                                        <tr
                                            class="hover:bg-slate-50
                                        transition">

                                            <!-- IMAGE -->

                                            <td
                                                class="px-6 py-4">

                                                <?php if (
                                                    !empty($equipment['image'])
                                                ): ?>

                                                    <img
                                                        src="../<?= htmlspecialchars(
                                                                    $equipment['image']
                                                                ); ?>"
                                                        alt="<?= htmlspecialchars(
                                                                    $equipment['name']
                                                                ); ?>"
                                                        class="w-16 h-16
                                                    rounded-xl
                                                    object-cover
                                                    border border-slate-200">

                                                <?php else: ?>

                                                    <div
                                                        class="w-16 h-16
                                                    rounded-xl
                                                    bg-slate-100
                                                    flex items-center
                                                    justify-center
                                                    text-xs
                                                    text-slate-400">
                                                        No Image
                                                    </div>

                                                <?php endif; ?>

                                            </td>


                                            <!-- CATEGORY -->

                                            <td
                                                class="px-6 py-4
                                            text-slate-600">

                                                <?= htmlspecialchars(
                                                    $equipment['category_name']
                                                        ?? 'Not Assigned'
                                                ); ?>

                                            </td>


                                            <!-- NAME -->

                                            <td
                                                class="px-6 py-4">

                                                <span
                                                    class="font-semibold
                                                text-slate-800">

                                                    <?= htmlspecialchars(
                                                        $equipment['name']
                                                    ); ?>

                                                </span>

                                            </td>


                                            <!-- PURCHASE PRICE -->

                                            <td
                                                class="px-6 py-4
                                            text-slate-600">

                                                <?php if (
                                                    $equipment['purchase_price'] !== null
                                                ): ?>

                                                    ₹<?= formatIndianCurrency(
                                                            $equipment['purchase_price']
                                                        ); ?>

                                                <?php else: ?>

                                                    —

                                                <?php endif; ?>

                                            </td>


                                            <!-- RENTAL PRICE -->

                                            <td
                                                class="px-6 py-4
                                            text-slate-600">

                                                <?php if (
                                                    $equipment['rental_price'] !== null
                                                ): ?>

                                                    ₹<?= formatIndianCurrency(
                                                            $equipment['rental_price']
                                                        ); ?>

                                                    <?php if (
                                                        !empty($equipment['rental_period'])
                                                    ): ?>

                                                        <span
                                                            class="text-xs
                                                        text-slate-400">
                                                            /
                                                            <?= htmlspecialchars(
                                                                $equipment['rental_period']
                                                            ); ?>
                                                        </span>

                                                    <?php endif; ?>

                                                <?php else: ?>

                                                    —

                                                <?php endif; ?>

                                            </td>


                                            <!-- STATUS -->

                                            <td
                                                class="px-6 py-4">

                                                <?php if (
                                                    $equipment['status']
                                                ): ?>

                                                    <span
                                                        class="inline-flex
                                                    items-center px-2.5
                                                    py-1 rounded-full
                                                    text-xs font-bold
                                                    bg-emerald-100
                                                    text-emerald-700">
                                                        Active
                                                    </span>

                                                <?php else: ?>

                                                    <span
                                                        class="inline-flex
                                                    items-center px-2.5
                                                    py-1 rounded-full
                                                    text-xs font-bold
                                                    bg-red-100
                                                    text-red-700">
                                                        Inactive
                                                    </span>

                                                <?php endif; ?>

                                            </td>


                                            <!-- ACTION -->

                                            <td
                                                class="px-6 py-4">

                                                <div
                                                    class="flex
                                                items-center
                                                justify-center
                                                gap-2">

                                                    <!-- EDIT -->

                                                    <button
                                                        type="button"
                                                        onclick='openEditModal(
                                                        <?= (int) $equipment["id"]; ?>,
                                                        <?= json_encode(
                                                            (int) $equipment["category_id"]
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["name"]
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["image"] ?? ""
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["short_description"] ?? ""
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["description"] ?? ""
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["technical_specifications"] ?? ""
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["brands"] ?? ""
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["purchase_price"] ?? ""
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["rental_price"] ?? ""
                                                        ); ?>,
                                                        <?= json_encode(
                                                            $equipment["rental_period"] ?? ""
                                                        ); ?>,
                                                        <?= json_encode(
                                                            (int) $equipment["status"]
                                                        ); ?>
                                                    )'
                                                        class="px-4 py-2
                                                    rounded-lg
                                                    bg-slate-100
                                                    text-slate-700
                                                    text-xs font-bold
                                                    hover:bg-slate-200
                                                    transition">
                                                        Edit
                                                    </button>


                                                    <!-- DELETE -->

                                                    <form
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this equipment? This action cannot be undone.');">

                                                        <input
                                                            type="hidden"
                                                            name="action"
                                                            value="delete">

                                                        <input
                                                            type="hidden"
                                                            name="equipment_id"
                                                            value="<?= (int) $equipment['id']; ?>">


                                                        <button
                                                            type="submit"
                                                            class="px-4 py-2
                                                        rounded-lg
                                                        bg-red-50
                                                        text-red-600
                                                        text-xs font-bold
                                                        hover:bg-red-100
                                                        transition">
                                                            Delete
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>


                    <?php endif; ?>

                </div>


            </div>

        </main>

    </div>


    <?php include "footer.php"; ?>


    <!-- =========================================================
     EDIT EQUIPMENT MODAL
     ========================================================= -->

    <div
        id="editModal"
        class="fixed inset-0 z-50 hidden
    items-center justify-center p-4">


        <!-- Overlay -->

        <div
            class="absolute inset-0
        bg-slate-900/60"
            onclick="closeEditModal()"></div>


        <!-- Modal -->

        <div
            class="relative w-full max-w-4xl
        max-h-[90vh] overflow-y-auto
        bg-white rounded-2xl
        shadow-2xl border border-slate-200">


            <!-- Header -->

            <div
                class="sticky top-0 z-10
            bg-white px-6 py-5
            border-b border-slate-200
            flex items-center
            justify-between">

                <div>

                    <h2
                        class="text-lg font-bold
                    text-slate-900">
                        Edit Equipment
                    </h2>

                    <p
                        class="text-sm text-slate-500 mt-1">
                        Update equipment information.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="w-9 h-9 rounded-lg
                bg-slate-100 text-slate-500
                hover:bg-slate-200
                transition flex items-center
                justify-center">

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>


            <!-- Form -->

            <form
                method="POST"
                enctype="multipart/form-data"
                class="p-6">

                <input
                    type="hidden"
                    name="action"
                    value="update">

                <input
                    type="hidden"
                    name="equipment_id"
                    id="editEquipmentId">


                <div
                    class="grid grid-cols-1
                md:grid-cols-2 gap-5">


                    <!-- CATEGORY -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Equipment Category
                            <span class="text-red-500">*</span>
                        </label>


                        <select
                            name="category_id"
                            id="editCategoryId"
                            required
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        bg-white
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500">

                            <option value="">
                                Select Equipment Category
                            </option>


                            <?php foreach (
                                $categories
                                as $category
                            ): ?>

                                <option
                                    value="<?= (int) $category['id']; ?>">
                                    <?= htmlspecialchars(
                                        $category['name']
                                    ); ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- NAME -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Equipment Name
                            <span class="text-red-500">*</span>
                        </label>


                        <input
                            type="text"
                            name="name"
                            id="editEquipmentName"
                            required
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500">

                    </div>


                    <!-- CURRENT IMAGE -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Current Image
                        </label>


                        <div
                            id="currentImageContainer"></div>

                    </div>


                    <!-- NEW IMAGE -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Change Image
                        </label>


                        <input
                            type="file"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        bg-white
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500">


                        <p
                            class="text-xs
                        text-slate-400 mt-2">
                            Leave empty to keep current image.
                        </p>

                    </div>


                    <!-- SHORT DESCRIPTION -->

                    <div class="md:col-span-2">

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Short Description
                        </label>


                        <textarea
                            name="short_description"
                            id="editShortDescription"
                            rows="3"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        resize-none
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500"></textarea>

                    </div>


                    <!-- DESCRIPTION -->

                    <div class="md:col-span-2">

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Description
                        </label>


                        <textarea
                            name="description"
                            id="editDescription"
                            rows="5"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        resize-none
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500"></textarea>

                    </div>


                    <!-- TECHNICAL SPECIFICATIONS -->

                    <div class="md:col-span-2">

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Technical Specifications
                        </label>


                        <textarea
                            name="technical_specifications"
                            id="editTechnicalSpecifications"
                            rows="6"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        resize-none
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500"></textarea>

                    </div>


                    <!-- BRANDS -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Brands
                        </label>


                        <input
                            type="text"
                            name="brands"
                            id="editBrands"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500">

                    </div>


                    <!-- RENTAL PERIOD -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Rental Period
                        </label>


                        <input
                            type="text"
                            name="rental_period"
                            id="editRentalPeriod"
                            placeholder="e.g. Per Day / Per Month"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500">

                    </div>


                    <!-- PURCHASE PRICE -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Purchase Price
                        </label>


                        <input
                            type="number"
                            name="purchase_price"
                            id="editPurchasePrice"
                            step="0.01"
                            min="0"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500">

                    </div>


                    <!-- RENTAL PRICE -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Rental Price
                        </label>


                        <input
                            type="number"
                            name="rental_price"
                            id="editRentalPrice"
                            step="0.01"
                            min="0"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500">

                    </div>


                    <!-- STATUS -->

                    <div>

                        <label
                            class="block text-sm
                        font-semibold
                        text-slate-700 mb-2">
                            Status
                        </label>


                        <select
                            name="status"
                            id="editStatus"
                            class="w-full rounded-xl
                        border border-slate-300
                        px-4 py-3 text-sm
                        bg-white
                        focus:outline-none
                        focus:ring-2
                        focus:ring-teal-500
                        focus:border-teal-500">

                            <option value="1">
                                Active
                            </option>

                            <option value="0">
                                Inactive
                            </option>

                        </select>

                    </div>


                </div>


                <!-- BUTTONS -->

                <div
                    class="mt-6 pt-5
                border-t border-slate-200
                flex justify-end gap-3">

                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="px-5 py-2.5
                    rounded-xl bg-slate-100
                    text-slate-700
                    text-sm font-bold
                    hover:bg-slate-200
                    transition">
                        Cancel
                    </button>


                    <button
                        type="submit"
                        class="px-6 py-2.5
                    rounded-xl bg-teal-600
                    text-white text-sm
                    font-bold
                    hover:bg-teal-700
                    transition">
                        Update Equipment
                    </button>

                </div>

            </form>

        </div>

    </div>


    <script>
        /*
|--------------------------------------------------------------------------
| Open Edit Modal
|--------------------------------------------------------------------------
*/

        function openEditModal(
            id,
            categoryId,
            name,
            image,
            shortDescription,
            description,
            technicalSpecifications,
            brands,
            purchasePrice,
            rentalPrice,
            rentalPeriod,
            status
        ) {

            document.getElementById(
                'editEquipmentId'
            ).value = id;


            document.getElementById(
                'editCategoryId'
            ).value = categoryId;


            document.getElementById(
                'editEquipmentName'
            ).value = name;


            document.getElementById(
                'editShortDescription'
            ).value = shortDescription;


            document.getElementById(
                'editDescription'
            ).value = description;


            document.getElementById(
                'editTechnicalSpecifications'
            ).value = technicalSpecifications;


            document.getElementById(
                'editBrands'
            ).value = brands;


            document.getElementById(
                'editPurchasePrice'
            ).value = purchasePrice;


            document.getElementById(
                'editRentalPrice'
            ).value = rentalPrice;


            document.getElementById(
                'editRentalPeriod'
            ).value = rentalPeriod;


            document.getElementById(
                'editStatus'
            ).value = status;


            /*
            |--------------------------------------------------------------------------
            | Current Image
            |--------------------------------------------------------------------------
            */

            const imageContainer =
                document.getElementById(
                    'currentImageContainer'
                );


            imageContainer.innerHTML = '';


            if (image) {

                const imageElement =
                    document.createElement('img');


                imageElement.src =
                    '../' + image;


                imageElement.alt =
                    name;


                imageElement.className =
                    'w-24 h-24 rounded-xl object-cover border border-slate-200';


                imageContainer.appendChild(
                    imageElement
                );

            } else {

                imageContainer.innerHTML = `
            <div
                class="w-24 h-24 rounded-xl
                bg-slate-100
                flex items-center
                justify-center
                text-xs text-slate-400"
            >
                No Image
            </div>
        `;
            }


            /*
            |--------------------------------------------------------------------------
            | Show Modal
            |--------------------------------------------------------------------------
            */

            const modal =
                document.getElementById(
                    'editModal'
                );


            modal.classList.remove(
                'hidden'
            );


            modal.classList.add(
                'flex'
            );


            document.body.classList.add(
                'overflow-hidden'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Close Edit Modal
        |--------------------------------------------------------------------------
        */

        function closeEditModal() {

            const modal =
                document.getElementById(
                    'editModal'
                );


            modal.classList.add(
                'hidden'
            );


            modal.classList.remove(
                'flex'
            );


            document.body.classList.remove(
                'overflow-hidden'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ESC Key
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function(event) {

                if (
                    event.key === 'Escape'
                ) {

                    closeEditModal();

                }

            }
        );

        /*
|--------------------------------------------------------------------------
| Equipment Search
|--------------------------------------------------------------------------
*/

        const equipmentSearch =
            document.getElementById('equipmentSearch');

        const equipmentTableBody =
            document.getElementById('equipmentTableBody');


        if (
            equipmentSearch &&
            equipmentTableBody
        ) {

            equipmentSearch.addEventListener(
                'input',
                function() {

                    const searchValue =
                        this.value
                        .trim()
                        .toLowerCase();


                    const rows =
                        equipmentTableBody.querySelectorAll('tr');


                    rows.forEach(function(row) {

                        const rowText =
                            row.textContent
                            .toLowerCase();


                        if (
                            rowText.includes(searchValue)
                        ) {

                            row.style.display = '';

                        } else {

                            row.style.display = 'none';

                        }

                    });

                }
            );

        }
    </script>


</body>

</html>