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
