<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$name = mysqli_real_escape_string($con, $_POST['name']);

if($action == 'add'){
	$query_insert = mysqli_query($con, "INSERT INTO pr_expense_directions (name) VALUES ('$name')");
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'edit'){
	$finance_type_id = mysqli_real_escape_string($con, $_POST['finance_type_id']);
	$query_update = mysqli_query($con, "UPDATE pr_expense_directions SET name = '$name' WHERE id = '$finance_type_id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_cient'){
	$finance_type_id = mysqli_real_escape_string($con, $_POST['finance_type_id']);
	$query_delete = mysqli_query($con, "UPDATE `pr_expense_directions` SET `active`=0 WHERE id = $finance_type_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}
?>