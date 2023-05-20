<?php

	include 'db.php';
	$product_id = mysqli_real_escape_string($con, $_POST['barcode_product_id']);
	$barcode_count = mysqli_real_escape_string($con, $_POST['barcode_count']);
	$action = mysqli_real_escape_string($con, $_POST['action']);
	$barcode_text = mysqli_real_escape_string($con, $_POST['barcode_text']);

	$query_check_barcode = mysqli_query($con, "SELECT Count(id) AS bar_count FROM pr_barcodes WHERE barcode = '$barcode_text' ");
	$check_count = mysqli_fetch_array($query_check_barcode);
	
	
	if($check_count['bar_count'] == '0') {
		$query_barcode_add = mysqli_query($con, "INSERT INTO pr_barcodes (product_id, barcode, product_count) VALUES ('$product_id', '$barcode_text', '$barcode_count')");
		
		if($query_barcode_add) {
			echo"
			<tr class='$barcode_text'>
			<td>$barcode_text</td>
			
			<td>$barcode_count</td>
			<td>
			
			<button id='$barcode_text' class='btn btn-danger btn-sm rounded-0 delete_barcode' title='Ջնջել'><i class='fa fa-trash'></i></button>
			
			</td>
			</tr>
			";
		}
	}else{
		echo "<script type='text/javascript'>
		alert ('Նման Շտրիխ կոդ գոյություն ունի');
		
		</script>";
	}
	
	if($action == 'delete_barcode'){

		$barcode_text = mysqli_real_escape_string($con, $_POST['barcode']);
		
		mysqli_query($con, "DELETE FROM pr_barcodes WHERE barcode = '$barcode_text' ");
		echo "min";
		
	}	

	
	?>
	