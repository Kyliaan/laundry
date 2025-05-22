<?php
include '../database/koneksi.php';

$id = $_GET['id'];

$koneksi->query("UPDATE tb_detail_transaksi SET id_transaksi = NULL WHERE id_transaksi = '$id'");

$query = $koneksi->query("DELETE FROM tb_transaksi WHERE id = '$id'");

if ($query) {
    header("Location: laporan.php?status=deleted");
} else {
    echo "Gagal menghapus transaksi.";
}
?>