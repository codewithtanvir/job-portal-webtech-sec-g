<?php

require_once 'app/models/Application.php';
require_once 'app/models/Candidate.php';
require_once 'app/models/Job.php';
require_once 'app/helpers/Validator.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

if ($action == 'form') {
    showApplicationForm();
} elseif ($action == 'submit') {
    submitApplication();
} elseif ($action == 'register') {
    registerCandidate();
} elseif ($action == 'upload-resume') {
    uploadResume();
} elseif ($action == 'list') {
    listApplications();
}

function showApplicationForm()
{
    $job_id = isset($_GET['job_id']) ? $_GET['job_id'] : 0;
    $conn = getConnection();
    $job = getJobById($conn, $job_id);

    if (!$job) {
        echo "Job not found";
        return;
    }

    require_once 'app/views/application/form.php';
    mysqli_close($conn);
}

function submitApplication()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: ?page=jobs');
        return;
    }

    $validator = new Validator();
    $conn = getConnection();

    // Validate and sanitize inputs
    $email = $validator->sanitizeEmail($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $job_id = $_POST['job_id'] ?? '';

    // Validate email
    $validator->validateEmail($email);

    // Validate password exists
    if (empty($password)) {
        $validator->validateRequired($password, 'Password');
    }

    // Validate job ID
    $validator->validateInteger($job_id, 'Job ID', 1);

    // If validation fails, show errors
    if ($validator->hasErrors()) {
        $error = $validator->getFirstError();
        $job = getJobById($conn, $job_id);
        require_once 'app/views/application/form.php';
        mysqli_close($conn);
        return;
    }

    // Escape for SQL query
    $email = mysqli_real_escape_string($conn, $email);
    $job_id = mysqli_real_escape_string($conn, $job_id);

    $candidate = getCandidateByEmail($conn, $email);

    if (!$candidate) {
        $error = "Invalid email or password";
        $job = getJobById($conn, $job_id);
        require_once 'app/views/application/form.php';
        mysqli_close($conn);
        return;
    }

    if (!password_verify($password, $candidate['password'])) {
        $error = "Invalid email or password";
        $job = getJobById($conn, $job_id);
        require_once 'app/views/application/form.php';
        mysqli_close($conn);
        return;
    }

    if (empty($candidate['resume_path'])) {
        $error = "Please upload your resume first";
        $job = getJobById($conn, $job_id);
        require_once 'app/views/application/form.php';
        mysqli_close($conn);
        return;
    }

    $result = createApplication($conn, $job_id, $candidate['id']);

    if ($result) {
        $_SESSION['candidate_id'] = $candidate['id'];
        header('Location: ?page=applications');
    } else {
        $error = "You have already applied for this job";
        $job = getJobById($conn, $job_id);
        require_once 'app/views/application/form.php';
    }

    mysqli_close($conn);
}

function registerCandidate()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        require_once 'app/views/candidate/register.php';
        return;
    }

    $validator = new Validator();
    $conn = getConnection();

    // Sanitize inputs
    $name = $validator->sanitizeString($_POST['name'] ?? '');
    $email = $validator->sanitizeEmail($_POST['email'] ?? '');
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate all fields
    $validator->validateRequired($name, 'Name', 2, 255);
    $validator->validateEmail($email);
    $validator->validatePhone($phone);
    $validator->validatePassword($password);

    // If validation fails, show errors
    if ($validator->hasErrors()) {
        $error = $validator->getFirstError();
        require_once 'app/views/candidate/register.php';
        mysqli_close($conn);
        return;
    }

    // Escape for SQL query
    $email = mysqli_real_escape_string($conn, $email);

    $existing = getCandidateByEmail($conn, $email);

    if ($existing) {
        $error = "Email already exists";
        require_once 'app/views/candidate/register.php';
        mysqli_close($conn);
        return;
    }

    $candidate_id = createCandidate($conn, $name, $email, $phone, $password);

    if ($candidate_id) {
        $_SESSION['candidate_id'] = $candidate_id;
        $success = "Registration successful! Please upload your resume.";
        $candidate = getCandidateById($conn, $candidate_id);
        require_once 'app/views/candidate/resume.php';
    } else {
        $error = "Registration failed";
        require_once 'app/views/candidate/register.php';
    }

    mysqli_close($conn);
}

function uploadResume()
{
    if (!isset($_SESSION['candidate_id'])) {
        header('Location: ?page=apply&action=register');
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $conn = getConnection();
        $candidate = getCandidateById($conn, $_SESSION['candidate_id']);
        require_once 'app/views/candidate/resume.php';
        mysqli_close($conn);
        return;
    }

    $validator = new Validator();
    $conn = getConnection();
    $candidate = getCandidateById($conn, $_SESSION['candidate_id']);

    // Validate file upload
    if (!isset($_FILES['resume'])) {
        $error = "Please select a file";
        require_once 'app/views/candidate/resume.php';
        mysqli_close($conn);
        return;
    }

    // Validate file with Validator class
    $validator->validateFile(
        $_FILES['resume'],
        'Resume',
        ['pdf'],
        5 * 1024 * 1024 // 5MB
    );

    if ($validator->hasErrors()) {
        $error = $validator->getFirstError();
        require_once 'app/views/candidate/resume.php';
        mysqli_close($conn);
        return;
    }

    $file_tmp = $_FILES['resume']['tmp_name'];
    $new_file_name = 'resume_' . $_SESSION['candidate_id'] . '_' . time() . '.pdf';
    $upload_path = 'public/uploads/resumes/' . $new_file_name;

    // Ensure upload directory exists
    $upload_dir = 'public/uploads/resumes/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (move_uploaded_file($file_tmp, $upload_path)) {
        // Delete old resume if exists
        if (!empty($candidate['resume_path']) && file_exists($candidate['resume_path'])) {
            unlink($candidate['resume_path']);
        }

        updateCandidateResume($conn, $_SESSION['candidate_id'], $upload_path);
        $success = "Resume uploaded successfully!";
        $candidate = getCandidateById($conn, $_SESSION['candidate_id']);
    } else {
        $error = "Failed to upload resume. Please check directory permissions.";
    }

    require_once 'app/views/candidate/resume.php';
    mysqli_close($conn);
}

function listApplications()
{
    if (!isset($_SESSION['candidate_id'])) {
        echo "Please login first";
        return;
    }

    $conn = getConnection();
    $applications = getApplicationsByCandidate($conn, $_SESSION['candidate_id']);
    require_once 'app/views/application/list.php';
    mysqli_close($conn);
}
