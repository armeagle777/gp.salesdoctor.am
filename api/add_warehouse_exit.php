<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$barcode = mysqli_real_escape_string($con, $_POST['barcode']);
$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
$courier_id = mysqli_real_escape_string($con, $_POST['courier']);
$warehouse_id = mysqli_real_escape_string($con, $_POST['warehouse']);


if($action == 'add'){
	
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);

	$query_check_returned = mysqli_fetch_array(mysqli_query($con, "SELECT order_type FROM pr_orders_document WHERE document_id = '$transaction_id' "));

	//update count from input 
	if(mysqli_real_escape_string($con, $_POST['second_action']) == 'warehouse_edit'){
		$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);

		$product_count = mysqli_real_escape_string($con, $_POST['product_count']);
		$product_id = mysqli_real_escape_string($con, $_POST['product_id']);
		$total = mysqli_real_escape_string($con, $_POST['total']);
		
		$query_insert_document = mysqli_query($con, "UPDATE pr_orders_document SET courier_id='$courier_id', warehouse_id='$warehouse_id' WHERE document_id = '$transaction_id'" );

		//check warehouse count
		$query_check_warehouse = mysqli_query($con, "SELECT product_count FROM pr_warehouse_products WHERE product_id = '$product_id' AND warehouse_id = '$warehouse_id' ");
		
		$product_count_warehouse_array = mysqli_fetch_array($query_check_warehouse);
		
		$query_check_order_count_with_edit = mysqli_fetch_array(mysqli_query($con, "SELECT product_count FROM pr_orders WHERE product_id = '$product_id' AND document_id = '$transaction_id' "));

		
		if($query_check_returned != '1'){
				$product_count_from_input = mysqli_real_escape_string($con, $_POST['product_count']);

				if($product_count_from_input > $query_check_order_count_with_edit['product_count']) {
					echo "avel";
					exit;
				}
		}
		
		
		if($query_check_returned == '1'){
			if($product_count_warehouse_array['product_count'] < $product_count) {
				echo "pakas";
				exit;
			}	
		}
		
		
		$query_insert = mysqli_query($con, "UPDATE pr_orders SET product_count_warehouse = '$product_count' WHERE document_id = '$transaction_id' AND product_id = '$product_id' ");
		
		$query_insert_document = mysqli_query($con, "UPDATE pr_orders_document SET order_last_summ='$total' WHERE document_id = '$transaction_id'" );
		
		
	}else{
		
		$total = mysqli_real_escape_string($con, $_POST['total']);

		//update count from barcode reader		
		$query_insert_document = mysqli_query($con, "UPDATE pr_orders_document SET courier_id='$courier_id', warehouse_id='$warehouse_id' WHERE document_id = '$document_id'" );
		

			
		$product_query = mysqli_query($con, "SELECT * FROM pr_barcodes WHERE barcode = '$barcode' ");
		
		if(mysqli_num_rows($product_query) !=0) {
			while($product_array = mysqli_fetch_array($product_query)){
				$product_id = $product_array['product_id'];
				$product_count = $product_array['product_count'];
			}
			
			//check warehouse count
			$query_check_warehouse = mysqli_query($con, "SELECT product_count FROM pr_warehouse_products WHERE product_id = '$product_id' AND warehouse_id = '$warehouse_id' ");
			$query_check_order_count = mysqli_query($con, "SELECT product_count_warehouse, product_count FROM pr_orders WHERE product_id = '$product_id' AND document_id = '$document_id' ");
			
			$product_count_warehouse_array = mysqli_fetch_array($query_check_warehouse);
			$product_count_order_array = mysqli_fetch_array($query_check_order_count);
			
			if($query_check_returned == '1'){
			
				if($product_count_warehouse_array['product_count'] < ($product_count_order_array['product_count_warehouse'] + $product_count)) {
					echo "pakas";
					exit;
				}
			}

			if($query_check_returned == '1'){
				if(($product_count_order_array['product_count_warehouse'] + $product_count) > $product_count_order_array['product_count']){
					echo "avel";
					exit;
				}
			}
			
			if($query_check_returned != '1'){

				if(($product_count_order_array['product_count_warehouse'] + $product_count) > $product_count_order_array['product_count']) {
					echo "avel";
					exit;
				}
			}	
			
				$changed_for_sort_date = date_create();
				$changed_for_sort = date_timestamp_get($changed_for_sort_date);

							
			$query_insert = mysqli_query($con, "UPDATE pr_orders SET product_count_warehouse = (product_count_warehouse + $product_count), changed_for_sort = '$changed_for_sort' WHERE document_id = '$document_id' AND product_id = '$product_id' ");		
			
			$select_total_for_document_summ = mysqli_query($con, "SELECT sum(product_count_warehouse * product_last_cost) AS order_total FROM pr_orders WHERE document_id = '$document_id' ");
			$array_for_total = mysqli_fetch_array($select_total_for_document_summ);
			
			$order_total = $array_for_total['order_total'];
			
			$query_insert_document = mysqli_query($con, "UPDATE pr_orders_document SET order_last_summ='$order_total' WHERE document_id = '$document_id'" );
			
			if($query_insert) {
				echo 'yes';
			}
			
			

		}
		
	}
		
}
/* 
if($action == 'edit'){
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
	$product_update_count = mysqli_real_escape_string($con, $_POST['product_update_count']);
	$query_update = mysqli_query($con, "UPDATE pr_warehouse_trans SET product_count = '$product_update_count' WHERE id = '$transaction_id' ");
} */

if($action == 'edit_count'){
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
	$product_count = mysqli_real_escape_string($con, $_POST['product_count']);
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);
	$total = mysqli_real_escape_string($con, $_POST['total']);

	$query_update = mysqli_query($con, "UPDATE pr_orders SET product_count = '$product_count' WHERE document_id = '$transaction_id' AND product_id='$product_id' ");

	$query_update_document = mysqli_query($con, "UPDATE pr_orders_document SET order_summ = '$total' WHERE document_id = '$transaction_id'");
}

if($action == 'edit_discount'){
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
	$discount = mysqli_real_escape_string($con, $_POST['discount']);
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);
	$product_current_price = mysqli_real_escape_string($con, $_POST['product_current']);
	
	$total = mysqli_real_escape_string($con, $_POST['total']);

	$query_update = mysqli_query($con, "UPDATE pr_orders SET product_last_cost = '$product_current_price', product_procent = '$discount' WHERE document_id = '$transaction_id' AND product_id='$product_id' ");

	$query_update_document = mysqli_query($con, "UPDATE pr_orders_document SET order_last_summ = '$total' WHERE document_id = '$transaction_id'");
}

if($action == 'change_payment_type'){
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
	$payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);

	$query_update = mysqli_query($con, "UPDATE pr_orders SET pay_type = '$payment_type' WHERE document_id = '$transaction_id' ");
	$query_update_document = mysqli_query($con, "UPDATE pr_orders_document SET pay_type = '$payment_type' WHERE document_id = '$transaction_id' ");
	
}

if($action == 'edit_document_dates'){
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
	$depb_date = mysqli_real_escape_string($con, $_POST['depb_date']);
	$order_start_date = mysqli_real_escape_string($con, $_POST['order_start_date']);

	$query_update = mysqli_query($con, "UPDATE pr_orders SET debt_date = '$depb_date', document_date = '$order_start_date' WHERE document_id = '$transaction_id' ");
	
	echo "UPDATE pr_orders SET debt_date = '$depb_date', document_date = '$order_start_date' WHERE document_id = '$transaction_id'";
	
	$query_update_document =  mysqli_query($con, "UPDATE pr_orders_document SET debt_date = '$depb_date', document_date = '$order_start_date' WHERE document_id = '$transaction_id' ");
	
}



?>