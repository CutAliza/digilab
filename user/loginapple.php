<?php
// Start session
session_start();

// Database connection
$host = 'localhost';
$username = 'root'; // Ganti sesuai username database Anda
$password = '';     // Ganti sesuai password database Anda
$dbname = 'digilab';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check credentials
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: beranda.php");
    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-500 to-blue-900">
    <div class="flex h-screen justify-center items-center">
        <div class="bg-gray-100 text-black w-full max-w-sm rounded-lg shadow-lg p-8">
            <div class="text-center mb-4">
                <img src="https://th.bing.com/th/id/R.46b36af61d8babdb963560313d505dd1?rik=nLxfzLqms%2bVlyQ&riu=http%3a%2f%2fclipart-library.com%2fimages_k%2fapple-logo-transparent-background%2fapple-logo-transparent-background-9.png&ehk=uz6jeO4im9zAfdgcp2Sx8bDlmE2L5%2bKeS4A3tXPLeuU%3d&risl=&pid=ImgRaw&r=0" alt="digilab" class="mx-auto w-5">
                <h1 class="text-xl font-bold mt-2">Akun Apple</h1>
            </div>
            <form method="POST" action="">
                <?php if (isset($error)) { ?>
                    <p class="text-red-500 text-sm mb-4"><?= $error; ?></p>
                <?php } ?>
                <div class="mb-4">
                    <label for="username" class="block text-sm">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-full mt-1 p-2 rounded bg-white text-gray-900">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full mt-1 p-2 rounded bg-white text-gray-900">
                </div>
                <div class="text-center mb-4">
                    <a href="#" class="text-sm text-blue-300">Lupa Sandi?</a>
                </div>
                <button type="submit"
                    class="w-full bg-gray-700 hover:bg-gray-800 text-white py-2 rounded">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
