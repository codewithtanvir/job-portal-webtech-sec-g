<?php
session_start();
require_once 'config/database.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'jobs':
        require_once 'app/controllers/JobController.php';
        break;
    case 'job-details':
        require_once 'app/controllers/JobController.php';
        break;
    case 'apply':
        require_once 'app/controllers/ApplicationController.php';
        break;
    case 'applications':
        require_once 'app/controllers/ApplicationController.php';
        break;
    default:
        require_once 'app/views/home.php';
        break;
}
