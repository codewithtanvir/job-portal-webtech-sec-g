<?php

require_once 'app/models/Job.php';

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
    $conn = getConnection();

    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $location = isset($_GET['location']) ? $_GET['location'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    $jobs = searchJobs($conn, $keyword, $location, $category);

    require_once 'app/views/jobs/list.php';
    mysqli_close($conn);
}

function showJobDetails()
{
    $conn = getConnection();
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $job = getJobById($conn, $id);

    if (!$job) {
        echo "Job not found";
        return;
    }

    require_once 'app/views/jobs/details.php';
    mysqli_close($conn);
}

function ajaxSearchJobs()
{
    header('Content-Type: application/json');

    $conn = getConnection();

    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $location = isset($_GET['location']) ? $_GET['location'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    $jobs = searchJobs($conn, $keyword, $location, $category);

    echo json_encode($jobs);

    mysqli_close($conn);
    exit;
}
