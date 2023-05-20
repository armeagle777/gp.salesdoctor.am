<?php
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
$status = mysqli_real_escape_string($con, $_POST['status']);

if($action == 'order_delivered'){
	$query_order_status = mysqli_query($con, "UPDATE pr_orders_document SET order_delivered = '$status' WHERE document_id = '$document_id'");
}

if($action == 'delete_document'){
	
	$delete_document_id = mysqli_real_escape_string($con, $_POST['delete_document_id']);

	$query_document = mysqli_query($con, "SELECT * FROM pr_orders_document WHERE document_id = '$delete_document_id' ");
	$document_array = mysqli_fetch_array($query_document);
	
	$datas_details = array();
	$datas_details[0] ;
	
	if($document_array['order_last_summ'] == '0' or $document_array['order_last_summ'] == ''){
		
		$query_delete = mysqli_query($con, "DELETE FROM pr_orders_document WHERE document_id = '$delete_document_id' ");
		$query_delete_orders = mysqli_query($con, "DELETE FROM pr_orders WHERE document_id = '$delete_document_id' ");
		
		$datas_details[0] = "";
		$datas_details[1] = '1';
	}else{
		$datas_details[0] = "Զրոյացրեք պատվերը:";
		$datas_details[1] = '2';
	}
	
	echo json_encode($datas_details);
	
}





?>