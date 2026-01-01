<!DOCTYPE html>
<html>

<head>
    <title>Job Portal</title>
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
        <h2>Welcome to Job Portal</h2>
        <p>Find your dream job today!</p>
        <a href="?page=jobs" class="btn">Browse Jobs</a>
    </div>
</body>

</html>
