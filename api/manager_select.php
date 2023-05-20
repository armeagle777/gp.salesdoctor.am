<?php
include 'db.php';
if(isset($_POST['check_active']) ){

		
	$check_active = mysqli_real_escape_string($con, $_POST['check_active']);
	
	$check_manager_id = mysqli_real_escape_string($con, $_POST['check_manager_id']);
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	
	if($check_active == '1'){
		$query_2 = mysqli_query($con, "SELECT * FROM manager_to_shop WHERE shop_id = '$shop_id' AND manager_id = '$district_selected_id' ");
		if ($query_2->num_rows == 0){
					$query = mysqli_query($con, "INSERT INTO manager_to_shop (manager_id, shop_id) VALUES ('$check_manager_id','$shop_id') ");
		}
		
	}
	if($check_active == '0'){
		$query = mysqli_query($con, "DELETE FROM manager_to_shop WHERE manager_id = '$check_manager_id' AND shop_id = '$shop_id' ");
	}

}

if(isset($_POST['check_id_delete']) ){

		
	$check_id_delete = mysqli_real_escape_string($con, $_POST['check_id_delete']);
	
	
		$query = mysqli_query($con, "DELETE FROM manager_to_shop WHERE id = '$check_id_delete' ");

}


?>