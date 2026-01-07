<?php
require_once(__DIR__ . '/db.php');

function getAllCategories()
{
    $conn = getConnection();
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    mysqli_close($conn);
    return $categories;
}
function isCategoryExists($name)
{
    $conn = getConnection();
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "SELECT id FROM categories WHERE name = '$name'";
    $result = mysqli_query($conn, $sql);
    $exists = mysqli_num_rows($result) > 0;
    mysqli_close($conn);
    return $exists;
}

function addCategory($name)
{
    $conn = getConnection();
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "INSERT INTO categories (name) VALUES ('$name')";
    $result = mysqli_query($conn, $sql);
    $newId = $result ? mysqli_insert_id($conn) : false;
    mysqli_close($conn);
    return $newId;
}

function deleteCategory($id)
{
    $conn = getConnection();
    $id = (int)$id;
    $sql = "DELETE FROM categories WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}
