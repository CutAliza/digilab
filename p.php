<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Fungsi untuk toggle dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdownMenu");
            dropdown.classList.toggle("hidden");
        }
    </script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <!-- Dropdown Profil -->
    <div class="relative">
        <!-- Trigger -->
        <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-gray-800 text-white px-4 py-2 rounded-full">
            <img src="https://via.placeholder.com/50" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
            <span>Rahma Maelani</span>
        </button>

        <!-- Dropdown Menu -->
        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-gray-900 text-white rounded-lg shadow-lg">
            <!-- Profil Header -->
            <div class="flex items-center p-4 border-b border-gray-700">
                <img src="https://via.placeholder.com/50" alt="Foto Profil" class="w-12 h-12 rounded-full object-cover">
                <div class="ml-3">
                    <h2 class="font-semibold">Rahma Maelani Sania</h2>
                    <p class="text-gray-400 text-sm">@rahmamaelani5499</p>
                    <a href="#" class="text-blue-400 text-sm hover:underline">Lihat channel Anda</a>
                </div>
            </div>

            <!-- Menu Options -->
            <ul class="py-2 text-sm">
                <li>
                    <a href="edit_profil.php" class="flex items-center px-4 py-2 hover:bg-gray-700">
                        <span class="material-icons-outlined mr-2">edit</span>
                        Edit Profil
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                        <span class="material-icons-outlined mr-2">swap_horiz</span>
                        Ganti Akun
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                        <span class="material-icons-outlined mr-2">logout</span>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tambahkan Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</body>

</html>
