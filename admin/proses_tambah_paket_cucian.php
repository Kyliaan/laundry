<?php
include '../database/koneksi.php';

$nama = $_POST['nama_paket'];
$jenis = $_POST['jenis'];
$harga = $_POST['harga'];
$outlet = $_POST['id_outlet'];

$query = "INSERT INTO tb_paket (nama_paket, jenis, harga, id_outlet) VALUES ('$nama', '$jenis', '$harga', '$outlet')";

if (mysqli_query($koneksi, $query)) {
    header("Location: paket_cucian.php?status=success");
} else {
    header("Location: paket_cucian.php?status=error");
}
?>
