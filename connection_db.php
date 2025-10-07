<?php

// Database connection
$servername = "localhost";
$username   = "root";  // change if needed
$password   = "";      // change if needed
$dbname     = "hrm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>