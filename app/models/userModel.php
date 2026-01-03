<?php
require_once('db.php');

function getAllUsers()
{
    $conn = getConnection();
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    mysqli_close($conn);
    return $users;
}

function checkUserExists($username, $email)
{
    $conn = getConnection();
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $sql);
    $exists = mysqli_num_rows($result) > 0;
    mysqli_close($conn);
    return $exists;
}

function addUser($username, $email, $password, $dob, $role)
{
    $conn = getConnection();
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $dob = mysqli_real_escape_string($conn, $dob);
    $role = mysqli_real_escape_string($conn, $role);

    $sql = "INSERT INTO users (username, email, password, dob, role, is_verified) VALUES ('$username', '$email', '$password', '$dob', '$role', 1)";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function deleteUserById($id)
{
    $conn = getConnection();
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "DELETE FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function updateUser($id, $username, $email, $role)
{
    $conn = getConnection();
    $id = mysqli_real_escape_string($conn, $id);
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $role = mysqli_real_escape_string($conn, $role);

    $sql = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getDashboardStats()
{
    $conn = getConnection();

    // Total Users
    $res1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
    $totalUsers = mysqli_fetch_assoc($res1)['total'];

    // Active Employers
    $res2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='employer'");
    $totalEmployers = mysqli_fetch_assoc($res2)['total'];

    // Total Jobs (Checking if table exists first to avoid errors)
    $res3 = mysqli_query($conn, "SHOW TABLES LIKE 'jobs'");
    $totalJobs = 0;
    if (mysqli_num_rows($res3) > 0) {
        $res3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM jobs");
        $totalJobs = mysqli_fetch_assoc($res3)['total'];
    }

    // Total Applications (Checking if table exists first)
    $res4 = mysqli_query($conn, "SHOW TABLES LIKE 'applications'");
    $totalApps = 0;
    if (mysqli_num_rows($res4) > 0) {
        $res4 = mysqli_query($conn, "SELECT COUNT(*) as total FROM applications");
        $totalApps = mysqli_fetch_assoc($res4)['total'];
    }

    mysqli_close($conn);

    return [
        'users' => $totalUsers,
        'employers' => $totalEmployers,
        'jobs' => $totalJobs,
        'apps' => $totalApps
    ];
}
