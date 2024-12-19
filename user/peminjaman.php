<?php
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user data from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'Pengguna';
$user_email = $_SESSION['email'] ?? 'Email tidak tersedia';
$user_img = $_SESSION['img'] ?? 'default.jpg'; // Default image if no image is uploaded

// Database connection
include 'dbconfig.php';

// Get user data for profile display
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


        <!-- Profile Dropdown -->
        <div class="relative">
            <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-gray-200 text-black px-4 py-2 rounded-full">
                <img src="<?php echo htmlspecialchars($img); ?>" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                <span><?php echo htmlspecialchars($username); ?></span>
            </button>

            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-gray-900 text-white rounded-lg shadow-lg">
                <div class="flex items-center p-4 border-b border-gray-700">
                    <img src="<?php echo htmlspecialchars($img); ?>" alt="Foto Profil" class="w-12 h-12 rounded-full object-cover">
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
    </nav>

    <script>
        // Toggle dropdown menu visibility
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }
    </script>

    <!-- Main Content -->
    <div class="container">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengembalian</h2>
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
                    <p>Ulasan: Secara keseluruhan, buku "Laut Bercerita" adalah karya sastra yang menggugah pikiran dan perasaan. Novel ini menceritakan kehidupan yang terpinggirkan dan harapan di tengah kesulitan.</p>
                </div>
                <div class="due-info">
                    <p><strong>Batas Waktu:</strong> 30 Hari</p>
                    <p><strong>Jumlah Dipinjam:</strong> 1</p>
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
                    <p><strong>Tanggal Peminjaman: 20 Nov 2024</strong></p>
                    <p><strong>Sudah Meminjam: 5 hari</strong></p>
                </div>
            </div>
        </div>
    </div>
            <!-- Add more book cards as needed -->
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

</body>
</html>
