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
    case 'ajax-search':
        require_once 'app/controllers/JobController.php';
        break;
    case 'apply':
        require_once 'app/controllers/ApplicationController.php';
        break;
    case 'applications':
        require_once 'app/controllers/ApplicationController.php';
        break;
    case 'login':
        handleLogin();
        break;
    case 'logout':
        handleLogout();
        break;
    case 'profile':
        showProfile();
        break;
    default:
        require_once 'app/views/home.php';
        break;
}

function handleLogin()
{
    require_once 'app/models/Candidate.php';

    $action = isset($_GET['action']) ? $_GET['action'] : 'form';

    if ($action == 'form') {
        require_once 'app/views/candidate/login.php';
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        require_once 'app/views/candidate/login.php';
        return;
    }

    $conn = getConnection();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $candidate = getCandidateByEmail($conn, $email);

    if (!$candidate) {
        $error = "Invalid email or password";
        require_once 'app/views/candidate/login.php';
        mysqli_close($conn);
        return;
    }

    if (!password_verify($password, $candidate['password'])) {
        $error = "Invalid email or password";
        require_once 'app/views/candidate/login.php';
        mysqli_close($conn);
        return;
    }

    $_SESSION['candidate_id'] = $candidate['id'];
    $_SESSION['candidate_name'] = $candidate['name'];
    header('Location: ?page=profile');
    mysqli_close($conn);
}

function handleLogout()
{
    session_destroy();
    header('Location: index.php');
}

function showProfile()
{
    if (!isset($_SESSION['candidate_id'])) {
        header('Location: ?page=login');
        return;
    }

    require_once 'app/models/Candidate.php';
    $conn = getConnection();
    $candidate = getCandidateById($conn, $_SESSION['candidate_id']);
    require_once 'app/views/candidate/profile.php';
    mysqli_close($conn);
}
