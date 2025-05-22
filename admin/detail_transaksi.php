<?php
session_start();
if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}

include '../database/koneksi.php';
$id_transaksi = $_GET['id_transaksi'] ?? null;

if (!$id_transaksi) {
    header("Location: transaksi.php");
    exit();
}

$nama = htmlspecialchars($_SESSION["nama"]);

// Ambil data transaksi
$query_transaksi = "SELECT t.*, m.nama AS nama_member, o.nama AS nama_outlet, u.nama AS nama_user
                    FROM tb_transaksi t
                    JOIN tb_member m ON t.id_member = m.id
                    JOIN tb_outlet o ON t.id_outlet = o.id
                    JOIN tb_user u ON t.id_user = u.id
                    WHERE t.id = $id_transaksi";
$result_transaksi = mysqli_query($koneksi, $query_transaksi);
$transaksi = mysqli_fetch_assoc($result_transaksi);

// Ambil data paket
$paket_result = mysqli_query($koneksi, "SELECT * FROM tb_paket WHERE id_outlet = {$transaksi['id_outlet']}");

$detail_result = mysqli_query($koneksi, "SELECT td.*, p.nama_paket 
    FROM tb_detail_transaksi td 
    JOIN tb_paket p ON td.id_paket = p.id 
    WHERE td.id_transaksi = $id_transaksi");

$subtotal = 0;
$detail_list = []; // Simpan semua detail

while ($detail = mysqli_fetch_assoc($detail_result)) {
    $detail_list[] = $detail;

    // Ambil harga paket
    $paket_query = mysqli_query($koneksi, "SELECT harga FROM tb_paket WHERE id = {$detail['id_paket']}");
    $paket = mysqli_fetch_assoc($paket_query);
    $subtotal += $paket['harga'] * $detail['qty'];
}

$angka_diskon = $transaksi['diskon'];
$biaya_tambahan = $transaksi['biaya_tambahan'];
$pajak_persen = $transaksi['pajak'];

$diskon = $subtotal * ($transaksi['diskon'] / 100);
$pajak = $subtotal * ($pajak_persen / 100);
$total = $subtotal + $biaya_tambahan - $diskon + $pajak;
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
            <a href="transaksi.php" class="active"><li><i class="fa fa-random"></i> Transaksi</li></a>
            <a href="laporan.php"><li><i class="fa fa-file-alt"></i> Laporan</li></a>
        </ul>
        <div class="logout">
            <a href="../index.php"><i class="fa fa-sign-out-alt"></i> Keluar</a>
        </div>
    </div>
    <div class="main-content">
        <div class="content-box">
            <h1>Detail Transaksi</h1>
            <p><strong>Kode Invoice:</strong> <?= $transaksi['kode_invoice'] ?></p>
            <p><strong>Nama Pelanggan:</strong> <?= $transaksi['nama_member'] ?></p>
            <p><strong>Nama User:</strong> <?= $transaksi['nama_user'] ?></p>
            <p><strong>Outlet:</strong> <?= $transaksi['nama_outlet'] ?></p>
            <p><strong>Tanggal Transaksi:</strong> <?= $transaksi['tgl'] ?></p>

            <h2>Tambah Detail Transaksi</h2>
            <form action="proses_detail_transaksi.php" method="post">
                <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
                <label>Paket:</label>
                <select name="id_paket" required>
                    <option value="">Pilih Paket</option>
                    <?php while ($paket = mysqli_fetch_assoc($paket_result)) { ?>
                        <option value="<?= $paket['id'] ?>"><?= $paket['nama_paket'] ?> - <?= $paket['harga'] ?></option>
                    <?php } ?>
                </select><br><br>
                <label>Qty:</label>
                <input type="number" name="qty" min="1" required><br><br>
                <label>Keterangan:</label>
                <input type="text" name="keterangan"><br><br>
                <button type="submit">Tambah</button>
            </form>

            <h2>Daftar Detail Transaksi</h2>
            <table class="tabel-outlet">
                <tr>
                    <th>Paket</th>
                    <th>Qty</th>
                    <th>Keterangan</th>
                </tr>
                <?php foreach ($detail_list as $detail) { ?>
                    <tr>
                        <td><?= $detail['nama_paket'] ?></td>
                        <td><?= $detail['qty'] ?></td>
                        <td><?= $detail['keterangan'] ?></td>
                    </tr>
                <?php } ?>
            </table>
            <br>
            <button onclick="konfirmasiPesanan()">Konfirmasi Pesanan</button>
            
            <script>
            function konfirmasiPesanan() {
                if (confirm("Apakah Anda yakin ingin mengonfirmasi pesanan ini?")) {
                    const invoiceWindow = window.open('', 'Invoice', 'width=800,height=600');
                    invoiceWindow.document.write(`
                        <html>
                        <head>
                            <title>Invoice - <?= $transaksi['kode_invoice'] ?></title>
                            <style>
                                body { font-family: Arial; padding: 20px; }
                                h2 { text-align: center; }
                                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                                table, th, td { border: 1px solid black; padding: 8px; }
                                th { background-color: #f2f2f2; }
                                .total { margin-top: 20px; text-align: right; }
                                .btn-print {
                                    display: inline-block;
                                    margin-top: 30px;
                                    padding: 10px 20px;
                                    background-color: #4CAF50;
                                    color: white;
                                    border: none;
                                    border-radius: 5px;
                                    cursor: pointer;
                                    font-size: 16px;
                                }
                            </style>
                        </head>
                        <body>
                            <h2>INVOICE</h2>
                            <p><strong>Kode Invoice:</strong> <?= $transaksi['kode_invoice'] ?></p>
                            <p><strong>Nama Pelanggan:</strong> <?= $transaksi['nama_member'] ?></p>
                            <p><strong>Nama User:</strong> <?= $transaksi['nama_user'] ?></p>
                            <p><strong>Outlet:</strong> <?= $transaksi['nama_outlet'] ?></p>
                            <p><strong>Tanggal Transaksi:</strong> <?= $transaksi['tgl'] ?></p>
                            
                            <table>
                                <tr>
                                    <th>Paket</th>
                                    <th>Qty</th>
                                    <th>Keterangan</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                </tr>
                                <?php foreach ($detail_list as $detail) {
                                    $harga = 0;
                                    $paket_q = mysqli_query($koneksi, "SELECT harga FROM tb_paket WHERE id = {$detail['id_paket']}");
                                    if ($row = mysqli_fetch_assoc($paket_q)) {
                                        $harga = $row['harga'];
                                    }
                                    $total_per_item = $harga * $detail['qty'];
                                ?>
                                <tr>
                                    <td><?= $detail['nama_paket'] ?></td>
                                    <td><?= $detail['qty'] ?></td>
                                    <td><?= $detail['keterangan'] ?></td>
                                    <td>Rp<?= number_format($harga, 0, ',', '.') ?></td>
                                    <td>Rp<?= number_format($total_per_item, 0, ',', '.') ?></td>
                                </tr>
                                <?php } ?>
                            </table>
            
                            <div class="total">
                                <p><strong>Subtotal:</strong> Rp<?= number_format($subtotal, 0, ',', '.') ?></p>
                                <p><strong>Diskon (<?= $angka_diskon ?>%):</strong> - Rp<?= number_format($diskon, 0, ',', '.') ?></p>
                                <p><strong>Biaya Tambahan:</strong> + Rp<?= number_format($biaya_tambahan, 0, ',', '.') ?></p>
                                <p><strong>Pajak (<?= $pajak_persen ?>%):</strong> + Rp<?= number_format($pajak, 0, ',', '.') ?></p>
                                <p><strong>Total Bayar:</strong> <strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></p>
                            </div>
            
                            <div style="text-align:center;">
                                <button class="btn-print" onclick="window.print()">Cetak Invoice</button>
                            </div>
                        </body>
                        </html>
                    `);
                    invoiceWindow.document.close();
            
                    // Redirect setelah 3 detik
                    setTimeout(function () {
                        window.location.href = 'transaksi.php?status=success';
                    }, 3000);
                }
            }
            </script>
            <h2>Ringkasan Pembayaran</h2>
            
            <div style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;">
                <p><strong>Subtotal:</strong> Rp<?= number_format($subtotal, 0, ',', '.') ?></p>
                <p><strong>Diskon (<?= $angka_diskon ?>%):</strong> - Rp<?= number_format($diskon, 0, ',', '.') ?></p>
                <p><strong>Biaya Tambahan:</strong> + Rp<?= number_format($biaya_tambahan, 0, ',', '.') ?></p>
                <p><strong>Pajak (<?= $pajak_persen ?>%):</strong> + Rp<?= number_format($pajak, 0, ',', '.') ?></p>
                <p><strong>Total:</strong> Rp<?= number_format($total, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
