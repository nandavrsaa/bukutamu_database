<?php
session_start();
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "123", "bukutamu", 3307);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses pengisian buku tamu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['pesan'])) {
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);
        $pesan = htmlspecialchars($_POST['pesan']);
        if (!empty($nama) && !empty($email) && !empty($pesan)) {
            $stmt = $koneksi->prepare("INSERT INTO tamu (nama, email, pesan) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $pesan);
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Mengambil daftar tamu
$tamu_list = [];
$result = $koneksi->query("SELECT nama, email, pesan FROM tamu");
while ($row = $result->fetch_assoc()) {
    $tamu_list[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital</title>
    <style>
        /* Gaya CSS kamu tetap bagus */
        body { font-family: Arial, sans-serif; background-color: #ffe6f2; color: #d63384; padding: 40px; }
        .container { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 30px; }
        .box { flex: 1 1 45%; background-color: #fff0f5; padding: 25px; border: 3px solid #ff66b2; border-radius: 20px; box-shadow: 0px 0px 10px #ff99cc; }
        h1 { text-align: center; color: #ff3399; margin-bottom: 20px; }
        h2 { text-align: center; }
        form { display: flex; flex-direction: column; }
        input, textarea { padding: 10px; margin-bottom: 15px; border: 1px solid #ff66b2; border-radius: 5px; }
        input[type="submit"] { background-color: #ff3399; color: white; cursor: pointer; font-weight: bold; }
        input[type="submit"]:hover { background-color: #d63384; }
        ul { list-style: none; padding-left: 0; }
        li { margin-bottom: 10px; background: #fff; padding: 10px; border-left: 4px solid #ff66b2; border-radius: 5px; }
        .logout-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #ff3399; color: white; text-decoration: none; border-radius: 5px; }
        .logout-btn:hover { background-color: #d63384; }
    </style>
</head>
<body>

    <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <div class="container">
        <!-- Kolom Form -->
        <div class="box">
            <h2>Isi Buku Tamu</h2>
            <form method="post">
                <input type="text" name="nama" placeholder="Nama" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="pesan" placeholder="Pesan" required></textarea>
                <input type="submit" value="Kirim">
            </form>
        </div>

        <!-- Kolom Daftar Tamu -->
        <div class="box">
            <h2>Daftar Tamu</h2>
            <ul>
                <?php 
                foreach ($tamu_list as $tamu) : 
                    ?>
                    <li><strong><?= htmlspecialchars($tamu['nama']); ?></strong> (<?= htmlspecialchars($tamu['email']); ?>): <?= htmlspecialchars($tamu['pesan']); ?></li>
                <?php 
                endforeach; 
                ?>
            </ul>
        </div>
    </div> <!-- Penutup .container -->

    <!-- Tombol Logout di bawah halaman -->
    <div style="text-align: center; margin-top: 40px;">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>
