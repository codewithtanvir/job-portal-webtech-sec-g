<?php
$page_title = 'Welcome';
require_once ROOT_PATH . 'views/layouts/header.php';
?>

<div class="container">
    <div class="hero">
        <h1>Welcome to <?php echo APP_NAME; ?></h1>
        <p>Find your dream job or hire the best talent</p>
        <div class="cta-buttons">
            <a href="<?php echo BASE_URL; ?>?page=auth&action=register" class="btn btn-primary">Get Started</a>
            <a href="<?php echo BASE_URL; ?>?page=jobs" class="btn btn-secondary">Browse Jobs</a>
        </div>
    </div>

    <div class="features">
        <div class="feature-card">
            <h3>For Job Seekers</h3>
            <p>Find and apply for jobs that match your skills and interests</p>
        </div>
        <div class="feature-card">
            <h3>For Employers</h3>
            <p>Post jobs and find qualified candidates for your company</p>
        </div>
        <div class="feature-card">
            <h3>Easy Management</h3>
            <p>Simple and intuitive interface for managing applications</p>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
