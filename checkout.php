<?php
$pageTitle = "VAMOUS";
require 'navbar-user.php';
include('koneksi.php'); 

// Mulai sesi dan cek apakah keranjang ada
session_start();
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = []; // Pastikan keranjang ada
}

$alamat = $_SESSION['alamat'];
$short_alamat = substr($alamat, 0, 15) . '...';

// Fungsi untuk menghapus produk berdasarkan index
if (isset($_GET['hapus'])) {
    $index_hapus = $_GET['hapus']; // Ambil index produk yang akan dihapus
    if (isset($_SESSION['keranjang'][$index_hapus])) {
        unset($_SESSION['keranjang'][$index_hapus]); // Hapus produk dari keranjang
        // Re-index array setelah menghapus item
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); 
    }

    // Jika keranjang kosong, arahkan ke halaman produk
    if (empty($_SESSION['keranjang'])) {
        header('Location: produk.php');
        exit();
    }
}

// Variabel awal
$diskon = null; // Untuk menyimpan data diskon
$harga_total = 0; // Total harga awal
$kode_diskon = ''; // Input kode diskon
$potongan_harga = 0; // Default potongan harga

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

<style>
    body {
        overflow-x: hidden;
    }
    .container-fluid {
        padding: 0px 30px;
    }
    img {
        border-radius: 10px;
    }
    .badge-container {
        position: relative;
        display: inline-block;
    }
    .badge-container .badge {
        position: absolute;
        top: -15px;
        right: -15px;
        font-size: 1.25rem;
        padding: 0.5em 0.8em;
    }
    input {
        border-radius: 0px !important;
        border-color: black !important;
    }
    .btn {
        background-color: black;
        border-radius: 0px;
        color: white;
        font-size: 12px;
        padding: 20px 30px;
    }
    .col-10 a {
        color: black;
        font-weight: 700;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3" style="font-weight: 700; font-size: 12px;">Alamat tujuan</div>
            <div class="col-2 mb-3" style="font-size: 50px;"><i class="bi bi-geo"></i></div>
            <div class="col-10 mb-3" style="text-align: right; font-size: 12px;"><?= $alamat; ?> <br><a href="alamat.php">ubah?</a></div>
            <br><br><hr>

            <?php
            // Periksa apakah ada produk di keranjang
            if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
                $total = 0; // Variabel untuk total harga
                foreach ($_SESSION['keranjang'] as $index => $item) {
                    // Ambil data produk dari keranjang
                    $nama_produk = $item['nama_produk'];
                    $harga = $item['harga'];
                    $size = $item['size'];
                    $quantity = $item['quantity'];
                    $subtotal = $harga * $quantity; // Menghitung subtotal per item

                    $total += $subtotal; // Menambahkan subtotal ke total

                    // Tampilkan produk yang ada di keranjang
                    echo '
                    <div class="col-4 mt-3">
                        <div class="badge-container">
                            <img src="img/produk.jpg" width="150px" height="auto">
                            <span class="badge rounded-pill bg-black">' . $quantity . '</span>
                        </div>
                    </div>
                    <div class="col-8 mt-3" style="text-align: right; padding-left: 40px;">
                        <p><strong>' . $nama_produk . '</strong></p>
                        <p>RP ' . number_format($harga, 0, ',', '.') . ' IDR - <strong>' . $size . '</strong></p>
                        <p><a href="checkout.php?hapus=' . $index . '" style="color: black; font-weight: 700;">Batalkan</a></p>
                    </div>';
                }
            }
            ?>

            <div class="col-12 mt-3">
                <form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="kode_diskon" class="form-control" placeholder="Kode diskon" id="discountCode" style="font-size: 12px;">
                    <button class="btn" type="submit" id="applyDiscount" name="apply_discount">PAKAI</button>
                </div>
                </form>
            </div>

            <?php if ($diskon): ?>
                <strong class="mt-3">Diskon pesanan</strong>
                <div class="col-6"><i class="bi bi-tags me-2"></i>Kode Diskon</div>
                <div class="col-6" style="text-align: right;"><strong><?php echo htmlspecialchars($diskon['kode_diskon']); ?></strong></div>
    
                <div class="col-6"><i class="bi bi-tags me-2"></i>Potongan harga</div>
                <div class="col-6" style="text-align: right;">Rp <?php echo number_format($potongan_harga, 0, ',', '.'); ?> </div>
                <div class="col-6"><i class="bi bi-tags me-2"></i>Besar potongan</div>
                <div class="col-6" style="text-align: right;"><?php echo htmlspecialchars($diskon['jenis_diskon'] === 'PERCENT' ? $diskon['nilai_diskon'] . '%' : 'Nominal'); ?></div>

                <div class="col-3 mt-3 mb-3" style="font-size: 25px;"><strong>TOTAL</strong></div>
                <div class="col-9 mt-3 mb-3" id="totalPrice" style="text-align: right;">
                <small class="me-2">IDR</small><strong style="font-size: 25px;">Rp <?php echo number_format($harga_total - $potongan_harga, 0, ',', '.'); ?></strong>
                </div>
            <?php else: ?>
                <div class="col-3 mt-3 mb-3" style="font-size: 25px;"><strong>TOTAL</strong></div>
                <div class="col-9 mt-3 mb-3" style="text-align: right;">
                <small class="me-2">IDR</small><strong style="font-size: 25px;">Rp <?php echo number_format($harga_total, 0, ',', '.'); ?></strong>
            </div>
            <?php endif; ?>
            <hr>
            
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
                <button type="submit" class="btn w-100 mt-3">Checkout</button>
            </form>
        </div>
    </div>
</body>