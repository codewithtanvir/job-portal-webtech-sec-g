<?php
require_once ROOT_PATH . 'config/database.php';

// Get overall system statistics
function get_overall_statistics()
{
    $conn = get_db_connection();

    $stats = array();

    // Total users
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
    $stats['total_users'] = mysqli_fetch_assoc($result)['count'];

    // New users this month
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
    $stats['new_users_month'] = mysqli_fetch_assoc($result)['count'];

    // Total jobs
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs");
    $stats['total_jobs'] = mysqli_fetch_assoc($result)['count'];

    // Active jobs
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE status = 'approved'");
    $stats['active_jobs'] = mysqli_fetch_assoc($result)['count'];

    // Total applications
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications");
    $stats['total_applications'] = mysqli_fetch_assoc($result)['count'];

    // Applications this month
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
    $stats['applications_month'] = mysqli_fetch_assoc($result)['count'];

    return $stats;
}

// Get monthly statistics for the last N months
function get_monthly_statistics($months = 6)
{
    $conn = get_db_connection();

    $stats = array();

    for ($i = $months - 1; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));

        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'");
        $user_count = mysqli_fetch_assoc($result)['count'];

        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'");
        $job_count = mysqli_fetch_assoc($result)['count'];

        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'");
        $app_count = mysqli_fetch_assoc($result)['count'];

        $stats[] = array(
            'month' => date('M Y', strtotime($month)),
            'users' => $user_count,
            'jobs' => $job_count,
            'applications' => $app_count
        );
    }

    return $stats;
}

// Get top categories by job count
function get_top_categories($limit = 5)
{
    $conn = get_db_connection();

    $query = "SELECT c.name, COUNT(j.id) as job_count
              FROM categories c
              LEFT JOIN jobs j ON c.id = j.category_id
              GROUP BY c.id
              ORDER BY job_count DESC
              LIMIT $limit";

    $result = mysqli_query($conn, $query);
    $categories = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    return $categories;
}

// Get top employers by job count
function get_top_employers($limit = 5)
{
    $conn = get_db_connection();

    $query = "SELECT u.username, u.full_name, COUNT(j.id) as job_count
              FROM users u
              LEFT JOIN jobs j ON u.id = j.employer_id
              WHERE u.user_type = 'employer'
              GROUP BY u.id
              ORDER BY job_count DESC
              LIMIT $limit";

    $result = mysqli_query($conn, $query);
    $employers = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $employers[] = $row;
    }

    return $employers;
}

// Get recent trends
function get_recent_trends()
{
    $conn = get_db_connection();

    $trends = array();

    // User growth rate (last 30 days vs previous 30 days)
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $recent_users = mysqli_fetch_assoc($result)['count'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $previous_users = mysqli_fetch_assoc($result)['count'];

    $trends['user_growth'] = $previous_users > 0 ? round((($recent_users - $previous_users) / $previous_users) * 100, 1) : 100;

    // Job posting rate
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $recent_jobs = mysqli_fetch_assoc($result)['count'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $previous_jobs = mysqli_fetch_assoc($result)['count'];

    $trends['job_growth'] = $previous_jobs > 0 ? round((($recent_jobs - $previous_jobs) / $previous_jobs) * 100, 1) : 100;

    return $trends;
}

// User report statistics
function get_user_report_statistics()
{
    $conn = get_db_connection();

    $stats = array();

    // By status
    $result = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM users GROUP BY status");
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['by_status'][$row['status']] = $row['count'];
    }

    // By type
    $result = mysqli_query($conn, "SELECT user_type, COUNT(*) as count FROM users GROUP BY user_type");
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['by_type'][$row['user_type']] = $row['count'];
    }

    return $stats;
}

// Get user registration trend
function get_user_registration_trend($months = 12)
{
    $conn = get_db_connection();

    $trend = array();

    for ($i = $months - 1; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));

        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'");
        $count = mysqli_fetch_assoc($result)['count'];

        $trend[] = array(
            'month' => date('M Y', strtotime($month)),
            'count' => $count
        );
    }

    return $trend;
}

// Get user type distribution
function get_user_type_distribution()
{
    $conn = get_db_connection();

    $query = "SELECT user_type, COUNT(*) as count FROM users GROUP BY user_type";
    $result = mysqli_query($conn, $query);

    $distribution = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $distribution[] = $row;
    }

    return $distribution;
}

// Job report statistics
function get_job_report_statistics()
{
    $conn = get_db_connection();

    $stats = array();

    // By status
    $result = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM jobs GROUP BY status");
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['by_status'][$row['status']] = $row['count'];
    }

    // By type
    $result = mysqli_query($conn, "SELECT job_type, COUNT(*) as count FROM jobs GROUP BY job_type");
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['by_type'][$row['job_type']] = $row['count'];
    }

    return $stats;
}

// Get job posting trend
function get_job_posting_trend($months = 12)
{
    $conn = get_db_connection();

    $trend = array();

    for ($i = $months - 1; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));

        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'");
        $count = mysqli_fetch_assoc($result)['count'];

        $trend[] = array(
            'month' => date('M Y', strtotime($month)),
            'count' => $count
        );
    }

    return $trend;
}

// Get job status distribution
function get_job_status_distribution()
{
    $conn = get_db_connection();

    $query = "SELECT status, COUNT(*) as count FROM jobs GROUP BY status";
    $result = mysqli_query($conn, $query);

    $distribution = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $distribution[] = $row;
    }

    return $distribution;
}

// Get jobs by category
function get_jobs_by_category()
{
    $conn = get_db_connection();

    $query = "SELECT c.name, COUNT(j.id) as count
              FROM categories c
              LEFT JOIN jobs j ON c.id = j.category_id
              GROUP BY c.id
              ORDER BY count DESC";

    $result = mysqli_query($conn, $query);
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

// Application report statistics
function get_application_report_statistics()
{
    $conn = get_db_connection();

    $stats = array();

    // By status
    $result = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM applications GROUP BY status");
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['by_status'][$row['status']] = $row['count'];
    }

    return $stats;
}

// Get application trend
function get_application_trend($months = 12)
{
    $conn = get_db_connection();

    $trend = array();

    for ($i = $months - 1; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));

        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'");
        $count = mysqli_fetch_assoc($result)['count'];

        $trend[] = array(
            'month' => date('M Y', strtotime($month)),
            'count' => $count
        );
    }

    return $trend;
}

// Get application status distribution
function get_application_status_distribution()
{
    $conn = get_db_connection();

    $query = "SELECT status, COUNT(*) as count FROM applications GROUP BY status";
    $result = mysqli_query($conn, $query);

    $distribution = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $distribution[] = $row;
    }

    return $distribution;
}

// Category report statistics
function get_category_report_statistics()
{
    $conn = get_db_connection();

    $query = "SELECT
                c.id,
                c.name,
                c.status,
                COUNT(DISTINCT j.id) as job_count,
                COUNT(DISTINCT a.id) as application_count
              FROM categories c
              LEFT JOIN jobs j ON c.id = j.category_id
              LEFT JOIN applications a ON j.id = a.job_id
              GROUP BY c.id
              ORDER BY job_count DESC";

    $result = mysqli_query($conn, $query);
    $stats = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $stats[] = $row;
    }

    return $stats;
}

// Get category performance
function get_category_performance()
{
    $conn = get_db_connection();

    $query = "SELECT
                c.name,
                COUNT(DISTINCT j.id) as total_jobs,
                COUNT(DISTINCT CASE WHEN j.status = 'approved' THEN j.id END) as active_jobs,
                COUNT(DISTINCT a.id) as total_applications,
                ROUND(COUNT(DISTINCT a.id) / NULLIF(COUNT(DISTINCT j.id), 0), 2) as avg_applications_per_job
              FROM categories c
              LEFT JOIN jobs j ON c.id = j.category_id
              LEFT JOIN applications a ON j.id = a.job_id
              GROUP BY c.id
              ORDER BY total_applications DESC";

    $result = mysqli_query($conn, $query);
    $performance = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $performance[] = $row;
    }

    return $performance;
}

// Export functions
function export_overall_report($output)
{
    $conn = get_db_connection();

    fputcsv($output, array('Overall System Report', date('Y-m-d H:i:s')));
    fputcsv($output, array());

    $stats = get_overall_statistics();
    fputcsv($output, array('Metric', 'Value'));
    foreach ($stats as $key => $value) {
        fputcsv($output, array(ucwords(str_replace('_', ' ', $key)), $value));
    }
}

function export_user_report($output)
{
    $conn = get_db_connection();

    fputcsv($output, array('User Report', date('Y-m-d H:i:s')));
    fputcsv($output, array());
    fputcsv($output, array('ID', 'Username', 'Email', 'Full Name', 'Type', 'Status', 'Registered'));

    $result = mysqli_query($conn, "SELECT id, username, email, full_name, user_type, status, created_at FROM users ORDER BY created_at DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
}

function export_job_report($output)
{
    $conn = get_db_connection();

    fputcsv($output, array('Job Report', date('Y-m-d H:i:s')));
    fputcsv($output, array());
    fputcsv($output, array('ID', 'Title', 'Employer', 'Category', 'Type', 'Location', 'Status', 'Posted'));

    $result = mysqli_query($conn, "SELECT j.id, j.title, u.username, c.name as category, j.job_type, j.location, j.status, j.created_at
                                    FROM jobs j
                                    LEFT JOIN users u ON j.employer_id = u.id
                                    LEFT JOIN categories c ON j.category_id = c.id
                                    ORDER BY j.created_at DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
}

function export_application_report($output)
{
    $conn = get_db_connection();

    fputcsv($output, array('Application Report', date('Y-m-d H:i:s')));
    fputcsv($output, array());
    fputcsv($output, array('ID', 'Job Title', 'Applicant', 'Status', 'Applied'));

    $result = mysqli_query($conn, "SELECT a.id, j.title, u.username, a.status, a.created_at
                                    FROM applications a
                                    LEFT JOIN jobs j ON a.job_id = j.id
                                    LEFT JOIN users u ON a.jobseeker_id = u.id
                                    ORDER BY a.created_at DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
}
