<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($job['title']); ?> - Job Portal</title>
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
            <h2><?php echo htmlspecialchars($job['title']); ?></h2>
            <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($job['category']); ?></p>

            <?php if (!empty($job['salary'])) { ?>
                <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
            <?php } ?>

            <?php if (!empty($job['job_type'])) { ?>
                <p><strong>Job Type:</strong> <?php echo htmlspecialchars($job['job_type']); ?></p>
            <?php } ?>

            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>

            <h3>Requirements</h3>
            <p><?php echo nl2br(htmlspecialchars($job['requirements'])); ?></p>

            <p><small>Posted on: <?php echo date('F j, Y', strtotime($job['created_at'])); ?></small></p>

            <a href="?page=apply&action=form&job_id=<?php echo $job['id']; ?>" class="btn">Apply Now</a>
            <a href="?page=jobs" class="btn" style="background: #95a5a6;">Back to Jobs</a>
        </div>
    </div>
</body>

</html>
