<?php
include '../database/koneksi.php';
session_start();

$id_user = $_SESSION['id']; // JANGAN ditimpa POST lagi

$id_outlet = $_POST['id_outlet'];
$id_member = $_POST['id_member'];
$biaya_tambahan = $_POST['biaya_tambahan'] ?: 0;
$diskon = $_POST['diskon'] ?: 0;
$pajak = $_POST['pajak'] ?: 0;
$status = $_POST['status'];
$dibayar = $_POST['dibayar'];

date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m-d H:i:s');
$tgl_bayar = date('Y-m-d H:i:s');
$batas_waktu = date('Y-m-d H:i:s');

$kode_invoice = "INV - " . time() . rand(10, 99);

// Ambil harga paket
$query_paket = mysqli_query($koneksi, "SELECT harga FROM tb_paket WHERE id_outlet = '$id_outlet' LIMIT 1");
$data_paket = mysqli_fetch_assoc($query_paket);
$harga_paket = $data_paket['harga'];

$total_sebelum_diskon = $harga_paket + $biaya_tambahan;
$nilai_diskon = ($diskon / 100) * $total_sebelum_diskon;
$total_setelah_diskon = $total_sebelum_diskon - $nilai_diskon;
$nilai_pajak = ($pajak / 100) * $total_setelah_diskon;
$total_bayar = $total_setelah_diskon + $nilai_pajak;

$query = "INSERT INTO tb_transaksi 
(id_outlet, id_member, tgl, batas_waktu, tgl_bayar, biaya_tambahan, diskon, pajak, status, dibayar, id_user, kode_invoice)
VALUES
('$id_outlet', '$id_member', '$tgl', '$batas_waktu', '$tgl_bayar', '$biaya_tambahan', '$diskon', '$pajak', '$status', '$dibayar', '$id_user', '$kode_invoice')";

if (mysqli_query($koneksi, $query)) {
    $id_transaksi = mysqli_insert_id($koneksi);
    $_SESSION['total_bayar'] = $total_bayar;
    header("Location: detail_transaksi.php?id_transaksi=$id_transaksi");
    exit();
} else {
    echo "Error: " . mysqli_error($koneksi);
}

?>