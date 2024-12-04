<?php
session_start();

// Cek jika pengguna sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil data pengguna dari sesi
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna';
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Email tidak tersedia';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Metode Pembayaran</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

   <!-- Navbar -->
<nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <!-- Logo -->
        <a href="beranda.php" class="flex items-center">
            <img src="digilab logo.png" alt="Logo" class="w-10 h-10">
            <span class="ml-2 font-bold text-lg"></span>
        </a>

        <!-- Navbar Links -->
        <div class="flex space-x-6">
            <a href="beranda.php" class="hover:underline">Beranda</a>
            <a href="layanan.php" class="hover:underline">Layanan</a>
            <a href="download.php" class="hover:underline">Download</a>
            <a href="peminjaman.php" class="hover:underline">Peminjaman</a>
            <a href="pengembalian.php" class="hover:underline">Pengembalian</a>
        </div>

          <!-- Bagian Ikon dan Dropdown -->
          <div class="flex items-center space-x-4">
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

            <!-- Dropdown Profil -->
            <div class="relative">
                <!-- Trigger -->
                <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-white text-black px-4 py-2 rounded-full">
                    <img src="https://via.placeholder.com/50" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                    <span><?php echo htmlspecialchars($username); ?></span>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-white text-black rounded-lg shadow-lg">
                    <!-- Profil Header -->
                    <div class="flex items-center p-4 border-b border-gray-700">
                        <img src="https://via.placeholder.com/50" alt="Foto Profil" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-3">
                            <h2 class="font-semibold"><?php echo htmlspecialchars($username); ?></h2>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user_email); ?></p>
                            <a href="profil.php" class="text-blue-400 text-sm hover:underline">Lihat channel Anda</a>
                        </div>
                    </div>

                    <!-- Menu Options -->
                    <ul class="py-2 text-sm">
                        <li>
                            <a href="editprofile.php" class="block px-4 py-2 hover:bg-gray-700">Edit Profil</a>
                        </li>
                        <li>
                            <a href="ganti_akun.php" class="block px-4 py-2 hover:bg-gray-700">Ganti Akun</a>
                        </li>
                        <li>
                            <a href="logout.php" class="block px-4 py-2 hover:bg-gray-700">Logout</a>
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


    <!-- Main Content -->
    <main class="container mx-auto my-5">
        <h1 class="text-center text-2xl font-semibold mb-4">Pilih Metode Pembayaran</h1>
        <section class="space-y-6">
            <!-- Transfer Bank -->
            <div class="bg-gray-200 text-black rounded-lg">
                <div class="p-4 font-semibold text-lg text-center">Transfer Bank</div>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6 p-6">
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="bca.jpg" alt="Bank BCA" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">Bank BCA</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="bri.jpg" alt="Bank BRI" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">Bank BRI</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="bni.png" alt="Bank BNI" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">Bank BNI</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="mandiri.png" alt="Bank Mandiri" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">Bank Mandiri</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="bsi.png" alt="Bank BSI" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">Bank BSI</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- E-Wallet -->
            <div class="bg-gray-200 text-black rounded-lg">
                <div class="p-4 font-semibold text-lg text-center">E-Wallet</div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6">
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="qris.png" alt="QRIS" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">QRIS</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="spayy.jpg" alt="ShopeePay" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">ShopeePay</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="gopay.png" alt="GoPay" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">GoPay</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Virtual Bank Account -->
            <div class="bg-gray-200 text-black rounded-lg">
                <div class="p-4 font-semibold text-lg text-center">Virtual Bank Account</div>
                <div class="grid grid-cols-2 md:grid-cols-6 gap-6 p-6">
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="bcava.jpg" alt="BCA Virtual Account" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">BCA VA</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="mandiriva.png" alt="Mandiri Virtual Account" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">Mandiri VA</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="briva.png" alt="BRI Virtual Account" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">BRI VA</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="bniva.png" alt="BNI Virtual Account" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">BNI VA</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="cimbva.png" alt="CIMB Virtual Account" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">CIMB VA</span>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="flex flex-col items-center">
                            <img src="mayva.jpg" alt="MayBank Virtual Account" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm">MayBank VA</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
                    <a href="#" class="text-white hover:text-blue-200 transition duration-300 ease-in-out">Facebook</a>
                    <a href="#" class="text-white hover:text-blue-200 transition duration-300 ease-in-out">YouTube</a>
                </div>
            </div>

            <!-- Digilab Website Link -->
            <div class="mt-6 text-center">
                <p class="text-blue-100 hover:text-blue-200 transition duration-300 ease-in-out">digilab.com</p>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="mt-12 border-t-2 border-blue-800 pt-4 text-center text-sm">
            <p>&copy; 2024 DIGILAB. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
