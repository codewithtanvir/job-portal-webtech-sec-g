<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Job Portal</title>
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
                <li><a href="index.php?page=login">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Create Account</h2>

        <?php
        // show error message if exists
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }

        // show success message
        if (isset($_SESSION['success'])) {
            echo '<div class="success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <form action="../app/controllers/UserController.php?action=register" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <label>Register As</label>
                <select name="user_type" required>
                    <option value="">Select User Type</option>
                    <option value="jobseeker">Job Seeker</option>
                    <option value="employer">Employer</option>
                </select>
            </div>

            <button type="submit" class="btn">Register</button>
        </form>

        <p style="text-align: center; margin-top: 1rem;">
            Already have an account? <a href="index.php?page=login">Login here</a>
        </p>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2026 JobPortal. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
