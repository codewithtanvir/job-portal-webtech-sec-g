<?php
require_once 'config/config.php';

// Simple router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Route to appropriate controller
switch ($page) {
    case 'company':
        require_once 'controllers/CompanyController.php';
        break;
    case 'job':
        require_once 'controllers/JobController.php';
        break;
    case 'applicant':
        require_once 'controllers/ApplicantController.php';
        break;
    default:
        require_once 'views/home.php';
        break;
}
