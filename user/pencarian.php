<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <!-- Logo -->
        <a href="#" class="flex items-center">
            <img src="webpro/image/digilab logo.png" alt="Logo" class="w-10 h-10">
        </a>

        <!-- Navbar Links -->
        <div class="hidden md:flex space-x-4">
            <a href="#" class="text-white hover:text-blue-300">Beranda</a>
            <a href="#" class="text-white hover:text-blue-300">Layanan</a>
            <a href="#" class="text-white hover:text-blue-300">Download</a>
            <a href="#" class="text-white hover:text-blue-300">Peminjaman</a>
            <a href="#" class="text-white hover:text-blue-300">Pengembalian</a>
        </div>

        <!-- Search and Icons -->
        <div class="flex items-center space-x-3">
            <input type="text" id="Cari" placeholder="Cari" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-60">
            <span class="cursor-pointer text-xl">🔍</span>
            <span class="cursor-pointer text-xl">👤</span>
            <span class="cursor-pointer text-xl">🔔</span>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto mt-10 flex-1">
        <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
            <label for="search" class="block text-gray-700 mb-4">Apa Buku Yang Ingin Kamu Cari Hari Ini?</label>
            <div class="relative">
                <input 
                    type="text" 
                    id="search" 
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Cari..." 
                    oninput="showSuggestions(this.value)"
                />
                <div id="suggestions-box" class="absolute top-full mt-1 w-full bg-white border border-gray-300 rounded-b shadow-lg z-10 hidden">
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Pendidikan</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Anak</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Ilmiah</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Fiksi</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Non Fiksi</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Kesehatan</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Sejarah</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Memasak</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Seni dan Fotografi</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Pengembangan Diri</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Buku Perjalanan</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Bisnis dan Ekonomi</div>
                    <div class="p-2 cursor-pointer hover:bg-gray-100">Filsafat dan Agama</div>
                </div>
            </div>
        </div>
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

    <script>
        function showSuggestions(value) {
            const suggestionsBox = document.getElementById('suggestions-box');
            if (value) {
                suggestionsBox.classList.remove('hidden');
            } else {
                suggestionsBox.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
