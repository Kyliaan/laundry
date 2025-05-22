<?php
include '../database/koneksi.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

$nama = htmlspecialchars($_SESSION["nama"]);

$query = "SELECT * FROM tb_member";
$result = $koneksi->query($query);
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
            <a href="pelanggan.php"><li class="active"><i class="fa fa-user"></i> Pelanggan</li></a>
            <a href="transaksi.php"><li><i class="fa fa-random"></i> Transaksi</li></a>
            <a href="laporan.php"><li><i class="fa fa-file-alt"></i> Laporan</li></a>
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
                    title: 'Pelanggan Berhasil Dihapus!',
                    text: 'Data pelanggan telah berhasil dihapus dari sistem.',
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
                        text: 'Data pelanggan berhasil diperbarui.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        <?php endif; ?>
        <div class="content-box">
            <h1>Data Pengguna</h1>
            <a href="tambah_pelanggan.php" class="btn-tambah" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Tambah</a>
            <table class="tabel-outlet">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['nama']}</td>";
                            echo "<td>{$row['tlp']}</td>";
                            echo "<td>{$row['alamat']}</td>";
                            echo "<td>{$row['jenis_kelamin']}</td>";
                            echo "<td>
                                    <a href='edit_pelanggan.php?id={$row['id']}' class='btn-aksi edit' title='Edit'><i class='fa fa-edit'></i></a>
                                    <a href='delete_pelanggan.php?id={$row['id']}' class='btn-aksi hapus' title='Hapus' onclick='return confirm(\"Yakin ingin menghapus pengguna ini?\")'><i class='fa fa-trash'></i></a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data pelanggan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
