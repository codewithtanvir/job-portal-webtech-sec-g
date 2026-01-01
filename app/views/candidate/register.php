<!DOCTYPE html>
<html>

<head>
    <title>Register - Job Portal</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <header>
        <h1>Job Portal</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="?page=jobs">Jobs</a>
            <?php if (isset($_SESSION['candidate_id'])) { ?>
                <a href="?page=applications">My Applications</a>
                <a href="?page=profile">Profile</a>
                <a href="?page=logout">Logout</a>
            <?php } else { ?>
                <a href="?page=login">Login</a>
                <a href="?page=apply&action=register">Register</a>
            <?php } ?>
        </nav>
    </header>

    <div class="container">
        <div class="job-details">
            <h2>Create Account</h2>

            <?php if (isset($error)) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>

            <?php if (isset($success)) { ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php } ?>

            <form method="POST" action="?page=apply&action=register">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn">Register</button>
            </form>
        </div>
    </div>
</body>

</html>
