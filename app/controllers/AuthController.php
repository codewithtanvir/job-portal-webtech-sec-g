<?php
session_start();
require_once('../models/db.php');

function login($username, $password, $remember = false)
{
    $conn = getConnection();
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($remember) {
            setcookie('user_login', $username, time() + (86400 * 30), "/");
        } else {
            if (isset($_COOKIE['user_login'])) {
                setcookie('user_login', '', time() - 3600, "/");
            }
        }
        mysqli_close($conn);
        return true;
    }
    mysqli_close($conn);
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if (login($username, $password, $remember)) {
        header("Location: ../views/admin/adminhome.php");
    } else {
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: ../views/auth/login.php");
    }
    exit();
}
