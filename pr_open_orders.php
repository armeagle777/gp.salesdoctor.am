<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);
$order_type = mysqli_real_escape_string($con, $_GET['order_type']);

$cash = mysqli_real_escape_string($con, $_GET['cash']);
$credit = mysqli_real_escape_string($con, $_GET['credit']);
$debt = mysqli_real_escape_string($con, $_GET['debt']);
$network_orders = mysqli_real_escape_string($con, $_GET['network_orders']);

$group_orders = mysqli_real_escape_string($con, $_GET['group_orders']);

$shop_id = mysqli_real_escape_string($con, $_GET['shop_id']);

$group_selected = mysqli_real_escape_string($con, $_GET['group_id']);

$selected_region = mysqli_real_escape_string($con, $_GET['region']);
$selected_district = mysqli_real_escape_string($con, $_GET['district']);
$selected_shop = mysqli_real_escape_string($con, $_GET['shop']);


if(isset($shop_id) and $shop_id !=''){
	$query_shop_id = " AND shops.shop_id = '$shop_id' ";
}else{
	$query_shop_id = '';	
}

if($cash == 'on' && $credit == '' && $debt == '' ){
	$query_paytype_select = " AND (pay_type = '1' or pay_type = '2') ";
}

if($cash == '' && $credit == '' && $debt == 'on' ){
	$query_paytype_select = " AND (pay_type = '3' or pay_type = '4') ";
}

if($cash == '' && $credit == 'on' && $debt == '' ){
	$query_paytype_select = " AND (pay_type = '5' or pay_type = '6') ";
}


if($cash == 'on' && $credit == 'on' && $debt == '' ){
	$query_paytype_select = " AND (pay_type = '1' or pay_type = '2' or pay_type = '5' or pay_type = '6') ";
}

if($cash == 'on' && $credit == '' && $debt == 'on' ){
	$query_paytype_select = " AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4') ";
}

if($cash == 'on' && $credit == 'on' && $debt == 'on' ){
	$query_paytype_select = " AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4' or pay_type = '5' or pay_type = '6') ";
}

if($cash == '' && $credit == 'on' && $debt == 'on' ){
	$query_paytype_select = " AND (pay_type = '3' or pay_type = '4' or pay_type = '5' or pay_type = '6') ";
}


if($network_orders == 'on' ){
	$query_network_orders = " AND shops.network != '0' ";
}else{
	$query_network_orders = " AND shops.network = '0' ";	
}

if($group_orders == 'on' ){
	$query_group_orders = " AND group_to_shop.group_id > 0 ";
}


if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND pr_orders_document.manager_id = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}


if($group_selected != 0 AND $group_selected != ''){
	$query_group_selected = " AND pr_orders_document.product_group = '$group_selected' ";
}else{
	$query_group_selected = '';
}


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

if($_SESSION['user_role'] == '5'){
	$current_courier_id = $_SESSION['user_id'];
	$query_current_courier = " AND pr_orders_document.courier_id = '$current_courier_id' ";
}else{
	$query_current_courier = '';
}

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Չվճարված պատվերներ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="#" onclick="window.print()" class="btn btn-success" style="margin-right: 20px;"><i class="fa fa-print"></i></a>
			<a href="/pr_finance.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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

              <!-- /.card-header -->
              <div class="card-body">
			  
				 <form action="/pr_open_orders.php" id="statistics_form"> 
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
						
											  					  
					 <div class="form-group col-md-1"  style="text-align: center;">
								<label for="login">Պարտք</label>
								<input type="checkbox" name="debt" id="debt" <?php if($debt == 'on'){ echo "checked"; } ?>>
					  </div>
					  
					 <div class="form-group col-md-1" style="text-align: center;">
								<label for="login">Կանխիկ</label>
								<input type="checkbox" name="cash" id="cash" <?php if($cash == 'on'){ echo "checked"; } ?>>
					  </div>					
					  
					 <div class="form-group col-md-1"  style="text-align: center;">
								<label for="login">Կրեդիտ</label>
								<input type="checkbox" name="credit" id="credit" <?php if($credit == 'on'){ echo "checked"; } ?>>
					  </div>		
					  
					 <div class="form-group col-md-1"  style="text-align: center;">
								<label for="network_orders">Ցանցեր</label>
								<input type="checkbox" name="network_orders" id="network_orders" <?php if($network_orders == 'on'){ echo "checked"; } ?>>
					  </div>
					  
					 <div class="form-group col-md-1"  style="text-align: center;">
								<label for="group_orders">Խմբեր  </label>
								<input type="checkbox" name="group_orders" id="group_orders" <?php if($group_orders == 'on'){ echo "checked"; } ?>>
					  </div>

					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  <input type="hidden" name="order_type" value="<?php echo $order_type; ?>">
					  
					  
					
					</div>
				
				
				  </form>
			  
			  
			  
			  <form id="add_finance" action="/api/add_pr_finance.php" style="margin-top: 30px;">
			  
				<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
				
				<div class="form-row">
				 <div class="form-group col-md-3">
							<label for="address">Գումարի մուտք</label>
							<input type="text" class="form-control product_count" id="input_summ" name="input_summ" placeholder="Գումար" >
				  </div>
				  
				  
				  		  <div class="form-group col-md-3">
							<label for="address">Դրամարկղ / բանկ</label>
							<select name="payer_payment_type" id="payer_payment_type" class="form-control">
								<option value="0">Ընտրել</option>
								<option value="1">Դրամարկղ</option>
								<option value="2">Բանկ</option>
							</select>
				  </div>
				  
				  
				  
				    
				  <div class="form-group col-md-2">
							<label for="address">Բանկ</label>
							<select name="payer_payment_bank" id="payer_payment_bank" class="form-control">
								<option value="0">Ընտրել</option>
								<?php 
									$query_bank = mysqli_query($con, "SELECT * FROM pr_bank");
									while($bank_array = mysqli_fetch_array($query_bank)):
								?>
								<option value="<?php echo $bank_array['id'] ?>"><?php echo $bank_array['bank_name']; ?></option> 
								<?php endwhile; ?>
							</select>
				  </div>
				  
				  
				  
				  <div class="form-group col-md-3">

				 <button type="submit" class=" btn btn-primary" style="margin-top: 30px;">Մուտքագրել</button>
				  </div>
				
				
				</div>
				
		
				
				
				<div class="form-row">
				 <div class="form-group col-md-6" style="display:none;">
						Նշված պատվերների գումաը՝ <b><span id="total">0</span></b>
				</div>
				
			</form>
		
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
					<th style="width: 86px;">Ընտրել</th>
					<th style="width: 150px;">Խմբագրել</th>
					<th class="select-filter">ID</th>
					<th class="select-filter">Խումբ</th>

                    <th class="select-filter">Խանութ</th>
                    <th class="select-filter">Հասցե</th>
					<th class="select-filter">Հեռախոս</th>
                    <th class="select-filter">Մենեջեր</th>
                    <th>Գումար</th>
					<th class="select-filter">Ամսաթիվ</th>
					<th class="select-filter">Վճարման օր</th>
                    <th class="select-filter">Վճարման տիպ</th>
                    <th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Փաստաթուղթ</th>

					
					</tr>
                  </thead>
                  <tbody>
				  
				 <?php 
				 					
					if($datebeet !=''){
						$query = mysqli_query($con, "SELECT *, manager.name AS manager_name, shops.name AS shop_name,  shops.shop_id AS current_shop_id, shops.phone AS shop_phone, pr_groups.group_name AS product_group_name FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN group_to_shop ON shops.shop_id = group_to_shop.shop_id LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id LEFT JOIN manager ON pr_orders_document.manager_id = manager.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE group_to_shop.shop_id is null AND order_pay_status !='3' $query_paytype_select AND pr_orders_document.document_date $query_date_range $query_district_select $query_region_select $query_shop_select $query_manager_select $query_shop_id $query_network_orders $query_group_orders $query_group_selected $query_current_courier ");

					}
					
					while($orders_array = mysqli_fetch_array($query)):
					
					
					$current_shop_id = $orders_array['current_shop_id'];
					$document_id = $orders_array['document_id'];
					$order_summ = $orders_array['order_last_summ'];
					$document_date = $orders_array['document_date'];
					$pay_date = $orders_array['debt_date'];
					$pay_type = $orders_array['payment_name'];
					$shop_name = $orders_array['shop_name'];
					$shop_address = $orders_array['address'];
					$manager_name = $orders_array['manager_name'];
					$order_comment = $orders_array['order_comment'];
					$shop_phone = $orders_array['shop_phone'];
					$product_group_name = $orders_array['product_group_name'];
					$order_type = $orders_array['order_type'];
								
				 ?> 
				  
					<tr>
				  
						<td><input type="checkbox" class="document" id="<?php echo $document_id; ?>" value="<?php echo $order_summ; ?>"></td>
						<td>
						
						<a href="/view_order.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i></a>
						
						<a href="/warehouse_exit.php?document_id=<?php echo $document_id; ?><?php if ($order_type == '2'){ echo "&order_type=2"; }?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="far fa-file"></i></i></a>
						 <?php
							$query_check_full_pay = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) as payed_summ FROM pr_orders_finance WHERE payed_document_id = '$document_id' "));
							if($query_check_full_pay['payed_summ'] < $order_last_summ AND $order_pay_status == '3'){
								echo '<button class="btn btn-warning btn-sm rounded-0"><i class="fas fa-check"></i></button>';
							}elseif($query_check_full_pay['payed_summ'] >= $order_last_summ AND $order_pay_status == '3'){
								echo '<button class="btn btn-success btn-sm rounded-0"><i class="fas fa-check"></i></button>';
							}else{
								echo '<button class="btn btn-danger btn-sm rounded-0"><i class="fas fa-window-close"></i></button>';
							}					
						?>
						</td>

						<td><?php echo $current_shop_id; ?></td>
						<td><?php echo $product_group_name; ?></td>
						<td><?php echo $shop_name; ?></td>
						<td><?php echo $shop_address; ?></td>
						<td><?php echo $shop_phone; ?></td>
						<td><?php echo $manager_name; ?></td>
						<td><?php echo $order_summ; ?></td>
						<td><?php echo $document_date; ?></td>
						<td><?php echo $pay_date; ?></td>
						<td><?php echo $pay_type; ?></td>
						<td><textarea id="document_comment" data-documentid="<?php echo $document_id; ?>" class="form-control"><?php echo $order_comment; ?></textarea></td>
						<td><?php echo $document_id; ?></td>

					</tr>
                 
				 <?php endwhile; ?>
                  </tbody>
                  <tfoot>
                  <tr>
				  <th style="width: 86px;">Ընտրել</th>
					<th style="width: 86px;">Խմբագրել</th>
					<th  class="select-filter">ID</th>
					<th  class="select-filter">Խումբ</th>
                    <th class="select-filter">Խանութ</th>
                    <th class="select-filter">Հասցե</th>
                    <th class="select-filter">Հեռախոս</th>
                    <th class="select-filter">Մենեջեր</th>
                    <th>Գումար</th>
					<th class="select-filter">Ամսաթիվ</th>
					<th class="select-filter">Վճարման օր</th>
                    <th class="select-filter">Վճարման տիպ</th>
                    <th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Փաստաթուղթ</th>


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
<!-- jQuery -->
<script src="/dist/js/jquery.tableTotal.js"></script>



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

 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });
 

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

$(document).on('keyup','#input_summ', function(){
	
	var check = $('td').find('.document:checked').length;
	if(check > 1){
		$( ".document" ).prop( "checked", false );
		document_obj = {};
	}
});



document_obj = {};
$(document).on('change','.document', function(){
		var pdocument_id = this.id;
		var order_sum = $(this).val();

	 if(this.checked) {

		document_obj[pdocument_id] = order_sum;
		
	}else{
		document_obj[pdocument_id] = '';
	}
});


$('.document').change(function ()
{
      var total = 0;
      $('input:checkbox:checked').each(function(){
       total += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
      });   
  
      $("#input_summ").val(total);
});


$("#add_finance").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');
	var input_summ = $('#input_summ').val();
	
	var shop_id = $('#shop_id').val();
	var product_group = $('#product_group').val();
	var product_payment = $('#product_payment').val();

	var payer_payment_type = $('#payer_payment_type').val();
	var payer_payment_bank = $('#payer_payment_bank').val();

	
	if(payer_payment_type == '0'){
		$('#payer_payment_type').addClass('border border-danger');
		return false;
	}else{
		$('#payer_payment_type').removeClass('border border-danger')
	}

	
	if (input_summ == '' || input_summ < 0 || input_summ == 0){
		$('#input_summ').addClass('border border-danger');
		return false;
	}else{
		$('#input_summ').removeClass('border border-danger')
	}
	
	if (product_payment == ''){
		$('#product_payment').addClass('border border-danger');
		return false;
	}
	
	if (shop_id == ''){
		$('#shop_id').addClass('border border-danger');
		//return false;
	}
   
	var check = $('td').find('.document:checked').length;
	
    $.ajax({
           type: "POST",
           url: url,
           data: {
				documents: JSON.stringify(document_obj),
				shop_id: shop_id,
				input_summ: input_summ,
				payer_payment_type: payer_payment_type,
				payer_payment_bank: payer_payment_bank,
				type: 'add_finance',
				user_id: <?php echo $_SESSION['user_id']; ?>,
				orders_count: check
		   }, 
           success: function(data)

           {
				document.location.reload();

               //alert(data); 
			 //  $('#shop_id').removeClass('border border-danger');
			 //  $('#qr_id').removeClass('border border-danger');
			 //  $('.success_message').text(data);
			   //$('.modal_answere').click();
			//   window.location.replace("/shops.php");

			  // $('.alert').show()
			  

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
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
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
<style>
.dataTables_wrapper{
	width: 100%;
}
</style>
</body>
</html>
