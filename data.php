<?php
include 'koneksi.php';

$start = $_GET['start'] ?? date('Y-m-d');
$end = $_GET['end'] ?? date('Y-m-d');

$result = $conn->query("
  SELECT * FROM data_tamu 
  WHERE DATE(timestamp) BETWEEN '$start' AND '$end'
  ORDER BY timestamp DESC
");

$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
