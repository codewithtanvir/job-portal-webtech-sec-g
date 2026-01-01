<!DOCTYPE html>
<html>

<head>
    <title>Browse Jobs - Job Portal</title>
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
        <h2>Find Your Dream Job</h2>

        <div class="search-form">
            <form method="GET" action="index.php">
                <input type="hidden" name="page" value="jobs">
                <input type="hidden" name="action" value="search">

                <div class="form-group">
                    <label>Keyword</label>
                    <input type="text" name="keyword" placeholder="Job title or keyword" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" placeholder="City or state" value="<?php echo isset($_GET['location']) ? htmlspecialchars($_GET['location']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category">
                        <option value="">All Categories</option>
                        <option value="IT" <?php echo (isset($_GET['category']) && $_GET['category'] == 'IT') ? 'selected' : ''; ?>>IT</option>
                        <option value="Marketing" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Marketing') ? 'selected' : ''; ?>>Marketing</option>
                        <option value="Sales" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Sales') ? 'selected' : ''; ?>>Sales</option>
                        <option value="Finance" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Finance') ? 'selected' : ''; ?>>Finance</option>
                        <option value="HR" <?php echo (isset($_GET['category']) && $_GET['category'] == 'HR') ? 'selected' : ''; ?>>HR</option>
                    </select>
                </div>

                <button type="submit" class="btn">Search Jobs</button>
            </form>
        </div>

        <div class="job-list">
            <?php
            if (mysqli_num_rows($jobs) > 0) {
                while ($job = mysqli_fetch_assoc($jobs)) {
            ?>
                    <div class="job-card">
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p><strong><?php echo htmlspecialchars($job['company']); ?></strong></p>
                        <p><?php echo htmlspecialchars($job['location']); ?> | <?php echo htmlspecialchars($job['category']); ?></p>
                        <p><?php echo htmlspecialchars(substr($job['description'], 0, 150)); ?>...</p>
                        <a href="?page=jobs&action=details&id=<?php echo $job['id']; ?>" class="btn">View Details</a>
                    </div>
            <?php
                }
            } else {
                echo "<p>No jobs found.</p>";
            }
            ?>
        </div>
    </div>

    <script src="public/js/job.js"></script>
</body>

</html>
