<?php

$dbHost = "localhost";
$dbName = "job_portal";
$dbUser = "root";
$dbPass = "";
$dbPort = 3306;

function getConnection()
{
    global $dbHost, $dbName, $dbUser, $dbPass, $dbPort;

    $connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

    if (!$connection) {
        http_response_code(500);
        die("Database connection failed.");
    }

    mysqli_set_charset($connection, 'utf8mb4');
    return $connection;
}
