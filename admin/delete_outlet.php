<?php
include '../database/koneksi.php';

$id = $_GET['id'];

// Set id_outlet ke NULL dulu untuk user yang terkait
$koneksi->query("UPDATE tb_user SET id_outlet = NULL WHERE id_outlet = '$id'");
$koneksi->query("UPDATE tb_transaksi SET id_outlet = NULL WHERE id_outlet = '$id'");
$koneksi->query("UPDATE tb_paket SET id_outlet = NULL WHERE id_outlet = '$id'");

// Lanjut hapus outlet
$query = $koneksi->query("DELETE FROM tb_outlet WHERE id = '$id'");

if ($query) {
    // Redirect dengan notifikasi sukses (contoh pakai SweetAlert2)
    header("Location: outlet.php?status=deleted");
} else {
    echo "Gagal menghapus outlet.";
}
?>
