<?php
session_start();
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

$nama = htmlspecialchars($_SESSION["nama"]);
$id = isset($_GET['id']) ? $_GET['id'] : null;

include '../database/koneksi.php';

$outlet_result = mysqli_query($koneksi, "SELECT * FROM tb_outlet");
$member_result = mysqli_query($koneksi, "SELECT * FROM tb_member");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Laundry</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container">
    <div class="sidebar">
                    <div class="profile">
                  <div class="avatar"><i class="bi bi-person-circle"></i></div>
                <h3> <?= $nama ?></h3>
            </div>
        <ul class="menu">
            <a href="dashboard.php"><li><i class="fa fa-home"></i> Dashboard</li></a>
            <a href="tambah_pelanggan.php"><li><i class="fa fa-edit"></i> Registrasi Pelanggan</li></a>
            <a href="pelanggan.php"><li><i class="fa fa-user"></i> Pelanggan</li></a>
            <a href="transaksi.php"><li class="active"><i class="fa fa-random"></i> Transaksi</li></a>
            <a href="laporan.php"><li><i class="fa fa-file-alt"></i> Laporan</li></a>
        </ul>
        <div class="logout">
            <a href="../index.php"><i class="fa fa-sign-out-alt"></i> Keluar</a>
        </div>
    </div>
    <div class="main-content">
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Transaksi baru berhasil ditambahkan.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
        <?php endif; ?>
        <div class="content-box">
            <div class="outlet-header">
                <h1>Tambah Transaksi Baru</h1>
                <a href="transaksi.php" class="btn-kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <form action="proses_tambah_transaksi.php" method="post">
                <div class="custom-select">
                    <select name="id_outlet" required>
                        <option value="" disabled selected>Pilih Outlet</option>
                        <?php while ($outlet = mysqli_fetch_assoc($outlet_result)) { ?>
                            <option value="<?= $outlet['id'] ?>"><?= $outlet['nama'] ?></option>
                        <?php } ?>
                    </select>
                    <i class="bi bi-caret-down-square-fill"></i>
                </div>

                <div class="custom-select">
                    <select name="id_member" required>
                        <option value="" disabled selected>Pilih Pelanggan</option>
                        <?php while ($member = mysqli_fetch_assoc($member_result)) { ?>
                            <option value="<?= $member['id'] ?>"><?= $member['nama'] ?></option>
                        <?php } ?>
                    </select>
                    <i class="bi bi-caret-down-square-fill"></i>
                </div>

                <label for="tgl">Tanggal Transaksi</label>
                <input type="date" name="tgl" id="tgl" required>
                <label for="tgl">Batas Waktu</label>
                <input type="date" name="batas_waktu" required placeholder="Batas Waktu">
                <label for="tgl">Tanggal Bayar</label>
                <input type="date" name="tgl_bayar" placeholder="Tanggal Bayar">
                <input type="number" name="biaya_tambahan" placeholder="Biaya Tambahan">
                <input type="number" name="diskon" placeholder="Diskon (%)">
                <input type="number" name="pajak" placeholder="Pajak (%)">

                <div class="custom-select">
                    <select name="status" required>
                        <option value="" disabled selected>Status</option>
                        <option value="proses">Proses</option>
                        <option value="selesai">Selesai</option>
                        <option value="diambil">Diambil</option>
                    </select>
                    <i class="bi bi-caret-down-square-fill"></i>
                </div>

                <div class="custom-select">
                    <select name="dibayar" required>
                        <option value="" disabled selected>Pembayaran</option>
                        <option value="dibayar">Dibayar</option>
                        <option value="belum_dibayar">Belum Dibayar</option>
                    </select>
                    <i class="bi bi-caret-down-square-fill"></i>
                </div>

                <!-- Hidden input untuk id_user dari sesi -->
                <input type="hidden" name="id_user" value="<?= $id_user ?>">

                <button type="submit">Tambah Transaksi</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
