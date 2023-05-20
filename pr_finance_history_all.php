<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);

$group_selected = mysqli_real_escape_string($con, $_GET['group_id']);


$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$district_id_selected = mysqli_real_escape_string($con, $_GET['district']);
$shop = mysqli_real_escape_string($con, $_GET['shop']);

//new

$selected_region = mysqli_real_escape_string($con, $_GET['region']);
$selected_district = mysqli_real_escape_string($con, $_GET['district']);
$selected_shop = mysqli_real_escape_string($con, $_GET['shop']);
$selected_network = mysqli_real_escape_string($con, $_GET['network_select']);
$selected_payment_type = mysqli_real_escape_string($con, $_GET['payment_type']);



if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_id = " AND shops.static_manager = '$manager_id_selected'";
}else{
	$query_manager_id = '';
}

if($group_selected != 0 AND $group_selected != ''){
	$query_group_selected = " AND pr_orders_finance.payed_product_group = '$group_selected' ";
}else{
	$query_group_selected = '';
}

/*
if($shop != 0 AND $shop != ''){
	$query_shop_select = " AND shops.shop_id = '$shop'";
}else{
	$query_shop_select = '';
}

if($district_id_selected != 0 AND $district_id_selected != ''){
	$query_district_select = " AND shops.district = '$district_id_selected'";
}else{
	$query_district_select = '';
}*/


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
	$payment_type_select = " AND pr_orders_finance.pay_type = '$selected_payment_type'";
}else{
	$payment_type_select = '';
}



if(isset($_GET['datebeet'])){
	
	$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = " LIKE '$start_date%'";
	}
	
	$query = "SELECT *, order_summ as total_summ, manager.name as user_name, shops.name AS shop_name, pr_orders_finance.id AS pr_orders_finance_id FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id LEFT JOIN pr_payment_type ON pr_orders_finance.pay_type = pr_payment_type.id LEFT JOIN manager ON pr_orders_finance.user_id = manager.id WHERE 1=1 AND document_date $query_date_range $query_district_select $query_shop_select $query_manager_id $query_group_selected";

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
            <h1>Գումարի մուտքերի մանրամասն</h1>
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
			  
				 <form action="/pr_finance_history_all.php" id="statistics_form"> 
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
								<select name="manager_select" id="manager_select" class="form-control">
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
				  
				  
					<div class="form-group col-md-2" style="display: none;">
								<label for="login">Խանութ</label>
								<select name="warehouse_id" id="warehouse_id" class="form-control mdb-select md-form"">
								<option value="0"> Ընտրել </option>
									<?php 
										$query_shops = mysqli_query($con, "SELECT * FROM shops ORDER by id DESC");
										while ($array_shop = mysqli_fetch_array($query_shops)):
										$shop_id = $array_shop['shop_id'];
										$shop_name = $array_shop['name'];
									?> 
									 
									<option value="<?php echo $shop_id; ?>"  <?php if($curr_warehouse_id == $shop_id ) {echo "selected"; } ?> > <?php echo $shop_name; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>

		


					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  
					  <?php // echo $query; ?>
					  
					
					</div>
				
				
				  </form>
			  
		
			  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
                    <th class="select-filter">Հ/Հ</th>
                    <th class="select-filter">Մուտքի Հ/Հ</th>
                    <th class="select-filter">Պատվերի Հ/Հ</th>
					<th class="select-filter">Խանութ</th>
                    <th class="select-filter">Ժամանակ</th>
                    <th class="select-filter">Աշխատակից</th>
                    <th>Գումար</th>
                    <th class="select-filter">Կարգավիճակ (գործավար)</th>
                    <th class="select-filter">Վճ. տիպ</th>
                    <th class="select-filter">Բանկ</th>
                    <th style="width:150px;">Գործողություն</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
				  
					$query_shops_documents = mysqli_query($con, "$query");
										
					while($shops_array = mysqli_fetch_array($query_shops_documents)):
					$shop_id = $shops_array['shop_id'];
					$qr_id = $shops_array['qr_id'];
					$curr_shop_name = $shops_array['shop_name'];
					$address = $shops_array['address'];
					$total = $shops_array['total_summ'];
					$transaction_id = $shops_array['transaction_id'];
					$payed_document_id = $shops_array['payed_document_id'];
					$user_name = $shops_array['user_name'];
					$document_date = $shops_array['document_date'];
					$payer_payment_type = $shops_array['payer_payment_type'];
					$payer_payment_bank = $shops_array['payer_payment_bank'];
					$pr_orders_finance_id = $shops_array['pr_orders_finance_id'];

					
				  ?>
				  
				  <tr> 
					<td><?php echo $shop_id; ?></td>
					<td><?php echo $transaction_id; ?></td>
					<td><?php echo $payed_document_id; ?></td>
					<td><?php echo $curr_shop_name; ?></td>
					<td><input type="text" value="<?php echo $document_date; ?>" class="form-control editable_date"  id="<?php echo $transaction_id; ?>"style="width: 100px;"> </td>
					<td><?php echo $user_name; ?></td>
					<td><?php echo $total; ?></td>
					

					 
					<td>
					<?php 
					$query_all_document_statuses = mysqli_query($con, "SELECT * FROM pr_orders_finance WHERE payed_document_status = '1' AND transaction_id = '$transaction_id' ");
					$num_count_rows = mysqli_num_rows($query_all_document_statuses);

					?> 
					<input type="checkbox" class="form-control order_full_payed_from_transaction" id="<?php echo $transaction_id; ?>" <?php if($num_count_rows == '0'){ echo "checked"; } ?>>
					
					
					</td>

					
					
					<td><?php 
					if($payer_payment_type == '1'){
						echo "Դրամարկղ";
					}if($payer_payment_type == '2'){
						echo "Բանկ";
					}
					?></td>
					<td>
						<?php 
							$bank_array = mysqli_fetch_array(mysqli_query($con, "SELECT bank_name FROM pr_bank WHERE id='$payer_payment_bank' "));
							echo $bank_array['bank_name'];
						
						?>
					</td>
					<td>
					<a style="" href="/pr_finance_history_edit.php?transaction_id=<?php echo $transaction_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fa fa-search"></i></a>
					</td>
				  </tr>
				 
				 <?php endwhile; ?>
				 
                  </tbody>
                  <tfoot>
                  <tr>
				  
                    <th class="select-filter"></th>
                    <th class="select-filter"></th>
                    <th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th></th>
                    <th class="select-filter"></th>
					<th class="select-filter"></th>
                    <th class="select-filter"></th>
                    <th style="width:150px;"></th>


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

$(document).ready(function(){
        $('.editable_date').change(function(){
 
			var pr_orders_finance_id = $(this).attr('id');
			var editable_date = $(this).val();
			$.ajax({
				type: "POST",
				url: "api/add_pr_finance.php",
				data: {pr_orders_finance_id:pr_orders_finance_id, editable_date: editable_date, action: 'change_payment_date'},
				success: function(data)
				{
				   //alert(data); 
				   window.location.reload();
				}
			   
			});
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


$(document).ready(function(){
        $('.editable_date').change(function(){
 
			var pr_orders_finance_id = $(this).attr('id');
			var editable_date = $(this).val();
			$.ajax({
				type: "POST",
				url: "api/add_pr_finance.php",
				data: {pr_orders_finance_id:pr_orders_finance_id, editable_date: editable_date, action: 'change_payment_date'},
				success: function(data)
				{
				   //alert(data); 
				   window.location.reload();
				}
			   
			});
        });
    });
$(document).ready(function(){
        $('.order_full_payed_from_transaction').click(function(){
            if($(this).is(":checked")){
                var status = '3';
            }
            else if($(this).is(":not(:checked)")){
                var status = '1';
            }
			
			var transaction_id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "api/add_pr_finance.php",
				data: {transaction_id:transaction_id, action:'order_full_payed_from_transaction', status: status},
				success: function(data)
				{
				   //alert(data); 
				   window.location.reload();
				}
			   
			});
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
    $("#example1").DataTable({
		
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 6;
				while(j < 7){
					var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return Number(a) + Number(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal);
					j++;
				} 
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
