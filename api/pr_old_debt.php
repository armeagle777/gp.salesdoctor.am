<?php 
	include 'db.php';
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	$product_group = mysqli_real_escape_string($con, $_POST['product_group']);
	$product_payment = mysqli_real_escape_string($con, $_POST['product_payment']);
	$summ = mysqli_real_escape_string($con, $_POST['summ']);
	$comment = mysqli_real_escape_string($con, $_POST['comment']);

	$date = date_create();
	$document_id = date_timestamp_get($date);


	if(isset($_POST['action']) AND $_POST['action'] == 'add_old_debt' ){
		
		$query_insert_debt = mysqli_query($con, "INSERT INTO pr_orders_document (document_id, shop_id, product_group, pay_type, order_last_summ, old_debt, order_delivered, order_comment) VALUES ('$document_id', '$shop_id', '$product_group', '$product_payment', '$summ', '1', '1', '$comment' ) ");
		
	}
	
	if(isset($_POST['action']) AND $_POST['action'] == 'delete_debt' ){
		
		$deleting_document_id = mysqli_real_escape_string($con, $_POST['deleting_document_id']);
		
		$query_insert_debt = mysqli_query($con, "DELETE FROM pr_orders_document WHERE id = '$deleting_document_id' ");
		
	}	
	if(isset($_POST['action']) AND $_POST['action'] == 'edit_debt' ){
		
		$editing_document_id = mysqli_real_escape_string($con, $_POST['editing_document_id']);
		$edit_summ = mysqli_real_escape_string($con, $_POST['edit_summ']);
		$comment = mysqli_real_escape_string($con, $_POST['comment']);
		
		
		$query_update_debt = mysqli_query($con, "UPDATE pr_orders_document SET order_last_summ = '$edit_summ', order_comment = '$comment'  WHERE id = '$editing_document_id' ");
		
	}
	
	
	
	
	
	

?>