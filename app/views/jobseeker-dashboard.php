<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require_once '../app/helpers/auth.php';
    requireRole('jobseeker');
    ?>

    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <h2>JobPortal</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php?page=jobseeker-dashboard">Dashboard</a></li>
                <li><a href="index.php?page=jobs">Browse Jobs</a></li>
                <li><a href="index.php?page=my-applications">My Applications</a></li>
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
                <h3>Browse Jobs</h3>
                <p>Find and apply to jobs that match your skills</p>
                <a href="index.php?page=jobs" class="btn">Browse Now</a>
            </div>
            <div class="card">
                <h3>My Applications</h3>
                <p>Track your job applications</p>
                <a href="index.php?page=my-applications" class="btn">View Applications</a>
            </div>
            <div class="card">
                <h3>Profile</h3>
                <p>Update your profile and resume</p>
                <a href="index.php?page=profile" class="btn">Edit Profile</a>
            </div>
        </div>
    </div>
</body>

</html>
