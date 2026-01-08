<?php
session_start();
require_once(__DIR__ . '/../models/AdminHomeModel.php');
require_once(__DIR__ . '/../models/AdminUserModel.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: candidate/login.php");
    exit();
}
$stats = getDashboardStats();
$users = getAllUsers();
$message = isset($_GET['msg']) ? $_GET['msg'] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../public/css/admin_homestyle.css">
    <link rel="stylesheet" href="../../public/css/admin_userStyle.css" />
</head>

<body>
    <div class="header">
        <h2>Admin Dashboard - Welcome, <?php echo $_SESSION['username']; ?></h2>
        <?php if (!empty($message)): ?>
            <span style="background: #dcfce7; color: #166534; padding: 5px 15px; border-radius: 4px; margin-left: 20px;"><?= $message ?></span>
        <?php endif; ?>
        <a href="candidate/logout.php" style="text-decoration: none;"><button class="logout-btn">Logout</button></a>
    </div>
    <div class="sidebar">
        <ul>
            <li onclick="showSection('overview')">Overview</li>
            <li onclick="showSection('manageUsers')">User Management</li>
            <li onclick="showSection('categories')">Category Management</li>
        </ul>

    </div>
    <div class="main">
        <div id="overview">
            <h3>Overview</h3>
            <div class="card">
                <h3>Users</h3>
                <p>Total Users:<?php echo $stats['users']; ?></p>
            </div>
            <div class="card">
                <h3>Employers</h3>
                <p>Active Employers: <?php echo $stats['employers']; ?></p>
            </div>
        </div>
        <?php
        require_once(__DIR__ . '/jobs/AdminUserManagement.php');
        ?>
        <?php
        require_once(__DIR__ . '/jobs/AdminCategoryManagement.php');
        ?>
    </div>
    <script src="../../public/js/admin_script.js"></script>
</body>

</html>