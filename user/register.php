<?php
// KONEKSI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cafe";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// PROSES REGISTER
if (isset($_POST['register'])) {

    $nama   = $_POST['nama'];
    $hp     = $_POST['hp'];   // ← No HP
    $email  = $_POST['email'];
    $pass   = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (nama, hp, email, password) 
              VALUES ('$nama', '$hp', '$email', '$pass')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registrasi berhasil!');</script>";
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Café du Rêve</title>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap');

    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background: url("ratatouille.jpg") no-repeat center center/cover;
        font-family: Arial, sans-serif;
    }

    .overlay {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        backdrop-filter: brightness(0.6);
    }

    .form-card {
        width: 350px;
        padding: 35px;
        background: #4b0f0f;
        color: #f4d2d6;
        border-radius: 40px;
        text-align: left;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }

    .form-card h1 {
        text-align: center;
        font-family: "Playfair Display", serif;
        font-size: 28px;
        margin-bottom: 25px;
        color: #f4d2d6;
    }

    .form-card h1 span {
        font-weight: 600;
    }

    label {
        display: block;
        font-size: 14px;
        margin-top: 10px;
        margin-bottom: 3px;
    }

    input {
        width: 100%;
        padding: 10px 5px;
        background: transparent;
        border: none;
        border-bottom: 1px solid #cba7ad;
        font-size: 14px;
        color: #f4d2d6;
        outline: none;
    }

    input::placeholder {
        color: #cba7ad;
    }

    button {
        margin-top: 25px;
        width: 100%;
        padding: 12px;
        border: none;
        background: #e8a4b0;
        color: #4b0f0f;
        font-weight: bold;
        border-radius: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #ffb8c7;
    }
</style>

</head>
<body>

<div class="overlay">
    <div class="form-card">
        <h1>Join us in <br><span>CAFÉ DU RÊVE</span></h1>

        <form method="POST">

            <label>Username</label>
            <input type="text" name="nama" placeholder="Username" required>

            <label>No HP</label>
            <input type="text" name="hp" placeholder="No HP" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="register">Submit</button>
        </form>
    </div>
</div>

</body>
</html>
