<?php
include '../database/koneksi.php';

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$tlp = $_POST['tlp'];

$query = "INSERT INTO tb_outlet (nama, alamat, tlp) VALUES ('$nama', '$alamat', '$tlp')";

if (mysqli_query($koneksi, $query)) {
    header("Location: outlet.php?status=success");
} else {
    header("Location: outlet.php?status=error");
}
?>
