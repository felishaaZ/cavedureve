<?php
include "koneksi.php";

// cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// insert kasir TANPA kolom username
$sql = "INSERT INTO kasir (userKasir, password)
        VALUES ('kasir1', '12345')";

if (mysqli_query($koneksi, $sql)) {
    echo "Kasir berhasil ditambahkan!";
} else {
    echo "GAGAL INSERT: " . mysqli_error($koneksi);
}
?>
