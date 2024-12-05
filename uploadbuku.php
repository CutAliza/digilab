<?php
// Database connection
$host = 'localhost'; // Your database host
$db = 'digilab'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle Create Book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year_published = $_POST['year_published'];
    $category = $_POST['category'];
    $access = $_POST['access']; // Ensure the correct input name is used
    $synopsis = $_POST['synopsis']; // Add synopsis
    $image = $_FILES['image']['name'] ?? null;

    // Upload image to the server
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // File uploaded successfully
        } else {
            echo "Error uploading file.";
        }
    }

    // Insert query
    $sql = "INSERT INTO books (title, author, year_published, category, access, synopsis, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$title, $author, $year_published, $category, $access, $synopsis, $image]);
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Display error message
    }
}

// Handle Update Book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year_published = $_POST['year_published'];
    $category = $_POST['category'];
    $access = $_POST['access']; // Ensure the correct input name is used
    $synopsis = $_POST['synopsis']; // Add synopsis
    $image = $_FILES['image']['name'] ?? null;

    // Upload new image if provided
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "File uploaded: " . $target_file; // Debugging line
        } else {
            echo "Error uploading file.";
        }
    } else {
        // Keep existing image if no new image is uploaded
        $stmt = $pdo->prepare("SELECT image FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $existingImage = $stmt->fetchColumn();
        $image = $existingImage; // Use existing image
    }

    $sql = "UPDATE books SET title = ?, author = ?, year_published = ?, category = ?, access = ?, synopsis = ?, image = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$title, $author, $year_published, $category, $access, $synopsis, $image, $id]);
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Display error message
    }
}

// Handle Delete Book
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$id]);
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Display error message
    }
}

// Read Books
$sql = "SELECT * FROM books";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if we are editing a book
$bookToEdit = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $bookToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin - DigiLab</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
    <a href="#" class="flex items-center">
        <img src="digilab logo.png" alt="Logo" class="w-10 h-10">
    </a>
    <div class="flex space-x-6">
        <a href="index.php" class="hover:underline">Dashboard</a>
        <a href="manage_books.php" class="hover:underline">Kelola Buku</a>
        <a href="manage_users.php" class="hover:underline">Kelola Pengguna</a>
    </div>
</nav>




    <!-- Main Content -->
    <div class="container mx-auto mt-8 p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Upload Buku</h1>

        <!-- Add or Edit Book Form -->
        <form action="index.php" method="POST" enctype="multipart/form-data" class="mb-6">
            <input type="hidden" name="id" value="<?= $bookToEdit['id'] ?? '' ?>">
            <input type="text" name="title" placeholder="Judul" value="<?= $bookToEdit['title'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
            <input type="text" name="author" placeholder="Pengarang" value="<?= $bookToEdit['author'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
            <input type="number" name="year_published" placeholder="Tahun Terbit" value="<?= $bookToEdit['year_published'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
            <input type="text" name="category" placeholder="Kategori" value="<?= $bookToEdit['category'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">

            <label for="synopsis" class="block text-gray-700 mt-4">Sinopsis</label>
            <textarea name="synopsis" id="synopsis" placeholder="Sinopsis" required class="border p-2 rounded mb-2 w-full"><?= $bookToEdit['synopsis'] ?? '' ?></textarea>

            <label class="block text-gray-700 mt-4">Akses</label>
            <div class="flex space-x-4 mt-1">
                <label class="inline-flex items-center">
                    <input type="radio" name="access" class="form-radio text-gray-600" value="baca_online" <?= (isset($bookToEdit['access']) && $bookToEdit['access'] == 'baca_online') ? 'checked' : '' ?>>
                    <span class="ml-2 text-gray-700">Baca Online</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="access" class="form-radio text-gray-600" value="download" <?= (isset($bookToEdit['access']) && $bookToEdit['access'] == 'download') ? 'checked' : '' ?>>
                    <span class="ml-2 text-gray-700">Download</span>
                </label>
            </div>

            <input type="file" name="image" accept="image/*" class="border p-2 rounded mt-4 mb-2">
            <button type="submit" name="action" value="<?= $bookToEdit ? 'update' : 'create' ?>" class="bg-blue-500 text-white py-2 px-4 rounded mt-4 hover:bg-blue-600">
                <?= $bookToEdit ? 'Update Buku' : 'Tambah Buku' ?>
            </button>
        </form>

        <!-- Display Books -->
        <h2 class="text-xl font-semibold mb-4">Daftar Buku</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Judul</th>
                    <th class="py-2 px-4 border-b">Pengarang</th>
                    <th class="py-2 px-4 border-b">Tahun Terbit</th>
                    <th class="py-2 px-4 border-b">Kategori</th>
                    <th class="py-2 px-4 border-b">Akses</th>
                    <th class="py-2 px-4 border-b">Sinopsis</th>
                    <th class="py-2 px-4 border-b">Gambar</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['title']) ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['author']) ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['year_published']) ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['category']) ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['access']) ?></td>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['synopsis']) ?></td>
                        <td class="py-2 px-4 border-b">
                            <?php if ($book['image']): ?>
                                <img src="uploads/<?= htmlspecialchars($book['image']) ?>" alt="Book Image" class="w-16 h-16 object-cover">
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="index.php?action=edit&id=<?= $book['id'] ?>" class="text-blue-500">Edit</a>
                            <a href="index.php?action=delete&id=<?= $book['id'] ?>" class="text-red-500" onclick="return confirm('Are you sure you want to delete this book?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
