<?php
session_start();

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$dbname = "digilab";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Simulasi: Mengambil data pengguna dari session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Email tidak tersedia';
$img = isset($_SESSION['img']) ? $_SESSION['img'] : 'default-profile.png'; // Default foto profil


// Ambil data admin dari database
$adminData = [];
$query = "SELECT username FROM admin";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $adminData[] = $row['username'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Carousel Styles */
        .carousel {
            position: relative;
            overflow: hidden;
        }
        .carousel-track {
            display: flex;
            transition: transform 0.5s ease;
        }
        .carousel-item {
            flex: 0 0 100%;
        }
        .carousel-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }
        .carousel-prev {
            left: 10px;
        }
        .carousel-next {
            right: 10px;
        }
    </style>
</head>

<body class="bg-gray-200 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <a href="beranda.php" class="flex items-center">
            <img src="digilab logo.png" alt="Logo" class="w-10 h-10">
        </a>
        <div class="flex space-x-6">
            <a href="berandaa.php" class="hover:underline font-bold">Beranda</a>
            <a href="koleksi.php" class="hover:underline">Koleksi</a>
            <a href="kelolapengguna.php" class="hover:underline">Kelola Pengguna</a>
            <a href="historydenda.php" class="hover:underline">Laporan</a>
        </div>

        <div class="relative">
    <!-- Trigger -->
    <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-white text-black px-4 py-2 rounded-full">
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
                <a href="editprofile.php" class="text-blue-400 text-sm hover:underline">Edit Profil</a>
            </div>
        </div>

        <!-- Menu Options -->
        <ul class="py-2 text-sm">
            <li>
                <a href="editprofile.php" class="block px-4 py-2 hover:bg-gray-700">Edit Profil</a>
            </li>
            <li>
                <a href="index.php" class="block px-4 py-2 hover:bg-gray-700">Upload Buku</a>
            </li>
            <li>
                <a href="uploadfeeds.php" class="block px-4 py-2 hover:bg-gray-700">Upload Feeds</a>
            </li>
            <li>
                <a href="logout.php" class="block px-4 py-2 hover:bg-gray-700">Logout</a>
            </li>
            <!-- Tambahkan daftar admin -->
            <li class="px-4 py-2 text-gray-400">Daftar Admin:</li>
            <?php foreach ($adminData as $admin): ?>
                <li class="px-4 py-2 hover:bg-gray-700"><?php echo htmlspecialchars($admin); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold mb-6">Beranda Admin</h2>

        <!-- Carousel Section -->
        <div class="carousel relative">
            <div class="carousel-track">
                <div class="carousel-item">
                    <img src="library-shelves.jpg" alt="Slide 1" class="w-full h-64 object-cover rounded-lg">
                </div>
                <div class="carousel-item">
                    <img src="library1.jpg" alt="Slide 2" class="w-full h-64 object-cover rounded-lg">
                </div>
                <div class="carousel-item">
                    <img src="library2.jpg" alt="Slide 3" class="w-full h-64 object-cover rounded-lg">
                </div>
            </div>
            <button class="carousel-controls carousel-prev bg-gray-800 text-white px-4 py-2 rounded-full">&lt;</button>
            <button class="carousel-controls carousel-next bg-gray-800 text-white px-4 py-2 rounded-full">&gt;</button>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-8">
            <h2 class="text-3xl font-semibold mb-6 col-span-full">Statistik dan Aktivitas Perpustakaan</h2>
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700">Total Koleksi Buku</h3>
                <p class="text-4xl font-bold text-blue-600 mt-2">10</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700">Total Pengguna</h3>
                <p class="text-4xl font-bold text-green-600 mt-2">20</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700">Buku Dipinjam</h3>
                <p class="text-4xl font-bold text-yellow-500 mt-2">5</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-700">Buku Terlambat</h3>
                <p class="text-4xl font-bold text-red-500 mt-2">2</p>
            </div>
        </div>

        <!-- Latest Activity -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Pengumuman Terbaru</h2>
            <ul class="bg-white shadow-md rounded-lg divide-y divide-gray-200">
                <li class="p-4">Perpustakaan akan mengadakan diskusi buku pada 15 Januari 2024.</li>
                <li class="p-4">Koleksi buku baru telah tersedia, kunjungi bagian "Koleksi" untuk melihat daftar lengkapnya.</li>
                <li class="p-4">Pengguna dengan keterlambatan pengembalian di atas 1 minggu harap segera menghubungi admin.</li>
            </ul>
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

    <script>
        // Dropdown Functionality
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        // Carousel Functionality
        const track = document.querySelector('.carousel-track');
        const items = Array.from(track.children);
        const nextButton = document.querySelector('.carousel-next');
        const prevButton = document.querySelector('.carousel-prev');
        let currentIndex = 0;

        function updateCarousel() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % items.length;
            updateCarousel();
        });

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            updateCarousel();
        });
    </script>
</body>
</html>
