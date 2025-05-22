<?php
session_start();

include '../database/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

$nama = htmlspecialchars($_SESSION["nama"]);

$query_jumlah = "SELECT COUNT(*) AS total FROM tb_member";
$result_jumlah = $koneksi->query($query_jumlah);
$row_jumlah = $result_jumlah->fetch_assoc();
$jumlah_pelanggan = $row_jumlah['total'];

$query_proses = "SELECT COUNT(*) AS total_proses FROM tb_transaksi WHERE status = 'proses'";
$result_proses = $koneksi->query($query_proses);
$row_proses = $result_proses->fetch_assoc();
$jumlah_proses = $row_proses['total_proses'];

$query_selesai = "SELECT COUNT(*) AS total_selesai FROM tb_transaksi WHERE status = 'selesai'";
$result_selesai = $koneksi->query($query_selesai);
$row_selesai = $result_selesai->fetch_assoc();
$jumlah_selesai = $row_selesai['total_selesai'];
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
                  <div class="avatar"><i class="bi bi-person-circle"></i></div>
                <h3> <?= $nama ?></h3>
            </div>
            <ul class="menu">
                <a href="dashboard.php"><li class="active"><i class="fa fa-home"></i> Dashboard</li></a>
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
                <h1>Halo, kasir <?= $nama ?>!</h1>
                <div class="cards">
                    <div class="card">
                        <i class="fa fa-user"></i>
                        <div class="info">
                            <p>Jumlah pelanggan</p>
                            <h2><?= $jumlah_pelanggan ?></h2>
                        </div>
                    </div>
                    <div class="card">
                        <i class="fa fa-sync-alt"></i>
                        <div class="info">
                            <p>Jumlah cucian diproses</p>
                            <h2><?= $jumlah_proses ?></h2>
                        </div>
                    </div>
                    <div class="card">
                        <i class="fa fa-check-circle"></i>
                        <div class="info">
                            <p>Jumlah cucian selesai</p>
                            <h2><?= $jumlah_selesai ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
