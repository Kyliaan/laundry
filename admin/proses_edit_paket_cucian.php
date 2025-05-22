<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nama = htmlspecialchars($_POST["nama_paket"]);
    $jenis = htmlspecialchars($_POST["jenis"]);
    $harga = htmlspecialchars($_POST["harga"]);
    $outlet = htmlspecialchars($_POST["outlet"]);

    $query = "UPDATE tb_paket SET nama_paket='$nama', jenis='$jenis', harga='$harga', id_outlet='$outlet'  WHERE id='$id'";
    
    if ($koneksi->query($query) === TRUE) {
        header("Location: paket_cucian.php?status=edited");
    } else {
        echo "Gagal mengupdate data: " . $koneksi->error;
    }
} else {
    header("Location: paket_cucian.php");
}
?>