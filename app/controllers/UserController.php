<?php
// app/controllers/UserController.php
require_once '../app/models/UserModel.php';

function register() {
    global $conn;
    if (isset($_POST['btnRegister'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (saveUser($conn, $name, $email, $password, $role)) {
            header("Location: login");
            exit();
        } else {
            echo "Registration failed!";
        }
    } else {
        require_once '../app/views/register.php';
    }
}

function login() {
    global $conn;
    if (isset($_POST['btnLogin'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = getUserByEmail($conn, $email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: home");
            exit();
        } else {
            echo "Invalid email or password";
        }
    } else {
        require_once '../app/views/login.php';
    }
}

function logout() {
    session_destroy();
    header("Location: login");
    exit();
}
?>
