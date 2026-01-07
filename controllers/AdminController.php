<?php
require_once ROOT_PATH . 'models/AdminModel.php';

function admin_controller($action)
{
    // Check if user is logged in and is admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit();
    }

    switch ($action) {
        case 'index':
        case 'dashboard':
            admin_dashboard();
            break;

        default:
            admin_dashboard();
            break;
    }
}

function admin_dashboard()
{
    // Get dashboard statistics
    $stats = get_dashboard_stats();
    $recent_activities = get_recent_activities(10);
    $pending_jobs = get_pending_jobs_count();
    $pending_users = get_pending_users_count();

    $page_title = 'Admin Dashboard';
    require_once ROOT_PATH . 'views/admin/dashboard.php';
}
