<?php
session_start();
include 'dbconfig.php';

// Cek jika pengguna sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil data pengguna dari sesi
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'Pengguna';
$user_email = $_SESSION['email'] ?? 'Email tidak tersedia';
$user_img = $_SESSION['img'] ?? 'default.jpg'; // Default image if no image is uploaded

$message = ""; // Variabel untuk menyimpan pesan sukses atau error

// Ambil data pengguna untuk ditampilkan di form
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Set the user image path
$img = !empty($user_data['img']) ? 'uploads/' . $user_data['img'] : 'default.jpg'; // Use a default image if none is set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku</title>
    <title><?php echo htmlspecialchars($book_data['title']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 text-gray-800">

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
            <a href="layanan2.php" class="hover:underline">Layanan</a>
            <a href="feeds.php" class="hover:underline">Feeds</a>
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
                <button class="relative hover:underline text-white" onclick="window.location.href='notif.php'">
                    <span class="material-icons-outlined">notifications</span>
                    <!-- Notification Badge -->
                    <span class="absolute top-0 right-0 text-xs bg-red-600 text-white rounded-full px-1">3</span>
                </button>


                <!-- Tambahkan Google Material Icons -->
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

                <!-- Dropdown Profil -->
                <div class="relative">
                    <!-- Trigger -->
                    <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-gray-200 text-black px-4 py-2 rounded-full">
                        <img src="<?php echo $img; ?>" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                        <span><?php echo htmlspecialchars($username); ?></span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-gray-900 text-white rounded-lg shadow-lg">
                        <!-- Profil Header -->
                        <div class="flex items-center p-4 border-b border-gray-700">
                            <img src="<?php echo $img; ?>" alt="Foto Profil" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-3">
                                <h2 class="font-semibold"><?php echo htmlspecialchars($username); ?></h2>
                                <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user_email); ?></p>
                                <!-- Mengarah ke halaman profil -->
                                <a href="profil.php" class="text-blue-400 text-sm hover:underline">Lihat channel Anda</a>
                            </div>
                        </div>

                        <!-- Menu Options -->
                        <ul class="py-2 text-sm">
                            <li>
                                <a href="profile.php" class="block px-4 py-2 hover:bg-gray-700">Edit Profil</a>
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

<!-- Konten Perpustakaan Terdekat -->
<div class="max-w-6xl mx-auto mt-12 bg-white rounded-lg p-6 shadow-md mb-12">
    <h1 class="text-2xl font-semibold mb-6">Perpustakaan Terdekat</h1>

    <div class="space-y-6">
        <!-- Perpustakaan 1 -->
        <div class="flex items-center space-x-4">
            <img src="perpus8.jpg" alt="Perpustakaan Kota" class="w-24 h-24 rounded-lg">
            <div>
                <h2 class="font-semibold">Perpustakaan Kota</h2>
                <p>Jl. Maunya Kamu No.1, Kota Khayalan</p>
                <button onclick="window.location.href='layananisi2.php'" class="bg-blue-500 text-white py-2 px-6 rounded hover:bg-blue-600">Pilih</button>
            </div>
        </div>

        <!-- Perpustakaan 2 -->
        <div class="flex items-center space-x-4">
            <img src="perpus1.jpg" alt="Perpustakaan Universitas Danuarta" class="w-24 h-24 rounded-lg">
            <div>
                <h2 class="font-semibold">Perpustakaan Universitas Danuarta</h2>
                <p>Jl. Universitas No.1, Kota Khayalan</p>
                <button onclick="window.location.href='layananisi2.php'" class="bg-blue-500 text-white py-2 px-6 rounded hover:bg-blue-600">Pilih</button>
            </div>
        </div>

        <!-- Perpustakaan 3 -->
        <div class="flex items-center space-x-4">
            <img src="perpus7.jpg" alt="Perpustakaan Buku Jojo" class="w-24 h-24 rounded-lg">
            <div>
                <h2 class="font-semibold">Perpustakaan Buku Jojo</h2>
                <p>Jl. Buku No.1, Kota Khayalan</p>
                <button onclick="window.location.href='layananisi2.php'" class="bg-blue-500 text-white py-2 px-6 rounded hover:bg-blue-600">Pilih</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
    <div class="container mx-auto text-center">
        <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
        <p class="mt-2 text-lg">Platform inovatif untuk mengakses koleksi buku secara online dengan mudah.</p>
        <p class="text-sm mt-4">&copy; 2024 DIGILAB. All rights reserved.</p>
    </div>
</footer>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
    }
</script>
</body>
</html>
