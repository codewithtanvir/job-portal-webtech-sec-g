<?php
require_once(__DIR__ . '/../Models/UserModel.php');
require_once(__DIR__ . '/../Models/AdminDashboardModel.php');

function admin_get_dashboard_stats()
{
    return getDashboardStats();
}
