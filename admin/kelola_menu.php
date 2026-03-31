<?php
include "../koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($koneksi, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Menu</title>
<style>
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #aaa; }
    .btn { padding: 5px 8px; background: blue; color: white; text-decoration: none; border-radius: 5px; }
    .hapus { background: red; }
</style>
</head>
<body>

<h2>Kelola Menu</h2>
<a href="tambah_menu.php" class="btn">Tambah Menu</a>
<br><br>

<table>
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Harga</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['nama'] ?></td>
    <td>Rp <?= number_format($row['harga']) ?></td>
    <td>
        <a href="edit_menu.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
        <a href="hapus_menu.php?id=<?= $row['id'] ?>" class="btn hapus">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
