<?php
// Database configuration file
// this file connects to mysql database

// database credentials
$host = 'localhost';
$dbname = 'job_portal';
$username = 'root';
$password = '';
$port = 3307;

// create connection
$conn = mysqli_connect($host, $username, $password, $dbname, $port);

// check if connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
