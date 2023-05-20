<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$network_comment_info = mysqli_real_escape_string($con, $_POST['network_comment_info']);
$network_limit = mysqli_real_escape_string($con, $_POST['network_limit']);

if($action == 'add'){
	$query_insert = mysqli_query($con, "INSERT INTO network (network_name, network_comment_info, network_limit) VALUES ('$name', '$network_comment_info', '$network_limit')");
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'edit'){
	$network_id = mysqli_real_escape_string($con, $_POST['network_id']);
	$query_update = mysqli_query($con, "UPDATE network SET network_name = '$name', network_comment_info = '$network_comment_info' , network_limit = '$network_limit' WHERE id = '$network_id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_cient'){
	$network_id = mysqli_real_escape_string($con, $_POST['network_id']);
	$query_delete = mysqli_query($con, "DELETE FROM network WHERE id = $network_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}
?>