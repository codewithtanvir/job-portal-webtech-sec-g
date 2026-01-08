<?php

function getAllJobs($conn)
{
    $query = "SELECT jobs.*, users.full_name as company, categories.name as category
              FROM jobs
              LEFT JOIN users ON jobs.employer_id = users.id
              LEFT JOIN categories ON jobs.category_id = categories.id
              WHERE jobs.status = 'approved'
              ORDER BY jobs.created_at DESC";
    $result = mysqli_query($conn, $query);
    return $result;
}

function searchJobs($conn, $keyword, $location, $category)
{
    $query = "SELECT jobs.*, users.full_name as company, categories.name as category
              FROM jobs
              LEFT JOIN users ON jobs.employer_id = users.id
              LEFT JOIN categories ON jobs.category_id = categories.id
              WHERE jobs.status = 'approved'";

    if (!empty($keyword)) {
        $keyword = mysqli_real_escape_string($conn, $keyword);
        $query .= " AND (jobs.title LIKE '%$keyword%' OR jobs.description LIKE '%$keyword%')";
    }

    if (!empty($location)) {
        $location = mysqli_real_escape_string($conn, $location);
        $query .= " AND jobs.location LIKE '%$location%'";
    }

    if (!empty($category)) {
        $category = mysqli_real_escape_string($conn, $category);
        $query .= " AND categories.name = '$category'";
    }

    $query .= " ORDER BY jobs.created_at DESC";

    $result = mysqli_query($conn, $query);
    return $result;
}

function getJobById($conn, $id)
{
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT jobs.*, users.full_name as company, categories.name as category
              FROM jobs
              LEFT JOIN users ON jobs.employer_id = users.id
              LEFT JOIN categories ON jobs.category_id = categories.id
              WHERE jobs.id = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}
