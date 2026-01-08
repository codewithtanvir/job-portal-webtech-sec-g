<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require_once '../app/helpers/auth.php';
    requireRole('admin');
    ?>

    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <h2>JobPortal Admin</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php?page=admin-dashboard">Dashboard</a></li>
                <li><a href="index.php?page=manage-users">Users</a></li>
                <li><a href="index.php?page=manage-jobs">Jobs</a></li>
                <li><a href="../app/controllers/UserController.php?action=logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 3rem;">
        <h1>Admin Dashboard</h1>

        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <div class="feature-cards" style="margin-top: 2rem;">
            <div class="card">
                <h3>Manage Users</h3>
                <p>Approve, ban or delete users</p>
                <a href="index.php?page=manage-users" class="btn">Manage</a>
            </div>
            <div class="card">
                <h3>Manage Jobs</h3>
                <p>Approve or reject job posts</p>
                <a href="index.php?page=manage-jobs" class="btn">Manage</a>
            </div>
            <div class="card">
                <h3>Categories</h3>
                <p>Manage job categories</p>
                <a href="index.php?page=manage-categories" class="btn">Manage</a>
            </div>
        </div>
    </div>
</body>

</html>
