<?php 
include 'db.php';

if(isset($_POST['region_select'])){
		
		$region_id = mysqli_real_escape_string($con, $_POST['region_select']);
		$query_districts = mysqli_query($con, "SELECT * FROM  district WHERE region_id = '$region_id' ");
		//$query = mysqli_query($con, "SELECT id, district_name FROM district WHERE region_id = `$region_id` " );
		$data = "<option value='0'>Ընտրել</option>";
		while($regions_array = mysqli_fetch_array($query_districts)){
			$data .= "<option value='{$regions_array['id']}'>{$regions_array['district_name']}</option>";
		}
		
		echo $data;

}

if(isset($_POST['product_group'])){
		
		$product_group = mysqli_real_escape_string($con, $_POST['product_group']);
		$query_product_group = mysqli_query($con, "SELECT * FROM pr_products WHERE product_group = '$product_group' ORDER BY regular_n ASC");

		$data = "<option value='0'>Ընտրել</option>";
		while($query_product_group_array = mysqli_fetch_array($query_product_group)){
			$data .= "<option value='{$query_product_group_array['id']}'>{$query_product_group_array['name']}</option>";
		}
		
		echo $data;

}

if(isset($_POST['district_id'])){
		
	$district_id = mysqli_real_escape_string($con, $_POST['district_id']);
	$district_selected_id = mysqli_real_escape_string($con, $_POST['district_selected_id']);
	
	$query = mysqli_query($con, "SELECT shop_id, qr_id, name, address, district FROM shops WHERE district = '$district_id' ");
	$data = '';
	while ($array_shops = mysqli_fetch_array($query)){
		$shop_id = $array_shops['shop_id'];

		$query_2 = mysqli_query($con, "SELECT * FROM manager_to_shop WHERE shop_id = '$shop_id' AND manager_id = '$district_selected_id' ");
		if ($query_2->num_rows != 0){
			$shop_checked = ' checked';
		}else{
			$shop_checked = '';
		}
		
		$qr_id = $array_shops['qr_id'];
		$name = $array_shops['name'];
		$address = $array_shops['address'];
		$data .= "<tr>";
		$data .= "<td><input type='checkbox' $shop_checked class='active' name='active' value='$shop_id'></td>";
		$data .= "<td>$shop_id</td>";
		$data .= "<td>$qr_id</td>";
		$data .= "<td>$name</td>";
		$data .= "<td>$address</td>";
		$data .= "</tr>";
	}
		
	echo $data;

}

if(isset($_POST['check_active']) ){

		
	$check_active = mysqli_real_escape_string($con, $_POST['check_active']);
	
	$check_group_id = mysqli_real_escape_string($con, $_POST['check_group_id']);
	$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
	
	if($check_active == '1'){
		$query = mysqli_query($con, "INSERT INTO group_to_shop (group_id, shop_id) VALUES ('$check_group_id','$shop_id') ");
	}
	if($check_active == '0'){
		$query = mysqli_query($con, "DELETE FROM group_to_shop WHERE group_id = '$check_group_id' AND shop_id = '$shop_id' ");
	}

}


if(isset($_POST['check_id_delete']) ){

		
	$check_id_delete = mysqli_real_escape_string($con, $_POST['check_id_delete']);
	
	
		$query = mysqli_query($con, "DELETE FROM group_to_shop WHERE id = '$check_id_delete' ");

}



?>


  
							
							
								
							 