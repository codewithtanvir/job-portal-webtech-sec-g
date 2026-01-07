<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job - <?php echo SITE_NAME; ?></title>
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
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Post New Job</h2>
                <a href="index.php?page=job&action=list" class="btn">Back to Jobs</a>
            </div>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if(count($companies) > 0): ?>
                <div class="card">
                    <form method="POST" action="index.php?page=job&action=create" id="jobForm">
                        <div class="form-group">
                            <label for="company_id">Select Company *</label>
                            <select id="company_id" name="company_id" required>
                                <option value="">-- Select Company --</option>
                                <?php foreach($companies as $company): ?>
                                    <option value="<?php echo $company['id']; ?>"><?php echo $company['company_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="title">Job Title *</label>
                            <input type="text" id="title" name="title" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Job Description *</label>
                            <textarea id="description" name="description" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="requirements">Requirements *</label>
                            <textarea id="requirements" name="requirements" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="salary_range">Salary Range</label>
                            <input type="text" id="salary_range" name="salary_range" placeholder="e.g., 50000-80000">
                        </div>
                        
                        <div class="form-group">
                            <label for="location">Location *</label>
                            <input type="text" id="location" name="location" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="job_type">Job Type *</label>
                            <select id="job_type" name="job_type" required>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="posted_date">Posted Date *</label>
                            <input type="date" id="posted_date" name="posted_date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="deadline">Application Deadline *</label>
                            <input type="date" id="deadline" name="deadline" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Post Job</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-error">
                    No companies found. Please <a href="index.php?page=company&action=create">create a company</a> first.
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2026 Job Portal. All rights reserved.</p>
    </footer>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
