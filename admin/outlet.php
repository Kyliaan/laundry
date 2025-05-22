<?php

include '../database/koneksi.php';

$query = "SELECT * FROM tb_outlet";
$result = $koneksi->query($query);

session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

$nama = htmlspecialchars($_SESSION["nama"]);;
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
                <h3> <?= $nama ?></h3>
            </div>
            <ul class="menu">
                <a href="dashboard.php"><li><i class="fa fa-home"></i> Dashboard</li></a>
                <a href="outlet.php"><li class="active"><i class="fa fa-store"></i> Outlet</li></a>
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
            <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Outlet Berhasil Dihapus!',
                        text: 'Data outlet telah berhasil dihapus dari sistem.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
            <?php endif; ?>
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Outlet baru berhasil ditambahkan.',
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
                        text: 'Data outlet berhasil diperbarui.',
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
                <div class="outlet-header">
                    <h1>Outlet</h1>
                    <a href="tambah_outlet.php" class="btn-tambah"><i class="fa fa-plus"></i> Tambah Outlet</a>
                </div>
                <table class="tabel-outlet">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Outlet</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$no}</td>";
                                echo "<td>{$row['nama']}</td>";
                                echo "<td>{$row['alamat']}</td>";
                                echo "<td>{$row['tlp']}</td>";
                                echo "<td>
                                        <a href='edit_outlet.php?id={$row['id']}' class='btn-aksi edit'><i class='fa fa-edit'></i></a>
                                        <a href='delete_outlet.php?id={$row['id']}' class='btn-aksi hapus' onclick='return confirm(\"Yakin ingin menghapus outlet ini?\")'><i class='fa fa-trash'></i></a>
                                      </td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada data outlet</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
