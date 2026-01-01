<?php

function createApplication($conn, $job_id, $candidate_id)
{
    $job_id = mysqli_real_escape_string($conn, $job_id);
    $candidate_id = mysqli_real_escape_string($conn, $candidate_id);

    $check_query = "SELECT * FROM applications WHERE job_id = '$job_id' AND candidate_id = '$candidate_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        return false;
    }

    $query = "INSERT INTO applications (job_id, candidate_id) VALUES ('$job_id', '$candidate_id')";

    return mysqli_query($conn, $query);
}

function getApplicationsByCandidate($conn, $candidate_id)
{
    $candidate_id = mysqli_real_escape_string($conn, $candidate_id);

    $query = "SELECT a.*, j.title, j.company, j.location
              FROM applications a
              JOIN jobs j ON a.job_id = j.id
              WHERE a.candidate_id = '$candidate_id'
              ORDER BY a.applied_at DESC";

    $result = mysqli_query($conn, $query);
    return $result;
}
