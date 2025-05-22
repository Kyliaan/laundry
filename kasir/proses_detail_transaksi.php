<?php
include '../database/koneksi.php';

$id_transaksi = $_POST['id_transaksi'];
$id_paket = $_POST['id_paket'];
$qty = $_POST['qty'];
$keterangan = $_POST['keterangan'];

$query = "INSERT INTO tb_detail_transaksi (id_transaksi, id_paket, qty, keterangan)
          VALUES ('$id_transaksi', '$id_paket', '$qty', '$keterangan')";

mysqli_query($koneksi, $query);

header("Location: detail_transaksi.php?id_transaksi=$id_transaksi");
exit();
