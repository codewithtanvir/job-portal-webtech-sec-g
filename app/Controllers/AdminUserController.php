<?php
session_start();
require_once(__DIR__ . '/../Models/UserModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $username = $_POST['newUsername'];
            $email = $_POST['newEmail'];
            $password = $_POST['newPassword'];
            $role = $_POST['newRole'];
            $dob = $_POST['dob'] ?? date('Y-m-d');

            if (checkUserExists($username, $email)) {
                $errorMsg = "Username or Email already exists!";
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo $errorMsg;
                    exit();
                }
                $_SESSION['error'] = $errorMsg;
            } else {
                if (addUser($username, $email, $password, $dob, $role)) {
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        echo "success";
                        exit();
                    }
                    $_SESSION['message'] = "User added successfully!";
                } else {
                    $errorMsg = "Failed to add user.";
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        echo $errorMsg;
                        exit();
                    }
                    $_SESSION['error'] = $errorMsg;
                }
            }
            header("Location: ../Views/admin/AdminHome.php");
            exit();
        }

        if ($action === 'delete') {
            $id = $_POST['id'];
            if (deleteUserById($id)) {
                echo "success";
            } else {
                echo "error";
            }
            exit();
        }

        if ($action === 'edit') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            if (updateUser($id, $username, $email, $role)) {
                echo "success";
            } else {
                echo "error";
            }
            exit();
        }
    }
}
