<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <a href="beranda.php" class="flex items-center">
            <img src="digilab logo.png" alt="Logo" class="w-10 h-10">
        </a>
        <div class="flex space-x-6">
            <a href="berandaa.php" class="hover:underline">Beranda</a>
            <a href="koleksi.php" class="hover:underline">Koleksi</a>
            <a href="kelolapengguna.php" class="hover:underline">Kelola Pengguna</a>
            <a href="historydenda.php" class="hover:underline font-bold">Laporan</a>
        </div>
    </nav>
            </div>
</header>


        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8 flex-grow">
            <h2 class="text-2xl font-semibold mb-6">History Denda Pengembalian Buku</h2>

            <div class="bg-white shadow-md rounded-lg p-6">
                <table class="min-w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">Buku</th>
                            <th class="px-6 py-3">Pengguna</th>
                            <th class="px-6 py-3">Jumlah Denda</th>
                            <th class="px-6 py-3">Tanggal Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data dari database akan ditampilkan di sini -->
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Fiksi</td>
                            <td class="px-6 py-4">John</td>
                            <td class="px-6 py-4 text-red-500">Rp 10.000</td>
                            <td class="px-6 py-4">15-12-2024 10:00</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Dongeng</td>
                            <td class="px-6 py-4">Liza</td>
                            <td class="px-6 py-4 text-red-500">Rp 15.000</td>
                            <td class="px-6 py-4">16-12-2024 14:30</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Ilmiah</td>
                            <td class="px-6 py-4">Mey</td>
                            <td class="px-6 py-4 text-red-500">Rp 10.000</td>
                            <td class="px-6 py-4">15-12-2024 10:00</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Sistem Informasi</td>
                            <td class="px-6 py-4">Fikri</td>
                            <td class="px-6 py-4 text-red-500">Rp 15.000</td>
                            <td class="px-6 py-4">16-12-2024 14:30</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Bahasa Inggris</td>
                            <td class="px-6 py-4">Alice</td>
                            <td class="px-6 py-4 text-red-500">Rp 15.000</td>
                            <td class="px-6 py-4">16-12-2024 14:30</td>
                        </tr>
                        <!-- Tambahkan lebih banyak data sesuai kebutuhan -->
                    </tbody>
                </table>
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
    </div>
</body>
</html>
