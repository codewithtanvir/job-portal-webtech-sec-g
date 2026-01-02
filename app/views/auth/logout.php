<?php
session_start();
session_unset();
session_destroy();

// Clear the cookie if it exists
if (isset($_COOKIE['user_login'])) {
    setcookie('user_login', '', time() - 3600, "/");
}

header("Location: login.php");
exit();
