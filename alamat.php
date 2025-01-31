<?php
$pageTitle = "VAMOUZ";
require 'navbar-user.php';
include('koneksi.php'); 

// Variabel untuk status alert
$alertMessage = '';
$alertClass = '';

// Pastikan session sudah dimulai
session_start();

// Ambil id pengguna yang sedang login dari session
$userId = $_SESSION['id_akun'] ?? null; // Sesuaikan dengan cara kamu menyimpan user_id

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form menggunakan $_POST
    $negara = isset($_POST['negara']) ? $_POST['negara'] : '';
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    $kecamatan = isset($_POST['kecamatan']) ? $_POST['kecamatan'] : '';
    $kota = isset($_POST['kota']) ? $_POST['kota'] : '';
    $provinsi = isset($_POST['provinsi']) ? $_POST['provinsi'] : '';
    $kodePos = isset($_POST['kode_pos']) ? $_POST['kode_pos'] : '';
    $noHp = isset($_POST['no_hp']) ? $_POST['no_hp'] : '';

    // Pastikan user_id valid
    if ($userId) {
        // Membuat alamat lengkap
        $alamatLengkap = "$negara, $alamat, $kecamatan, $kota, $provinsi, $kodePos, No HP: $noHp";
        
        // Query untuk memperbarui alamat pengguna
        $sql = "UPDATE akun SET alamat = '$alamatLengkap' WHERE id_akun = '$userId'";

        if (mysqli_query($conn, $sql)) {
            // Jika sukses, set pesan alert
            $alertMessage = 'Alamat berhasil diperbarui!';
            $alertClass = 'alert-success'; // Kelas Bootstrap untuk alert sukses
        } else {
            // Jika gagal, set pesan alert error
            $alertMessage = 'Terjadi kesalahan saat memperbarui alamat!';
            $alertClass = 'alert-danger'; // Kelas Bootstrap untuk alert error
        }
    } else {
        $alertMessage = 'ID pengguna tidak valid!';
        $alertClass = 'alert-danger'; // Kelas Bootstrap untuk alert error
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .form-select {
        border-radius: 0 !important;
        border-color: #000 !important;
        color: #000;
        font-size: 12px;
        padding: 15px;
        box-shadow: none;
    }
    .form-select:focus {
        box-shadow: none;
    }
    .form-control {
        border-radius: 0 !important;
        border-color: #000 !important;
        color: #000;
        font-size: 12px;
        padding: 15px;
    }
    .btn {
        background-color: black;
        color: white;
        border-radius: 0px;
        font-size: 12px;
        padding: 10px;
    }
    label {
        color: black;
        font-size: 12px;
    }
    .alert {
        color: white;
        border-radius: 0 !important;
        border-color: #000 !important;
        background-color: black;
        font-size: 12px;
    }
</style>
<body>
    <div class="container">
    <?php if ($alertMessage): ?>
        <div class="alert <?php echo $alertClass; ?> mt-3" role="alert">
            <?php echo $alertMessage; ?>
        </div>
    <?php endif; ?>`

    <form class="row g-3 needs-validation" novalidate method="POST">
                <div class="col-md-4 position-relative">
                    <label for="negara" class="form-label">Negara/Wilayah</label>
                    <select class="form-select" id="negara" name="negara" required>
                        <option selected disabled value="">Pilih Negara/Wilayah...</option>
                        <?php
                        // Array berisi daftar negara
                        $countries = [
                            "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", 
                            "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", 
                            "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", 
                            "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", 
                            "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", 
                            "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", 
                            "Congo (Congo-Brazzaville)", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia", 
                            "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", 
                            "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini (fmr. Swaziland)", 
                            "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", 
                            "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", 
                            "Haiti", "Holy See", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", 
                            "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", 
                            "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", 
                            "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", 
                            "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", 
                            "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", 
                            "Morocco", "Mozambique", "Myanmar (Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", 
                            "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", 
                            "Norway", "Oman", "Pakistan", "Palau", "Palestine State", "Panama", "Papua New Guinea", 
                            "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", 
                            "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", 
                            "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", 
                            "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", 
                            "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", 
                            "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan", "Tanzania", "Thailand", 
                            "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", 
                            "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", 
                            "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
                        ];

                        // Loop untuk membuat opsi
                        foreach ($countries as $country) {
                            echo "<option value=\"$country\">$country</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-tooltip">Silakan pilih negara/wilayah yang valid.</div>
                </div>
                <div class="col-md-8 position-relative">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                    <div class="invalid-tooltip">Alamat diperlukan.</div>
                </div>
                <div class="col-md-6 position-relative">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                    <div class="invalid-tooltip">Kecamatan diperlukan.</div>
                </div>
                <div class="col-md-6 position-relative">
                    <label for="kota" class="form-label">Kabupaten/Kota</label>
                    <input type="text" class="form-control" id="kota" name="kota" required>
                    <div class="invalid-tooltip">Kota diperlukan.</div>
                </div>
                <div class="col-md-6 position-relative">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                    <div class="invalid-tooltip">Provinsi diperlukan.</div>
                </div>
                <div class="col-md-6 position-relative">
                    <label for="kodePos" class="form-label">Kode Pos</label>
                    <input type="text" class="form-control" id="kodePos" name="kode_pos" required>
                    <div class="invalid-tooltip">Kode pos diperlukan.</div>
                </div>
                <div class="col-md-12 position-relative">
                    <label for="noHp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="noHp" name="no_hp" required>
                    <div class="invalid-tooltip">No HP diperlukan.</div>
                </div>
                <div class="col-12 mb-3">
                    <button class="btn" type="submit">Simpan Alamat</button>
                    <a href="akun.php" class="btn">Kembali</a>
                </div>
                </form>
    </div>
</body>
</html>

<?php require 'footer.php'; ?>