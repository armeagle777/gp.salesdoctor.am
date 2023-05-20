<?php 

include 'db.php';

$action = mysqli_real_escape_string($con, $_POST['action']);
$property_id = mysqli_real_escape_string($con, $_POST['property_id']);

if($action == 'delete_property_1'){
	
	$query_delete = mysqli_query($con, "DELETE FROM pr_property1 WHERE id = '$property_id' ");

}

if($action == 'delete_property_2'){
	
	$query_delete = mysqli_query($con, "DELETE FROM pr_property2 WHERE id = '$property_id' ");

}
if($action == 'delete_qr'){
	
	$query_delete = mysqli_query($con, "DELETE FROM pr_qr WHERE id = '$property_id' ");

}

?>