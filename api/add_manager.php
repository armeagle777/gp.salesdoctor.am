<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$client_id = mysqli_real_escape_string($con, $_POST['client_select']);
$login = mysqli_real_escape_string($con, $_POST['login']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$audit = mysqli_real_escape_string($con, $_POST['audit']); 
$active = mysqli_real_escape_string($con, $_POST['active']); 
$discount = mysqli_real_escape_string($con, $_POST['discount']); 
$user_role = mysqli_real_escape_string($con, $_POST['user_role']); 
$has_order = mysqli_real_escape_string($con, $_POST['has_order']); 
$plan_visit = mysqli_real_escape_string($con, $_POST['plan_visit']); 
$plan_audit = mysqli_real_escape_string($con, $_POST['plan_audit']); 
$plan_task = mysqli_real_escape_string($con, $_POST['plan_task']); 
$plan_order_summ = mysqli_real_escape_string($con, $_POST['plan_order_summ']); 
$plan_shop_count = mysqli_real_escape_string($con, $_POST['plan_shop_count']); 
$plan_shop_summ = mysqli_real_escape_string($con, $_POST['plan_shop_summ']); 


$canRate = mysqli_real_escape_string($con, $_POST['canRate']); 
$hasMic = mysqli_real_escape_string($con, $_POST['hasMic']); 
$canRecord = mysqli_real_escape_string($con, $_POST['canRecord']); 

if($canRate == 'on'){
    $canRate = '1';
}
if($hasMic == 'on'){
    $hasMic = '1';
}
if($canRecord == 'on'){
    $canRecord = '1';
}

$plan_visit_money = mysqli_real_escape_string($con, $_POST['plan_visit_money']); 
$plan_audit_money = mysqli_real_escape_string($con, $_POST['plan_audit_money']); 
$plan_task_money = mysqli_real_escape_string($con, $_POST['plan_task_money']); 
$plan_order_summ_money = mysqli_real_escape_string($con, $_POST['plan_order_summ_money']); 
$plan_shop_count_money = mysqli_real_escape_string($con, $_POST['plan_shop_count_money']); 
$plan_shop_summ_money = mysqli_real_escape_string($con, $_POST['plan_shop_summ_money']); 


$plan_comment = mysqli_real_escape_string($con, $_POST['plan_comment']); 

$manager_comment = mysqli_real_escape_string($con, $_POST['manager_comment']); 
$passport_details = mysqli_real_escape_string($con, $_POST['passport_details']); 
$passport_address = mysqli_real_escape_string($con, $_POST['passport_address']); 
$real_address = mysqli_real_escape_string($con, $_POST['real_address']); 


$manager_origin_latitude = mysqli_real_escape_string($con, $_POST['manager_origin_latitude']); 
$manager_origin_longitude = mysqli_real_escape_string($con, $_POST['manager_origin_longitude']); 
$manager_destination_latitude = mysqli_real_escape_string($con, $_POST['manager_destination_latitude']);  
$manager_destination_longitude = mysqli_real_escape_string($con, $_POST['manager_destination_longitude']);  

$charge_cost = mysqli_real_escape_string($con, $_POST['charge_cost']);  
$charge_km = mysqli_real_escape_string($con, $_POST['charge_km']);  



if($has_order == 'on'){
	$has_order = '1';
}else{
	$has_order = '0';
}

$password_hashed = hash('sha256', $password);


if($action == 'add'){
	

	$query_check_login = mysqli_query($con, "SELECT login FROM manager WHERE login = '$login' ");
	$rows = mysqli_num_rows($query_check_login);
	if($rows != 0){
		echo "Տվյալ մուտքանունը արդեն առկա է:";
		exit;
	}	
	
	$active = 'on';
	
	$query_insert = mysqli_query($con, "INSERT INTO manager (client_id, login, password, email, phone, name, audit_active, active, discount, user_role, has_order, plan_visit, plan_audit, plan_task, plan_order_summ, plan_shop_count, plan_shop_summ, plan_visit_money, plan_audit_money, plan_task_money, plan_order_summ_money, plan_shop_count_money, plan_shop_summ_money, plan_comment, manager_comment, passport_details, passport_address, real_address, manager_origin_latitude, manager_origin_longitude, manager_destination_latitude, manager_destination_longitude, charge_cost, charge_km, canRecord, hasMic, canRate) 
	VALUES ('$client_id', '$login', '$password_hashed', '$email',  '$phone', '$name', '$audit', '$active', '$discount', '$user_role', '$has_order', '$plan_visit', '$plan_audit', '$plan_task', '$plan_order_summ', '$plan_shop_count', '$plan_shop_summ', '$plan_visit_money', '$plan_audit_money', '$plan_task_money', '$plan_order_summ_money', '$plan_shop_count_money', '$plan_shop_summ_money', '$plan_comment', '$manager_comment', '$passport_details', '$passport_address', '$real_address', '$manager_origin_latitude', '$manager_origin_longitude', '$manager_destination_latitude', '$manager_destination_longitude', '$charge_cost', '$charge_km','$canRecord', '$hasMic', $canRate )");
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'edit'){
	$manager_id = mysqli_real_escape_string($con, $_POST['manager_id']);
	
	if($password == ''){
		$query_for_pas = mysqli_query($con, "SELECT password FROM manager WHERE id = '$manager_id' ");
		$array_for_pas = mysqli_fetch_array($query_for_pas);
		$password_hashed = $array_for_pas['password'];
	}
	
	$query_update = mysqli_query($con, "UPDATE manager SET  canRecord='$canRecord', hasMic='$hasMic', canRate='$canRate', client_id = '$client_id', login = '$login', password = '$password_hashed', email = '$email', phone = '$phone', name = '$name', audit_active = '$audit', active = '$active' , discount = '$discount', user_role = '$user_role', has_order = '$has_order', plan_visit = '$plan_visit', plan_audit = '$plan_audit', plan_task = '$plan_task', plan_order_summ = '$plan_order_summ', plan_shop_count = '$plan_shop_count', plan_shop_summ = '$plan_shop_summ', plan_visit_money = '$plan_visit_money', plan_audit_money = '$plan_audit_money', plan_task_money = '$plan_task_money', plan_order_summ_money = '$plan_order_summ_money', plan_shop_count_money = '$plan_shop_count_money', plan_shop_summ_money = '$plan_shop_summ_money', plan_comment = '$plan_comment', manager_comment = '$manager_comment', passport_details = '$passport_details', passport_address = '$passport_address', real_address = '$real_address', manager_origin_latitude = '$manager_origin_latitude', manager_origin_longitude = '$manager_origin_longitude', manager_destination_latitude = '$manager_destination_latitude', manager_destination_longitude = '$manager_destination_longitude', charge_cost = '$charge_cost', charge_km = '$charge_km' WHERE id = '$manager_id' ") or die(mysqli_error($con));
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_cient'){
	$manager_id = mysqli_real_escape_string($con, $_POST['manager_id']);
	$query_delete = mysqli_query($con, "DELETE FROM manager WHERE id = $manager_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}


if($action == 'support_edit'){
	$support_val = mysqli_real_escape_string($con, $_POST['support_val']);
	$query_support = mysqli_query($con, "UPDATE manager SET active = '$support_val' WHERE id = '999' ");
	if($query_support) {
		echo "Հաջողությամբ փոփոխված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}


?>