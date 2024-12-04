<?php
session_start();
include 'dbconfig.php'; // File koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);

    // Ambil data pengguna dari database
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userId, $usernameFromDB, $email, $hashedPassword);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        // Verifikasi password
        if (password_verify($password, $hashedPassword)) {
            // Set sesi pengguna
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['email'] = $email;

            // Redirect ke beranda
            header('Location: beranda.php');
            exit;
        } else {
            $_SESSION['login_status'] = 'incorrect_password';
        }
    } else {
        $_SESSION['login_status'] = 'account_not_found';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digilab Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-800">

    <!-- Navbar -->
    <div class="bg-gradient-to-r from-gray-500 to-blue-900 text-white p-4 flex items-center font-semibold text-xl">
        <div class="font-bold">Digilab</div>
    </div>

    <div class="max-w-4xl mx-auto my-12 p-6 bg-gray-100 rounded-xl">
        <div class="text-center mb-8">
            <img src="digilab logo.png" alt="Digilab Logo" class="w-24 h-auto mx-auto">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Login Form -->
            <div>
                <h4 class="text-xl font-semibold mb-4">Sign In</h4>

                <!-- Display Error Message -->
                <?php if (isset($_SESSION['login_status'])): ?>
                    <div class="mb-4 text-red-500 font-semibold">
                        <?php
                        switch ($_SESSION['login_status']) {
                            case 'incorrect_password':
                                echo "Incorrect password. Please try again.";
                                break;
                            case 'account_not_found':
                                echo "Account not found. Please check your username.";
                                break;
                            default:
                                break;
                        }
                        unset($_SESSION['login_status']); // Clear session error
                        ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-4">
                        <label for="username" class="block text-lg font-medium">Username</label>
                        <input type="text" id="username" name="username" class="w-full p-3 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-lg font-medium">Password</label>
                        <input type="password" id="password" name="password" class="w-full p-3 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" id="remember" class="mr-2">
                        <label for="remember" class="text-lg font-medium">Remember Username</label>
                    </div>
                    <button type="submit" name="submit" class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800">
                        <strong>Sign In</strong>
                    </button>
                    <p class="mt-4 text-center">
                        <a href="forgot_password.php" class="text-blue-500 hover:underline">
                            <strong>Forgot Password?</strong>
                        </a>
                    </p>
                </form>
            </div>

            <!-- Social Login -->
            <div>
                <h4 class="text-xl font-semibold mb-4">Log-in with:</h4>
                <div class="space-y-4">
                    <button class="w-full py-3 bg-white text-gray-800 border border-gray-300 rounded-xl hover:bg-gray-100">
                        <i class="bi bi-google mr-2"></i><strong>Google</strong>
                    </button>
                    <button class="w-full py-3 bg-white text-gray-800 border border-gray-300 rounded-xl hover:bg-gray-100">
                        <i class="bi bi-apple mr-2"></i><strong>Apple</strong>
                    </button>
                </div>
                <div class="mt-6">
                    <button class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800" onclick="location.href='createacc.php'">
                        <strong>Create Account</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
