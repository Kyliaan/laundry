<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nama = htmlspecialchars($_POST["nama"]);
    $tlp = htmlspecialchars($_POST["tlp"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $jenis_kelamin = htmlspecialchars($_POST["jenis_kelamin"]);

    $query = "UPDATE tb_member SET nama='$nama', tlp='$tlp', alamat='$alamat', jenis_kelamin='$jenis_kelamin'  WHERE id='$id'";
    
    if ($koneksi->query($query) === TRUE) {
        header("Location: pelanggan.php?status=edited");
    } else {
        echo "Gagal mengupdate data: " . $koneksi->error;
    }
} else {
    header("Location: pelanggan.php");
}
?>