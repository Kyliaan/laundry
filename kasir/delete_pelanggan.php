<?php
include '../database/koneksi.php';

$id = $_GET['id'];

$koneksi->query("UPDATE tb_transaksi SET id_member = NULL WHERE id_member = '$id'");

$query = $koneksi->query("DELETE FROM tb_member WHERE id = '$id'");

if ($query) {
    header("Location: pelanggan.php?status=deleted");
} else {
    echo "Gagal menghapus pelanggan.";
}
?>
