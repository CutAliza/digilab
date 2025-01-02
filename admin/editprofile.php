<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "digilab";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan data pengguna saat ini
$current_user = [
    'username' => $_SESSION['username'] ?? 'Guest',
    'email' => $_SESSION['user_email'] ?? 'Email tidak tersedia',
    'img' => $_SESSION['img'] ?? 'default-profile.png'
];

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $official_name = $_POST['official_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $img = $_FILES['img'] ?? null;

    // Validasi dan proses perubahan data
    if ($password && $password !== $confirm_password) {
        $message = "Password tidak cocok!";
    } else {
        // Jika ada gambar baru, upload gambar dan simpan di folder
        if ($img && $img['error'] === UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($img['name']);
            if (move_uploaded_file($img['tmp_name'], $targetFile)) {
                $_SESSION['img'] = $targetFile; // Update gambar profil
            } else {
                $message = "Gagal mengupload gambar.";
            }
        }

        // Update data pengguna di database
        $updateQuery = "UPDATE admin SET official_name = ?, email = ?, contact_number = ?, address = ?, username = ?";
        $params = [$official_name, $email, $contact_number, $address, $username];

        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $updateQuery .= ", password = ?";
            $params[] = $hashedPassword;
        }

        $updateQuery .= " WHERE username = ?";
        $params[] = $current_user['username'];

        $stmt = $conn->prepare($updateQuery);
        if ($stmt) {
            $stmt->bind_param(str_repeat("s", count($params)), ...$params);
            if ($stmt->execute()) {
                $message = "Profil berhasil diperbarui!";
            } else {
                $message = "Terjadi kesalahan saat memperbarui profil.";
            }
        } else {
            $message = "Terjadi kesalahan saat mempersiapkan query.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dropdown-menu {
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
            transform-origin: top right;
        }
        
        .dropdown-menu.show {
            opacity: 1;
            transform: scale(1);
            pointer-events: auto;
        }
        
        .dropdown-menu.hide {
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <a href="beranda.php" class="flex items-center gap-2">
                <img src="digilab logo.png" alt="DIGILAB" class="h-8 w-auto">
            </a>

            <div class="flex items-center gap-8">
                <a href="berandaa.php" class="hover:text-blue-200 transition">Beranda</a>
                <a href="koleksi.php" class="hover:text-blue-200 transition">Koleksi</a>
                <a href="kelolapengguna.php" class="hover:text-blue-200 transition">Kelola Pengguna</a>
                <a href="historydenda.php" class="hover:text-blue-200 transition">Laporan</a>

                <!-- Profile Dropdown -->
                <div class="relative" id="profileDropdown">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-white text-gray-800 px-4 py-2 rounded-full hover:bg-gray-50 transition">
                        <img src="<?php echo htmlspecialchars($current_user['img']); ?>" 
                             alt="Profile" 
                             class="w-8 h-8 rounded-full object-cover">
                        <span class="font-medium"><?php echo htmlspecialchars($current_user['username']); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu" class="dropdown-menu hide absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl text-gray-800 overflow-hidden">
                        <!-- User Profile Section -->
                        <div class="p-4 bg-gray-50 border-b">
                            <div class="flex items-center">
                                <img src="<?php echo htmlspecialchars($current_user['img']); ?>" 
                                     alt="Profile" 
                                     class="w-12 h-12 rounded-full object-cover">
                                <div class="ml-3">
                                    <p class="font-semibold"><?php echo htmlspecialchars($current_user['username']); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($current_user['email']); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <nav class="py-2">
                            <a href="editprofile.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                <i class="fas fa-user-edit w-5"></i>
                                <span>Edit Profile</span>
                            </a>
                            <a href="index.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                <i class="fas fa-book w-5"></i>
                                <span>Upload Buku</span>
                            </a>
                            <a href="uploadfeeds.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                <i class="fas fa-rss w-5"></i>
                                <span>Upload Feeds</span>
                            </a>
                            <a href="logout.php" class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                <i class="fas fa-sign-out-alt w-5"></i>
                                <span>Logout</span>
                            </a>
                        </nav>

                        <!-- Admin List -->
                        <?php if (!empty($adminData)): ?>
                        <div class="border-t">
                            <div class="px-4 py-2 bg-gray-50">
                                <h3 class="text-sm font-semibold text-gray-600">Daftar Admin</h3>
                            </div>
                            <div class="max-h-48 overflow-y-auto">
                                <?php foreach ($adminData as $admin): ?>
                                <div class="px-4 py-2 hover:bg-gray-100 transition">
                                    <div class="flex items-center">
                                        <img src="<?php echo htmlspecialchars($admin['logo_image'] ?? 'default-admin.png'); ?>" 
                                             alt="Admin Logo" 
                                             class="w-8 h-8 rounded-full object-cover">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium"><?php echo htmlspecialchars($admin['username']); ?></p>
                                            <?php if ($admin['institution_origin']): ?>
                                                <p class="text-xs text-gray-500"><?php echo htmlspecialchars($admin['institution_origin']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        const isHidden = dropdownMenu.classList.contains('hide');
        
        if (isHidden) {
            dropdownMenu.classList.remove('hide');
            dropdownMenu.classList.add('show');
        } else {
            dropdownMenu.classList.remove('show');
            dropdownMenu.classList.add('hide');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function closeDropdown(e) {
            const dropdown = document.getElementById('profileDropdown');
            if (!dropdown.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                dropdownMenu.classList.add('hide');
                document.removeEventListener('click', closeDropdown);
            }
        });
    }

    // Prevent dropdown from closing when clicking inside
    document.getElementById('dropdownMenu').addEventListener('click', function(e) {
        e.stopPropagation();
    });
    </script>

     <script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        const isHidden = dropdownMenu.classList.contains('hide');
        
        if (isHidden) {
            dropdownMenu.classList.remove('hide');
            dropdownMenu.classList.add('show');
        } else {
            dropdownMenu.classList.remove('show');
            dropdownMenu.classList.add('hide');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function closeDropdown(e) {
            const dropdown = document.getElementById('profileDropdown');
            if (!dropdown.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                dropdownMenu.classList.add('hide');
                document.removeEventListener('click', closeDropdown);
            }
        });
    }

    // Prevent dropdown from closing when clicking inside
    document.getElementById('dropdownMenu').addEventListener('click', function(e) {
        e.stopPropagation();
    });
    </script>

    <div class="container mx-auto mt-8">
        <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-4">Edit Profil</h1>
            <?php if (!empty($message)): ?>
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            <form action="editprofile.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
    <div class="mb-4">
        <label for="img" class="block text-lg font-medium">Foto Profil</label>
        <input type="file" name="img" id="img" class="w-full p-3 mt-2 border border-gray-300 rounded-lg bg-white">
    </div>
    <div class="mb-4">
        <label for="official_name" class="block text-lg font-medium">Nama Perpustakaan</label>
        <input type="text" name="official_name" id="official_name" value="<?php echo htmlspecialchars($user_data['official_name'] ?? ''); ?>" class="w-full p-3 mt-2 border border-gray-300 rounded-lg bg-white" placeholder="Masukkan nama perpustakaan">
    </div>
    <div class="mb-4">
        <label for="email" class="block text-lg font-medium">Email</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" class="w-full p-3 mt-2 border border-gray-300 rounded-lg bg-white" placeholder="Masukkan email">
    </div>
    <div class="mb-4">
        <label for="contact_number" class="block text-lg font-medium">Nomor Kontak</label>
        <input type="text" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($user_data['contact_number'] ?? ''); ?>" class="w-full p-3 mt-2 border border-gray-300 rounded-lg bg-white" placeholder="Masukkan nomor kontak">
    </div>
    <div class="mb-4">
        <label for="address" class="block text-lg font-medium">Alamat</label>
        <textarea name="address" id="address" class="w-full p-3 mt-2 border border-gray-300 rounded-lg bg-white" placeholder="Masukkan alamat"><?php echo htmlspecialchars($user_data['address'] ?? ''); ?></textarea>
    </div>
    <div class="mb-4">
        <label for="username" class="block text-lg font-medium">Username</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user_data['username'] ?? ''); ?>" class="w-full p-3 mt-2 border border-gray-300 rounded-lg bg-white" placeholder="Masukkan username">
    </div>
    <div class="mb-4">
        <label for="password" class="block text-lg font-medium">Kata Sandi Baru</label>
        <input type="password" name="password" id="password" class="w-full p-3 mt-2 border border-gray-300 rounded-lg bg-white" placeholder="Masukkan kata sandi baru">
    </div>
    <div class="mb-4">
        <label for="confirm_password" class="block text-lg font-medium">Konfirmasi Kata Sandi Baru</label>
        <input type="password" name="confirm_password" id="confirm_password" class="w-full p-3 mt-2 border border-gray-300 rounded-lg bg-white" placeholder="Konfirmasi kata sandi baru">
    </div>
    <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">Simpan</button>
    </div>
</div>
<?php if (!empty($message)): ?>
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

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
