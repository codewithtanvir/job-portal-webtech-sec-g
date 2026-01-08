<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Job Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    // check if token is present
    if (!isset($_GET['token'])) {
        header("Location: index.php?page=login");
        exit();
    }
    ?>

    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <h2>JobPortal</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php?page=home">Home</a></li>
                <li><a href="index.php?page=login">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Set New Password</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <form action="../app/controllers/UserController.php?action=reset-password" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 JobPortal. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
