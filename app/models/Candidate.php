<?php

function createCandidate($conn, $name, $email, $phone, $password) {
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO candidates (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
    
    if (mysqli_query($conn, $query)) {
        return mysqli_insert_id($conn);
    }
    
    return false;
}

function getCandidateByEmail($conn, $email) {
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM candidates WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function getCandidateById($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT * FROM candidates WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateCandidateResume($conn, $candidate_id, $resume_path) {
    $candidate_id = mysqli_real_escape_string($conn, $candidate_id);
    $resume_path = mysqli_real_escape_string($conn, $resume_path);
    
    $query = "UPDATE candidates SET resume_path = '$resume_path' WHERE id = '$candidate_id'";
    
    return mysqli_query($conn, $query);
}

?>
