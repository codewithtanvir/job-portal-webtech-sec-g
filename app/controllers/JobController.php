<?php

require_once 'app/models/Job.php';
require_once 'app/helpers/Validator.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

if ($action == 'list') {
    listJobs();
} elseif ($action == 'search') {
    searchJobsAction();
} elseif ($action == 'ajax-search') {
    ajaxSearchJobs();
} elseif ($action == 'details') {
    showJobDetails();
}

function listJobs()
{
    $conn = getConnection();
    $jobs = getAllJobs($conn);
    require_once 'app/views/jobs/list.php';
    mysqli_close($conn);
}

function searchJobsAction()
{
    $validator = new Validator();
    $conn = getConnection();

    // Sanitize search inputs
    $keyword = $validator->sanitizeString($_GET['keyword'] ?? '');
    $location = $validator->sanitizeString($_GET['location'] ?? '');
    $category = $validator->sanitizeString($_GET['category'] ?? '');

    // Escape for SQL
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $location = mysqli_real_escape_string($conn, $location);
    $category = mysqli_real_escape_string($conn, $category);

    $jobs = searchJobs($conn, $keyword, $location, $category);

    require_once 'app/views/jobs/list.php';
    mysqli_close($conn);
}

function showJobDetails()
{
    $validator = new Validator();
    $conn = getConnection();

    $id = $_GET['id'] ?? 0;

    // Validate ID
    if (!$validator->validateInteger($id, 'Job ID', 1)) {
        echo "Invalid job ID";
        mysqli_close($conn);
        return;
    }

    $id = mysqli_real_escape_string($conn, $id);
    $job = getJobById($conn, $id);

    if (!$job) {
        echo "Job not found";
        mysqli_close($conn);
        return;
    }

    require_once 'app/views/jobs/details.php';
    mysqli_close($conn);
}

function ajaxSearchJobs()
{
    header('Content-Type: application/json');

    $validator = new Validator();
    $conn = getConnection();

    // Sanitize search inputs
    $keyword = $validator->sanitizeString($_GET['keyword'] ?? '');
    $location = $validator->sanitizeString($_GET['location'] ?? '');
    $category = $validator->sanitizeString($_GET['category'] ?? '');

    // Escape for SQL
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $location = mysqli_real_escape_string($conn, $location);
    $category = mysqli_real_escape_string($conn, $category);

    $result = searchJobs($conn, $keyword, $location, $category);

    $jobs = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }

    echo json_encode($jobs);

    mysqli_close($conn);
    exit;
}
