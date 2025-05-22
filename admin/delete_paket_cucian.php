<?php
include '../database/koneksi.php';

$id = $_GET['id'];

$koneksi->query("UPDATE tb_detail_transaksi SET id_paket = NULL WHERE id_paket = '$id'");

$query = $koneksi->query("DELETE FROM tb_paket WHERE id = '$id'");

if ($query) {
    header("Location: paket_cucian.php?status=deleted");
} else {
    echo "Gagal menghapus outlet.";
}
?>