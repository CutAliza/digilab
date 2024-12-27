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
$user_img = $_SESSION['img'] ?? 'default.jpg';

$message = ""; // Variabel untuk menyimpan pesan sukses atau error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update foto profil
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['img']['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            $upload_dir = __DIR__ . '/uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_name = uniqid() . '_' . basename($_FILES['img']['name']);
            $upload_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['img']['tmp_name'], $upload_file)) {
                $stmt = $conn->prepare("UPDATE users SET img = ? WHERE id = ?");
                $stmt->bind_param("si", $file_name, $user_id);
                $stmt->execute();
                $stmt->close();

                $_SESSION['img'] = $file_name;
                $message = "Foto profil berhasil diperbarui.";
            } else {
                $message = "Gagal mengunggah foto profil.";
            }
        } else {
            $message = "Hanya file gambar (JPG, PNG, GIF) yang diperbolehkan.";
        }
    }

    // Update data lainnya
    $fields = ['username', 'library_name', 'email', 'contact_number', 'address'];
    foreach ($fields as $field) {
        if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
            $value = $conn->real_escape_string(trim($_POST[$field]));
            $stmt = $conn->prepare("UPDATE users SET $field = ? WHERE id = ?");
            $stmt->bind_param("si", $value, $user_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION[$field] = $value; // Update sesi untuk data terkait
            $message = "Data berhasil diperbarui.";
        }
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
$img = !empty($user_data['img']) ? 'uploads/' . $user_data['img'] : 'default.jpg';
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
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <a href="beranda.php" class="flex items-center">
            <img src="digilab logo.png" alt="Logo" class="w-10 h-10">
            <span class="ml-2 font-bold text-lg"></span>
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

            <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-gray-200 text-black px-4 py-2 rounded-full">
                    <img src="<?php echo $img; ?>" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                    <span><?php echo htmlspecialchars($username); ?></span>
                </button>

                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-gray-900 text-white rounded-lg shadow-lg">
                    <ul class="py-2 text-sm">
                        <li><a href="profile.php" class="block px-4 py-2 hover:bg-gray-700">Edit Profil</a></li>
                        <li><a href="logout.php" class="block px-4 py-2 hover:bg-gray-700">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-4">Edit Profil</h1>

            <?php if (!empty($message)): ?>
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="profile.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="img" class="block font-medium">Foto Profil</label>
                    <input type="file" name="img" id="img" class="block w-full">
                </div>
                <div>
                    <label for="library_name" class="block font-medium">Nama Perpustakaan</label>
                    <input type="text" name="library_name" id="library_name" value="<?php echo htmlspecialchars($user_data['library_name'] ?? ''); ?>" class="block w-full">
                </div>
                <div>
                    <label for="email" class="block font-medium">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" class="block w-full">
                </div>
                <div>
                    <label for="contact_number" class="block font-medium">Nomor Kontak</label>
                    <input type="text" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($user_data['contact_number'] ?? ''); ?>" class="block w-full">
                </div>
                <div>
                    <label for="address" class="block font-medium">Alamat</label>
                    <textarea name="address" id="address" class="block w-full"><?php echo htmlspecialchars($user_data['address'] ?? ''); ?></textarea>
                </div>
                <div>
                    <label for="username" class="block font-medium">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user_data['username'] ?? ''); ?>" class="block w-full">
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

    <footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
            <p class="mt-2 text-lg">Platform inovatif untuk mengakses koleksi buku secara online dengan mudah.</p>
            <p class="text-sm mt-4">&copy; 2024 DIGILAB. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
