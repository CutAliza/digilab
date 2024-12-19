<?php
session_start();
include "dbconfig.php"; // Menghubungkan ke file koneksi database

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);

    if ($password !== $confirmPassword) {
        $message = '<p class="text-red-500 mb-4 text-center">Passwords do not match!</p>';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username atau email sudah ada
        $queryCheck = "SELECT COUNT(*) FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($queryCheck);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $message = '<p class="text-red-500 mb-4 text-center">Username or email already exists!</p>';
        } else {
            $queryInsert = "INSERT INTO users (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($queryInsert);
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $hashedPassword);

            if ($stmt->execute()) {
                $stmt->close();
                // Redirect ke halaman login
                header("Location: login.php");
                exit;
            } else {
                $message = '<p class="text-red-500 mb-4 text-center">Error: ' . htmlspecialchars($stmt->error) . '</p>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-gray-500 to-blue-900">

    <div class="bg-gray-100 text-gray-800 max-w-lg mx-auto mt-10 p-8 rounded-lg shadow-lg">
        <div class="text-center mb-6">
            <img src="digilab logo.png" alt="Digilab Logo" class="mx-auto w-20 h-20 mb-4">
            <h2 class="text-2xl font-bold">Create New Account</h2>
        </div>

        <?= $message; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="firstName" class="block text-sm font-medium mb-1">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="lastName" class="block text-sm font-medium mb-1">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium mb-1">Username</label>
                <input type="text" id="username" name="username" placeholder="Choose a username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="confirmPassword" class="block text-sm font-medium mb-1">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-gray-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Create Account
            </button>
        </form>
    </div>
</body>

</html>
