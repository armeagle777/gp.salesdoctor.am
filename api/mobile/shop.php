<?php
include '../db.php';
header('Content-Type: application/json');
if (isset($_GET) && isset($_GET['qr_id'])) {
    $qr_id = mysqli_real_escape_string($con, $_GET['qr_id']);
    $manager_id = mysqli_real_escape_string($con, $_GET['manager_id']);
    $sql=  "SELECT 
                shops.*,
    	        (shops.marketing_payment - PAYMENTS.PAYED_DEBT) AS debt 
            FROM shops 
                INNER JOIN manager_to_shop ON shops.shop_id=manager_to_shop.shop_id 
                LEFT JOIN (SELECT shop, SUM(debt) AS PAYED_DEBT FROM marketing_payments GROUP BY shop ) PAYMENTS ON shops.id = PAYMENTS.shop
            WHERE shops.qr_id='$qr_id' 
                AND manager_to_shop.manager_id='$manager_id'";

    $shop_query = mysqli_query($con, $sql);
    $shop = mysqli_fetch_assoc($shop_query);
    if (!$shop) {
        echo json_encode(array('notMyShop' => true));exit;
    }
    
    $rates_sql = "SELECT 
                    id,
                	title_hy,
                    title_en,
                    title_ru
                FROM rates
                WHERE  
                    active=1 ";
                    
    $rates= array();
    $select_query_result = mysqli_query($con,$rates_sql);
    if($select_query_result -> num_rows > 0):
        while($row = mysqli_fetch_assoc($select_query_result)):
            extract($row);
            $new_obj = array('id'=>$id, 'title' => array('hy' => $title_hy, 'en' => $title_en, 'ru' => $title_ru));
            array_push($rates,$new_obj);
        endwhile;
    endif;
    
    $result = array_merge($shop, array('rates' =>$rates));
    echo json_encode($result);exit;
} else if (isset($_POST['visit_id']) && isset($_POST['latitude']) && isset($_POST['latitude'])) {
    $visit_id = mysqli_real_escape_string($con, $_POST['visit_id']);
    $latitude = mysqli_real_escape_string($con, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($con, $_POST['longitude']);
    $visit_query = mysqli_query($con, "UPDATE visits SET longitude='$longitude', latitude='$latitude' WHERE id = '$visit_id'");
    echo json_encode($_POST);exit;
} else {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $latitude = mysqli_real_escape_string($con, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($con, $_POST['longitude']);
    $today = date("Y-m-d");
    $visit_query = mysqli_query($con, "SELECT * FROM visits WHERE manager_id = '$user_id' AND shop_id = '$shop_id' AND date LIKE '$today%' ");
    if ($visit_query->num_rows == 0) {
        mysqli_query($con, "INSERT INTO visits(manager_id, shop_id, comment, latitude, longitude)
		VALUES('$user_id', '$shop_id', '$comment', '$latitude', '$longitude');");
        $visit_query = mysqli_query($con, "SELECT *  FROM visits WHERE id=(SELECT LAST_INSERT_ID());");
    }
    echo json_encode(mysqli_fetch_assoc($visit_query));
    mysqli_close($con);exit;
}
