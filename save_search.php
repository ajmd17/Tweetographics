<?php
// save the search in the sql database
include "mysql_connect.php";

if (isset($_POST["search_data"])) 
{
    $data = mysqli_real_escape_string($conn, $_POST["search_data"]);
    $query = "undefined";
    $date = date("Y-m-d h:i:sa");
    
    if (isset($_POST["query"])) 
    {
        $query = $_POST["query"];    
    }
    
    $sql = "INSERT INTO saved_searches (query, data, date) VALUES ('$query', '$data', '$date');";

    if (!$conn->query($sql)) {
        echo -1; // return -1 ID for error
    } else {
        echo $conn->insert_id;
    }
}
?>