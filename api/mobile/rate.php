<?php
require '../db.php';
header('Content-Type: application/json');


$json = file_get_contents('php://input');
$data = json_decode($json);


if(isset($_POST['rate'])){
    $shop_id = $_POST['shop'];
    $user_id = $_POST['user_id'];
    $visit = $_POST['visit'];
    $rate = $_POST['rate'];
    

    
    $sql = "INSERT INTO `shop_evaluation`( 
                `shop_id`, 
                `manager_id`, 
                `visit_id`,
                `rate_id`,
                `rate_value`
                ) 
            VALUES ";
    $elements = get_object_vars ( $rate );
    foreach($elements as $key=>$value) {
        $sql .= " ($shop_id,$user_id,$visit, $key,$value),";
    }
    $sql = rtrim($sql, ",");

    mysqli_query($con, $sql);
    
    
    $result=array();
    $rates=new stdClass();
    $select_sql = "SELECT * FROM shop_evaluation WHERE shop_id=$shop_id AND visit_id=$visit";

    $select_query_result = mysqli_query($con,$select_sql);
    if($select_query_result -> num_rows > 0):
        while($row = mysqli_fetch_assoc($select_query_result)):
            extract($row); 
            $rates -> $rate_id = $rate_value;
        endwhile;
        $result = array( "shop" => $shop_id, "user_id" => $manager_id, "visit" => $visit_id, "rate"=>$rates);
    endif;
    
  
    
    echo json_encode($result);
    mysqli_close($con);
    exit;
}
