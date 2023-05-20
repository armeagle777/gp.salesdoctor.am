<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$barcode = mysqli_real_escape_string($con, $_POST['barcode']);
$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
$product_select = mysqli_real_escape_string($con, $_POST['product_select']);
$action_select = mysqli_real_escape_string($con, $_POST['action_select']);

$warehouse_id = mysqli_real_escape_string($con, $_POST['warehouse']);
$supplier_id = mysqli_real_escape_string($con, $_POST['supplier']);

$document_date = date("Y-m-d"); 

if($action == 'add'){

	$product_query = mysqli_query($con, "SELECT * FROM pr_barcodes WHERE barcode = '$barcode' ");
	if(mysqli_num_rows($product_query) !='0' or $action_select == 'with_select') {
		echo "mtav";
		if($action_select == 'with_select') {
			$product_id = $product_select;
			$product_count = '0';
		}else{
			while($product_array = mysqli_fetch_array($product_query)){
			
				$product_id = $product_array['product_id'];
				$product_count = $product_array['product_count'];

			}
		}
		
		$product_last_price = mysqli_query($con, "SELECT last_price, product_group FROM pr_products WHERE id = '$product_id' ");
		$product_last_price_array = mysqli_fetch_array($product_last_price);
		
		$product_buying_last_price = $product_last_price_array['last_price'];
		$product_buying_group = $product_last_price_array['product_group'];
		
		$query_check_product = mysqli_query($con, "SELECT * FROM pr_warehouse_trans WHERE document_id = '$document_id' AND product_id = '$product_id' ");
		$product_array_trans = mysqli_fetch_array($query_check_product);

		$num_rows = mysqli_num_rows($query_check_product);

		//echo $num_rows;

		if($num_rows == 0){
			$insert_product = mysqli_query($con, "INSERT INTO pr_warehouse_trans (warehouse_id, supplier_id, transaction_type, product_id, product_count, document_id, document_date, buy_price) VALUES ('$warehouse_id', '$supplier_id', '2', '$product_id', '$product_count', '$document_id', '$document_date', '$product_buying_last_price' ) ");
			
	
			
		}else{
			$product_count_avalible = $product_array_trans['product_count'];
			$product_count_avalible = $product_count_avalible + $product_count;
			$insert_product = mysqli_query($con, "UPDATE pr_warehouse_trans SET product_count = '$product_count_avalible' WHERE document_id = '$document_id' AND product_id = '$product_id' ");
			
			
		}

		//echo $insert_product_text;
		
		$current_docoument_query = mysqli_query($con, "SELECT * FROM pr_warehouse_trans WHERE document_id = '$document_id'");
		while($document_array = mysqli_fetch_array($current_docoument_query)){
			$transaction_id = $document_array['id'];
			$product_doc_id = $document_array['product_id'];
			$product_count = $document_array['product_count'];
			$buying_price = $document_array['buy_price'];
			$product_name_query = mysqli_query($con, "SELECT name, last_price FROM pr_products WHERE id = '$product_doc_id' ");
			while($product_name_array = mysqli_fetch_array($product_name_query)){
				$product_name = $product_name_array['name'];
				$last_price = $product_name_array['last_price'];
			}
			
			if($buying_price == ''){
				$buying_price = $last_price;
			}
			
			echo "<tr class='prod_$product_doc_id'>";
				echo "<td>$product_name</td>
					  <td><input type='text' value='$product_count' class='form-control col-sm-6 $transaction_id prod_count' id='$transaction_id'></td>
					  <td><input type='text' value='$buying_price' class='form-control col-sm-6 prod_buy_price' id='$transaction_id'></td>
					  <td>
						<button class='btn btn-danger btn-sm rounded-0 transaction_delete' id='$product_doc_id'><i class='fa fa-trash'></i></button>
						
					  </td>
			
						";
			echo "</tr>";
		}
		
				

		
	}

}

if($action == 'edit_count'){
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
	$product_update_count = mysqli_real_escape_string($con, $_POST['product_update_count']);
	$query_update = mysqli_query($con, "UPDATE pr_warehouse_trans SET product_count = '$product_update_count' WHERE id = '$transaction_id' ");
}

if($action == 'edit_buy_price'){
	$transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
	$product_update_price = mysqli_real_escape_string($con, $_POST['product_price']);
	$query_update = mysqli_query($con, "UPDATE pr_warehouse_trans SET buy_price = '$product_update_price' WHERE id = '$transaction_id' ");
}

if($action == 'select_product'){
	
	
	if(isset($_POST['product_group_select'])){
		
		$product_group_select = mysqli_real_escape_string($con, $_POST['product_group_select']);
		$query_products = mysqli_query($con, "SELECT * FROM pr_products WHERE product_group = '$product_group_select' ORDER BY id2 ");

		$data = "<option value='0'>Ընտրել</option>";
		while($products_array = mysqli_fetch_array($query_products)){
			$data .= "<option value='{$products_array['id']}'>{$products_array['name']}</option>";
		}
		
		echo $data;

	}
	
}

if($action == 'delete'){
	$product_for_delete = mysqli_real_escape_string($con, $_POST['product_for_delete']);
	
	mysqli_query($con, "DELETE FROM pr_warehouse_trans WHERE document_id = '$document_id' AND product_id = '$product_for_delete' ");
	
}

if($action == 'next_step') {
	$query_document = mysqli_query($con, "SELECT * FROM pr_warehouse_trans WHERE document_id = '$document_id'");
	while($document_array_trans = mysqli_fetch_array($query_document)){
		
		$warehouse_id = $document_array_trans['warehouse_id'];
		$product_id = $document_array_trans['product_id'];
		$product_count = $document_array_trans['product_count'];
		
		$product_last_price = mysqli_query($con, "SELECT product_group FROM pr_products WHERE id = '$product_id' ");
		$product_last_price_array = mysqli_fetch_array($product_last_price);
		
		$product_buying_group = $product_last_price_array['product_group'];
		
		$check_in_warehouse = mysqli_query($con, "SELECT * FROM pr_warehouse_products WHERE warehouse_id = '$warehouse_id' AND product_id = '$product_id' ");
			
		$num_rows_warehouse = mysqli_num_rows($check_in_warehouse);
		
		if($num_rows_warehouse == 0){
				$insert_warehouse = mysqli_query($con, "INSERT INTO pr_warehouse_products(warehouse_id, product_id, product_count, warehouse_product_group) VALUES ('$warehouse_id', '$product_id', '$product_count', '$product_buying_group' )");
				
		}else{
				$update_warehouse = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count + $product_count) WHERE warehouse_id = '$warehouse_id' AND product_id = '$product_id' ");
		}
		
	}
	$total = 0;
	$query_summ = mysqli_query($con, "SELECT product_count, buy_price FROM pr_warehouse_trans WHERE document_id = '$document_id'");
	while($array_summ = mysqli_fetch_array($query_summ)){
		$total = $total + ($array_summ['product_count'] * $array_summ['buy_price']);
	}
	
	echo $total;
	
}

if($action == 'back_step') {
	$delete_query = mysqli_query($con, "DELETE FROM pr_warehouse_trans WHERE document_id = '$document_id'");
}


if($action == 'edit_added_count'){
	$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
	$product_count_new = mysqli_real_escape_string($con, $_POST['product_count_new']);
	$oldcount = mysqli_real_escape_string($con, $_POST['oldcount']);
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);
	$warehouse_id = mysqli_real_escape_string($con, $_POST['warehouse_id']);

	$query_update = mysqli_query($con, "UPDATE pr_warehouse_trans SET product_count = '$product_count_new' WHERE document_id='$document_id' AND product_id='$product_id'");
	
	$calc_changes = $product_count_new - $oldcount;

	if($calc_changes > 0) {
		$query_update_warehouse = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count + $calc_changes) WHERE warehouse_id='$warehouse_id' AND product_id = '$product_id' ");
	}
	
	if($calc_changes < 0){
		
		$calc_changes = $calc_changes * (-1);
		echo $calc_changes;
		
		echo "UPDATE pr_warehouse_products SET product_count = (product_count - $calc_changes) WHERE warehouse_id='$warehouse_id' AND product_id = '$product_id' ";
		$query_update_warehouse = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count - $calc_changes) WHERE warehouse_id='$warehouse_id' AND product_id = '$product_id' ");
	}
	
}

if($action == 'edit_added_price'){
	$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
	$product_price_new = mysqli_real_escape_string($con, $_POST['product_price_new']);
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);

	$query_update = mysqli_query($con, "UPDATE pr_warehouse_trans SET buy_price = '$product_price_new' WHERE document_id='$document_id' AND product_id='$product_id'");
}

if($action == 'delete_added_product'){
	$document_id = mysqli_real_escape_string($con, $_POST['document_id']);
	$oldcount = mysqli_real_escape_string($con, $_POST['oldcount']);
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);
	$warehouse_id = mysqli_real_escape_string($con, $_POST['warehouse_id']);
	
	$query_delete = mysqli_query($con, "DELETE FROM pr_warehouse_trans WHERE document_id='$document_id' AND product_id='$product_id'");
	
	$query_update_warehouse = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count - $oldcount) WHERE warehouse_id='$warehouse_id' AND product_id = '$product_id' ");

}


?>