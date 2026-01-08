<?php
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'models/AdminModel.php';

// Get all users with optional filters
function get_all_users($filter = 'all', $search = '') {
    $conn = get_db_connection();
    
    $query = "SELECT * FROM users WHERE 1=1";
    
    // Apply filters
    if ($filter != 'all') {
        if (in_array($filter, ['pending', 'approved', 'banned'])) {
            $query .= " AND status = '" . mysqli_real_escape_string($conn, $filter) . "'";
        } else if (in_array($filter, ['admin', 'employer', 'jobseeker'])) {
            $query .= " AND user_type = '" . mysqli_real_escape_string($conn, $filter) . "'";
        }
    }
    
    // Apply search
    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $query .= " AND (username LIKE '%$search%' OR email LIKE '%$search%' OR full_name LIKE '%$search%')";
    }
    
    $query .= " ORDER BY created_at DESC";
    
    $result = mysqli_query($conn, $query);
    $users = array();
    
    while($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    
    return $users;
}

// Get users by status
function get_users_by_status($status) {
    $conn = get_db_connection();
    
    $status = mysqli_real_escape_string($conn, $status);
    $query = "SELECT * FROM users WHERE status = '$status' ORDER BY created_at DESC";
    
    $result = mysqli_query($conn, $query);
    $users = array();
    
    while($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    
    return $users;
}

// Get user by ID
function get_user_by_id($user_id) {
    $conn = get_db_connection();
    
    $user_id = intval($user_id);
    $query = "SELECT * FROM users WHERE id = $user_id";
    
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Update user status
function update_user_status($user_id, $status) {
    $conn = get_db_connection();
    
    $user_id = intval($user_id);
    $status = mysqli_real_escape_string($conn, $status);
    
    $query = "UPDATE users SET status = '$status' WHERE id = $user_id";
    return mysqli_query($conn, $query);
}

// Delete user
function delete_user_by_id($user_id) {
    $conn = get_db_connection();
    
    $user_id = intval($user_id);
    $query = "DELETE FROM users WHERE id = $user_id";
    
    return mysqli_query($conn, $query);
}

// Get user statistics
function get_user_statistics($user_id) {
    $conn = get_db_connection();
    $user_id = intval($user_id);
    
    $stats = array();
    
    // Get user info
    $user = get_user_by_id($user_id);
    
    if ($user['user_type'] == 'employer') {
        // Total jobs posted
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE employer_id = $user_id");
        $stats['total_jobs'] = mysqli_fetch_assoc($result)['count'];
        
        // Active jobs
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE employer_id = $user_id AND status = 'approved'");
        $stats['active_jobs'] = mysqli_fetch_assoc($result)['count'];
        
        // Total applications received
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications a 
                                       JOIN jobs j ON a.job_id = j.id 
                                       WHERE j.employer_id = $user_id");
        $stats['total_applications'] = mysqli_fetch_assoc($result)['count'];
    } else if ($user['user_type'] == 'jobseeker') {
        // Total applications submitted
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE jobseeker_id = $user_id");
        $stats['total_applications'] = mysqli_fetch_assoc($result)['count'];
        
        // Pending applications
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE jobseeker_id = $user_id AND status = 'pending'");
        $stats['pending_applications'] = mysqli_fetch_assoc($result)['count'];
        
        // Accepted applications
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE jobseeker_id = $user_id AND status = 'accepted'");
        $stats['accepted_applications'] = mysqli_fetch_assoc($result)['count'];
    }
    
    return $stats;
}

// Get user's recent activities
function get_user_activities($user_id, $limit = 10) {
    $conn = get_db_connection();
    
    $user_id = intval($user_id);
    $limit = intval($limit);
    
    $query = "SELECT * FROM activity_logs 
              WHERE user_id = $user_id 
              ORDER BY created_at DESC 
              LIMIT $limit";
    
    $result = mysqli_query($conn, $query);
    $activities = array();
    
    while($row = mysqli_fetch_assoc($result)) {
        $activities[] = $row;
    }
    
    return $activities;
}
?>
