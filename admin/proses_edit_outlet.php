<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nama = htmlspecialchars($_POST["nama"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $tlp = htmlspecialchars($_POST["tlp"]);

    $query = "UPDATE tb_outlet SET nama='$nama', alamat='$alamat', tlp='$tlp' WHERE id='$id'";
    
    if ($koneksi->query($query) === TRUE) {
        header("Location: outlet.php?status=edited");
    } else {
        echo "Gagal mengupdate data: " . $koneksi->error;
    }
} else {
    header("Location: outlet.php");
}
?>
