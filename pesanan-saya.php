<?php
$pageTitle = "VAMOUS";
require 'navbar-user.php';
require 'koneksi.php';

session_start();
$id_akun = $_SESSION['id_akun']; // atau metode lain untuk mendapatkan id_akun

// Menggabungkan nama_depan dan nama_belakang untuk membuat nama_lengkap
$nama_lengkap = $_SESSION['nama_depan'] . ' ' . $_SESSION['nama_belakang'];
$nama_depan = $_SESSION['nama_depan'];
$nama_belakang = $_SESSION['nama_belakang'];
$email = $_SESSION['email'];
$dibuat_pada = $_SESSION['dibuat_pada'];
$alamat = $_SESSION['alamat'];

$short_email = substr($email, 0, 5) . '...';
$no_hp = substr($alamat, -12);

// Query pertama untuk mengambil data dari tabel checkout
$sql_checkout = "SELECT id_checkout, id_akun, nama_produk, size, quantity, harga, created_at, id_produk, nilai_diskon, jenis_diskon FROM checkout";
$result_checkout = $conn->query($sql_checkout);

// Mengecek apakah ada data yang ditemukan
if ($result_checkout->num_rows > 0) {
    // Mengambil satu baris data dari tabel checkout
    $data_checkout = $result_checkout->fetch_assoc();
    $id_checkout = $data_checkout['id_checkout'];
    $id_akun = $data_checkout['id_akun'];
    $nama_produk = $data_checkout['nama_produk'];
    $size = $data_checkout['size'];
    $quantity = $data_checkout['quantity'];
    $harga = $data_checkout['harga'];
    $created_at = $data_checkout['created_at'];
    $id_produk = $data_checkout['id_produk'];
    
    $sql_diskon = "SELECT d.kode_diskon, d.nilai_diskon, d.jenis_diskon
                FROM diskon d
                JOIN checkout c ON d.nilai_diskon = c.nilai_diskon
                WHERE c.id_akun = '$id_akun'"; // Pastikan ada ID akun untuk kondisi spesifik

    $result_diskon = $conn->query($sql_diskon);

    if ($result_diskon->num_rows > 0) {
        // Mengambil satu baris data dari tabel diskon
        $data_diskon = $result_diskon->fetch_assoc();
        $kode_diskon = $data_diskon['kode_diskon'];
        $nilai_diskon = $data_diskon['nilai_diskon'];
        $jenis_diskon = $data_diskon['jenis_diskon'];
    } else {
        // Jika tidak ada data diskon yang sesuai
        $kode_diskon = "Tidak ada diskon";
        $nilai_diskon = "N/A"; // Nilai default jika tidak ada diskon
        $jenis_diskon = "N/A"; // Nilai default jika tidak ada diskon
    }

    // Query ketiga untuk mendapatkan harga normal dari tabel produk berdasarkan id_produk
    $sql_produk = "SELECT harga FROM produk WHERE id_produk = '$id_produk'";
    $result_produk = $conn->query($sql_produk);

    if ($result_produk->num_rows > 0) {
        // Mengambil harga dari tabel produk
        $data_produk = $result_produk->fetch_assoc();
        $harga_normal = $data_produk['harga'];
    } else {
        // Jika tidak ada harga yang ditemukan
        $harga_normal = "Harga tidak ditemukan";
    }
    
    // Menghitung potongan harga berdasarkan jenis diskon
    if (is_numeric($harga_normal) && is_numeric($nilai_diskon)) {
        if ($jenis_diskon == 'PERCENT') {
            // Potongan harga berdasarkan persentase
            $potongan_harga = ($harga_normal * $nilai_diskon / 100);
        } else {
            // Potongan harga dalam bentuk nominal
            $potongan_harga = $nilai_diskon;
        }
    } else {
        // Jika harga atau diskon tidak valid, anggap tidak ada potongan
        $potongan_harga = 0;
    }

    // Menghitung total akhir
    if (is_numeric($harga_normal) && is_numeric($potongan_harga)) {
        $total_akhir = $harga_normal - $potongan_harga;
    } else {
        $total_akhir = 0; // Jika salah satu atau keduanya bukan angka, anggap total akhir 0
    }
    
} else {
    // Jika tidak ada data checkout
    echo "Tidak ada data checkout.";
}

$conn->close();
?>

<style>
    .nav {
        display: none;
    }
    .square {
        background-image: linear-gradient(135deg, rgba(128, 128, 128, 1) -200%, rgba(0, 0, 0, 1) 100%);
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 130px;
        margin-top: -20px;
    }
    .card {
        background-color: white;
        color: black;
        border-color: white;
        border-radius: 15px;
        padding: 20px;
    }
    .row p {
        margin-bottom: -5px;
        font-weight: 700;
        color: black;
    }
    .row small {
        color: rgba(0, 0, 0, 0.7);
        font-size: 12px;
    }
    .btn {
        color: black;
        background-color: rgba(0, 0, 0, 0.1);
        font-size: 12px;
        padding: 8px 30px;
        border-radius: 10px;
    }
    h6 {
        font-weight: 400;
        font-size: 12px;
    }
    .col-5 {
        text-align: right;
    }
    .container-fluid {
        margin-top: -190px;
        padding: 0px 30px;
    }
    h3 {
        color: white;
        font-weight: 600;
        text-align: center;
        margin-top: -30px;
        margin-bottom: 60px;
    }
    .row .col-6 {
        color: white;
        font-size: 10px;
        margin-bottom: 10px;
    }
    img {
        border-radius: 10px;
    }
    .button {
        background-image: linear-gradient(135deg, rgba(128, 128, 128, 1) -200%, rgba(0, 0, 0, 1) 100%);
        color: white; 
        padding: 10px 20px; 
        margin: 0; 
        border-radius: 0 0 15px 15px; 
        font-size: 12px; 
        width: calc(100% + 40px); 
        margin-left: -20px; 
        margin-right: -20px;
        margin-bottom: -20px;
        margin-top: -20px; 
        box-sizing: border-box;
        font-weight: 300;
    }
    .total {
        background-image: linear-gradient(135deg, rgba(128, 128, 128, 1) -200%, rgba(0, 0, 0, 1) 100%);
        color: white; 
        padding: 20px 20px; 
        margin: 0; 
        border-radius: 0; 
        font-weight: 700;
        width: calc(100% + 40px); 
        margin-left: -20px; 
        margin-right: -20px;
        margin-bottom: -20px;
        margin-top: -20px; 
        box-sizing: border-box;
    }
    .total .col-6 {
        font-size: 20px;
    }
    .validation {
        text-align: center;
        font-weight: 700;
        color: black;
    }
</style>

<body>
    <div style="background-color: #ededed; height: 135vh;">
    <div class="square"><br></div>
    <div class="container-fluid">
    <h3>Pesanan Saya</h3>
    <div class="row">
        <div class="col-6" style="color: rgba(255, 255, 255, 0.4);"><i class="bi bi-geo-alt-fill me-1"></i>Alamat pesanan</div>
        <div class="col-6" style="text-align: right; font-size: 10px;"><a href="alamat.php" style="color: white;">Ganti ke alamat lain?</a></div>
    </div>
    <div class="card mb-4">
        <div class="row">
            <div class="col-7">
                <p><?= $nama_lengkap; ?></p>
                <small><?= $no_hp; ?></small>
            </div>
            <div class="col-5">
                <a href="#" class="btn">Rumah</a>
            </div>
        </div>
        <hr>
        <h6><?= $alamat; ?></h6>
    </div>

    <div class="row">
        <div class="col-6" style="color: rgba(0, 0, 0, 0.4);"><i class="bi bi-box-fill me-1"></i>Produk pesanan</div>
    </div>
    <div class="card mb-4">
        <div class="row">
            <div class="col-7">
                <p><img src="img/logo1.png" alt="" width="90px" height="auto"></p>
            </div>
            <div class="col-5">
                <small><strong><?php setlocale(LC_TIME, 'id_ID.UTF-8'); echo strftime('%B'); ?></strong> Edition</small>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-4">
                <img src="img/produk.jpg" alt="" width="100px" height="auto">
            </div>
            <div class="col-6" style="font-size: 12px;">
                <p class="mb-1"><?= $nama_produk; ?></p>
                <small><?= $harga; ?></small>
                <p class="mt-1"><?= $size; ?></p>
            </div>
            <div class="col-2">
                <p>x<?= $quantity; ?></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6" style="color: rgba(0, 0, 0, 0.4);"><i class="bi bi-tags-fill me-2"></i>Voucher</div>
    </div>
    <div class="card mb-4">
        <div class="row g-5">
            <div class="col-2">
                <p><img src="img/voucher.jpg" alt="" width="50px" height="auto" style="border-radius: 0px;"></p>
            </div>
            <div class="col-10">
                <p style="font-size: 20px;"><?= $kode_diskon; ?></p>
                <small>Potongan harga sebesar <?= number_format($nilai_diskon, 2); ?>%</small>
            </div>
        </div>
        <div class="button text-center mt-4">Batalkan menggunakan voucher?</div>
    </div>

    <div class="row">
        <div class="col-6" style="color: rgba(0, 0, 0, 0.4);"><i class="bi bi-wallet me-2"></i>Detail Pembayaran</div>
    </div>
    <div class="card mb-4">
        <table>
            <tr>
                <td>Subtotal Produk</td>
                <td style="text-align: right;">Rp <?= number_format($harga_normal, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Potongan Diskon</td>
                <td style="text-align: right;"><?= number_format($potongan_harga, 0, ',', '.'); ?></td>
            </tr>
        </table>
        <div class="total mt-4">
            <div class="row">
                <div class="col-6">TOTAL</div>
                <div class="col-6" style="text-align: right;">Rp <?= number_format($total_akhir, 0, ',', '.'); ?> <small style="font-weight: 400; color: white;">IDR</small></div>
            </div>
        </div>
    </div>
    <a href="pesanan.php" class="mt-2 validation" onclick="clearCart()"><p class="text-center">Konfirmasi Pesanan</p></a>
    </div>
    </div>
</body>

<script>
function clearCart() {
    // Misalkan array cart ada di localStorage
    localStorage.removeItem('cartData');
}
</script>