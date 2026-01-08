<?php
function getConnection()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "job_portal"; 
    $PORT = 3306;

    $conn = mysqli_connect($host, $user, $pass, $dbname, $PORT);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
