<?php
function admin_get_pending_jobs($name)
{
    global $conn;
    $sql = "SELECT j.id, j.title, u.username as employer_name, j.location, j.salary, j.created_at
            FROM jobs j
            JOIN users u ON j.employer_id = u.id
            WHERE j.status='Pending'
            ORDER BY j.created_at DESC";
    $result = mysqli_query($conn, $sql);
    $rows = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;       // Implementation for creating a category in the database
}
function admin_set_job_status($jobId, $status)
{
    global $conn;
    $jobId = (int)$jobId;
    $status = mysqli_real_escape_string($conn, $status);
    $sql = "UPDATE jobs SET status = '$status' WHERE id = $jobId";
    return mysqli_query($conn, $sql);
}
