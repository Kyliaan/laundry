<?php
session_start();
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
                  <div class="avatar"><i class="bi bi-person-circle"></i></div>
                <h3> <?= $nama ?></h3>
            </div>
            <ul class="menu">
                <a href="dashboard.php"><li><i class="fa fa-home"></i> Dashboard</li></a>
                <a href="tambah_pelanggan.php"><li class="active"><i class="fa fa-edit"></i> Registrasi Pelanggan</li></a>
                <a href="pelanggan.php"><li><i class="fa fa-user"></i> Pelanggan</li></a>
                <a href="transaksi.php"><li><i class="fa fa-random"></i> Transaksi</li></a>
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
                    text: 'Pelanggan baru berhasil ditambahkan.',
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
                    <h1>Tambah Pelanggan</h1>
                </div>
                <form action="proses_tambah_pelanggan.php" method="post">
                    <input type="text" name="nama" placeholder="Nama Lengkap" required>
                    <input type="text" name="tlp" placeholder="No. hp" required>
                    <input type="text" name="alamat" placeholder="Alamat" required>
                    <div class="custom-select">
                        <select name="jenis_kelamin" required>
                            <option value="" disabled selected>Jenis Kelamin</option>
                            <option value="L">L</option>
                            <option value="P">P</option>
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
