<!DOCTYPE html>
<html>

<head>
    <title>Upload Resume - Job Portal</title>
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
            <h2>Upload Your Resume</h2>

            <?php if (isset($error)) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>

            <?php if (isset($success)) { ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php } ?>

            <?php if (!empty($candidate['resume_path'])) { ?>
                <p>Current Resume: <a href="<?php echo $candidate['resume_path']; ?>" target="_blank">View Resume</a></p>
            <?php } ?>

            <form method="POST" action="?page=apply&action=upload-resume" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Select Resume (PDF only)</label>
                    <input type="file" name="resume" accept=".pdf" required>
                </div>

                <button type="submit" class="btn">Upload Resume</button>
            </form>
        </div>
    </div>
</body>

</html>
