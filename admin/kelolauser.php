<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Perpustakaan Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Pengguna - Perpustakaan Online</h1>
            <p class="text-gray-600">Dikelola oleh Admin</p>
        </div>

        <!-- Kelola Komentar -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Kelola Komentar Buku</h2>
            <div class="bg-white p-4 rounded shadow">
                <table class="table-auto w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Nama Pengguna</th>
                            <th class="px-4 py-2">Komentar</th>
                            <th class="px-4 py-2">Judul Buku</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $comments = [
                            ['id' => 1, 'user_name' => 'Alice', 'comment' => 'Buku ini sangat membantu.', 'book_title' => 'Pemrograman PHP'],
                            ['id' => 2, 'user_name' => 'Bob', 'comment' => 'Ceritanya menarik!', 'book_title' => 'Seni Berbicara'],
                            ['id' => 3, 'user_name' => 'Charlie', 'comment' => 'Buku ini sulit dipahami.', 'book_title' => 'Matematika Lanjut'],
                        ];
                        foreach ($comments as $comment): ?>
                            <tr class="border-t">
                                <td class="px-4 py-2"><?= $comment['id'] ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($comment['user_name']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($comment['comment']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($comment['book_title']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Pinjaman Buku Melebihi Batas Waktu -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Pinjaman Buku Melebihi Batas Waktu</h2>
            <div class="bg-white p-4 rounded shadow">
                <table class="table-auto w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Nama Pengguna</th>
                            <th class="px-4 py-2">Judul Buku</th>
                            <th class="px-4 py-2">Tanggal Peminjaman</th>
                            <th class="px-4 py-2">Tanggal Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $overdueBooks = [
                            ['id' => 1, 'user_name' => 'Diana', 'book_title' => 'Dasar Pemrograman', 'borrow_date' => '2024-11-15', 'due_date' => '2024-12-01'],
                            ['id' => 2, 'user_name' => 'Evan', 'book_title' => 'Belajar Python', 'borrow_date' => '2024-11-20', 'due_date' => '2024-12-05'],
                        ];
                        foreach ($overdueBooks as $loan): ?>
                            <tr class="border-t">
                                <td class="px-4 py-2"><?= $loan['id'] ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($loan['user_name']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($loan['book_title']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($loan['borrow_date']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($loan['due_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Riwayat Pembayaran Denda -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Riwayat Pembayaran Denda</h2>
            <div class="bg-white p-4 rounded shadow">
                <table class="table-auto w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Nama Pengguna</th>
                            <th class="px-4 py-2">Judul Buku</th>
                            <th class="px-4 py-2">Jumlah Denda</th>
                            <th class="px-4 py-2">Tanggal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $finePayments = [
                            ['id' => 1, 'user_name' => 'Fiona', 'book_title' => 'Dasar HTML', 'fine_amount' => 15000, 'payment_date' => '2024-12-10'],
                            ['id' => 2, 'user_name' => 'George', 'book_title' => 'Algoritma Dasar', 'fine_amount' => 10000, 'payment_date' => '2024-12-12'],
                        ];
                        foreach ($finePayments as $payment): ?>
                            <tr class="border-t">
                                <td class="px-4 py-2"><?= $payment['id'] ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($payment['user_name']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($payment['book_title']) ?></td>
                                <td class="px-4 py-2">Rp<?= number_format($payment['fine_amount'], 0, ',', '.') ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($payment['payment_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
