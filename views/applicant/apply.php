<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <h1><?php echo SITE_NAME; ?></h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?page=company&action=list">Companies</a></li>
                <li><a href="index.php?page=job&action=list">Jobs</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="container">
            <?php if($job): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Apply for: <?php echo $job['title']; ?></h2>
                    <a href="index.php?page=job&action=view&id=<?php echo $job['id']; ?>" class="btn">Back to Job</a>
                </div>
                
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <h3>Job Information</h3>
                    <p><strong>Company:</strong> <?php echo $job['company_name']; ?></p>
                    <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
                    <p><strong>Job Type:</strong> <?php echo $job['job_type']; ?></p>
                </div>
                
                <div class="card">
                    <h3>Application Form</h3>
                    <form method="POST" action="index.php?page=applicant&action=apply&job_id=<?php echo $job['id']; ?>" id="applicationForm">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone *</label>
                            <input type="text" id="phone" name="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="cover_letter">Cover Letter *</label>
                            <textarea id="cover_letter" name="cover_letter" required placeholder="Tell us why you're a great fit for this position..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Submit Application</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-error">Job not found.</div>
                <a href="index.php?page=job&action=list" class="btn">Back to Jobs</a>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2026 Job Portal. All rights reserved.</p>
    </footer>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
