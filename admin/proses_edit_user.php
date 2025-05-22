<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars(md5($_POST["password"]));
    $role = htmlspecialchars($_POST["role"]);
    $outlet = htmlspecialchars($_POST["outlet"]);

    $query = "UPDATE tb_user SET nama='$nama', username='$username', password='$password', role='$role', id_outlet='$outlet'  WHERE id='$id'";
    
    if ($koneksi->query($query) === TRUE) {
        header("Location: user.php?status=edited");
    } else {
        echo "Gagal mengupdate data: " . $koneksi->error;
    }
} else {
    header("Location: user.php");
}
?>