<?php
session_start();
require_once('../models/userModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $username = $_POST['newUsername'];
            $email = $_POST['newEmail'];
            $password = $_POST['newPassword'];
            $role = $_POST['newRole'];
            $dob = $_POST['dob'] ?? date('Y-m-d'); // Default if not provided

            if (checkUserExists($username, $email)) {
                $_SESSION['error'] = "Username or Email already exists!";
            } else {
                if (addUser($username, $email, $password, $dob, $role)) {
                    $_SESSION['message'] = "User added successfully!";
                } else {
                    $_SESSION['error'] = "Failed to add user.";
                }
            }
            header("Location: ../views/admin/adminhome.php");
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
