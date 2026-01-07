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
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        if ($_POST['action'] === 'createCategory') {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                if (isCategoryExists($name)) {
                    $error = "Error: Category '$name' already exists.";
                    if ($isAjax) {
                        echo json_encode(['status' => 'error', 'message' => $error]);
                        exit;
                    }
                    return $error;
                }
                $newId = addCategory($name);
                if ($newId) {
                    if ($isAjax) {
                        echo json_encode(['status' => 'success', 'id' => $newId, 'name' => $name]);
                        exit;
                    }
                    return null;
                } else {
                    $error = "Error adding category.";
                    if ($isAjax) {
                        echo json_encode(['status' => 'error', 'message' => $error]);
                        exit;
                    }
                    return $error;
                }
            }
        } elseif ($_POST['action'] === 'deleteCategory') {
            $id = (int)$_POST['id'];
            if (deleteCategory($id)) {
                if ($isAjax) {
                    echo json_encode(['status' => 'success', 'id' => $id]);
                    exit;
                }
                return null;
            } else {
                $error = "Error deleting category.";
                if ($isAjax) {
                    echo json_encode(['status' => 'error', 'message' => $error]);
                    exit;
                }
                return $error;
            }
        }
    }
    return null;
}
