<?php

$servername = "127.0.0.1";
$username = "ajmd1700_ajmd17";
$password = "***REMOVED***";
$dbname = "ajmd1700_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Error message: " . $conn->connect_error);
} 

?>