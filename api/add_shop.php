<?php 
include 'db.php';

	$action = mysqli_real_escape_string($con, $_POST['action']);
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	$filter_n = mysqli_real_escape_string($con, $_POST['filter_n']);
	$qr_id = mysqli_real_escape_string($con, $_POST['qr_id']);
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$address = mysqli_real_escape_string($con, $_POST['address']);
	$district = mysqli_real_escape_string($con, $_POST['district']);
	$region = mysqli_real_escape_string($con, $_POST['region']);
	$network = mysqli_real_escape_string($con, $_POST['network']);
	$comment = mysqli_real_escape_string($con, $_POST['comment']);
	$stend_count = mysqli_real_escape_string($con, $_POST['stend_count']);
	$stend_summ = mysqli_real_escape_string($con, $_POST['stend_summ']);
	$law_name = mysqli_real_escape_string($con, $_POST['law_name']);
	$law_address = mysqli_real_escape_string($con, $_POST['law_address']);
	$hvhh = mysqli_real_escape_string($con, $_POST['hvhh']);
	$phone = mysqli_real_escape_string($con, $_POST['phone']);
	$active = mysqli_real_escape_string($con, $_POST['active']);
	$latitude = mysqli_real_escape_string($con, $_POST['latitude']);
	$longitude = mysqli_real_escape_string($con, $_POST['longitude']);
	$discount = mysqli_real_escape_string($con, $_POST['discount']);
	$limit_cash = mysqli_real_escape_string($con, $_POST['limit_cash']);
	$limit_cash_ha = mysqli_real_escape_string($con, $_POST['limit_cash_ha']);
	$limit_debt = mysqli_real_escape_string($con, $_POST['limit_debt']);
	$limit_debt_ha = mysqli_real_escape_string($con, $_POST['limit_debt_ha']);
	$limit_credit = mysqli_real_escape_string($con, $_POST['limit_credit']);
	$limit_credit_ha = mysqli_real_escape_string($con, $_POST['limit_credit_ha']);
	$static_manager = mysqli_real_escape_string($con, $_POST['static_manager']);
	$courier = mysqli_real_escape_string($con, $_POST['courier']);
	$owner_name = mysqli_real_escape_string($con, $_POST['owner_name']);
	$owner_tel = mysqli_real_escape_string($con, $_POST['owner_tel']);
	$hasDebt = mysqli_real_escape_string($con, $_POST['hasDebt']);
	
	
	$as_class = mysqli_real_escape_string($con, $_POST['as_class']);
	$property_1 = mysqli_real_escape_string($con, $_POST['property_1']);
	$property_2 = mysqli_real_escape_string($con, $_POST['property_2']);
	$marketing_payment = mysqli_real_escape_string($con, $_POST['marketing_payment']);

	if($hasDebt == 'on'){
	    $hasDebt ='1';
	}else{
	    $hasDebt='0';
	}

if($action == 'add'){
	
	// $query_check_qr = mysqli_query($con, "SELECT qr_id FROM shops WHERE qr_id = '$qr_id'  ");
	// $rows = mysqli_num_rows($query_check_qr);
	// if($rows != 0){
	// 	echo "Տվյալ QR արդեն առկա է:";
	// 	exit;
	// }	
	try{
	
		$active = 'on';
	
		$query_check_shop_id = mysqli_query($con, "SELECT shop_id FROM shops WHERE shop_id = '$shop_id' ");
		$rows = mysqli_num_rows($query_check_shop_id);
		if($rows != 0){
			echo "Տվյալ խանութ արդեն առկա է:";
			exit;
		}	
	
		$sql="INSERT INTO shops 
		(courier_id,marketing_payment,as_classification_id, property_1, property_2, shop_id, filter_n,  name, address, district, region, network, comment, stend_count, stend_summ, law_name, law_address, hvhh, phone, active, shop_latitude, shop_longitude, discount, limit_cash, limit_cash_ha, limit_debt, limit_debt_ha, limit_credit, limit_credit_ha, static_manager, owner_name, owner_tel, hasDebt) 
		VALUES ('$courier', '$marketing_payment', '$as_class', '$property_1', '$property_2','$shop_id', '$filter_n',  '$name', '$address', '$district', '$region', '$network', '$comment', '$stend_count', '$stend_summ', '$law_name', '$law_address', '$hvhh', '$phone', '$active' , '$latitude' , '$longitude', '$discount', '$limit_cash', '$limit_cash_ha', '$limit_debt', '$limit_debt_ha', '$limit_credit', '$limit_credit_ha', '$static_manager',  '$owner_name', '$owner_tel', '$hasDebt' )";
		// echo $sql;die;
		$query_insert = mysqli_query($con, $sql);		
		$query_manager_to_shop = mysqli_query($con, "INSERT INTO manager_to_shop (shop_id, manager_id) VALUES ('$shop_id', '$static_manager')");
	
	
	
		if($query_insert) {
			echo "Հաջողությամբ ավելացված է";
		}else{
			echo "Ստուգեք տվյալները";
		}
	}catch(Exception $e){
		echo $e -> getMessage();
	}
}

if($action == 'edit'){
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	
	$sql = "UPDATE shops 
	        SET 
	            courier_id='$courier',
	            marketing_payment='$marketing_payment',
            	property_2='$property_2', 
            	property_1='$property_1', 
            	as_classification_id='$as_class',  
            	hasDebt='$hasDebt', 
            	shop_id = '$shop_id', 
            	filter_n = '$filter_n', 
            	name = '$name', 
            	address = '$address', 
            	district = '$district', 
            	region = '$region', 
            	network = '$network', 
            	comment = '$comment', 
            	stend_count = '$stend_count', 
            	stend_summ = '$stend_summ', 
            	law_name = '$law_name', 
            	law_address = '$law_address', 
            	hvhh = '$hvhh', 
            	phone = '$phone', 
            	active = '$active', 
            	shop_latitude = '$latitude', 
            	shop_longitude = '$longitude', 
            	discount = '$discount', 
            	limit_cash = '$limit_cash', 
            	limit_cash_ha = '$limit_cash_ha', 
            	limit_debt = '$limit_debt', 
            	limit_debt_ha = '$limit_debt_ha', 
            	limit_credit = '$limit_credit', 
            	limit_credit_ha = '$limit_credit_ha', 
            	static_manager = '$static_manager', 
            	owner_name = '$owner_name', 
            	owner_tel = '$owner_tel' 
        	WHERE shop_id = '$shop_id' ";

	$query_update = mysqli_query($con, $sql); 

	
	$query_manager_to_shop = mysqli_query($con, "INSERT INTO manager_to_shop (shop_id, manager_id) VALUES ('$shop_id', '$static_manager')");


	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_cient'){
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	$query_delete = mysqli_query($con, "DELETE FROM shops WHERE shop_id = $shop_id");
	$query_dele_from_manager = mysqli_query($con, "DELETE FROM manager_to_shop WHERE shop_id = $shop_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}
?>