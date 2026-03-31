<?php
include "../koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($koneksi, "SELECT * FROM pesanan");
?>

<!DOCTYPE html>
<html>
<head>
<title>Kelola Pesanan</title>
<style>
table { width: 100%; border-collapse: collapse; }
th, td { padding: 10px; border: 1px solid #aaa; }
</style>
</head>
<body>

<h2>Kelola Pesanan</h2>

<table>
<tr>
    <th>ID</th>
    <th>Nama Pelanggan</th>
    <th>Menu</th>
    <th>Jumlah</th>
    <th>Total</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['menu'] ?></td>
    <td><?= $row['jumlah'] ?></td>
    <td>Rp <?= number_format($row['total']) ?></td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
