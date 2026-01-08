<?php
require_once(__DIR__ . '/../../config/database.php');

function getDashboardStats()
{
    $conn = getConnection();
    $res1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
    $totalUsers = mysqli_fetch_assoc($res1)['total'];
    $res2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='employer'");
    $totalEmployers = mysqli_fetch_assoc($res2)['total'];

    mysqli_close($conn);

    return [
        'users' => $totalUsers,
        'employers' => $totalEmployers
    ];
}
