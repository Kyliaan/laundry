<?php
include '../database/koneksi.php';

$id = $_GET['id'];

$koneksi->query("UPDATE tb_transaksi SET id_user = NULL WHERE id_user = '$id'");

// Lanjut hapus outlet
$query = $koneksi->query("DELETE FROM tb_user WHERE id = '$id'");

if ($query) {
    // Redirect dengan notifikasi sukses (contoh pakai SweetAlert2)
    header("Location: user.php?status=deleted");
} else {
    echo "Gagal menghapus outlet.";
}
?>
