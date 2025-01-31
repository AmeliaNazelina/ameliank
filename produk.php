<?php
$pageTitle = "VAMOUS";
require 'navbar-user.php';
require 'koneksi.php';

// Periksa koneksi database
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Amankan variabel id_produk
$id_produk = 1; // Ganti dengan id_produk yang diinginkan

// Debug: Cek struktur tabel produk
// echo "Debug: Query to check structure: DESCRIBE produk;";

// Gunakan prepared statement
$stmt = $conn->prepare("SELECT id_produk, nama_produk, harga_produk FROM produk WHERE id_produk = ?");
if (!$stmt) {
    die("Prepare statement gagal: " . $conn->error);
}

// Bind parameter dan eksekusi
$stmt->bind_param("i", $id_produk); // "i" untuk integer
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ditemukan
if ($result && $result->num_rows > 0) {
    // Ambil data produk
    $row = $result->fetch_assoc();
    $id_produk = $row['id_produk'];
    $nama_produk = $row['nama_produk'];
    $harga_produk = $row['harga_produk'];
} else {
    $nama_produk = "Produk tidak ditemukan";
    $harga_produk = "-";
}
?>




<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
    }
    .content {
        position: relative;
        background-color: white;
        padding: 30px;
        margin-top: -170px; 
        z-index: 1; 
        border-radius: 40px 40px 0px 0px;
    }
    .img {
        display: flex;
        justify-content: center; /* Posisikan secara horizontal */
        align-items: center; /* Posisikan secara vertikal */
        height: 70vh; /* Tinggi layar penuh */
        overflow: hidden; /* Hindari scroll jika gambar lebih besar */
        }
    .img img {
        width: 100%; /* Lebar mengikuti layar */
        height: 100%; /* Tinggi mengikuti layar */
        object-fit: cover; /* Pastikan gambar memenuhi layar tanpa merusak aspek rasio */
        object-position: center; /* Posisikan gambar di tengah */
        }
    h3 {
        font-weight: 700;
    }
    .btn {
        background-color: white;
        color: black;
        border: 1;
        border-color: rgba(0, 0, 0, 0.2);
    }
    .btn-check:checked + .btn {
        background-color: black;
        color: white;
    }
    .btn-check:not(:checked) + .btn:hover {
        border-color: rgba(0, 0, 0, 0.2);
        outline: none;
        box-shadow: none;
    }
    .btn-check:not(:checked) + .btn {
        border-color: rgba(0, 0, 0, 0.2);
        color: black;
    }
</style>

<body>
    <div class="img">
        <img src="img/produk.jpg" alt="Produk">
    </div>

    <div class="content">
        <h3><?php echo $nama_produk; ?></h3>
        <small>RP <?php echo number_format($harga_produk, 0, ',', '.'); ?>,00 IDR</small>
        <br>
        
        <form method="POST" action="simpan-keranjang.php">
            <!-- Nama Produk -->
            <input type="hidden" name="nama_produk" value="<?php echo $nama_produk; ?>">
            <input type="hidden" name="harga_produk" value="<?php echo $harga_produk; ?>">

            <!-- Pilihan Ukuran -->
            <div class="btn-group w-100 mt-3 mb-3" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="size" id="btnradio1" value="S" autocomplete="off" checked>
                <label class="btn" for="btnradio1">S</label>

                <input type="radio" class="btn-check" name="size" id="btnradio2" value="M" autocomplete="off">
                <label class="btn" for="btnradio2">M</label>

                <input type="radio" class="btn-check" name="size" id="btnradio3" value="L" autocomplete="off">
                <label class="btn" for="btnradio3">L</label>

                <input type="radio" class="btn-check" name="size" id="btnradio4" value="XL" autocomplete="off">
                <label class="btn" for="btnradio4">XL</label>
            </div>

            <!-- Jumlah Produk -->
             <div class="row g-2">
                <div class="col-5">
                    <div class="input-group">
                        <button class="btn btn-outline-secondary" type="button" id="decrement">-</button>
                        <input type="text" class="form-control text-center" id="quantity" name="quantity" value="1" readonly>
                        <button class="btn btn-outline-secondary me-2" type="button" id="increment">+</button>
                    </div>
                </div>
                <div class="col-7">
                    <div class="button">
                        <!-- Tombol submit langsung mengarah ke simpan-keranjang.php -->
                        <button type="submit" name="add_to_cart" class="btn w-100"><i class="bi bi-cart2"></i> KERANJANG</button>
                     </div>
                </div>
             </div>
            
            <script>
                const decrementButton = document.getElementById('decrement');
                const incrementButton = document.getElementById('increment');
                const quantityInput = document.getElementById('quantity');

                decrementButton.addEventListener('click', () => {
                    let currentValue = parseInt(quantityInput.value);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });

                incrementButton.addEventListener('click', () => {
                    let currentValue = parseInt(quantityInput.value);
                    quantityInput.value = currentValue + 1;
                });
            </script>
            <br>
        </form>
    </div>
</body>
