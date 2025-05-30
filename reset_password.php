<?php
session_start();
include 'koneksi.php';

if(isset($_POST['reset'])) {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE username=?");
        $stmt->bind_param("ss", $hashed_password, $username);
        if ($stmt->execute()) {
            echo "<script>alert('Password berhasil diubah! Silakan login kembali.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Gagal mengubah password.');</script>";
        }
    } else {
        echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

<div class="wrapper">
    <h1>Reset Password</h1>
    <form method="POST">
        <div class="input-box">
            <input type="text" name="username" placeholder="Masukkan Username" required>
            <i class="fas fa-user"></i>
        </div>
        <div class="input-box">
            <input type="password" name="new_password" placeholder="Password Baru" required>
            <i class="fas fa-lock"></i>
        </div>
        <div class="input-box">
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <i class="fas fa-lock"></i>
        </div>
        <input type="submit" name="reset" value="Reset Password" class="btn">
    </form>
</div>

</body>
</html>
