<?php
include '../database/koneksi.php';
session_start();

if (!isset($_SESSION["nama"]) || !isset($_SESSION["role"])) {
    header("Location: ../index.php");
    exit();
}


$id = $_POST['id'];
$tgl = $_POST['tgl'];
$batas_waktu = $_POST['batas_waktu'];
$tgl_bayar = $_POST['tgl_bayar'] ?: NULL;
$status = $_POST['status'];
$dibayar = $_POST['dibayar'];

// Update ke database
$query = "UPDATE tb_transaksi SET 
            tgl = '$tgl',
            batas_waktu = '$batas_waktu',
            tgl_bayar = " . ($tgl_bayar ? "'$tgl_bayar'" : "NULL") . ",
            status = '$status',
            dibayar = '$dibayar'
          WHERE id = '$id'";

if ($koneksi->query($query) === TRUE) {
    header("Location: laporan.php?status=edited");
} else {
    echo "Gagal mengupdate data: " . $koneksi->error;
}
?>
