<?php
include "dbconfig.php";

// Cek jika form telah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $user = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);

    // Query untuk menghapus user berdasarkan username dan password
    $sql = "DELETE FROM users WHERE username = ? AND password = ?";

    // Persiapkan statement untuk menghindari SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);

    // Eksekusi statement
    if ($stmt->execute()) {
        $message = "Akun berhasil dihapus.";
        $stmt->close();
        $conn->close();

        // Redirect ke halaman loginadmin.php
        header("Location: loginadmin.php");
        exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
    } else {
        $message = "Gagal menghapus akun: " . $stmt->error;
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digilab Log-out</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-gray-500 to-blue-900-800">

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
