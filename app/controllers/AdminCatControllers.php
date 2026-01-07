<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../models/AdminCatModels.php');

function category_get_all()
{
    return getAllCategories();
}

function category_handle_actions()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] === 'createCategory') {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                if (isCategoryExists($name)) {
                    return "Error: Category '$name' already exists.";
                }
                if (addCategory($name)) {
                    return null;
                } else {
                    return "Error adding category.";
                }
            }
        } elseif ($_POST['action'] === 'deleteCategory') {
            $id = (int)$_POST['id'];
            if (deleteCategory($id)) {
                return null;
            } else {
                return "Error deleting category.";
            }
        }
    }
    return null;
}
