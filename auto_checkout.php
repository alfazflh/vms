<?php
include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu ke WIB

// Update semua tamu yang statusnya masih "check-in" pada hari ini
$sql = "UPDATE data_tamu 
        SET status = 'check-out', jam_checkout = NOW()
        WHERE status = 'check-in' AND DATE(timestamp) = CURDATE()";

if ($conn->query($sql) === TRUE) {
    echo "Auto checkout berhasil dijalankan.";
} else {
    echo "Gagal auto checkout: " . $conn->error;
}

$conn->close();
?>
