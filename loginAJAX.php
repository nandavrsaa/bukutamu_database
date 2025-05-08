<?php 
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Buku Tamu</title>
    <style>
        body {
            font-family: Arial;
            background-color: #ffe6f2;
            text-align: center;
            color: #d63384;
        }
        .container {
            margin: auto;
            margin-top: 100px;
            width: 40%;
            background-color: #fff0f5;
            padding: 30px;
            border: 2px solid #ff66b2;
            border-radius: 15px;
            box-shadow: 0 0 10px #ff99cc;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            width: 80%;
            margin-bottom: 15px;
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
        #error-msg {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Login Buku Tamu</h1>
    <form id="loginForm">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Login">
    </form>
    <div id="error-msg"></div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch('proses_login.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(response => {
        if (response.trim() === 'success') {
            window.location.href = 'dasboard.php'; // arahkan ke dashboard jika login berhasil
        } else {
            document.getElementById('error-msg').innerText = response;
        }
    })
    .catch(error => {
        document.getElementById('error-msg').innerText = 'Terjadi kesalahan. Silakan coba lagi.';
    });
});
</script>
</body>
</html>
