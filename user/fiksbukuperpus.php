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
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
        }

        header {
            background-color: #d3d3d3;
            padding: 10px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar input {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            cursor: pointer;
        }

        .icons span {
            margin-left: 10px;
            font-size: 20px;
        }

        /* Main Content */
        main {
            padding: 20px;
        }

        h2 {
            margin-top: 0;
        }

        /* Library Section */
        .library-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .library-info .image img {
            width: 100px;
            height: auto;
        }

        .library-details p {
            margin: 0;
        }

        /* Book Info */
        .book-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 20px 0;
        }

        .book-image img {
            width: 120px;
            height: auto;
        }

        .loan-duration h3 {
            margin: 0 0 10px;
        }

        .duration-buttons button {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            background-color: #e0e0e0;
            border-radius: 5px;
            cursor: pointer;
        }

        .duration-buttons button:hover {
            background-color: #d3d3d3;
        }

        /* Notes Section */
        .notes {
            margin-top: 20px;
        }

        .agree-button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #b3b3b3;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .agree-button:hover {
            background-color: #999;
        }
    </style>
</head>
<body class="bg-gray-200 text-gray-800">

   <!-- Navbar -->
   <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <!-- Logo -->
        <a href="beranda.php" class="flex items-center">
            <img src="digilab logo.png" alt="" class="w-10 h-10">
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

        <!-- Search and Icons -->
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Search" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <a href="beranda.php" class="hover:underline text-white">
                <span class="material-icons-outlined">search</span>
            </a>
            <button class="relative hover:underline text-white">
                <span class="material-icons-outlined">notifications</span>
                <span class="absolute top-0 right-0 text-xs bg-red-600 text-white rounded-full px-1">3</span>
            </button> 

            <!-- Dropdown Profil -->
            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-gray-200 text-black px-4 py-2 rounded-full">
                    <img src="<?php echo $img; ?>" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                    <span><?php echo htmlspecialchars($username); ?></span>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-gray-900 text-white rounded-lg shadow-lg">
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

    <!-- Tambahkan Google Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">


    <script>
        // Script untuk toggle dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }
    </script>

    <!-- Content Section -->
    <main>
        <h2>Perpustakaan Terdekat</h2>
        <section class="library-info">
            <div class="image">
                <img src="perpus2.jpg" alt="Perpustakaan ITB" />
            </div>
            <div class="library-details">
                <strong>Perpustakaan ITB</strong>
                <p>Kawasan ITB Kampus Ganesa, Jl. Ganesa No.10, Lb. Siliwangi, Kecamatan Coblong, Kota Bandung, Jawa Barat 40132</p>
            </div>
        </section>

        <!-- Book Details -->
        <section class="book-info">
            <div class="book-image">
                <img src="morfo.jpg" alt="Morfologi Buku" />
            </div>
            <div class="loan-duration">
                <h3>Lama Meminjam</h3>
                <div class="duration-buttons space-x-2">
    <button onclick="setActive(this)" class="duration-btn bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-500 hover:text-black">1 Hari</button>
    <button onclick="setActive(this)" class="duration-btn bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-500 hover:text-black">3 Hari</button>
    <button onclick="setActive(this)" class="duration-btn bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-500 hover:text-black">7 Hari</button>
    <button onclick="setActive(this)" class="duration-btn bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-500 hover:text-black">14 Hari</button>
</div>

<script>
    function setActive(button) {
        // Hapus kelas 'bg-blue-500 text-white' dari semua tombol
        document.querySelectorAll('.duration-btn').forEach(btn => {
            btn.classList.remove('bg-blue-500', 'text-white');
            btn.classList.add('bg-gray-300', 'text-black');
        });

        // Tambahkan kelas aktif ke tombol yang diklik
        button.classList.add('bg-blue-500', 'text-white');
    }
</script>

            </div>
        </section>

        <!-- Notes -->
        <section class="notes">
            <p><strong>NOTES:</strong><br>
            Apabila terjadi keterlambatan atau melebihi batas hari yang sudah ditentukan saat peminjaman, maka akan dikenakan denda sesuai dengan yang telah ditentukan.</p>
            <a href="berhasil.php" class="agree-button">Setuju</a>
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
