<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 
function draw_star($n){
    for($i=1; $i < 6; $i++){
        if($i<= $n):
            echo '<span class="fa fa-star checked_star"></span>';
        elseif($n):
            echo '<span class="fa fa-star text-muted"></span>';
        else:
            echo '';
        endif;        
    }
}

$selected_region = mysqli_real_escape_string($con, $_GET['region']);
$selected_district = mysqli_real_escape_string($con, $_GET['district']);
$selected_shop = mysqli_real_escape_string($con, $_GET['shop']);


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
	$query_shop_select = " AND shops.shop_id = '$selected_shop' ";
}else{
	$query_shop_select = '';
}

$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);

if($manager_id_selected != '0'){
	$query_manager_1 = " AND static_manager = '$manager_id_selected' ";
	$query_manager_id_selected = " AND visits.manager_id = '$manager_id_selected'  ";
	$evaluation_manager_where_claus = " AND manager_id='$manager_id_selected' ";

}else{
	$query_manager_id_selected = '';
	$evaluation_manager_where_claus='';
}



$visit_count_est = mysqli_real_escape_string($con, $_GET['visit_count']);

$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
$date_ex = explode(" - ", $datebeet);
$start_date = $date_ex[0];
$end_date = $date_ex[1];

if($start_date != $end_date){
	$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
}else{
	$query_date_range = " LIKE '$start_date%'";
}

$not_visited = mysqli_real_escape_string($con, $_GET['not_visited']);
$not_grouped = mysqli_real_escape_string($con, $_GET['not_grouped']);

					
?>

<?php
function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
  $theta = $longitude1 - $longitude2; 
  $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
  $distance = acos($distance); 
  $distance = rad2deg($distance); 
  $distance = $distance * 60 * 1.1515; 
  switch($unit) { 
    case 'Mi': 
      break; 
    case 'Km' : 
      $distance = $distance * 1.609344 * 1000; 
  } 
  
 // echo $distance;
  return (round($distance,2)); 
}
?>


<style type="text/css">
.dt-buttons {
	float: right;
    margin-top: 15px;
}
.checked_star {
  color: orange;
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Վիճակագրություն</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/dashboard.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
      
            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  
		<form action="/statistics.php" id="statistics_form"> 
			<div class="form-row">				  
				<div class="form-group col-md-3">
					<label>Ժամանակահատված</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" class="form-control float-right" id="reservation" value="<?php echo $datebeet; ?>" name="datebeet">
					</div>
				</div>
				<div class="form-group col-md-2">
						<label for="address">Մարզ</label>
						<select name="region" id="region" class="form-control">
							<option value="0"> Ընտրել </option>
								<?php 
									$query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
									while ($array_regions = mysqli_fetch_array($query_region)):
									$region_id = $array_regions['id'];
									$region_name = $array_regions['region_name'];
								?>										 
							<option value="<?php echo $region_id; ?>" <?php if($region_id == $selected_region) {echo "selected"; } ?>> <?php echo $region_name; ?></option>							
								<?php endwhile; ?>							
						</select>
				</div>
				<div class="form-group col-md-2">
					<label for="district">Տարածք</label>						
					<select name="district" id="district" class="form-control">					
						<option value="0">Ընտրել</option>							
							<?php 
								$district_query = mysqli_query($con, "SELECT * FROM district WHERE region_id = '$selected_region' ORDER by id DESC");
								while ($array_district = mysqli_fetch_array($district_query)):
								$district_id = $array_district['id'];
								$district_name = $array_district['district_name'];
							?> 						 
						<option value="<?php echo $district_id; ?>" <?php if($district_id == $selected_district) {echo "selected"; } ?>> <?php echo $district_name; ?></option>			
							<?php endwhile; ?>				
					</select>					
				</div>				  
				<div class="form-group col-md-2">
					<label for="shop">Խանութ</label>						
					<select name="shop" id="shop" class="form-control">
						<option value="0">Ընտրել</option>					
							<?php 
								$shops_query = mysqli_query($con, "SELECT shop_id, name, district FROM shops WHERE district = '$selected_district' ORDER by id DESC");
								while ($array_shops = mysqli_fetch_array($shops_query)):
								$shop_id = $array_shops['shop_id'];
								$shop_name = $array_shops['name'];
							?> 						 
						<option value="<?php echo $shop_id; ?>" <?php if($shop_id == $selected_shop) {echo "selected"; } ?>> <?php echo $shop_name; ?></option>			
							<?php endwhile; ?>					
					</select>					
				</div>				  
				<div class="form-group col-md-2">
					<label for="login">Մենեջեր</label>
					<select name="manager_select" id="manager_select" class="form-control">
						<option value="0"> Ընտրել </option>
							<?php 
								$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' AND active = 'on' ORDER by id DESC");
								while ($array_manager = mysqli_fetch_array($query_manager)):
								$manager_id = $array_manager['id'];
								$manager_login = $array_manager['login'];
							?> 								 
						<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>								
							<?php endwhile; ?>								
					</select>
				</div>							
				<div class="form-group col-md-2">
					<label for="login">Ենթադրվող քանակ</label>
					<input type="number" class="form-control" id="visit_count" name="visit_count" value="<?php echo $visit_count_est; ?>" placeholder="Այցերի քանակ">
				</div>					  					  
				<div class="form-group col-md-1"  align="center">
					<label for="login">Բացվածք</label>
					<input type="checkbox" class="form-control" id="not_grouped" name="not_grouped" value="1" <?php if($not_grouped == '1'){echo "checked"; } ?>>
				</div>					  
				<div class="form-group col-md-1 not_visited_check" <?php if(isset($_GET['not_grouped'])){echo "style='display:none;'";} ?>  align="center">
					<label for="login" >Չայցելած</label>
					<input type="checkbox" class="form-control" id="not_visited" name="not_visited" value="1" <?php if($not_visited == '1'){echo "checked"; } ?>>
				</div>				  
				<div class="form-group col-md-1" style="max-width:150px;display: flex;  flex-direction:column;  justify-content:flex-end;">
					<button type="submit" class="btn btn-success">Ցուցադրել</button>
				</div>				  
				</div>
				</form>
			  
		
			  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>				  
                    <th>ID</th>
                    <th>QR համար</th>
					<th>Խանութի Անուն</th>
					<th>ՀՎՀՀ</th>
					<th>Իրվ․ անուն</th>
                    <th>Խանութի Հասցե</th>
                    <th>Մարզ</th>
                    <th>Շրջան</th>
					<th>Մենեջեր</th>
					<th>Ոլորտի անվանում</th>
					<th>Ժամանակ</th>				
						<?php if($not_grouped !='1'): ?>					
					<th>Այցի քանակ</th>
					<th>Տարբերություն</th>
					<th>Գնահատման քանակ</th>
						<?php endif; ?>
						<?php if($not_grouped =='1'): ?>
					<th>Մեկնաբանություն</th>
					<th class="text-nowrap">Գույքի դիրք</th>
					<th class="text-nowrap">Գույքի վիճակ</th>
					<th>Ապրանքի դասավորվածություն</th>
					<th>Տեսականու առկայություն</th>
					<th>Խանութի վերաբերմունքը բրենդին և սպասարկմանը</th>
					<th>Վաճառքի դինամիկա</th>
					<th>Մարքեթինգի տրամադրման անհրաժեշտություն</th>
					<th class="text-nowrap">Ապրանքի ժամկետ</th>
					<th>Ապրանքի քանակությունը սառնարանում</th>
					<th>Ռադիուս</th>
						<?php endif; ?>					
                    <th style="width:150px;">Դիտել</th>
                  </tr>
                  </thead>
                  <tbody>				  
						<?php 					
							if(isset($datebeet) and $datebeet != ''):					
								if($not_grouped == '1'){
									$sql="SELECT *,
										visits.id AS ID,
										visits.manager_id AS MANAGHER_ID,
										visits.shop_id AS SHOP_ID,
										visits.comment AS visit_comment,
										shops.name  AS SHOP_NAME,
										shops.address AS SHOP_ADDRESS,
										D.district_name AS DISTRICT_NAME,
										RE.region_name AS REGION_NAME,
										ASE.name AS as_class_name,
										T.visit_id as TASK_IS_REGISTERED
									FROM visits 
									INNER JOIN shops on visits.shop_id = shops.shop_id
									LEFT JOIN district D ON D.id=shops.district
									LEFT JOIN tasks T ON T.visit_id=visits.id
									LEFT JOIN region RE ON RE.id = shops.region
									LEFT JOIN as_classifications ASE ON shops.as_classification_id = ASE.id
									LEFT JOIN (select visit_id,
										max(case when rate_id = 2  then rate_value end) guyqi_dirq,
										max(case when rate_id = 3 then rate_value end) guyqi_vijak,
										max(case when rate_id = 4 then rate_value end) apranqi_dasavorutyun,
										max(case when rate_id = 5 then rate_value end) tesakanu_arkayutyun,
										max(case when rate_id = 6 then rate_value end) xanuti_verabermunq,
										max(case when rate_id = 7 then rate_value end) vajarqi_dinamika,
										max(case when rate_id = 8 then rate_value end) marqetingi_anhrajeshtutyun,
										max(case when rate_id = 9 then rate_value end) apranqi_jamket,
										max(case when rate_id = 10 then rate_value end) apranqi_qanakutyun           
									from shop_evaluation
									group by visit_id) AS evaluation ON evaluation.visit_id = visits.id
									WHERE 1=1 $query_manager_id_selected 
										AND visits.date $query_date_range 
														$query_region_select 
														$query_district_select 
														$query_shop_select 
														ORDER by visits.id DESC";
									
														
								}else{
									$sql = "SELECT *,
												visits.id AS ID,
												visits.manager_id AS MANAGHER_ID,
												COUNT(visits.shop_id) AS visit_count ,
												shops.name  AS SHOP_NAME,
												visits.shop_id AS SHOP_ID,
												shops.address AS SHOP_ADDRESS,
												shops.shop_latitude,
												shops.shop_longitude,
												CE.count_evaluation,
												D.district_name AS DISTRICT_NAME,
												RE.region_name AS REGION_NAME,
												ASE.name AS as_class_name
											FROM visits 
												INNER JOIN shops on visits.shop_id = shops.shop_id
												LEFT JOIN district D ON D.id=shops.district
												LEFT JOIN region RE ON RE.id = shops.region
												LEFT JOIN (
													SELECT shop_id,count(DISTINCT visit_id) AS count_evaluation 
													FROM shop_evaluation 
													WHERE 1
														$evaluation_manager_where_claus 
														AND created_at $query_date_range 
												GROUP BY 
													visit_id
												) AS CE ON CE.shop_id = shops.id
												LEFT JOIN as_classifications ASE ON shops.as_classification_id = ASE.id
											WHERE 1
												$query_manager_id_selected 
												AND visits.date $query_date_range 
												$query_region_select 
												$query_district_select 
												$query_shop_select 
											GROUP by visits.shop_id 
											ORDER by visits.id DESC";						
								}

								$query = mysqli_query($con, $sql);
											
								while ($array_visits = mysqli_fetch_array($query)):
									$visit_id = $array_visits['ID'];
									$shop_id = $array_visits['SHOP_ID'];
									$shop_qr_id = $array_visits['qr_id'];
									$law_name = $array_visits['law_name'];
									$shop_name = $array_visits['SHOP_NAME'];
									$shop_address = $array_visits['SHOP_ADDRESS'];
									$hvhh = $array_visits['hvhh'];
									$manager_id = $array_visits['manager_id'];
									$date = $array_visits['date'];
									$comment = $array_visits['visit_comment'];
									$latitude = $array_visits['latitude'];
									$longitude = $array_visits['longitude'];
									$visit_count = $array_visits['visit_count'];
									$evaluation_count = $array_visits['count_evaluation'];
									$as_class_name = $array_visits['as_class_name'];
									$guyqi_dirq = $array_visits['guyqi_dirq'];
									$guyqi_vijak = $array_visits['guyqi_vijak'];
									$apranqi_dasavorutyun = $array_visits['apranqi_dasavorutyun'];
									$tesakanu_arkayutyun = $array_visits['tesakanu_arkayutyun'];
									$xanuti_verabermunq = $array_visits['xanuti_verabermunq'];
									$vajarqi_dinamika = $array_visits['vajarqi_dinamika'];
									$marqetingi_anhrajeshtutyun = $array_visits['marqetingi_anhrajeshtutyun'];
									$apranqi_jamket = $array_visits['apranqi_jamket'];
									$apranqi_qanakutyun = $array_visits['apranqi_qanakutyun'];
									$district_name=$array_visits['DISTRICT_NAME'];
									$region_name=$array_visits['REGION_NAME'];
									$TASK_IS_REGISTERED=$array_visits['TASK_IS_REGISTERED'];
									$MANAGHER_ID=$array_visits['MANAGHER_ID'];
									$shop_latitude = $array_visits['shop_latitude'];
									$shop_longitude = $array_visits['shop_longitude'];
									
									if(!empty($TASK_IS_REGISTERED) || empty($comment)){
										$disabled=' disabled ';
									}else{
										$disabled='';
									}

									if($active == 'on'){
										$active = 'Այո';
									}else{
										$active = 'Ոչ';
									}

								

									$query_manager = mysqli_query($con, "SELECT manager.login AS manager_login, client.law_name AS client_name from manager, client WHERE manager.id='$MANAGHER_ID' AND manager.client_id = client.id ");
									$array_manager = mysqli_fetch_array($query_manager);
									if($visit_count_est == ''){
										$visit_count_est = 0;
									}
									$visits_diff = $visit_count_est - $visit_count;
									if($visits_diff < 0){
										$visits_diff = $visits_diff * (-1);
										$plus = '+';
									}
									//$visits_diff = $visits_diff * (-1);
						?>				  
					<tr>				  
						<td><?php echo $visit_id; ?></td>
						<td class="word_break"><?php echo $shop_qr_id; ?></td>
						<td><?php echo $shop_name; ?></td>
						<td><?php echo $hvhh; ?></td>
						<td><?php echo $law_name; ?></td>
						<td><?php echo $shop_address; ?></td>
						<td><?php echo $region_name;  ?></td>
						<td><?php echo $district_name;  ?></td>
						<td><?php echo $array_manager['manager_login']; ?></td>
						<td><?php echo $as_class_name; ?></td>
						<td>
							<?php
								if($not_grouped == '1'){
									echo $date;
								}else{
									echo $start_date;
									echo " - ";
									echo $end_date;
								}
							?>
						</td>				 
				    		<?php if($not_grouped !='1'): ?>
						<td><?php echo $visit_count; ?></td>
						<td><?php echo $plus; echo $visits_diff; ?></td>
						<td><?php echo $evaluation_count;  ?></td>
				    		<?php endif; ?>				 
				 			<?php if($not_grouped =='1'): ?>
						<td><?php echo $comment; ?></td>
						<td><?php  echo (int)$guyqi_dirq   ;?></td>
						<td><?php  echo (int)$guyqi_vijak ;?></td>
						<td><?php  echo (int)$apranqi_dasavorutyun ;?></td>
						<td><?php  echo (int)$tesakanu_arkayutyun ;?></td>
						<td><?php  echo (int)$xanuti_verabermunq ;?></td>
						<td><?php  echo (int)$vajarqi_dinamika ;?></td>
						<td><?php  echo (int)$marqetingi_anhrajeshtutyun ;?></td>
						<td><?php  echo (int)$apranqi_jamket ;?></td>
						<td><?php  echo (int)$apranqi_qanakutyun ;?></td>
						<td>
							<?php 
								if($shop_latitude !='' and $not_grouped == '1'){
									$km = getDistanceBetweenPointsNew($latitude, $longitude, $shop_latitude, $shop_longitude, $unit = 'Km');
									$km2 = getDistanceBetweenPointsNew($latitude, $longitude, $shop_latitude, $shop_longitude, $unit = 'Km');
									if($_SESSION['role']!= '1' ){
										echo $km;
									}
									echo " ";
									$km = intval($km);
									if($km <= 100 or $km2 == 'NAN'){
										echo "<i class='fa fa-check' style='color:#28a745'>";
									}else{
										echo "<i class='fa fa-times' style='color:#bd2130'>";
									}
								}
							?>
						</td>
							<?php endif; ?>
                 		<td style="width:150px;">					
								<?php if($not_grouped =='1'): ?>
							<button visit_id="<?php echo $visit_id; ?>" manager_id="<?php echo $MANAGHER_ID ; ?>" task_text="<?php echo $shop_address.'->'.$shop_name.'->'.$comment  ; ?>" class="btn btn-secondary btn-sm add_task_from_comment" style="color:#fff" <?php echo $disabled ; ?> title="Ստեղծել առաջադրանք"><i  ><i class='fa fa-tasks'></i></button>
							<button style="width: 33px;" class="btn btn-primary btn-sm rounded-0 save_coordinates after_<?php echo $visit_id; ?>"  data-lat="<?php echo $latitude; ?>" data-long="<?php echo $longitude; ?>" data-curshop="<?php echo $shop_id; ?>" data-visitid="<?php echo $visit_id; ?>" title="Պահպանել կոորդինատները"><i class="fas fa-save"></i></button>					
							<a href="#"style="width: 33px;" data-toggle="modal" data-target="#map<?php echo $visit_id; ?>"  class="btn btn-warning btn-sm rounded-0 delete_client_button" title="Դիտել"><i class="fas fa-map-marker-alt"></i></a>								
							<!-- Modal -->
							<div class="modal fade" id="map<?php echo $visit_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">N<?php echo $visit_id; ?>այցի քարտեզը</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<iframe  width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $latitude; ?>,<?php echo $longitude; ?>&hl=es&z=14&amp;output=embed"></iframe>									
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
										</div>
									</div>
								</div>
							</div>				 
								<?php endif; ?>				        
							<form action="view_visit.php" method="GET" target="_blank" style="display:inline;">
								<input type="hidden" name="datebeet" value="<?php echo $datebeet; ?>">
								<input type="hidden" name="manager_select" value="<?php echo $MANAGHER_ID; ?>">
								<input type="hidden" name="client" value="<?php echo $curr_client_id; ?>">
								<input type="hidden" name="shop_id" value="<?php echo $shop_id;  ?>">
								<button type="submit" class="btn btn-success btn-sm rounded-0 delete_client_button" title="Դիտել"><i class="fa fa-eye"></i></button>
							</form>
				  		</td>
                  	</tr>                
							<?php endwhile; ?>
                 
				 
				 
				<?php 				
					if($not_visited == '1' AND $not_grouped !='1'){
						
						$not_visited_query_shop = mysqli_query($con, "SELECT * FROM shops where shops.shop_id not in (SELECT shop_id FROM visits WHERE visits.date $query_date_range) $query_manager_1 $query_region_select $query_district_select $query_shop_select ");

						
						//$not_visited_query_shop = mysqli_query($con, "SELECT shops.*, manager_to_shop.* FROM shops, manager_to_shop WHERE manager_to_shop.manager_id = '$manager_id_selected' $query_district_select AND shops.shop_id = manager_to_shop.shop_id");
						 						
						while($not_visited_array_shop = mysqli_fetch_array($not_visited_query_shop)){
							
							$not_visited_shop_id = $not_visited_array_shop['shop_id'];							
														
							$query_check_visit = mysqli_query($con, "SELECT * FROM visits WHERE manager_id='$manager_id_selected' AND shop_id = '$not_visited_shop_id' AND date $query_date_range ");
							
							if ($query_check_visit->num_rows == 0) {
								
							$query_shop = mysqli_query($con, "SELECT id, shop_id, qr_id, name, address, district FROM shops WHERE shop_id='$not_visited_shop_id' $query_district_select ");
							$array_shop = mysqli_fetch_array($query_shop);
							
							$shop_qr_id_not = $array_shop['qr_id'];
							$shop_qr_id_not_id = $array_shop['shop_id'];
							$shop_name_not = $array_shop['name'];
							$shop_address_not = $array_shop['address'];
							$shop_district_not = $array_shop['district'];
							
							$query_district_name = mysqli_query($con, "SELECT * FROM district WHERE id='$shop_district_not' ");
							$array_district_name = mysqli_fetch_array($query_district_name);
							
							$shop_district_not_name = $array_district_name['district_name'];
							
							$query_manager = mysqli_query($con, "SELECT manager.login AS manager_login, client.law_name AS client_name from manager, client WHERE manager.id='$manager_id_selected' AND manager.client_id = client.id ");
							$array_manager = mysqli_fetch_array($query_manager);
							$manager_login =$array_manager['manager_login'];
							$client_name = $array_manager['client_name'];
							
								echo "<tr class='table-danger'>
								
								<td>$shop_qr_id_not_id</td>
								<td class='word_break'>$shop_qr_id_not</td>
								<td>$shop_name_not</td>
								<td>$shop_address_not</td>
								<td>$shop_district_not_name</td>
								<td>$manager_login</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							
					
					</tr>";
							}
						}
					}
					
					endif;
				?>

				 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>QR համար</th>
					<th>Խանութի Անուն</th>
					<th>ՀՎՀՀ</th>
					<th>Իրվ․ անուն</th>
                    <th>Խանութի Հասցե</th>
					<th>Մարզ</th>
					<th>Շրջան</th>
					<th>Մենեջեր</th>
					<th>Ոլորտի անվանում</th>
					<th>Ժամանակ</th>

					<?php if($not_grouped !='1'): ?>
					
					<th>Այցի քանակ</th>
					<th>Տարբերություն</th>
					<th>Գնահատման քանակ</th>
					<?php endif; ?>

					<?php if($not_grouped =='1'): ?>
					<th>Մեկնաբանություն</th>
					<th>Ռադիուս</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<?php endif; ?>
                    <th style="min-width:170px;">Դիտել</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php 

include 'footer.php';

?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->

<!-- Export -->

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>


<script>

$('.add_task_from_comment').on('click', function(){
    const visit_id = $(this).attr('visit_id')
    const task_text = $(this).attr('task_text')
    const manager_id = $(this).attr('manager_id')

    $.ajax({
           type: "POST",
           url: "/actions.php?cmd=add_task_from_comment",
           data: {visit_id,task_text,manager_id}, 
           success: function(data)
           {
			   location.reload()

           }		   
         });
})

$( "#region" ).change(function() {
	  
	  $('#district option').remove();
	  var url = 'api/region_select.php';
	  var region = $('#region').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {region_select: region}, 
           success: function(data)
           {

			   $('#district').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});


$( "#district" ).change(function() {
	  var district = $('#district').val();
	  $('#shop option').remove();
	  var url = 'api/shop_select.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {district: district}, 
           success: function(data)
           {

			   $('#shop').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});

$(document).on('click','.save_coordinates', function(){
	
	var shop_id = $(this).data("curshop");
	var shop_lat = $(this).data("lat");
	var shop_long = $(this).data("long");
	var visitid = $(this).data("visitid");
	
	var url = '/api/save_coordinates.php';
		
    $.ajax({
           type: "POST",
           url: url,
           data: {
				shop_id: shop_id,
				shop_lat: shop_lat,
				shop_long: shop_long
		   }, 
           success: function(data)
			   {			  
				  $('.after_' + visitid).addClass("btn-success");

			   }
		   
         });
	
	});



$('#not_grouped').click(function() {
    if( $(this).is(':checked')) {
        $(".not_visited_check").hide();
    } else {
        $(".not_visited_check").show();
    }
}); 

 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });
 

//#statistics_form

	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	
    $.ajax({
           type: "POST",
           url: "api/add_shop.php",
           data: {shop_id:client_to_delete, action:'delete_cient'},
           success: function(data)
           {
               //alert(data); 
			   window.location.reload();
           }
		   
         });
});
	
	

  $(function () {
    $("#example1").DataTable({
        <?php if($not_grouped =='1'): ?>
        columnDefs: [{
            targets: [12,13,14,15,16,17,18,19,20],
            createdCell: function (td, cellData, rowData, row, col) {
                switch(cellData){
                    case '1':
                        $(td).html('<span class="fa fa-star checked_star"></span><span class="fa fa-star text-muted"></span><span class="fa fa-star text-muted"></span><span class="fa fa-star text-muted"></span><span class="fa fa-star text-muted"></span>')
                        break;
                    case '2':
                        $(td).html('<span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star text-muted"></span><span class="fa fa-star text-muted"></span><span class="fa fa-star text-muted"></span>')
                        break;
                    case '3':
                        $(td).html('<span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star text-muted"></span><span class="fa fa-star text-muted"></span>')
                        break;
                    case '4':
                        $(td).html('<span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star text-muted"></span>')
                        break;
                    case '5':
                        $(td).html('<span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span><span class="fa fa-star checked_star"></span>')
                        break;
                    default:
                        $(td).html('<span class="fa fa-star" style="color:	#dadada"></span><span class="fa fa-star"  style="color:	#dadada"></span><span class="fa fa-star"  style="color:	#dadada"></span><span class="fa fa-star"  style="color:	#dadada"></span><span class="fa fa-star"  style="color:	#dadada"></span>')
                }
            }
        }],
        <?php  endif ; ?>
		initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select style="max-width: 100px;"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
    
		
        dom: 'Bfrtip',
	    lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
  
		"scrollX": true,
		"autoWidth": true,
        "buttons": [
			
						{
                       extend: 'print',
                       exportOptions: {
                       columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                           }
                         },
                         {
                          extend: 'excel',
                          exportOptions: {
                          columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                         }
                       },
					   
					   'copy', 'pageLength',

			
			
        ],
		"language":{
					  "sEmptyTable": "Տվյալները բացակայում են",
					  "sProcessing": "Կատարվում է...",
					  "sInfoThousands":  ",",
					  "sLengthMenu": "Ցուցադրել արդյունքներ մեկ էջում _MENU_ ",
					  "sLoadingRecords": "Բեռնվում է ...",
					  "sZeroRecords": "Հարցմանը համապատասխանող արդյունքներ չկան",
					  "sInfo": "Ցուցադրված են _START_-ից _END_ արդյունքները ընդհանուր _TOTAL_-ից",
					  "sInfoEmpty": "Արդյունքներ գտնված չեն",
					  "sInfoFiltered": "(ֆիլտրվել է ընդհանուր _MAX_ արդյունքներից)",
					  "sInfoPostFix":  "",
					  "sSearch": "Փնտրել",
					  "oPaginate": {
						  "sFirst": "Առաջին էջ",
						  "sPrevious": "Նախորդ էջ",
						  "sNext": "Հաջորդ էջ",
						  "sLast": "Վերջին էջ"
					  },
					  "oAria": {
						  "sSortAscending":  ": ակտիվացրեք աճման կարգով դասավորելու համար",
						  "sSortDescending": ": ակտիվացրեք նվազման կարգով դասավորելու համար"
					  }
					}
		
		
		
		
    });



  });
  
    function draw_star(n){
        if(n== 0){
            return 0
        }
        let result=''
        for(i=1; i < 6; i++){
            if(i<= n){
                result += '<span class="fa fa-star checked_star"></span>';
            }else {
                result += '<span class="fa fa-star text-muted"></span>';
            }
        }
        return result
    }
</script>
</body>
</html>