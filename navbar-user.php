<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Icon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Poppins';
            z-index: 8;
            color: black;
        }
        .navbar {
            margin-top: 10px;
        }
        .navbar i {
            color: black;
        }
        .nav ul {
            font-size: 12px;
            margin-bottom: 15px;
        }
        .nav li a {
            color: black;
            font-weight: 300;
        }
        .nav-item .nav-link::after {
            color: rgba(0, 0, 0, 0.4); 
        }
        .nav-item:hover .nav-link,
        .nav-item.active .nav-link {
            color: rgba(0, 0, 0, 0.4); 
        }
        .dropdown-item.disabled {
            color: black !important;
            pointer-events: none;
            background-color: transparent !important;
        }
    </style>

    <body>
    <div class="container">
        <nav class="navbar">
            <div class="container d-flex justify-content-between align-items-center">
                <!-- Ikon Person di kiri -->
                <a href="akun.php" style="font-size: 30px;">
                    <i class="bi bi-person"></i>
                </a>
                
                <!-- Logo di tengah -->
                <a class="navbar-brand mx-auto" href="index.php">
                    <img src="img/logo1.png" alt="Logo" width="150" height="auto">
                </a>
                
                <!-- Ikon Cart di kanan -->
                <a href="keranjang-user.php" style="font-size: 30px;">
                    <i class="bi bi-cart2"></i>
                </a>
            </div>
        </nav>
    </div>
        <hr>

        <div class="navbar2">
        <div class="nav justify-content-center">
            <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="kontak-user.php">HUBUNGI KAMI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="lokasi-user.php">LOKASI TOKO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tentang-user.php">TENTANG KAMI</a>
            </li>
            </ul>
        </div>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    </html>