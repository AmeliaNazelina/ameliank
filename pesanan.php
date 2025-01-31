<?php
// Sertakan file koneksi.php
session_start();
$pageTitle = "VAMOUS";
require 'navbar-user.php';
require 'koneksi.php'; // Sesuaikan dengan lokasi file koneksi.php

// Ambil data pesanan yang sudah disimpan
$sql = "SELECT * FROM pesanan WHERE id_akun = '$_SESSION[id_akun]'"; // Sesuaikan query sesuai kebutuhan
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pesanan Anda</h2>
        
        <!-- Pesan berhasil diproses -->
        <div class="alert alert-success" role="alert">
            Pesanan berhasil diproses.
        </div>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>ID Pesanan:</strong> " . $row['id_pesanan'] . "</p>";
                echo "<p><strong>Nama Produk:</strong> " . $row['nama_produk'] . "</p>";
                echo "<p><strong>Size:</strong> " . $row['size'] . "</p>";
                echo "<p><strong>Stok Produk:</strong> " . $row['stok_produk'] . "</p>";
                echo "<p><strong>Harga:</strong> " . number_format($row['harga'], 2, ',', '.') . "</p>";
                echo "<p><strong>Quantity:</strong> " . $row['quantity'] . "</p>";
                echo "<p><strong>Total Harga:</strong> " . number_format($row['total_harga'], 2, ',', '.') . "</p>";
                echo "<p><strong>Status Pesanan:</strong> " . $row['status_pesanan'] . "</p>";
                echo "<p><strong>Kode Diskon:</strong> " . $row['kode_diskon'] . "</p>";
                echo "<p><strong>Nilai Diskon:</strong> " . number_format($row['nilai_diskon'], 2, ',', '.') . "</p>";
                echo "<p><strong>Total Harga Diskon:</strong> " . number_format($row['total_harga_diskon'], 2, ',', '.') . "</p>";
                echo "<p><strong>Tanggal Pemesanan:</strong> " . $row['created_at'] . "</p>";
                echo "<hr>"; // Pembatas antar pesanan
            }
        } else {
            echo "<p>Tidak ada data pesanan.</p>";
        }

        // Tutup koneksi (opsional jika menggunakan koneksi di koneksi.php)
        $conn->close();
        ?>
    </div>
</body>
</html>
