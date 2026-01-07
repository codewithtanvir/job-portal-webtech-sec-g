<?php
// General Configuration
define('BASE_URL', 'http://localhost/jobemp/');
define('SITE_NAME', 'Job Portal');

// Session Configuration
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/database.php';
