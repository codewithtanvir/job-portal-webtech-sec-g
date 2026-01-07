<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job - <?php echo SITE_NAME; ?></title>
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
                    <h2>Edit Job</h2>
                    <a href="index.php?page=job&action=view&id=<?php echo $job['id']; ?>" class="btn">Cancel</a>
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
                    <form method="POST" action="index.php?page=job&action=edit&id=<?php echo $job['id']; ?>" id="jobForm">
                        <div class="form-group">
                            <label for="company">Company</label>
                            <input type="text" id="company" value="<?php echo $job['company_name']; ?>" disabled>
                            <small>Company cannot be changed</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="title">Job Title *</label>
                            <input type="text" id="title" name="title" value="<?php echo $job['title']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Job Description *</label>
                            <textarea id="description" name="description" required><?php echo $job['description']; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="requirements">Requirements *</label>
                            <textarea id="requirements" name="requirements" required><?php echo $job['requirements']; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="salary_range">Salary Range</label>
                            <input type="text" id="salary_range" name="salary_range" value="<?php echo $job['salary_range']; ?>" placeholder="e.g., 50000-80000">
                        </div>
                        
                        <div class="form-group">
                            <label for="location">Location *</label>
                            <input type="text" id="location" name="location" value="<?php echo $job['location']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="job_type">Job Type *</label>
                            <select id="job_type" name="job_type" required>
                                <option value="Full-time" <?php echo $job['job_type'] == 'Full-time' ? 'selected' : ''; ?>>Full-time</option>
                                <option value="Part-time" <?php echo $job['job_type'] == 'Part-time' ? 'selected' : ''; ?>>Part-time</option>
                                <option value="Contract" <?php echo $job['job_type'] == 'Contract' ? 'selected' : ''; ?>>Contract</option>
                                <option value="Internship" <?php echo $job['job_type'] == 'Internship' ? 'selected' : ''; ?>>Internship</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="posted_date">Posted Date</label>
                            <input type="date" id="posted_date" value="<?php echo $job['posted_date']; ?>" disabled>
                            <small>Posted date cannot be changed</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="deadline">Application Deadline *</label>
                            <input type="date" id="deadline" name="deadline" value="<?php echo $job['deadline']; ?>" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Update Job</button>
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
