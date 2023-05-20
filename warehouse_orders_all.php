<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);


$selected_region = mysqli_real_escape_string($con, $_GET['region']);
$selected_district = mysqli_real_escape_string($con, $_GET['district']);
$selected_shop = mysqli_real_escape_string($con, $_GET['shop']);
$selected_network = mysqli_real_escape_string($con, $_GET['network_select']);

$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);


$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$products = mysqli_real_escape_string($con, $_GET['products']);
$product_group = mysqli_real_escape_string($con, $_GET['product_group']);



if($products != 0 AND $products != ''){
	$products_select = " AND product_id = '$products'";
}else{
	$products_select = '';
}


if($selected_region != 0 AND $selected_region != ''){
	$product_group_select = " AND product_group = '$product_group'";
}else{
	$product_group_select = '';
}


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
            <h1>Պատվերներ մանրամասն</h1>
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
			  
				 <form action="/warehouse_orders_all.php" id="statistics_form"> 
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
			   
				  <div class="form-group col-md-3">
					<label for="product_group">Ապրանքների խումբ</label>
						
					<select name="product_group" id="product_group" class="form-control">

						<option value="0">Ընտրել</option>
						<?php 
						
						$query_product_group = mysqli_query($con, "SELECT * FROM pr_groups");
						while($array_pr_groups = mysqli_fetch_array($query_product_group)):
							
						?>
						
						<option value="<?php echo $array_pr_groups['id']; ?>" <?php if($product_group == $array_pr_groups['id']) {echo "selected"; } ?>  ><?php echo $array_pr_groups['group_name']; ?></option>";
						<?php 
							endwhile;
						?>
					
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
				  
				  <div class="form-group col-md-3">
					<label for="products">Ապրանք</label>
						
					<select name="products" id="products" class="form-control">

						<option value="0">Ընտրել</option>
					
								
					<?php 
							$shops_query = mysqli_query($con, "SELECT * FROM pr_products WHERE product_group = '$product_group' ORDER by regular_n ASC");
							while ($array_shops = mysqli_fetch_array($shops_query)):
							$product_id = $array_shops['id'];
							$product_name = $array_shops['name'];
						?> 
						 
					<option value="<?php echo $product_id; ?>" <?php if($product_id == $products) {echo "selected"; } ?>> <?php echo $product_name; ?></option>
			
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
					<th  class='select-filter'>Ժամանակ</th>
					<th  class='select-filter'>Անուն</th>
                    <th style="width:150px;"  class='select-filter'>Գործողություն</th>
					<th>Գին</th>					
					<th>Քանակ</th>					
					<th>Գումար</th>		
					<th>Զեղչի գումար</th>										
					<th>Զեղչի տոկոս</th>					
					<th class="select-filter">Վճ. տիպ</th>
					<th class="select-filter">Խումբ</th>
                    <th class="select-filter">Խանութ</th>
                    <th>Հասցե</th>
                    <th class="select-filter">Տարածք</th>
					<th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Առաքիչ</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Խումբ</th>
					<th class='select-filter'>Համար</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  
				  
				  <?php 
				  
				  
					if($datebeet !=''){
						$query = "SELECT * FROM pr_orders LEFT JOIN shops ON pr_orders.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN network ON shops.network = network.id LEFT JOIN pr_groups ON pr_orders.product_group = pr_groups.id WHERE document_date $query_date_range $query_region_select $query_district_select $query_shop_select $query_manager_select $products_select $product_group_select $query_network_select";
					}else{
						$query = '';
					}
										
					$query_order_documents = mysqli_query($con, $query);
					while($warehouse_order_array = mysqli_fetch_array($query_order_documents)):
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
					
					$product_order_total = $warehouse_order_array['product_last_cost'] * $warehouse_order_array['product_count_warehouse'];
					
					if($order_last_summ == ''){
						$order_last_summ = '0'; 
					}
					
				  ?>
				  <tr> 
					<td><?php echo $document_date; ?></td>
					<td>
						<?php
							$query_product_name = mysqli_fetch_array(mysqli_query($con, "SELECT name, sale_price FROM pr_products WHERE id = '$product_id' "));
							echo $query_product_name['name'];
						
						?>
					</td>
				
					<td style="text-align: center;">
				
					<?php
						if($warehouse_order_array['order_type'] == '1'){
							echo 'Պատվեր';
						}if($warehouse_order_array['order_type'] == '2'){
							echo 'Վերադարձ';
						}
					?>
				
					</td>
					<td>
						<?php echo $warehouse_order_array['product_cost'];  ?>
					</td>
					<td>
						<?php echo $warehouse_order_array['product_count_warehouse'];  ?>
					</td>					
					
					<td>
						<?php if($warehouse_order_array['order_type'] == '2'){
							echo '-';
						} ?><?php echo $product_order_total; ?>
					</td>	
					<td>
						<?php if($warehouse_order_array['order_type'] == '2'){
							echo '-';
						} ?><?php echo $query_product_name['sale_price'] * $warehouse_order_array['product_count_warehouse'] - $product_order_total; ?>
					</td>
					
					<td>
						<?php echo $warehouse_order_array['product_procent']; ?>
					</td>


					<td>
					
						<?php 
							$query_pay = mysqli_query($con, "SELECT payment_name FROM pr_payment_type WHERE id='$order_pay_type' ");
							$array_payment = mysqli_fetch_array($query_pay);
							echo $array_payment['payment_name'];
						?>
					
					
					</td>
					<td><?php echo $product_group_name; ?></td>

					<td><?php echo $shop_name; ?></td>
					<td><?php echo $shop_address; ?></td>
					<td><?php echo $district_name; ?></td>
					<td>
					
					<?php 
						$query_manager = mysqli_query($con, "SELECT name FROM manager WHERE id='$manager_id' ");
						$array_manager = mysqli_fetch_array($query_manager);
						echo $array_manager['name'];
					?>
										
					
					</td>
					
					<td>
					
					<?php 
						$query_courier = mysqli_query($con, "SELECT name FROM manager WHERE id='$courier_id' ");
						$array_courier = mysqli_fetch_array($query_courier);
						echo $array_courier['name'];
					?>
										
					
					</td>
					<td><?php echo $network; ?></td>
					<td>
						<?php 
							$query_groups = mysqli_query($con, "SELECT * FROM shop_group LEFT JOIN group_to_shop ON shop_group.id = group_to_shop.group_id WHERE group_to_shop.shop_id = '$shop_id' ");
							$array_groups = mysqli_fetch_array($query_groups);
							echo $array_groups['group_name'];
							
						?>
						
					</td>

					<td><?php echo $document_id; ?></td>

				  </tr>
				  
				 
				 <?php endwhile; ?>
				 
				 <?php 
				 
					if($datebeet !=''){
						$query_warehouse_q = "SELECT * FROM pr_warehouse_trans LEFT JOIN pr_products ON pr_warehouse_trans.product_id = pr_products.id LEFT JOIN pr_groups ON pr_products.product_group = pr_groups.id WHERE document_date $query_date_range AND transaction_type = '2'  $products_select $product_group_select ";
					}else{
						$query_warehouse_q = '';
					}
					 $query_warehouse_income = mysqli_query($con, $query_warehouse_q);
					 
					 while($array_warehouse_income = mysqli_fetch_array($query_warehouse_income)):
				 ?>
				 
					<tr>
						<td><?php echo $array_warehouse_income['document_date']; ?></td>
						<td><?php echo $array_warehouse_income['name']; ?></td>
						<td style="text-align: center;">Ձեռքբերում</td>
						<td></td>
						<td>-<?php echo $array_warehouse_income['product_count']; ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $array_warehouse_income['group_name']; ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				 
				 <?php
					endwhile;
				 ?>
				 
                  </tbody>
                  <tfoot>
                  <tr>
				  
					<th class='select-filter'></th>
					<th class='select-filter'></th>
                    <th class='select-filter'></th>
					<th></th>					
					<th></th>
					<th></th>
					<th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class='select-filter'></th>
					
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

$( "#product_group" ).change(function() {
	  var product_group = $('#product_group').val();
	  $('#products option').remove();
	  var url = 'api/region_select.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {product_group: product_group}, 
           success: function(data)
           {

			   $('#products').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});


$(document).ready(function(){
        $('.order_delivered').click(function(){
            if($(this).is(":checked")){
                var status = '1';
            }
            else if($(this).is(":not(:checked)")){
                var status = '0';
            }
			
			var document_id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "api/add_warehouse_order_edit.php",
				data: {document_id:document_id, action:'order_delivered', status: status},
				success: function(data)
				{
				   //alert(data); 
				   //window.location.reload();
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
   var table =  $("#example1").DataTable({
	   
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 4;
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
