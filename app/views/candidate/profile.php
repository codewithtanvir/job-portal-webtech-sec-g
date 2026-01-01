<!DOCTYPE html>
<html>

<head>
    <title>Profile - Job Portal</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <header>
        <h1>Job Portal</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="?page=jobs">Jobs</a>
            <a href="?page=applications">My Applications</a>
            <a href="?page=profile">Profile</a>
            <a href="?page=logout">Logout</a>
        </nav>
    </header>

    <div class="container">
        <div class="job-details">
            <h2>My Profile</h2>

            <p><strong>Name:</strong> <?php echo htmlspecialchars($candidate['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($candidate['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($candidate['phone']); ?></p>

            <?php if (!empty($candidate['resume_path'])) { ?>
                <p><strong>Resume:</strong> <a href="<?php echo htmlspecialchars($candidate['resume_path']); ?>" target="_blank">View Resume</a></p>
            <?php } else { ?>
                <p><strong>Resume:</strong> Not uploaded</p>
            <?php } ?>

            <p><small>Member since: <?php echo date('F j, Y', strtotime($candidate['created_at'])); ?></small></p>

            <a href="?page=apply&action=upload-resume" class="btn">Update Resume</a>
        </div>
    </div>
</body>

</html>
