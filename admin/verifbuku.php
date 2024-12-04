<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Import Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-500 to-blue-900 p-4 flex items-center justify-between">
        <!-- Logo -->
        <img src="digilab logo.png" alt="Logo" class="w-16 h-auto">

        <!-- Menu Navigasi -->
        <div class="hidden md:flex space-x-4">
            <a href="#" class="text-white hover:text-blue-300">Beranda</a>
            <a href="#" class="text-white hover:text-blue-300">Layanan</a>
            <a href="#" class="text-white hover:text-blue-300">Download</a>
            <a href="#" class="text-white hover:text-blue-300">Peminjaman</a>
            <a href="#" class="text-white hover:text-blue-300">Pengembalian</a>
        </div>

        <!-- Ikon Search, Profil, dan Notifikasi -->
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Cari" class="p-2 rounded border border-gray-300 text-gray-800">
            <span class="text-xl cursor-pointer">🔍</span>
            <span class="text-xl cursor-pointer">👤</span>
            <span class="text-xl cursor-pointer">🔔</span>
        </div>
    </nav>

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <form class="bg-white p-20 rounded-lg shadow-lg w-100 max-w-md">
            <div class="text-center">
                <p class="mb-4 text-lg font-bold text-gray-800">Selamat! Buku berhasil diunggah.</p>
                <img src="laut bercerita.jpg" alt="Laut Bercerita" class="mb-4 rounded shadow-md w-40 h-auto mx-auto">
                <p class="mb-4 text-lg font-bold text-gray-800">Laut Bercerita</p>
                <a href="uploadbuku.php" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Upload Buku Lain
                </a>
            </div>
        </form>
    </div>

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
