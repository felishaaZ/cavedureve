<?php
session_start();
include "koneksi.php";

$error = "";

if (isset($_POST['login'])) {

    $user = $_POST['userKasir'];
    $pass = $_POST['password'];

    // Query tabel kasir
    $query = mysqli_query($koneksi, 
        "SELECT * FROM kasir WHERE userKasir='$user' AND password='$pass'"
    );

    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $_SESSION['kasir'] = $user;
        header("Location: dashboard_kasir.php");
        exit();
    } else {
        $error = "UserKasir atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Kasir | Café du Rêve</title>

<style>
    body{
        margin:0;
        padding:0;
        height:100vh;
        font-family: 'Poppins', sans-serif;
        background:#3a0505;
        display:flex;
        justify-content:center;
        align-items:center;
    }
    .login-box{
        background:#4d1a1a;
        padding:35px 45px;
        width:380px;
        border-radius:25px;
        color:#fff;
        box-shadow:0 0 15px rgba(0,0,0,0.5);
    }
    h2{ text-align:center; margin-bottom:15px; }
    label{ font-weight:bold; margin-top:15px; display:block; }
    input{
        width:100%;
        padding:10px;
        margin-top:5px;
        border:none;
        border-bottom:2px solid #f5b041;
        background:transparent;
        color:white;
    }
    button{
        width:100%;
        margin-top:25px;
        padding:12px;
        background:#f5b041;
        border:none;
        border-radius:20px;
        color:#4d1a1a;
        font-size:16px;
        font-weight:bold;
        cursor:pointer;
    }
    .error{ margin-top:10px; color:#ffaaaa; text-align:center; }
</style>

</head>
<body>

<div class="login-box">

    <h2>Login Kasir</h2>

    <?php 
        if ($error != "") echo "<div class='error'>$error</div>";
    ?>

    <form method="POST">
        <label>UserKasir</label>
        <input type="text" name="userKasir" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>

</div>

</body>
</html>
