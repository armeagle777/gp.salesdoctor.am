<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$shop_id =  mysqli_real_escape_string($con, $_GET['shop_id']);
	$qr_id =  mysqli_real_escape_string($con, $_GET['qr_id']);
	if($action == 'edit'){		
		$query_data_shop = mysqli_query($con, "SELECT * FROM shops WHERE shop_id='$shop_id'");
		$array_shops = mysqli_fetch_array($query_data_shop);
		$shop_id = $array_shops['shop_id'];
		$filter_n = $array_shops['filter_n'];
		$qr_id = $array_shops['qr_id'];
		$name = $array_shops['name'];
		$address = $array_shops['address'];
		$district = $array_shops['district'];
		$region = $array_shops['region'];
		$network = $array_shops['network'];
		$comment = $array_shops['comment'];
		$stend_count = $array_shops['stend_count'];
		$stend_summ = $array_shops['stend_summ'];
		$law_name = $array_shops['law_name'];
		$law_address = $array_shops['law_address'];
		$hvhh = $array_shops['hvhh'];
		$phone = $array_shops['phone'];
		$active = $array_shops['active'];
		$latitude = $array_shops['shop_latitude'];
		$longitude = $array_shops['shop_longitude'];
		$discount = $array_shops['discount'];
		$limit_cash = $array_shops['limit_cash'];
		$limit_cash_ha = $array_shops['limit_cash_ha'];
		$limit_debt = $array_shops['limit_debt'];
		$limit_debt_ha = $array_shops['limit_debt_ha'];
		$limit_credit = $array_shops['limit_credit'];
		$limit_credit_ha = $array_shops['limit_credit_ha'];
		$static_manager = $array_shops['static_manager'];
		$courier = $array_shops['courier_id'];
		$owner_name = $array_shops['owner_name'];
		$owner_tel = $array_shops['owner_tel'];
		
		$as_class = $array_shops['as_classification_id'];
		$marketing_payment = $array_shops['marketing_payment'];
		$property_1 = $array_shops['property_1'];
		$property_2 = $array_shops['property_2'];
		
		$hasDebt = $array_shops['hasDebt'];
	}
	
	if($action == 'add'){		
		$query_data_shop = mysqli_query($con, "SELECT * FROM shops ORDER BY id DESC LIMIT 1 ");
		$array_shops = mysqli_fetch_array($query_data_shop);
		$last_shop_id = intval($array_shops['id']) + 1;
	}
	
?>
<style>
    .chosen-container, .chosen-container-single,.chosen-single{
        height: 37px!important;  
        width:100%;
    }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
			<?php 
			if($action == 'add'){
				echo "Ավելացնել խանութ";
			}elseif($action == 'edit'){
				echo "Խմբագրել խանութ";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/shops.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
				<div class="alert alert-success alert-dismissible fade show" style="display: none;" role="alert" id="success_message">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				 

				</div>


              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
			   
									<form id="add_partner" action="api/add_shop.php">
										<div class="form-row">
											<div class="form-group col-md-1">
												<label for="shop_id">Հ\Հ</label>
												<input type="text" class="form-control" id="shop_id" name="shop_id" placeholder="Հ\Հ" value="<?php echo $shop_id; echo $last_shop_id; ?>">
											</div>
											<div class="form-group col-md-1">
												<label for="filter_n">Հերթական N</label>
												<input type="text" class="form-control" id="filter_n" name="filter_n" placeholder="Հերթական N" value="<?php echo $filter_n; ?>">
											</div>
											<div class="form-group col-md-1">
												<label for="discount">Զեղչ %</label>
												<input type="text" class="form-control" id="discount" name="discount" placeholder="Զեղչ" value="<?php echo $discount; ?>">
											</div>
											<div class="form-group col-md-3">
												<label for="qr_id">QR համար</label>
												<input readonly type="text" class="form-control" id="qr_id" name="qr_id" value="<?php echo $qr_id; ?>"  placeholder="QR համար">
											</div>
											<!-- <div class="form-group col-md-2">
												<label for="property_1">Գույք 1</label>
												<select id="property_1" name="property_1" class='form-control'>
													<option value='0'>Ընտրել</option>
													<?php
														$sql="SELECT id AS property_1_id, property_1 AS property_1_name FROM pr_property1";
														$query_property_1 = mysqli_query($con,$sql);
														while($row = mysqli_fetch_array($query_property_1)):
															extract($row)  ;
														?>
															<option value="<?php echo $property_1_id; ?>"  <?php if($property_1_id==$property_1){ echo " selected"; } ?> ><?php echo $property_1_name ?></option>
														<?php endwhile; ?>
												</select>
											</div> -->
											<!-- <div class="form-group col-md-2">
												<label for="property_2">Գույք 2</label>
												<select id="property_2" name="property_2" class='form-control'>
													<option value='0'>Ընտրել</option>
													<?php
														$sql="SELECT id AS property_2_id, property_2 AS property_2_name FROM pr_property2";
														$query_property_2 = mysqli_query($con,$sql);
														while($row = mysqli_fetch_array($query_property_2)):
															extract($row)  ;
														?>
															<option value="<?php echo $property_2_id; ?>"  <?php if($property_2_id==$property_2){ echo " selected"; } ?> ><?php echo $property_2_name ?></option>
														<?php endwhile; ?>
												</select>
											</div>						   -->
											<div class="form-group col-md-6">
												<label for="network">Ցանց</label>							
												<select name="network" class="form-control">
													<option value="0"> Ընտրել </option>
													<?php 
														$query_network = mysqli_query($con, "SELECT * FROM network ORDER by id DESC");
														while ($array_networks = mysqli_fetch_array($query_network)):
														$network_id = $array_networks['id'];
														$network_name = $array_networks['network_name'];
													?> 											
														<option value="<?php echo $network_id; ?>" <?php if($network == $network_id ){ echo "selected"; } ?>> <?php echo $network_name; ?></option>							
													<?php endwhile; ?>							
												</select>
											</div>
										</div>

										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="latitude">Կոորդինատ 1 (Latitude)</label>
												<input type="text" class="form-control" id="latitude" name="latitude" placeholder="Կոորդինատ 1 (Latitude)" value="<?php echo $latitude; ?>">
											</div>
											<div class="form-group col-md-6">
												<label for="longitude">Կոորդինատ 2 (Longitude)</label>
												<input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $longitude; ?>"  placeholder="Կոորդինատ 2 (Longitude)">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="name">Անուն</label>
												<input type="text" class="form-control" id="name" name="name" placeholder="Անուն" value="<?php echo $name; ?>">
											</div>
											<div class="form-group col-md-6">
												<label for="address">Հասցե</label>
												<input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>"  placeholder="Հասցե">
											</div>
										</div>			   
										<div class="form-row">						
											<div class="form-group col-md-6">
												<label for="address">Մարզ</label>
												<select name="region" id="region" class="form-control">
													<option value="0"> Ընտրել </option>
														<?php 
															$query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
															while ($array_regions = mysqli_fetch_array($query_region)):
															$region_id = $array_regions['id'];
															$region_name = $array_regions['region_name'];
														?> 										 
															<option value="<?php echo $region_id; ?>" <?php if($region == $region_id ){ echo "selected"; } ?>> <?php echo $region_name; ?></option>							
														<?php endwhile; ?>							
												</select>
											</div>
											<div class="form-group col-md-6">
												<label for="district">Տարածք</label>						
												<select name="district" id="district" class="form-control">
													<?php
														if($action == 'edit'): 
															$query_district = mysqli_query($con, "SELECT * FROM district WHERE region_id = '$region' ORDER by id DESC");
															while ($array_districts = mysqli_fetch_array($query_district)):
															$district_id = $array_districts['id'];
															$district_name = $array_districts['district_name'];
													?> 							
														<option value="<?php echo $district_id; ?>" <?php if($district == $district_id ){ echo "selected"; } ?>> <?php echo $district_name; ?></option>							
														<?php endwhile; ?>
													<?php else: ?>
														<option>Ընտրել</option>
													<?php endif; ?>					
												</select>					
											</div>
											<!--	<div class="form-group col-md-6">
												<label for="name">Տարածք</label>


													<select name="district" class="form-control">
														<option value="0"> Ընտրել </option>
															<?php 
																$query_district = mysqli_query($con, "SELECT * FROM district ORDER by id DESC");
																while ($array_districts = mysqli_fetch_array($query_district)):
																$district_id = $array_districts['id'];
																$district_name = $array_districts['district_name'];
															?> 
															
														<option value="<?php echo $district_id; ?>" <?php if($district == $district_id ){ echo "selected"; } ?>> <?php echo $district_name; ?></option>
												
														<?php endwhile; ?>
												
													</select>
											</div> -->
						  				</div>			   
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="comment">Մեկնաբանություն</label>
												<input type="text" class="form-control" id="comment" name="comment" placeholder="Մեկնաբանություն" value="<?php echo $comment; ?>">
											</div>
											<div class="form-group col-md-6">
												<label for="stend_count">Ստենդի քանակ</label>
												<input type="text" class="form-control" id="stend_count" name="stend_count" value="<?php echo $stend_count; ?>"  placeholder="Ստենդի քանակ">
											</div>
										</div>			   
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="stend_summ">Ստենդի գումար</label>
												<input type="text" class="form-control" id="stend_summ" name="stend_summ" placeholder="Ստենդի գումար" value="<?php echo $stend_summ; ?>">
											</div>
											<div class="form-group col-md-6">
												<label for="law_name">Իր. Անուն</label>
												<input type="text" class="form-control" id="law_name" name="law_name" value="<?php echo $law_name; ?>"  placeholder="Իր. Անուն">
											</div>
										</div>			   			   
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="law_address">Իր. հասցե</label>
												<input type="text" class="form-control" id="law_address" name="law_address" placeholder="Իր. հասցե" value="<?php echo $law_address; ?>">
											</div>
											<div class="form-group col-md-6">
												<label for="hvhh">ՀՎՀՀ</label>
												<input type="text" class="form-control" id="hvhh" name="hvhh" value="<?php echo $hvhh; ?>"  placeholder="ՀՎՀՀ">
											</div>
										</div>			   
										<div class="form-row">
											<div class="form-group col-md-4">
												<label for="phone">Հեռախոս</label>
												<input type="text" class="form-control" id="phone" name="phone" placeholder="Հեռախոս" value="<?php echo $phone; ?>">
											</div>
											<div class="form-group col-md-4">
												<label for="login">Մենեջեր</label>
												<select name="static_manager" id="static_manager" class="form-control">
												<option value="0"> Ընտրել </option>
													<?php 

														$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' ORDER by id DESC");

														while ($array_manager = mysqli_fetch_array($query_manager)):
														$manager_id = $array_manager['id'];
														$manager_login = $array_manager['login'];
													?> 									 
													<option value="<?php echo $manager_id; ?>"  <?php if($static_manager == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>									
													<?php endwhile; ?>									
												</select>
											</div>
											<div class="form-group col-md-4">
												<label for="courier">Առաքիչ</label>
												<select name="courier" id="courier" class="form-control">
													<option value="0"> Ընտրել </option>
													<?php 

														$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '5' ORDER by id DESC");

														while ($array_manager = mysqli_fetch_array($query_manager)):
														$courier_id = $array_manager['id'];
														$courier_name = $array_manager['name'];
													?> 									 
													<option value="<?php echo $courier_id; ?>"  <?php if($courier == $courier_id ) {echo "selected"; } ?> > <?php echo $courier_name; ?></option>									
													<?php endwhile; ?>									
												</select>
											</div>
										</div>			   
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="owner_name">Տնօրենի անուն</label>
												<input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Տնօրենի անուն" value="<?php echo $owner_name; ?>">
											</div>
											<div class="form-group col-md-6">							
												<label for="owner_tel">Տնօրենի հեռախոս</label>
												<input type="text" class="form-control" id="owner_tel" name="owner_tel" placeholder="Տնօրենի անուն" value="<?php echo $owner_tel; ?>">
											</div>
										</div>
										<div class="form-row">				    
											<div class="form-group col-md-6">
												<label for="as_class">Ոլորտի անվանում</label>
												<select id="as_class" name="as_class" class='form-control'>
													<option value='0'>Ընտրել</option>
													<?php
														$sql="SELECT id AS as_class_id, name AS as_class_name FROM as_classifications";
														$query_as_class = mysqli_query($con,$sql);
														while($row = mysqli_fetch_array($query_as_class)):
															extract($row)  ;
														?>
															<option value="<?php echo $as_class_id; ?>"  <?php if($as_class_id==$as_class){ echo " selected"; } ?> ><?php echo $as_class_name ?></option>
														<?php endwhile; ?>
												</select>
											</div>
											<div class="form-group col-md-6">
												<label for="marketing_payment">Մարքետինգային վճարի չափ</label>
												<input type="number" class="form-control" id="marketing_payment" name="marketing_payment" placeholder="Մարքեթինգային վճար" value="<?php echo  $marketing_payment; ?>"/> 
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="hasDebt">Մարքետինգային վճար</label>
												<input value='on' type="checkbox" class="active" id="hasDebt" name="hasDebt" <?php if($hasDebt=='1'){echo "checked";} ?>>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="active">Ակտիվ</label>
												<input type="checkbox" class="active" id="active" name="active" <?php if($active=='on'){echo "checked";} ?>>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-2">
												<label for="phone">Լիմիտ կանխիկ</label>
												<input type="text" class="form-control" id="limit_cash" name="limit_cash" placeholder="" value="<?php echo $limit_cash; ?>">
											</div>
											<div class="form-group col-md-2">
												<label for="phone">Լիմիտ կանխիկ Հ/Ա</label>
												<input type="text" class="form-control" id="limit_cash_ha" name="limit_cash_ha" placeholder="" value="<?php echo $limit_cash_ha; ?>">
											</div>
											<div class="form-group col-md-2">
												<label for="phone">Լիմիտ պարտք</label>
												<input type="text" class="form-control" id="limit_debt" name="limit_debt" placeholder="" value="<?php echo $limit_debt; ?>">
											</div>
											<div class="form-group col-md-2">
												<label for="phone">Լիմիտ պարտք Հ/Ա</label>
												<input type="text" class="form-control" id="limit_debt_ha" name="limit_debt_ha" placeholder="" value="<?php echo $limit_debt_ha; ?>">
											</div>
											<div class="form-group col-md-2">
												<label for="phone">Լիմիտ կրեդիտ</label>
												<input type="text" class="form-control" id="limit_credit" name="limit_credit" placeholder="" value="<?php echo $limit_credit; ?>">
											</div>
											<div class="form-group col-md-2">
												<label for="phone">Լիմիտ կրեդիտ Հ/Ա</label>
												<input type="text" class="form-control" id="limit_credit_ha" name="limit_credit_ha" placeholder="" value="<?php echo $limit_credit_ha; ?>">
											</div>
										</div>   
										<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">			
										<input type="hidden" name="manager_id" id="manager_id" value="<?php echo $_GET['manager_id']; ?>">			
										<?php 
											if($action == 'add'):
										?>
											<button type="submit" class="btn btn-primary">Ավելացնել</button>
										<?php else: ?> 			
											<button type="submit" class="btn btn-primary">Թարմացնել</button>
										<?php endif; ?>
									</form>
	   
			   
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
  
 <!-- Button trigger modal -->
<button type="button" class="btn btn-primary modal_answere" data-toggle="modal" data-target="#modal_answere" style="display:none;">
</button>

<!-- Modal -->
<div class="modal fade" id="modal_answere" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p class="success_message"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <a href="/dashboard.php" class="btn btn-primary">Գլխավոր էջ</a>
        <a href="/action_shops.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
      </div>
    </div>
  </div>
</div> 
  
  
  
  
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
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->

<!-- Chosen script  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
        
<script>
$("#property_1").chosen()
$("#property_2").chosen()
$("#as_class").chosen()

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



$("#add_partner").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');
	var shop_id = $('#shop_id').val();
	var qr_id = $('#qr_id').val();
	var name = $('#name').val();
	var address = $('#address').val();
	var region = $('#region').val();
	var district = $('#district').val();
	var static_manager = $('#static_manager').val();
	
	// if (qr_id == ''){
	// 	$('#qr_id').addClass('border border-danger');
	// 	return false;
	// }else{
	// 	$('#qr_id').removeClass('border border-danger');
	// }
	
	if (name == ''){
		$('#name').addClass('border border-danger');
		return false;
	}else{
		$('#name').removeClass('border border-danger');
	}
	
	
	if (address == ''){
		$('#address').addClass('border border-danger');
		return false;
	}else{
		$('#address').removeClass('border border-danger');
	}

	if (region == '0'){
		$('#region').addClass('border border-danger');
		return false;
	}else{
		$('#region').removeClass('border border-danger');
	}
	
	if (district == '0'){
		$('#district').addClass('border border-danger');
		return false;
	}else{
		$('#district').removeClass('border border-danger');
	}
	
	if (static_manager == '0'){
		$('#static_manager').addClass('border border-danger');
		return false;
	}else{
		$('#static_manager').removeClass('border border-danger');
	}
	
	if (shop_id == ''){
		$('#shop_id').addClass('border border-danger');
		return false;
	}else{
		$('#shop_id').removeClass('border border-danger');
	}
	
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {
			   $('#shop_id').removeClass('border border-danger');
			   $('#qr_id').removeClass('border border-danger');
			   
			   window.location.replace("/shops.php");

			  // $('.alert').show()
			  

           }
		   
         });
});
   
</script>
</body>
</html>
