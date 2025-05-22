<?php
session_start();
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

include '../database/koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: outlet.php");
    exit();
}

// Ambil data outlet berdasarkan ID
$query = "SELECT * FROM tb_member WHERE id = '$id'";
$result = $koneksi->query($query);

if ($result->num_rows === 0) {
    echo "Data tidak ditemukan.";
    exit();
}

$data = $result->fetch_assoc();
$namaUser = htmlspecialchars($_SESSION["nama"]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Laundry</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="profile">
            <a href="user.php" style="color: inherit; text-decoration: none;">
                <div class="avatar"><i class="bi bi-person-circle"></i></div>
            </a>
            <h3><?= $namaUser ?></h3>
        </div>
        <ul class="menu">
            <a href="dashboard.php"><li><i class="fa fa-home"></i> Dashboard</li></a>
            <a href="tambah_pelanggan.php"><li><i class="fa fa-edit"></i> Registrasi Pelanggan</li></a>
            <a href="pelanggan.php"><li><i class="fa fa-user"></i> Pelanggan</li></a>
            <a href="transaksi.php"><li><i class="fa fa-random"></i> Transaksi</li></a>
            <a href="laporan.php"><li><i class="fa fa-file-alt"></i> Laporan</li></a>
        </ul>
        <div class="logout">
            <a href="../index.php"><i class="fa fa-sign-out-alt"></i> Keluar</a>
        </div>
    </div>

    <div class="main-content">
        <div class="content-box">
            <div class="outlet-header">
                <h1>Edit User</h1>
                <a href="pelanggan.php" class="btn-kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <form action="proses_edit_pelanggan.php" method="post">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="text" name="nama" placeholder="Nama Lengkap" value="<?= htmlspecialchars($data['nama']) ?>" required>
                <input type="text" name="tlp" placeholder="No. hp" value="<?= htmlspecialchars($data['tlp']) ?>" required>
                <input type="text" name="alamat" placeholder="Alamat" value="<?= htmlspecialchars($data['alamat']) ?>" required>
                   <div class="custom-select">
                        <select name="jenis_kelamin" required>
                            <option value="" disabled <?= empty($data['jenis_kelamin']) ? 'selected' : '' ?>>Pilih Role</option>
                            <option value="L" <?= $data['jenis_kelamin'] === 'L' ? 'selected' : '' ?>>L</option>
                            <option value="P" <?= $data['jenis_kelamin'] === 'P' ? 'selected' : '' ?>>P</option>
                        </select>
                        <i class="bi bi-caret-down-square-fill"></i>
                    </div>  
                <button type="submit"><i class="bi bi-floppy-fill"></i> Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
