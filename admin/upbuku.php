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
    $access = $_POST['access'];

    $sql = "INSERT INTO books (title, author, year_published, category, access) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $author, $year_published, $category, $access]);

    header('Location: index.php');
    exit();
}

// Handle Update Book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year_published = $_POST['year_published'];
    $category = $_POST['category'];
    $access = $_POST['access'];

    $sql = "UPDATE books SET title = ?, author = ?, year_published = ?, category = ?, access = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $author, $year_published, $category, $access, $id]);

    header('Location: index.php');
    exit();
}

// Handle Delete Book
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header('Location: index.php');
    exit();
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

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <a href="#" class="flex items-center">
            <img src="digilab_logo.png" alt="Logo" class="w-10 h-10">
        </a>
        <div class="flex space-x-6">
            <a href="index.php" class="hover:underline">Beranda</a>
            <a href="layanan.php" class="hover:underline">Layanan</a>
            <a href="download.php" class="hover:underline">Download</a>
            <a href="peminjaman.php" class="hover:underline">Peminjaman</a>
            <a href="pengembalian.php" class="hover:underline">Pengembalian</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-8 p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Dashboard Admin DigiLab</h1>

        <!-- Add or Edit Book Form -->
        <form action="index.php" method="POST" class="mb-6">
            <input type="hidden" name="id" value="<?= $bookToEdit['id'] ?? '' ?>">
            <input type="text" name="title" placeholder="Judul" value="<?= $bookToEdit['title'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
            <input type="text" name="author" placeholder="Pengarang" value="<?= $bookToEdit['author'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
            <input type="number" name="year_published" placeholder="Tahun Terbit" value="<?= $bookToEdit['year_published'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
            <input type="text" name="category" placeholder="Kategori" value="<?= $bookToEdit['category'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
            <input type="text" name="access" placeholder="Akses" value="<?= $bookToEdit['access'] ?? '' ?>" required class="border p-2 rounded mb-2 w-full">
            <button type="submit" name="action" value="<?= $bookToEdit ? 'update' : 'create' ?>" class="bg-blue-500 text-white p-2 rounded">
                <?= $bookToEdit ? 'Update Buku' : 'Tambah Buku' ?>
            </button>
        </form>

        <!-- Display Books -->
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">Judul</th>
                    <th class="py-2 px-4 border">Pengarang</th>
                    <th class="py-2 px-4 border">Tahun Terbit</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td class='py-2 px-4 border'><?= htmlspecialchars($book['title']) ?></td>
                        <td class='py-2 px-4 border'><?= htmlspecialchars($book['author']) ?></td>
                        <td class='py-2 px-4 border'><?= htmlspecialchars($book['year_published']) ?></td>
                        <td class='py-2 px-4 border'>
                            <a href="?action=edit&id=<?= $book['id'] ?>" class='text-blue-600'>Edit</a>
                            <a href="?action=delete&id=<?= $book['id'] ?>" class='text-red-600 ml-2' onclick="return confirm('Are you sure you want to delete this book?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
