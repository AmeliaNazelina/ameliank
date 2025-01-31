<?php
$pageTitle = "VAMOUS";
require 'navbar.php';
?>

<style>
    body{
        overflow: hidden;
    }
    .container {
        text-align: center;
        color: black;
    }
    span {
        font-weight: 700;
    }
    .container p a {
        color: black;
        font-weight: 700;
    }
    .content {
        margin-top: 200px;
        margin-bottom: 200px;
    }
</style>

<body>
    <div class="container">
        <div class="content">
    <h1><span>Oops</span>, anda belum memiliki akun <img src="img/logo1.png" width="110px" height="auto"></h1>
    <p><a href="login.php">login</a> atau <a href="registrasi.php">buat akun</a> sekarang!</p></div>
    </div>

    <?php require 'footer.php'; ?>
</body>