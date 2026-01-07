<?php
session_start();

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Base URL and paths
define('BASE_URL', 'http://localhost/job/');
define('ROOT_PATH', __DIR__ . '/');

// Include configuration
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'config/config.php';

// Get the requested page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Route to appropriate controller
switch ($page) {
    case 'admin':
        require_once ROOT_PATH . 'controllers/AdminController.php';
        admin_controller($action);
        break;

    case 'users':
        require_once ROOT_PATH . 'controllers/UserController.php';
        user_controller($action);
        break;

    case 'jobs':
        require_once ROOT_PATH . 'controllers/JobController.php';
        job_controller($action);
        break;

    case 'categories':
        require_once ROOT_PATH . 'controllers/CategoryController.php';
        category_controller($action);
        break;

    case 'reports':
        require_once ROOT_PATH . 'controllers/ReportController.php';
        report_controller($action);
        break;

    default:
        require_once ROOT_PATH . 'views/home.php';
        break;
}
