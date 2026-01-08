<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Job Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <h2>JobPortal</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php?page=home">Home</a></li>
                <li><a href="index.php?page=login">Login</a></li>
                <li><a href="index.php?page=register">Register</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Reset Password</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            echo '<div class="success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <form action="../app/controllers/UserController.php?action=forgot-password" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
                <small>Enter your registered email to receive reset instructions</small>
            </div>

            <button type="submit" class="btn">Send Reset Link</button>
        </form>

        <p style="text-align: center; margin-top: 1rem;">
            Remember your password? <a href="index.php?page=login">Login here</a>
        </p>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 JobPortal. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
