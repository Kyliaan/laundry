<?php
include '../database/koneksi.php';

$nama = htmlspecialchars($_POST['nama']);
$username = htmlspecialchars($_POST['username']);
$password = md5($_POST['password']);
$role = $_POST['role'];
$id_outlet = $_POST['id_outlet'];

$query = "INSERT INTO tb_user (nama, username, password, role, id_outlet) VALUES ('$nama', '$username', '$password', '$role', '$id_outlet')";

if (mysqli_query($koneksi, $query)) {
    header("Location: user.php?status=success");
} else {
    header("Location: user.php?status=error");
}
?>