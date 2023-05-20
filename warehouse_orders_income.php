<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);



$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);
$order_type = mysqli_real_escape_string($con, $_GET['order_type']);

if($district_id_selected != 0 AND $district_id_selected != ''){
	$query_district_select = " AND shops.district = '$district_id_selected'";
}else{
	$query_district_select = '';
}

if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND pr_orders_document.manager_id = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}


$group_selected = mysqli_real_escape_string($con, $_GET['group_id']);


if($group_selected != 0 AND $group_selected != ''){
	$query_group_selected = " AND pr_orders_document.product_group = '$group_selected' ";
	$payed_group_selected = " AND pr_orders_finance.payed_product_group = '$group_selected' ";
}else{
	$query_group_selected = '';
	$payed_group_selected = '';
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

	if($_SESSION['user_role'] == '3' ){
		$disabled = 'disabled';
	}else{
		$disabled = '';
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
            <h1><?php if($order_type == '2'){ echo "Վերադարձներ"; }else {echo "Պատվերներ և վճարումներ"; } ?></h1>
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
			  
				 <form action="/warehouse_orders_income.php" id="statistics_form"> 
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
								<label for="district">Շրջան</label>
								<select name="district_select" id="district_select" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 
										
										$query_district = mysqli_query($con, "SELECT * FROM district ORDER by id");
										
										while ($array_district = mysqli_fetch_array($query_district)):
										$district_id = $array_district['id'];
										$district_name = $array_district['district_name'];
									?> 
									 
									<option value="<?php echo $district_id; ?>"  <?php if($district_id_selected == $district_id ) {echo "selected"; } ?> > <?php echo $district_name; ?></option>
									
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

					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  <input type="hidden" name="order_type" value="<?php echo $order_type; ?>">
					  
					  
					
					</div>
				
				
				  </form>
				  
			
				  
				  
			  
		<?php //echo "SELECT * FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN network ON shops.network = network.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE pr_orders_document.order_type = '$order_type' AND document_date $query_date_range $query_district_select $query_manager_select "; ?>
			  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Ժամանակ</th>
                    <th style="width:150px;">Դիտել</th>
					<th class="select-filter">Համար</th>
					<th style="width: 200px;">Պատվերի Գումար</th>
					<th style="width: 200px;">Մուտքի Գումար</th>
					<th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Խումբ</th>
                    <th class="select-filter">Խանութ</th>
                    <th class="select-filter">Հասցե</th>
                    <th class="select-filter">Տարածք</th>
					<th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Հ/Ա</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Խումբ</th>
					<th class="select-filter">Առաքիչ</th>
					<th class="select-filter">Վճ. տիպ</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
					if($datebeet !=''){
						$query = "SELECT * FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN network ON shops.network = network.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE pr_orders_document.order_type = '$order_type' AND document_date $query_date_range $query_district_select $query_manager_select $query_group_selected";
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
					$order_comment = $warehouse_order_array['order_comment'];
					
					if($order_last_summ == ''){
						$order_last_summ = '0'; 
					}
					
				  ?>
				  <tr> 
					<td><?php echo $document_date; ?></td>
					<td>
					
					<a href="/view_order.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fa fa-search"></i></a>
		
					 
					</td>
					<td><?php echo $document_id; ?></td>

					<td><?php echo $order_last_summ; ?></td>
					<td> </td>
					<td>
					<?php echo $order_comment; ?>
					
					
					
					</td>
					<td><?php echo $product_group_name; ?></td>

					<td style="font-weight: bold;"><?php echo $shop_id; ?>.<?php echo $shop_name; ?></td>
					<td style="font-weight: bold;"><?php echo $shop_address; ?></td>
					<td><?php echo $district_name; ?></td>
					<td>
					
					<?php 
						$query_manager = mysqli_query($con, "SELECT name FROM manager WHERE id='$manager_id' ");
						$array_manager = mysqli_fetch_array($query_manager);
						echo $array_manager['name'];
					?>
										
					
					</td>
					
					<td>
					
						<?php if($warehouse_order_array['ha_sended']== '1'): ?>
						<button class="btn btn-success btn-sm rounded-0"><i class="fas fa-check"></i></button>
						<?php endif; ?>
										
					
					</td>
					<td><?php echo $network; ?></td>
					<td>
						<?php 
							$query_groups = mysqli_query($con, "SELECT * FROM shop_group LEFT JOIN group_to_shop ON shop_group.id = group_to_shop.group_id WHERE group_to_shop.shop_id = '$shop_id' ");
							$array_groups = mysqli_fetch_array($query_groups);
							echo $array_groups['group_name'];
							
						?>
						
					</td>


					
					<td style="text-align: center; width: 55px;">
					
					<?php 
						$query_courier = mysqli_query($con, "SELECT name FROM manager WHERE id='$courier_id' ");
						$array_courier = mysqli_fetch_array($query_courier);
						echo $array_courier['name'];
					?>
					
					
					</td>					
					<td>
					<?php 
						$query_pay = mysqli_query($con, "SELECT payment_name FROM pr_payment_type WHERE id='$order_pay_type' ");
						$array_payment = mysqli_fetch_array($query_pay);
						echo $array_payment['payment_name'];
					?>
					</td>

				  </tr>
				  
				 
				 <?php endwhile; ?>

				 
				  <?php 
					if($datebeet !=''){
						$query = "SELECT * FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN network ON shops.network = network.id LEFT JOIN pr_groups ON pr_orders_finance.payed_product_group = pr_groups.id WHERE document_date $query_date_range $query_district_select $query_manager_select $payed_group_selected";
					}else{
						$query = '';
					}
					
					$query_order_documents = mysqli_query($con, $query);
					while($warehouse_order_array = mysqli_fetch_array($query_order_documents)):
					$document_id = $warehouse_order_array['payed_document_id'];
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
					$payed_last_summ = $warehouse_order_array['order_summ'];
				
					
				  ?>
				  <tr> 
					<td><?php echo $document_date; ?></td>
					<td>
					
					<a href="/view_order.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fa fa-search"></i></a>
					 
					</td>
					
					<td><?php echo $document_id; ?></td>

					
					<td>
					
					
						
					<?php 
						$query_order_summ = mysqli_query($con, "SELECT order_last_summ FROM pr_orders_document WHERE document_id='$document_id' ");
						$array_summ = mysqli_fetch_array($query_order_summ);
						
					?>
					
					<?php echo $array_summ['order_last_summ']; ?>
					
					
					
					
					</td>
					<td> <?php echo $payed_last_summ; ?></td>
					<td>
					
					<?php 
						$query_order_comment = mysqli_query($con, "SELECT order_comment FROM pr_orders_document WHERE document_id='$document_id' ");
						$array_comment = mysqli_fetch_array($query_order_comment);
						
					?>
					
					<textarea id="document_comment" data-documentid="<?php echo $document_id; ?>" class="form-control"><?php echo $array_comment['order_comment']; ?></textarea>
							
					
					<?php //echo $order_comment; ?>
					
					
					
					</td>
					<td><?php echo $product_group_name; ?></td>

					<td style="font-weight: bold;"><?php echo $shop_id; ?>.<?php echo $shop_name; ?></td>
					<td style="font-weight: bold;"><?php echo $shop_address; ?></b></td>
					<td><?php echo $district_name; ?></td>
					<td>
					
					<?php 
						$query_manager = mysqli_query($con, "SELECT name FROM manager WHERE id='$manager_id' ");
						$array_manager = mysqli_fetch_array($query_manager);
						echo $array_manager['name'];
					?>
										
					
					</td>
					
					<td>
					
						<?php if($warehouse_order_array['ha_sended']== '1'): ?>
						<button class="btn btn-success btn-sm rounded-0"><i class="fas fa-check"></i></button>
						<?php endif; ?>
										
					
					</td>
					<td><?php echo $network; ?></td>
					<td>
						<?php 
							$query_groups = mysqli_query($con, "SELECT * FROM shop_group LEFT JOIN group_to_shop ON shop_group.id = group_to_shop.group_id WHERE group_to_shop.shop_id = '$shop_id' ");
							$array_groups = mysqli_fetch_array($query_groups);
							echo $array_groups['group_name'];
							
						?>
						
					</td>


					
					<td style="text-align: center; width: 55px;">
					
					<?php 
						$query_courier = mysqli_query($con, "SELECT name FROM manager WHERE id='$courier_id' ");
						$array_courier = mysqli_fetch_array($query_courier);
						echo $array_courier['name'];
					?>
					
					
					</td>					
					<td>
					<?php 
						$query_pay = mysqli_query($con, "SELECT payment_name FROM pr_payment_type WHERE id='$order_pay_type' ");
						$array_payment = mysqli_fetch_array($query_pay);
						echo $array_payment['payment_name'];
					?>
					</td>

				  </tr>
				  
				 
				 <?php endwhile; ?>
                  </tbody>
                  <tfoot>
                  <tr>
				  
					<th>Ժամանակ</th>
                    <th style="width:150px;">Դիտել</th>			
					<th class="select-filter">Համար</th>
					
					<th style="width: 200px;">Պատվերի Գումար</th>
					<th style="width: 200px;">Մուտքի Գումար</th>
					<th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Խումբ</th>
                    <th class="select-filter">Խանութ</th>
                    <th class="select-filter">Հասցե</th>
                    <th class="select-filter">Տարածք</th>
					<th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Հ/Ա</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Խումբ</th>
					<th class="select-filter">Առաքիչ</th>
					<th class="select-filter">Վճ. տիպ</th>


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


<!-- Modal -->
<div class="modal fade" id="delete_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
        Ջնջե՞լ պատվերը
		
		<div id="message_text" style="font-weight: bold; margin-top: 30px;"></div>
		
		<input type="hidden" id="delete_document_id" value=""> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger end_delete_document">Ջնջել</button>
      </div>
    </div>
  </div>
</div>



<script>


$(document).on('change','#document_comment', function(){
	
	var order_comment = $(this).val();
	var document_id = $(this).data("documentid");
	var url = '/api/add_pr_finance.php';
		
    $.ajax({
           type: "POST",
           url: url,
           data: {
				document_id: document_id,
				order_comment: order_comment,
				action: "order_comment"
		   }, 
           success: function(data)
			   {			  

			   }
		   
         });
	
	});

        $('.delete_document').click(function(){
			var document_id = $(this).data('documentid');
			
			$('#delete_document_id').val(document_id);
			$('#delete_document').modal('show');

        });


$(document).ready(function(){
        $('.end_delete_document').click(function(){
			
			var delete_document_id = $('#delete_document_id').val();
			
			$.ajax({
				type: "POST",
				url: "api/add_warehouse_order_edit.php",
				data: {delete_document_id:delete_document_id, action:'delete_document'},
				success: function(data)
				{
					var get_data = JSON.parse(data);
					
					$('#message_text').html(get_data[0]);
					
					if(get_data[1] == '1'){
						window.location.reload();
					}
					
				   //alert(data); 
				   //window.location.reload();
				}
			   
			});
			
			
			
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
				var j = 3;
				while(j < 5){
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
		  
		"order": [[ 0, "desc" ]],
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
