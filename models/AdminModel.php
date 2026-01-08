<?php
require_once ROOT_PATH . 'config/database.php';

// Get dashboard statistics
function get_dashboard_stats()
{
    $conn = get_db_connection();

    $stats = array();

    // Total users
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
    $stats['total_users'] = mysqli_fetch_assoc($result)['count'];

    // Total jobs
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs");
    $stats['total_jobs'] = mysqli_fetch_assoc($result)['count'];

    // Total applications
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications");
    $stats['total_applications'] = mysqli_fetch_assoc($result)['count'];

    // Total categories
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM categories WHERE status = 'active'");
    $stats['total_categories'] = mysqli_fetch_assoc($result)['count'];

    // Pending jobs
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE status = 'pending'");
    $stats['pending_jobs'] = mysqli_fetch_assoc($result)['count'];

    // Pending users
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE status = 'pending'");
    $stats['pending_users'] = mysqli_fetch_assoc($result)['count'];

    // Approved jobs
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE status = 'approved'");
    $stats['approved_jobs'] = mysqli_fetch_assoc($result)['count'];

    // Approved users
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE status = 'approved'");
    $stats['approved_users'] = mysqli_fetch_assoc($result)['count'];

    return $stats;
}

// Get recent activities
function get_recent_activities($limit = 10)
{
    $conn = get_db_connection();

    $query = "SELECT al.*, u.username
              FROM activity_logs al
              LEFT JOIN users u ON al.user_id = u.id
              ORDER BY al.created_at DESC
              LIMIT " . intval($limit);

    $result = mysqli_query($conn, $query);
    $activities = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $activities[] = $row;
    }

    return $activities;
}

// Get pending jobs count
function get_pending_jobs_count()
{
    $conn = get_db_connection();

    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE status = 'pending'");
    return mysqli_fetch_assoc($result)['count'];
}

// Get pending users count
function get_pending_users_count()
{
    $conn = get_db_connection();

    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE status = 'pending'");
    return mysqli_fetch_assoc($result)['count'];
}

// Log activity
function log_activity($user_id, $action, $description)
{
    $conn = get_db_connection();

    $user_id = mysqli_real_escape_string($conn, $user_id);
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);
    $ip_address = $_SERVER['REMOTE_ADDR'];

    $query = "INSERT INTO activity_logs (user_id, action, description, ip_address)
              VALUES ('$user_id', '$action', '$description', '$ip_address')";

    return mysqli_query($conn, $query);
}

// Get recent users
function get_recent_users($limit = 5)
{
    $conn = get_db_connection();

    $query = "SELECT id, username, email, full_name, user_type, status, created_at
              FROM users
              ORDER BY created_at DESC
              LIMIT " . intval($limit);

    $result = mysqli_query($conn, $query);
    $users = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}

// Get recent jobs
function get_recent_jobs($limit = 5)
{
    $conn = get_db_connection();

    $query = "SELECT j.*, u.username as employer_name, c.name as category_name
              FROM jobs j
              LEFT JOIN users u ON j.employer_id = u.id
              LEFT JOIN categories c ON j.category_id = c.id
              ORDER BY j.created_at DESC
              LIMIT " . intval($limit);

    $result = mysqli_query($conn, $query);
    $jobs = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }

    return $jobs;
}
