<?php

function getAllJobs($conn) {
    $query = "SELECT * FROM jobs ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
    return $result;
}

function searchJobs($conn, $keyword, $location, $category) {
    $query = "SELECT * FROM jobs WHERE 1=1";
    
    if (!empty($keyword)) {
        $keyword = mysqli_real_escape_string($conn, $keyword);
        $query .= " AND (title LIKE '%$keyword%' OR description LIKE '%$keyword%')";
    }
    
    if (!empty($location)) {
        $location = mysqli_real_escape_string($conn, $location);
        $query .= " AND location LIKE '%$location%'";
    }
    
    if (!empty($category)) {
        $category = mysqli_real_escape_string($conn, $category);
        $query .= " AND category = '$category'";
    }
    
    $query .= " ORDER BY created_at DESC";
    
    $result = mysqli_query($conn, $query);
    return $result;
}

function getJobById($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT * FROM jobs WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

?>
