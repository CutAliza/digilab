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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan ITB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <style>
        /* Custom Styles */
        .library-info img {
            width: 300px;
            height: auto;
            border-radius: 10px;
        }

        .book-info img {
            transition: transform 0.3s;
        }

        .book-info img:hover {
            transform: scale(1.05);
        }

        .dropdown-menu {
            transition: opacity 0.3s, visibility 0.3s;
        }

        .dropdown-menu.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .dropdown-menu.visible {
            opacity: 1;
            visibility: visible;
        }
    </style>
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

        <!-- Search and Profile -->
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Search" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="hover:underline text-white">
                <span class="material-icons-outlined">search</span>
            </button>
            <button class="relative hover:underline text-white">
                <span class="material-icons-outlined">notifications</span>
                <span class="absolute top-0 right-0 text-xs bg-red-600 text-white rounded-full px-1">3</span>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-gray-200 text-black px-4 py-2 rounded-full">
                    <img src="<?php echo $img; ?>" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                    <span><?php echo htmlspecialchars($username); ?></span>
                </button>
                <div id="dropdownMenu" class="dropdown-menu hidden absolute right-0 mt-2 w-64 bg-gray-900 text-white rounded-lg shadow-lg">
                    <div class="flex items-center p-4 border-b border-gray-700">
                        <img src="<?php echo $img; ?>" alt="Foto Profil" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-3">
                            <h2 class="font-semibold"><?php echo htmlspecialchars($username); ?></h2>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user_email); ?></p>
                            <a href="profil.php" class="text-blue-400 text-sm hover:underline">Lihat channel Anda</a>
                        </div>
                    </div>
                    <ul class="py-2 text-sm">
                        <li><a href="profile.php" class="block px-4 py-2 hover:bg-gray-700">Edit Profil</a></li>
                        <li><a href="ganti_akun.php" class="block px-4 py-2 hover:bg-gray-700">Ganti Akun</a></li>
                        <li><a href="logout.php" class="block px-4 py-2 hover:bg-gray-700">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Section -->
    <main class="p-6">
        <h2 class="text-3xl font-bold mb-6">Perpustakaan Terdekat</h2>
        <section class="library-info flex items-center gap-6 bg-white p-6 rounded-lg shadow-md">
            <div class="image">
                <img src="perpus2.jpg" alt="Perpustakaan ITB">
            </div>
            <div class="library-details">
                <strong class="text-2xl">Perpustakaan ITB</strong>
                <p class="text-gray-600 mt-2">Kawasan ITB Kampus Ganesa, Jl. Ganesa No.10, Lb. Siliwangi, Kecamatan Coblong, Kota Bandung, Jawa Barat 40132</p>
            </div>
        </section>

        <!-- Book Details -->
        <div class="mt-10">
            <h4 class="mb-4 text-2xl font-bold">Rekomendasi Buku</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="infobuku.php?title=Apa yang wanita inginkan" class="bg-white p-4 rounded-md shadow-lg hover:shadow-xl">
                    <img src="wanita.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 1">
                    <h5 class="font-semibold text-xl">Apa yang Wanita Inginkan</h5>
                    <p class="text-sm mt-2">"Apa yang Wanita Inginkan" adalah dongeng Indonesia yang mengajarkan bahwa wanita menginginkan kebebasan, penghargaan, dan hak untuk memilih.</p>
                </a>
                <a href="infobuku.php?title=Laut Bebas Sampah" class="bg-white p-4 rounded-md shadow-lg hover:shadow-xl">
                    <img src="Laut.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 2">
                    <h5 class="font-semibold text-xl">Laut Bebas Sampah</h5>
                    <p class="text-sm mt-2">Laut Bebas Sampah adalah konsep untuk menjaga laut tetap bersih dari sampah, terutama plastik, demi melestarikan ekosistem dan keanekaragaman hayati.</p>
                </a>
                <a href="infobuku.php?title=Buku Ajar Sosiologi" class="bg-white p-4 rounded-md shadow-lg hover:shadow-xl">
                    <img src="sosiologi.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 3">
                    <h5 class="font-semibold text-xl">Buku Ajar Sosiologi</h5>
                    <p class="text-sm mt-2">Buku ajar sosiologi membahas konsep-konsep dasar tentang masyarakat, interaksi sosial, budaya, dan perubahan sosial untuk memahami dinamika kehidupan sosial.</p>
                </a>
                <a href="infobuku.php?title=Raja Jenggot" class="bg-white p-4 rounded-md shadow-lg hover:shadow-xl">
                    <img src="raja.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 4">
                    <h5 class="font-semibold text-xl">Raja Jenggot</h5>
                    <p class="text-sm mt-2">Pengembaraan seorang raja dalam menyelami kehidupan rakyatnya yang penuh dengan intrik.</p>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
            <p class="mt-4">© 2023 DIGILAB. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('hidden');
            dropdownMenu.classList.toggle('visible');
        }
    </script>
</body>
</html>
