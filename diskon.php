<?php
if (isset($_POST['discountCode'])) {
    $kode_diskon = $_POST['discountCode'];

    // Cek apakah kode diskon valid
    $query = "SELECT * FROM diskon WHERE kode_diskon = ? AND status = 'ACTIVE' AND tanggal_mulai <= NOW() AND tanggal_berakhir >= NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kode_diskon);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $diskon = $result->fetch_assoc();
        // Kirim data diskon ke frontend
        echo json_encode([
            'status' => 'success',
            'jenis_diskon' => $diskon['jenis_diskon'],
            'nilai_diskon' => $diskon['nilai_diskon']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Kode diskon tidak valid.']);
    }
}
?>
