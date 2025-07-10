<?php
require 'koneksi.php';
$start = $_GET['start'] ?? date('Y-m-d');
$end   = $_GET['end']   ?? date('Y-m-d');

// Query data tamu berdasarkan range tanggal
$res = $conn->query("SELECT * FROM data_tamu
  WHERE DATE(timestamp) BETWEEN '$start' AND '$end' ORDER BY timestamp");

// Header agar file bisa diunduh sebagai Excel
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=export_tamu_{$start}_to_{$end}.csv");

// Buka stream output ke browser
$output = fopen("php://output", "w");

// Tulis header kolom
fputcsv($output, [
  "Timestamp", "Nama Tamu", "Perusahaan", "Alamat", "Unit", "Pegawai",
  "APD", "Keperluan", "KTP", "Kendaraan", "NameTag", "Jumlah",
  "Induksi", "Link Foto", "Status", "Jam Checkout"
]);

// Loop data dan tulis baris-barisnya
while ($r = $res->fetch_assoc()) {
  fputcsv($output, [
    $r['timestamp'],
    $r['nama_tamu'],
    $r['perusahaan'],
    $r['alamat'],
    $r['unit'],
    $r['pegawai'],
    $r['apd'],
    $r['keperluan'],
    $r['ktp'],
    $r['kendaraan'],
    $r['name_tag'],
    $r['jumlah'],
    $r['induksi'],
    $r['link_foto'],
    $r['status'],
    $r['jam_checkout']
  ]);
}

fclose($output);
exit;
?>
