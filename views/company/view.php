<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Company - <?php echo SITE_NAME; ?></title>
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
            <?php if($company): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2><?php echo $company['company_name']; ?></h2>
                    <div>
                        <a href="index.php?page=company&action=edit&id=<?php echo $company['id']; ?>" class="btn btn-success">Edit Profile</a>
                        <a href="index.php?page=company&action=list" class="btn">Back to List</a>
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
                
                <div class="card">
                    <h3>Company Information</h3>
                    <p><strong>Email:</strong> <?php echo $company['email']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $company['phone']; ?></p>
                    <p><strong>Address:</strong> <?php echo $company['address']; ?></p>
                    <p><strong>Website:</strong> 
                        <?php if($company['website']): ?>
                            <a href="<?php echo $company['website']; ?>" target="_blank"><?php echo $company['website']; ?></a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </p>
                    <p><strong>Description:</strong><br><?php echo nl2br($company['description']); ?></p>
                    <p><strong>Created:</strong> <?php echo date('F d, Y', strtotime($company['created_at'])); ?></p>
                    <p><strong>Last Updated:</strong> <?php echo date('F d, Y', strtotime($company['updated_at'])); ?></p>
                </div>
            <?php else: ?>
                <div class="alert alert-error">Company not found.</div>
                <a href="index.php?page=company&action=list" class="btn">Back to List</a>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2026 Job Portal. All rights reserved.</p>
    </footer>
    
    <script src="assets/js/main.js"></script>
</body>
</html>
