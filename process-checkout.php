<?php
require 'koneksi.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_akun = $_POST['id_akun'];
    $kode_diskon = $_POST['kode_diskon'];
    $total_harga = $_POST['total_harga'];

    // Insert data ke tabel checkout
    $sql = "INSERT INTO checkout (id_akun, nama_produk, size, quantity, harga, created_at, id_produk, kode_diskon, nilai_diskon, jenis_diskon) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Loop untuk memasukkan setiap item di keranjang
    foreach ($_POST['produk'] as $produk) {
        // Ambil data produk dari form yang dikirim
        $nama_produk = $produk['nama_produk'];
        $size = $produk['size'];
        $quantity = $produk['quantity'];

        // Ambil harga produk dari database
        $product_sql = "SELECT harga, id_produk FROM produk WHERE nama_produk = ?";
        $product_stmt = $conn->prepare($product_sql);
        $product_stmt->bind_param("s", $nama_produk);
        $product_stmt->execute();
        $product_result = $product_stmt->get_result();
        $product = $product_result->fetch_assoc();

        // Pastikan produk ditemukan
        if ($product) {
            $harga = $product['harga'];
            $id_produk = $product['id_produk'];

            // Hitung harga total (harga * quantity)
            $harga_total = $harga * $quantity;

            // Menangani diskon jika ada
            $nilai_diskon = 0;
            $jenis_diskon = null;
            $harga_setelah_diskon = $harga_total; // Default harga setelah diskon

            if ($kode_diskon) {
                $diskon_sql = "SELECT * FROM diskon WHERE kode_diskon = ? AND status = 'ACTIVE' AND tanggal_mulai <= NOW() AND tanggal_berakhir >= NOW()";
                $diskon_stmt = $conn->prepare($diskon_sql);
                $diskon_stmt->bind_param("s", $kode_diskon);
                $diskon_stmt->execute();
                $diskon_result = $diskon_stmt->get_result();
                $diskon = $diskon_result->fetch_assoc();

                if ($diskon) {
                    $nilai_diskon = $diskon['nilai_diskon'];
                    $jenis_diskon = $diskon['jenis_diskon'];

                    // Hitung harga setelah diskon berdasarkan jenis diskon
                    if ($jenis_diskon === 'PERCENT') {
                        $harga_setelah_diskon = $harga_total - ($harga_total * $nilai_diskon / 100);
                    } elseif ($jenis_diskon === 'NOMINAL') {
                        $harga_setelah_diskon = $harga_total - $nilai_diskon;
                    }
                }
            }

            // Insert ke tabel checkout dengan harga setelah diskon
            $stmt->bind_param("ssssdsdss", $id_akun, $nama_produk, $size, $quantity, $harga_setelah_diskon, $id_produk, $kode_diskon, $nilai_diskon, $jenis_diskon);
            $stmt->execute();
        }
    }

    // Pengalihan ke halaman pesanan-saya.php setelah checkout berhasil
    header("Location: pesanan-saya.php");
    exit(); // Menghentikan eksekusi lebih lanjut
} else {
    echo "Tidak ada data yang dikirimkan.";
}
?>
