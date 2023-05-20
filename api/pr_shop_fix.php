<?php 
session_start();

include 'db.php';

	$fix_shop_id = mysqli_real_escape_string($con, $_POST['fix_shop_id']);
	$fix_summ = mysqli_real_escape_string($con, $_POST['fix_summ']);
	$fixed_user_id = mysqli_real_escape_string($con, $_POST['fixed_user_id']);

if(isset($_POST['action']) and $_POST['action'] == 'add_fix'){
		
	$query_static_manager = mysqli_fetch_array(mysqli_query($con, "SELECT static_manager FROM shops WHERE shop_id = '$fix_shop_id' "));
	
	$static_manager = $query_static_manager['static_manager'];
	
	$query_insert = mysqli_query($con, "INSERT INTO shop_fix (fix_shop_id, fix_summ, fix_manager_id, fixed_user_id) VALUES ('$fix_shop_id', '$fix_summ', '$static_manager', '$fixed_user_id' )");
	
	//echo "INSERT INTO shop_fix (fix_shop_id, fix_summ, fix_manager_id) VALUES ('$fix_shop_id', '$fix_summ', '$static_manager')";

}

if(isset($_POST['action']) and $_POST['action'] == 'delete_fix'){
		
	$delete_fix = mysqli_real_escape_string($con, $_POST['delete_fix']);
	$query_insert = mysqli_query($con, "DELETE FROM shop_fix WHERE id = '$delete_fix' ");
	

}

?>