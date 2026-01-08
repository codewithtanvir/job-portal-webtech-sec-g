<?php
session_start();

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Base URL and paths
define('BASE_URL', 'http://localhost/job/');
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// Include configuration
require_once ROOT_PATH . 'config' . DIRECTORY_SEPARATOR . 'database.php';
require_once ROOT_PATH . 'config' . DIRECTORY_SEPARATOR . 'config.php';

// Get the requested page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Route to appropriate controller
switch ($page) {
    case 'auth':
        require_once ROOT_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'AuthController.php';
        auth_controller($action);
        break;

    case 'admin':
        require_once ROOT_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'AdminController.php';
        admin_controller($action);
        break;

    case 'users':
        require_once ROOT_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'UserController.php';
        user_controller($action);
        break;

    case 'jobs':
        require_once ROOT_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'JobController.php';
        job_controller($action);
        break;

    case 'categories':
        require_once ROOT_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'CategoryController.php';
        category_controller($action);
        break;

    case 'reports':
        require_once ROOT_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'ReportController.php';
        report_controller($action);
        break;

    default:
        require_once ROOT_PATH . 'views' . DIRECTORY_SEPARATOR . 'home.php';
        break;
}
