<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Job Portal</title>
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
                <li><a href="index.php?page=jobs">Jobs</a></li>
                <li><a href="index.php?page=about">About</a></li>
                <li><a href="index.php?page=register">Register</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Login to Your Account</h2>

        <?php
        // display error message
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }

        // display success message
        if (isset($_SESSION['success'])) {
            echo '<div class="success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <form action="../app/controllers/UserController.php?action=login" method="POST">
            <div class="form-group">
                <label>Email or Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <p style="text-align: center; margin-top: 1rem;">
            <a href="index.php?page=forgot-password">Forgot Password?</a>
        </p>

        <p style="text-align: center; margin-top: 0.5rem;">
            Don't have an account? <a href="index.php?page=register">Register here</a>
        </p>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 JobPortal. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
