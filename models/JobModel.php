<?php
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'models/AdminModel.php';

// Get all jobs with optional filters
function get_all_jobs($filter = 'all', $search = '')
{
    $conn = get_db_connection();

    $query = "SELECT j.*, u.username as employer_name, u.email as employer_email,
                     c.name as category_name
              FROM jobs j
              LEFT JOIN users u ON j.employer_id = u.id
              LEFT JOIN categories c ON j.category_id = c.id
              WHERE 1=1";

    // Apply filters
    if ($filter != 'all' && in_array($filter, ['pending', 'approved', 'rejected', 'closed'])) {
        $query .= " AND j.status = '" . mysqli_real_escape_string($conn, $filter) . "'";
    }

    // Apply search
    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $query .= " AND (j.title LIKE '%$search%' OR j.description LIKE '%$search%' OR u.username LIKE '%$search%')";
    }

    $query .= " ORDER BY j.created_at DESC";

    $result = mysqli_query($conn, $query);
    $jobs = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }

    return $jobs;
}

// Get jobs by status
function get_jobs_by_status($status)
{
    $conn = get_db_connection();

    $status = mysqli_real_escape_string($conn, $status);
    $query = "SELECT j.*, u.username as employer_name, u.email as employer_email,
                     c.name as category_name
              FROM jobs j
              LEFT JOIN users u ON j.employer_id = u.id
              LEFT JOIN categories c ON j.category_id = c.id
              WHERE j.status = '$status'
              ORDER BY j.created_at DESC";

    $result = mysqli_query($conn, $query);
    $jobs = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }

    return $jobs;
}

// Get job by ID
function get_job_by_id($job_id)
{
    $conn = get_db_connection();

    $job_id = intval($job_id);
    $query = "SELECT j.*, u.username as employer_name, u.email as employer_email,
                     u.full_name as employer_fullname, c.name as category_name
              FROM jobs j
              LEFT JOIN users u ON j.employer_id = u.id
              LEFT JOIN categories c ON j.category_id = c.id
              WHERE j.id = $job_id";

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Update job status
function update_job_status($job_id, $status)
{
    $conn = get_db_connection();

    $job_id = intval($job_id);
    $status = mysqli_real_escape_string($conn, $status);

    $query = "UPDATE jobs SET status = '$status' WHERE id = $job_id";
    return mysqli_query($conn, $query);
}

// Delete job
function delete_job_by_id($job_id)
{
    $conn = get_db_connection();

    $job_id = intval($job_id);
    $query = "DELETE FROM jobs WHERE id = $job_id";

    return mysqli_query($conn, $query);
}

// Get job applications
function get_job_applications($job_id)
{
    $conn = get_db_connection();

    $job_id = intval($job_id);
    $query = "SELECT a.*, u.username, u.email, u.full_name
              FROM applications a
              LEFT JOIN users u ON a.jobseeker_id = u.id
              WHERE a.job_id = $job_id
              ORDER BY a.created_at DESC";

    $result = mysqli_query($conn, $query);
    $applications = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $applications[] = $row;
    }

    return $applications;
}

// Get jobs by employer
function get_jobs_by_employer($employer_id)
{
    $conn = get_db_connection();

    $employer_id = intval($employer_id);
    $query = "SELECT j.*, c.name as category_name
              FROM jobs j
              LEFT JOIN categories c ON j.category_id = c.id
              WHERE j.employer_id = $employer_id
              ORDER BY j.created_at DESC";

    $result = mysqli_query($conn, $query);
    $jobs = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }

    return $jobs;
}

// Get job statistics
function get_job_statistics($job_id)
{
    $conn = get_db_connection();
    $job_id = intval($job_id);

    $stats = array();

    // Total applications
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE job_id = $job_id");
    $stats['total_applications'] = mysqli_fetch_assoc($result)['count'];

    // Pending applications
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE job_id = $job_id AND status = 'pending'");
    $stats['pending_applications'] = mysqli_fetch_assoc($result)['count'];

    // Shortlisted applications
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE job_id = $job_id AND status = 'shortlisted'");
    $stats['shortlisted_applications'] = mysqli_fetch_assoc($result)['count'];

    // Accepted applications
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE job_id = $job_id AND status = 'accepted'");
    $stats['accepted_applications'] = mysqli_fetch_assoc($result)['count'];

    return $stats;
}
