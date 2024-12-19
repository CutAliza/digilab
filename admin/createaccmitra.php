<?php
session_start();

$host = 'localhost'; // Server address
$username = 'root'; // Database username
$password = ''; // Database password
$database = 'digilab'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from form
    $officialName = htmlspecialchars(trim($_POST['official_name']));
    $institutionOrigin = htmlspecialchars(trim($_POST['institution_origin']));
    $website = htmlspecialchars(trim($_POST['website']));
    $address = htmlspecialchars(trim($_POST['address']));
    $partnerCategory = htmlspecialchars(trim($_POST['partner_category']));
    $businessSector = htmlspecialchars(trim($_POST['business_sector']));
    $contactNumber = htmlspecialchars(trim($_POST['contact_number']));
    $email = htmlspecialchars(trim($_POST['email']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO library_partners (official_name, institution_origin, website, address, partner_category, business_sector, contact_number, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssssss', $officialName, $institutionOrigin, $website, $address, $partnerCategory, $businessSector, $contactNumber, $email, $username, $password);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        header('Location: loginadmin.php'); // Redirect to login page after success
        exit;
    } else {
        $_SESSION['status'] = 'error';
    }
    $stmt->close();
    // Redirect back to the form if error occurs
    header('Location: loginadmin.php'); 
    exit;
}
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
                <?php
                if ($_SESSION['status'] === 'success') {
                    echo "<p class='text-green-500 font-semibold'>Data saved successfully!</p>";
                } else {
                    echo "<p class='text-red-500 font-semibold'>An error occurred while saving data.</p>";
                }
                unset($_SESSION['status']); // Clear session status
                ?>
            </div>
        <?php endif; ?>

        <form action="loginadmin.php" method="POST" class="space-y-4">
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
            <button type="submit" class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800">
                <strong>Create Account</strong>
            </button>
        </form>
    </div>

</body>
</html>
