<?php
$pageTitle = "VAMOUS";
require 'navbar-user.php';
require 'koneksi.php';

session_start();

// Periksa apakah session sudah memiliki data yang diperlukan
if (!isset($_SESSION['nama_depan']) || !isset($_SESSION['nama_belakang']) || !isset($_SESSION['email']) || !isset($_SESSION['dibuat_pada']) || !isset($_SESSION['alamat'])) {
    // Redirect ke halaman login jika data tidak ada
    header('Location: login.php');
    exit();
}

// Menggabungkan nama_depan dan nama_belakang untuk membuat nama_lengkap
$nama_lengkap = $_SESSION['nama_depan'] . ' ' . $_SESSION['nama_belakang'];
$nama_depan = $_SESSION['nama_depan'];
$nama_belakang = $_SESSION['nama_belakang'];
$email = $_SESSION['email'];
$dibuat_pada = $_SESSION['dibuat_pada'];
$alamat = $_SESSION['alamat'];

$short_email = substr($email, 0, 5) . '...';
$short_alamat = substr($alamat, 0, 5) . '...';
?>


<style>
    body {
        overflow: hidden;
    }
    .nav {
        display: none;
    }
    .circle {
        background-color: black;
        padding: 110px;
        border-radius: 0px 0px 50px 50px;
        margin-top: -20px;
        z-index: -2;
    }
    p {
        color: white;
        margin-top: -180px;
        margin-bottom: 50px;
    }
    .content {
        background-color: white;
        margin-left: 20px;
        margin-right: 20px;
        padding: 30px;
        color: black;
        border-radius: 25px;
        margin-top: 50px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        margin-bottom: 40px;
    }
    .content a {
        font-weight: 700;
        text-decoration: none;
        color: black;
    }
</style>

<body>
    <div class="circle">
        <br>
    </div>
    <div>
        <p class="text-center">Hai, <strong><?= $nama_lengkap; ?></strong>! <br> <a href="pesanan-saya.php" style="color: white; text-align: center; font-weight: 400;"><small>Pesanan saya</small></a></p>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-6">Nama Lengkap</div>
                <div class="col-6" style="text-align: right;"><?= $nama_lengkap; ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">Alamat</div>
                <div class="col-6" style="text-align: right;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?= $alamat; ?>"><?= $short_alamat; ?> <a href="alamat.php"><u>Edit</u></a></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">Email</div>
                <div class="col-6" style="text-align: right;" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="<?= $email; ?>"><?= $short_email; ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">Dibuat Pada</div>
                <div class="col-6" style="text-align: right;"><?= $dibuat_pada; ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6" style="text-align: right;"><a href="login.php">Keluar</a></div>
            </div>
        </div>
    </div>
</body>

<?php require 'footer.php'; ?>

<script>
    // Inisialisasi Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
