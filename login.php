<?php
$pageTitle = "VAMOUS";
require 'navbar.php';
require 'koneksi.php';

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa data login
    $sql = "SELECT id_akun, email, nama_depan, nama_belakang, sandi, role, dibuat_pada, alamat FROM akun WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        // Cek apakah email ada di database
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_akun, $db_email, $nama_depan, $nama_belakang, $db_password, $role, $dibuat_pada, $alamat);
            $stmt->fetch();

            // Verifikasi password
            if ($password === $db_password) {  // Pengecekan langsung password tanpa hashing
                // Menyimpan data ke session setelah login berhasil
                session_start();
                $_SESSION['id_akun'] = $id_akun;
                $_SESSION['email'] = $db_email;
                $_SESSION['nama_depan'] = $nama_depan;
                $_SESSION['nama_belakang'] = $nama_belakang;
                $_SESSION['dibuat_pada'] = $dibuat_pada;
                $_SESSION['alamat'] = $alamat;
                $_SESSION['role'] = $role;  // Menyimpan role pengguna

                // Redirect ke halaman setelah login (misalnya dashboard)
                header("Location: beranda-user.php");
                exit();
            } else {
                // Jika password salah
                $message = "Email atau password salah!";
                $alertType = "danger";
            }
        } else {
            // Jika email tidak ditemukan
            $message = "Email tidak terdaftar!";
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
        color: black;
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
            <h2 class="text-center mb-4">LOGIN</h2>

            <!-- Menampilkan pesan alert jika ada -->
            <?php if (!empty($message)) : ?>
                <div class="alert alert-<?= $alertType; ?> alert-dismissible fade show" role="alert">
                    <?= $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Sandi" required>
                </div>
                <div class="mb-3">
                    <a href="#">Lupa sandi?</a>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn">Masuk</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="register.php">Buat Akun</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
    require 'footer.php';
?>