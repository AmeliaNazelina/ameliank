<?php
session_start();

$pageTitle = "VAMOUS";
require 'navbar-user.php'; // Memuat navbar

// Periksa apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $nama_produk = $_POST['nama_produk'] ?? '';
    $harga = $_POST['harga'] ?? 0;
    $size = $_POST['size'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;

    // Validasi data
    if (!empty($nama_produk) && !empty($size) && $harga > 0 && $quantity > 0) {
        // Siapkan data keranjang
        $item = [
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'size' => $size,
            'quantity' => $quantity,
        ];

        // Periksa apakah sesi keranjang sudah ada
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = []; // Jika belum ada, buat array keranjang
        }

        // Tambahkan produk ke keranjang
        $_SESSION['keranjang'][] = $item;

        // Tampilkan pesan dan arahkan setelah beberapa detik
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script>
                // Setelah 3 detik, lakukan redirect ke checkout.php
                setTimeout(function(){
                    window.location.href = "checkout.php";
                }, 3000); // 3000ms = 3 detik
            </script>
            <style>
                /* Styling khusus untuk pesan */
                .message-wrapper {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 60vh;
                    margin-top: 50px;
                    flex-direction: column;
                }
                .message {
                    text-align: center;
                    font-size: 24px;
                    font-weight: 400;
                    font-size: 12px;
                    padding: 20px;
                    background-color: black;
                    color: white;
                    border-radius: 0px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="message-wrapper">
                    <div class="message">
                        <p>Data berhasil disimpan ke keranjang, tunggu beberapa saat...</p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ';
        exit(); // Menghentikan eksekusi setelah menampilkan pesan
    } else {
        // Jika data tidak valid, arahkan kembali ke halaman produk dengan pesan error
        header('Location: produk.php?status=error');
        exit();
    }
} else {
    // Jika akses langsung, arahkan ke halaman produk
    header('Location: produk.php');
    exit();
}
?>
