<?php
$host = "localhost"; // Server Database
$user = "root"; // Username Database
$password = ""; // Password Database
$database = "digilab"; // Nama Database

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

