<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Pengguna</title>
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
            <a href="kelolapengguna.php" class="hover:underline font-bold">Kelola Pengguna</a>
            <a href="historydenda.php" class="hover:underline">Laporan</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold mb-6">Pengelolaan Pengguna</h2>

        <!-- Pengguna Sudah Bayar Denda -->
        <section class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Pengguna Sudah Bayar Denda</h3>
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b py-2 px-4">Nama</th>
                        <th class="border-b py-2 px-4">Email</th>
                        <th class="border-b py-2 px-4">Jumlah Denda</th>
                        <th class="border-b py-2 px-4">Tanggal Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-b py-2 px-4">John Doe</td>
                        <td class="border-b py-2 px-4">john.doe@example.com</td>
                        <td class="border-b py-2 px-4">Rp 50,000</td>
                        <td class="border-b py-2 px-4">20 Desember 2024</td>
                    </tr>
                    <!-- Tambahkan data lainnya -->
                </tbody>
            </table>
        </section>

        <!-- Pengguna Sudah Kembalikan Buku -->
        <section class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Pengguna Sudah Kembalikan Buku</h3>
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b py-2 px-4">Nama</th>
                        <th class="border-b py-2 px-4">Judul Buku</th>
                        <th class="border-b py-2 px-4">Tanggal Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-b py-2 px-4">Jane Smith</td>
                        <td class="border-b py-2 px-4">"Belajar Python"</td>
                        <td class="border-b py-2 px-4">18 Desember 2024</td>
                    </tr>
                    <!-- Tambahkan data lainnya -->
                </tbody>
            </table>
        </section>

        <!-- Pengguna Sedang Meminjam Buku -->
        <section class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Pengguna Sedang Meminjam Buku</h3>
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b py-2 px-4">Nama</th>
                        <th class="border-b py-2 px-4">Judul Buku</th>
                        <th class="border-b py-2 px-4">Tanggal Pinjam</th>
                        <th class="border-b py-2 px-4">Batas Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-b py-2 px-4">Alice Johnson</td>
                        <td class="border-b py-2 px-4">"Kisah Inspiratif"</td>
                        <td class="border-b py-2 px-4">15 Desember 2024</td>
                        <td class="border-b py-2 px-4">22 Desember 2024</td>
                    </tr>
                    <!-- Tambahkan data lainnya -->
                </tbody>
            </table>
        </section>

        <!-- Buku yang Paling Banyak Dipinjam Pengguna -->
        <section class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Buku yang Paling Banyak Dipinjam Pengguna</h3>
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b py-2 px-4">Judul Buku</th>
                        <th class="border-b py-2 px-4">Jumlah Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-b py-2 px-4">"Pemrograman Dasar"</td>
                        <td class="border-b py-2 px-4">25 kali</td>
                    </tr>
                    <tr>
                        <td class="border-b py-2 px-4">"Algoritma dan Struktur Data"</td>
                        <td class="border-b py-2 px-4">18 kali</td>
                    </tr>
                    <!-- Tambahkan data lainnya -->
                </tbody>
            </table>
        </section>
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
