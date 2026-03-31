<?php
include "../koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($koneksi, "SELECT * FROM admin");
?>

<!DOCTYPE html>
<html>
<head>
<title>Kelola Admin</title>
<style>
table { width: 100%; border-collapse: collapse; }
th, td { padding: 10px; border: 1px solid #aaa; }
.btn { padding: 5px 8px; background: blue; color: white; text-decoration: none; border-radius: 5px; }
.hapus { background: red; }
</style>
</head>
<body>

<h2>Kelola Admin</h2>

<a href="tambah_admin.php" class="btn">Tambah Admin</a>
<br><br>

<table>
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Password</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['userAdmin'] ?></td>
    <td>
        <a href="edit_admin.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
        <a href="hapus_admin.php?id=<?= $row['id'] ?>" class="btn hapus">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
