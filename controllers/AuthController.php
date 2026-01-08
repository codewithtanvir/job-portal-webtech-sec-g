<?php
require_once ROOT_PATH . 'config' . DIRECTORY_SEPARATOR . 'database.php';

function auth_controller($action)
{
    switch ($action) {
        case 'login':
            login();
            break;

        case 'logout':
            logout();
            break;

        case 'authenticate':
            authenticate();
            break;

        default:
            login();
            break;
    }
}

function login()
{
    // If already logged in, redirect to appropriate page
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_type'] == 'admin') {
            header('Location: ' . BASE_URL . '?page=admin');
        } else {
            header('Location: ' . BASE_URL);
        }
        exit();
    }

    $page_title = 'Login';
    require_once ROOT_PATH . 'views' . DIRECTORY_SEPARATOR . 'auth' . DIRECTORY_SEPARATOR . 'login.php';
}

function authenticate()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit();
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username and password are required';
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit();
    }

    $conn = get_db_connection();
    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Check if user is approved
            if ($user['status'] != 'approved') {
                $_SESSION['error'] = 'Your account is pending approval or has been banned';
                header('Location: ' . BASE_URL . '?page=auth&action=login');
                exit();
            }

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['full_name'] = $user['full_name'];

            // Log activity
            require_once ROOT_PATH . 'models' . DIRECTORY_SEPARATOR . 'AdminModel.php';
            log_activity($user['id'], 'login', 'User logged in');

            // Redirect based on user type
            if ($user['user_type'] == 'admin') {
                header('Location: ' . BASE_URL . '?page=admin');
            } else {
                header('Location: ' . BASE_URL);
            }
            exit();
        } else {
            $_SESSION['error'] = 'Invalid username or password';
            header('Location: ' . BASE_URL . '?page=auth&action=login');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit();
    }
}

function logout()
{
    if (isset($_SESSION['user_id'])) {
        require_once ROOT_PATH . 'models' . DIRECTORY_SEPARATOR . 'AdminModel.php';
        log_activity($_SESSION['user_id'], 'logout', 'User logged out');
    }

    session_destroy();
    header('Location: ' . BASE_URL . '?page=auth&action=login');
    exit();
}
