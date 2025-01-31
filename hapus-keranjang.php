<?php
session_start();

// Periksa apakah ada data yang dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key'])) {
    $key = $_POST['key'];

    // Periksa apakah key valid
    if (isset($_SESSION['keranjang'][$key])) {
        // Hapus item dari keranjang
        unset($_SESSION['keranjang'][$key]);

        // Reset array untuk menjaga indeks tetap konsisten
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
    }
}

// Redirect kembali ke halaman checkout
header('Location: checkout.php');
exit();
?>
