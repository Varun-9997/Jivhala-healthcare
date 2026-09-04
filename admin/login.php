<?php

session_name('JIVHALA_ADMIN_SESSION');
session_start();

require_once "../conn.php";

/*
|--------------------------------------------------------------------------
| Already Logged In
|--------------------------------------------------------------------------
*/

if (isset($_SESSION['admin_id'])) {
    header("Location: home.php");
    exit;
}

$error = '';
$success = '';

/*
|--------------------------------------------------------------------------
| Session Messages
|--------------------------------------------------------------------------
*/

if (isset($_GET['timeout'])) {
    $error = "Your session expired due to 30 minutes of inactivity. Please login again.";
}

if (isset($_GET['logout'])) {
    $success = "You have been logged out successfully.";
}

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {

        $error = "Please enter your email address and password.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";
    } else {

        $stmt = $pdo->prepare("
            SELECT id, name, email, password, role, status
            FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute([
            ':email' => $email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (
            $user &&
            $user['role'] === 'admin' &&
            $user['status'] === 'active' &&
            password_verify($password, $user['password'])
        ) {

            session_regenerate_id(true);

            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_role'] = $user['role'];

            $_SESSION['login_time'] = time();
            $_SESSION['last_activity'] = time();

            header("Location: home.php");
            exit;
        } else {

            $error = "Invalid email or password.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Jivhala Healthcare</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-slate-100 min-h-screen flex items-center justify-center font-sans p-4">


    <main class="w-full max-w-5xl">


        <!-- Main Login Card -->

        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">


            <div class="grid grid-cols-1 md:grid-cols-2">


                <!-- =====================================================
                     LEFT SIDE - BRANDING
                ====================================================== -->

                <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 text-white relative overflow-hidden min-h-[360px] md:min-h-[560px] flex items-center justify-center p-8 md:p-12">


                    <!-- Decorative Pattern -->

                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#14b8a6_1px,transparent_1px)] [background-size:16px_16px]"></div>


                    <!-- Decorative Circle -->

                    <div class="absolute -right-24 -bottom-24 w-64 h-64 rounded-full bg-teal-500/10 blur-3xl"></div>

                    <div class="absolute -left-24 -top-24 w-64 h-64 rounded-full bg-indigo-500/10 blur-3xl"></div>


                    <!-- Branding Content -->

                    <div class="relative z-10 text-center max-w-sm">


                        <!-- Jivhala Healthcare Logo -->

                        <div
                            class="w-24 h-24 md:w-28 md:h-28
    mx-auto rounded-2xl
    bg-white shadow-xl
    flex items-center justify-center
    mb-7 overflow-hidden">

                            <img
                                src="../img/JHCLOGO.jpeg"
                                alt="Jivhala Healthcare"
                                class="w-full h-full object-contain">

                        </div>


                        <!-- Brand -->

                        <h1 class="text-3xl md:text-4xl font-black tracking-wide">
                            Jivhala Healthcare
                        </h1>


                        <div class="w-16 h-1 bg-teal-500 rounded-full mx-auto my-5"></div>


                        <p class="text-base md:text-lg text-slate-300 font-medium">
                            Administration Panel
                        </p>


                        <p class="text-sm text-slate-400 mt-4 leading-relaxed">
                            Manage healthcare equipment, bookings and
                            customer information from one secure dashboard.
                        </p>


                        <!-- Security Badge -->

                        <div class="inline-flex items-center gap-2 mt-8 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs text-slate-300">

                            <span class="w-2 h-2 rounded-full bg-teal-400"></span>

                            Secure Administrator Access

                        </div>


                    </div>

                </div>



                <!-- =====================================================
                     RIGHT SIDE - LOGIN FORM
                ====================================================== -->

                <div class="p-6 sm:p-8 md:p-12 bg-slate-50 flex items-center">


                    <div class="w-full max-w-md mx-auto">


                        <!-- Form Heading -->

                        <div class="mb-8">

                            <p class="text-xs font-bold uppercase tracking-widest text-teal-600 mb-2">
                                Welcome Back
                            </p>

                            <h2 class="text-2xl md:text-3xl font-black text-slate-900">
                                Admin Login
                            </h2>

                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                Sign in to manage equipment and bookings.
                            </p>

                        </div>


                        <!-- =================================================
                             SUCCESS MESSAGE
                        ================================================== -->

                        <?php if ($success !== ''): ?>

                            <div class="mb-5 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm">

                                <div class="flex items-start gap-3">

                                    <svg
                                        class="w-5 h-5 shrink-0 mt-0.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>

                                    <span>
                                        <?= htmlspecialchars($success); ?>
                                    </span>

                                </div>

                            </div>

                        <?php endif; ?>


                        <!-- =================================================
                             ERROR MESSAGE
                        ================================================== -->

                        <?php if ($error !== ''): ?>

                            <div class="mb-5 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm">

                                <div class="flex items-start gap-3">

                                    <svg
                                        class="w-5 h-5 shrink-0 mt-0.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                                    </svg>

                                    <span>
                                        <?= htmlspecialchars($error); ?>
                                    </span>

                                </div>

                            </div>

                        <?php endif; ?>


                        <!-- =================================================
                             LOGIN FORM
                        ================================================== -->

                        <form
                            method="POST"
                            autocomplete="off"
                            class="space-y-5">


                            <!-- Email -->

                            <div>

                                <label
                                    for="email"
                                    class="block text-sm font-bold text-slate-700 mb-2">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>"
                                    placeholder="admin@example.com"
                                    autocomplete="username"
                                    required
                                    class="px-4 py-3.5 text-sm text-slate-900 border border-slate-300 rounded-xl bg-white w-full transition placeholder-slate-400 hover:border-slate-400 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10">

                            </div>


                            <!-- Password -->

                            <div>

                                <div class="flex items-center justify-between mb-2">

                                    <label
                                        for="password"
                                        class="block text-sm font-bold text-slate-700">
                                        Password
                                    </label>

                                </div>


                                <div class="relative">

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Enter your password"
                                        autocomplete="current-password"
                                        required
                                        class="px-4 py-3.5 pr-12 text-sm text-slate-900 border border-slate-300 rounded-xl bg-white w-full transition placeholder-slate-400 hover:border-slate-400 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10">


                                    <button
                                        type="button"
                                        onclick="togglePassword()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition"
                                        aria-label="Show or hide password">

                                        <svg
                                            id="eyeIcon"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                        </svg>

                                    </button>

                                </div>

                            </div>


                            <!-- Login Button -->

                            <button
                                type="submit"
                                class="w-full py-3.5 px-6 text-sm rounded-xl font-bold tracking-wide text-white bg-gradient-to-r from-slate-900 to-indigo-950 hover:from-indigo-950 hover:to-slate-900 shadow-md hover:shadow-lg active:scale-[0.99] transition-all focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2">
                                Secure Login
                            </button>


                        </form>


                        <!-- Bottom Security Info -->

                        <div class="mt-8 pt-6 border-t border-slate-200">

                            <div class="flex items-center justify-center gap-2 text-xs text-slate-500">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 text-teal-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>

                                <span>
                                    Your session is protected and secure.
                                </span>

                            </div>

                            <p class="text-center text-xs text-slate-400 mt-5">
                                Jivhala Healthcare Admin Panel
                            </p>

                        </div>


                    </div>

                </div>


            </div>

        </div>


    </main>


    <script>
        function togglePassword() {

            const passwordField =
                document.getElementById("password");

            const eyeIcon =
                document.getElementById("eyeIcon");


            if (passwordField.type === "password") {

                passwordField.type = "text";

            } else {

                passwordField.type = "password";

            }

        }
    </script>

</body>

</html>