<?php
// Applicant Model - Handles all database operations for applicants and applications

function createApplicant($data) {
    $conn = getDBConnection();
    
    $name = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $resume = isset($data['resume']) ? mysqli_real_escape_string($conn, $data['resume']) : '';
    $cover_letter = mysqli_real_escape_string($conn, $data['cover_letter']);
    
    $sql = "INSERT INTO applicants (name, email, phone, resume, cover_letter) 
            VALUES ('$name', '$email', '$phone', '$resume', '$cover_letter')";
    
    $result = mysqli_query($conn, $sql);
    $applicant_id = mysqli_insert_id($conn);
    
    mysqli_close($conn);
    
    return $applicant_id;
}

function createApplication($data) {
    $conn = getDBConnection();
    
    $job_id = mysqli_real_escape_string($conn, $data['job_id']);
    $applicant_id = mysqli_real_escape_string($conn, $data['applicant_id']);
    $applied_date = mysqli_real_escape_string($conn, $data['applied_date']);
    
    $sql = "INSERT INTO applications (job_id, applicant_id, applied_date) 
            VALUES ('$job_id', '$applicant_id', '$applied_date')";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}

function getApplicationsByJob($job_id) {
    $conn = getDBConnection();
    
    $job_id = mysqli_real_escape_string($conn, $job_id);
    $sql = "SELECT app.*, a.name, a.email, a.phone, a.resume, a.cover_letter 
            FROM applications app 
            JOIN applicants a ON app.applicant_id = a.id 
            WHERE app.job_id = '$job_id' 
            ORDER BY app.applied_date DESC";
    
    $result = mysqli_query($conn, $sql);
    
    $applications = array();
    while($row = mysqli_fetch_assoc($result)) {
        $applications[] = $row;
    }
    
    mysqli_close($conn);
    
    return $applications;
}

function getApplicationById($id) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT app.*, a.name, a.email, a.phone, a.resume, a.cover_letter, j.title as job_title, c.company_name 
            FROM applications app 
            JOIN applicants a ON app.applicant_id = a.id 
            JOIN jobs j ON app.job_id = j.id 
            JOIN companies c ON j.company_id = c.id 
            WHERE app.id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    $application = mysqli_fetch_assoc($result);
    
    mysqli_close($conn);
    
    return $application;
}

function updateApplicationStatus($id, $status, $notes = '') {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $status = mysqli_real_escape_string($conn, $status);
    $notes = mysqli_real_escape_string($conn, $notes);
    
    $sql = "UPDATE applications SET status = '$status', notes = '$notes' WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    return $result;
}

function getApplicantById($id) {
    $conn = getDBConnection();
    
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM applicants WHERE id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    $applicant = mysqli_fetch_assoc($result);
    
    mysqli_close($conn);
    
    return $applicant;
}

function countApplicationsByStatus($job_id, $status) {
    $conn = getDBConnection();
    
    $job_id = mysqli_real_escape_string($conn, $job_id);
    $status = mysqli_real_escape_string($conn, $status);
    
    $sql = "SELECT COUNT(*) as count FROM applications WHERE job_id = '$job_id' AND status = '$status'";
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    mysqli_close($conn);
    
    return $row['count'];
}
?>
