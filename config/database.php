<?php

function getConnection()
{
    $host = 'localhost';
    $dbname = 'job_portal';
    $username = 'root';
    $password = '';
    $port = 3307;

    $conn = @mysqli_connect($host, $username, $password, '', $port);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $result = mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $dbname");
    mysqli_select_db($conn, $dbname);

    return $conn;
}
