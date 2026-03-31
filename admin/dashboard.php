<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// (Opsional) bisa ambil data user dari session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard</title> 
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f2f2f2;
        padding: 20px;
    }

    .card {
        background: white;
        padding: 20px;
        width: 350px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }

    .logout {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        background: red;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }
</style>
</head>

<body>

<div class="card">
    <h2>Selamat Datang!</h2>
    <p>Anda login sebagai: <b><?php echo htmlspecialchars($username); ?></b></p>

    <a class="logout" href="logout.php">Logout</a>
</div>

</body>
</html>
