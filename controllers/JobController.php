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
        
    case 'edit':
        if(isset($_GET['id'])) {
            $job = getJobById($_GET['id']);
            $companies = getAllCompanies();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = array(
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'requirements' => $_POST['requirements'],
                    'salary_range' => $_POST['salary_range'],
                    'location' => $_POST['location'],
                    'job_type' => $_POST['job_type'],
                    'deadline' => $_POST['deadline']
                );
                
                if(updateJob($_GET['id'], $data)) {
                    $_SESSION['success'] = "Job updated successfully!";
                    header('Location: index.php?page=job&action=view&id=' . $_GET['id']);
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to update job.";
                }
            }
            
            require_once 'views/job/edit.php';
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'close':
        if(isset($_GET['id'])) {
            if(closeJob($_GET['id'])) {
                $_SESSION['success'] = "Job closed successfully!";
            } else {
                $_SESSION['error'] = "Failed to close job.";
            }
            header('Location: index.php?page=job&action=view&id=' . $_GET['id']);
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'open':
        if(isset($_GET['id'])) {
            if(openJob($_GET['id'])) {
                $_SESSION['success'] = "Job reopened successfully!";
            } else {
                $_SESSION['error'] = "Failed to reopen job.";
            }
            header('Location: index.php?page=job&action=view&id=' . $_GET['id']);
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'delete':
        if(isset($_GET['id'])) {
            if(deleteJob($_GET['id'])) {
                $_SESSION['success'] = "Job deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete job.";
            }
        }
        header('Location: index.php?page=job&action=list');
        break;
        
    default:
        header('Location: index.php?page=job&action=list');
        break;
}
?>
