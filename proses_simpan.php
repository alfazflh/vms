<?php
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta'); // Pastikan waktu pakai WIB

$namaTamu     = $_POST['namaTamu'];
$perusahaan   = $_POST['perusahaan'];
$alamat       = $_POST['alamat'];
$unit         = $_POST['unit'];
$pegawai      = $_POST['pegawai'];
$apd          = isset($_POST['apd']) ? implode(", ", $_POST['apd']) : "";
$keperluan    = $_POST['keperluan'];
$ktp          = $_POST['ktp'];
$kendaraan    = $_POST['kendaraan'];
$nameTag      = $_POST['nameTag'];
$jumlahTamu   = $_POST['jumlahTamu'];
$induksi      = $_POST['induction'];
$timestamp    = date("Y-m-d H:i:s"); // Jam sesuai WIB
$status       = "check-in";

// ============ UPLOAD FOTO ============
$targetDir  = "uploads/";
$link_foto  = ""; // Default kosong

if (isset($_FILES['fotoInput']) && $_FILES['fotoInput']['error'] === UPLOAD_ERR_OK) {
    $foto       = $_FILES['fotoInput'];
    $ext        = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $fotoName   = time() . "_" . uniqid() . "." . $ext;
    $targetFile = $targetDir . $fotoName;

    if (move_uploaded_file($foto["tmp_name"], $targetFile)) {
        $link_foto = $targetFile; // Simpan path jika sukses
    } else {
        echo "Upload foto gagal!";
        exit;
    }
} else {
    echo "Tidak ada foto yang dikirim.";
    exit;
}
// ======================================

// ============ SIMPAN DATABASE =========
$sql = "INSERT INTO data_tamu (
  nama_tamu, perusahaan, alamat, unit, pegawai, apd, keperluan,
  ktp, kendaraan, name_tag, jumlah, induksi, link_foto, timestamp, status
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssissss",
  $namaTamu, $perusahaan, $alamat, $unit, $pegawai, $apd, $keperluan,
  $ktp, $kendaraan, $nameTag, $jumlahTamu, $induksi, $link_foto, $timestamp, $status);

if ($stmt->execute()) {
  echo "<script>window.location.href='registrasi.php';</script>";
} else {
  echo "Gagal menyimpan data: " . $stmt->error;
}
?>
