<?php
session_start();

class AuthController
{
    public function login($username, $password, $remember = false)
    {
        // Dummy authentication logic
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = 'admin';
            $_SESSION['role'] = 'admin';

            if ($remember) {
                // Set a cookie for 30 days
                setcookie('user_login', $username, time() + (86400 * 30), "/");
            }
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        // Clear the cookie
        if (isset($_COOKIE['user_login'])) {
            setcookie('user_login', '', time() - 3600, "/");
        }

        header("Location: ../views/auth/login.php");
        exit();
    }

    public static function checkSession()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../auth/login.php");
            exit();
        }
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $auth = new AuthController();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if ($auth->login($username, $password, $remember)) {
        header("Location: ../views/admin/adminhome.php");
    } else {
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: ../views/auth/login.php");
    }
    exit();
}
