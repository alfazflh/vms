<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Visitor Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_PLN.png" rel="icon" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
      border-radius: 8px; padding: 30px; border: 2px solid #196275;
      box-shadow: 0 19px 41px rgba(0,0,0,0.1); box-sizing: border-box;
    }

    h2 { margin-bottom: 30px; font-size: 20px; font-weight: 600; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 5px; color: #666; }
    .form-group input[type="text"], .form-group input[type="number"] {
      width: 100%; padding: 8px 10px; border: 1px solid #D1D1D1;
      border-radius: 4px; box-sizing: border-box;
    }

    .photo-preview { text-align: center; margin-bottom: 20px; }
    #preview {
      height: 155px; object-fit: cover; margin: 0 auto 10px auto;
      display: block;
    }
    .file-hidden { display: none; }

    .btn {
      padding: 10px 20px;
      background-color: #196275;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
    }

    .apd-options {
      display: flex; gap: 30px; margin-top: 10px; flex-wrap: wrap;
    }
    .checkbox-label {
      display: flex; align-items: center; gap: 8px;
      font-weight: 600; color: #666;
    }

    .induction-image {
      display: block; max-width: 100%; margin: 30px auto;
    }

    .submit-section { text-align: right; }

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
    <a href="index.php">Dashboard</a>
    <a href="registrasi.php" class="active">Registrasi Tamu</a>
  </div>
</div>

<div class="container">
  <h2>Formulir Tamu PLN PUSHARLIS UP2WVI</h2>

  <form id="formTamu" action="proses_simpan.php" method="POST" enctype="multipart/form-data">
  <div class="photo-preview">
    <img id="preview" src="https://icon-library.com/images/no-picture-available-icon/no-picture-available-icon-13.jpg" alt="Preview Foto">
    <input type="file" id="fotoInput" name="fotoInput" class="file-hidden" accept="image/*" onchange="previewImage(this)" required>
    <button type="button" class="btn" onclick="document.getElementById('fotoInput').click()">Ambil Foto</button>
  </div>

    <div class="form-group"><label>Nama Tamu*</label><input name="namaTamu" type="text" required></div>
    <div class="form-group"><label>Nama Perusahaan*</label><input name="perusahaan" type="text" required></div>
    <div class="form-group"><label>Alamat Perusahaan Tamu*</label><input name="alamat" type="text" required></div>
    <div class="form-group"><label>Unit Yang Dituju*</label><input name="unit" type="text" required></div>
    <div class="form-group"><label>Nama Pegawai Yang Dituju*</label><input name="pegawai" type="text" required></div>
    <div class="form-group"><label>Pemakaian APD*</label>
      <div class="apd-options">
        <label class="checkbox-label"><input type="checkbox" name="apd[]" value="Safety Helmet"> Safety Helmet</label>
        <label class="checkbox-label"><input type="checkbox" name="apd[]" value="Safety Shoes"> Safety Shoes</label>
        <label class="checkbox-label"><input type="checkbox" name="apd[]" value="Seragam Kerja"> Seragam Kerja</label>
      </div>
    </div>
    <div class="form-group"><label>Keperluan Kunjungan*</label><input name="keperluan" type="text" required></div>
    <div class="form-group"><label>No. KTP atau Identitas Lainnya*</label><input name="ktp" type="text" required></div>
    <div class="form-group"><label>Kendaraan (Jenis / No.Pol)*</label><input name="kendaraan" type="text" required></div>
    <div class="form-group"><label>No Name Tag Tamu*</label><input name="nameTag" type="text" required></div>
    <div class="form-group"><label>Jumlah Tamu*</label><input name="jumlahTamu" type="number" required></div>

    <p style="text-align:center; font-weight:600; color:#666;">
      Selama Anda Berada di Area PT PLN (Persero) Pusharlis wajib mematuhi Paparan Safety and Security Induction sebagai berikut:
    </p>
    <img class="induction-image" src="https://ik.imagekit.io/pln/peraturan.png?updatedAt=1751940307075" alt="Safety Induction">

    <div class="form-group">
      <label><input name="induction" type="checkbox" value="Ya" required> Sudah membaca dan memahami Safety and Security Induction yang diberikan</label>
    </div>

    <div class="submit-section">
      <button type="submit" class="btn">Submit</button>
    </div>
  </form>
</div>

<script>
  function previewImage(input) {
    const reader = new FileReader();
    reader.onload = (e) => document.getElementById("preview").src = e.target.result;
    reader.readAsDataURL(input.files[0]);
  }

  function toggleMenu() {
    document.getElementById("navbarMenu").classList.toggle("active");
  }
</script>


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function previewImage(input) {
    const reader = new FileReader();
    reader.onload = (e) => document.getElementById("preview").src = e.target.result;
    reader.readAsDataURL(input.files[0]);
  }

  function toggleMenu() {
    document.getElementById("navbarMenu").classList.toggle("active");
  }

  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formTamu");

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      Swal.fire({
        icon: 'success',
        title: 'Data berhasil dikirim!',
        text: 'Terima kasih sudah mengisi formulir tamu.',
        confirmButtonColor: '#196275',
        timer: 2000,
        showConfirmButton: false
      });

      setTimeout(() => {
        form.submit(); // submit form setelah SweetAlert muncul sebentar
      }, 2000); // delay 2 detik
    });
  });
</script>

</body>
</html>
