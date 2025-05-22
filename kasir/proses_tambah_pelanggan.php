<?php
include '../database/koneksi.php';

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tlp = $_POST['tlp'];

$query = "INSERT INTO tb_member (nama, alamat, jenis_kelamin, tlp) VALUES ('$nama', '$alamat', '$jenis_kelamin', '$tlp')";

if (mysqli_query($koneksi, $query)) {
    header("Location: tambah_pelanggan.php?status=success");
} else {
    header("Location: tambah_pelanggan.php?status=error");
}
?>
