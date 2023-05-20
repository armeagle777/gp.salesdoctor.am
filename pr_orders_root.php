<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$courier_select = mysqli_real_escape_string($con, $_GET['courier_select']);
$curr_date = mysqli_real_escape_string($con, $_GET['datebeet']);



if($_SESSION['user_role'] == '5'){
	$current_courier_id = $_SESSION['user_id'];
	$query_current_courier = " AND pr_orders_document.courier_id = '$current_courier_id' ";
}else{
	$query_current_courier = '';
}

//SELECT *, shops.name AS shop_name, shops.shop_id as cur_shop_id FROM pr_orders_document LEFT JOIN pr_courier ON pr_orders_document.courier_id = pr_courier.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id


					
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
            <h1>Root տպել</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="#" class="btn btn-success print_root" style="margin-right: 10px;"><i class="fa fa-print"></i></a> 
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
			  
			  
			  
			    
				 <form action="" id="statistics_form" name="form_submit" class="root_header"> 
				  <div class="form-row">
				  
				 <div class="form-group col-md-3">
                  <label>Ժամանակահատված</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation" value="<?php echo $curr_date; ?>" name="datebeet">
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
				  

		
				 
					  <div class="form-group col-md-2" <?php if($_SESSION['user_role'] == '5'){ echo "style='display: none;'"; } ?>>
								<label for="login">Առաքիչ</label>
								<select name="courier_select" id="manager_select" class="form-control" >
								<option value="0"> Ընտրել </option>
									<?php 
										$query_courier = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '5' ORDER by id DESC");
										while ($array_courier = mysqli_fetch_array($query_courier)):
										$courierr_id = $array_courier['id'];
										$courier_name = $array_courier['login'];
									?> 
									 
									<option value="<?php echo $courierr_id; ?>" <?php if($courier_select == $courierr_id){echo "selected"; } if($_SESSION['user_role'] == '5'){ if($current_courier_id == $courierr_id){echo "selected";}} ?> > <?php echo $courier_name; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>

					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>			
					</div>
				  </form>
			  
			  		    <table class='table' style="">
			  
			  <tr> 
				
				<td style="border-top: 0">
					Առաքիչ՝ <?php 
								$query_cur_courier = mysqli_query($con, "SELECT * FROM manager WHERE id = '$courier_select' ");
								$array_cur_courier = mysqli_fetch_array($query_cur_courier);
								echo $array_cur_courier['name']; 
							?>
				</td>
				<td style="border-top: 0">Օրը՝ <?php echo $curr_date;  ?></td>
			  
			  </tr>
			  
			  </table>
			  
              </div>
              <!-- /.card-header -->
			  
			  
	
			  
              <div class="card-body">
			
			  
			  
			
			  
		
				<?php
					
					
						if($curr_date !=''){
							$query_districts = mysqli_query($con, "SELECT *, 
							district.id AS cur_district_id 
							FROM `pr_orders_document` 
							LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id 
							LEFT JOIN district ON shops.district = district.id 
							WHERE pr_orders_document.courier_id = '$courier_select' AND document_date LIKE '$curr_date%' GROUP BY district");
						}else{
							$query_districts = '';
						}
						while($district_array = mysqli_fetch_array($query_districts)):
						
							$district_id = $district_array['id'];
							$district_name = $district_array['district_name'];
						
						echo " 
						<b>$district_name</b><br><br>
						<table id='example1' class='table table-bordered table-striped' style='margin-bottom: 40px;'>
                  <thead>
                  <tr>
				  
                    <th>Հաշիվ</th>
                    <th>Խումբ</th>
					<th style='width: 200px;'>Գնորդ</th>
                    <th style='width: 350px;'>Հասցե</th>
					<th style='width: 170px;'>Վճ. տիպ</th>
					<th>Գումարը</th>
					<th>Նշում</th>

                  </tr>
                  </thead>
                  <tbody>";
						
						
							
							$query_data = mysqli_query($con, "SELECT *,
							shops.name AS shop_name, shops.shop_id as cur_shop_id 
							FROM pr_orders_document 
							LEFT JOIN pr_courier ON pr_orders_document.courier_id = pr_courier.id
							LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id 
							LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id 
							LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id 
							WHERE pr_orders_document.courier_id = '$courier_select' 
							AND document_date LIKE '$curr_date%'
							AND shops.district = '$district_id' ");
							
							$document_count = mysqli_num_rows($query_data);
							
							$order_total = 0;
							$cash_total = 0;
							
							while($data_array = mysqli_fetch_array($query_data)):
							if($data_array['order_type'] == '1'){
								$order_total = $order_total + $data_array['order_last_summ'];
								if($data_array['pay_type'] == '1' or $data_array['pay_type'] == '2'){
								$cash_total = $cash_total + $data_array['order_last_summ'];
								}
							}

				?>
			  
				<tr <?php if($data_array['order_type'] != '1') {echo "style=' font-weight: bold; font-style: italic;' "; } ?>>
					<td><?php echo $data_array['document_id']; ?> </td>
					<td><?php echo $data_array['group_name']; ?> </td>
					<td><?php echo $data_array['cur_shop_id']; ?>. <?php echo $data_array['shop_name']; ?> </td>
					<td><?php echo $data_array['address']; ?> </td>
					<td><?php echo $data_array['payment_name']; ?> </td>
					<td><?php echo round($data_array['order_last_summ'], 2); ?> </td>
					<td><?php echo $data_array['order_comment']; ?> </td>
				</tr>
                  
				
				<?php 				
				endwhile;
				
				echo "
				
				<tbody>
				  
				 
				 
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Քանակ՝ $document_count</th>
					<th></th>
					<th></th>
					<th></th>
					<th>Կանխիկ<br> Ընդհանուր</th>
					<th>$cash_total<br>$order_total</th>
					<th></th>
                  </tr>
                  </tfoot>
                </table>
				
				
				";
				
				$all_order_total = $all_order_total + $order_total;
				$all_order_total_cache = $all_order_total_cache + $cash_total;
				$all_order_count = $all_order_count + $document_count;
				
				endwhile;
				echo "Ընդհանուր քանակ՝ <b>$all_order_count</b> | ";
				echo "Ընդհանուր կանխիկ գումար՝ <b>$all_order_total_cache</b> | ";
				echo "Ընդհանուր գումար՝ <b>$all_order_total</b>";
				?>
				
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
<?php 

if($courier_select == ''){
	
	
}else{
	
	echo "
	$(window).on('load', function() {
		window.print();
	});
	";
}

?>

$('.print_root').click(function(){
	window.print();
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
	  //autoUpdateInput: false,

	locale: {
		format: 'YYYY-MM-DD', 
		firstDay: 1,
		cancelLabel: 'Clear'
    },
    singleDatePicker: true,
    showDropdowns: true,
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
	
	

 




</script>
</body>
</html>
