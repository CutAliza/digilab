<?php
session_start();

// Security check for admin login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

// Koneksi database
$host = 'localhost'; // Host database
$db = 'digilab'; // Nama database
$user = 'root'; // Username
$pass = ''; // Password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Get current user data
$current_user = [
    'username' => $_SESSION['username'] ?? 'Guest',
    'email' => $_SESSION['user_email'] ?? 'Email tidak tersedia',
    'img' => $_SESSION['img'] ?? 'default-profile.png'
];

// Handle Create, Update, Delete Buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $year_published = $_POST['year_published'] ?? '';
    $category = $_POST['category'] ?? '';
    $jenis_buku = $_POST['jenis_buku'] ?? '';
    $kota = $_POST['kota'] ?? '';
    $synopsis = $_POST['synopsis'] ?? '';
    $image = $_FILES['image']['name'] ?? null;

    // Handle image upload
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "Error uploading file.";
            $image = null; // Prevent saving an invalid image
        }
    } elseif ($id) {
        // If no new image and updating, get the current image
        $stmt = $pdo->prepare("SELECT image FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetchColumn();
    }

    if (isset($_POST['action']) && $_POST['action'] == 'update' && $id) {
        // Update existing book
        $sql = "UPDATE books SET title = ?, author = ?, publisher = ?, year_published = ?, category = ?, jenis_buku = ?, kota = ?, synopsis = ?, image = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$title, $author, $publisher, $year_published, $category, $jenis_buku, $kota, $synopsis, $image, $id]);
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'create') {
        // Insert new book
        $sql = "INSERT INTO books (title, author, publisher, year_published, category, jenis_buku, kota, synopsis, image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$title, $author, $publisher, $year_published, $category, $jenis_buku, $kota, $synopsis, $image]);
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Handle Delete Buku
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$id]);
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Ambil data buku
$sql = "SELECT * FROM books";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if we're editing a book
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $bookToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DIGILAB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 50;
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
            transform-origin: top right;
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }

        .dropdown-menu.show {
            opacity: 1;
            transform: scale(1);
            pointer-events: auto;
        }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <a href="beranda.php" class="flex items-center gap-2">
                <img src="digilab logo.png" alt="DIGILAB" class="h-8 w-auto">
            </a>

            <div class="flex items-center gap-8">
                <a href="berandaa.php" class="hover:text-blue-200 transition font-bold">Beranda</a>
                <a href="koleksi.php" class="hover:text-blue-200 transition">Koleksi</a>
                <a href="kelolapengguna.php" class="hover:text-blue-200 transition">Kelola Pengguna</a>
                <a href="historydenda.php" class="hover:text-blue-200 transition">Laporan</a>

                <div class="relative" id="profileDropdown">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-3 bg-white text-gray-800 px-4 py-2 rounded-full hover:bg-gray-50 transition">
                        <img src="<?php echo htmlspecialchars($current_user['img']); ?>" 
                             alt="Profile" 
                             class="w-8 h-8 rounded-full object-cover">
                        <span class="font-medium"><?php echo htmlspecialchars($current_user['username']); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div id="dropdownMenu" class="dropdown-menu hide absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl text-gray-800 overflow-hidden">
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
                    </div>
                </div>
            </div>
        </div>
    </nav>

<div class="container mx-auto mt-8 p-6 px-4 py-8 bg-white rounded shadow">
    <h1 class="text-2xl font-semibold mb-4"><?= isset($bookToEdit) ? 'Edit Buku' : 'Tambah Buku' ?></h1>

<form action="index.php" method="POST" enctype="multipart/form-data" class="mb-6">
    <input type="hidden" name="id" value="<?= $bookToEdit['id'] ?? '' ?>">

    <input type="text" name="title" placeholder="Judul" value="<?= $bookToEdit['title'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
    <input type="text" name="author" placeholder="Pengarang" value="<?= $bookToEdit['author'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
    <input type="text" name="publisher" placeholder="Penerbit" value="<?= $bookToEdit['publisher'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
    <input type="number" name="year_published" placeholder="Tahun Terbit" value="<?= $bookToEdit['year_published'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">

    <label for="category" class="block text-gray-700 mt-4">Kategori</label>
    <select name="category" id="category" required class="border p-2 rounded mb-2 w-full">
        <option value="">Pilih Kategori</option>
        <option value="Pendidikan" <?= isset($bookToEdit['category']) && $bookToEdit['category'] === 'Pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
        <option value="Non Fiksi" <?= isset($bookToEdit['category']) && $bookToEdit['category'] === 'Non Fiksi' ? 'selected' : '' ?>>Non Fiksi</option>
        <option value="Fiksi" <?= isset($bookToEdit['category']) && $bookToEdit['category'] === 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
        <option value="Teknologi" <?= isset($bookToEdit['category']) && $bookToEdit['category'] === 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
        <option value="Sains" <?= isset($bookToEdit['category']) && $bookToEdit['category'] === 'Sains' ? 'selected' : '' ?>>Sains</option>
    </select>

    <label for="jenis_buku" class="block text-gray-700 mt-4">Jenis Buku</label>
    <input type="text" name="jenis_buku" placeholder="Jenis Buku" value="<?= $bookToEdit['jenis_buku'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">

    <label for="kota" class="block text-gray-700 mt-4">Kota</label>
    <input type="text" name="kota" placeholder="Kota" value="<?= $bookToEdit['kota'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">

    <textarea name="synopsis" placeholder="Sinopsis" required class="border p-2 rounded mb-2 w-full"><?= $bookToEdit['synopsis'] ?? '' ?></textarea>

    <input type="file" name="image" accept="image/*" class="border p-2 rounded mt-4 mb-2">
    <button type="submit" name="action" value="<?= isset($bookToEdit) ? 'update' : 'create' ?>" class="bg-blue-500 text-white py-2 px-4 rounded mt-4 hover:bg-blue-600">
        <?= isset($bookToEdit) ? 'Update Buku' : 'Tambah Buku' ?>
    </button>
</form>

<table class="min-w-full bg-white border border-gray-200">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b">Gambar</th>
            <th class="py-2 px-4 border-b">Judul</th>
            <th class="py-2 px-4 border-b">Pengarang</th>
            <th class="py-2 px-4 border-b">Penerbit</th>
            <th class="py-2 px-4 border-b">Tahun Terbit</th>
            <th class="py-2 px-4 border-b">Kategori</th>
            <th class="py-2 px-4 border-b">Jenis Buku</th>
            <th class="py-2 px-4 border-b">Kota</th> <!-- Add image column -->
            <th class="py-2 px-4 border-b">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
            <td class="py-2 px-4 border-b">
                    <?php if (!empty($book['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($book['image']) ?>" alt="Book Image" class="w-16 h-16 object-cover">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['title']) ?></td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['author']) ?></td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['publisher']) ?></td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['year_published']) ?></td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['category']) ?></td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['jenis_buku']) ?></td>
                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['kota']) ?></td>
                <td class="py-2 px-4 border-b">
                    <a href="index.php?action=edit&id=<?= $book['id'] ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                    <a href="index.php?action=delete&id=<?= $book['id'] ?>" class="text-red-500 hover:text-red-700">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

<script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('show');
    }
</script>
</body>
</html>
