<!DOCTYPE html>
<html>

<head>
    <title>My Applications - Job Portal</title>
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
        <h2>My Applications</h2>

        <?php if (mysqli_num_rows($applications) > 0) { ?>
            <ul class="application-list">
                <?php while ($app = mysqli_fetch_assoc($applications)) { ?>
                    <li class="application-item">
                        <h3><?php echo htmlspecialchars($app['title']); ?></h3>
                        <p><strong><?php echo htmlspecialchars($app['company']); ?></strong></p>
                        <p><?php echo htmlspecialchars($app['location']); ?></p>
                        <p>Applied on: <?php echo date('F j, Y', strtotime($app['applied_at'])); ?></p>
                        <p>
                            Status:
                            <span class="status status-<?php echo $app['status']; ?>">
                                <?php echo ucfirst($app['status']); ?>
                            </span>
                        </p>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>You haven't applied to any jobs yet.</p>
            <a href="?page=jobs" class="btn">Browse Jobs</a>
        <?php } ?>
    </div>
</body>

</html>
