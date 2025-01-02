<?php
session_start();

// Security check for admin login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "digilab";

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Get current user data
$current_user = [
    'username' => $_SESSION['username'] ?? 'Guest',
    'email' => $_SESSION['user_email'] ?? 'Email tidak tersedia',
    'img' => $_SESSION['img'] ?? 'default-profile.png'
];

// Fetch admin data
$adminQuery = "SELECT id_admin, official_name, institution_origin, email, username, logo_image FROM admin";
$adminResult = $conn->query($adminQuery);
$adminData = [];

if ($adminResult && $adminResult->num_rows > 0) {
    while ($row = $adminResult->fetch_assoc()) {
        $adminData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History denda - admin</title>
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


        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8 flex-grow">
            <h2 class="text-2xl font-semibold mb-6">History Denda Pengembalian Buku</h2>

            <div class="bg-white shadow-md rounded-lg p-6">
                <table class="min-w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">Buku</th>
                            <th class="px-6 py-3">Pengguna</th>
                            <th class="px-6 py-3">Jumlah Denda</th>
                            <th class="px-6 py-3">Tanggal Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data dari database akan ditampilkan di sini -->
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Fiksi</td>
                            <td class="px-6 py-4">John</td>
                            <td class="px-6 py-4 text-red-500">Rp 10.000</td>
                            <td class="px-6 py-4">15-12-2024 10:00</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Dongeng</td>
                            <td class="px-6 py-4">Liza</td>
                            <td class="px-6 py-4 text-red-500">Rp 15.000</td>
                            <td class="px-6 py-4">16-12-2024 14:30</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Ilmiah</td>
                            <td class="px-6 py-4">Mey</td>
                            <td class="px-6 py-4 text-red-500">Rp 10.000</td>
                            <td class="px-6 py-4">15-12-2024 10:00</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Sistem Informasi</td>
                            <td class="px-6 py-4">Fikri</td>
                            <td class="px-6 py-4 text-red-500">Rp 15.000</td>
                            <td class="px-6 py-4">16-12-2024 14:30</td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">Buku Bahasa Inggris</td>
                            <td class="px-6 py-4">Alice</td>
                            <td class="px-6 py-4 text-red-500">Rp 15.000</td>
                            <td class="px-6 py-4">16-12-2024 14:30</td>
                        </tr>
                        <!-- Tambahkan lebih banyak data sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
            <p class="mt-2 text-lg">Platform inovatif untuk mengakses koleksi buku secara online dengan mudah.</p>
            <p class="text-sm mt-4">&copy; 2024 DIGILAB. All rights reserved.</p>
        </div>
    </footer>
    </div>
</body>
</html>
