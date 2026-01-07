<?php
require_once ROOT_PATH . 'models/JobModel.php';

function job_controller($action)
{
    // Check if user is logged in and is admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit();
    }

    switch ($action) {
        case 'index':
        case 'list':
            list_jobs();
            break;

        case 'pending':
            list_pending_jobs();
            break;

        case 'approve':
            approve_job();
            break;

        case 'reject':
            reject_job();
            break;

        case 'close':
            close_job();
            break;

        case 'delete':
            delete_job();
            break;

        case 'view':
            view_job();
            break;

        default:
            list_jobs();
            break;
    }
}

function list_jobs()
{
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $jobs = get_all_jobs($filter, $search);

    $page_title = 'Job Management';
    require_once ROOT_PATH . 'views/jobs/list.php';
}

function list_pending_jobs()
{
    $jobs = get_jobs_by_status('pending');

    $page_title = 'Pending Jobs Approval';
    require_once ROOT_PATH . 'views/jobs/pending.php';
}

function approve_job()
{
    if (isset($_GET['id'])) {
        $job_id = intval($_GET['id']);

        if (update_job_status($job_id, 'approved')) {
            log_activity($_SESSION['user_id'], 'job_approved', "Approved job ID: $job_id");
            $_SESSION['success'] = 'Job approved successfully';
        } else {
            $_SESSION['error'] = 'Failed to approve job';
        }
    }

    header('Location: ' . BASE_URL . '?page=jobs');
    exit();
}

function reject_job()
{
    if (isset($_GET['id'])) {
        $job_id = intval($_GET['id']);

        if (update_job_status($job_id, 'rejected')) {
            log_activity($_SESSION['user_id'], 'job_rejected', "Rejected job ID: $job_id");
            $_SESSION['success'] = 'Job rejected';
        } else {
            $_SESSION['error'] = 'Failed to reject job';
        }
    }

    header('Location: ' . BASE_URL . '?page=jobs');
    exit();
}

function close_job()
{
    if (isset($_GET['id'])) {
        $job_id = intval($_GET['id']);

        if (update_job_status($job_id, 'closed')) {
            log_activity($_SESSION['user_id'], 'job_closed', "Closed job ID: $job_id");
            $_SESSION['success'] = 'Job closed successfully';
        } else {
            $_SESSION['error'] = 'Failed to close job';
        }
    }

    header('Location: ' . BASE_URL . '?page=jobs');
    exit();
}

function delete_job()
{
    if (isset($_GET['id'])) {
        $job_id = intval($_GET['id']);

        if (delete_job_by_id($job_id)) {
            log_activity($_SESSION['user_id'], 'job_deleted', "Deleted job ID: $job_id");
            $_SESSION['success'] = 'Job deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete job';
        }
    }

    header('Location: ' . BASE_URL . '?page=jobs');
    exit();
}

function view_job()
{
    if (!isset($_GET['id'])) {
        header('Location: ' . BASE_URL . '?page=jobs');
        exit();
    }

    $job_id = intval($_GET['id']);
    $job = get_job_by_id($job_id);

    if (!$job) {
        $_SESSION['error'] = 'Job not found';
        header('Location: ' . BASE_URL . '?page=jobs');
        exit();
    }

    // Get job applications
    $applications = get_job_applications($job_id);

    $page_title = 'View Job';
    require_once ROOT_PATH . 'views/jobs/view.php';
}
