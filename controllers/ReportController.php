<?php
require_once ROOT_PATH . 'models/ReportModel.php';

function report_controller($action)
{
    // Check if user is logged in and is admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit();
    }

    switch ($action) {
        case 'index':
        case 'dashboard':
            reports_dashboard();
            break;

        case 'users':
            user_reports();
            break;

        case 'jobs':
            job_reports();
            break;

        case 'applications':
            application_reports();
            break;

        case 'categories':
            category_reports();
            break;

        case 'export':
            export_report();
            break;

        default:
            reports_dashboard();
            break;
    }
}

function reports_dashboard()
{
    // Get overall statistics
    $overall_stats = get_overall_statistics();
    $monthly_stats = get_monthly_statistics();
    $top_categories = get_top_categories(5);
    $top_employers = get_top_employers(5);
    $recent_trends = get_recent_trends();

    $page_title = 'Reports & Analytics';
    require_once ROOT_PATH . 'views/reports/dashboard.php';
}

function user_reports()
{
    $user_stats = get_user_report_statistics();
    $user_registration_trend = get_user_registration_trend(12);
    $user_type_distribution = get_user_type_distribution();

    $page_title = 'User Reports';
    require_once ROOT_PATH . 'views/reports/users.php';
}

function job_reports()
{
    $job_stats = get_job_report_statistics();
    $job_posting_trend = get_job_posting_trend(12);
    $job_status_distribution = get_job_status_distribution();
    $jobs_by_category = get_jobs_by_category();

    $page_title = 'Job Reports';
    require_once ROOT_PATH . 'views/reports/jobs.php';
}

function application_reports()
{
    $application_stats = get_application_report_statistics();
    $application_trend = get_application_trend(12);
    $application_status_distribution = get_application_status_distribution();

    $page_title = 'Application Reports';
    require_once ROOT_PATH . 'views/reports/applications.php';
}

function category_reports()
{
    $category_stats = get_category_report_statistics();
    $category_performance = get_category_performance();

    $page_title = 'Category Reports';
    require_once ROOT_PATH . 'views/reports/categories.php';
}

function export_report()
{
    $type = isset($_GET['type']) ? $_GET['type'] : 'overall';

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="report_' . $type . '_' . date('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');

    switch ($type) {
        case 'users':
            export_user_report($output);
            break;
        case 'jobs':
            export_job_report($output);
            break;
        case 'applications':
            export_application_report($output);
            break;
        default:
            export_overall_report($output);
            break;
    }

    fclose($output);
    exit();
}
