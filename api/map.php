<?php 
include 'db.php';

$action = mysqli_real_escape_string($con, $_POST['action']);

if($action == 'edit_map'){
	$map_comment = mysqli_real_escape_string($con, $_POST['map_comment']);
	$map_id = mysqli_real_escape_string($con, $_POST['map_id']);
	
	$query = mysqli_query($con, "UPDATE maps SET map_comment = '$map_comment' WHERE id = '$map_id' ");

}

if($action == 'delete_map'){
	$map_to_delete = mysqli_real_escape_string($con, $_POST['map_to_delete']);
	
	$query = mysqli_query($con, "DELETE FROM maps WHERE id = '$map_to_delete' ");

}

if($action == 'save_calc_km'){

	$map_fake_km = mysqli_real_escape_string($con, $_POST['map_fake_km']);
	$map_real_km = mysqli_real_escape_string($con, $_POST['map_real_km']);
	$manager_select = mysqli_real_escape_string($con, $_POST['manager_select']);
	$reservation = mysqli_real_escape_string($con, $_POST['reservation']);
	$map_km_cost = mysqli_real_escape_string($con, $_POST['map_km_cost']);
	$map_km_dif = mysqli_real_escape_string($con, $_POST['map_km_dif']);
	$map_comment = mysqli_real_escape_string($con, $_POST['map_comment']);



	$datebeet = mysqli_real_escape_string($con, $_POST['reservation']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($map_real_km != ''){
		$query_insert = mysqli_query($con, "INSERT INTO maps (map_manager_id, map_date, map_comment, map_real_km, map_fake_km, map_km_cost, map_km_dif) VALUES ('$manager_select', '$start_date', '$map_comment', '$map_real_km', '$map_fake_km', '$map_km_cost', '$map_km_dif' )");
		

		//$curr_date = date("Y-m-d");

		//$query_insert_finance = mysqli_query($con, "INSERT INTO pr_expenses (expenses_type, expenses_date, expenses_payment_type, expenses_group, expenses_summ) VALUES ('78', '$curr_date', '1', '4', '$map_km_cost')");
	
	
	
	}
	
}

if($action == 'get_calc_km'){

	$map_fake_km = mysqli_real_escape_string($con, $_POST['map_fake_km']);
	$map_real_km = mysqli_real_escape_string($con, $_POST['map_real_km']);
	$manager_select = mysqli_real_escape_string($con, $_POST['manager_select']);

	$array_check_worker = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM manager WHERE id = '$manager_select' "));

	$cofficent = $array_check_worker['charge_cost'] / $array_check_worker['charge_km'];
	
	$result_calc = array();
	
	$result_calc[0] = round($cofficent * $map_real_km, 1); // gumar 
	$result_calc[1] = round($map_fake_km - $map_real_km, 1); // km -eri tarberutyun

	echo json_encode($result_calc);

}


if($action == 'request_orders'){
	
		$manager_id_selected = mysqli_real_escape_string($con, $_POST['manager_select']);
		$courier_id_selected = mysqli_real_escape_string($con, $_POST['courier_select']);

		$district_id_selected = mysqli_real_escape_string($con, $_POST['district_select']);


		$selected_region = mysqli_real_escape_string($con, $_POST['region_select']);
		$selected_district = mysqli_real_escape_string($con, $_POST['district_select']);
		$selected_shop = mysqli_real_escape_string($con, $_POST['shop']);
		$selected_network = mysqli_real_escape_string($con, $_POST['network_select']);
		
		$selected_payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);
		
		$group_selected = mysqli_real_escape_string($con, $_POST['group_id']);
		
			
		if($manager_id_selected != 0 AND $manager_id_selected != ''){
			$query_manager_select = " AND pr_orders_document.manager_id = '$manager_id_selected'";
		}else{
			$query_manager_select = '';
		}

		if($courier_id_selected != 0 AND $courier_id_selected != ''){
			$query_courier_select = " AND pr_orders_document.courier_id = '$courier_id_selected'";
		}else{
			$query_courier_select = '';
		}




		if($group_selected != 0 AND $group_selected != ''){
			$query_group_selected = " AND pr_orders_document.product_group = '$group_selected' ";
		}else{
			$query_group_selected = '';
		}


		//new
		if($selected_region != 0 AND $selected_region != ''){
			$query_region_select = " AND shops.region = '$selected_region'";
		}else{
			$query_region_select = '';
		}

		if($selected_district != 0 AND $selected_district != ''){
			$query_district_select = " AND shops.district = '$selected_district'";
		}else{
			$query_district_select = '';
		}

		if($selected_shop != 0 AND $selected_shop != ''){
			$query_shop_select = " AND shops.shop_id = '$selected_shop'";
		}else{
			$query_shop_select = '';
		}


		if($selected_network != 0 AND $selected_network != ''){
			$query_network_select = " AND shops.network = '$selected_network'";
		}else{
			$query_network_select = '';
		}


		if($selected_payment_type != 0 AND $selected_payment_type != ''){
			$payment_type_select = " AND pr_orders_document.pay_type = '$selected_payment_type'";
		}else{
			$payment_type_select = '';
		}


	$worker_select = mysqli_real_escape_string($con, $_POST['worker_select']);
		
	$array_check_worker = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM manager WHERE id = '$worker_select' "));
	
	$warehouse_lat = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'warehouse_lat' "));
	$warehouse_long = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'warehouse_long' "));
	
	
	if($array_check_worker['manager_origin_latitude'] == '' AND $array_check_worker['manager_origin_longitude'] == ''){
		$start_lat =  $warehouse_lat['param_value'];
		$start_long =  $warehouse_long['param_value'];
	}else{
		$start_lat = $array_check_worker['manager_origin_latitude'];
		$start_long = $array_check_worker['manager_origin_longitude'];
	}


		$datebeet = mysqli_real_escape_string($con, $_POST['reservation']);
		$date_ex = explode(" - ", $datebeet);
		$start_date = $date_ex[0];
		$end_date = $date_ex[1];

		if($start_date != $end_date){
			$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
		}else{
			$query_date_range = " LIKE '$start_date%'";
		}
			
	
					
			if($datebeet !=''){
				$query = "SELECT * FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN network ON shops.network = network.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE  document_date $query_date_range $query_district_select $query_region_select $query_shop_select $query_network_select $payment_type_select $query_manager_select $query_group_selected $query_courier_select ORDER BY ABS(shop_latitude - $start_lat) + ABS(shop_longitude - $start_long) ASC";
		
				
			}else{
				$query = '';
			}
						
			$query_order_documents = mysqli_query($con, $query);
			while($warehouse_order_array = mysqli_fetch_array($query_order_documents)){
			$document_id = $warehouse_order_array['document_id'];
			$shop_id = $warehouse_order_array['shop_id'];
			$manager_id = $warehouse_order_array['manager_id'];
			$courier_id = $warehouse_order_array['courier_id'];
			$product_id = $warehouse_order_array['product_id'];
			$product_count = $warehouse_order_array['product_count'];
			$document_date = $warehouse_order_array['document_date'];
			$shop_name = $warehouse_order_array['name'];
			$shop_address = $warehouse_order_array['address'];
			$order_summ = $warehouse_order_array['order_summ'];
			$order_last_summ = $warehouse_order_array['order_last_summ'];
			$order_delivered = $warehouse_order_array['order_delivered'];
			$order_pay_status = $warehouse_order_array['order_pay_status'];
			$product_group_name = $warehouse_order_array['group_name'];
			$order_pay_type = $warehouse_order_array['pay_type'];
			$district_name = $warehouse_order_array['district_name'];
			$network = $warehouse_order_array['network_name'];
			$order_comment = $warehouse_order_array['order_comment'];
			$region_id = $warehouse_order_array['region_id'];
			$latitude = $warehouse_order_array['shop_latitude'];
			
			
			$query_manager = mysqli_query($con, "SELECT login FROM manager WHERE id='$manager_id' ");
			$array_manager = mysqli_fetch_array($query_manager);
			$manager_login = $array_manager['login'];
			
			$query_region = mysqli_query($con, "SELECT region_name FROM region WHERE id='$region_id' ");
			$array_region = mysqli_fetch_array($query_region);
			$region_name = $array_region['region_name'];


			$query_courier = mysqli_query($con, "SELECT login FROM manager WHERE id='$courier_id' ");
			$array_courier = mysqli_fetch_array($query_courier);
			$courier_login = $array_courier['login'];
			
			
			if($order_last_summ == ''){
				$order_last_summ = '0'; 
			}
			

		echo "	  
		
			<tr>
			 <td> <input type='checkbox' class='ch_orders'  name='ch_orders[]' value='$shop_id' checked> </td>		  
			 <td>$shop_id.$shop_name </td>
			 <td> $shop_address </td>
			 <td> $district_name </td>
			 <td> $region_name | $latitude </td>
			 <td> $manager_login </td>
			 <td> $courier_login </td>

			</tr>";
			 
		}
                 
	
	
}


if($action == 'request_shop'){
	
	$district_id_selected = mysqli_real_escape_string($con, $_POST['district_select']);
	$manager_id_selected = mysqli_real_escape_string($con, $_POST['manager_select']);
	$region_id_selected = mysqli_real_escape_string($con, $_POST['region_select']);
	
	$worker_select = mysqli_real_escape_string($con, $_POST['worker_select']);
		
	$array_check_worker = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM manager WHERE id = '$worker_select' "));
	
	$warehouse_lat = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'warehouse_lat' "));
	$warehouse_long = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'warehouse_long' "));
	
	
	if($array_check_worker['manager_origin_latitude'] == '' AND $array_check_worker['manager_origin_longitude'] == ''){
		$start_lat =  $warehouse_lat['param_value'];
		$start_long =  $warehouse_long['param_value'];
	}else{
		$start_lat = $array_check_worker['manager_origin_latitude'];
		$start_long = $array_check_worker['manager_origin_longitude'];
	}

	if($district_id_selected != 0 AND $district_id_selected != ''){
		$query_district_select = " AND shops.district = '$district_id_selected'";
	}else{
		$query_district_select = '';
	}

	if($region_id_selected != 0 AND $region_id_selected != ''){
		$query_region_select = " AND shops.region = '$region_id_selected'";
	}else{
		$query_region_select = '';
	}

	if($manager_id_selected != 0 AND $manager_id_selected != ''){
		$query_manager_select = " AND shops.static_manager = '$manager_id_selected'";
	}else{
		$query_manager_select = '';
	}

	
		
		$query = mysqli_query($con, "SELECT *, shops.name AS shop_name, shops.phone AS phone_shop, manager.name AS manager_name, shops.discount AS shop_discount FROM shops LEFT JOIN manager ON shops.static_manager = manager.id LEFT JOIN network ON shops.network = network.id WHERE 1=1 $query_district_select $query_region_select $query_manager_select ORDER BY ABS(shop_latitude - $start_lat) + ABS(shop_longitude - $start_long) ASC");

			
		while ($array_shops = mysqli_fetch_array($query)){
		$shop_id = $array_shops['shop_id'];
		$qr_id = $array_shops['qr_id'];
		$name = $array_shops['shop_name'];
		$address = $array_shops['address'];
		$district = $array_shops['district'];
		$region = $array_shops['region'];
		$latitude = $array_shops['shop_latitude'];

		
		$query_region = mysqli_query($con, "SELECT * from region WHERE id='$region' ");
		$array_region = mysqli_fetch_array($query_region);
		
		$query_district = mysqli_query($con, "SELECT * from district WHERE id='$district' ");
		$array_district = mysqli_fetch_array($query_district);
		
		$dist_name = $array_district['district_name'];	
		$reg_name = $array_region['region_name'];
		
		echo "	  
			  <tr>
			 <td> <input type='checkbox' class='ch_shops'  name='ch_shops[]' value='$shop_id' checked> </td>		  
			 <td>$shop_id.$name </td>
			 <td> $address </td>
			 <td> $dist_name </td>
			 <td> $reg_name | $latitude </td>

			</tr>";
			 
		}
                 
	
	
}

if($action == 'request_visit'){
	
	$district_id_selected = mysqli_real_escape_string($con, $_POST['district_select1']);
	$manager_id_selected = mysqli_real_escape_string($con, $_POST['manager_select1']);
	$region_id_selected = mysqli_real_escape_string($con, $_POST['region_select1']);

	$datebeet = mysqli_real_escape_string($con, $_POST['reservation']);

	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = " LIKE '$start_date%'";
	}

	if($district_id_selected != 0 AND $district_id_selected != ''){
		$query_district_select = " AND shops.district = '$district_id_selected'";
	}else{
		$query_district_select = '';
	}

	if($region_id_selected != 0 AND $region_id_selected != ''){
		$query_region_select = " AND shops.region = '$region_id_selected'";
	}else{
		$query_region_select = '';
	}

	if($manager_id_selected != 0 AND $manager_id_selected != ''){
		$query_manager_select = " AND shops.static_manager = '$manager_id_selected'";
	}else{
		$query_manager_select = '';
	}

		$query = mysqli_query($con, "SELECT * FROM visits INNER JOIN shops on visits.shop_id = shops.shop_id WHERE 1=1 AND visits.date $query_date_range $query_district_select $query_region_select $query_manager_select ORDER by visits.id DESC");

			
		while ($array_shops = mysqli_fetch_array($query)){
		$shop_id = $array_shops['shop_id'];
		$qr_id = $array_shops['qr_id'];
		$name = $array_shops['name'];
		$address = $array_shops['address'];
		$district = $array_shops['district'];
		$region = $array_shops['region'];
		$latitude = $array_shops['shop_latitude'];
		$manager_id = $array_shops['manager_id'];

		
		$manager_query = mysqli_query($con, "SELECT * FROM manager WHERE id='$manager_id' ");
		$array_manager = mysqli_fetch_array($manager_query);
		
		$query_region = mysqli_query($con, "SELECT * from region WHERE id='$region' ");
		$array_region = mysqli_fetch_array($query_region);
		
		$query_district = mysqli_query($con, "SELECT * from district WHERE id='$district' ");
		$array_district = mysqli_fetch_array($query_district);
		
		$dist_name = $array_district['district_name'];	
		$reg_name = $array_region['region_name'];
		$manager_name = $array_manager['login'];
		
		echo "	  
			  <tr>
			 <td> <input type='checkbox' class='ch_visits'  name='ch_visits[]' value='$shop_id' checked> </td>		  
			 <td>$shop_id.$name </td>
			 <td> $address </td>
			 <td> $dist_name </td>
			 <td> $reg_name | $latitude</td>
			 <td> $manager_name </td>
			</tr>";
			 
		}
	
}

if($action == 'request_shops'){
	
	$manager_select = mysqli_real_escape_string($con, $_POST['manager_select']);

	$manager_query = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM manager WHERE id='$manager_select' "));

	$manager_origin_latitude = $manager_query['manager_origin_latitude'];
	$manager_origin_longitude = $manager_query['manager_origin_longitude'];
	$manager_destination_latitude = $manager_query['manager_destination_latitude'];
	$manager_destination_longitude = $manager_query['manager_destination_longitude'];
	
	
		
	$warehouse_lat = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'warehouse_lat' "));
	$warehouse_long = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'warehouse_long' "));
	
	
	if($manager_origin_latitude == '' AND $manager_origin_longitude == ''){
		$manager_origin_latitude = $warehouse_lat['param_value'];
		$manager_origin_longitude = $warehouse_long['param_value'];
	}	
	
	if($manager_destination_latitude == '' AND $manager_destination_longitude == ''){
		$manager_destination_latitude = $warehouse_lat['param_value'];
		$manager_destination_longitude = $warehouse_long['param_value'];
	}
	
	
	
	
	$shops = mysqli_real_escape_string($con, $_POST['checks']);
	$shops_array = explode(",", $shops);
	
	
	
	
	if(count($shops_array) < 24) {
			
		if($_POST['action1'] == 'visits'){
			$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$manager_origin_latitude,$manager_origin_longitude&destination=$manager_destination_latitude,$manager_destination_longitude&waypoints=";

		}if($_POST['action1'] == 'shops'){
			$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$manager_origin_latitude,$manager_origin_longitude&destination=$manager_destination_latitude,$manager_destination_longitude&waypoints=optimize:true";

		}
		
		
		foreach ($shops_array as $value) {
			
		  $query_select_shop = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops WHERE shop_id = '$value' " ));

		  $shop_latitude = $query_select_shop['shop_latitude'];
		  $shop_longitude = $query_select_shop['shop_longitude'];
		  $url .= "|$shop_latitude,$shop_longitude";
		}
		 
		$url .= "&key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);

		curl_close($ch);
		$response_a = json_decode($response, true);
		

		//chanaparhi erkarutyan hashvark
		$total = 0;
		for ($i = 0; $i <= count($response_a['routes'][0]['legs']); $i++) {
		  
		  $total = $total + $response_a['routes'][0]['legs'][$i]['distance']['value'];
		}
		
		$way_points = $response_a['routes'][0]['waypoint_order'];
		
		//xanutneri hasceneri texadrum
		$shops = "";
		foreach ($way_points as $key => $value) {
			
			$shop_id = $shops_array[$value];
			$query_sorder_shops = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops WHERE shop_id='$shop_id' "));
			$shop_name = $query_sorder_shops['name'];
			$shop_address = $query_sorder_shops['address'];
			$shops .= "$shop_id . $shop_name , $shop_address <br>";
		}
		
		$points_map = $response_a['routes'][0]['overview_polyline']['points'];

		$response_details = array();
		
		$response_details[0] = $total / 1000;
		$response_details[1] = $shops;
		$response_details[2] = "<img src='http://maps.googleapis.com/maps/api/staticmap?size=500x500&key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8&path=weight:4|color:blue|enc:$points_map'>";
		
		
		echo json_encode($response_details);
		
		
		//var_dump($way_points);
		
		//qartezi parametrer
		
		//echo $total / 1000;
		
		
		
	/* -------- qartez
	http://maps.googleapis.com/maps/api/staticmap?size=500x500&key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8&path=weight:4|color:blue|enc:ijntFy{znG|AmFj@sAdA{AxDsF~@eAlAiA|@yAKkGbHcB|CeAtCwA~FuBxI_ChAG|IJhAUpAe@tGuEnBcAdAUzA[xAL`D`AE]m@gByCeGsG_NsAmE{AoG]iEHuCZgBt@wA`AaAbEwBhL_F|HcDxOcHzAq@R`Af@rC|@jD`AxA`BwAz@i@n@_@H_@\YDUKq@^}@`A}FNiBCQIUXKhBs@h@MZHpACbABtANtA\dChArHnFt@XfAQpBk@lCcAz@J^`@|@Z{@zD?~BLj@Z~@dBxBjDlDbAt@_AnC}@zBm@u@l@t@w@jB{@jCNJGp@E\Jb@nAlBd@d@n@VhBl@b@Tq@vDQhCJxCh@tB`AvBpBpDEXOJyCoBWQiBtFXv@v@VCFIRGPM`@Qf@_@lA]hAOf@e@xA_EpKo@rBsBzDT|@|AfEd@nA~@y@~DlCdMpIkBvFa@pDuApOm@hGKfCFxAGpAaAbKWzCBpBNlD^RlATtC`@~@PHRUl@{AVeDpAkEnBgCz@eAOqAu@wFkFs@gAMoAPwCEYWCSb@k@fDYVoAMs@IcDOk@H_Bj@}ApAeAjBk@|BS`BUvTLjFhBfRJ|DUzD_CrNS~DAlEq@fDkBpEkAbB_BbBwLxKy@jAw@pBkAvGs@`FY~@aA~A_@~@[hADz@Bx@Ht@tB`HxBfH|@zCkCtAuJdG{RpLuJbGmA~@eFjE{DvCqFhEkDfDgB~AaEhDuO~MmGhFqAx@o@s@y@iBgAqByBiD{EmHgLeQsEaHaBeC`BdCrE`HbElG~LdR`EzGbAdCZxADnAK`AjJnJfQvPfBbA`AARLfBVhBHf^bCjk@~DxLx@hBT~G\nFX~AA~Bo@pDcDlAkA|BxEbBnCbC`Fr@xAPzA?t@_@`@e@Im@m@Ig@Bu@l@aBLiA@qC\qAlAiBfBs@hEw@dL}BvDyAlBmBfDsDp@mAf@wBDgBu@sIGkBN{A|G{PdAcC\NjAl@pCdBvDdC^BNyAd@eBl@WdAcAH[SoAKWPGdFmFpDeEpCqCHm@IUUk@So@KiBBu@B[FYLM|C~FpBvDhDtGlI|ObJ`QjEjIjCdGtChH|IpWfQpg@fHbTd@tAA`@Gb@S\WFe@MW_AFi@Vc@|B{@FE\[vBmAvAmAdAwA~AuDxDmR|DeSdBgIvC_F~BgDpGcJZ_@jA{ATXFBN?pAy@zAiCEkAQ[lAkBlC}DhBkC|JwNjVe^pDkFt@gANLh@GNo@Ie@lAwBnGgJzBeCdBgAjI_C`P{ErU{GfK_D


	*/
		
	
	}
	
	
	
	if(count($shops_array) > 24){
		
				
		$shops_array_chuked = array_chunk($shops_array, 23);
		
		$last_shop_id = $shops_array_chuked[0][22];
				
		
		$last_shop = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops WHERE shop_id = '$last_shop_id' " ));
		$last_shop_latitude = $last_shop['shop_latitude'];
		$last_shop_longitude = $last_shop['shop_longitude'];
		
		if($_POST['action1'] == 'visits'){
			$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$manager_origin_latitude,$manager_origin_longitude&destination=$last_shop_latitude,$last_shop_longitude&waypoints=";

		}if($_POST['action1'] == 'shops'){
			$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$manager_origin_latitude,$manager_origin_longitude&destination=$last_shop_latitude,$last_shop_longitude&waypoints=optimize:true";
		}
		
		
		
		foreach ($shops_array_chuked['0'] as $value) {
			
		  $query_select_shop = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops WHERE shop_id = '$value' " ));

		  $shop_latitude = $query_select_shop['shop_latitude'];
		  $shop_longitude = $query_select_shop['shop_longitude'];
		  $url .= "|$shop_latitude,$shop_longitude";
		}
		 
		$url .= "&key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);

		curl_close($ch);
		$response_a = json_decode($response, true);
			
		$total = 0;
		for ($i = 0; $i <= count($response_a['routes'][0]['legs']); $i++) {
		  
		  $total = $total + $response_a['routes'][0]['legs'][$i]['distance']['value'];
		}
		
		$way_points = $response_a['routes'][0]['waypoint_order'];
		
		//xanutneri hasceneri texadrum
		$shops = "";
		foreach ($way_points as $key => $value) {
			
			$shop_id = $shops_array_chuked['0'][$value];
			$query_sorder_shops = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops WHERE shop_id='$shop_id' "));
			$shop_name = $query_sorder_shops['name'];
			$shop_address = $query_sorder_shops['address'];
			$shops .= "$shop_id . $shop_name , $shop_address <br>";
		}
		
		$points_map = $response_a['routes'][0]['overview_polyline']['points'];

		$response_details = array();
		
		$total_first_part = $total / 1000;
		$response_details[1] = $shops;
		$response_details[2] = "<img src='http://maps.googleapis.com/maps/api/staticmap?size=500x500&key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8&path=weight:4|color:blue|enc:$points_map'>";
		
				
		
		


		//echo $total;
		
		//--------------------------------------------		
		
		//erkrord mas
		
		$shops_array_chuked = array_chunk($shops_array, 23);
		
		$first_shop_id = $shops_array_chuked[0][22];
				
		
		$first_shop = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops WHERE shop_id = '$first_shop_id' " ));
		$first_shop_latitude = $first_shop['shop_latitude'];
		$first_shop_longitude = $first_shop['shop_longitude'];

		
		
		
		
		if($_POST['action1'] == 'visits'){
			$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$first_shop_latitude,$first_shop_longitude&destination=$manager_destination_latitude,$manager_destination_longitude&waypoints=";


		}if($_POST['action1'] == 'shops'){
			$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$first_shop_latitude,$first_shop_longitude&destination=$manager_destination_latitude,$manager_destination_longitude&waypoints=optimize:true";

		}
		
		
		foreach ($shops_array_chuked['1'] as $value) {
		
		  $query_select_shop = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops WHERE shop_id = '$value' " ));

		  $shop_latitude = $query_select_shop['shop_latitude'];
		  $shop_longitude = $query_select_shop['shop_longitude'];
		  $url .= "|$shop_latitude,$shop_longitude";
		  
		}
		 
		$url .= "&key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);

		curl_close($ch);
		$response_a = json_decode($response, true);
			
		$total1 = 0;
		for ($i = 0; $i <= count($response_a['routes'][0]['legs']); $i++) {
		  
		  $total1 = $total1 + $response_a['routes'][0]['legs'][$i]['distance']['value'];
		}
		
		

		$way_points = $response_a['routes'][0]['waypoint_order'];
		
		//xanutneri hasceneri texadrum
		$shops = "";
		foreach ($way_points as $key => $value) {
			
			$shop_id = $shops_array_chuked['1'][$value];
			$query_sorder_shops = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops WHERE shop_id='$shop_id' "));
			$shop_name = $query_sorder_shops['name'];
			$shop_address = $query_sorder_shops['address'];
			$shops .= "$shop_id . $shop_name , $shop_address <br>";
		}
		
		$points_map = $response_a['routes'][0]['overview_polyline']['points'];

	//	$response_details = array();
		
		$response_details[0] = $total / 1000 + $total_first_part;
		$response_details[3] = $shops;
		$response_details[4] = "<img src='http://maps.googleapis.com/maps/api/staticmap?size=500x500&key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8&path=weight:4|color:blue|enc:$points_map'>";
		
		
		echo json_encode($response_details);



		$all_total = ($total + $total1) / 1000;
		//echo $all_total;
		//echo $url;

	}
	
	
	
	
	
	
	
	
	
	
}




?>