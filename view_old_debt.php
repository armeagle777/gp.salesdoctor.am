<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);


$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);
$order_type = mysqli_real_escape_string($con, $_GET['order_type']);

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
            <h1>Հին պարտքեր</h1>
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
			  
				 <form action="/view_old_debt.php" id="statistics_form"> 
				  <div class="form-row">
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
					<th class="select-filter">Հ/Հ</th>

					<th style="width: 200px;">Նախնական պարտք</th>
					<th class="select-filter">Վճ. տիպ</th>
					<th class="select-filter">Խումբ</th>
                    <th class="select-filter">Խանութ</th>
                    <th class="select-filter">Հասցե</th>
                    <th class="select-filter">Տարածք</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Խումբ</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
						$query = "SELECT *, pr_orders_document.id AS curr_order_id FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN network ON shops.network = network.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE pr_orders_document.old_debt = '1' $query_region_select $query_district_select $query_shop_select ";
				
					
					$query_order_documents = mysqli_query($con, $query);
					while($warehouse_order_array = mysqli_fetch_array($query_order_documents)):
					$document_id = $warehouse_order_array['curr_order_id'];
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
					
					if($order_last_summ == ''){
						$order_last_summ = '0'; 
					}
					
				  ?>
				  <tr> 
					<td>
					
					<a href="#" class="btn btn-success btn-sm rounded-0 edit_client_button" title="Դիտել" data-toggle="modal" data-documentid="<?php echo $document_id; ?>"data-summ="<?php echo $order_last_summ; ?>"><i class="far fa-edit"></i></i></a>
					<a href="#" class="btn btn-danger btn-sm rounded-0 delete_client_button"  title="Դիտել" data-toggle="modal" id="<?php echo $document_id; ?>"><i class="fa fa-trash"></i></i></a>
					
					</td>
					
						<td><?php echo $shop_id; ?></td>

					<td><?php echo $order_last_summ; ?></td>
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
		
					
				
					<td><?php echo $network; ?></td>
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
                    <th style="width:150px;">Հ/Հ</th>
					<th style="width: 200px;">Նախնական պարտք</th>
					<th class="select-filter">Վճ. տիպ</th>
					<th class="select-filter">Խումբ</th>
                    <th class="select-filter">Խանութ</th>
                    <th class="select-filter">Հասցե</th>
                    <th class="select-filter">Տարածք</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Խումբ</th>

                  </tr>
                  </tfoot>
                </table>
              </div>
			  
			  <!-- Button trigger modal -->


<!-- Edit Modal -->
<div class="modal fade" id="eidt_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
	   <div class="modal-header">
        
      </div>
      <div class="modal-body">
        <input type="text" id="edit_summ" class="form-control" value="">
		<input type="hidden" id="editing_document_id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger end_edit">Խմբագրել</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
	   <div class="modal-header">
        
      </div>
      <div class="modal-body">
        Ջնջե՞լ պարտքը
		<input type="hidden" id="deleting_document_id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger end_delete">Ջնջել</button>
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


	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#deleting_document_id').val(contentPanelId);
		$('#delete_modal').modal('show')

	});
	
	jQuery(".edit_client_button").click(function() {
		
		$('#editing_document_id').val($(this).data("documentid"));
		
		$('#edit_summ').val($(this).data("summ"));
		$('#eidt_modal').modal('show')
		
	});
	
	
	$(".end_edit").click(function() {
		var editing_document_id = $('#editing_document_id').val();
		var edit_summ = $('#edit_summ').val();
		
		$.ajax({
			   type: "POST",
			   url: "api/pr_old_debt.php",
			   data: {editing_document_id: editing_document_id, edit_summ:edit_summ, action:'edit_debt'},
			   success: function(data)
			   {
				   //alert(data); 
				   window.location.reload();
			   }
			   
			 });
	});	
	
	$(".end_delete").click(function() {
		var deleting_document_id = $('#deleting_document_id').val();
		
		$.ajax({
			   type: "POST",
			   url: "api/pr_old_debt.php",
			   data: {deleting_document_id:deleting_document_id, action:'delete_debt'},
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
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
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
