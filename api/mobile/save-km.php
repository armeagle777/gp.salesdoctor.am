<?php
require '../db.php';
header('Content-Type: application/json');



$json = file_get_contents('php://input');
$data = json_decode($json);

if(isset($_POST['km'])){
    $user_id = $_POST['user_id'];
    $km = $_POST ['km'];
    
    $sql = "INSERT INTO `km_passed`( `km`,  `user_id`) 
            VALUES ($km,$user_id)";
    
    
    mysqli_query($con, $sql);
    
    $select_sql = "SELECT * FROM km_passed WHERE id=LAST_INSERT_ID()";

    $select_query_result = mysqli_query($con,$select_sql);
    $row = mysqli_fetch_assoc($select_query_result);
    extract($row);
    
    $result = array("id" =>$id, "user_id" => $user_id, "km" => $km);
    
    echo json_encode($result);
    mysqli_close($con);
    exit;
}