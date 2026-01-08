<?php
require_once(__DIR__ . '/../models/AdminUserModel.php');
require_once(__DIR__ . '/../models/AdminHomeModel.php');

function admin_get_dashboard_stats()
{
    return getDashboardStats();
}
