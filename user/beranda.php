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
    <title>Edit Profil</title>
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



    <!-- Hero Section -->
    <div class="bg-gray-300 py-12">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-blue-700 mb-4">Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
            <p class="text-lg text-gray-700">Temukan koleksi buku terbaik dan terbaru hanya di sini!</p>
        </div>
    </div>

     <!-- Carousel -->
     <div id="carouselExample" class="relative mb-6">
                <!-- Wrapper Gambar -->
                <div class="flex overflow-x-scroll snap-x snap-mandatory scrollbar-hide">
                    <!-- Slide 1 -->
                    <div class="flex-shrink-0 w-full snap-center relative">
                        <img src="download (1).jpg" class="w-full h-64 object-cover rounded-lg" alt="Slide 1">
                        <div class="absolute bottom-6 left-6 bg-black bg-opacity-50 p-4 rounded-md text-white">
                            <h5 class="text-2xl font-semibold">Selamat Datang di DIGILAB!!</h5>
                            <p>Temukan buku favorit Anda di sini!</p>
                        </div>
                    </div>
<!-- Slide 2 -->
<div class="flex-shrink-0 w-full snap-center relative">
                        <img src="download (2).jpg" class="w-full h-64 object-cover rounded-lg" alt="Slide 2">
                        <div class="absolute bottom-6 left-6 bg-black bg-opacity-50 p-4 rounded-md text-white">
                            <h5 class="text-2xl font-semibold">Berbagai Koleksi Buku</h5>
                            <p>Jelajahi koleksi buku terbaru kami.</p>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="flex-shrink-0 w-full snap-center relative">
                        <img src="download.jpg" class="w-full h-64 object-cover rounded-lg" alt="Slide 3">
                        <div class="absolute bottom-6 left-6 bg-black bg-opacity-50 p-4 rounded-md text-white">
                        <h5 class="text-2xl font-semibold">Baca di Mana Saja</h5>
                            <p>Platform yang mendukung mobilitas Anda.</p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <button id="prevButton" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700">
                    &lt;
                </button>
                <button id="nextButton" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700">
                    &gt;
                </button>

                 <!-- Indikator Slide -->
                 <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                    <div class="w-3 h-3 bg-blue-300 rounded-full"></div>
                    <div class="w-3 h-3 bg-blue-300 rounded-full"></div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="bg-white p-6 rounded-md shadow-lg mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <h5 class="text-3xl text-blue-600">296</h5>
                        <p>Buku Tersedia</p>
                    </div>
                    <div>
                        <h5 class="text-3xl text-blue-600">800</h5>
                        <p>Anggota Terdaftar</p>
                    </div>

                    <div>
                        <h5 class="text-3xl text-blue-600">156</h5>
                        <p>Peminjaman Bulanan</p>
                    </div>
                </div>
            </div>

        </body>

        </html>
        <!-- Daftar Buku Terbaru -->
<div class="mb-6">
    <h4 class="mb-4 text-2xl font-semibold">Buku Terbaru</h4>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="infobuku.php?title=Apa yang wanita inginkan" class="bg-white p-4 rounded-md shadow-lg">
            <img src="wanita.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 1">
            <h5 class="font-semibold text-xl">Apa yang wanita inginkan</h5>
            <p class="text-sm">"Apa yang Wanita Inginkan" adalah dongeng Indonesia yang mengajarkan bahwa wanita menginginkan kebebasan, penghargaan, dan hak untuk memilih.</p>
        </a>
        <a href="infobuku.php?title=Laut Bebas Sampah" class="bg-white p-4 rounded-md shadow-lg">
            <img src="Laut.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 2">
            <h5 class="font-semibold text-xl">Laut Bebas Sampah</h5>
            <p class="text-sm">Laut Bebas Sampah adalah konsep untuk menjaga laut tetap bersih dari sampah, terutama plastik, demi melestarikan ekosistem dan keanekaragaman hayati.</p>
        </a>
        <a href="infobuku.php?title=Buku Ajar Sosiologi" class="bg-white p-4 rounded-md shadow-lg">
            <img src="sosiologi.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 3">
            <h5 class="font-semibold text-xl">Buku Ajar Sosiologi</h5>
            <p class="text-sm">Buku ajar sosiologi membahas konsep-konsep dasar tentang masyarakat, interaksi sosial, budaya, dan perubahan sosial untuk memahami dinamika kehidupan sosial.</p>
        </a>
        <a href="infobuku.php?title=Raja Jenggot" class="bg-white p-4 rounded-md shadow-lg">
            <img src="raja.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 4">
            <h5 class="font-semibold text-xl">Raja Jenggot</h5>
            <p class="text-sm">Pengembaraan seorang raja dalam menyelami kehidupan rakyatnya yang penuh dengan intrik.</p>
        </a>
    </div>
</div>

<!-- Daftar Buku Populer -->
<div class="mb-6">
    <h4 class="mb-4 text-2xl font-semibold">Buku Populer</h4>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="infobuku.php?title=Apa yang wanita inginkan" class="bg-white p-4 rounded-md shadow-lg">
            <img src="wanita.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 1">
            <h5 class="font-semibold text-xl">Apa yang wanita inginkan</h5>
            <p class="text-sm">"Apa yang Wanita Inginkan" adalah dongeng Indonesia yang mengajarkan bahwa wanita menginginkan kebebasan, penghargaan, dan hak untuk memilih.</p>
        </a>
        <a href="infobuku.php?title=Laut Bebas Sampah" class="bg-white p-4 rounded-md shadow-lg">
            <img src="Laut.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 2">
            <h5 class="font-semibold text-xl">Laut Bebas Sampah</h5>
            <p class="text-sm">Laut Bebas Sampah adalah konsep untuk menjaga laut tetap bersih dari sampah, terutama plastik, demi melestarikan ekosistem dan keanekaragaman hayati.</p>
        </a>
        <a href="infobuku.php?title=Buku Ajar Sosiologi" class="bg-white p-4 rounded-md shadow-lg">
            <img src="sosiologi.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 3">
            <h5 class="font-semibold text-xl">Buku Ajar Sosiologi</h5>
            <p class="text-sm">Buku ajar sosiologi membahas konsep-konsep dasar tentang masyarakat, interaksi sosial, budaya, dan perubahan sosial untuk memahami dinamika kehidupan sosial.</p>
        </a>
        <a href="infobuku.php?title=Raja Jenggot" class="bg-white p-4 rounded-md shadow-lg">
            <img src="raja.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 4">
            <h5 class="font-semibold text-xl">Raja Jenggot</h5>
            <p class="text-sm">Pengembaraan seorang raja dalam menyelami kehidupan rakyatnya yang penuh dengan intrik.</p>
        </a>
    </div>
</div>

<!-- Daftar Buku Rating Tertinggi -->
<div class="mb-6">
    <h4 class="mb-4 text-2xl font-semibold">Rating Tertinggi</h4>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="infobuku.php?title=Apa yang wanita inginkan" class="bg-white p-4 rounded-md shadow-lg">
            <img src="wanita.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 1">
            <h5 class="font-semibold text-xl">Apa yang wanita inginkan</h5>
            <p class="text-sm">"Apa yang Wanita Inginkan" adalah dongeng Indonesia yang mengajarkan bahwa wanita menginginkan kebebasan, penghargaan, dan hak untuk memilih.</p>
        </a>
        <a href="infobuku.php?title=Laut Bebas Sampah" class="bg-white p-4 rounded-md shadow-lg">
            <img src="Laut.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 2">
            <h5 class="font-semibold text-xl">Laut Bebas Sampah</h5>
            <p class="text-sm">Laut Bebas Sampah adalah konsep untuk menjaga laut tetap bersih dari sampah, terutama plastik, demi melestarikan ekosistem dan keanekaragaman hayati.</p>
        </a>
        <a href="infobuku.php?title=Buku Ajar Sosiologi" class="bg-white p-4 rounded-md shadow-lg">
            <img src="sosiologi.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 3">
            <h5 class="font-semibold text-xl">Buku Ajar Sosiologi</h5>
            <p class="text-sm">Buku ajar sosiologi membahas konsep-konsep dasar tentang masyarakat, interaksi sosial, budaya, dan perubahan sosial untuk memahami dinamika kehidupan sosial.</p>
        </a>
        <a href="infobuku.php?title=Raja Jenggot" class="bg-white p-4 rounded-md shadow-lg">
            <img src="raja.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 4">
            <h5 class="font-semibold text-xl">Raja Jenggot</h5>
            <p class="text-sm">Pengembaraan seorang raja dalam menyelami kehidupan rakyatnya yang penuh dengan intrik.</p>
        </a>
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

    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('dropdownMenu');
        const button = document.querySelector('button[onclick="toggleDropdown()"]');
        
        // Jika klik di luar tombol atau dropdown, sembunyikan dropdown
        if (!dropdown.contains(e.target) && !button.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>

</body>

</html>
