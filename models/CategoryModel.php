<?php
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'models/AdminModel.php';

// Get all categories
function get_all_categories($include_inactive = true)
{
    $conn = get_db_connection();

    $query = "SELECT c.*,
              (SELECT COUNT(*) FROM jobs WHERE category_id = c.id) as job_count
              FROM categories c";

    if (!$include_inactive) {
        $query .= " WHERE c.status = 'active'";
    }

    $query .= " ORDER BY c.name ASC";

    $result = mysqli_query($conn, $query);
    $categories = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    return $categories;
}

// Get category by ID
function get_category_by_id($category_id)
{
    $conn = get_db_connection();

    $category_id = intval($category_id);
    $query = "SELECT c.*,
              (SELECT COUNT(*) FROM jobs WHERE category_id = c.id) as job_count
              FROM categories c
              WHERE c.id = $category_id";

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Create category
function create_category($name, $description, $status = 'active')
{
    $conn = get_db_connection();

    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    $status = mysqli_real_escape_string($conn, $status);

    $query = "INSERT INTO categories (name, description, status)
              VALUES ('$name', '$description', '$status')";

    return mysqli_query($conn, $query);
}

// Update category
function update_category($category_id, $name, $description, $status)
{
    $conn = get_db_connection();

    $category_id = intval($category_id);
    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    $status = mysqli_real_escape_string($conn, $status);

    $query = "UPDATE categories
              SET name = '$name', description = '$description', status = '$status'
              WHERE id = $category_id";

    return mysqli_query($conn, $query);
}

// Update category status
function update_category_status($category_id, $status)
{
    $conn = get_db_connection();

    $category_id = intval($category_id);
    $status = mysqli_real_escape_string($conn, $status);

    $query = "UPDATE categories SET status = '$status' WHERE id = $category_id";
    return mysqli_query($conn, $query);
}

// Delete category
function delete_category_by_id($category_id)
{
    $conn = get_db_connection();

    $category_id = intval($category_id);
    $query = "DELETE FROM categories WHERE id = $category_id";

    return mysqli_query($conn, $query);
}

// Get category job count
function get_category_job_count($category_id)
{
    $conn = get_db_connection();

    $category_id = intval($category_id);
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE category_id = $category_id");
    return mysqli_fetch_assoc($result)['count'];
}

// Get category statistics
function get_category_statistics($category_id)
{
    $conn = get_db_connection();
    $category_id = intval($category_id);

    $stats = array();

    // Total jobs
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE category_id = $category_id");
    $stats['total_jobs'] = mysqli_fetch_assoc($result)['count'];

    // Active jobs
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE category_id = $category_id AND status = 'approved'");
    $stats['active_jobs'] = mysqli_fetch_assoc($result)['count'];

    // Pending jobs
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE category_id = $category_id AND status = 'pending'");
    $stats['pending_jobs'] = mysqli_fetch_assoc($result)['count'];

    // Total applications
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications a
                                   JOIN jobs j ON a.job_id = j.id
                                   WHERE j.category_id = $category_id");
    $stats['total_applications'] = mysqli_fetch_assoc($result)['count'];

    return $stats;
}
