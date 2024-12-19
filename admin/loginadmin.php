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

        <!-- Form for Sign In -->
        <form action="berandaa.php" method="POST" class="space-y-4">
            <div>
                <label for="library_name" class="block text-lg font-medium">Library Name</label>
                <input type="text" id="library_name" name="nama_perpustakaan" class="w-full p-3 mt-2 border border-gray-300 rounded-xl" placeholder="Enter library name" required>
            </div>
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
            <h4 class="text-xl font-semibold mb-4">Or Log in with:</h4>

            <!-- Create Account Button -->
            <form action="createaccmitra.php" method="GET" class="mt-4">
                <button type="submit" class="w-full py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800">
                    <strong>Create Account</strong>
                </button>
            </form>
        </div>
    </div>

</body>
</html>
