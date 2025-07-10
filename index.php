<?php
include 'koneksi.php';

$start = $_GET['start'] ?? date('Y-m-d');
$end   = $_GET['end'] ?? date('Y-m-d');

$sqlTotal = "SELECT SUM(jumlah) as total FROM data_tamu WHERE DATE(timestamp) = CURDATE()";
$sqlCheckin = "SELECT SUM(jumlah) as checkin FROM data_tamu WHERE DATE(timestamp) = CURDATE() AND status = 'check-in'";
$sqlCheckout = "SELECT SUM(jumlah) as checkout FROM data_tamu WHERE DATE(timestamp) = CURDATE() AND status = 'check-out'";

$total = $conn->query($sqlTotal)->fetch_assoc()['total'] ?? 0;
$checkIn = $conn->query($sqlCheckin)->fetch_assoc()['checkin'] ?? 0;
$checkOut = $conn->query($sqlCheckout)->fetch_assoc()['checkout'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM data_tamu WHERE DATE(timestamp) BETWEEN ? AND ? ORDER BY timestamp DESC");
$stmt->bind_param("ss", $start, $end);
$stmt->execute();
$dataTamu = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Visitor Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_PLN.png" rel="icon" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: url('https://ik.imagekit.io/pln/background.jpeg?updatedAt=1751940305910') no-repeat center center fixed;
      background-size: cover;
    }

    .navbar {
      display: flex; justify-content: space-between; align-items: center;
      padding: 10px 30px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      position: sticky; top: 0; z-index: 999;
    }
    .navbar-logo { display: flex; align-items: center; }
    .navbar-logo img { height: 40px; margin-right: 10px; }
    .navbar-menu { display: flex; gap: 30px; font-weight: 600; }
    .navbar-menu a { text-decoration: none; color: #000; }
    .navbar-menu a.active { color: #196275; border-bottom: 2px solid #196275; }
    .burger { display: none; flex-direction: column; cursor: pointer; }
    .burger span { height: 3px; background: #000; margin: 4px; width: 25px; }

    .container {
      max-width: 1200px; margin: 40px auto; background: white;
      border-radius: 8px; padding: 30px;
      box-shadow: 0 19px 41px rgba(0,0,0,0.1);
    }

    .cards {
      display: flex; justify-content: space-between; gap: 20px; margin-bottom: 30px;
    }
    .card {
      flex: 1; background: #f8f8f8; border: 1px solid #ccc;
      border-radius: 8px; padding: 20px; text-align: center;
    }
    .card h1 { margin: 0; font-size: 32px; color: #196275; }
    .card p { margin: 5px 0 0; font-size: 14px; color: #444; }

    .filter-section { display: flex; gap: 20px; align-items: center; margin-bottom: 20px; }
    .filter-section input {
      padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;
    }
    .export-btn {
      padding: 8px 16px; background: #196275; color: white;
      border: none; border-radius: 4px; cursor: pointer;
    }

    table {
      width: 100%; border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd; padding: 10px; text-align: left;
    }
    th { background-color: #196275; color: white; }

    .btn-detail {
      background-color: #196275; color: white;
      border: none; padding: 6px 12px; border-radius: 4px;
      cursor: pointer;
    }

    .modal {
      display: none; position: fixed; z-index: 9999; left: 0; top: 0;
      width: 100%; height: 100%; overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
      background-color: #fff; margin: 10% auto; padding: 20px;
      border: 1px solid #888; width: 90%; max-width: 400px;
      border-radius: 8px;
    }

.modal-content {
  font-family: 'Poppins', sans-serif;
  background: #fff;
  border-radius: 16px;
  padding: 30px;
  max-width: 700px;
  margin: 40px auto;
  box-shadow: 0 0 40px rgba(0,0,0,0.2);
  position: relative;
}

.modal-content h2 {
  text-align: center;
  color: #196275;
  font-size: 24px;
  margin-bottom: 30px;
}

.detail-header {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 24px;
}

.detail-header img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 12px;
  border: 3px solid #196275;
}

.detail-header .info {
  flex: 1;
}

.detail-header .info h3 {
  font-size: 20px;
  margin: 0;
  color: #333;
}

.detail-header .info p {
  margin: 6px 0 0;
  color: #555;
  font-size: 14px;
}

.detail-header .status {
  text-align: right;
  font-size: 14px;
  color: #777;
}

.detail-header .status strong {
  color: #196275;
  font-size: 15px;
}

.section-title {
  font-weight: 600;
  color: #196275;
  font-size: 16px;
  margin: 30px 0 10px;
  border-bottom: 1px solid #ddd;
  padding-bottom: 6px;
}

.info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.info-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 16px;
}

.icon-wrap {
  width: 28px;
  font-size: 18px;
  color: #196275;
  margin-top: 2px;
}

.info-text {
  display: flex;
  flex-direction: column;
}

.info-text label {
  font-weight: 600;
  font-size: 14px;
  color: #196275;
}

.info-text span {
  font-size: 14px;
  color: #333;
}



#btnCheckout {
  background-color: #196275;
  color: white;
  border: none;
  padding: 14px;
  margin-top: 30px;
  border-radius: 6px;
  width: 100%;
  font-weight: 600;
  font-size: 15px;
  cursor: pointer;
  transition: 0.3s;
}

#btnCheckout:hover {
  background-color: #154b5a;
}

@media (max-width: 600px) {
  .info-grid {
    grid-template-columns: 1fr;
  }
}

.filter-section {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  align-items: center;
  margin-bottom: 20px;
}

.filter-form {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  align-items: center;
  flex: 1; /* biar form lebar mengikuti container */
}

.filter-form div {
  display: flex;
  flex-direction: column;
}

.export-btn {
  padding: 10px 20px;
  background: #196275;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  white-space: nowrap;
  font-weight: 600;
}

/* RESPONSIF: tombol ke bawah jika kecil */
@media (max-width: 768px) {
  .filter-section {
    flex-direction: column;
    align-items: stretch;
  }

  .filter-form {
    width: 100%;
  }

  .export-btn {
    width: 100%;
    text-align: center;
  }
}


    .close {
      color: #aaa; float: right; font-size: 24px; font-weight: bold; cursor: pointer;
    }

    @media (max-width: 768px) {
        .container { margin: 20px 15px; padding: 20px; }
      .navbar-menu {
        display: none; position: absolute; right: 20px; top: 60px;
        flex-direction: column; background: white; padding: 15px;
        border: 1px solid #ccc; z-index: 999;
      }
      .navbar-menu.active { display: flex; }
      .burger { display: flex; }
    }

    .table-responsive {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

table {
  width: 100%;
  min-width: 800px; /* supaya kolom tidak numpuk di mobile */
  border-collapse: collapse;
}

th, td {
  white-space: nowrap; /* supaya teks tidak turun ke bawah */
}

  </style>
</head>
<body>

<div class="navbar">
  <a href="index.php" class="navbar-logo" style="text-decoration: none; color: inherit;">
    <img src="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_PLN.png" alt="PLN Logo">
    <span>Visitor Management System</span>
  </a>
  <div class="burger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
  <div class="navbar-menu" id="navbarMenu">
    <a href="index.php" class="active">Dashboard</a>
    <a href="registrasi.php">Registrasi Tamu</a>
  </div>
</div>


<div class="container">
  <h2>Daftar Tamu</h2>

  <div class="cards">
    <div class="card">
      <h1><?= $total ?></h1>
      <p>Tamu Hari Ini</p>
    </div>
    <div class="card">
      <h1><?= $checkIn ?></h1>
      <p>Check In Hari Ini</p>
    </div>
    <div class="card">
      <h1><?= $checkOut ?></h1>
      <p>Check Out Hari Ini</p>
    </div>
  </div>

  <h2>Data Tamu</h2>
<div class="filter-section">
  <form method="GET" class="filter-form">
    <div>
      <label>Tanggal Awal Data:</label>
      <input type="date" name="start" value="<?= $start ?>">
    </div>
    <div>
      <label>Tanggal Akhir Data:</label>
      <input type="date" name="end" value="<?= $end ?>">
    </div>
  </form>
  <button class="export-btn" type="button" onclick="exportExcel()">Export to Excel</button>
</div>


  <div class="table-responsive">
  <table id="dataTamu">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Tamu</th>
        <th>Unit Yang Dituju</th>
        <th>Nama Pegawai Tujuan</th>
        <th>Keperluan</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (empty($dataTamu)) {
        echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada data tamu.</td></tr>";
      } else {
        foreach ($dataTamu as $i => $row) {
          echo "<tr>
            <td>".($i+1)."</td>
            <td>{$row['nama_tamu']}</td>
            <td>{$row['unit']}</td>
            <td>{$row['pegawai']}</td>
            <td>{$row['keperluan']}</td>
            <td>{$row['status']}</td>
            <td><button class='btn-detail' onclick='showDetail(".json_encode($row).")'>Detail</button></td>
          </tr>";
        }
      }
      ?>
    </tbody>
  </table>
  </div>
</div>

<!-- Modal Detail -->
<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Detail Tamu</h2>

    <div class="detail-header">
      <img id="modalFoto" src="">
      <div class="info">
        <h3 id="modalNama">Nama Tamu</h3>
        <p>Nametag: <span id="modalNameTag">-</span></p>
      </div>
      <div class="status">
        <label>Status</label><br>
        <strong id="modalStatus">check-in</strong>
      </div>
    </div>

    <div class="section-title">Perusahaan & Tujuan</div>
    <div class="info-grid">
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-building"></i></div><div class="info-text"><label>Perusahaan</label><span id="modalPerusahaan">-</span></div></div>
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-sitemap"></i></div><div class="info-text"><label>Unit Tujuan</label><span id="modalUnit">-</span></div></div>
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-user-tie"></i></div><div class="info-text"><label>Pegawai Tujuan</label><span id="modalPegawai">-</span></div></div>
    </div>

    <div class="section-title">Informasi Tambahan</div>
    <div class="info-grid">
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-briefcase"></i></div><div class="info-text"><label>Keperluan</label><span id="modalKeperluan">-</span></div></div>
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-car"></i></div><div class="info-text"><label>Kendaraan</label><span id="modalKendaraan">-</span></div></div>
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-users"></i></div><div class="info-text"><label>Jumlah Tamu</label><span id="modalJumlah">-</span></div></div>
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-shield-alt"></i></div><div class="info-text"><label>Status Induksi</label><span id="modalInduksi">-</span></div></div>
    </div>

    <div class="section-title">APD Yang Dipakai</div>
    <div class="info-grid">
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-hard-hat"></i></div><div class="info-text"><label>APD</label><span id="modalApd">-</span></div></div>
    </div>

    <div class="section-title">Log Tamu</div>
    <div class="info-grid">
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-sign-in-alt"></i></div><div class="info-text"><label>Jam Check-in</label><span id="modalCheckin">-</span></div></div>
      <div class="info-item"><div class="icon-wrap"><i class="fas fa-sign-out-alt"></i></div><div class="info-text"><label>Jam Check-out</label><span id="modalCheckout">-</span></div></div>
    </div>

    <button id="btnCheckout" onclick="checkoutTamu()">Checkout</button>
  </div>
</div>

<script>
  function toggleMenu() {
    document.getElementById("navbarMenu").classList.toggle("active");
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('input[name=start]').addEventListener('change', applyFilter);
    document.querySelector('input[name=end]').addEventListener('change', applyFilter);
  });

  function applyFilter() {
    const s = document.querySelector('input[name=start]').value;
    const e = document.querySelector('input[name=end]').value;
    location.href = '?start=' + s + '&end=' + e;
  }

  let current = null;

  function showDetail(data) {
    current = data;
    document.getElementById("modal").style.display = "block";
    document.getElementById("modalFoto").src = data.link_foto || "";
    document.getElementById("modalNama").innerText = data.nama_tamu;
    document.getElementById("modalStatus").innerText = data.status;
    document.getElementById("modalPerusahaan").innerText = data.perusahaan;
    document.getElementById("modalUnit").innerText = data.unit;
    document.getElementById("modalPegawai").innerText = data.pegawai;
    document.getElementById("modalKeperluan").innerText = data.keperluan;
    document.getElementById("modalKendaraan").innerText = data.kendaraan;
    document.getElementById("modalJumlah").innerText = data.jumlah;
    document.getElementById("modalNameTag").innerText = data.name_tag;
    document.getElementById("modalInduksi").innerText = data.induksi;
    document.getElementById("modalApd").innerText = data.apd;
    document.getElementById("modalCheckin").innerText = data.timestamp;
    document.getElementById("modalCheckout").innerText = data.jam_checkout || "-";

    document.getElementById("btnCheckout").style.display = (data.status === "check-in") ? "block" : "none";
  }

  function closeModal() {
    document.getElementById("modal").style.display = "none";
  }

  function checkoutTamu() {
    if (!current) return;
    fetch('proses_checkout.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + current.id
    }).then(() => location.reload());
  }

  function exportExcel() {
  const start = document.querySelector('input[name="start"]').value;
  const end = document.querySelector('input[name="end"]').value;
  const url = `export.php?start=${start}&end=${end}`;
  window.open(url, '_blank');
}

</script>
</body>
</html>
