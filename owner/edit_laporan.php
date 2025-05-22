<?php
session_start();
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

include '../database/koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: laporan.php");
    exit();
}

// Ambil data transaksi berdasarkan ID
$query = "SELECT * FROM tb_transaksi WHERE id = '$id'";
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
    <title>Edit Laporan Transaksi</title>
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
            <a href="laporan.php"><li class="active"><i class="fa fa-file-alt"></i> Laporan</li></a>
        </ul>
        <div class="logout">
            <a href="../index.php"><i class="fa fa-sign-out-alt"></i> Keluar</a>
        </div>
    </div>

    <div class="main-content">
        <div class="content-box">
            <div class="outlet-header">
                <h1>Edit Transaksi</h1>
                <a href="laporan.php" class="btn-kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <form action="proses_edit_laporan.php" method="post">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <label>Kode Invoice</label>
                <input type="text" name="kode_invoice" value="<?= htmlspecialchars($data['kode_invoice']) ?>" readonly>

                <label>Tanggal</label>
                <input type="datetime-local" name="tgl" value="<?= date('Y-m-d\TH:i', strtotime($data['tgl'])) ?>">

                <label>Batas Waktu</label>
                <input type="datetime-local" name="batas_waktu" value="<?= date('Y-m-d\TH:i', strtotime($data['batas_waktu'])) ?>">

                <label>Tanggal Bayar</label>
                <input type="datetime-local" name="tgl_bayar" value="<?= $data['tgl_bayar'] ? date('Y-m-d\TH:i', strtotime($data['tgl_bayar'])) : '' ?>">

                <label>Status Pesanan</label>
                <div class="custom-select">
                    <select name="status" required>
                        <option value="baru" <?= $data['status'] === 'baru' ? 'selected' : '' ?>>Baru</option>
                        <option value="proses" <?= $data['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="selesai" <?= $data['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="diambil" <?= $data['status'] === 'diambil' ? 'selected' : '' ?>>Diambil</option>
                    </select>
                    <i class="bi bi-caret-down-square-fill"></i>
                </div>

                <label>Status Pembayaran</label>
                <div class="custom-select">
                    <select name="dibayar" required>
                        <option value="dibayar" <?= $data['dibayar'] === 'dibayar' ? 'selected' : '' ?>>Dibayar</option>
                        <option value="belum_dibayar" <?= $data['dibayar'] === 'belum_dibayar' ? 'selected' : '' ?>>Belum Dibayar</option>
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
