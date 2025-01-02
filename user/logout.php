<?php
session_start(); // Memulai sesi

// Logika Logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Menghapus semua data sesi
    session_unset();
    session_destroy();

    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digilab Log-out</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-gray-500 to-blue-900">

    

    <!-- Konten -->
    <div class="max-w-2xl mx-auto my-12 p-6 bg-gray-100 rounded-xl">
        <div class="text-center mb-8">
            <img src="digilab logo.png" alt="Logo Digilab" class="w-24 h-auto mx-auto">
        </div>
        <p class="text-lg text-gray-700 font-semibold mb-4 text-center">Apakah Anda Yakin Ingin Keluar?</p>
        <form method="POST" action="">
            <button type="submit" name="submit" class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800">
                <strong>Log-out</strong>
            </button>
        </form>
    </div>

</body>

</html>
