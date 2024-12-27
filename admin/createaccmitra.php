<?php
session_start();

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'digilab';

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $officialName = htmlspecialchars(trim($_POST['official_name']));
    $institutionOrigin = htmlspecialchars(trim($_POST['institution_origin']));
    $website = filter_var(trim($_POST['website']), FILTER_VALIDATE_URL) ?: null;
    $address = htmlspecialchars(trim($_POST['address']));
    $businessSector = htmlspecialchars(trim($_POST['business_sector']));
    $contactNumber = htmlspecialchars(trim($_POST['contact_number']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $username = htmlspecialchars(trim($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt password

    if (!$email) {
        $_SESSION['status'] = 'Invalid email format.';
        header('Location: createaccmitra.php');
        exit;
    }

    // Handle file upload
    $logoImage = null;
    if (isset($_FILES['logo_image']) && $_FILES['logo_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpName = $_FILES['logo_image']['tmp_name'];
        $fileType = mime_content_type($fileTmpName);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileSize = $_FILES['logo_image']['size'];
        $maxFileSize = 2 * 1024 * 1024; // 2 MB

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $fileExtension = pathinfo($_FILES['logo_image']['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid('logo_', true) . '.' . $fileExtension;
            $uploadDir = 'uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($fileTmpName, $uploadDir . $newFileName)) {
                $logoImage = $newFileName;
            } else {
                $_SESSION['status'] = 'Failed to upload logo.';
                header('Location: createaccmitra.php');
                exit;
            }
        } else {
            $_SESSION['status'] = 'Invalid logo image format or size.';
            header('Location: createaccmitra.php');
            exit;
        }
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO admin (official_name, institution_origin, website, address, business_sector, contact_number, email, username, password, logo_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssssss', $officialName, $institutionOrigin, $website, $address, $businessSector, $contactNumber, $email, $username, $password, $logoImage);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'Account successfully created!';
        header('Location: loginadmin.php'); 
        exit;
    } else {
        $_SESSION['status'] = 'Failed to save data: ' . $stmt->error;
        header('Location: createaccmitra.php');
        exit;
    }

    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Partner Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-500 to-blue-900">

    <div class="max-w-lg mx-auto my-12 p-6 bg-gray-100 rounded-xl">
        <img src="digilab logo.png" alt="Digilab Logo" class="mx-auto w-20 h-20 mb-4">
        <h2 class="text-center text-2xl font-semibold text-gray-700 mb-6">Create a New Partner Account</h2>

        <!-- Display Status Message -->
        <?php if (isset($_SESSION['status'])): ?>
            <div class="mb-4 text-center">
                <p class='<?= $_SESSION['status'] === 'Data successfully saved!' ? 'text-green-500' : 'text-red-500'; ?> font-semibold'>
                    <?= htmlspecialchars($_SESSION['status']); ?>
                </p>
                <?php unset($_SESSION['status']); ?>
            </div>
        <?php endif; ?>

        <form action="createaccmitra.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="official_name" class="block text-lg font-medium">Official Name</label>
                <input type="text" id="official_name" name="official_name" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter official name" required>
            </div>
            <div>
                <label for="institution_origin" class="block text-lg font-medium">Institution Origin</label>
                <input type="text" id="institution_origin" name="institution_origin" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter institution origin" required>
            </div>
            <div>
                <label for="website" class="block text-lg font-medium">Website</label>
                <input type="url" id="website" name="website" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter website URL (optional)">
            </div>
            <div>
                <label for="address" class="block text-lg font-medium">Address</label>
                <input type="text" id="address" name="address" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter address" required>
            </div>
            <div>
                <label for="business_sector" class="block text-lg font-medium">Business Sector</label>
                <select id="business_sector" name="business_sector" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" required>
                    <option value="" disabled selected>Select a business sector</option>
                    <option value="Education Sector">Education Sector</option>
                    <option value="Government Sector">Government Sector</option>
                    <option value="Business Sector">Business Sector</option>
                    <option value="Private/Non-Profit Sector">Private/Non-Profit Sector</option>
                </select>
            </div>
            <div>
                <label for="contact_number" class="block text-lg font-medium">Contact Number</label>
                <input type="text" id="contact_number" name="contact_number" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter contact number" required>
            </div>
            <div>
                <label for="email" class="block text-lg font-medium">Email</label>
                <input type="email" id="email" name="email" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter email" required>
            </div>
            <div>
                <label for="username" class="block text-lg font-medium">Username</label>
                <input type="text" id="username" name="username" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter username" required>
            </div>
            <div>
                <label for="password" class="block text-lg font-medium">Password</label>
                <input type="password" id="password" name="password" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter password" required>
            </div>
            <div>
                <label for="logo_image" class="block text-lg font-medium">Upload Logo Image</label>
                <input type="file" id="logo_image" name="logo_image" class="w-full p-3 mt-2 border border-gray-300 rounded-xl">
            </div>
            <button type="submit" class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800">
                <strong>Create Account</strong>
            </button>
        </form>
    </div>

</body>
</html>
