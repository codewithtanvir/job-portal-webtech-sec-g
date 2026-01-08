<!DOCTYPE html>
<html>

<head>
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/validation.js" defer></script>
</head>

<body>
    <header>
        <h1>Job Portal</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="?page=jobs">Jobs</a>
            <a href="?page=login">Login</a>
            <a href="?page=apply&action=register">Register</a>
        </nav>
    </header>

    <div class="container">
        <div class="job-details">
            <h2>Login</h2>

            <?php if (isset($error)) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>

            <form method="POST" action="?page=login&action=submit">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>

            <p>Don't have an account? <a href="?page=apply&action=register">Register here</a></p>
        </div>
    </div>
</body>

</html>
