<?php
// User Controller - handles user related actions
// this file processes registration, login, logout etc

session_start();
require_once '../../config/db.php';
require_once '../models/UserModel.php';

// get the action from url
$action = isset($_GET['action']) ? $_GET['action'] : '';

// handle register action
if ($action == 'register') {
    // get form data
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];

    // validate inputs
    if (empty($full_name) || empty($username) || empty($email) || empty($password) || empty($user_type)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: ../../public/index.php?page=register");
        exit();
    }

    // check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: ../../public/index.php?page=register");
        exit();
    }

    // check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: ../../public/index.php?page=register");
        exit();
    }

    // check password length
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters";
        header("Location: ../../public/index.php?page=register");
        exit();
    }

    // check if email already exists
    if (checkEmailExists($conn, $email)) {
        $_SESSION['error'] = "Email already registered";
        header("Location: ../../public/index.php?page=register");
        exit();
    }

    // check if username already exists
    if (checkUsernameExists($conn, $username)) {
        $_SESSION['error'] = "Username already taken";
        header("Location: ../../public/index.php?page=register");
        exit();
    }

    // create user
    if (createUser($conn, $username, $email, $password, $full_name, $user_type)) {
        $_SESSION['success'] = "Registration successful! Please wait for admin approval";
        header("Location: ../../public/index.php?page=login");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again";
        header("Location: ../../public/index.php?page=register");
        exit();
    }
}

// handle login action
if ($action == 'login') {
    // get form data
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // validate inputs
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: ../../public/index.php?page=login");
        exit();
    }

    // get user from database
    $user = getUserByUsername($conn, $username);

    // check if user exists
    if (!$user) {
        $_SESSION['error'] = "Invalid username or password";
        header("Location: ../../public/index.php?page=login");
        exit();
    }

    // verify password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Invalid username or password";
        header("Location: ../../public/index.php?page=login");
        exit();
    }

    // check if account is approved
    if ($user['status'] != 'approved') {
        $_SESSION['error'] = "Your account is pending approval";
        header("Location: ../../public/index.php?page=login");
        exit();
    }

    // login successful - set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['user_type'] = $user['user_type'];
    $_SESSION['success'] = "Login successful!";

    // redirect based on user type
    if ($user['user_type'] == 'admin') {
        header("Location: ../../public/index.php?page=admin-dashboard");
    } elseif ($user['user_type'] == 'employer') {
        header("Location: ../../public/index.php?page=employer-dashboard");
    } else {
        header("Location: ../../public/index.php?page=jobseeker-dashboard");
    }
    exit();
}

// handle logout action
if ($action == 'logout') {
    // destroy session
    session_destroy();
    header("Location: ../../public/index.php?page=login");
    exit();
}
