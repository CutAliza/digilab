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

    <!-- Content -->
    <div class="max-w-3xl mx-auto mt-6 bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4"></h2>

     <!-- Create Feed Form -->
<form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
    <h3 class="text-md font-semibold">Tambah Feed Baru</h3>
    <!-- Gambar -->
    <div class="w-full bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center relative">
        <label for="feedPhoto" class="block w-full h-60 cursor-pointer flex items-center justify-center">
            <img id="previewFeed" src="#" alt="Preview" class="hidden w-full h-full object-cover">
            <i class="fas fa-camera text-gray-600 text-3xl"></i>
            <span class="absolute text-sm text-gray-600">Pilih Gambar</span>
        </label>
        <input type="file" name="feed_photo" id="feedPhoto" accept="image/*" class="hidden" onchange="previewFeedImage()" required>
    </div>
    <!-- Deskripsi -->
    <textarea name="description" rows="3" placeholder="Tambahkan deskripsi"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required></textarea>
    <button type="submit" name="create" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">Tambah</button>
</form>


<?function previewFeedImage() {
    const file = document.getElementById('feedPhoto').files[0];
    const preview = document.getElementById('previewFeed');
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
>?

        <!-- Feeds List -->
        <div class="mt-8">
            <h3 class="text-md font-semibold">Daftar Feeds</h3>
            <div class="space-y-4 mt-4">
                <?php
                $result = $conn->query("SELECT * FROM feeds ORDER BY created_at DESC");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="border rounded-lg p-4 flex items-start space-x-4">
                            <img src="uploads/feeds/' . htmlspecialchars($row['photo']) . '" alt="Feed" class="w-24 h-24 rounded-lg object-cover">
                            <div class="flex-1">
                                <p>' . htmlspecialchars($row['description']) . '</p>
                                <small class="text-gray-500">Diupload pada ' . $row['created_at'] . '</small>
                            </div>
                            <div class="flex space-x-2">
                                <form action="" method="POST" class="inline">
                                    <input type="hidden" name="id" value="' . $row['id'] . '">
                                    <button type="button" onclick="editFeed(' . htmlspecialchars(json_encode($row)) . ')" class="bg-yellow-500 text-white px-2 py-1 rounded-lg">Edit</button>
                                </form>
                                <form action="" method="POST" class="inline">
                                    <input type="hidden" name="id" value="' . $row['id'] . '">
                                    <button type="submit" name="delete" class="bg-red-600 text-white px-2 py-1 rounded-lg">Hapus</button>
                                </form>
                            </div>
                        </div>';
                    }
                } else {
                    echo "<p class='text-gray-600'>Belum ada feeds.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['create'])) {
        $description = $conn->real_escape_string($_POST['description']);
        $photo = $_FILES['feed_photo'];
    
        if ($photo && $photo['tmp_name']) {
            $uploadDir = "uploads/feeds/";
            $fileName = uniqid() . "_" . basename($photo['name']);
            $filePath = $uploadDir . $fileName;
    
            if (move_uploaded_file($photo['tmp_name'], $filePath)) {
                $insertQuery = "INSERT INTO feeds (photo, description) VALUES ('$fileName', '$description')";
                if ($conn->query($insertQuery)) {
                    echo "Feed berhasil ditambahkan!";
                } else {
                    echo "Gagal menambahkan feed: " . $conn->error;
                }
            } else {
                echo "Gagal mengupload gambar.";
            }
        }
    
        error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    }
    
    
    if (isset($_POST['update'])) {
        $id = intval($_POST['id']);
        $description = $conn->real_escape_string($_POST['description']);
        $photo = $_FILES['feed_photo'];
    
        $updateQuery = "UPDATE feeds SET description = '$description'";
        
        if ($photo && $photo['tmp_name']) {
            $uploadDir = "uploads/feeds/";
            $fileName = uniqid() . "_" . basename($photo['name']);
            $filePath = $uploadDir . $fileName;
    
            if (move_uploaded_file($photo['tmp_name'], $filePath)) {
                $updateQuery .= ", photo = '$fileName'";
            }
        }
    
        $updateQuery .= " WHERE id = $id";
    
        if ($conn->query($updateQuery)) {
            echo "Feed berhasil diperbarui!";
        } else {
            echo "Gagal memperbarui feed: " . $conn->error;
        }
    
        error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    }
    
    
    if (isset($_POST['delete'])) {
        $id = intval($_POST['id']);
    
        // Hapus file gambar jika ada
        $result = $conn->query("SELECT photo FROM feeds WHERE id = $id");
        if ($result && $row = $result->fetch_assoc()) {
            $photoPath = "uploads/feeds/" . $row['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
    
        $deleteQuery = "DELETE FROM feeds WHERE id = $id";
        if ($conn->query($deleteQuery)) {
            echo "Feed berhasil dihapus!";
        } else {
            echo "Gagal menghapus feed: " . $conn->error;
        }
    
        error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    }
    
    
    ?>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-md font-semibold mb-4">Edit Feed</h3>
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="id" id="editId">
                <textarea name="description" id="editDescription" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required></textarea>
                <div class="flex items-center space-x-4">
                    <div class="w-24 h-32 bg-gray-200 rounded-lg overflow-hidden">
                        <label for="editPhoto" class="block w-full h-full cursor-pointer">
                            <img id="editPreview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                        </label>
                        <input type="file" name="feed_photo" id="editPhoto" accept="image/*" class="hidden" onchange="previewEditImage()">
                    </div>
                </div>
                <button type="submit" name="update" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">Simpan</button>
                <button type="button" onclick="toggleEditModal(false)" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function previewFeedImage() {
            const file = document.getElementById('feedPhoto').files[0];
            const preview = document.getElementById('previewFeed');
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function previewEditImage() {
            const file = document.getElementById('editPhoto').files[0];
            const preview = document.getElementById('editPreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function editFeed(feed) {
            document.getElementById('editId').value = feed.id;
            document.getElementById('editDescription').value = feed.description;
            document.getElementById('editPreview').src = 'uploads/feeds/' + feed.photo;
            document.getElementById('editPreview').classList.remove('hidden');
            toggleEditModal(true);
        }

        function toggleEditModal(show) {
            const modal = document.getElementById('editModal');
            modal.classList.toggle('hidden', !show);
        }
    </script>

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
