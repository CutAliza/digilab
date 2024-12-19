<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "digilab");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CREATE
    if (isset($_POST['create'])) {
        $description = $conn->real_escape_string($_POST['description']);
        $targetDir = "uploads/feeds/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $photoName = basename($_FILES["feed_photo"]["name"]);
        $targetFile = $targetDir . $photoName;
        if (move_uploaded_file($_FILES["feed_photo"]["tmp_name"], $targetFile)) {
            $sql = "INSERT INTO feeds (photo, description) VALUES ('$photoName', '$description')";
            $conn->query($sql);
        }
    }

    // UPDATE
    if (isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $description = $conn->real_escape_string($_POST['description']);
        $photoUpdate = '';

        if (!empty($_FILES["feed_photo"]["name"])) {
            $targetDir = "uploads/feeds/";
            $photoName = basename($_FILES["feed_photo"]["name"]);
            $targetFile = $targetDir . $photoName;
            if (move_uploaded_file($_FILES["feed_photo"]["tmp_name"], $targetFile)) {
                $photoUpdate = ", photo='$photoName'";
            }
        }

        $sql = "UPDATE feeds SET description='$description' $photoUpdate WHERE id=$id";
        $conn->query($sql);
    }

    // DELETE
    if (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $result = $conn->query("SELECT photo FROM feeds WHERE id=$id");
        $row = $result->fetch_assoc();
        if ($row && file_exists("uploads/feeds/" . $row['photo'])) {
            unlink("uploads/feeds/" . $row['photo']);
        }
        $conn->query("DELETE FROM feeds WHERE id=$id");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Feeds</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

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

    <!-- Content -->
    <div class="max-w-3xl mx-auto mt-6 bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4"></h2>

        <!-- Create Feed -->
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <h3 class="text-md font-semibold">Tambah Feed Baru</h3>
            <div class="flex items-center space-x-4">
                <div class="w-24 h-32 bg-gray-200 rounded-lg overflow-hidden">
                    <label for="feedPhoto" class="block w-full h-full cursor-pointer">
                        <img id="previewFeed" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                    </label>
                    <input type="file" name="feed_photo" id="feedPhoto" accept="image/*" class="hidden" onchange="previewFeedImage()" required>
                </div>
                <textarea name="description" rows="3" placeholder="Tambahkan deskripsi"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required></textarea>
            </div>
            <button type="submit" name="create" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">Tambah</button>
        </form>

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
