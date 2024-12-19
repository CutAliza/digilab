<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['role'])) {
        if ($_POST['role'] === 'mitra') {
            echo "Redirecting to loginadmin.php";
            header("Location: ../admin/loginadmin.php");
            exit();
        } elseif ($_POST['role'] === 'user') {
            echo "Redirecting to login.php";
            header("Location: ../user/login.php");
            exit();
        } else {
            echo "Unknown role";
        }
    } else {
        echo "Role not set.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Role - DigiLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-bg {
            background-color: #1C2938; /* Replace with the extracted color */
        }
    </style>
</head>

<body class="bg-gradient-to-r from-gray-500 to-blue-900">

    <!-- Role Selection -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-100 rounded-lg p-8 w-96 text-center">
            <img src="digilab logo.png" alt="Digilab Logo" class="w-24 mx-auto mb-6">
            <h2 class="text-lg font-semibold mb-6 text-gray-800">Log-in sebagai</h2>
            <form action="role.php" method="POST">
                <div class="grid grid-cols-2 gap-4">
                    <button type="submit" name="role" value="mitra" 
                        class="py-2 px-4 bg-gray-300 hover:bg-gray-400 rounded">Mitra</button>
                    <button type="submit" name="role" value="user" 
                        class="py-2 px-4 bg-gray-300 hover:bg-gray-400 rounded">User</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
