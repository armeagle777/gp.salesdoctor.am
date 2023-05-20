<?php include 'header.php'; ?>
<?php include 'api/db.php'; 



?>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCVLpYzepN8MwjBUsqK7n6gCXpA6H6ntY8"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>GPS</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
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
			  
			  <form action="/map_shops.php" method="POST" id="shops">
					<h4 style="margin-bottom: 20px;">Խանութներ</h4>
					<div class="form-row">
				
				  <div class="form-group col-md-3">
					<label for="address">Մարզ</label>

						<select name="region_select" id="region" class="form-control">
							<option value="0"> Ընտրել </option>
								<?php 
									$query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
									while ($array_regions = mysqli_fetch_array($query_region)):
									$region_id = $array_regions['id'];
									$region_name = $array_regions['region_name'];
								?> 
								 
							<option value="<?php echo $region_id; ?>" <?php if($region_id_selected == $region_id){ echo "selected"; } ?>> <?php echo $region_name; ?></option>
					
							<?php endwhile; ?>
					
						</select>

				  </div>
				  
				  <div class="form-group col-md-2">
					<label for="district">Տարածք</label>
						
					<select name="district_select" id="district" class="form-control">

						<option>Ընտրել</option>
							<?php 
								$query_district = mysqli_query($con, "SELECT * FROM district WHERE region_id = '$region_id_selected' ORDER by id DESC");
								while ($array_district = mysqli_fetch_array($query_district)):
								$district_id = $array_district['id'];
								$district_name = $array_district['district_name'];
							?> 
							
							<option value="<?php echo $district_id; ?>" <?php if($district_id_selected == $district_id){ echo "selected"; } ?>> <?php echo $district_name; ?></option>
					
							<?php endwhile; ?>
					</select>
					
				  </div>
				  
				  <div class="form-group col-md-2">
					<label for="login">Մենեջեր</label>
					<select name="manager_select" id="static_manager" class="form-control">
					<option value="0"> Ընտրել </option>
						<?php 

							$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' ORDER by id DESC");

							while ($array_manager = mysqli_fetch_array($query_manager)):
							$manager_id = $array_manager['id'];
							$manager_login = $array_manager['login'];
						?> 
						 
						<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
						
						<?php endwhile; ?>
						
					</select>
				  </div>	
				  
				  <div class="form-group col-md-2">
					<label for="login">Հաշվարկ</label>
					<select name="worker_select" id="worker_select" class="form-control">
					<option value="0"> Ընտրել </option>
						<?php 

							$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' or user_role = '5' ORDER by id DESC");

							while ($array_manager = mysqli_fetch_array($query_manager)):
							$manager_id = $array_manager['id'];
							$manager_login = $array_manager['login'];
						?> 
						 
						<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
						
						<?php endwhile; ?>
						
					</select>
				  </div>
				  
				  <div class="form-group col-md-2">
				  <label for="login">Ցուցադրել</label>
						<button type="submit" name="submit_filtr" class="btn btn-success" style="display: block;">Ցուցադրել</submit>
				
				</div>
			  
						  
			   </div>
			  
			  	</form>		
			  
                <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                  <thead>
                  <tr>
                   <th class="select-filter">ID</th>
					<th class="select-filter">Անուն</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Տարածք</th>
					<th class="select-filter">Մարզ</th>                  </tr>
                  </thead>
                  <tbody id="shops_body">
				
				
				
                  </tbody>
                  <tfoot>
                  <tr>
                   <th class="select-filter">ID</th>
					<th class="select-filter">Անուն</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Տարածք</th>
					<th class="select-filter">Մարզ</th>


                  </tr>
                  </tfoot>
                </table>
				<div style="margin-top: 10px;"> <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox(this.checked);" /> Նշել բոլորը</div>
				
				
				
				
				
				
				<form action="/map_shops.php" id="orders"> 
						<h4 style="margin-bottom: 20px; margin-top: 30px;">Պատվերներ</h4>

				  <div class="form-row">
				  
				 <div class="form-group col-md-3">
                  <label>Ժամանակահատված</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation2" value="<?php echo $datebeet; ?>" name="datebeet">
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
				  
					  <div class="form-group col-md-2">
								<label for="login">Խումբ</label>
								<select name="group_id" id="group_id" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 
										$query_groups = mysqli_query($con, "SELECT * FROM pr_groups");
										while($groups_array = mysqli_fetch_array($query_groups)):
										$group_id = $groups_array['id'];
										$group_name = $groups_array['group_name'];
									?> 
									 
									<option value="<?php echo $group_id; ?>"  <?php if($group_selected == $group_id ) {echo "selected"; } ?> > <?php echo $group_name; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>
					  
					  
					  
					  
					  
					  
					  
					  
					  			  
			  
						<div class="form-group col-md-2">
							<label for="address">Մարզ</label>

								<select name="region2" id="region2" class="form-control">
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
					<label for="district2">Տարածք</label>
						
					<select name="district2" id="district2" class="form-control">
					
						<option>Ընտրել</option>
							
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
							<label for="login">Ցանց</label>
							<select name="network_select" id="network_select" class="form-control">
							<option value="0"> Ընտրել </option>
								<?php 

									$query_network = mysqli_query($con, "SELECT * FROM network ORDER by id DESC");

									while ($array_network = mysqli_fetch_array($query_network)):
									$network_id = $array_network['id'];
									$network_name = $array_network['network_name'];
								?> 
								 
								<option value="<?php echo $network_id; ?>"  <?php if($network_id == $selected_network ) {echo "selected"; } ?> > <?php echo $network_name; ?></option>
								
								<?php endwhile; ?>
								
							</select>
				  </div>
				  
				  <div class="form-group col-md-2">
							<label for="login">Վճ. տիպ</label>
							<select name="payment_type" id="payment_type" class="form-control">
							<option value="0"> Ընտրել </option>
								<?php 

									$query_payment_type = mysqli_query($con, "SELECT * FROM pr_payment_type ORDER by id DESC");

									while ($array_payment_type = mysqli_fetch_array($query_payment_type)):
									$payment_type_id = $array_payment_type['id'];
									$payment_type_name = $array_payment_type['payment_name'];
								?> 
								 
								<option value="<?php echo $payment_type_id; ?>"  <?php if($payment_type_id == $selected_payment_type ) {echo "selected"; } ?> > <?php echo $payment_type_name; ?></option>
								
								<?php endwhile; ?>
								
							</select>
				  </div>
		  
			
				  <div class="form-group col-md-2">
								<label for="login">Մենեջեր</label>
								<select name="manager_select2" id="manager_select2" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 

										$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' ORDER by id DESC");

										while ($array_manager = mysqli_fetch_array($query_manager)):
										$manager_id = $array_manager['id'];
										$manager_login = $array_manager['login'];
									?> 
									 
									<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
									
									<?php endwhile; ?>
									
								</select>
				  </div>	
				  
				  <div class="form-group col-md-2">
								<label for="login">Առաքիչ</label>
								<select name="courier_select" id="courier_select" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 

										$query_courier = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '5' ORDER by id DESC");

										while ($array_courier = mysqli_fetch_array($query_courier)):
										$courier_id = $array_courier['id'];
										$courier_login = $array_courier['login'];
									?> 
									 
									<option value="<?php echo $courier_id; ?>"  <?php if($courier_id_selected == $courier_id ) {echo "selected"; } ?> > <?php echo $courier_login; ?></option>
									
									<?php endwhile; ?>
									
								</select>
				  </div>

				  <div class="form-group col-md-2">
					<label for="login">Հաշվարկ</label>
					<select name="worker_select1" id="worker_select1" class="form-control">
					<option value="0"> Ընտրել </option>
						<?php 

							$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' or user_role = '5' ORDER by id DESC");

							while ($array_manager = mysqli_fetch_array($query_manager)):
							$manager_id = $array_manager['id'];
							$manager_login = $array_manager['login'];
						?> 
						 
						<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
						
						<?php endwhile; ?>
						
					</select>
			
					</div>
					
					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  <input type="hidden" name="order_type" value="<?php echo $order_type; ?>">
					  
					  
					
					</div>
				
				
				  </form>
			  
                <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                  <thead>
                  <tr>
                   <th class="select-filter">ID</th>
					<th class="select-filter">Անուն</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Տարածք</th>
					<th class="select-filter">Մարզ</th>     
					<th class="select-filter">Մենեջեր</th>     
					<th class="select-filter">Առաքիչ</th>     

					</tr>
                  </thead>
                  <tbody id="orders_body">
				
				
				
                  </tbody>
                  <tfoot>
                  <tr>
                   <th class="select-filter">ID</th>
					<th class="select-filter">Անուն</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Տարածք</th>
					<th class="select-filter">Մարզ</th>
					<th class="select-filter">Մենեջեր</th>     
					<th class="select-filter">Առաքիչ</th>     


                  </tr>
                  </tfoot>
                </table>
				<div style="margin-top: 10px;"> <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox2(this.checked);" /> Նշել բոլորը</div>
		


			  
				 <form action="/map_shops.php" id="visits" style="margin-top: 30px;"> 
				 <h4 style="margin-bottom: 20px;">Այցեր</h4>
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
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
				  
	
							  <div class="form-group col-md-2">
					<label for="address">Մարզ</label>

						<select name="region_select" id="region1" class="form-control">
							<option value="0"> Ընտրել </option>
								<?php 
									$query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
									while ($array_regions = mysqli_fetch_array($query_region)):
									$region_id = $array_regions['id'];
									$region_name = $array_regions['region_name'];
								?> 
								 
							<option value="<?php echo $region_id; ?>" <?php if($region_id_selected == $region_id){ echo "selected"; } ?>> <?php echo $region_name; ?></option>
					
							<?php endwhile; ?>
					
						</select>

				  </div>
				  
				  <div class="form-group col-md-2">
					<label for="district">Տարածք</label>
						
					<select name="district_select" id="district1" class="form-control">

						<option>Ընտրել</option>
							<?php 
								$query_district = mysqli_query($con, "SELECT * FROM district WHERE region_id = '$region_id_selected' ORDER by id DESC");
								while ($array_district = mysqli_fetch_array($query_district)):
								$district_id = $array_district['id'];
								$district_name = $array_district['district_name'];
							?> 
							
							<option value="<?php echo $district_id; ?>" <?php if($district_id_selected == $district_id){ echo "selected"; } ?>> <?php echo $district_name; ?></option>
					
							<?php endwhile; ?>
					</select>
					
				  </div>
				  
				  <div class="form-group col-md-2">
					<label for="login">Աշխատակից</label>
					<select name="manager_select" id="static_manager1" class="form-control">
					<option value="0"> Ընտրել </option>
						<?php 

							$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' or user_role = '5' ORDER by id DESC");

							while ($array_manager = mysqli_fetch_array($query_manager)):
							$manager_id = $array_manager['id'];
							$manager_login = $array_manager['login'];
						?> 
						 
						<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
						
						<?php endwhile; ?>
						
					</select>
			
					</div>
				
				
				
					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
				
				  </form>


                <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                  <thead>
                  <tr>
                   <th class="select-filter">ID</th>
					<th class="select-filter">Անուն</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Տարածք</th>
					<th class="select-filter">Մարզ</th>
					<th class="select-filter">Մենեջեր</th>

					</tr>
                  </thead>
                  <tbody id="visits_body">
				
				
				
                  </tbody>
                  <tfoot>
                  <tr>
                   <th class="select-filter">ID</th>
					<th class="select-filter">Անուն</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Տարածք</th>
					<th class="select-filter">Մարզ</th>
					<th class="select-filter">Մենեջեր</th>



                  </tr>
                  </tfoot>
                </table>
			<div class="form-row col-md-12">	
				<div style="margin-top: 10px; margin-bottom: 10px;"> <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox1(this.checked);" /> Նշել բոլորը <br></div>
			</div>

			<div class="form-row col-md-12" style="margin-top: 20px;">
			
			  <div class="form-group col-md-6">
				
		
				<div class="form-group col-md-12">
					<input type="button" id="calc_shops" value="Խանութների հաշվարկ">
					<input type="button" id="calc_orders" value="Պատվերների հաշվարկ">
			

				</div>
						
		
				<div class="form-group col-md-12">
				
					<div id="shops_response"></div>	
					---------------------------
					<div id="shops_response1"></div>	
					<div id="shops_map_response"></div>	
					<div id="shops_map_response1"></div>	
					<div id="shops_km_response"></div>	
			

				</div>
		
			  </div>
			  
			 
			  <div class="form-group col-md-6">
				
		
				<div class="form-group col-md-12">
					<input type="button" id="calc_visits" value="Այցերի հաշվարկ">
			

				</div>
						
		
				<div class="form-group col-md-12">
				
					<div id="visits_response"></div>	
					---------------------------
					<div id="visits_response1"></div>	
					<div id="visits_map_response"></div>	
					<div id="visits_map_response1"></div>	
					<div id="visits_km_response"></div>	
			

				</div>
		
			  </div>
			  
			 
			
			</div>	  




			<div class="form-row col-md-12" style="margin-top: 20px;">
			
				<div class="form-group col-md-6">
 
				  <div class="form-group col-md-4">
					<label for="map_fake_km">Նախնական կմ</label>
										
					<input type="text" class="form-control" name="map_fake_km" id="map_fake_km" disabled>  <span class="">Տարբերություն՝ </span><span class="calc_tarb"> </span>
			
				  </div> 


				  <div class="form-group col-md-12">
					<label for="map_comment">Մեկնաբանություն</label>
										
					<input type="text" class="form-control" name="map_comment" id="map_comment"> 
			
				  </div>

				  <div class="form-group col-md-6">
					<label for="map_comment"></label>
										
					<input type="button" class="btn btn-primary" id="get_calc_km" value="Հաշվարկել">

					<input type="button" class="btn btn-success" id="save_calc_km" value="Պահպանել" style="margin-left: 10px;"> 

			
				  </div>

				  <div class="form-group col-md-12">
					
					<span>Գումար՝ </span> <span class="calc_km_result"> </span>
					
				  </div>

				<div id="succes_result" style="display: none; color: #0a9f00;">Պահպանված է:</div>



			  </div>
			 
			  <div class="form-group col-md-6">
				
		 
				  <div class="form-group col-md-4">
					<label for="map_real_km">Փաստացի կմ</label>
										
					<input type="text" class="form-control" name="map_real_km" id="map_real_km"> 
			
				  </div>
				
		
		
			  </div>
			  
			 
			
			</div>	  





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
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->

<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>




<script>



$('#save_calc_km').click(function() {

	var map_fake_km = $('#map_fake_km').val();
	var map_real_km = $('#map_real_km').val();
	var reservation = $('#reservation').val();
	var map_km_cost = $('.calc_km_result').html();
	var map_km_dif = $('.calc_tarb').html();
	var manager_select = $('#static_manager1').val();
	var map_comment = $('#map_comment').val();

    var url = 'api/map.php';
	
$.ajax({
	type: "POST",
	url: url,
    data:  {
			map_fake_km: map_fake_km,
			map_real_km: map_real_km,
			reservation: reservation,
			map_km_cost: map_km_cost,
			map_km_dif: map_km_dif,
			manager_select: manager_select,
			map_comment: map_comment,
			action: 'save_calc_km'
			}, 
    success: function(data) {
   
			$('#succes_result').css('display', 'block');
	//		$('.calc_tarb').html(get_data[1]);
	//	$('.calc_km_result').html(get_data[0]);
   
   
   
    }
});


});


$('#get_calc_km').click(function() {


	$('#succes_result').css('display', 'none');

	var map_fake_km = $('#map_fake_km').val();
	var map_real_km = $('#map_real_km').val();

	var manager_select = $('#static_manager1').val();

    var url = 'api/map.php';
	
$.ajax({
	type: "POST",
	url: url,
    data:  {
			map_fake_km: map_fake_km,
			map_real_km: map_real_km,
			manager_select: manager_select,
			action: 'get_calc_km'
			}, 
    success: function(data) {
   
   
		var get_data = JSON.parse(data);
		$('.calc_tarb').html(get_data[1]);
		$('.calc_km_result').html(get_data[0]);
   
   
   
    }
});


});





$(document).on('submit','#orders', function(e){

    e.preventDefault(); 
	
	var reservation = $('#reservation2').val();
	var region_select = $('#region2').val();
	var district_select = $('#district2').val();
	var manager_select = $('#static_manager2').val();
	var group_id = $('#group_id').val();
	var shop = $('#shop').val();
	var network_select = $('#network_select').val();
	var payment_type = $('#payment_type').val();
	var courier_select = $('#courier_select').val();
	var worker_select = $('#worker_select1').val();
	
	if (worker_select == '0'){
		$('#worker_select1').addClass('border border-danger');
		return false;
	}else{
		$('#worker_select1').removeClass('border border-danger');
	}
	
	var url = '/api/map.php';
		
    $.ajax({
           type: "POST",
           url: url,
           data: {
			    action: 'request_orders',
				reservation: reservation,
				region_select: region_select,
				district_select: district_select,
				manager_select: manager_select,
				group_id: group_id,
				shop: shop,
				network_select: network_select,
				payment_type: payment_type,
				courier_select: courier_select,
				worker_select: worker_select
				
		   }, 
		 
           success: function(data)

           {
				$('#orders_body').html(data);		

           }
		   
         });
});




$('#calc_shops').click(function() {
		$('#shops_response').html("");
		$('#shops_response1').html("");
		$('#shops_map_response').html("");
		$('#shops_map_response1').html("");
		$('#map_fake_km').val("");


	var manager_select = $('#worker_select').val();
	var checks = [];
	$('.ch_shops:checked').each(function(i, e) {
		checks.push($(this).val());
	});

    var url = 'api/map.php';
	
$.ajax({
	type: "POST",
	url: url,
    data:  {
			'checks': checks.join(),
			manager_select: manager_select,
			action: 'request_shops',
			action1: 'shops'
			}, 
    success: function(data) {
   
   
		var get_data = JSON.parse(data);
		$('#shops_response').html(get_data[1]);
		$('#shops_response1').html(get_data[3]);
		$('#shops_map_response').html(get_data[2]);
		$('#shops_map_response1').html(get_data[4]);
		$('#map_fake_km').val(get_data[0]);
   
   
   
    }
});


});

$('#calc_orders').click(function() {
		$('#shops_response').html("");
		$('#shops_response1').html("");
		$('#shops_map_response').html("");
		$('#shops_map_response1').html("");
		$('#map_fake_km').val("");


	var manager_select = $('#static_manager').val();
	var worker_select = $('#worker_select1').val();
	
	if (worker_select == '0'){
		$('#worker_select').addClass('border border-danger');
		return false;
	}else{
		$('#worker_select').removeClass('border border-danger');
	}
	
	var checks = [];
	$('.ch_orders:checked').each(function(i, e) {
		checks.push($(this).val());
	});

    var url = 'api/map.php';
	
$.ajax({
	type: "POST",
	url: url,
    data:  {
			'checks': checks.join(),
			manager_select: manager_select,
			worker_select: worker_select,
			action: 'request_shops',
			action1: 'shops'
			}, 
    success: function(data) {
   
   
		var get_data = JSON.parse(data);
		$('#shops_response').html(get_data[1]);
		$('#shops_response1').html(get_data[3]);
		$('#shops_map_response').html(get_data[2]);
		$('#shops_map_response1').html(get_data[4]);
		$('#map_fake_km').val(get_data[0]);
   
   
   
    }
});


});


$('#calc_visits').click(function() {
		$('#visits_response').html("");
		$('#visits_response1').html("");
		$('#visits_map_response').html("");
		$('#visits_map_response1').html("");
		$('#map_real_km').val("");


	var manager_select = $('#static_manager1').val();
	var checks = [];
	$('.ch_visits:checked').each(function(i, e) {
		checks.push($(this).val());
	});

    var url = 'api/map.php';
	
$.ajax({
	type: "POST",
	url: url,
    data:  {
			'checks': checks.join(),
			manager_select: manager_select,
			action: 'request_shops',
			action1: 'visits'
			}, 
    success: function(data) {
   
   
		var get_data = JSON.parse(data);
		$('#visits_response').html(get_data[1]);
		$('#visits_response1').html(get_data[3]);
		$('#visits_map_response').html(get_data[2]);
		$('#visits_map_response1').html(get_data[4]);
		$('#map_real_km').val(get_data[0]);
   
   
   
    }
});


});



 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });
 
 $('#reservation2').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });
 
 
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
$( "#region1" ).change(function() {
	  
	  $('#district1 option').remove();
	  var url = 'api/region_select.php';
	  var region = $('#region1').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {region_select: region}, 
           success: function(data)
           {

			   $('#district1').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});

$( "#region2" ).change(function() {
	  
	  $('#district2 option').remove();
	  var url = 'api/region_select.php';
	  var region = $('#region2').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {region_select: region}, 
           success: function(data)
           {

			   $('#district2').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});

$( "#district2" ).change(function() {
	  var district = $('#district2').val();
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





$(document).on('submit','#shops', function(e){

    e.preventDefault(); 
	
	var region_select = $('#region').val();
	var district_select = $('#district').val();
	var manager_select = $('#static_manager').val();
	var worker_select = $('#worker_select').val();
	
	if (worker_select == '0'){
		$('#worker_select').addClass('border border-danger');
		return false;
	}else{
		$('#worker_select').removeClass('border border-danger');
	}
	
	var url = '/api/map.php';
		
    $.ajax({
           type: "POST",
           url: url,
           data: {
			    action: 'request_shop',
				region_select: region_select,
				district_select: district_select,
				manager_select: manager_select,
				worker_select: worker_select
				
		   }, 
		 
           success: function(data)

           {
				$('#shops_body').html(data);

           }
		   
         });
});

$(document).on('submit','#visits', function(e){

    e.preventDefault(); 
	
	var reservation = $('#reservation').val();
	var region_select1 = $('#region1').val();
	var district_select1 = $('#district1').val();
	var manager_select1 = $('#static_manager1').val();
	
	var url = '/api/map.php';
		
    $.ajax({
           type: "POST",
           url: url,
           data: {
			    action: 'request_visit',
				reservation: reservation,
				region_select1: region_select1,
				district_select1: district_select1,
				manager_select1: manager_select1
		   }, 
		 
           success: function(data)

           {
				$('#visits_body').html(data);		

           }
		   
         });
});

	function check_uncheck_checkbox(isChecked) {
		if(isChecked) {
			$('.ch_shops').each(function() { 
				this.checked = true; 
			});
		} else {
			$('.ch_shops').each(function() {
				this.checked = false;
			});
		}
	}
	
	function check_uncheck_checkbox1(isChecked) {
		if(isChecked) {
			$('.ch_visits').each(function() { 
				this.checked = true; 
			});
		} else {
			$('.ch_visits').each(function() {
				this.checked = false;
			});
		}
	}
		
	function check_uncheck_checkbox2(isChecked) {
		if(isChecked) {
			$('.ch_orders').each(function() { 
				this.checked = true; 
			});
		} else {
			$('.ch_orders').each(function() {
				this.checked = false;
			});
		}
	}
	

</script>
</body>
</html>
