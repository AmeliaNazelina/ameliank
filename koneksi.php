<?php
$host = "localhost"; // Ganti sesuai konfigurasi server
$user = "root";      // Ganti dengan username database Anda
$password = "";      // Ganti dengan password database Anda
$database = "vamous"; // Nama database

// Buat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
