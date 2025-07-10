<?php
include 'koneksi.php';
$id = intval($_POST['id']);
$stmt = $conn->prepare("UPDATE data_tamu SET status='check-out', jam_checkout=NOW() WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
?>
