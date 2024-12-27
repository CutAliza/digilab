<?php
$servername = "localhost"; // Host database
$username = "root";         // Username MySQL
$password = "";             // Password MySQL (kosong jika Anda tidak mengatur password)
$dbname = "digilab";       // Nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
