<?php

$servername = "127.0.0.1";
$username = /*USERNAME*/;
$password = /*PASSWORD*/;
$dbname = /*DATABASE*/;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Error message: " . $conn->connect_error);
} 

?>