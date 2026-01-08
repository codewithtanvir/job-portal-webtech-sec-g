<?php
// public/index.php
session_start();
require_once '../config/db.php';

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';

// Basic procedural routing
switch ($url) {
    case 'home':
        require_once '../app/views/home.php';
        break;
    case 'register':
        require_once '../app/controllers/UserController.php';
        register();
        break;
    case 'login':
        require_once '../app/controllers/UserController.php';
        login();
        break;
    case 'logout':
        require_once '../app/controllers/UserController.php';
        logout();
        break;
    default:
        echo "404 Page Not Found";
        break;
}
