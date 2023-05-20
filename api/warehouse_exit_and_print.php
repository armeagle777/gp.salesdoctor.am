<?php include 'db.php'; ?>
<?php 
$document_id = mysqli_real_escape_string($con, $_GET['document_id']);

$document_details_query = mysqli_query($con, "SELECT *, shops.discount AS shop_discount, shops.name AS shop_name, manager.name AS manager_name FROM pr_orders_document LEFT JOIN shops on pr_orders_document.shop_id = shops.shop_id LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id LEFT JOIN manager ON pr_orders_document.manager_id = manager.id LEFT JOIN pr_courier ON pr_orders_document.courier_id = pr_courier.id LEFT JOIN district ON shops.district = district.id WHERE document_id = '$document_id'");

$document_details = mysqli_fetch_array($document_details_query);

//warehouse for exit from warehouse
$warehouse_id = $document_details['warehouse_id'];
$order_type = $document_details['order_type'];

if($document_details['order_status'] == '0'){
	
	$query_products_warehouse = mysqli_query($con, "SELECT * FROM pr_orders WHERE document_id = '$document_id' ");
	while($array_products = mysqli_fetch_array($query_products_warehouse)){
		
		$curr_product_count = $array_products['product_count_warehouse'];
		$curr_product_product_id = $array_products['product_id'];
		
		// retunr or exit product
		if($order_type == '2'){
			$warehouse_update = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count + $curr_product_count) WHERE product_id = '$curr_product_product_id' AND warehouse_id = '$warehouse_id' ");
		}else{
			$warehouse_update = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count - $curr_product_count) WHERE product_id = '$curr_product_product_id' AND warehouse_id = '$warehouse_id' ");
		}
		
		
		$warehouse_update_history = mysqli_query($con, "UPDATE pr_orders SET product_count_warehouse_history = '$curr_product_count' WHERE product_id = '$curr_product_product_id' AND document_id = '$document_id' ");
		
	}
	
	$query_update_order_status = mysqli_query($con, "UPDATE pr_orders_document SET order_status = '1' WHERE document_id = '$document_id' ");

	
}
	if($document_details['order_status'] == '1'){
		
		$query_products_warehouse = mysqli_query($con, "SELECT * FROM pr_orders WHERE document_id = '$document_id' ");
		while($array_products = mysqli_fetch_array($query_products_warehouse)){
				
			$curr_product_count = $array_products['product_count_warehouse'];
			$curr_product_product_id = $array_products['product_id'];
			$product_count_warehouse_history = $array_products['product_count_warehouse_history'];
			
			if($curr_product_count == $product_count_warehouse_history) {
				
			//	echo "havasar";
			} 
			
			if($curr_product_count > $product_count_warehouse_history){
				
				$difference = $curr_product_count - $product_count_warehouse_history;
				
				
				if($order_type == '2'){
					$warehouse_update = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count + $difference) WHERE product_id = '$curr_product_product_id' AND warehouse_id = '$warehouse_id' ");
				}else{
					$warehouse_update = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count - $difference) WHERE product_id = '$curr_product_product_id' AND warehouse_id = '$warehouse_id' ");
				}
			//	 echo "mec";
								
				$warehouse_update_history = mysqli_query($con, "UPDATE pr_orders SET product_count_warehouse_history = '$curr_product_count' WHERE product_id = '$curr_product_product_id' AND document_id = '$document_id' ");


			}	
			
			if($curr_product_count < $product_count_warehouse_history){
				
			//	 echo "poqr";

				$difference = $product_count_warehouse_history - $curr_product_count;
				if($order_type == '2'){
					$warehouse_update = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count - $difference) WHERE product_id = '$curr_product_product_id' AND warehouse_id = '$warehouse_id' ");
				}else{
					$warehouse_update = mysqli_query($con, "UPDATE pr_warehouse_products SET product_count = (product_count + $difference) WHERE product_id = '$curr_product_product_id' AND warehouse_id = '$warehouse_id' ");
				}
				$warehouse_update_history = mysqli_query($con, "UPDATE pr_orders SET product_count_warehouse_history = '$curr_product_count' WHERE product_id = '$curr_product_product_id' AND document_id = '$document_id' ");

			}
						
		}

	} 


?>

<?php 
	$action = mysqli_real_escape_string($con, $_GET['action']);
	if($action == 'no_print'):
?>

<script type="text/javascript">
	history.go(-2)
</script>

<?php else: ?>

<script type="text/javascript">
var document_id = <?php echo $document_id; ?> ;
window.location.replace('/view_order.php?document_id='+document_id+'');
</script>

<?php endif; ?>