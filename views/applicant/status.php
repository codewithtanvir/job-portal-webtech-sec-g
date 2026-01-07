<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Application Status - <?php echo SITE_NAME; ?></title>
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
                    <h2>Update Application Status</h2>
                    <a href="index.php?page=applicant&action=list&job_id=<?php echo $application['job_id']; ?>" class="btn">Back to Applicants</a>
                </div>
                
                <div class="card">
                    <h3>Applicant Information</h3>
                    <p><strong>Name:</strong> <?php echo $application['name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $application['email']; ?></p>
                    <p><strong>Job:</strong> <?php echo $application['job_title']; ?></p>
                    <p><strong>Current Status:</strong> 
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
                </div>
                
                <div class="card">
                    <h3>Quick Actions</h3>
                    <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <form method="POST" action="index.php?page=applicant&action=shortlist&id=<?php echo $application['id']; ?>" style="display: inline;">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Shortlist this candidate?')">
                                Shortlist
                            </button>
                        </form>
                        
                        <form method="POST" action="index.php?page=applicant&action=reject&id=<?php echo $application['id']; ?>" style="display: inline;">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this candidate?')">
                                Reject
                            </button>
                        </form>
                        
                        <form method="POST" action="index.php?page=applicant&action=hire&id=<?php echo $application['id']; ?>" style="display: inline;">
                            <button type="submit" class="btn" style="background: #9b59b6;" onclick="return confirm('Mark as hired?')">
                                Mark as Hired
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <h3>Update Status with Notes</h3>
                    
                    <form method="POST" action="index.php?page=applicant&action=shortlist&id=<?php echo $application['id']; ?>">
                        <h4>Shortlist Candidate</h4>
                        <div class="form-group">
                            <label for="notes_shortlist">Notes (Optional)</label>
                            <textarea id="notes_shortlist" name="notes" placeholder="Add any notes about this candidate..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Shortlist with Notes</button>
                    </form>
                    
                    <hr style="margin: 20px 0;">
                    
                    <form method="POST" action="index.php?page=applicant&action=reject&id=<?php echo $application['id']; ?>">
                        <h4>Reject Candidate</h4>
                        <div class="form-group">
                            <label for="notes_reject">Notes (Optional)</label>
                            <textarea id="notes_reject" name="notes" placeholder="Add any notes about this decision..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Reject with Notes</button>
                    </form>
                    
                    <hr style="margin: 20px 0;">
                    
                    <form method="POST" action="index.php?page=applicant&action=hire&id=<?php echo $application['id']; ?>">
                        <h4>Mark as Hired</h4>
                        <div class="form-group">
                            <label for="notes_hire">Notes (Optional)</label>
                            <textarea id="notes_hire" name="notes" placeholder="Add any notes about the hiring..."></textarea>
                        </div>
                        <button type="submit" class="btn" style="background: #9b59b6;">Mark as Hired with Notes</button>
                    </form>
                </div>
                
                <div class="card">
                    <h3>View Full Application</h3>
                    <a href="index.php?page=applicant&action=view&id=<?php echo $application['id']; ?>" class="btn">View Complete Details</a>
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
