<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // JavaScript untuk mengontrol dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-menu');
            dropdown.classList.toggle('hidden');
        }
    </script>
</head>

<body class="bg-gray-100">

   <!-- Navbar -->
<nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
    <!-- Logo -->
    <a href="#" class="flex items-center">
        <img src="image/digilab logo.png" alt="Logo" class="w-10 h-10">
    </a>

    <!-- Navbar Links -->
    <div class="flex space-x-6">
        <a href="beranda.php" class="hover:underline">Beranda</a>
        <a href="layanan.php" class="hover:underline">Layanan</a>
        <a href="download.php" class="hover:underline">Download</a>
        <a href="peminjaman.php" class="hover:underline">Peminjaman</a>
        <a href="pengembalian.php" class="hover:underline">Pengembalian</a>
    </div>

    <!-- Search and Icons -->
    <div class="flex items-center space-x-4">
        <!-- Search Input -->
        <input type="text" placeholder="Search" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Search Icon -->
        <a href="beranda.php" class="hover:underline text-white">
            <span class="material-icons-outlined">search</span>
        </a>

        <!-- Notification Icon -->
        <button class="relative hover:underline text-white">
            <span class="material-icons-outlined">notifications</span>
            <!-- Notification Badge -->
            <span class="absolute top-0 right-0 text-xs bg-red-600 text-white rounded-full px-1">3</span>
        </button>

        <!-- Profile Dropdown -->
        <div class="relative">
            <!-- Trigger -->
            <button onclick="toggleDropdown()" class="flex items-center space-x-2 bg-white text-black px-4 py-2 rounded-full">
                <img src="https://via.placeholder.com/50" alt="Foto Profil" class="w-8 h-8 rounded-full object-cover">
                <span>Rahma Maelani</span>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white text-black rounded-lg shadow-lg">
                <!-- Profil Header -->
                <div class="flex items-center p-4 border-b border-gray-700">
                    <img src="https://via.placeholder.com/50" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                    <div class="ml-3">
                        <h2 class="font-semibold">Rahma Maelani Sania</h2>
                        <p class="text-black-200 text-sm">@rahmamaelani5499</p>
                        <a href="#" class="text-blue-600 text-sm hover:underline">Lihat channel Anda</a>
                    </div>
                </div>

                <!-- Menu Options -->
                <ul class="py-2 text-sm">
                    <li>
                        <a href="edit_profil.php" class="flex items-center px-4 py-2 hover:bg-blue-700">
                            <span class="material-icons-outlined mr-2">edit</span>
                            Edit Profil
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-blue-700">
                            <span class="material-icons-outlined mr-2">swap_horiz</span>
                            Ganti Akun
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-blue-700">
                            <span class="material-icons-outlined mr-2">logout</span>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Tambahkan Google Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

<script>
    // Script untuk toggle dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
    }
</script>



    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">

                <!-- DIGILAB Section -->
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
                    <p class="mt-2 text-lg">Platform inovatif untuk mengakses koleksi buku secara online dengan mudah.</p>
                </div>

                <!-- Library Partners Section -->
                <div class="mt-4 md:mt-0">
                    <h3 class="text-2xl font-semibold mb-4">Library Partners</h3>
                    <ul class="space-y-3 text-sm md:text-base">
                        <li><a href="#" class="hover:text-blue-200 transition duration-300 ease-in-out">Perpustakaan Nasional</a></li>
                        <li><a href="#" class="hover:text-blue-200 transition duration-300 ease-in-out">Perpustakaan Universitas</a></li>
                    </ul>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="text-center">
                <h4 class="text-xl font-semibold">Follow Us</h4>
                <div>
                    <a href="#" class="text-white hover:text-blue-200 transition duration-300 ease-in-out">
                        <i class="fab fa-facebook fa-3x"></i>
                    </a>
                    <a href="#" class="text-white hover:text-blue-200 transition duration-300 ease-in-out">
                        <i class="fab fa-youtube fa-2x"></i>
                    </a>
                </div>
            </div>

            <!-- Digilab Website Link -->
            <div class="mt-6 text-center">
                <p class="text-blue-100 hover:text-blue-200 transition duration-300 ease-in-out">digilab.com</a>
                </p>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="mt-12 border-t-2 border-blue-800 pt-4 text-center text-sm">
            <p>&copy; 2024 DIGILAB. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
