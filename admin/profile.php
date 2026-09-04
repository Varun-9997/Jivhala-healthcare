<?php

session_name('JIVHALA_ADMIN_SESSION');
session_start();

require_once "../conn.php";

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

$admin_id = $_SESSION['admin_id'];

$error = '';
$success = '';


/*
|--------------------------------------------------------------------------
| Change Password
|--------------------------------------------------------------------------
*/

if (isset($_POST['change_password'])) {

    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    /*
    |--------------------------------------------------------------------------
    | Get Current Admin Password
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT password
        FROM users
        WHERE id = :id
        AND role = 'admin'
        LIMIT 1
    ");

    $stmt->execute([
        ':id' => $admin_id
    ]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$admin) {

        $error = "Unable to find administrator account.";

    } elseif (!password_verify($current_password, $admin['password'])) {

        $error = "Current password is incorrect.";

    } elseif ($new_password !== $confirm_password) {

        $error = "New password and Confirm password do not match.";

    } elseif (strlen($new_password) < 6) {

        $error = "Password must be at least 6 characters long.";

    } else {

        $hashedPassword = password_hash(
            $new_password,
            PASSWORD_DEFAULT
        );

        $update = $pdo->prepare("
            UPDATE users
            SET password = :password
            WHERE id = :id
            AND role = 'admin'
        ");

        if ($update->execute([
            ':password' => $hashedPassword,
            ':id' => $admin_id
        ])) {

            $success = "Password changed successfully.";

        } else {

            $error = "Unable to update password.";

        }
    }
}


/*
|--------------------------------------------------------------------------
| Update Admin Profile
|--------------------------------------------------------------------------
*/

if (isset($_POST['update_profile'])) {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');


    if ($name === '') {

        $error = "Please enter your name.";

    } elseif ($email === '') {

        $error = "Please enter your email address.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        /*
        |--------------------------------------------------------------------------
        | Check Email Already Exists
        |--------------------------------------------------------------------------
        */

        $check = $pdo->prepare("
            SELECT id
            FROM users
            WHERE email = :email
            AND id != :id
            LIMIT 1
        ");

        $check->execute([
            ':email' => $email,
            ':id' => $admin_id
        ]);


        if ($check->fetch()) {

            $error = "Email address already exists.";

        } else {

            $update = $pdo->prepare("
                UPDATE users
                SET
                    name = :name,
                    email = :email
                WHERE id = :id
                AND role = 'admin'
            ");

            if ($update->execute([
                ':name' => $name,
                ':email' => $email,
                ':id' => $admin_id
            ])) {

                /*
                |--------------------------------------------------------------------------
                | Update Session Information
                |--------------------------------------------------------------------------
                */

                $_SESSION['admin_name'] = $name;
                $_SESSION['admin_email'] = $email;

                $success = "Profile updated successfully.";

            } else {

                $error = "Unable to update profile.";

            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| Fetch Logged-In Admin
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id, name, email, role, status, created_at
    FROM users
    WHERE id = :id
    AND role = 'admin'
    LIMIT 1
");

$stmt->execute([
    ':id' => $admin_id
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Admin Account Not Found
|--------------------------------------------------------------------------
*/

if (!$user) {

    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Profile | Jivhala Healthcare</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen flex flex-col">


    <?php include "header.php"; ?>


    <div class="flex flex-1">


        <?php include "sidebar.php"; ?>


        <!-- =========================================================
             Main Content
        ========================================================== -->

        <main class="flex-1 p-4 md:p-8 overflow-x-hidden">

            <div class="max-w-4xl mx-auto">


                <!-- Main Card -->

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">


                    <!-- Page Header -->

                    <div class="px-6 md:px-8 py-6 border-b border-slate-200 bg-slate-50">

                        <div class="flex items-center gap-4">


                            <!-- Profile Avatar -->

                            <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl md:text-2xl font-black shadow-sm">

                                <?= strtoupper(substr($user['name'], 0, 1)); ?>

                            </div>


                            <div>

                                <h1 class="text-xl md:text-2xl font-black text-slate-900">

                                    My Profile

                                </h1>

                                <p class="text-sm text-slate-500 mt-1">

                                    Manage your administrator account information and password.

                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         Feedback
                    ================================================== -->

                    <div class="px-6 md:px-8 pt-6">


                        <?php if ($success !== ''): ?>

                            <div class="mb-5 p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 flex items-center gap-3 text-sm font-medium">

                                <svg
                                    class="w-5 h-5 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                <?= htmlspecialchars($success); ?>

                            </div>

                        <?php endif; ?>


                        <?php if ($error !== ''): ?>

                            <div class="mb-5 p-4 rounded-xl bg-rose-50 text-rose-800 border border-rose-200 flex items-center gap-3 text-sm font-medium">

                                <svg
                                    class="w-5 h-5 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"
                                    />
                                </svg>

                                <?= htmlspecialchars($error); ?>

                            </div>

                        <?php endif; ?>


                    </div>


                    <!-- =================================================
                         Profile Information
                    ================================================== -->

                    <div class="p-6 md:p-8">


                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 md:p-6">


                            <div class="flex items-center justify-between gap-4 mb-6">

                                <div>

                                    <h2 class="text-base font-black text-slate-900">
                                        Account Information
                                    </h2>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Your current administrator account details.
                                    </p>

                                </div>


                                <span class="text-[10px] font-bold uppercase tracking-wider text-teal-700 bg-teal-50 border border-teal-200 px-3 py-1.5 rounded-lg whitespace-nowrap">

                                    <?= htmlspecialchars($user['status']); ?>

                                </span>

                            </div>


                            <div class="grid md:grid-cols-2 gap-5">


                                <!-- Name -->

                                <div>

                                    <label class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400 block">

                                        Full Name

                                    </label>

                                    <input
                                        type="text"
                                        readonly
                                        value="<?= htmlspecialchars($user['name']); ?>"
                                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-semibold cursor-not-allowed outline-none"
                                    >

                                </div>


                                <!-- Email -->

                                <div>

                                    <label class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400 block">

                                        Email Address

                                    </label>

                                    <input
                                        type="email"
                                        readonly
                                        value="<?= htmlspecialchars($user['email']); ?>"
                                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-semibold cursor-not-allowed outline-none"
                                    >

                                </div>


                                <!-- Role -->

                                <div>

                                    <label class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400 block">

                                        Account Role

                                    </label>

                                    <input
                                        type="text"
                                        readonly
                                        value="Administrator"
                                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-semibold cursor-not-allowed outline-none"
                                    >

                                </div>


                                <!-- Created -->

                                <div>

                                    <label class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-400 block">

                                        Account Created

                                    </label>

                                    <input
                                        type="text"
                                        readonly
                                        value="<?= !empty($user['created_at']) ? date('d M Y, h:i A', strtotime($user['created_at'])) : '-'; ?>"
                                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 font-semibold cursor-not-allowed outline-none"
                                    >

                                </div>


                            </div>


                            <!-- Actions -->

                            <div class="flex flex-wrap gap-3 mt-7 pt-6 border-t border-slate-200">

                                <button
                                    type="button"
                                    onclick="openProfileModal()"
                                    class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm"
                                >
                                    Edit Profile
                                </button>


                                <button
                                    type="button"
                                    onclick="openPasswordModal()"
                                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-bold transition"
                                >
                                    Change Password
                                </button>

                            </div>


                        </div>

                    </div>


                </div>

            </div>

        </main>

    </div>


    <?php include "footer.php"; ?>



    <!-- =============================================================
         Edit Profile Modal
    ============================================================== -->

    <div
        id="profileModal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center z-[9999] p-4"
    >

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">


            <!-- Modal Header -->

            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-black text-slate-900">
                        Edit Profile
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Update your administrator information.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="closeProfileModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition text-lg"
                >
                    &times;
                </button>

            </div>


            <!-- Form -->

            <form
                method="POST"
                class="p-6 space-y-5"
            >


                <!-- Name -->

                <div>

                    <label
                        for="profile_name"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="profile_name"
                        name="name"
                        value="<?= htmlspecialchars($user['name']); ?>"
                        required
                        class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-800 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 outline-none transition"
                    >

                </div>


                <!-- Email -->

                <div>

                    <label
                        for="profile_email"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="profile_email"
                        name="email"
                        value="<?= htmlspecialchars($user['email']); ?>"
                        required
                        class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-800 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 outline-none transition"
                    >

                </div>


                <!-- Buttons -->

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">

                    <button
                        type="button"
                        onclick="closeProfileModal()"
                        class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-bold transition"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        name="update_profile"
                        class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold transition"
                    >
                        Update Profile
                    </button>

                </div>


            </form>

        </div>

    </div>



    <!-- =============================================================
         Change Password Modal
    ============================================================== -->

    <div
        id="passwordModal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center z-[9999] p-4"
    >

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">


            <!-- Modal Header -->

            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-black text-slate-900">
                        Change Password
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Update your administrator login password.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="closePasswordModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition text-lg"
                >
                    &times;
                </button>

            </div>


            <!-- Form -->

            <form
                method="POST"
                class="p-6 space-y-5"
            >


                <!-- Current Password -->

                <div>

                    <label
                        for="current_password"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        Current Password
                    </label>

                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                        class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-800 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 outline-none transition"
                    >

                </div>


                <!-- New Password -->

                <div>

                    <label
                        for="new_password"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        New Password
                    </label>

                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        minlength="6"
                        required
                        class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-800 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 outline-none transition"
                    >

                    <p class="text-xs text-slate-400 mt-1.5">
                        Minimum 6 characters.
                    </p>

                </div>


                <!-- Confirm Password -->

                <div>

                    <label
                        for="confirm_password"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        minlength="6"
                        required
                        class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-800 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 outline-none transition"
                    >

                </div>


                <!-- Buttons -->

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">

                    <button
                        type="button"
                        onclick="closePasswordModal()"
                        class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-bold transition"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        name="change_password"
                        class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold transition"
                    >
                        Update Password
                    </button>

                </div>


            </form>

        </div>

    </div>



    <script>

        /*
        |--------------------------------------------------------------------------
        | Profile Modal
        |--------------------------------------------------------------------------
        */

        const profileModal =
            document.getElementById("profileModal");

        const passwordModal =
            document.getElementById("passwordModal");


        function openProfileModal() {

            profileModal.classList.remove("hidden");
            profileModal.classList.add("flex");

        }


        function closeProfileModal() {

            profileModal.classList.remove("flex");
            profileModal.classList.add("hidden");

        }


        /*
        |--------------------------------------------------------------------------
        | Password Modal
        |--------------------------------------------------------------------------
        */

        function openPasswordModal() {

            passwordModal.classList.remove("hidden");
            passwordModal.classList.add("flex");

        }


        function closePasswordModal() {

            passwordModal.classList.remove("flex");
            passwordModal.classList.add("hidden");

        }


        /*
        |--------------------------------------------------------------------------
        | Close Modals On Outside Click
        |--------------------------------------------------------------------------
        */

        window.addEventListener("click", function(event) {

            if (event.target === profileModal) {

                closeProfileModal();

            }

            if (event.target === passwordModal) {

                closePasswordModal();

            }

        });

    </script>


</body>

</html>