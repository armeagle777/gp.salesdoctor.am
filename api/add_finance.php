<?php

include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$finance = mysqli_real_escape_string($con, $_POST['finance']);
$client_id = mysqli_real_escape_string($con, $_POST['client_id']);

if($action == 'add_finance_client'){
	$client_id = mysqli_real_escape_string($con, $_POST['client_id']);
	$query_update = mysqli_query($con, "UPDATE client SET finance = '$finance' WHERE id = '$client_id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}


$action_get = mysqli_real_escape_string($con, $_GET['action']);

if($action_get == 'edit_finance_one'){
	
	$finance_id = mysqli_real_escape_string($con, $_GET['finance_id']);
	$comment = mysqli_real_escape_string($con, $_GET['comment']);
	$add_date = mysqli_real_escape_string($con, $_GET['add_date']);
	$finance = mysqli_real_escape_string($con, $_GET['finance']);
	
	$query_update = mysqli_query($con, "UPDATE finance SET comment = '$comment', add_date = '$add_date', summ = '$finance' WHERE id = '$finance_id' ");
	if($query_update) {
		echo "<script> window.location.href = '/finance.php';</script>";
	}else{
		echo "Ստուգեք տվյալները00";
	}
}

if($action_get == 'finance_delete'){
	
	$finance_id = mysqli_real_escape_string($con, $_GET['finance_id']);
	
	$query_update = mysqli_query($con, "DELETE FROM finance WHERE id='$finance_id ' ");
	if($query_update) {
		echo "<script> window.location.href = '/finance.php';</script>";
	}else{
		echo "Ստուգեք տվյալները00";
	}
}

if($action == 'add_finance_month_client'){
	$comment = mysqli_real_escape_string($con, $_POST['comment']);
	$add_date = mysqli_real_escape_string($con, $_POST['add_date']);
	$client_id = mysqli_real_escape_string($con, $_POST['client_id']);
	$query_test = "INSERT INTO finance (client_id, comment, add_date, summ) VALUES ('$client_id', '$comment', '$add_date', '$finance')";
	$query_update = mysqli_query($con, $query_test );
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
		echo $query_test;;
	}
}

?>