<?php
$pageTitle = "VAMOUS";
require 'navbar-user.php';

session_start();

// Menggabungkan nama_depan dan nama_belakang untuk membuat nama_lengkap
$nama_lengkap = $_SESSION['nama_depan'] . ' ' . $_SESSION['nama_belakang'];
$email = $_SESSION['email'];
?>

<style>
    @media screen and (max-width: 828px) {
            .form-group {
                margin-bottom: 15px;
            }
        }
        form {
            padding-left: 20px;
            padding-right: 20px;
        }
        h2 {
            font-weight: 700;
        }
        .form-group label {
            font-size: 12px;
        }
        input {
            border-radius: 0% !important;
            border-color: black !important;
        }
        textarea {
            border-radius: 0% !important;
            border-color: black !important;
        }
        .btn {
            border-radius: 0%;
            background-color: black;
            color: white;
        }
</style>

<body>
<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Apa yang bisa <br> kami bantu?</h2>
    <form>
        <!-- Baris pertama -->
        <div class="row">
            <div class="form-group col-6">
                <label for="fullname">Nama Lengkap</label>
                <input type="text" class="form-control" id="fullname" value="<?= $nama_lengkap; ?>" style="font-size: 12px; padding: 20px;" readonly>
            </div>
            <div class="form-group col-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" value="<?= $email; ?>" style="font-size: 12px; padding: 20px;" readonly>
            </div>
        </div>
        <!-- Baris kedua -->
        <div class="row">
            <div class="form-group col-12">
                <label for="message">Pesan</label>
                <textarea class="form-control" id="message" rows="4" style="font-size: 12px; padding: 20px;"></textarea>
            </div>
        </div>
        <button type="submit" class="btn">Kirim</button>
    </form>
</div>
</body>
<?php require 'footer.php'; ?>