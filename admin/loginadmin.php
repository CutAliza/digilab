<?php
session_start();

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'digilab';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitize and validate input
        $username = htmlspecialchars(trim($_POST['username']));
        $password = $_POST['password'];

        // Check if username exists and fetch data
        $stmt = $conn->prepare("SELECT id_admin, username, email, logo_image, password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception('Username not found.');
        }

        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify password
        if (!password_verify($password, $user['password'])) {
            throw new Exception('Invalid password.');
        }

        // Set session variables
        $_SESSION['id_admin'] = $user['id_admin'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['img'] = !empty($user['logo_image']) ? 'uploads/' . $user['logo_image'] : 'uploads/default-profile.png';
        $_SESSION['status'] = 'Login successful!';
        $_SESSION['status_type'] = 'success';

        // Redirect to dashboard
        header("Location: berandaa.php");
        exit();

    } catch (Exception $e) {
        // Handle login error
        $_SESSION['status'] = $e->getMessage();
        $_SESSION['status_type'] = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Account Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-500 to-blue-900">

    <div class="max-w-lg mx-auto my-12 p-6 bg-gray-100 rounded-xl">
        <img src="digilab logo.png" alt="Digilab Logo" class="w-24 h-auto mx-auto">
        <h2 class="text-center text-2xl font-semibold text-gray-700 mb-6">Sign In to Your Account</h2>

        <?php if (isset($_SESSION['status'])): ?>
            <div class="mb-4 text-center text-<?php echo $_SESSION['status_type'] === 'success' ? 'green' : 'red'; ?>-500">
                <?php echo $_SESSION['status']; ?>
                <?php unset($_SESSION['status'], $_SESSION['status_type']); ?>
            </div>
        <?php endif; ?>

        <!-- Form for Sign In -->
        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-lg font-medium">Username</label>
                <input type="text" id="username" name="username" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter username" required>
            </div>
            <div>
                <label for="password" class="block text-lg font-medium">Password</label>
                <input type="password" id="password" name="password" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter password" required>
            </div>

            <!-- Sign In Button -->
            <button type="submit" class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800">
                <strong>Sign In</strong>
            </button>
        </form>

        <!-- Log-in Options -->
        <div class="mt-8 text-center">
            <h4 class="text-xl font-semibold mb-4">Don't have an account?</h4>
            <a href="createaccmitra.php" class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800 block text-center">
                <strong>Create Account</strong>
            </a>
        </div>
    </div>

</body>
</html>
