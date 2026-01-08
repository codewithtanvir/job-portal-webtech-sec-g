<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . APP_NAME : APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?php echo BASE_URL . $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="<?php echo BASE_URL; ?>"><?php echo APP_NAME; ?></a>
            </div>
            <ul class="nav-menu">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_type'] == 'admin'): ?>
                        <li><a href="<?php echo BASE_URL; ?>?page=admin">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?page=users">Users</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?page=jobs">Jobs</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?page=categories">Categories</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?page=reports">Reports</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo BASE_URL; ?>?page=auth&action=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo BASE_URL; ?>?page=auth&action=login">Login</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?page=auth&action=register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="main-content">
