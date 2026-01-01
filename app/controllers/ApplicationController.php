<?php

require_once 'app/models/Application.php';
require_once 'app/models/Candidate.php';
require_once 'app/models/Job.php';

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

    $conn = getConnection();

    $email = $_POST['email'];
    $password = $_POST['password'];
    $job_id = $_POST['job_id'];

    $candidate = getCandidateByEmail($conn, $email);

    if (!$candidate) {
        $error = "Invalid email or password";
        require_once 'app/views/application/form.php';
        mysqli_close($conn);
        return;
    }

    if (!password_verify($password, $candidate['password'])) {
        $error = "Invalid email or password";
        require_once 'app/views/application/form.php';
        mysqli_close($conn);
        return;
    }

    if (empty($candidate['resume_path'])) {
        $error = "Please upload your resume first";
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

    $conn = getConnection();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

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

    $conn = getConnection();
    $candidate = getCandidateById($conn, $_SESSION['candidate_id']);

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $file_name = $_FILES['resume']['name'];
        $file_tmp = $_FILES['resume']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_ext != 'pdf') {
            $error = "Only PDF files are allowed";
            require_once 'app/views/candidate/resume.php';
            mysqli_close($conn);
            return;
        }

        $new_file_name = 'resume_' . $_SESSION['candidate_id'] . '_' . time() . '.pdf';
        $upload_path = 'public/uploads/resumes/' . $new_file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            updateCandidateResume($conn, $_SESSION['candidate_id'], $upload_path);
            $success = "Resume uploaded successfully!";
            $candidate = getCandidateById($conn, $_SESSION['candidate_id']);
        } else {
            $error = "Failed to upload resume";
        }
    } else {
        $error = "Please select a file";
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