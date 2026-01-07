<?php
require_once '../core/Auth.php';
if (!auth_is_logged_in()) {
    header('Location: /job-portal/public/auth/login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Job Portal</title>
    <link rel="stylesheet" href="/job-portal/public/css/style.css">
</head>

<body>
    <nav>
        <a href="/job-portal/public/">Home</a>
        <a href="/job-portal/public/auth/logout">Logout</a>
    </nav>

    <div class="container">
        <div class="welcome-banner">
            <h2>Hello, <?php echo $_SESSION['email']; ?>!</h2>
            <p>Welcome back to your dashboard. You are currently logged in as a <strong><?php echo ucfirst($_SESSION['role']); ?></strong>.</p>
        </div>

        <div class="dashboard-grid">
            <div class="dash-card">
                <h3>My Profile</h3>
                <p>Update your personal information and CV.</p>
                <button onclick="alert('Profile feature coming soon!')">Edit Profile</button>
            </div>

            <?php if ($_SESSION['role'] === 'employer'): ?>
                <div class="dash-card">
                    <h3>Post a Job</h3>
                    <p>Create a new job listing for seekers.</p>
                    <button onclick="alert('Job posting coming soon!')">Create Listing</button>
                </div>
                <div class="dash-card">
                    <h3>Applications</h3>
                    <p>View people who applied to your jobs.</p>
                    <button onclick="alert('Applications view coming soon!')">View All</button>
                </div>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'seeker'): ?>
                <div class="dash-card">
                    <h3>Find Jobs</h3>
                    <p>Search and apply for the latest openings.</p>
                    <button onclick="alert('Job search coming soon!')">Browse Jobs</button>
                </div>
                <div class="dash-card">
                    <h3>My Applied Jobs</h3>
                    <p>Check the status of your applications.</p>
                    <button onclick="alert('Status view coming soon!')">Check Status</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        &copy; Job Portal
    </div>
</body>

</html>
