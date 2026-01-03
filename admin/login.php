<?php
include '../includes/db.php';
include '../public/header.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admins WHERE username='$username'");
    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: qlist.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="upper">
        <div class="login-container">
            <h1>Admin Login</h1>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form method="post">
                <label>Username: <input type="text" name="username"></label><br>
                <label>Password: <input type="password" name="password"></label><br>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
