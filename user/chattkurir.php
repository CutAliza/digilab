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
$user_img = $_SESSION['img'] ?? 'default.jpg'; // Default image if no image is uploaded

// Set default pesan
$user_message = "";
$courier_message = "";

// Menangani pengiriman pesan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['user_message'])) {
    $user_message = $_POST['user_message'];
    $courier_message = "Pesanan Anda sedang diproses. Terima kasih telah menghubungi!";
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
    <title>Chat dengan Kurir</title>
    <!-- Link Tailwind CSS -->
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


    <!-- Chatbox Container -->
    <div class="max-w-lg mx-auto my-10 bg-white rounded-lg shadow-lg">
        <!-- Header -->
        <div class="bg-blue-500 text-white p-4 rounded-t-lg flex items-center">
            <h2 class="text-xl font-semibold">Chat dengan Kurir</h2>
        </div>

        <!-- Chat Messages -->
        <div class="p-4 h-96 overflow-y-auto space-y-4 bg-gray-50">
            <?php if (!empty($user_message)): ?>
                <!-- Pesan Pengguna -->
                <div class="flex justify-end">
                    <div class="bg-blue-200 text-black p-3 rounded-lg max-w-xs">
                        <p><?php echo htmlspecialchars($user_message); ?></p>
                    </div>
                </div>
                <!-- Balasan Kurir -->
                <div class="flex justify-start">
                    <div class="bg-blue-100 text-black p-3 rounded-lg max-w-xs">
                        <p><?php echo htmlspecialchars($courier_message); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <!-- Pesan Default -->
                <div class="text-center text-gray-500">
                    <p>Mulai chat dengan mengetik pesan di bawah.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Input Pesan -->
        <form action="" method="POST" class="flex p-4 bg-white border-t border-gray-300">
            <input type="text" name="user_message" placeholder="Ketik pesan..." class="w-full p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Kirim
            </button>
        </form>
    </div>

    <div class="flex justify-center my-4">
    <button onclick="window.location.href='beranda.php'" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-blue-700">
        Kembali
    </button>
</div>


    <footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
            <p class="mt-2 text-lg">Platform inovatif untuk mengakses koleksi buku secara online dengan mudah.</p>
            <p class="text-sm mt-4">&copy; 2024 DIGILAB. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
