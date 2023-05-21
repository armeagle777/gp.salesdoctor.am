<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php
	$curr_client_id = mysqli_real_escape_string($con, $_GET['client']);
	$not_photo = mysqli_real_escape_string($con, $_GET['not_photo']);
	$visit_count_est = mysqli_real_escape_string($con, $_GET['visit_count']);
	$selected_region = mysqli_real_escape_string($con, $_GET['region']);
	$selected_district = mysqli_real_escape_string($con, $_GET['district']);
	$selected_shop = mysqli_real_escape_string($con, $_GET['shop']);
	$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
	$not_visited = mysqli_real_escape_string($con, $_GET['not_visited']);

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

	$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = " LIKE '$start_date%'";
	}

	if($manager_id_selected != '0'){
		$query_manager_1 = " AND static_manager = '$manager_id_selected' ";
		$query_manager_2 = " AND visits.manager_id = '$manager_id_selected'  ";
	}
					
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
			  
				<form action="/audit.php" id="statistics_form"> 
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
				  	<div class="form-group col-md-1" style="text-align: center;">
						<label for="login">Չնկարած</label>
						<br>
						<input type="checkbox" name="not_photo" <?php if($not_photo == 'on') {echo "checked"; } ?> class="form-control">
					</div>					  
					<div class="form-group col-md-1">
						<button type="submit" class="btn btn-success">Ցուցադրել</button>
					</div>
				</div>				
				</form>			  
                <table id="example1" class="table table-bordered table-striped" width="100%"> 
					<thead>
						<tr>				  
						<th>ID</th>
						<th>QR համար</th>
						<th>Խանութի Անուն</th>
						<th>Խանութի Հասցե</th>
						<th>Շրջան</th>
						<th>Մենեջեր</th>
						<th>Գործընկեր</th>
						<th>Ժամանակ</th>
						<th>Ռադիուս</th>
						<th>Նկարներ</th>
						<th>Մեկնաբանություն</th>
						<th>Քարտեզ</th>
						</tr>
					</thead>
					<tbody>				  
							<?php 
								if($not_photo == 'on'){	
									$sql=  "SELECT * 
											FROM shops 
											WHERE shops.shop_id not in (
												SELECT shop_id FROM visit_images WHERE visit_images.date $query_date_range
												) 
											$query_manager_1 
											$query_region_select 
											$query_district_select 
											$query_shop_select ";													
								}else{
									$sql=  "SELECT *, 
												visit_id AS v_id 
											FROM visit_images 
												INNER JOIN visits ON visit_images.visit_id = visits.id 
												LEFT JOIN shops ON visits.shop_id = shops.shop_id 
												LEFT JOIN district on shops.district = district.id 
											WHERE visits.date $query_date_range 
												$query_manager_2 
												$query_region_select 
												$query_district_select 
												$query_shop_select 
											GROUP by visit_images.visit_id 
											ORDER by visits.date DESC";
								}
								// echo $sql;die;
								$query = mysqli_query($con, $sql);

								while ($array_visits = mysqli_fetch_array($query)):
									$shop_id = $array_visits['shop_id'];
									if($not_photo == 'on'){
										$manager_id = $manager_id_selected;
									}else{
										$manager_id = $array_visits['manager_id'];
									}
									$date = $array_visits['date'];
									$comment = $array_visits['comment'];
									$visit_id = $array_visits['v_id'];
									$latitude = $array_visits['latitude'];
									$longitude = $array_visits['longitude'];
									$district_name = $array_visits['district_name'];

									
									$query_shop = mysqli_query($con, "SELECT static_manager, qr_id, name, address, shop_latitude, shop_longitude, district FROM shops WHERE shop_id='$shop_id' ");
									$array_shop = mysqli_fetch_array($query_shop);
									
									$shop_qr_id = $array_shop['qr_id'];
									$shop_name = $array_shop['name'];
									$shop_address = $array_shop['address'];
									$static_manager_curr = $array_shop['static_manager'];
									$shop_latitude = $array_shop['shop_latitude'];
									$shop_longitude = $array_shop['shop_longitude'];
									
									$shop_district_id = $array_shop['district'];
									
									$query_manager = mysqli_query($con, "SELECT manager.login AS manager_login, client.law_name AS client_name from manager, client WHERE manager.id='$static_manager_curr' AND manager.client_id = client.id ");
									$array_manager = mysqli_fetch_array($query_manager);					
							?>				  
						<tr>				  
							<td><?php echo $shop_id; ?></td>
							<td class="word_break"><?php echo $shop_qr_id; ?></td>
							<td><?php echo $shop_name; ?></td>
							<td><?php echo $shop_address; ?></td>
							<td>
								<?php
									if($not_photo == 'on'){
										$array_district = mysqli_fetch_array(mysqli_query($con, "SELECT district_name FROM district WHERE id = '$shop_district_id' "));
										echo $array_district['district_name'];
									}else{
										echo $district_name;
									}
								?>				 
				 			</td>
							<td><?php echo $array_manager['manager_login']; ?></td>
							<td><?php echo $array_manager['client_name']; ?></td>
							<td><?php echo $date; ?></td>
							<td>				 
								<?php 
									if($not_photo != 'on'){				 
										if($shop_latitude != ''){
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
									}
								?>				 
							</td>
							<td>				 
								<!-- <?php				 
								if($not_photo != 'on'){
									$query_images = mysqli_query($con, "SELECT * FROM visit_images WHERE visit_id = '$visit_id' ");
									while($array_images = mysqli_fetch_array($query_images)){
										$img_name = $array_images['image'];
										echo "<a href='/api/mobile/upload/$img_name' target='_blank'><img src='/api/mobile/upload/$img_name' height='50' width='50'></a>";
									}
								}				 
								?>			  -->
							</td>				 
							<td>				 
								<?php 
									$query_comment = mysqli_query($con, "SELECT comment FROM visits WHERE id = '$visit_id' ");
									$array_comment = mysqli_fetch_array($query_comment);
									// echo $array_comment['comment'];
									if($not_photo != 'on'):
								?>				 
								<textarea id="comment_input_<?php echo $visit_id; ?>" data-visitid="<?php echo $visit_id; ?>" class="form-control visit_comment"><?php  echo $array_comment['comment']; ?></textarea>				 
								<?php endif; ?>				 
							</td>				 
							<td style="width:150px;">								
								<button visit_id="<?php echo $visit_id; ?>" manager_id="<?php echo $manager_id ; ?>" task_text="<?php echo $shop_address.'->'.$shop_name  ; ?>" class="btn btn-secondary btn-sm add_task_from_comment" style="color:#fff" title="Ստեղծել առաջադրանք"><i class='fa fa-tasks'></i></button>

								<?php if($not_photo != 'on'): ?>				 
									<button style="width: 33px;" class="btn btn-primary btn-sm rounded-0 save_coordinates after_<?php echo $visit_id; ?>"  data-lat="<?php echo $latitude; ?>" data-long="<?php echo $longitude; ?>" data-curshop="<?php echo $shop_id; ?>" data-visitid="<?php echo $visit_id; ?>" title="Պահպանել կոորդինատները"><i class="fas fa-save"></i></button>
									<a href="#"style="width: 33px;" data-toggle="modal" data-target="#map<?php echo $visit_id; ?>"  class="btn btn-warning btn-sm rounded-0 delete_client_button" title="Դիտել"><i class="fas fa-map-marker-alt"></i></a>							
									<!-- Modal -->
									<div class="modal fade" id="map<?php echo $visit_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
											<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLongTitle">N<?php echo $visit_id; ?>աուդիտի քարտեզը</h5>
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
								<?php  endif; ?>					
					 		</td>      
                  		</tr>                
                 			<?php endwhile; ?>				 
					</tbody>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>QR համար</th>
							<th>Խանութի Անուն</th>
							<th>Խանութի Հասցե</th>
							<th>Շրջան</th>
							<th>Մենեջեր</th>
							<th>Գործընկեր</th>
							<th>Ժամանակ</th>
							<th>Ռադիուս</th>
							<th>Նկարներ</th>
							<th>Մեկնաբանություն</th>
							<th>Քարտեզ</th>
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
	const clicked_button = $(this)

	const visit_id = $(this).attr('visit_id')
	const comment = $(`#comment_input_${visit_id}`).val().trim()
    const shop_info_text = $(this).attr('task_text') 
    const manager_id = $(this).attr('manager_id')
	
	if(!visit_id || !comment || !shop_info_text || !manager_id){
		return false
	}


	clicked_button.prepend('<i class="fa fa-spinner fa-spin"></i>')
	clicked_button.attr('disabled', true)

	const task_text = `${shop_info_text} -> ${comment}`

	$.ajax({
           type: "POST",
           url: "/actions.php?cmd=add_task_from_comment",
           data: {visit_id,task_text,manager_id}, 
           success: function(data)
           {
				clicked_button.children().eq(0).remove(); 
				clicked_button.attr('disabled', false)
           }		   
         });
})




$(document).on('change','.visit_comment', function(){
	
	var visit_comment = $(this).val();
	var visit_id = $(this).data("visitid");
	var url = '/api/pr_audit.php';
		
    $.ajax({
           type: "POST",
           url: url,
           data: {
				visit_id: visit_id,
				visit_comment: visit_comment,
				check_comment: "check_comment"
		   }, 
           success: function(data)
			   {			  

			   }
		   
         });
	
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

$('#reservation').daterangepicker({
	locale: {
	format: 'YYYY-MM-DD'
	}
});
 


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
			window.location.reload();
		}
		
	});
});
	
	

$(function () {
    var table = $("#example1").DataTable({		
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
                    }); 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                });
            });
        },		
		dom: 'Bfrtip',
	    lengthMenu: [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
    	],  
		scrollX: true,
		autoWidth: true,		
        buttons: [		
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
		language:{
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
</script>
</body>
</html>
