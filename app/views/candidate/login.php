<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="../../../public/css/admin_homestyle.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red; text-align: center;"><?php echo $_SESSION['error'];
                                                        unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <form action="../../controllers/AuthController.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required value="<?php echo isset($_COOKIE['user_login']) ? $_COOKIE['user_login'] : ''; ?>">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember Me</label>
            </div>
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
    </div>
</body>

</html>