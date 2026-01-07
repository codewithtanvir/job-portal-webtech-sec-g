<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applicants - <?php echo SITE_NAME; ?></title>
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
                    <h2>Applicants for: <?php echo $job['title']; ?></h2>
                    <a href="index.php?page=job&action=view&id=<?php echo $job['id']; ?>" class="btn">Back to Job</a>
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
                
                <!-- Statistics -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">
                    <div class="card" style="text-align: center;">
                        <h3 style="color: #3498db;"><?php echo $pending_count; ?></h3>
                        <p>Pending</p>
                    </div>
                    <div class="card" style="text-align: center;">
                        <h3 style="color: #27ae60;"><?php echo $shortlisted_count; ?></h3>
                        <p>Shortlisted</p>
                    </div>
                    <div class="card" style="text-align: center;">
                        <h3 style="color: #e74c3c;"><?php echo $rejected_count; ?></h3>
                        <p>Rejected</p>
                    </div>
                    <div class="card" style="text-align: center;">
                        <h3 style="color: #9b59b6;"><?php echo $hired_count; ?></h3>
                        <p>Hired</p>
                    </div>
                </div>
                
                <?php if(count($applications) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($applications as $application): ?>
                                <tr>
                                    <td><?php echo $application['id']; ?></td>
                                    <td><?php echo $application['name']; ?></td>
                                    <td><?php echo $application['email']; ?></td>
                                    <td><?php echo $application['phone']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($application['applied_date'])); ?></td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="index.php?page=applicant&action=view&id=<?php echo $application['id']; ?>" class="btn">View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="card">
                        <p>No applications received yet for this job.</p>
                    </div>
                <?php endif; ?>
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
