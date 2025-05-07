<?php
session_start();

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "123", "bukutamu", 3307);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil password dari database berdasarkan username
    $stmt = $koneksi->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username); // Mengikat parameter username
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];  // Password yang disimpan di database

        // Verifikasi password yang dimasukkan langsung
        if ($password === $stored_password) {
            $_SESSION['username'] = $username; // Simpan session
            header("Location: dasboard.php");  // Arahkan ke dashboard setelah login berhasil
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buku Tamu</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-color: #ffe6f2;
            color: #d63384;
        }
        .container { 
            width: 50%; 
            margin: auto; 
            padding: 20px; 
            border: 2px solid #ff66b2; 
            border-radius: 15px; 
            background-color: #fff0f5;
            box-shadow: 0px 0px 10px #ff99cc;
        }
        h1 { color: #ff3399; }
        input[type="text"], input[type="password"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ff66b2;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #ff3399;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #d63384;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>BUKU TAMU</h1>
    </div>
    <hr>
    <div class="container">
        <h1>Login</h1>
        <form action="" method="post">
            Username: <input type="text" name="username" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <input type="submit" name="login" value="Login">
        </form>
        <?php
            if (isset($error)) {
                echo "<p style='color:red;'>$error</p>";
            }
        ?>
    </div>
</body>
</html>
