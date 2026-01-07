<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Details - <?php echo SITE_NAME; ?></title>
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
            <?php if($application): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Applicant Details</h2>
                    <a href="index.php?page=applicant&action=list&job_id=<?php echo $application['job_id']; ?>" class="btn">Back to Applicants</a>
                </div>
                
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            echo $_SESSION['success']; 
                            unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <h3>Application Information</h3>
                    <p><strong>Application ID:</strong> <?php echo $application['id']; ?></p>
                    <p><strong>Job:</strong> <?php echo $application['job_title']; ?></p>
                    <p><strong>Company:</strong> <?php echo $application['company_name']; ?></p>
                    <p><strong>Applied Date:</strong> <?php echo date('F d, Y', strtotime($application['applied_date'])); ?></p>
                    <p><strong>Status:</strong> 
                        <?php
                        $status_colors = array(
                            'Pending' => '#3498db',
                            'Shortlisted' => '#27ae60',
                            'Rejected' => '#e74c3c',
                            'Hired' => '#9b59b6'
                        );
                        $color = $status_colors[$application['status']];
                        ?>
                        <span style="color: <?php echo $color; ?>; font-weight: bold;">
                            <?php echo $application['status']; ?>
                        </span>
                    </p>
                    <?php if($application['notes']): ?>
                        <p><strong>Notes:</strong> <?php echo nl2br($application['notes']); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="card">
                    <h3>Applicant Information</h3>
                    <p><strong>Name:</strong> <?php echo $application['name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $application['email']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $application['phone']; ?></p>
                    <?php if($application['resume']): ?>
                        <p><strong>Resume:</strong> <a href="<?php echo $application['resume']; ?>" target="_blank">Download</a></p>
                    <?php endif; ?>
                </div>
                
                <div class="card">
                    <h3>Cover Letter</h3>
                    <p><?php echo nl2br($application['cover_letter']); ?></p>
                </div>
                
                <div class="card">
                    <h3>Actions</h3>
                    <p>Use the Shortlist/Reject feature to update the status of this application.</p>
                    <a href="index.php?page=applicant&action=list&job_id=<?php echo $application['job_id']; ?>" class="btn">View All Applicants</a>
                </div>
            <?php else: ?>
                <div class="alert alert-error">Application not found.</div>
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
