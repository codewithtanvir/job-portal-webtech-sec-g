<?php
// Job Controller - Handles job-related requests
require_once 'models/JobModel.php';
require_once 'models/CompanyModel.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch($action) {
    case 'list':
        $jobs = getAllJobs();
        require_once 'views/job/list.php';
        break;
        
    case 'view':
        if(isset($_GET['id'])) {
            $job = getJobById($_GET['id']);
            require_once 'views/job/view.php';
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'create':
        $companies = getAllCompanies();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'company_id' => $_POST['company_id'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'requirements' => $_POST['requirements'],
                'salary_range' => $_POST['salary_range'],
                'location' => $_POST['location'],
                'job_type' => $_POST['job_type'],
                'posted_date' => $_POST['posted_date'],
                'deadline' => $_POST['deadline']
            );
            
            if(createJob($data)) {
                $_SESSION['success'] = "Job posted successfully!";
                header('Location: index.php?page=job&action=list');
                exit();
            } else {
                $_SESSION['error'] = "Failed to post job.";
            }
        }
        require_once 'views/job/create.php';
        break;
        
    default:
        header('Location: index.php?page=job&action=list');
        break;
}
?>
