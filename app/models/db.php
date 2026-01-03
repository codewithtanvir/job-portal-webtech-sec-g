<?php
function getConnection()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "job_portal"; // Assuming the database name

    $conn = mysqli_connect($host, $user, $pass, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
