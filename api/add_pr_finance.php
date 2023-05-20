<?php 
include 'db.php';

$document_date = date("Y-m-d"); 

$input_summ = mysqli_real_escape_string($con, $_POST['input_summ']);
$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
$documents = json_decode($_POST['documents'], true);
$user_id = mysqli_real_escape_string($con, $_POST['user_id']);

$transaction_date = date_create();
$payed_document_id = date_timestamp_get($transaction_date);

$orders_count = mysqli_real_escape_string($con, $_POST['orders_count']);

$network = mysqli_real_escape_string($con, $_POST['network']);
$payer_payment_type = mysqli_real_escape_string($con, $_POST['payer_payment_type']);
$payer_payment_bank = mysqli_real_escape_string($con, $_POST['payer_payment_bank']);

if(isset($_POST['type']) AND $_POST['type'] == 'add_finance'){
	
	if($orders_count == '0'){
		
		$product_payment = mysqli_real_escape_string($con, $_POST['product_payment']);
		$group_id = mysqli_real_escape_string($con, $_POST['group_id']);
		
		$pr_orders_finance = mysqli_query($con, "INSERT INTO pr_orders_finance (document_date, order_summ, shop_id, user_id, transaction_id, payer_payment_type, payer_payment_bank, pay_type, payed_product_group) VALUES ('$document_date', '$input_summ', '$shop_id', '$user_id', '$payed_document_id', '$payer_payment_type', '$payer_payment_bank', '$product_payment', '$group_id') ");
		exit;
	}
	
	foreach ($documents as $key => $value) {
		
		$query_pay_type = mysqli_query($con, "SELECT * FROM pr_orders_document WHERE document_id = '$key'");
		$pay_type_array = mysqli_fetch_array($query_pay_type);
		$pay_type = $pay_type_array['pay_type'];
		$shop_id = $pay_type_array['shop_id'];
		$product_group = $pay_type_array['product_group'];
		
		$order_pay_status = '1';

		if($input_summ < $pay_type_array['order_last_summ']){
			$value = $input_summ;
			$order_pay_status = '2';
		}		
		
		$query_insert_summ = mysqli_query($con, "UPDATE pr_orders_document SET order_pay_status = '$order_pay_status' WHERE shop_id='$shop_id' AND document_id = '$key' ");
		
		$pr_orders_finance = mysqli_query($con, "INSERT INTO pr_orders_finance (document_date, order_summ, shop_id, pay_type, user_id, payed_document_id, transaction_id, payer_payment_type, payer_payment_bank, payed_product_group) VALUES ('$document_date', '$value', '$shop_id', '$pay_type', '$user_id', '$key', '$payed_document_id', '$payer_payment_type', '$payer_payment_bank', '$product_group') ");
		
		echo "INSERT INTO pr_orders_finance (document_date, order_summ, shop_id, pay_type, user_id, payed_document_id, transaction_id, payer_payment_type, payer_payment_bank) VALUES ('$document_date', '$value', '$shop_id', '$pay_type', '$user_id', '$key', '$payed_document_id', '$payer_payment_type', '$payer_payment_bank') ";
		
	}	

}


if(isset($_POST['action']) AND $_POST['action'] == 'delete_transaction'){
	$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
	
	$query_delete = mysqli_query($con, "DELETE FROM pr_orders_finance WHERE id = '$document_id'");
	$query_update_transaction = mysqli_query($con, "UPDATE pr_orders_document SET order_pay_status='0' WHERE document_id = '$document_id' ");
	
}

if(isset($_POST['action']) AND $_POST['action'] == 'order_full_payed'){
	
	$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
	$status = mysqli_real_escape_string($con, $_POST['status']);
	$order_summ = mysqli_real_escape_string($con, $_POST['order_summ']);
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	
	$update_query = mysqli_query($con, "UPDATE pr_orders_finance SET payed_document_status = '$status' WHERE payed_document_id = '$document_id'");
	$update_query_transaction = mysqli_query($con, "UPDATE pr_orders_document SET order_pay_status = '$status' WHERE document_id = '$document_id' ");
	
	if($status == '3'){
		$update_shop_query = mysqli_query($con, "UPDATE shops SET balance = (balance - $order_summ) WHERE shop_id = $shop_id ");
	}
	
	if($status == '1'){
		$update_shop_query = mysqli_query($con, "UPDATE shops SET balance = (balance + $order_summ) WHERE shop_id = $shop_id ");
	}
	
	
}

if(isset($_POST['action']) AND $_POST['action'] == 'order_full_payed_from_transaction'){
	
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
	$status = mysqli_real_escape_string($con, $_POST['status']);

	
	$update_query = mysqli_query($con, "UPDATE pr_orders_finance SET payed_document_status = '$status' WHERE transaction_id = '$transaction_id'");
	
	$query_select_ducments = mysqli_query($con, "SELECT payed_document_id FROM pr_orders_finance WHERE transaction_id = '$transaction_id'");
	while($array_documents = mysqli_fetch_array($query_select_ducments)){
		$document_id = $array_documents['payed_document_id'];
		$update_query_transaction = mysqli_query($con, "UPDATE pr_orders_document SET order_pay_status = '$status' WHERE document_id = '$document_id' ");
	}
	
	if($status == '3'){
		$update_shop_query = mysqli_query($con, "UPDATE shops SET balance = (balance - $order_summ) WHERE shop_id = $shop_id ");
	}
	
	if($status == '1'){
		$update_shop_query = mysqli_query($con, "UPDATE shops SET balance = (balance + $order_summ) WHERE shop_id = $shop_id ");
	}
	
	
}

if(isset($_POST['action']) AND $_POST['action'] == 'order_comment'){
	
	$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
	$order_comment = mysqli_real_escape_string($con, $_POST['order_comment']);
	
	$update_query = mysqli_query($con, "UPDATE pr_orders_document SET order_comment = '$order_comment' WHERE document_id = '$document_id'");
	
}

if(isset($_POST['action']) AND $_POST['action'] == 'change_payment_date'){
	
	 $pr_orders_finance_id = mysqli_real_escape_string($con, $_POST['pr_orders_finance_id']);
	 $editable_date = mysqli_real_escape_string($con, $_POST['editable_date']);
		
	$query_update = mysqli_query($con, "UPDATE pr_orders_finance SET document_date = '$editable_date' WHERE transaction_id = '$pr_orders_finance_id'");
	
}

if(isset($_POST['action']) AND $_POST['action'] == 'change_payment_document_id'){
		
	 $data_id = mysqli_real_escape_string($con, $_POST['data_id']);
	 $data_val = mysqli_real_escape_string($con, $_POST['data_val']);
		
	$query_update = mysqli_query($con, "UPDATE pr_orders_finance SET payed_document_id = '$data_val' WHERE id = '$data_id' ");
	echo "UPDATE pr_orders_finance SET payed_document_id = '$data_val' WHERE id = '$data_id' ";
	
}






?>