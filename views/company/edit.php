<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Company - <?php echo SITE_NAME; ?></title>
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
                    <h2>Edit Company Profile</h2>
                    <a href="index.php?page=company&action=view&id=<?php echo $company['id']; ?>" class="btn">Cancel</a>
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
                    <form method="POST" action="index.php?page=company&action=edit&id=<?php echo $company['id']; ?>" id="companyForm">
                        <div class="form-group">
                            <label for="company_name">Company Name *</label>
                            <input type="text" id="company_name" name="company_name" value="<?php echo $company['company_name']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="<?php echo $company['email']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone *</label>
                            <input type="text" id="phone" name="phone" value="<?php echo $company['phone']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address *</label>
                            <textarea id="address" name="address" required><?php echo $company['address']; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" value="<?php echo $company['website']; ?>" placeholder="https://example.com">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea id="description" name="description" required><?php echo $company['description']; ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Update Company</button>
                    </form>
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
