<?php
session_start();
if (!isset($_SESSION['kasir'])) {
    header("Location: login_kasir.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Kasir</title>

<style>
    body{
        font-family: Poppins, sans-serif;
        background:#3a0505;
        color:white;
        text-align:center;
        padding-top:80px;
    }
    .box{
        background:#4d1a1a;
        padding:40px;
        width:450px;
        margin:auto;
        border-radius:25px;
        box-shadow:0 0 15px rgba(0,0,0,0.4);
    }
    a{
        color:#f5b041;
        font-weight:bold;
        text-decoration:none;
    }
</style>
</head>
<body>

<div class="box">
    <h1>Selamat Datang, <?php echo $_SESSION['kasir']; ?>!</h1>
    <p>Ini adalah Dashboard Kasir Café du Rêve.</p>

    <a href="logout.php">Logout</a>
</div>

</body>
</html>
