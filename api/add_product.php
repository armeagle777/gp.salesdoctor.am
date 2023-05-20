<?php 
include 'db.php';

	$action = mysqli_real_escape_string($con, $_POST['action']);
	
	$product_id = mysqli_real_escape_string($con, $_POST['id']);
	$product_group = mysqli_real_escape_string($con, $_POST['group']);
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$sale_price = mysqli_real_escape_string($con, $_POST['sale_price']);
	$last_price = mysqli_real_escape_string($con, $_POST['last_price']);
	$middle_price = mysqli_real_escape_string($con, $_POST['middle_price']);
	$balance = mysqli_real_escape_string($con, $_POST['balance']);
	$code = mysqli_real_escape_string($con, $_POST['code']);
	$id2 = mysqli_real_escape_string($con, $_POST['id2']);
	$regular_n = mysqli_real_escape_string($con, $_POST['regular_n']);
	$active = mysqli_real_escape_string($con, $_POST['active']);

if($action == 'add'){
	
	$active = 'on';
	
	if($product_group !='0' AND $name !=''){
		
		$query_insert = mysqli_query($con, "INSERT INTO pr_products (product_group, name, sale_price, last_price, middle_price, balance, code, id2, regular_n, active) VALUES ('$product_group', '$name', '$sale_price', '$last_price', '$middle_price', '$balance', '$code', '$id2',  '$regular_n', '$active')");
		if($query_insert) {
			echo "Հաջողությամբ ավելացված է";
		}else{
			echo "Ստուգեք տվյալները";
		}
			
	}
	

}

if($action == 'edit'){
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);
		
	$query_update = mysqli_query($con, "UPDATE pr_products SET product_group = '$product_group', name = '$name', sale_price = '$sale_price', last_price = '$last_price', middle_price = '$middle_price', balance = '$balance', code = '$code', id2 = '$id2', regular_n = '$regular_n', active = '$active' WHERE id = '$product_id' ") or die(mysqli_error($con));
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_product'){
	
	
	
	$product_id = mysqli_real_escape_string($con, $_POST['product_id']);
	
	
	$query_check_product = mysqli_query($con, "SELECT Count(id) AS trans_count FROM pr_warehouse_trans WHERE product_id = '$product_id' ");
	$check_count = mysqli_fetch_array($query_check_product);
	
	
	if($check_count['trans_count'] == '0') {
		
		$query_delete = mysqli_query($con, "DELETE FROM pr_products WHERE id = $product_id");
		if($query_delete) {
			echo "Հաջողությամբ ջնջված է";
		}else{
			echo "Ստուգեք տվյալները";
		}
		
	}
	
	
	
}
?>