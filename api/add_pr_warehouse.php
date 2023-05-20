<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$warehouse_man = mysqli_real_escape_string($con, $_POST['warehouse_man']);

if($action == 'add'){
	$query_insert = mysqli_query($con, "INSERT INTO pr_warehouse (warehouse_name, warehouse_man) VALUES ('$name', '$warehouse_man')");
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'edit'){
	$warehouse_id = mysqli_real_escape_string($con, $_POST['warehouse_id']);
	$query_update = mysqli_query($con, "UPDATE pr_warehouse SET warehouse_name = '$name', warehouse_man = '$warehouse_man' WHERE id = '$warehouse_id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_cient'){
	$warehouse_id = mysqli_real_escape_string($con, $_POST['warehouse_id']);
	$query_delete = mysqli_query($con, "DELETE FROM pr_warehouse WHERE id = $warehouse_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}
?>