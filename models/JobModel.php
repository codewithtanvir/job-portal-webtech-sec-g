<?php
// Job Model - Handles all database operations for jobs

function createJob($data) {
    $conn = getDBConnection();
    
    $company_id = mysqli_real_escape_string($conn, $data['company_id']);
    $title = mysqli_real_escape_string($conn, $data['title']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $requirements = mysqli_real_escape_string($conn, $data['requirements']);
    $salary_range = mysqli_real_escape_string($conn, $data['salary_range']);
    $location = mysqli_real_escape_string($conn, $data['location']);
    $job_type = mysqli_real_escape_string($conn, $data['job_type']);
    $posted_date = mysqli_real_escape_string($conn, $data['posted_date']);
    $deadline = mysqli_real_escape_string($conn, $data['deadline']);
    
    $sql = "INSERT INTO jobs (company_id, title, description, requirements, salary_range, location, job_type, posted_date, deadline) 
            VALUES ('$company_id', '$title', '$description', '$requirements', '$salary_range', '$location', '$job_type', '$posted_date', '$deadline')";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}

function getJobById($id) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT j.*, c.company_name 
            FROM jobs j 
            JOIN companies c ON j.company_id = c.id 
            WHERE j.id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    $job = mysqli_fetch_assoc($result);
    
    mysqli_close($conn);
    
    return $job;
}

function getAllJobs() {
    $conn = getDBConnection();
    
    $sql = "SELECT j.*, c.company_name 
            FROM jobs j 
            JOIN companies c ON j.company_id = c.id 
            ORDER BY j.posted_date DESC";
    
    $result = mysqli_query($conn, $sql);
    
    $jobs = array();
    while($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }
    
    mysqli_close($conn);
    
    return $jobs;
}

function getJobsByCompany($company_id) {
    $conn = getDBConnection();
    
    $company_id = mysqli_real_escape_string($conn, $company_id);
    $sql = "SELECT j.*, c.company_name 
            FROM jobs j 
            JOIN companies c ON j.company_id = c.id 
            WHERE j.company_id = '$company_id' 
            ORDER BY j.posted_date DESC";
    
    $result = mysqli_query($conn, $sql);
    
    $jobs = array();
    while($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }
    
    mysqli_close($conn);
    
    return $jobs;
}

function updateJob($id, $data) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $title = mysqli_real_escape_string($conn, $data['title']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $requirements = mysqli_real_escape_string($conn, $data['requirements']);
    $salary_range = mysqli_real_escape_string($conn, $data['salary_range']);
    $location = mysqli_real_escape_string($conn, $data['location']);
    $job_type = mysqli_real_escape_string($conn, $data['job_type']);
    $deadline = mysqli_real_escape_string($conn, $data['deadline']);
    
    $sql = "UPDATE jobs SET 
            title = '$title',
            description = '$description',
            requirements = '$requirements',
            salary_range = '$salary_range',
            location = '$location',
            job_type = '$job_type',
            deadline = '$deadline'
            WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}

function closeJob($id) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "UPDATE jobs SET status = 'Closed' WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}

function openJob($id) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "UPDATE jobs SET status = 'Open' WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}

function deleteJob($id) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "DELETE FROM jobs WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}
?>
