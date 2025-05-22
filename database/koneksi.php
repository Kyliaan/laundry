<?php

$koneksi = mysqli_connect("localhost","root","","aplikasi_laundry");

if (mysqli_connect_errno()){
    echo "Koneksi database gagal: ". mysqli_connect_error();
    }
?>