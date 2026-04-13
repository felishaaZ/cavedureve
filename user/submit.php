
<?php
$servername = "localhost";
$username = "root"; // default XAMPP
$password = "";     // default kosong
$dbname = "landing_db";

// koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ambil data dari form
$name = $_POST['name'];
$email = $_POST['email'];

// simpan ke tabel
$stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $email);
if ($stmt->execute()) {
    echo "Data berhasil disimpan!";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>