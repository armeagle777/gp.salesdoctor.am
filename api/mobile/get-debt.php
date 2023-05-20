<?php
require '../db.php';
header('Content-Type: application/json');



if(isset($_GET['shop_id'])){
    $shop_id = mysqli_real_escape_string($con, $_GET['shop_id']);
    
    $select_sql =  "SELECT 
                    	S.guyq, 
                    	S.marketing_payment,
                        PAYMENTS.shop,
                        PAYMENTS.PAYED_DEBT
                    from 
                    	shops S 
                    	LEFT JOIN (
                    		SELECT 
                    			shop, 
                    			SUM(debt) AS PAYED_DEBT 
                    		FROM 
                    			marketing_payments 
                    		WHERE 
                    			shop = $shop_id
                    		GROUP BY 
                    			shop
                    	) PAYMENTS ON S.id = PAYMENTS.shop
                    WHERE 
                    	S.id = $shop_id";


    $select_query_result = mysqli_query($con,$select_sql);
    $row = mysqli_fetch_assoc($select_query_result);
    extract($row);
    $debt = (int)$marketing_payment - (int)$PAYED_DEBT;
    $result = array("shop" => $shop, "guyq" => $guyq, "debt" => $debt);
    
    echo json_encode($result);
    mysqli_close($con);
    exit;
}