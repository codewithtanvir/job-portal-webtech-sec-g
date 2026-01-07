<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav>
            <h1><?php echo SITE_NAME; ?></h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?page=company&action=profile">Company Profile</a></li>
                <li><a href="index.php?page=job&action=list">Jobs</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Welcome to Job Portal</h2>
            <p>Find your dream job or post job vacancies for your company.</p>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Job Portal. All rights reserved.</p>
    </footer>
</body>

</html>
