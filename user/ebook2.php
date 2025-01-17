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
$user_img = $_SESSION['img'] ?? 'default.jpg'; // Gambar default jika tidak ada yang diunggah

// Set path gambar pengguna
$img = 'uploads/' . (!empty($user_img) ? $user_img : 'default.jpg');

// Ambil data pengguna untuk ditampilkan di form
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

// Set path gambar pengguna
$img = !empty($user_data['img']) ? 'uploads/' . $user_data['img'] : 'default.jpg'; // Gunakan gambar default jika tidak ada

// Data dummy untuk chapter
$content = [
    "It's pathetic, but at least you are too
I don't know what to do
I don't like anyone except sometimes you
And now you're sounding like a hurt puppy
You look ugly when you cry
But I'm the one you think to call
How do you feel lucky and appalled at the same time?
After everything you put me through
I somehow still believe in you
Oh
But I know in a week or so
You'll fade away again
And I wish that I cared
Hey, are you still there?
Good
Maybe I'm just not better than this, I haven't tried
'Cause maybe you'll finally choose me after you've had more time
I thought I was a fast learner
But guess I won't ever mind
Guess I won't ever mind
Maybe I blame my mother bleedin' into my stride
Maybe it was my father and his wandering eyes
(It's their fault that) I'll always be in your corner
'Cause I don't feel alive 'til I'm burning on your backburner",
];

// Menghitung total halaman (misalnya 1 paragraf per halaman)
$total_pages = count($content); 

// Set default page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Pastikan halaman dalam rentang yang valid
if ($page < 1 || $page > $total_pages) {
    $page = 1; // Atur ke halaman yang valid jika tidak
}

// Mendapatkan konten untuk halaman saat ini
$current_content = $content[$page - 1]; // Ambil konten untuk halaman saat ini

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapter Reader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <a href="beranda.php" class="flex items-center">
            <img src="digilab logo.png" alt="Logo" class="w-10 h-10">
        </a>

        <div class="flex space-x-6">
            <a href="beranda.php" class="hover:underline">Beranda</a>
            <a href="layanan2.php" class="hover:underline">Layanan</a>
            <a href="feeds.php" class="hover:underline">Feeds</a>
            <a href="peminjaman.php" class="hover:underline">Peminjaman</a>
            <a href="pengembalian.php" class="hover:underline">Pengembalian</a>
        </div>

        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Search" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <a href="beranda.php" class="hover:underline text-white">
                <span class="material-icons-outlined">search</span>
            </a>
            <button class="relative hover:underline text-white" onclick="window.location.href='notif.php'">
                <span class="material-icons-outlined">notifications</span>
                <span class="absolute top-0 right-0 text-xs bg-red-600 text-white rounded-full px-1">3</span>
            </button>

            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-gray-200 text-black px-4 py-2 rounded-full">
                    <img src="<?php echo $img; ?>" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                    <span><?php echo htmlspecialchars($username); ?></span>
                </button>
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

    <!-- Konten Utama -->
    <main class="p-6 max-w-3xl mx-auto bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">CHAPTER <?php echo $page; ?></h1>
        <p class="text-justify leading-relaxed mb-4">
            <?php echo nl2br(htmlspecialchars($current_content)); // Menampilkan konten ?>
        </p>
        <div class="text-center mt-6 text-sm text-gray-600">
            <?php echo $page; ?> dari <?php echo $total_pages; ?>
        </div>
    </main>

    <!-- Footer Navigation -->
    <footer class="bg-gray-300 fixed bottom-0 inset-x-0 shadow-md">
        <nav class="flex justify-around py-2">
        <a href="ebook.php" class="flex flex-col items-center text-gray-700 hover:text-gray-900"">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
                Sebelumnya
            </a>
            <a href="reader.php?action=exit" class="flex flex-col items-center text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
                Ulasan
            </a>
            <a href="ebook2.php" class="flex flex-col items-center text-gray-700 hover:text-gray-900"">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                Selanjutnya
            </a>
        </nav>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        document.addEventListener('click', function (e) {
            const dropdown = document.getElementById('dropdownMenu');
            const button = document.querySelector('button[onclick="toggleDropdown()"]');
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
