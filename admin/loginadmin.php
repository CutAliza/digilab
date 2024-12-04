<?php
session_start();

// Simulasi data pengguna
$valid_username = "mitra";
$valid_password = "password123";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username === $valid_username && $password === $valid_password) {
            $_SESSION['username'] = $username;
            header("Location: beranda.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    } elseif (isset($_POST['google'])) {
        header("Location: logingoogle.php");
        exit();
    } elseif (isset($_POST['apple'])) {
        header("Location: loginapple.php");
        exit();
    } elseif (isset($_POST['create'])) {
        header("Location: createaccmitra.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mitra - DigiLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-800">
    <!-- Navbar -->
    <div class="bg-gradient-to-r from-gray-500 to-blue-900 text-white p-4 flex items-center font-semibold text-xl">
        <div class="font-bold">Digilab</div>
    </div>

    <!-- Main Login Form -->
    <div class="max-w-4xl mx-auto my-12 p-6 bg-gray-100 rounded-xl">
        <div class="text-center mb-8">
            <img src="digilab_logo.png" alt="Digilab Logo" class="w-24 h-auto mx-auto">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Sign In Form -->
            <div>
                <h4 class="text-xl font-semibold mb-4">Sign In Mitra</h4>
                <form action="" method="POST">
                    <div class="mb-4">
                        <label for="username" class="block text-lg font-medium">Username</label>
                        <input type="text" id="username" name="username" required
                            class="w-full p-3 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" 
                            placeholder="Enter your username">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-lg font-medium">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full p-3 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" 
                            placeholder="Enter your password">
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" id="remember" class="mr-2">
                        <label for="remember" class="text-lg font-medium">Remember Username</label>
                    </div>
                    <button type="submit" name="submit" 
                        class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800 font-semibold">
                        Sign In
                    </button>
                    <p class="mt-4 text-center">
                        <a href="#" class="text-blue-500 hover:underline">Forgot Password?</a>
                    </p>
                </form>
            </div>

            <!-- Social Login -->
            <div>
                <h4 class="text-xl font-semibold mb-4">Log-in with:</h4>
                <form action="" method="POST">
                    <div class="space-y-4">
                        <button type="submit" name="google" 
                            class="w-full py-3 bg-white text-gray-800 border border-gray-300 rounded-xl hover:bg-gray-100 font-semibold">
                            Google
                        </button>
                        <button type="submit" name="apple" 
                            class="w-full py-3 bg-white text-gray-800 border border-gray-300 rounded-xl hover:bg-gray-100 font-semibold">
                            Apple
                        </button>
                    </div>
                    <div class="mt-6">
                        <button type="submit" name="create" 
                            class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800 font-semibold">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
