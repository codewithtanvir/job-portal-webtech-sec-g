<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - Job Portal</title>
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
                <?php if (isLoggedIn()): ?>
                    <li><a href="../app/controllers/UserController.php?action=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="index.php?page=login">Login</a></li>
                    <li><a href="index.php?page=register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 5rem; text-align: center;">
        <h1 style="color: #e74c3c;">Access Denied</h1>
        <p style="font-size: 1.2rem; margin: 2rem 0;">
            You don't have permission to access this page.
        </p>
        
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error" style="max-width: 500px; margin: 0 auto;">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <a href="index.php?page=home" class="btn" style="display: inline-block; width: auto; padding: 1rem 2rem;">
            Go to Home
        </a>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 JobPortal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
