<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$delete_id = mysqli_real_escape_string($con, $_POST['delete_id']);


if($action == 'add'){
	$region_name = mysqli_real_escape_string($con, $_POST['name']);
	$query_add_region = mysqli_query($con, "INSERT INTO region (region_name) VALUES ('$region_name') ");
	
	if($query_add_region) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
	
}

if($action == 'edit'){
	$region_name = mysqli_real_escape_string($con, $_POST['name']);
	$region_id = mysqli_real_escape_string($con, $_POST['region_id']);
	$query_add_region = mysqli_query($con, "UPDATE region SET region_name= '$region_name' WHERE id='$region_id' ");
	
	if($query_add_region) {
		echo "Հաջողությամբ թարմացվել է";
	}else{
		echo "Ստուգեք տվյալները";
	}
	
}


if($action == 'region'){
	$query_delete = mysqli_query($con, "DELETE FROM region WHERE id = '$delete_id' ");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'district'){
	$query_delete = mysqli_query($con, "DELETE FROM district WHERE id = '$delete_id' ");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}



?>