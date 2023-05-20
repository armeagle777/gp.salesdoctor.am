<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$warehouse_from = mysqli_real_escape_string($con, $_POST['warehouse_from']);
$warehouse_to = mysqli_real_escape_string($con, $_POST['warehouse_to']);
$product_group = mysqli_real_escape_string($con, $_POST['product_group']);
$product = mysqli_real_escape_string($con, $_POST['product_id']);
$product_count = mysqli_real_escape_string($con, $_POST['product_count']);

if($action == 'choose_group'){
	echo "<option value='0'>Ընտրել</option>";
	$choose_produts = mysqli_query($con, "SELECT product_group, name, id FROM pr_products WHERE product_group = '$product_group' ");
	while($product_array = mysqli_fetch_array($choose_produts)){
		echo "<option value='{$product_array['id']}'>{$product_array['name']}</option>";
	}
	
}

if($action == 'warehouse_from'){

	$warehouse_from_query = mysqli_query($con, "SELECT product_count, count(product_id) as row_count FROM pr_warehouse_products WHERE warehouse_product_group = '$product_group' AND product_id = '$product' AND warehouse_id = '$warehouse_from' ");
	

	while($warehouse_from_array = mysqli_fetch_array($warehouse_from_query)){
		
		if($warehouse_from_array['row_count'] > 0 ){
			echo $warehouse_from_array['product_count'];
		}else{
			echo '0'; 
		}
		
	}
	
}

if($action == 'warehouse_to'){

	$warehouse_to_query = mysqli_query($con, "SELECT product_count, count(product_id) as row_count FROM pr_warehouse_products WHERE warehouse_product_group = '$product_group' AND product_id = '$product' AND warehouse_id = '$warehouse_to' ");
	

	while($warehouse_to_array = mysqli_fetch_array($warehouse_to_query)){
		
		if($warehouse_to_array['row_count'] > 0 ){
			echo $warehouse_to_array['product_count'];
		}else{
			echo '0'; 
		}
		
	}
}

if($action == 'transfer'){	

	$warehouse_from_query = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count - $product_count) WHERE product_id = '$product' AND warehouse_id = '$warehouse_from' ");

	$check_to_warehouse = mysqli_query($con, "SELECT * FROM pr_warehouse_products WHERE product_id = '$product' AND warehouse_id = '$warehouse_to' ");
	
	$num_rows = mysqli_num_rows($check_to_warehouse);
	
	
	if($num_rows > 0) {
		$warehouse_to_query = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count + $product_count) WHERE product_id = '$product' AND warehouse_id = '$warehouse_to' ");
	}else{
		$warehouse_to_query = mysqli_query($con, "INSERT INTO pr_warehouse_products (warehouse_id, product_id, product_count, warehouse_product_group) VALUES ('$warehouse_to', '$product', '$product_count', '$product_group') ");
	}
			
}


?>
