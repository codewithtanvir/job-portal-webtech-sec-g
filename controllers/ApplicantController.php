<?php
// Applicant Controller - Handles applicant and application requests
require_once 'models/ApplicantModel.php';
require_once 'models/JobModel.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch($action) {
    case 'list':
        if(isset($_GET['job_id'])) {
            $job = getJobById($_GET['job_id']);
            $applications = getApplicationsByJob($_GET['job_id']);
            
            // Get counts for each status
            $pending_count = countApplicationsByStatus($_GET['job_id'], 'Pending');
            $shortlisted_count = countApplicationsByStatus($_GET['job_id'], 'Shortlisted');
            $rejected_count = countApplicationsByStatus($_GET['job_id'], 'Rejected');
            $hired_count = countApplicationsByStatus($_GET['job_id'], 'Hired');
            
            require_once 'views/applicant/list.php';
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'view':
        if(isset($_GET['id'])) {
            $application = getApplicationById($_GET['id']);
            require_once 'views/applicant/view.php';
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'apply':
        if(isset($_GET['job_id'])) {
            $job = getJobById($_GET['job_id']);
            
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Create applicant
                $applicant_data = array(
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'cover_letter' => $_POST['cover_letter']
                );
                
                $applicant_id = createApplicant($applicant_data);
                
                if($applicant_id) {
                    // Create application
                    $application_data = array(
                        'job_id' => $_GET['job_id'],
                        'applicant_id' => $applicant_id,
                        'applied_date' => date('Y-m-d')
                    );
                    
                    if(createApplication($application_data)) {
                        $_SESSION['success'] = "Application submitted successfully!";
                        header('Location: index.php?page=job&action=view&id=' . $_GET['job_id']);
                        exit();
                    }
                }
                
                $_SESSION['error'] = "Failed to submit application.";
            }
            
            require_once 'views/applicant/apply.php';
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'shortlist':
        if(isset($_GET['id'])) {
            $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
            
            if(updateApplicationStatus($_GET['id'], 'Shortlisted', $notes)) {
                $_SESSION['success'] = "Candidate shortlisted successfully!";
            } else {
                $_SESSION['error'] = "Failed to shortlist candidate.";
            }
            
            $application = getApplicationById($_GET['id']);
            header('Location: index.php?page=applicant&action=list&job_id=' . $application['job_id']);
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'reject':
        if(isset($_GET['id'])) {
            $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
            
            if(updateApplicationStatus($_GET['id'], 'Rejected', $notes)) {
                $_SESSION['success'] = "Candidate rejected.";
            } else {
                $_SESSION['error'] = "Failed to reject candidate.";
            }
            
            $application = getApplicationById($_GET['id']);
            header('Location: index.php?page=applicant&action=list&job_id=' . $application['job_id']);
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'hire':
        if(isset($_GET['id'])) {
            $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
            
            if(updateApplicationStatus($_GET['id'], 'Hired', $notes)) {
                $_SESSION['success'] = "Candidate marked as hired!";
            } else {
                $_SESSION['error'] = "Failed to update status.";
            }
            
            $application = getApplicationById($_GET['id']);
            header('Location: index.php?page=applicant&action=list&job_id=' . $application['job_id']);
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    case 'status':
        if(isset($_GET['id'])) {
            $application = getApplicationById($_GET['id']);
            require_once 'views/applicant/status.php';
        } else {
            header('Location: index.php?page=job&action=list');
        }
        break;
        
    default:
        header('Location: index.php?page=job&action=list');
        break;
}
?>
