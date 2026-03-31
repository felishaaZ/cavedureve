<?php
$koneksi = mysqli_connect("localhost", "root", "", "cafedureve");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
