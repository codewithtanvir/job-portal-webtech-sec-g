<?php
require_once ROOT_PATH . 'models/CategoryModel.php';

function category_controller($action)
{
    // Check if user is logged in and is admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit();
    }

    switch ($action) {
        case 'index':
        case 'list':
            list_categories();
            break;

        case 'add':
            add_category();
            break;

        case 'edit':
            edit_category();
            break;

        case 'delete':
            delete_category();
            break;

        case 'toggle_status':
            toggle_category_status();
            break;

        default:
            list_categories();
            break;
    }
}

function list_categories()
{
    $categories = get_all_categories();

    $page_title = 'Category Management';
    require_once ROOT_PATH . 'views/categories/list.php';
}

function add_category()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $status = isset($_POST['status']) ? $_POST['status'] : 'active';

        if (empty($name)) {
            $_SESSION['error'] = 'Category name is required';
        } else if (create_category($name, $description, $status)) {
            log_activity($_SESSION['user_id'], 'category_created', "Created category: $name");
            $_SESSION['success'] = 'Category created successfully';
            header('Location: ' . BASE_URL . '?page=categories');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to create category. Name may already exist.';
        }
    }

    $page_title = 'Add Category';
    require_once ROOT_PATH . 'views/categories/add.php';
}

function edit_category()
{
    if (!isset($_GET['id'])) {
        header('Location: ' . BASE_URL . '?page=categories');
        exit();
    }

    $category_id = intval($_GET['id']);
    $category = get_category_by_id($category_id);

    if (!$category) {
        $_SESSION['error'] = 'Category not found';
        header('Location: ' . BASE_URL . '?page=categories');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $status = isset($_POST['status']) ? $_POST['status'] : 'active';

        if (empty($name)) {
            $_SESSION['error'] = 'Category name is required';
        } else if (update_category($category_id, $name, $description, $status)) {
            log_activity($_SESSION['user_id'], 'category_updated', "Updated category ID: $category_id");
            $_SESSION['success'] = 'Category updated successfully';
            header('Location: ' . BASE_URL . '?page=categories');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update category';
        }
    }

    $page_title = 'Edit Category';
    require_once ROOT_PATH . 'views/categories/edit.php';
}

function delete_category()
{
    if (isset($_GET['id'])) {
        $category_id = intval($_GET['id']);

        // Check if category has jobs
        $job_count = get_category_job_count($category_id);

        if ($job_count > 0) {
            $_SESSION['error'] = "Cannot delete category. It has $job_count associated jobs.";
        } else if (delete_category_by_id($category_id)) {
            log_activity($_SESSION['user_id'], 'category_deleted', "Deleted category ID: $category_id");
            $_SESSION['success'] = 'Category deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete category';
        }
    }

    header('Location: ' . BASE_URL . '?page=categories');
    exit();
}

function toggle_category_status()
{
    if (isset($_GET['id'])) {
        $category_id = intval($_GET['id']);
        $category = get_category_by_id($category_id);

        if ($category) {
            $new_status = $category['status'] == 'active' ? 'inactive' : 'active';

            if (update_category_status($category_id, $new_status)) {
                log_activity(
                    $_SESSION['user_id'],
                    'category_status_changed',
                    "Changed category ID $category_id status to $new_status"
                );
                $_SESSION['success'] = 'Category status updated';
            } else {
                $_SESSION['error'] = 'Failed to update status';
            }
        }
    }

    header('Location: ' . BASE_URL . '?page=categories');
    exit();
}
