<?php
$pageTitle = "VAMOUS";
session_start();
require 'navbar-user.php';
require 'koneksi.php'; // File koneksi database

$pageTitle = "Checkout";

// Variabel awal
$diskon = null; // Untuk menyimpan data diskon
$harga_total = 0; // Total harga awal
$kode_diskon = ''; // Input kode diskon
$potongan_harga = 0; // Default potongan harga

// Hitung total harga awal dari keranjang
if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
    foreach ($_SESSION['keranjang'] as $item) {
        $harga_total += $item['harga'] * $item['quantity'];
    }
}

// Proses form diskon
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kode_diskon'])) {
    $kode_diskon = trim($_POST['kode_diskon']);

    // Validasi kode diskon di database
    $sql = "SELECT * FROM diskon WHERE kode_diskon = ? AND status = 'ACTIVE' AND tanggal_mulai <= NOW() AND tanggal_berakhir >= NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kode_diskon);
    $stmt->execute();
    $result = $stmt->get_result();
    $diskon = $result->fetch_assoc();

    // Jika diskon ditemukan, hitung potongan harga
    if ($diskon) {
        if ($diskon['jenis_diskon'] === 'PERCENT') {
            $potongan_harga = ($harga_total * $diskon['nilai_diskon']) / 100;
        } elseif ($diskon['jenis_diskon'] === 'NOMINAL') {
            $potongan_harga = $diskon['nilai_diskon'];
        }
    }
}
?>

<body>
<div class="container mt-5">
    <h2>Checkout</h2>
    <table class="table">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0): ?>
            <?php foreach ($_SESSION['keranjang'] as $key => $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nama_produk']); ?></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($item['size']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>Rp <?php echo number_format($item['harga'] * $item['quantity'], 0, ',', '.'); ?></td>
                    <td>
                        <!-- Tombol Hapus -->
                        <form action="hapus-keranjang.php" method="POST" style="display:inline;">
                            <input type="hidden" name="key" value="<?php echo $key; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Keranjang kosong</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    <h4>Total Harga: Rp <?php echo number_format($harga_total, 0, ',', '.'); ?></h4>

    <?php if ($diskon): ?>
        <div class="card">
            <p>Kode Diskon: <strong><?php echo htmlspecialchars($diskon['kode_diskon']); ?></strong></p>
            <p>Deskripsi: <?php echo htmlspecialchars($diskon['deskripsi']); ?></p>
            <p>Potongan: Rp <?php echo number_format($potongan_harga, 0, ',', '.'); ?> 
                (<?php echo htmlspecialchars($diskon['jenis_diskon'] === 'PERCENT' ? $diskon['nilai_diskon'] . '%' : 'Nominal'); ?>)</p>
            <h4>Total Setelah Diskon: Rp <?php echo number_format($harga_total - $potongan_harga, 0, ',', '.'); ?></h4>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="kode_diskon">Masukkan Kode Diskon:</label>
            <input type="text" class="form-control" id="kode_diskon" name="kode_diskon" placeholder="Kode Diskon" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Terapkan Diskon</button>
    </form>

    
<form action="process-checkout.php" method="POST">
        <!-- Hidden Fields -->
        <input type="hidden" name="id_akun" value="<?php echo $_SESSION['id_akun']; ?>">
        <input type="hidden" name="kode_diskon" value="<?php echo $kode_diskon; ?>">
        <input type="hidden" name="total_harga" value="<?php echo $harga_total - $potongan_harga; ?>">

        <!-- Looping untuk mengambil setiap produk di keranjang dan mengurangi stok -->
        <?php foreach ($_SESSION['keranjang'] as $item): ?>
            <?php
            // Ambil data stok berdasarkan produk dan size yang dipilih
            $sql = "SELECT * FROM stok WHERE size = ? AND id_produk = (SELECT id_produk FROM produk WHERE nama_produk = ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $item['size'], $item['nama_produk']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stok = $result->fetch_assoc();

            // Jika stok ditemukan, kurangi jumlahnya
            if ($stok) {
                $stok_baru = $stok['stok_produk'] - $item['quantity'];
                // Update stok di database
                $update_sql = "UPDATE stok SET stok_produk   = ? WHERE id_produk = (SELECT id_produk FROM produk WHERE nama_produk = ?) AND size = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("iss", $stok_baru, $item['nama_produk'], $item['size']);
                $update_stmt->execute();
            }
            ?>
            <!-- Hidden Fields untuk masing-masing item -->
            <input type="hidden" name="produk[<?php echo $item['nama_produk']; ?>][nama_produk]" value="<?php echo $item['nama_produk']; ?>">
            <input type="hidden" name="produk[<?php echo $item['nama_produk']; ?>][size]" value="<?php echo $item['size']; ?>">
            <input type="hidden" name="produk[<?php echo $item['nama_produk']; ?>][quantity]" value="<?php echo $item['quantity']; ?>">
        <?php endforeach; ?>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100 mt-4">Checkout</button>
    </form>
</div>
</body>
</html>
