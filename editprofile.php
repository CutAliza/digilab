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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update foto profil
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['img']['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            $upload_dir = __DIR__ . '/uploads/'; // Jalur absolut
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true); // Membuat folder jika belum ada
            }

            $file_name = uniqid() . '_' . basename($_FILES['img']['name']);
            $upload_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['img']['tmp_name'], $upload_file)) {
                // Update the database with the new image name
                $stmt = $conn->prepare("UPDATE users SET img = ? WHERE id = ?");
                $stmt->bind_param("si", $file_name, $user_id);
                $stmt->execute();
                $stmt->close();
                
                // Update session variable for image
                $_SESSION['img'] = $file_name;
                
                $message = "Foto profil berhasil diperbarui.";
            } else {
                $message = "Gagal mengunggah foto profil.";
            }
        } else {
            $message = "Hanya file gambar (JPG, PNG, GIF) yang diperbolehkan.";
        }
    }

    // Update username
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $new_username = $conn->real_escape_string(trim($_POST['username']));
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $new_username, $user_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['username'] = $new_username;
        $message = "Nama pengguna berhasil diperbarui.";
    }

    // Update password
    if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (!empty($password) && $password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed_password, $user_id);
            $stmt->execute();
            $stmt->close();
            $message = "Kata sandi berhasil diperbarui.";
        } elseif (!empty($password)) {
            $message = "Kata sandi tidak cocok.";
        }
    }
}

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
<body class="bg-gray-100">
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

                <!-- Tambahkan Google Material Icons -->
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

                <!-- Dropdown Profil -->
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
        </div>
    </nav>

   <div class="container mx-auto mt-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Edit Profil</h1>

        <!-- Pesan Sukses/Error -->
        <?php if (!empty($message)): ?>
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="profile.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="img" class="block font-medium">Ganti Foto Profil</label>
                <input type="file" name="img" id="img" class="block w-full">
            </div>
            <div>
                <label for="username" class="block font-medium">Nama Pengguna</label>
                <input type="text" name="username" id="username" 
                       value="<?php echo htmlspecialchars($user_data['username']); ?>" 
                       class="block w-full">
            </div>
            <div>
                <label for="password" class="block font-medium">Kata Sandi Baru</label>
                <input type="password" name="password" id="password" class="block w-full">
            </div>
            <div>
                <label for="confirm_password" class="block font-medium">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="confirm_password" id="confirm_password" class="block w-full">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Tambahkan margin bawah pada container atau div sebelum footer -->
<div class="mb-12"></div> <!-- Tambahkan jarak di sini -->

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
