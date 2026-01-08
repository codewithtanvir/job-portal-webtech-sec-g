<?php
// Main index file - front controller
// all requests go through this file

session_start();

// include database connection
require_once '../config/db.php';

// get the page from url
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// routing logic
switch ($page) {
    case 'home':
        include '../app/views/home.php';
        break;

    case 'register':
        include '../app/views/register.php';
        break;

    case 'login':
        include '../app/views/login.php';
        break;

    default:
        include '../app/views/home.php';
        break;
}
