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
    <title>Koleksi</title>
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
    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold mb-6">Koleksi Perpustakaan</h2>

        <!-- Perpustakaan Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Perpustakaan 1 -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800">ITB Library</h3>
                    <p class="text-gray-600 mb-4">Koleksi unggulan dari Perpustakaan Pusat.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <img src="book1.jpg" alt="Buku 1" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 1: Fiksi Modern</p>
                        </div>
                        <div class="">
                            <img src="book2.jpg" alt="Buku 2" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 2: Teknik Mesin</p>
                        </div>
                        <div class="">
                            <img src="book3.jpg" alt="Buku 3" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 3: Sejarah Dunia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perpustakaan 2 -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800">UPI Central Library</h3>
                    <p class="text-gray-600 mb-4">Koleksi populer dari Perpustakaan Kota.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <img src="book4.jpg" alt="Buku 4" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 4: Seni Digital</p>
                        </div>
                        <div class="">
                            <img src="book5.jpg" alt="Buku 5" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 5: Biografi</p>
                        </div>
                        <div class="">
                            <img src="book6.jpg" alt="Buku 6" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 6: Karya Sastra</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perpustakaan 3 -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800">Open Library Telkom University</h3>
                    <p class="text-gray-600 mb-4">Koleksi akademik terbaik dari Perpustakaan Kampus.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <img src="book7.jpg" alt="Buku 7" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 7: Fisika Kuantum</p>
                        </div>
                        <div class="">
                            <img src="book8.jpg" alt="Buku 8" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 8: Ekonomi Mikro</p>
                        </div>
                        <div class="">
                            <img src="book9.jpg" alt="Buku 9" class="w-full h-40 object-cover rounded">
                            <p class="text-sm font-medium mt-2 text-gray-700">Buku 9: Statistika</p>
                        </div>
                    </div>
                </div>
            </div>
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
</body>
</html>
