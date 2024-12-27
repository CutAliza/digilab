<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <a href="beranda.php" class="flex items-center">
            <img src="digilab logo.png" alt="Logo" class="w-10 h-10">
        </a>
        <div class="flex space-x-6">
            <a href="berandaa.php" class="hover:underline">Beranda</a>
            <a href="koleksi.php" class="hover:underline font-bold">Koleksi</a>
            <a href="kelolapengguna.php" class="hover:underline">Kelola Pengguna</a>
            <a href="historydenda.php" class="hover:underline">Laporan</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold mb-6">Koleksi Perpustakaan</h2>

        <!-- Perpustakaan Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Perpustakaan 1 -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800">ITB Library</h3>
                    <p class="text-gray-600 mb-4">Koleksi unggulan dari Perpustakaan Pusat.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <img src="book1.jpg" alt="Buku 1" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 1: Fiksi Modern</p>
                        </div>
                        <div class="">
                            <img src="book2.jpg" alt="Buku 2" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 2: Teknik Mesin</p>
                        </div>
                        <div class="">
                            <img src="book3.jpg" alt="Buku 3" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 3: Sejarah Dunia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perpustakaan 2 -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800">UPI Central Library</h3>
                    <p class="text-gray-600 mb-4">Koleksi populer dari Perpustakaan Kota.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <img src="book4.jpg" alt="Buku 4" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 4: Seni Digital</p>
                        </div>
                        <div class="">
                            <img src="book5.jpg" alt="Buku 5" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 5: Biografi</p>
                        </div>
                        <div class="">
                            <img src="book6.jpg" alt="Buku 6" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 6: Karya Sastra</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perpustakaan 3 -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800">Open Library Telkom University</h3>
                    <p class="text-gray-600 mb-4">Koleksi akademik terbaik dari Perpustakaan Kampus.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <img src="book7.jpg" alt="Buku 7" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 7: Fisika Kuantum</p>
                        </div>
                        <div class="">
                            <img src="book8.jpg" alt="Buku 8" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 8: Ekonomi Mikro</p>
                        </div>
                        <div class="">
                            <img src="book9.jpg" alt="Buku 9" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 9: Statistika</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
            <p class="mt-2 text-lg">Platform inovatif untuk mengakses koleksi buku secara online dengan mudah.</p>
            <p class="text-sm mt-4">&copy; 2024 DIGILAB. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
