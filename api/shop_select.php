<?php
session_start();
$user_id = $_SESSION['user_id'];

include 'db.php';
$array_user = mysqli_fetch_array(mysqli_query($con, "SELECT discount FROM manager WHERE id = '$user_id' "));
$user_discount = $array_user['discount'];

if(isset($_POST['district'])){
	
		if($_SESSION['user_role'] == '1'){
			$shops_query_change = " AND static_manager = $user_id ";
		}else{
			$shops_query_change = '';
		}
		
		if($_POST['mobile_user_id'] != ''){
			$mobile_user_id = mysqli_real_escape_string($con, $_POST['mobile_user_id']);

			$shops_query_change = " AND static_manager = '$mobile_user_id' ";
		}
		
		$district = mysqli_real_escape_string($con, $_POST['district']);
		$query_shops = mysqli_query($con, "SELECT * FROM shops WHERE district = '$district' $shops_query_change ORDER BY filter_n ASC");

		$data = "<option value='0'>Ընտրել</option>";
		while($shops_array = mysqli_fetch_array($query_shops)){
			$data .= "<option value='{$shops_array['shop_id']}'>{$shops_array['shop_id']}.{$shops_array['name']} - {$shops_array['address']}</option>";
		}
		
		echo $data;

}



if(isset($_POST['action']) AND $_POST['action'] == 'shop_details'){
	try{

	
		
		$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
		$query_shops = mysqli_query($con, "SELECT * FROM shops WHERE shop_id = '$shop_id' ");
		
		$array_shop_detils = mysqli_fetch_array($query_shops);

		if (mysqli_num_rows($query_shops)==0){
			$query_shops = mysqli_query($con, "SELECT * FROM shops WHERE id = '$shop_id' ");
			$array_shop_detils = mysqli_fetch_array($query_shops);
		}
		
		$current_network_id = $array_shop_detils['network'];
		$network_limit_query = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM network WHERE id = '$current_network_id' "));
		
		if($current_network_id > 0){
			
				$array_shops_orders = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total_sum FROM `shops` LEFT JOIN pr_orders_document on pr_orders_document.shop_id = shops.shop_id WHERE shops.network = '$current_network_id' AND order_type !='2' "));
				
				$array_shops_veradardz = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total_sum FROM `shops` LEFT JOIN pr_orders_document on pr_orders_document.shop_id = shops.shop_id WHERE shops.network = '$current_network_id' AND order_type = '2'  "));
				
				$array_shops_payed = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_summ) AS total_sum FROM `shops` LEFT JOIN pr_orders_finance on pr_orders_finance.shop_id = shops.shop_id WHERE shops.network = '$current_network_id' "));
				
				$network_balance = $array_shops_orders['total_sum'] - $array_shops_veradardz['total_sum'] - $array_shops_payed['total_sum']; 
			
			
		}
		
		

		
		$month = date('m');


		//For checking unundestandable 
		$query_summ_orders = mysqli_fetch_array(mysqli_query($con, "SELECT sum(order_last_summ) AS summ FROM pr_orders_document WHERE order_type = '1' AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4' ) AND shop_id = '$shop_id' AND MONTH(document_date) = '$month' " ));
		
		$query_summ_orders_veradardz = mysqli_fetch_array(mysqli_query($con, "SELECT sum(order_last_summ) AS summ FROM pr_orders_document WHERE order_type = '2' AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4' ) AND shop_id = '$shop_id' AND MONTH(document_date) = '$month' " ));
						
		$total_summ = $query_summ_orders['summ'] - $query_summ_orders_veradardz['summ'];
		
		
		
		// For checking shop balance
		$query_for_all_dept = mysqli_fetch_array(mysqli_query($con, "SELECT sum(order_last_summ) AS summ FROM pr_orders_document WHERE shop_id = '$shop_id' AND (order_type = '1' or order_type = '0') "));
		
		$query_for_all_dept_finance = mysqli_fetch_array(mysqli_query($con, "SELECT sum(order_summ) AS summ FROM pr_orders_finance WHERE shop_id = '$shop_id' "));
		
		$query_for_all_dept_veradardz = mysqli_fetch_array(mysqli_query($con, "SELECT sum(order_last_summ) AS summ FROM pr_orders_document WHERE order_type = '2' AND  shop_id = '$shop_id' "));
		

		
		$limit_cash = $array_shop_detils['limit_cash'] ? $array_shop_detils['limit_cash'] : 0;
		$limit_cash_ha = $array_shop_detils['limit_cash_ha'] ? $array_shop_detils['limit_cash_ha'] : 0;

		$limit_debt = $array_shop_detils['limit_debt'] ? $array_shop_detils['limit_debt'] : 0;
		$limit_debt_ha = $array_shop_detils['limit_debt_ha'] ? $array_shop_detils['limit_debt_ha'] : 0;
		$limit_credit = $array_shop_detils['limit_credit'] ? $array_shop_detils['limit_credit'] : 0;
		$limit_credit_ha = $array_shop_detils['limit_credit_ha'] ? $array_shop_detils['limit_credit_ha'] : 0;

		$total_limit = $limit_cash + $limit_cash_ha + $limit_debt + $limit_debt_ha + $limit_credit + $limit_credit_ha;
		$shop_details = array();
		$shop_details[0] = "
		
			<option value='0'>Ընտրել</option>
			<option value='1'>Կանխիկ - {$array_shop_detils['limit_cash']}</option>
			<option value='2'>Կանխիկ Հ/Ա - {$array_shop_detils['limit_cash_ha']}</option>
			<option value='3'>Պարտք - {$array_shop_detils['limit_debt']}</option>
			<option value='4'>Պարտք Հ/Ա - {$array_shop_detils['limit_debt_ha']}</option>
			<option value='5'>Կրեդիտ - {$array_shop_detils['limit_credit']}</option>
			<option value='6'>Կրեդիտ Հ/Ա - {$array_shop_detils['limit_credit_ha']}</option>
		
		
		";

		if($array_shop_detils['balance'] == ''){
			$array_shop_detils['balance'] = 0;
		}
		$shop_details[1] = $query_for_all_dept['summ'] - $query_for_all_dept_veradardz['summ'] - $query_for_all_dept_finance['summ'];
		$shop_details[2] = $total_limit;
		$shop_details[3] = $total_summ;
		$shop_details[4] = $array_shop_detils['comment'];
	    $shop_details[5] = $network_limit_query['network_limit'];
	    $shop_details[7] = $network_limit_query['id'];
	    $shop_details[8] = $network_balance;
		
		echo json_encode($shop_details);
	}catch(Exception $e){
		echo 'Message: ' .$e->getMessage();
	}
	
}






if(isset($_POST['product_group'])){
		
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	$query_discount_shop = mysqli_query($con, "SELECT discount, shop_id FROM shops WHERE shop_id = '$shop_id' ");
	$array_shop_discount = mysqli_fetch_array($query_discount_shop);
	
	$discount = $array_shop_discount['discount'];
	
	$product_group = mysqli_real_escape_string($con, $_POST['product_group']);
	
	$query = mysqli_query($con, "SELECT * FROM pr_products WHERE product_group = '$product_group' AND active = 'on' ORDER BY regular_n ASC");
	$data = '';
	
	while ($array_products = mysqli_fetch_array($query)){
		
		if($user_discount !='on'){
			$discount_permission = ' disabled ';
		}else{
			$discount_permission = '';
		}
		
		$product_id = $array_products['id'];
		$product_name = $array_products['name'];
		$product_price = $array_products['sale_price'];
		$product_price_start = $array_products['sale_price'];
		$product_price_old = $array_products['sale_price'];
		//$product_balance = $array_products['balance'];
		
		$query_product_balance = mysqli_query($con, "SELECT sum(product_count) as products_count FROM `pr_warehouse_products` WHERE product_id = '$product_id'");
		$product_balance_array = mysqli_fetch_array($query_product_balance);
		$product_balance = $product_balance_array['products_count'];
		
		if($product_balance == ''){
			$product_balance = 0;
		}
		
		if($discount > 0){
			$product_price = $product_price - ($product_price * ($discount / 100));  
		}
		
		$data .= "<tr>";
		$data .= "<td>$product_name</td>";
		$data .= "<td><input type='number' class='form-control product_count product_count_$product_id' id='$product_id' name='prod_count[]' min='0'></td>";
		$data .= "<td><input type='number' name='discount' class='discount form-control discount_$product_id' data-price='$product_price_old' value='$discount' id='$product_id' min='0' max='100' $discount_permission></td>";
		$data .= "<td class='product_$product_id'>$product_price</td>";
		$data .= "<td>$product_balance<span class='totalprice' id='totalprice_$product_id' style='display:none;'>0</span></td>";
		$data .= "<td class=''>$product_price_start</td>";
		$data .= "</tr>";
	}
		
	echo $data;

}

if(isset($_POST['type']) AND $_POST['type'] == 'add_order'){
	
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);

	$static_manager_array = mysqli_fetch_array(mysqli_query($con, "SELECT static_manager FROM shops WHERE shop_id = '$shop_id' "));
	
	$static_manager = $static_manager_array['static_manager'];
	
	$product_group = mysqli_real_escape_string($con, $_POST['product_group_add']);
	$pay_type = mysqli_real_escape_string($con, $_POST['product_payment']);
	$manager_id = mysqli_real_escape_string($con, $_POST['manager_id']);
	$comment = mysqli_real_escape_string($con, $_POST['comment']);
	$order_type = mysqli_real_escape_string($con, $_POST['order_type']);
	$debt_date = mysqli_real_escape_string($con, $_POST['debt_date']);
	$order_start_date = mysqli_real_escape_string($con, $_POST['order_start_date']);
	
	$order_summ = mysqli_real_escape_string($con, $_POST['order_summ']);

	$product = mysqli_real_escape_string($con, $_POST['product']);
	$products = json_decode($_POST['product'], true);
	
	$document_date = $order_start_date;
	$date = date_create();
	$document_id = date_timestamp_get($date);
	
	if($pay_type == '1' or $pay_type == '2' or $pay_type == '5' or $pay_type == '6' ){
		$debt_date = '';
	}
	
	echo $pay_type;
	echo $debt_date;
	
	foreach ($products as $value) {
		
		$prod_id = $value['prod_id'];
		$prod_count = $value['prod_count'];
		$product_procent = $value['prod_procent'];
		$product_cost = $value['prod_cost'];
		
	
		$query_insert = mysqli_query($con, "INSERT INTO pr_orders (document_id, shop_id, manager_id, product_id, product_count, document_date, pay_type, order_type, order_comment, product_procent, product_cost, product_last_cost, debt_date, product_group, static_manager) VALUES ('$document_id', '$shop_id', '$manager_id', '$prod_id', '$prod_count', '$document_date', '$pay_type', '$order_type', '$comment', '$product_procent', '$product_cost', '$product_cost', '$debt_date', '$product_group', '$static_manager')");
						
		
	}
		
	$pr_orders_document = mysqli_query($con, "INSERT INTO pr_orders_document (document_id, document_date, order_summ, shop_id, manager_id, pay_type, order_type, debt_date, product_group, order_comment, static_manager) VALUES ('$document_id','$document_date','$order_summ','$shop_id', '$manager_id', '$pay_type', '$order_type', '$debt_date', '$product_group', '$comment', '$static_manager')");
	
	
	//echo  "INSERT INTO pr_orders_document (document_id, document_date, order_summ, shop_id, manager_id, pay_type, order_type, debt_date, product_group, order_comment, static_manager) VALUES ('$document_id','$document_date','$order_summ','$shop_id', '$manager_id', '$pay_type', '$order_type', '$debt_date', '$product_group', '$comment', '$static_manager')";

}


if(isset($_POST['type']) AND $_POST['type'] == 'add_pre_order'){
    try {
    $product_group = mysqli_real_escape_string($con, $_POST['product_group_add']);
    $order_start_date = strtotime(mysqli_real_escape_string($con, $_POST['order_start_date']));
    $manager_id = mysqli_real_escape_string($con, $_POST['manager_id']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $order_type = mysqli_real_escape_string($con, $_POST['order_type']);
    $order_sum = mysqli_real_escape_string($con, $_POST['order_summ']);
    $products = json_decode($_POST['product'], true);
    $courier_select =mysqli_real_escape_string($con, $_POST['courier_select']);
    $create_id = time().rand(10000, 99999);
    foreach ($products as $value) {

        $prod_id = $value['prod_id'];
        $prod_count = $value['prod_count'];
        $product_procent = $value['prod_procent'];
        $product_cost = $value['prod_cost'];
        $sql = "INSERT INTO pre_order (product_group,order_start_date,manager_id,order_type,order_sum,courier_select,prod_id,prod_count,product_procent,product_cost,create_id)VALUES ('$product_group', '$order_start_date', '$manager_id', '$order_type', '$order_sum', '$courier_select', '$prod_id', '$prod_count', '$product_procent', '$product_cost','$create_id');";
        $query_insert = mysqli_query($con ,$sql);
    }
    if($comment){
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO comment (whereis,who,text_comment,comment_id) VALUES ('pre_order',' $user_id','$comment','$create_id')";
        mysqli_query($con ,$sql);
    }
        echo "true";exit;
    } catch (Exception $e) {
        echo "false";exit;
    }

    //$pr_orders_document = mysqli_query($con, "INSERT INTO pr_orders_document (document_id, document_date, order_summ, order_last_summ, shop_id, manager_id, pay_type, order_type, debt_date, product_group, order_comment, static_manager, courier_id) VALUES ('$document_id','$document_date','$order_summ','$order_summ','$shop_id', '$manager_id', '$pay_type', '$order_type', '$debt_date', '$product_group', '$comment', '$static_manager', '$static_courier')");
    //echo  "INSERT INTO pr_orders_document (document_id, document_date, order_summ, shop_id, manager_id, pay_type, order_type, debt_date, product_group, order_comment, static_manager) VALUES ('$document_id','$document_date','$order_summ','$shop_id', '$manager_id', '$pay_type', '$order_type', '$debt_date', '$product_group', '$comment', '$static_manager')";
}



if(isset($_POST['action']) AND $_POST['action'] == 'get_shop_order_limit'){
		
		$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
		$payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);
		
		$query_shops = mysqli_query($con, "SELECT * FROM shops WHERE shop_id = '$shop_id' ");
		
		$query_summ_orders = mysqli_fetch_array(mysqli_query($con, "SELECT sum(order_last_summ) AS summ FROM pr_orders_document WHERE order_type = '1' AND pay_type = '$payment_type' AND shop_id = '$shop_id' AND order_pay_status !='3' "));
		
		
		$query_summ_orders_veradardz = mysqli_fetch_array(mysqli_query($con, "SELECT sum(order_last_summ) AS summ FROM pr_orders_document WHERE order_type = '2' AND pay_type = '$payment_type' AND shop_id = '$shop_id'" ));
						
		$open_total_summ = $query_summ_orders['summ'] - $query_summ_orders_veradardz['summ'];
			
		$array_shop_detils = mysqli_fetch_array($query_shops);
		
		if($payment_type == 1){
			$limit_type = $array_shop_detils['limit_cash'];
		}if($payment_type == 2){
			$limit_type = $array_shop_detils['limit_cash_ha'];
		}if($payment_type == 3){
			$limit_type = $array_shop_detils['limit_debt'];
		}if($payment_type == 4){
			$limit_type = $array_shop_detils['limit_debt_ha'];
		}if($payment_type == 5){
			$limit_type = $array_shop_detils['limit_credit'];
		}if($payment_type == 6){
			$limit_type = $array_shop_detils['limit_credit_ha'];
		}
				
		$shop_details = array();
		
		$shop_details[0] = $limit_type - $open_total_summ;
		$shop_details[1] = $open_total_summ;

		echo json_encode($shop_details);
	
}


if (isset($_POST['action']) and $_POST['action'] == 'add_payment') {

    if ($_POST['setsum'] >= $_POST['sum']) {
        if (!$_POST['setsum'] || !$_POST['courier_select'] || !$_POST['manager_id'] || !$_POST['date'] || !$_POST['pre_uniq_id']) {
            echo "false";
            exit;
        }
    }
            try {
                $sum = $_POST['setsum'];
				$order_sum=$_POST['sum'];
				$newordersum=$order_sum-$sum;
                $courier_select = $_POST['courier_select'];
                $menager_id = $_POST['manager_id'];
                $date_payment =$_POST['date'];
                $pre_uniq_id = $_POST['pre_uniq_id'];
				$comment = $_POST['comment'];
                $sql = "INSERT INTO pre_order_payments (sumes,courier_select,menager_id,date_payment,pre_uniq_id,comment)VALUES ('$sum','$courier_select','$menager_id','$date_payment','$pre_uniq_id','$comment');";
                $query_insert = mysqli_query($con, $sql);
                $sqlupdate = "UPDATE pre_order SET order_sum='$newordersum', status = '1' WHERE create_id='$pre_uniq_id'";
                $query_update = mysqli_query($con, $sqlupdate);
                    echo "true";
                    exit;
                }
            catch(Exception $e) {
                    echo "false";
                    exit;
                }


}
if (isset($_POST['action']) and $_POST['action'] == 'updatepre') {
    $id = $_POST['id'];
	$value = $_POST['value'];
	$sql = "SELECT product_cost,prod_count,create_id,order_sum,prod_id,courier_select FROM pre_order WHERE id = '$id' ";
	$query_select = mysqli_query($con, $sql);
	$product_cost = mysqli_fetch_array($query_select);
	$create_id =$product_cost['create_id'];
    $prodid = $product_cost['prod_id'];
    $courier_select = $product_cost['courier_select'];
	$product_cost = ((int)$product_cost['product_cost']/(int)$product_cost['prod_count'])*(int)$value;

    if((int)$product_cost['prod_count'] == 0){

			    $prodidsql = "SELECT sale_price FROM pr_products WHERE id = '$prodid'";
				$prodidquery_select = mysqli_query($con, $prodidsql);
				$prodid = mysqli_fetch_array($prodidquery_select);
			    $prod_id_sale_price = $prodid['sale_price'];

				$courier_selectdsql = "SELECT percent FROM manager WHERE id = '$courier_select' ";
				$courier_selectquery_select = mysqli_query($con, $courier_selectdsql);
				$courier_select = mysqli_fetch_array($query_select);
				$courier_select_percent = $courier_select['percent'];

				if((int)$courier_select['percent'] != null){
				 $product_cost = ($prod_id_sale_price -(($courier_select_percent * $prod_id_sale_price)/100))*$value;
				}else{
				 $product_cost =  $prod_id_sale_price * $value;
				}

	}


	$sqlupdate = "UPDATE pre_order SET prod_count = '$value' WHERE id='$id'";
	$query_update = mysqli_query($con, $sqlupdate);

	$sqlsum = "SELECT SUM(product_cost) FROM pre_order WHERE create_id = '$create_id' ";
	$query_selectsum = mysqli_query($con, $sqlsum);
	$product_costsum = mysqli_fetch_array($query_selectsum);
//	print_r($product_costsum);die;
	$product_costsum = $product_costsum[0];
    $sql_update_order_sumes = "UPDATE pre_order SET order_sum='$product_costsum' WHERE create_id='$create_id'";
	$query_update_order_sum = mysqli_query($con, $sql_update_order_sumes);


	echo "true";
}




?>