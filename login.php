<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        if (empty($row['role'])) {
            $updateRole = $conn->prepare("UPDATE users SET role='user' WHERE username=?");
            $updateRole->bind_param("s", $username);
            $updateRole->execute();
            $row['role'] = 'user';
        }

        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<div class="wrapper">
    <h1>Login</h1>
    <form method="POST">
        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
            <i class="fas fa-user"></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class="fas fa-lock"></i>
        </div>
        <div class="remember">
            <a href="reset_password.php" style="color: #1e90ff;">Lupa Password?</a>
        </div>
        <input type="submit" name="login" value="Login" class="btn">
    </form>
</div>

</body>
</html>