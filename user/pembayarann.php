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
    <title>Pembayarann</title>
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


<!-- Main Content -->
<main class="container mx-auto my-5">
    <h1 class="text-center text-2xl font-semibold mb-4">Pilih Metode Pembayaran</h1>
    <section class="space-y-6">
        <!-- Transfer Bank -->
        <div class="bg-gray-200 text-black rounded-lg">
            
            <!-- Virtual Bank Account -->
            <div class="bg-gray-200 text-black rounded-lg">
                <div class="p-4 font-semibold text-lg text-center">Virtual Bank Account</div>
                <div class="grid grid-cols-2 md:grid-cols-6 gap-6 p-6">
                    <!-- BCA VA -->
                    <div class="text-center bg-white p-4 rounded-lg shadow">
                        <a href="#" class="flex flex-col items-center">
                            <img src="bcava.jpg" alt="BCA VA" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm mb-2">BCA VA</span>
                            <p class="text-xs text-gray-700">Nomor VA: <br><strong>123456789012</strong></p>
                        </a>
                    </div>
            
                    <!-- Mandiri VA -->
                    <div class="text-center bg-white p-4 rounded-lg shadow">
                        <a href="#" class="flex flex-col items-center">
                            <img src="mandiriva.png" alt="Mandiri VA" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm mb-2">Mandiri VA</span>
                            <p class="text-xs text-gray-700">Nomor VA: <br><strong>987654321098</strong></p>
                        </a>
                    </div>
            
                    <!-- BRI VA -->
                    <div class="text-center bg-white p-4 rounded-lg shadow">
                        <a href="#" class="flex flex-col items-center">
                            <img src="briva.png" alt="BRI VA" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm mb-2">BRI VA</span>
                            <p class="text-xs text-gray-700">Nomor VA: <br><strong>234567890123</strong></p>
                        </a>
                    </div>
            
                    <!-- BNI VA -->
                    <div class="text-center bg-white p-4 rounded-lg shadow">
                        <a href="#" class="flex flex-col items-center">
                            <img src="bniva.png" alt="BNI VA" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm mb-2">BNI VA</span>
                            <p class="text-xs text-gray-700">Nomor VA: <br><strong>345678901234</strong></p>
                        </a>
                    </div>
            
                    <!-- CIMB VA -->
                    <div class="text-center bg-white p-4 rounded-lg shadow">
                        <a href="#" class="flex flex-col items-center">
                            <img src="cimbva.png" alt="CIMB VA" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm mb-2">CIMB VA</span>
                            <p class="text-xs text-gray-700">Nomor VA: <br><strong>456789012345</strong></p>
                        </a>
                    </div>
            
                    <!-- MayBank VA -->
                    <div class="text-center bg-white p-4 rounded-lg shadow">
                        <a href="#" class="flex flex-col items-center">
                            <img src="mayva.jpg" alt="MayBank VA" class="w-24 h-24 object-contain mb-2">
                            <span class="block font-bold text-sm mb-2">MayBank VA</span>
                            <p class="text-xs text-gray-700">Nomor VA: <br><strong>567890123456</strong></p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- E-Wallet -->
<div class="bg-gray-200 text-black rounded-lg">
    <div class="p-4 font-semibold text-lg text-center">E-Wallet</div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6">
        <!-- QRIS -->
        <div class="text-center bg-white p-4 rounded-lg shadow">
            <a href="#" class="flex flex-col items-center">
                <img src="qris.png" alt="QRIS" class="w-24 h-24 object-contain mb-2">
                <span class="block font-bold text-sm mb-2">QRIS</span>
                <p class="text-xs text-gray-700">ID QRIS: <br><strong>QR123456789</strong></p>
            </a>
        </div>
        
        <!-- ShopeePay -->
        <div class="text-center bg-white p-4 rounded-lg shadow">
            <a href="#" class="flex flex-col items-center">
                <img src="spayy.jpg" alt="ShopeePay" class="w-24 h-24 object-contain mb-2">
                <span class="block font-bold text-sm mb-2">ShopeePay</span>
                <p class="text-xs text-gray-700">Nomor HP: <br><strong>0812-3456-7890</strong></p>
            </a>
        </div>
        
        <!-- GoPay -->
        <div class="text-center bg-white p-4 rounded-lg shadow">
            <a href="#" class="flex flex-col items-center">
                <img src="gopay.png" alt="GoPay" class="w-24 h-24 object-contain mb-2">
                <span class="block font-bold text-sm mb-2">GoPay</span>
                <p class="text-xs text-gray-700">Nomor HP: <br><strong>0821-2345-6789</strong></p>
            </a>
        </div>
    </div>
</div>


        </section>
    </main>

    <div class="text-center my-6">
    <a href="bayardenda.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700">
        Kembali 
    </a>
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
