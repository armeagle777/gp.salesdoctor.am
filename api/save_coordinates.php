<?php
session_start();
include 'db.php';

	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	$shop_lat = mysqli_real_escape_string($con, $_POST['shop_lat']);
	$shop_long = mysqli_real_escape_string($con, $_POST['shop_long']);
	
	if($shop_id != ''){
		$save_coordinates = mysqli_query($con, "UPDATE shops SET shop_latitude = '$shop_lat', shop_longitude = '$shop_long' WHERE shop_id = '$shop_id' ");
	}






?>