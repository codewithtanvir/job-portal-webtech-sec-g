<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job - <?php echo SITE_NAME; ?></title>
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
                    <h2><?php echo $job['title']; ?></h2>
                    <div>
                        <a href="index.php?page=job&action=edit&id=<?php echo $job['id']; ?>" class="btn btn-success">Edit Job</a>
                        <?php if($job['status'] == 'Open'): ?>
                            <a href="index.php?page=job&action=close&id=<?php echo $job['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Are you sure you want to close this job?')">Close Job</a>
                        <?php else: ?>
                            <a href="index.php?page=job&action=open&id=<?php echo $job['id']; ?>" 
                               class="btn btn-success">Reopen Job</a>
                        <?php endif; ?>
                        <a href="index.php?page=job&action=list" class="btn">Back to Jobs</a>
                    </div>
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
                    <h3>Job Details</h3>
                    <p><strong>Company:</strong> <?php echo $job['company_name']; ?></p>
                    <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
                    <p><strong>Job Type:</strong> <?php echo $job['job_type']; ?></p>
                    <p><strong>Salary Range:</strong> <?php echo $job['salary_range'] ? $job['salary_range'] : 'Negotiable'; ?></p>
                    <p><strong>Status:</strong> 
                        <span style="color: <?php echo $job['status'] == 'Open' ? 'green' : 'red'; ?>; font-weight: bold;">
                            <?php echo $job['status']; ?>
                        </span>
                    </p>
                    <p><strong>Posted Date:</strong> <?php echo date('F d, Y', strtotime($job['posted_date'])); ?></p>
                    <p><strong>Application Deadline:</strong> <?php echo date('F d, Y', strtotime($job['deadline'])); ?></p>
                </div>
                
                <div class="card">
                    <h3>Job Description</h3>
                    <p><?php echo nl2br($job['description']); ?></p>
                </div>
                
                <div class="card">
                    <h3>Requirements</h3>
                    <p><?php echo nl2br($job['requirements']); ?></p>
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
