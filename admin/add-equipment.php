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
| Add Equipment Category
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action']) &&
    $_POST['action'] === 'add'
) {

    $name = trim($_POST['name'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | Validate Name
    |--------------------------------------------------------------------------
    */

    if ($name === '') {

        $message = "Equipment category name is required.";
        $messageType = "error";
    } elseif (
        !isset($_FILES['image']) ||
        $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE
    ) {

        $message = "Equipment category image is required.";
        $messageType = "error";
    } else {

        try {

            /*
            |--------------------------------------------------------------------------
            | Check Duplicate Category Name
            |--------------------------------------------------------------------------
            */

            $checkStmt = $pdo->prepare("
                SELECT id
                FROM equipment_categories
                WHERE name = ?
                LIMIT 1
            ");

            $checkStmt->execute([$name]);


            if ($checkStmt->fetch()) {

                $message =
                    "Equipment category with this name already exists.";

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


                /*
                |--------------------------------------------------------------------------
                | Make Slug Unique
                |--------------------------------------------------------------------------
                */

                while (true) {

                    $slugCheckStmt = $pdo->prepare("
                        SELECT id
                        FROM equipment_categories
                        WHERE slug = ?
                        LIMIT 1
                    ");

                    $slugCheckStmt->execute([$slug]);


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

                if (
                    $_FILES['image']['error'] !==
                    UPLOAD_ERR_OK
                ) {

                    $message =
                        "There was an error uploading the image.";

                    $messageType = "error";
                } else {

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


                    /*
                    |--------------------------------------------------------------------------
                    | Validate Image
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !in_array(
                            $extension,
                            $allowedExtensions,
                            true
                        )
                    ) {

                        $message =
                            "Only JPG, JPEG, PNG and WEBP images are allowed.";

                        $messageType = "error";
                    } elseif (
                        $fileSize > 5 * 1024 * 1024
                    ) {

                        $message =
                            "Image size must be less than 5 MB.";

                        $messageType = "error";
                    } else {


                        /*
                        |--------------------------------------------------------------------------
                        | Upload Directory
                        |--------------------------------------------------------------------------
                        */

                        $uploadDirectory =
                            "../assets/images/equipment/categories/";


                        if (!is_dir($uploadDirectory)) {

                            mkdir(
                                $uploadDirectory,
                                0755,
                                true
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Generate File Name
                        |--------------------------------------------------------------------------
                        */

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


                        /*
                        |--------------------------------------------------------------------------
                        | Move Image
                        |--------------------------------------------------------------------------
                        */

                        if (
                            move_uploaded_file(
                                $tmpName,
                                $destination
                            )
                        ) {

                            $imagePath =
                                "assets/images/equipment/categories/" .
                                $newFileName;


                            /*
                            |--------------------------------------------------------------------------
                            | Insert Category
                            |--------------------------------------------------------------------------
                            */

                            $stmt = $pdo->prepare("
                                INSERT INTO equipment_categories (
                                    name,
                                    slug,
                                    image,
                                    status
                                )
                                VALUES (
                                    ?,
                                    ?,
                                    ?,
                                    1
                                )
                            ");


                            $stmt->execute([
                                $name,
                                $slug,
                                $imagePath
                            ]);


                            $message =
                                "Equipment category added successfully.";

                            $messageType = "success";


                            $_POST = [];
                        } else {

                            $message =
                                "Unable to save the uploaded image.";

                            $messageType = "error";
                        }
                    }
                }
            }
        } catch (PDOException $e) {

            $message =
                "Something went wrong while adding the equipment category.";

            $messageType = "error";
        }
    }
}


/*
|--------------------------------------------------------------------------
| Update Equipment Category
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action']) &&
    $_POST['action'] === 'update'
) {

    $categoryId = isset($_POST['category_id'])
        ? (int) $_POST['category_id']
        : 0;

    $name = trim($_POST['name'] ?? '');


    if ($categoryId <= 0) {

        $message = "Invalid equipment category.";
        $messageType = "error";
    } elseif ($name === '') {

        $message =
            "Equipment category name is required.";

        $messageType = "error";
    } else {

        try {

            /*
            |--------------------------------------------------------------------------
            | Get Existing Category
            |--------------------------------------------------------------------------
            */

            $categoryStmt = $pdo->prepare("
                SELECT
                    id,
                    name,
                    slug,
                    image
                FROM equipment_categories
                WHERE id = ?
                LIMIT 1
            ");

            $categoryStmt->execute([
                $categoryId
            ]);

            $existingCategory =
                $categoryStmt->fetch();


            if (!$existingCategory) {

                $message =
                    "Equipment category not found.";

                $messageType = "error";
            } else {

                /*
                |--------------------------------------------------------------------------
                | Check Duplicate Name
                |--------------------------------------------------------------------------
                */

                $checkStmt = $pdo->prepare("
                    SELECT id
                    FROM equipment_categories
                    WHERE name = ?
                      AND id != ?
                    LIMIT 1
                ");

                $checkStmt->execute([
                    $name,
                    $categoryId
                ]);


                if ($checkStmt->fetch()) {

                    $message =
                        "Another equipment category with this name already exists.";

                    $messageType = "error";
                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Generate New Slug
                    |--------------------------------------------------------------------------
                    */

                    $slug =
                        generateSlug($name);

                    $originalSlug =
                        $slug;

                    $counter = 1;


                    while (true) {

                        $slugCheckStmt = $pdo->prepare("
                            SELECT id
                            FROM equipment_categories
                            WHERE slug = ?
                              AND id != ?
                            LIMIT 1
                        ");

                        $slugCheckStmt->execute([
                            $slug,
                            $categoryId
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
                        $existingCategory['image'];


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

                            $message =
                                "There was an error uploading the new image.";

                            $messageType = "error";
                        } else {

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

                                $message =
                                    "Only JPG, JPEG, PNG and WEBP images are allowed.";

                                $messageType = "error";
                            } elseif (
                                $fileSize >
                                5 * 1024 * 1024
                            ) {

                                $message =
                                    "Image size must be less than 5 MB.";

                                $messageType = "error";
                            } else {

                                $uploadDirectory =
                                    "../assets/images/equipment/categories/";


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
                                    move_uploaded_file(
                                        $tmpName,
                                        $destination
                                    )
                                ) {

                                    $imagePath =
                                        "assets/images/equipment/categories/" .
                                        $newFileName;


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Delete Old Image
                                    |--------------------------------------------------------------------------
                                    */

                                    if (
                                        !empty($existingCategory['image'])
                                    ) {

                                        $oldImage =
                                            "../" .
                                            $existingCategory['image'];


                                        if (
                                            file_exists(
                                                $oldImage
                                            ) &&
                                            is_file(
                                                $oldImage
                                            )
                                        ) {

                                            unlink(
                                                $oldImage
                                            );
                                        }
                                    }
                                } else {

                                    $message =
                                        "Unable to save the new image.";

                                    $messageType = "error";
                                }
                            }
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Update Database
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $messageType !== 'error'
                    ) {

                        $updateStmt = $pdo->prepare("
                            UPDATE equipment_categories
                            SET
                                name = ?,
                                slug = ?,
                                image = ?
                            WHERE id = ?
                        ");


                        $updateStmt->execute([
                            $name,
                            $slug,
                            $imagePath,
                            $categoryId
                        ]);


                        $message =
                            "Equipment category updated successfully.";

                        $messageType = "success";
                    }
                }
            }
        } catch (PDOException $e) {

            $message =
                "Something went wrong while updating the equipment category.";

            $messageType = "error";
        }
    }
}


/*
|--------------------------------------------------------------------------
| Delete Equipment Category
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action']) &&
    $_POST['action'] === 'delete'
) {

    $deleteId = isset($_POST['category_id'])
        ? (int) $_POST['category_id']
        : 0;


    if ($deleteId <= 0) {

        $message =
            "Invalid equipment category.";

        $messageType = "error";
    } else {

        try {

            /*
            |--------------------------------------------------------------------------
            | Get Category Image
            |--------------------------------------------------------------------------
            */

            $imageStmt = $pdo->prepare("
                SELECT image
                FROM equipment_categories
                WHERE id = ?
                LIMIT 1
            ");

            $imageStmt->execute([
                $deleteId
            ]);

            $category =
                $imageStmt->fetch();


            if ($category) {

                /*
                |--------------------------------------------------------------------------
                | Delete Category
                |--------------------------------------------------------------------------
                */

                $deleteStmt = $pdo->prepare("
                    DELETE FROM equipment_categories
                    WHERE id = ?
                ");

                $deleteStmt->execute([
                    $deleteId
                ]);


                /*
                |--------------------------------------------------------------------------
                | Delete Image
                |--------------------------------------------------------------------------
                */

                if (
                    !empty($category['image'])
                ) {

                    $imageFile =
                        "../" .
                        $category['image'];


                    if (
                        file_exists(
                            $imageFile
                        ) &&
                        is_file(
                            $imageFile
                        )
                    ) {

                        unlink(
                            $imageFile
                        );
                    }
                }


                $message =
                    "Equipment category deleted successfully.";

                $messageType = "success";
            } else {

                $message =
                    "Equipment category not found.";

                $messageType = "error";
            }
        } catch (PDOException $e) {

            /*
            |--------------------------------------------------------------------------
            | Foreign Key Protection
            |--------------------------------------------------------------------------
            */

            if (
                $e->getCode() === '23000'
            ) {

                $message =
                    "This category cannot be deleted because equipment is already assigned to it.";
            } else {

                $message =
                    "Unable to delete equipment category.";
            }

            $messageType = "error";
        }
    }
}


/*
|--------------------------------------------------------------------------
| Fetch Equipment Categories
|--------------------------------------------------------------------------
*/

$categoryStmt = $pdo->query("
    SELECT
        id,
        name,
        image,
        status,
        created_at
    FROM equipment_categories
    ORDER BY id DESC
");

$categoryList =
    $categoryStmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Manage Equipment Categories | Jivhala Healthcare
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body
    class="bg-slate-100 text-slate-800
    antialiased min-h-screen flex flex-col">


    <?php include "header.php"; ?>


    <div class="flex flex-1 relative">


        <?php include "sidebar.php"; ?>


        <!-- Main Content -->

        <main
            class="flex-1 p-4 md:p-8
        overflow-x-hidden">

            <div class="max-w-6xl mx-auto">


                <!-- =================================================
                 PAGE HEADER
                 ================================================= -->

                <div class="mb-6">

                    <h1
                        class="text-2xl md:text-3xl
                    font-black text-slate-900">
                        Equipment Categories
                    </h1>

                    <p
                        class="mt-1 text-sm
                    text-slate-500">
                        Add and manage medical equipment categories.
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
                 ADD CATEGORY
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
                            Add New Equipment Category
                        </h2>

                        <p
                            class="text-sm
                        text-slate-500 mt-1">
                            Add a category such as Wheelchairs, Hospital Beds, etc.
                        </p>

                    </div>


                    <form
                        method="POST"
                        enctype="multipart/form-data"
                        class="p-6">

                        <input
                            type="hidden"
                            name="action"
                            value="add">


                        <div
                            class="grid grid-cols-1
                        md:grid-cols-2 gap-5">


                            <!-- Category Name -->

                            <div>

                                <label
                                    class="block text-sm
                                font-semibold text-slate-700 mb-2">
                                    Category Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="<?= htmlspecialchars(
                                                $_POST['name'] ?? ''
                                            ); ?>"
                                    required
                                    placeholder="e.g. Wheelchairs"
                                    class="w-full rounded-xl
                                border border-slate-300
                                px-4 py-3 text-sm
                                focus:outline-none
                                focus:ring-2
                                focus:ring-teal-500
                                focus:border-teal-500">

                            </div>


                            <!-- Image -->

                            <div>

                                <label
                                    class="block text-sm
                                font-semibold text-slate-700 mb-2">
                                    Category Image
                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    required
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

                        </div>


                        <div
                            class="mt-6 flex justify-end">

                            <button
                                type="submit"
                                class="px-6 py-3
                            rounded-xl bg-teal-600
                            text-white text-sm
                            font-bold
                            hover:bg-teal-700
                            transition shadow-sm">
                                Add Category
                            </button>

                        </div>

                    </form>

                </div>


                <!-- =================================================
                 SAVED CATEGORIES
                 ================================================= -->

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
                                Saved Equipment Categories
                            </h2>

                            <p
                                class="text-sm
            text-slate-500 mt-1">
                                Categories currently available in the system.
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
                                id="categorySearch"
                                placeholder="Search category..."
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


                    <?php if (empty($categoryList)): ?>

                        <div
                            class="p-10 text-center">

                            <p
                                class="text-sm
                            text-slate-500">
                                No equipment categories added yet.
                            </p>

                        </div>

                    <?php else: ?>


                        <div class="overflow-x-auto">

                            <table class="w-full text-sm">


                                <thead
                                    class="bg-slate-50
                                border-b border-slate-200">

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
                                            Category Name
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
                                    id="categoryTableBody"
                                    class="divide-y
    divide-slate-100">


                                    <?php foreach (
                                        $categoryList
                                        as $category
                                    ): ?>

                                        <tr
                                            class="hover:bg-slate-50
                                        transition">


                                            <!-- Image -->

                                            <td
                                                class="px-6 py-4">

                                                <?php if (
                                                    !empty($category['image'])
                                                ): ?>

                                                    <img
                                                        src="../<?= htmlspecialchars(
                                                                    $category['image']
                                                                ); ?>"
                                                        alt="<?= htmlspecialchars(
                                                                    $category['name']
                                                                ); ?>"
                                                        class="w-16 h-16
                                                    rounded-xl
                                                    object-cover
                                                    border
                                                    border-slate-200">

                                                <?php else: ?>

                                                    <div
                                                        class="w-16 h-16
                                                    rounded-xl
                                                    bg-slate-100
                                                    flex items-center
                                                    justify-center
                                                    text-slate-400">
                                                        No Image
                                                    </div>

                                                <?php endif; ?>

                                            </td>


                                            <!-- Name -->

                                            <td
                                                class="px-6 py-4">

                                                <span
                                                    class="font-semibold
                                                text-slate-800">

                                                    <?= htmlspecialchars(
                                                        $category['name']
                                                    ); ?>

                                                </span>

                                            </td>


                                            <!-- Status -->

                                            <td
                                                class="px-6 py-4">

                                                <?php if (
                                                    $category['status']
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


                                            <!-- Actions -->

                                            <td
                                                class="px-6 py-4">

                                                <div
                                                    class="flex
                                                items-center
                                                justify-center
                                                gap-2">


                                                    <!-- Edit -->

                                                    <button
                                                        type="button"
                                                        onclick="openEditModal(
                                                        <?= (int) $category['id']; ?>,
                                                        <?= htmlspecialchars(
                                                            json_encode(
                                                                $category['name']
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>,
                                                        <?= htmlspecialchars(
                                                            json_encode(
                                                                $category['image'] ?? ''
                                                            ),
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>
                                                    )"
                                                        class="px-4 py-2
                                                    rounded-lg
                                                    bg-slate-100
                                                    text-slate-700
                                                    text-xs font-bold
                                                    hover:bg-slate-200
                                                    transition">
                                                        Edit
                                                    </button>


                                                    <!-- Delete -->

                                                    <form
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this equipment category?');">

                                                        <input
                                                            type="hidden"
                                                            name="action"
                                                            value="delete">

                                                        <input
                                                            type="hidden"
                                                            name="category_id"
                                                            value="<?= (int) $category['id']; ?>">

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
     EDIT CATEGORY MODAL
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
            class="relative w-full max-w-lg
        bg-white rounded-2xl shadow-2xl
        border border-slate-200
        overflow-hidden">


            <!-- Header -->

            <div
                class="px-6 py-5
            border-b border-slate-200
            flex items-center
            justify-between">

                <div>

                    <h2
                        class="text-lg font-bold
                    text-slate-900">
                        Edit Equipment Category
                    </h2>

                    <p
                        class="text-sm
                    text-slate-500 mt-1">
                        Update category name or image.
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
                    name="category_id"
                    id="editCategoryId">


                <!-- Name -->

                <div class="mb-5">

                    <label
                        class="block text-sm
                    font-semibold
                    text-slate-700 mb-2">
                        Category Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="editCategoryName"
                        required
                        class="w-full rounded-xl
                    border border-slate-300
                    px-4 py-3 text-sm
                    focus:outline-none
                    focus:ring-2
                    focus:ring-teal-500
                    focus:border-teal-500">

                </div>


                <!-- Current Image -->

                <div class="mb-5">

                    <label
                        class="block text-sm
                    font-semibold
                    text-slate-700 mb-2">
                        Current Image
                    </label>


                    <div
                        id="currentImageContainer"
                        class="mb-3"></div>


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
                        Leave empty to keep the current image.
                    </p>

                </div>


                <!-- Buttons -->

                <div
                    class="flex justify-end
                gap-3 pt-2">

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
                        class="px-5 py-2.5
                    rounded-xl bg-teal-600
                    text-white text-sm
                    font-bold
                    hover:bg-teal-700
                    transition">
                        Update Category
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

        function openEditModal(id, name, image) {

            document.getElementById(
                'editCategoryId'
            ).value = id;


            document.getElementById(
                'editCategoryName'
            ).value = name;


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
                text-slate-400"
            >
                No Image
            </div>
        `;
            }


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
        | Category Search
        |--------------------------------------------------------------------------
        */

        const categorySearch =
            document.getElementById('categorySearch');

        const categoryTableBody =
            document.getElementById('categoryTableBody');


        if (
            categorySearch &&
            categoryTableBody
        ) {

            categorySearch.addEventListener(
                'input',
                function() {

                    const searchValue =
                        this.value
                        .trim()
                        .toLowerCase();


                    const rows =
                        categoryTableBody.querySelectorAll('tr');


                    rows.forEach(function(row) {

                        const categoryName =
                            row
                            .querySelector('td:nth-child(2)')
                            ?.textContent
                            .trim()
                            .toLowerCase() || '';


                        if (
                            categoryName.includes(
                                searchValue
                            )
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