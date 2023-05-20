<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$name = mysqli_real_escape_string($con, $_POST['name']);

if($action == 'add'){
	$query_insert = mysqli_query($con, "INSERT INTO pr_groups (group_name) VALUES ('$name')");
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'edit'){
	$group_id = mysqli_real_escape_string($con, $_POST['group_id']);
	$query_update = mysqli_query($con, "UPDATE pr_groups SET group_name = '$name' WHERE id = '$group_id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_cient'){
	$group_id = mysqli_real_escape_string($con, $_POST['group_id']);
	$query_delete = mysqli_query($con, "DELETE FROM pr_groups WHERE id = $group_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}
?>