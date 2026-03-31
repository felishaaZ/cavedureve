<?php
include "koneksi.php";

// cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// query insert admin
$sql = "INSERT INTO admin (userAdmin,password) VALUES ('admin1', 'PAssword')";

if (mysqli_query($koneksi, $sql)) {
    echo "Admin berhasil ditambahkan!";
} else {
    echo "GAGAL INSERT: " . mysqli_error($koneksi);
}
?>
