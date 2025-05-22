<?php
session_start();
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

$nama = htmlspecialchars($_SESSION["nama"]);

// Koneksi ke database
include '../database/koneksi.php';

// Ambil data outlet dari database
$query_outlet = "SELECT * FROM tb_outlet";
$result_outlet = mysqli_query($koneksi, $query_outlet);
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
                <h3><?= $nama ?></h3>
            </div>
            <ul class="menu">
                <a href="dashboard.php"><li><i class="fa fa-home"></i> Dashboard</li></a>
                <a href="outlet.php"><li><i class="fa fa-store"></i> Outlet</li></a>
                <a href="tambah_pelanggan.php"><li><i class="fa fa-edit"></i> Registrasi Pelanggan</li></a>
                <a href="pelanggan.php"><li><i class="fa fa-user"></i> Pelanggan</li></a>
                <a href="paket_cucian.php"><li><i class="bi bi-box-fill"></i> Paket Cucian</li></a>
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
                    <h1>Tambah Pengguna Baru</h1>
                    <a href="user.php" class="btn-kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
                <form action="proses_tambah_user.php" method="post">
                    <input type="text" name="nama" placeholder="Nama Lengkap" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password1" name="password" placeholder="Password" required>
                    <div class="custom-select">
                        <select name="role" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                            <option value="owner">Owner</option>
                        </select>
                        <i class="bi bi-caret-down-square-fill"></i>
                    </div>
                    <div class="custom-select">
                        <select name="id_outlet" required>
                            <option value="" disabled selected>Pilih Outlet</option>
                            <?php while ($outlet = mysqli_fetch_assoc($result_outlet)) { ?>
                                <option value="<?= $outlet['id'] ?>"><?= $outlet['nama'] ?></option>
                            <?php } ?>
                        </select>
                        <i class="bi bi-caret-down-square-fill"></i>
                    </div>
                    <button type="submit">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
