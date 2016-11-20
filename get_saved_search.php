<?php 
// return a saved search from the database
include "mysql_connect.php";

if (isset($_POST["saved_search_id"])) 
{
    $id = $_POST["saved_search_id"];
    $sql = "SELECT * FROM saved_searches WHERE id = ('$id');";

    if (!($res = $conn->query($sql))) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $row = $res->fetch_array();
    
    $returns = array();
    $returns['query'] = $row['query'];
    $returns['data'] = $row['data'];
    $returns['date'] = date("Y/m/d", strtotime($row['date']));
    
    echo json_encode($returns);
}
?>