<?php include 'header.php'; ?>
<?php include 'api/db.php'; 

$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);
$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$region_id_selected = mysqli_real_escape_string($con, $_GET['region_select']);
$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);

$not_visited = mysqli_real_escape_string($con, $_GET['not_visited']);
$not_filmed = mysqli_real_escape_string($con, $_GET['not_filmed']);
$not_sales = mysqli_real_escape_string($con, $_GET['not_sales']);


if($region_id_selected != 0 AND $region_id_selected != ''){
	$query_region_select = " AND S.region = '$region_id_selected'";
}else{
	$query_region_select = '';
}


if($district_id_selected != 0 AND $district_id_selected != ''){
	$query_district_select = " AND S.district = '$district_id_selected'";
}else{
	$query_district_select = '';
}


if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND S.static_manager = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}

$date_ex = explode(" - ", $datebeet);
$start_date = $date_ex[0];
$end_date = $date_ex[1];

	$query_date_range = " NOT BETWEEN '$start_date' AND '$end_date'";







$abandoned_shops_query="";
if($not_visited === '1'):
    $abandoned_shops_query .=" AND S.shop_id NOT IN (SELECT shop_id FROM visits WHERE date $query_date_range)";
endif;

if($not_filmed === '1'):
    $abandoned_shops_query .=" AND S.shop_id NOT IN (SELECT shop_id FROM visit_images WHERE date $query_date_range)";
endif;

if($not_sales === '1'):
    $abandoned_shops_query .=" AND S.shop_id NOT IN (SELECT  shop_id FROM pr_orders WHERE document_date $query_date_range)";
endif;


$query_string = "SELECT 
                	S.id,
                    S.filter_n,
                    S.shop_id,
                    S.discount AS shop_discount,
                	S.name AS shop_name,
                    S.address,
                    S.comment,
                    S.stend_count,
                    S.stend_summ,
                    S.law_name,
                    S.law_address,
                    S.hvhh,
                    S.active,
                	S.phone AS phone_shop, 	 
                	S.shop_latitude,
                    S.shop_longitude,
                    S.owner_name,
                    S.owner_tel,
                    S.qr_id,
                    S.marketing_payment,
                    M.name AS manager_name,
                    PC.name AS courier_name,
                    N.network_name,
                    R.region_name,
                    D.district_name
                FROM 
                	shops S
                	LEFT JOIN manager M ON S.static_manager = M.id 
                	LEFT JOIN manager PC ON PC.id=S.courier_id
                	LEFT JOIN network N ON S.network = N.id
                    LEFT JOIN region  R ON S.region = R.id
                    LEFT JOIN district D ON D.id = S.district
                WHERE 1
                	 $query_district_select 
                     $query_region_select 
                     $query_manager_select
                     $abandoned_shops_query
                ORDER by 
                	S.id DESC";

if($_GET['submit_filtr'] == '' and isset($_GET['submit_filtr'])){
	
	$query = mysqli_query($con,$query_string );
	
}else{
	$query = '';
}



?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Խանութներ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/action_shops.php?action=add" class="btn btn-primary">Ավելացնել նորը</a>
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
			  <form action="/shops_abandoned.php" method="GET">
			  	<div class="form-row">

				  <div class="form-group col-md-1">
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
						<option value='0'>Ընտրել</option>
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
  				    <div class="form-group col-md-1 not_visited_check" <?php if(isset($_GET['not_grouped'])){echo "style='display:none;'";} ?>  align="center">
						<label for="not_visited" >Չայցելած</label>
						<input type="checkbox" class="form-control" id="not_visited" name="not_visited" value="1" <?php if($not_visited == '1'){echo "checked"; } ?>>
				    </div>
  				    <div class="form-group col-md-1 not_visited_check"  align="center">
						<label for="not_filmed" >Չնկարած</label>
						<input type="checkbox" class="form-control" id="not_filmed" name="not_filmed" value="1" <?php if($not_filmed == '1'){echo "checked"; } ?>>
				    </div>
  				    <div class="form-group col-md-1 not_visited_check"  align="center">
						<label for="not_sales" >0 Վաճառք</label>
						<input type="checkbox" class="form-control" id="not_sales" name="not_sales" value="1" <?php if($not_sales == '1'){echo "checked"; } ?>>
				    </div>
      			    <div class="form-group col-md-2">
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
				  <div class="form-group col-md-3 col-lg-2 col-xxl-1" style="display: flex;  flex-direction:column;  justify-content:flex-end;">
						<button type="submit" name="submit_filtr" class="btn btn-success" style="display: block;max-width:150px">Ցուցադրել</submit>
				  </div>
			   </div>
			   </form>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th style="width:150px;">Խմբագրել</th>
					<th class="select-filter">N</th>
                    <th class="select-filter">ID</th>
					<th class="select-filter">Զեղչ %</th>
					<th class="select-filter">Անուն</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Տարածք</th>
					<th class="select-filter">Մարզ</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Առաքիչ</th>
					<th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Ստենդի քանակ</th>
					<th class="select-filter">Ստենդի գումար</th>
					<th class="select-filter">Իր. Անուն</th>
					<th class="select-filter">Իր. հասցե</th>
                    <th class="select-filter">ՀՎՀՀ</th>
					<th class="select-filter">Հեռախոս</th>
					<th class="select-filter">Տնօրենի անուն</th>
					<th class="select-filter">Տնօրենի հեռախոս</th>
					<th class="select-filter">Ակտիվ</th>
					<th class="select-filter">QR համար</th>
					<th class="select-filter">Մարքեթինգային վճար</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					if($query):
					while ($array_shops = mysqli_fetch_array($query)):
					$shop_id = $array_shops['shop_id'];
					$qr_id = $array_shops['qr_id'];
					$name = $array_shops['shop_name'];
					$address = $array_shops['address'];
					$district_name = $array_shops['district_name'];
					$region_name = $array_shops['region_name'];
					$network = $array_shops['network_name'];
					$comment = $array_shops['comment'];
					$stend_count = $array_shops['stend_count'];
					$stend_summ = $array_shops['stend_summ'];
					$law_name = $array_shops['law_name'];
					$law_address = $array_shops['law_address'];
					$hvhh = $array_shops['hvhh'];
					$phone = $array_shops['phone_shop'];
					$active = $array_shops['active'];
					$latitude = $array_shops['shop_latitude'];
					$longitude = $array_shops['shop_longitude'];
					$discount = $array_shops['shop_discount'];
					$manager_name = $array_shops['manager_name'];
					$courier_name = $array_shops['courier_name'];
					$network_name = $array_shops['network_name'];
					$filter_n = $array_shops['filter_n'];
					$owner_name = $array_shops['owner_name'];
					$owner_tel = $array_shops['owner_tel'];
					$marketing_payment = $array_shops['marketing_payment'];
					
					if($active == 'on'){
						$active = 'Այո';
					}else{
						$active = 'Ոչ';
					}
					
				 ?> 
				  
                  <tr>
				              <td style="width:170px;">
				 
				 <?php if($latitude !=''): ?>
				 
						<a href="#"style="width: 33px;" data-toggle="modal" data-target="#map<?php echo $shop_id; ?>"  class="btn btn-warning btn-sm rounded-0 delete_client_button" title="Դիտել"><i class="fas fa-map-marker-alt"></i></a>
						
						
						
						<!-- Modal -->
							<div class="modal fade" id="map<?php echo $shop_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">N<?php echo $shop_id; ?> խանութի քարտեզը</h5>
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
						
						<a href="/view_managers.php?shop_id=<?php echo $shop_id; ?>" class="btn btn-warning btn-sm rounded-0" title="Դիտել մենեջերներին" target="_blank"><i class="fa fa-user" ></i></a>

						<a href="/action_shops.php?action=edit&shop_id=<?php echo $shop_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						
						<a href="#" id="<?php echo $shop_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
						
												
						
						
				  </td>
				 <td><?php echo $filter_n; ?></td>
				 <td><?php echo $shop_id; ?></td>
				 <td><?php echo $discount; ?></td>

				 <td><?php echo $name; ?></td>
				 <td><?php echo $address; ?></td>
				 <td><?php echo $district_name; ?></td>
				 <td><?php echo $region_name; ?></td>
				 <td><?php echo $network_name; ?></td>
				 <td><?php echo $manager_name; ?></td>
				 <td><?php echo $courier_name; ?></td>
				 <td><?php echo $comment; ?></td>
				 <td><?php echo $stend_count; ?></td>
				 <td><?php echo $stend_summ; ?></td>
				 <td><?php echo $law_name; ?></td>
				 <td><?php echo $law_address; ?></td>
				 <td><?php echo $hvhh; ?></td>
				 <td><?php echo $phone; ?></td>
				 <td><?php echo $owner_name; ?></td>
				 <td><?php echo $owner_tel; ?></td>
				 <td><?php echo $active; ?></td>
				 <td class="word_break"><?php echo $qr_id; ?></td>
				 <td><?php echo $marketing_payment; ?></td>
			  </tr>
                 
                 <?php 
                 endwhile; 
                 endif;
                 ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
				  <th style="width:150px;">Խմբագրել</th>
                   <th class="select-filter">N</th>
                   <th class="select-filter">ID</th>
					<th class="select-filter">Զեղչ %</th>
					<th class="select-filter">Անուն</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Տարածք</th>
					<th class="select-filter">Մարզ</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Առաքիչ</th>
					<th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Ստենդի քանակ</th>
					<th class="select-filter">Ստենդի գումար</th>
					<th class="select-filter">Իր. անուն</th>
					<th class="select-filter">Իր. հասցե</th>
                    <th class="select-filter">ՀՎՀՀ</th>
					<th class="select-filter">Հեռախոս</th>
					<th class="select-filter">Տնօրենի անուն</th>
					<th class="select-filter">Տնօրենի հեռախոս</th>

					<th class="select-filter">Ակտիվ</th>
					<th class="select-filter">QR համար</th>
					<th class="select-filter">Մարքեթինգային վճար</th>


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

<!-- date-range-picker -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

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

<!-- Modal -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <b>Ջնջե՞լ Խանութը</b>
	   <input type="hidden" value="" name="client_to_delete" id="client_to_delete">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger" id="click_delete">Այո</button>
      </div>
    </div>
  </div>
</div>


<script>
$('#reservation').daterangepicker({
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
    var table = $("#example1").DataTable({

	 
			initComplete: function () {
            this.api().columns( '.select-filter' ).every( function (index) {
				
				//    var column = table.column( index );
 
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
						"paging": false,

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
</script>
</body>
</html>
