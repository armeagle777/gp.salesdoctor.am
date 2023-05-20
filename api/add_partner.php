<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$login = mysqli_real_escape_string($con, $_POST['login']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$hvhh = mysqli_real_escape_string($con, $_POST['hvhh']);
$aah = mysqli_real_escape_string($con, $_POST['aah']);
$telephone = mysqli_real_escape_string($con, $_POST['telephone']); 
$email = mysqli_real_escape_string($con, $_POST['email']);
$summ = mysqli_real_escape_string($con, $_POST['summ']);
$discount = mysqli_real_escape_string($con, $_POST['discount']);
$comment = mysqli_real_escape_string($con, $_POST['comment']);

$password = mysqli_real_escape_string($con, $_POST['password']);


if($action == 'add'){
	$password_hashed = hash('sha256', $password);
	
	$query_insert = mysqli_query($con, "INSERT INTO client (login, password, law_name, law_address, hvhh, vat, price, discount, comment, phone, mail) VALUES ('$login', '$password_hashed', '$name', '$address', '$hvhh',  '$aah', '$summ', '$discount', '$comment', '$telephone', '$email' )");
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'edit'){
	$partner_id = mysqli_real_escape_string($con, $_POST['partner_id']);

	if($password !=''){
		$password_hashed = hash('sha256', $password);
	}else{
		$query_for_pas = mysqli_query($con, "SELECT password FROM client WHERE id = '$partner_id' ");
		$array_for_pas = mysqli_fetch_array($query_for_pas);
		$password_hashed = $array_for_pas['password'];
	}
	
	$query_update = mysqli_query($con, "UPDATE client SET login = '$login',  password = '$password_hashed', law_name = '$name', law_address = '$address', hvhh = '$hvhh', vat = '$aah', price = '$summ', discount = '$discount', comment = '$comment',  phone = '$telephone', mail = '$email' WHERE id = '$partner_id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_cient'){
	$partner_id = mysqli_real_escape_string($con, $_POST['partner_id']);
	$query_delete = mysqli_query($con, "DELETE FROM client WHERE id = $partner_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}
?>