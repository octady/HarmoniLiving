<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <style>
        .remember {
            text-align: center;
            margin-top: 15px; 
        }
        .btn {
            margin-bottom: 30px; 
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Register</h1>
        <form method="POST">
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="register" class="btn">Register</button>
            
            <div class="remember">
                <p>Sudah punya akun? <a href="login.php" style="color: #1e90ff";>Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>

