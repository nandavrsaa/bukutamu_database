<?php
session_start();
$koneksi = new mysqli("localhost", "root", "123", "bukutamu", 3307);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $koneksi->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        if ($password === $stored_password) {
            $_SESSION['username'] = $username;
            echo 'success';
        } else {
            echo 'Password salah!';
        }
    } else {
        echo 'Username tidak ditemukan!';
    }
}
?>
