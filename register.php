<?php
$pageTitle = "VAMOUS";
require 'navbar.php';
require 'koneksi.php';

// Variabel untuk pesan alert
$message = "";
$alertType = ""; // success atau danger

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Nilai default untuk role
    $role = "user";

    // Query untuk menyimpan data ke tabel akun
    $sql = "INSERT INTO akun (nama_depan, nama_belakang, email, sandi, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $nama_depan, $nama_belakang, $email, $password, $role);
        if ($stmt->execute()) {
            // Jika berhasil, alihkan ke halaman login
            header("Location: login.php");
            exit;
        } else {
            // Jika gagal, tampilkan pesan kesalahan
            $message = "Terjadi kesalahan: " . $stmt->error;
            $alertType = "danger";
        }
        $stmt->close();
    } else {
        $message = "Terjadi kesalahan pada server.";
        $alertType = "danger";
    }
}
?>

<style>
    .card {
        margin-top: -200px;
        border: none;
    }
    .card h2 {
        font-weight: 700;
    }
    .btn {
        background-color: black;
        color: white;
        border-radius: 0px;
    }
    .nav {
        display: none;
    }
    a {
        color: black;
        font-size: 12px;
    }
    .form-control {
        border-radius: 0 !important;
        border-color: #000 !important;
        color: #000;
        font-size: 12px;
        padding: 15px;
    }
    footer {
        margin-top: -200px;
    }
    .btn {
        padding: 10px 40px;
    }
</style>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4" style="width: 500px;">
            <h2 class="text-center mb-4">BUAT AKUN</h2>

             <!-- Tampilkan alert jika ada pesan -->
            <?php if (!empty($message)) : ?>
                <div class="alert alert-<?= $alertType; ?> alert-dismissible fade show" role="alert">
                    <?= $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" name="nama_depan" placeholder="Nama depan" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="nama_belakang" placeholder="Nama belakang" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Sandi" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn">Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>