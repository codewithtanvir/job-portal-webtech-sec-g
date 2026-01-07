<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs - <?php echo SITE_NAME; ?></title>
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
                <h2>Job Listings</h2>
                <a href="index.php?page=job&action=create" class="btn btn-success">Post New Job</a>
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
            
            <?php if(count($jobs) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Job Type</th>
                            <th>Status</th>
                            <th>Posted Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($jobs as $job): ?>
                            <tr>
                                <td><?php echo $job['id']; ?></td>
                                <td><?php echo $job['title']; ?></td>
                                <td><?php echo $job['company_name']; ?></td>
                                <td><?php echo $job['location']; ?></td>
                                <td><?php echo $job['job_type']; ?></td>
                                <td>
                                    <span style="color: <?php echo $job['status'] == 'Open' ? 'green' : 'red'; ?>; font-weight: bold;">
                                        <?php echo $job['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($job['posted_date'])); ?></td>
                                <td>
                                    <a href="index.php?page=job&action=view&id=<?php echo $job['id']; ?>" class="btn">View</a>
                                    <a href="index.php?page=job&action=edit&id=<?php echo $job['id']; ?>" class="btn btn-success">Edit</a>
                                    <?php if($job['status'] == 'Open'): ?>
                                        <a href="index.php?page=job&action=close&id=<?php echo $job['id']; ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Close this job?')">Close</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No jobs found. <a href="index.php?page=job&action=create">Post a job now</a></p>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2026 Job Portal. All rights reserved.</p>
    </footer>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
