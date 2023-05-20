<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);

$selected_region = mysqli_real_escape_string($con, $_GET['region']);
$selected_district = mysqli_real_escape_string($con, $_GET['district']);
$selected_shop = mysqli_real_escape_string($con, $_GET['shop']);
$selected_network = mysqli_real_escape_string($con, $_GET['network_select']);

$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);


$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);

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

if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND shops.static_manager = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}

if($selected_network != 0 AND $selected_network != ''){
	$query_network_select = " AND shops.network = '$selected_network'";
}else{
	$query_network_select = '';
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
            <h1>Պարտքացուցակ</h1>
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
			  
				 <form action="/pr_finance.php" id="statistics_form" style=""> 
				  <div class="form-row">
				  
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

					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  
					  
					  
					
					</div>
				
				
				  </form>
			  
		
			  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					 <th style="width:150px;">Գործողություն</th>

                    <th  class="select-filter">Հ/Հ</th>
					<th  class="select-filter">Խանութ</th>
					<th  class="select-filter">Հասցե</th>
					<th  class="select-filter">Տարածք</th>
					<th  class="select-filter">Մենեջեր</th>
					<th  class="select-filter">Հեռախոս</th>
					<th  class="select-filter">ՀՎՀՀ</th>
					<th  class="select-filter">Իրավաբանական անուն</th>

                    <th>Պարտք</th>
                    <th class="select-filter">Ցանց</th>
                    <th class="select-filter">Խումբ</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
					$query_shops_documents = mysqli_query($con, "SELECT sum(order_last_summ) AS shop_total, pr_orders_document.shop_id AS order_shop_id, shops.name, shops.address, shops.district, shops.region, district.district_name, shops.static_manager, manager.login, shops.phone AS shop_phone, shops.hvhh, shops.law_name, network.network_name FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN manager ON manager.id = shops.static_manager LEFT JOIN network ON shops.network = network.id WHERE (pr_orders_document.order_type = 1 or pr_orders_document.order_type = 0) $query_region_select $query_district_select $query_shop_select $query_manager_select $query_network_select GROUP BY pr_orders_document.shop_id ");
										
					//$query_shops_documents = mysqli_query($con, "SELECT * FROM shops WHERE balance != '' ");
					while($shops_array = mysqli_fetch_array($query_shops_documents)):
					$shop_id = $shops_array['order_shop_id'];
					$name = $shops_array['name'];
					$address = $shops_array['address'];
					$balance = $shops_array['shop_total'];
					$law_name = $shops_array['law_name'];
					$district_name = $shops_array['district_name'];
					$static_manager = $shops_array['login'];
					$shop_phone = $shops_array['shop_phone'];
					$hvhh = $shops_array['hvhh'];
					$network_name = $shops_array['network_name'];

					$veraradz_array = mysqli_fetch_array(mysqli_query($con,"SELECT sum(order_last_summ) AS veradardz FROM pr_orders_document WHERE shop_id = '$shop_id' AND order_type = '2' AND order_status = '1'"));
					
					$finance_array = mysqli_fetch_array(mysqli_query($con,"SELECT sum(order_summ) AS vcharvats FROM pr_orders_finance WHERE shop_id = '$shop_id' "));
									
					
				  ?>
				  
				  <tr> 
					<td>
					<a style="" href="/add_pr_finance.php?shop_id=<?php echo $shop_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fas fa-money-bill-wave"></i></a>
					
					<a style="" href="/finance_history.php?shop_id=<?php echo $shop_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fa fa-list" aria-hidden="true"></i></a>
					
					
					<a style="display: none;" href="/warehouse_exit.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fas fa-location-arrow"></i></i></a>
					</td>
					<td><?php echo $shop_id; ?></td>
					<td><?php echo $name; ?></td>
					<td><?php echo $address; ?></td>
					<td><?php echo $district_name; ?></td>
					<td><?php echo $static_manager; ?></td>
					<td><?php echo $shop_phone; ?></td>
					<td><?php echo $hvhh; ?></td>
					<td><?php echo $law_name; ?></td>
					
					<td><?php echo $balance - $veraradz_array['veradardz'] - $finance_array['vcharvats']; ?></td>
					<td><?php echo $network_name; ?></td>
					<td>
					
						<?php 
							$query_groups = mysqli_query($con, "SELECT * FROM shop_group LEFT JOIN group_to_shop ON shop_group.id = group_to_shop.group_id WHERE group_to_shop.shop_id = '$shop_id' ");
							$array_groups = mysqli_fetch_array($query_groups);
							echo $array_groups['group_name'];
						?>
					
					
					</td>

				  </tr>
				 
				 <?php endwhile; ?>
				 
                  </tbody>
                  <tfoot>
                  <tr>
				  
					<th style="width:150px;">Գործողություն</th>

                    <th  class="select-filter">Հ/Հ</th>
					<th  class="select-filter">Խանութ</th>
					<th  class="select-filter">Հասցե</th>
					<th  class="select-filter">Տարածք</th>
					<th  class="select-filter">Մենեջեր</th>
					<th  class="select-filter">Հեռախոս</th>
					<th  class="select-filter">ՀՎՀՀ</th>
					<th  class="select-filter">Իրավաբանական անուն</th>

                    <th>Պարտք</th>
                    <th class="select-filter">Ցանց</th>
                    <th class="select-filter">Խումբ</th>


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



// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
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
      var table =  $("#example1").DataTable({
		
		   			"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                ''+pageTotal +''
            );
        },	

		  
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
	    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
		"paging": false,
		"scrollX": true,
		"autoWidth": false,
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
