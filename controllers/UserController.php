<?php
require_once ROOT_PATH . 'models/UserModel.php';

function user_controller($action) {
    // Check if user is logged in and is admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit();
    }
    
    switch($action) {
        case 'index':
        case 'list':
            list_users();
            break;
        
        case 'pending':
            list_pending_users();
            break;
        
        case 'approve':
            approve_user();
            break;
        
        case 'ban':
            ban_user();
            break;
        
        case 'unban':
            unban_user();
            break;
        
        case 'delete':
            delete_user();
            break;
        
        case 'view':
            view_user();
            break;
        
        default:
            list_users();
            break;
    }
}

function list_users() {
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    
    $users = get_all_users($filter, $search);
    
    $page_title = 'User Management';
    require_once ROOT_PATH . 'views/users/list.php';
}

function list_pending_users() {
    $users = get_users_by_status('pending');
    
    $page_title = 'Pending Users';
    require_once ROOT_PATH . 'views/users/pending.php';
}

function approve_user() {
    if (isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
        
        if (update_user_status($user_id, 'approved')) {
            log_activity($_SESSION['user_id'], 'user_approved', "Approved user ID: $user_id");
            $_SESSION['success'] = 'User approved successfully';
        } else {
            $_SESSION['error'] = 'Failed to approve user';
        }
    }
    
    header('Location: ' . BASE_URL . '?page=users');
    exit();
}

function ban_user() {
    if (isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
        
        if (update_user_status($user_id, 'banned')) {
            log_activity($_SESSION['user_id'], 'user_banned', "Banned user ID: $user_id");
            $_SESSION['success'] = 'User banned successfully';
        } else {
            $_SESSION['error'] = 'Failed to ban user';
        }
    }
    
    header('Location: ' . BASE_URL . '?page=users');
    exit();
}

function unban_user() {
    if (isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
        
        if (update_user_status($user_id, 'approved')) {
            log_activity($_SESSION['user_id'], 'user_unbanned', "Unbanned user ID: $user_id");
            $_SESSION['success'] = 'User unbanned successfully';
        } else {
            $_SESSION['error'] = 'Failed to unban user';
        }
    }
    
    header('Location: ' . BASE_URL . '?page=users');
    exit();
}

function delete_user() {
    if (isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
        
        // Prevent deleting own account
        if ($user_id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot delete your own account';
        } else if (delete_user_by_id($user_id)) {
            log_activity($_SESSION['user_id'], 'user_deleted', "Deleted user ID: $user_id");
            $_SESSION['success'] = 'User deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete user';
        }
    }
    
    header('Location: ' . BASE_URL . '?page=users');
    exit();
}

function view_user() {
    if (!isset($_GET['id'])) {
        header('Location: ' . BASE_URL . '?page=users');
        exit();
    }
    
    $user_id = intval($_GET['id']);
    $user = get_user_by_id($user_id);
    
    if (!$user) {
        $_SESSION['error'] = 'User not found';
        header('Location: ' . BASE_URL . '?page=users');
        exit();
    }
    
    // Get user statistics
    $user_stats = get_user_statistics($user_id);
    
    $page_title = 'View User';
    require_once ROOT_PATH . 'views/users/view.php';
}
?>
