<?php
include '../database/koneksi.php';
session_start();

$query = "SELECT 
    t.id,
    t.kode_invoice,
    p.nama AS nama_pelanggan,
    o.nama AS nama_outlet,
    t.tgl,
    t.batas_waktu,
    t.tgl_bayar,
    t.status,
    t.dibayar
FROM tb_transaksi t
JOIN tb_member p ON t.id_member = p.id
JOIN tb_outlet o ON t.id_outlet = o.id
ORDER BY t.id DESC";

$result = $koneksi->query($query);

// Cek apakah user sudah login
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

$nama = htmlspecialchars($_SESSION["nama"]);

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
            <a href="laporan.php"><li  class="active"><i class="fa fa-file-alt"></i> Laporan</li></a>
        </ul>
        <div class="logout">
            <a href="../index.php"><i class="fa fa-sign-out-alt"></i> Keluar</a>
        </div>
    </div>
    <div class="main-content">
        <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Transaksi Berhasil Dihapus!',
                        text: 'Data transaksi telah berhasil dihapus dari sistem.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            <?php endif; ?>
            <?php if (isset($_GET['status']) && $_GET['status'] == 'edited'): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data transaksi berhasil diperbarui.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            <?php endif; ?>
        <script>
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('status');
                window.history.replaceState({}, document.title, url.pathname);
            }
        </script>
        <div class="content-box">
            <h1>Data Transaksi</h1>
            <div style="margin-bottom: 10px;">
                <a href="export_pdf.php" class="btn-tambah" style="background-color: red;"><i class="fa fa-file-pdf"></i> Export PDF</a>
                <a href="export_excel.php" class="btn-tambah" style="background-color: green;"><i class="fa fa-file-excel"></i> Export Excel</a>
            </div>
            <table class="tabel-outlet">
                <thead>
                    <tr>
                        <th>Kode Invoice</th>
                        <th>Pelanggan</th>
                        <th>Outlet</th>
                        <th>Tanggal</th>
                        <th>Batas Waktu</th>
                        <th>Tanggal Bayar</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['kode_invoice']}</td>";
                            echo "<td>{$row['nama_pelanggan']}</td>";
                            echo "<td>{$row['nama_outlet']}</td>";
                            echo "<td>{$row['tgl']}</td>";
                            echo "<td>{$row['batas_waktu']}</td>";
                            echo "<td>" . ($row['tgl_bayar'] ?? '-') . "</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "<td>{$row['dibayar']}</td>";
                            echo "<td>
                                    <a href='edit_laporan.php?id={$row['id']}' class='btn-aksi edit' title='Edit'><i class='fa fa-edit'></i></a>
                                    <a href='delete_transaksi.php?id={$row['id']}' class='btn-aksi hapus' title='Hapus' onclick='return confirm(\"Yakin ingin menghapus transaksi ini?\")'><i class='fa fa-trash'></i></a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Tidak ada data transaksi</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
