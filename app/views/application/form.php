<!DOCTYPE html>
<html>

<head>
    <title>Apply for Job - Job Portal</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <header>
        <h1>Job Portal</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="?page=jobs">Jobs</a>
            <a href="?page=applications">My Applications</a>
        </nav>
    </header>

    <div class="container">
        <div class="job-details">
            <h2>Apply for: <?php echo htmlspecialchars($job['title']); ?></h2>
            <p><strong><?php echo htmlspecialchars($job['company']); ?></strong></p>

            <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>

            <form method="POST" action="?page=apply&action=submit">
                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn">Submit Application</button>
            </form>

            <p>Don't have an account? <a href="?page=apply&action=register">Register here</a></p>
        </div>
    </div>
</body>

</html>