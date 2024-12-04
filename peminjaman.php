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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(to right, #6b7280, #1d4ed8);
            color: white;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header img {
            width: 64px;
            height: auto;
        }

        header a {
            color: white;
            text-decoration: none;
            margin-right: 16px;
            transition: color 0.3s ease;
        }

        header a:hover {
            color: #93c5fd;
        }

        header input {
            padding: 4px 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            outline: none;
        }

        header span {
            font-size: 1.25rem;
            cursor: pointer;
        }

        /* Main Content */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 24px;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 16px;
        }

        .book-list {
            display: flex;
            flex-direction: column;
            gap: 24px; /* space between book cards */
        }

        .book-card {
            display: flex;
            background: white;
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            align-items: flex-start; /* align items at the start */
        }

        .book-card img {
            width: 120px; /* set width for book image */
            height: 180px; /* set height for book image */
            border-radius: 8px;
            margin-right: 16px; /* space between image and text */
        }

        .book-info {
            flex: 1; /* allows the text area to take the remaining space */
        }

        .book-info p {
            margin: 4px 0;
            color: #374151;
        }

        .button {
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.875rem;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            background-color: #1f2937;
            color: white;
            margin-top: 16px; /* space between text and button */
        }

        .button:hover {
            background-color: #4b5563;
        }

        .due-info {
            margin-left: 16px; /* space between book info and due info */
            display: flex;
            flex-direction: column;
            justify-content: center; /* center content vertically */
            align-items: flex-start; /* align items to the left */
        }

        .due-info p {
            margin: 4px 0;
            color: #374151;
            font-weight: bold; /* make due info bold */
        }

        /* Footer */
        footer {
            background: linear-gradient(to right, #6b7280, #1e40af);
            color: white;
            padding: 16px;
            text-align: center;
            margin-top: 24px;
        }

        footer h2,
        footer h3,
        footer p {
            margin: 8px 0;
        }

        footer a {
            color: #93c5fd;
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }

        footer .partners {
            margin-bottom: 16px;
        }

        footer .social-icons a {
            margin: 0 8px;
            font-size: 1.5rem;
            color: white;
        }

        footer .social-icons a:hover {
            color: #93c5fd;
        }
    </style>
</head>

<body>
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
    <div class="container">
        <h2>Daftar Peminjaman</h2>
        
        <div class="book-list">
            <div class="book-card">
                <img src="laut bercerita.jpg" alt="Laut Bercerita">
                <div class="book-info">
                    <p><strong>Laut Bercerita</strong> – Leila S. Chudori</p>
                    <p>Pengarang: Leila S. Chudori</p>
                    <p>Penerbit: KPG (Kepustakaan Populer Gramedia)</p>
                    <p>Jenis: Sastra</p>
                    <p>Kota: Jakarta</p>
                    <p>Tahun Terbit: 2017</p>
                    <p>ISBN: 978-602-424-694-5</p>
                    <p>Rating:</p>
                    <p>Ulasan: Secara keseluruhan, buku "Laut Bercerita" adalah karya sastra yang menggugah, menggambarkan perjuangan dan kehilangan di masa Orde Baru.</p>
                </div>
                <div class="due-info">
                    <p>Tanggal Peminjaman: 15 Nov 2024</p>
                    <p>Sudah Meminjam: 10 hari</p>
                </div>
            </div>

            <div class="book-card">
                <img src="gadis kretek.png" alt="Gadis Kretek">
                <div class="book-info">
                    <p><strong>Gadis Kretek</strong> – Ratih Kumala</p>
                    <p>Pengarang: Ratih Kumala</p>
                    <p>Penerbit: KPG (Kepustakaan Populer Gramedia)</p>
                    <p>Jenis: Sastra</p>
                    <p>Kota: Jakarta</p>
                    <p>Tahun Terbit: 2017</p>
                    <p>ISBN: 978-602-424-694-5</p>
                    <p>Rating:</p>
                    <p>Ulasan: Secara keseluruhan, buku "Gadis Kretek" adalah karya sastra yang menggugah, menggambarkan perjuangan dan kehilangan di masa Orde Baru.</p>
                </div>
                <div class="due-info">
                    <p>Tanggal Peminjaman: 20 Nov 2024</p>
                    <p>Sudah Meminjam: 5 hari</p>
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
                    <h2 class="text-2xl text-white font-bold tracking-tight">DIGILAB</h2>
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
