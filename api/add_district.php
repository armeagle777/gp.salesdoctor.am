<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);


if($action == 'add'){
	$region_id = mysqli_real_escape_string($con, $_POST['region_select']);
	$district_name = mysqli_real_escape_string($con, $_POST['name']);
	
	$query_add_region = mysqli_query($con, "INSERT INTO district (district_name, region_id) VALUES ('$district_name', '$region_id') ");
	
	if($query_add_region) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
	
}

if($action == 'edit'){
	$region_id = mysqli_real_escape_string($con, $_POST['region_select']);
	$district_name = mysqli_real_escape_string($con, $_POST['name']);

	$district_id = mysqli_real_escape_string($con, $_POST['district_id']);
	$query_add_region = mysqli_query($con, "UPDATE district SET district_name = '$district_name',region_id = '$region_id' WHERE id='$district_id' ");
	
	if($query_add_region) {
		echo "Հաջողությամբ թարմացվել է";
	}else{
		echo "Ստուգեք տվյալները";
	}
	
}



?>