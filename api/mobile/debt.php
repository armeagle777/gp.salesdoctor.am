<?php
require '../db.php';
header('Content-Type: application/json');



$json = file_get_contents('php://input');
$data = json_decode($json);

if(isset($_POST['debt'])){
    $shop_id = $_POST['shop'];
    $user_id = $_POST['user_id'];
    $visit = $_POST['visit'];
    $debt = $_POST['debt'];

    
    
    $sql = "INSERT INTO `marketing_payments`( `debt`, `shop`, `user_id`, `visit`) 
            VALUES ($debt,$shop_id,$user_id,$visit)";
    
    
    mysqli_query($con, $sql);
    
    $select_sql = "SELECT * FROM marketing_payments WHERE id=LAST_INSERT_ID()";

    $select_query_result = mysqli_query($con,$select_sql);
    $row = mysqli_fetch_assoc($select_query_result);
    extract($row);
    
    $result = array("id" =>$id, "shop" => $shop_id, "user_id" => $user_id, "visit" => $visit);
    
    echo json_encode($result);
    mysqli_close($con);
    exit;
}