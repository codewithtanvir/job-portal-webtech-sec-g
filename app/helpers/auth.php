<?php
// Authentication helper functions
// this file contains functions for checking user access

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = "Please login to continue";
        header("Location: index.php?page=login");
        exit();
    }
}

function requireRole($role) {
    requireLogin();
    
    if ($_SESSION['user_type'] != $role) {
        $_SESSION['error'] = "Access denied. You don't have permission";
        header("Location: index.php?page=login");
        exit();
    }
}

function requireRoles($roles) {
    requireLogin();
    
    if (!in_array($_SESSION['user_type'], $roles)) {
        $_SESSION['error'] = "Access denied. You don't have permission";
        header("Location: index.php?page=login");
        exit();
    }
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user_type'] == 'admin';
}

function isEmployer() {
    return isLoggedIn() && $_SESSION['user_type'] == 'employer';
}

function isJobSeeker() {
    return isLoggedIn() && $_SESSION['user_type'] == 'jobseeker';
}

?>
