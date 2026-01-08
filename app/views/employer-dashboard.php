<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require_once '../app/helpers/auth.php';
    requireRole('employer');
    ?>

    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <h2>JobPortal</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php?page=employer-dashboard">Dashboard</a></li>
                <li><a href="index.php?page=post-job">Post Job</a></li>
                <li><a href="index.php?page=my-jobs">My Jobs</a></li>
                <li><a href="../app/controllers/UserController.php?action=logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 3rem;">
        <h1>Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>

        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <div class="feature-cards" style="margin-top: 2rem;">
            <div class="card">
                <h3>Post New Job</h3>
                <p>Create and publish job openings</p>
                <a href="index.php?page=post-job" class="btn">Post Job</a>
            </div>
            <div class="card">
                <h3>My Jobs</h3>
                <p>Manage your posted jobs</p>
                <a href="index.php?page=my-jobs" class="btn">View Jobs</a>
            </div>
            <div class="card">
                <h3>Applications</h3>
                <p>Review job applications</p>
                <a href="index.php?page=applications" class="btn">View Applications</a>
            </div>
        </div>
    </div>
</body>

</html>
