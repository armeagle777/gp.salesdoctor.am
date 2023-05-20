<?php include 'header.php'; ?>
<?php

	include 'api/db.php';
	$order_type = mysqli_real_escape_string($con, $_GET['order_type']);

	$document_id = mysqli_real_escape_string($con, $_GET['document_id']);
	
	$query_document_detalis = mysqli_query($con, "SELECT * FROM pr_orders_document WHERE document_id = '$document_id' ");
	$document_details_array = mysqli_fetch_array($query_document_detalis);
	
	if($_SESSION['user_role'] == '3' ){
		$disabled = 'disabled';
	}else{
		$disabled = '';
	}
	
	if($_SESSION['user_role'] != '3' ){
		$disabled_other = 'disabled';
	}else{
		$disabled_other = '';
	}
	
	
	$document_details_query = mysqli_query($con, "SELECT *, shops.discount AS shop_discount, shops.name AS shop_name, manager.name AS manager_name FROM pr_orders_document LEFT JOIN shops on pr_orders_document.shop_id = shops.shop_id LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id LEFT JOIN manager ON pr_orders_document.manager_id = manager.id LEFT JOIN district ON shops.district = district.id WHERE document_id = '$document_id'");

	$document_details = mysqli_fetch_array($document_details_query);

	
	
?>
<div class="loading" style="display: none;">Loading&#8230;</div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php if($order_type == '2'){ echo "Ապրանքի վերադարձ"; }else {echo "Ապրանքների ելք պահեստից"; } ?></h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
				<button onclick="history.go(-1)" class="btn btn-info"><i class="fa fa-window-close"></i></button>
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
              <div class="card-header" style="">
			<p style="text-align: center;">  Պատվեր <b>No <?php echo $document_id; ?> <br> <?php $today = date("d.m.y");  echo $today; ?></b>  </p>
			  <div class="form-row col-md-12">

				<div class="form-group col-md-6" style="">
                  <label>Խանութ</label>
				  <p><?php echo $document_details['shop_id']; ?>.<?php echo $document_details['shop_name']; ?>, <?php echo $document_details['address']; ?>, <?php echo $document_details['district_name']; ?> </p>
				</div>
				 <div class="form-group col-md-3" id="date_range_picker1" style="">
                  <label>Պատվերի օր</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="order_start_date" value="<?php echo $document_details['document_date'] ?>" name="order_start_date" required <?php echo $disabled; ?>>
                  </div>
                  <!-- /.input group -->
                </div>	

				 <div class="form-group col-md-3" id="date_range_picker">
                  <label>Վճարման օր</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="depb_date" value="<?php echo $document_details['debt_date'] ?>"  name="depb_date" required <?php echo $disabled; ?>>
                  </div>
                  <!-- /.input group -->
                </div>	


				
			  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form id="warehouse_coming" action="api/add_warehouse_exit.php">
			  
			  <div class="form-row">
			  
			  <div class="form-group col-md-4">
				<label for="address">Պահեստ</label>

					<select name="warehouse" id="warehouse" class="form-control" <?php echo $disabled_other; ?>>
						<option value="0"> Ընտրել </option>
							<?php 
								$query_warehouse = mysqli_query($con, "SELECT * FROM pr_warehouse ORDER by id DESC");
								while ($array_warehouse = mysqli_fetch_array($query_warehouse)):
								$warehouse_id = $array_warehouse['id'];
								$warehouse_name = $array_warehouse['warehouse_name'];
							?> 
							 
						<option value="<?php echo $warehouse_id; ?>" <?php if($document_details_array['warehouse_id'] == $warehouse_id){ echo "selected"; } ?> ><?php echo $warehouse_name; ?></option>
				
						<?php endwhile; ?>
				
					</select>

			  </div>  
			  
			  <div class="form-group col-md-4">
				<label for="address">Առաքիչ</label>

					<select name="courier" id="courier" class="form-control">
						<option value="0"> Ընտրել </option>
							<?php 
								$query_courier = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '5' ORDER by id DESC");
								while ($array_regions = mysqli_fetch_array($query_courier)):
								$courier_id = $array_regions['id'];
								$courier_name = $array_regions['login'];
							?> 
							 
						<option value="<?php echo $courier_id; ?>" <?php if($document_details_array['courier_id'] == $courier_id){ echo "selected"; } ?>><?php echo $courier_name; ?></option>
				
						<?php endwhile; ?>
				
					</select>

			  </div>    
			  
			  <div class="form-group col-md-4">
				<label for="address">Վճարման տիպ</label>

					<select name="payment_type" id="payment_type" class="form-control" data-documentid="<?php echo $document_details_array['document_id']; ?>" <?php echo $disabled; ?> >
							<?php 
								$query_order_type = mysqli_query($con, "SELECT * FROM pr_payment_type ");
								while ($array_order_type = mysqli_fetch_array($query_order_type)):
								$order_type_id = $array_order_type['id'];
								$order_type_name = $array_order_type['payment_name'];
							?> 
							 
						<option value="<?php echo $order_type_id; ?>" <?php if($document_details_array['pay_type'] == $order_type_id){ echo "selected"; } ?>><?php echo $order_type_name; ?></option>
				
						<?php endwhile; ?>
				
					</select>

			  </div>    
			   
			</div>
			
			
					<div class="form-row">
					  <div class="form-group col-md-8">
						<label for="barcode">Շտրիխ կոդ</label>
						<input type="text" class="form-control" id="barcode" name="barcode" placeholder="Շտրիխ կոդ" autofocus <?php echo $disabled_other; ?>>
					  </div>
					  
					  <div class="form-group col-md-4">
						<label for="name">Ավելացնել</label>
						<br>
						<button type="submit" class="btn btn-primary">Ավելացնել</button>

					  </div>
					</div>
					
					<div class="form-row error_div" style="display: none;">
					  <div class="form-group col-md-8" style="color: #f00; font-size: 35px;">
						Պահեստում չկա տվյալ քանակությամբ ապրանք
					  </div>
					</div>					
					<div class="form-row error_div_avel" style="display: none; font-size: 35px;">
					  <div class="form-group col-md-8" style="color: #f00;">
						Քանակը լրացել է
					  </div>
					</div>
					
					<div class="form-row error_div_chka" style="display: none; font-size: 35px;">
					  <div class="form-group col-md-8" style="color: #f00;">
						Ապրանքը ցուցակում չկա
					  </div>
					</div>

			<input type="hidden" name="action" id="action" value="add">
			
			<input type="hidden" name="document_id" id="document_id" value="<?php echo $document_id; ?>">
			
	
			</form>
	   
	   
	   




                <table id="example_0" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
                    <th>Խումբ</th>
					<th>Անվանում</th>
					<th>Ելքի քանակ</th>
					<th>Քանակ</th>
                    <th>Զեղչ</th>
					<th>Զեղչված գին</th>
					<th>Գին</th>
					<th>Ընդհամենը</th>
					<th>Նախնական գումար</th>
					<th>Export կոդ</th>
					<th>Քանակ</th>
					<th>Գումար</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query = mysqli_query($con, "SELECT * FROM pr_orders WHERE document_id = '$document_id' ");
					while($document_array = mysqli_fetch_array($query)):
					
					$shop_id = $document_array['shop_id'];
					$manager_id = $document_array['manager_id'];
					$product_id = $document_array['product_id'];
					$product_count = $document_array['product_count'];
					$product_count_warehouse = $document_array['product_count_warehouse'];
					$product_procent = $document_array['product_procent'];
					$product_cost = $document_array['product_cost'];
					$product_last_cost = $document_array['product_last_cost'];
					$product_group = $document_array['product_group'];
					
					
					
					
					$warehouse_exit_count = $document_array['product_count_warehouse'];

					$query_products = mysqli_query($con, "SELECT * FROM `pr_products` LEFT JOIN pr_groups on pr_products.product_group = pr_groups.id where pr_products.id = $product_id");
					$products_array = mysqli_fetch_array($query_products);
					
					$total_row = $product_count * $product_cost;
					$total_row_warehouse = $product_count_warehouse * $product_last_cost;
					
					$export_cod = $products_array['id2'];
					
				 ?> 
				  
					<tr>
				  
						
						<td><?php echo $products_array['group_name'] ?></td>
						<td><b style="font-size: 17px;"><?php echo $products_array['name'] ?></b></td>
						
						<td>
						<input type="text" name="warehouse_exit_count" id="warehouse_exit_count" class="form-control product_exit_count_<?php echo $product_id; ?>" style="width:80px;" data-documentid="<?php echo $document_id; ?>" data-productid="<?php echo $product_id; ?>" value="<?php echo $warehouse_exit_count; ?>" data-managerproductcount="<?php echo $product_count; ?>" <?php echo $disabled_other; ?>>
						</td>

						<td>
						<input type="text" name="product_manager_count" id="product_manager_count" class="form-control product_count_<?php echo $product_id; ?>" style="width:80px; font-size: 25px;" data-documentid="<?php echo $document_id; ?>" data-productid="<?php echo $product_id; ?>" value="<?php echo $product_count; ?>" <?php echo $disabled; ?>>
						</td>
						
						<td>
						<input type="text" name="product_discount" id="product_discount" class="form-control" data-documentid="<?php echo $document_id; ?>" data-productid="<?php echo $product_id; ?>" style="width:80px;" value="<?php echo $product_procent; ?>" <?php echo $disabled; ?>>
						</td>
						
						<td class='current_price_<?php echo $product_id; ?>'><?php echo $product_last_cost; ?></td>
						<td class='old_price_<?php echo $product_id; ?>'><?php echo $products_array['sale_price'] ?></td>
						<td class='totals_warehouse total_for_warehouse_exit_<?php echo $product_id; ?>'><?php echo $total_row_warehouse; ?></td>
						<td class='totals total_for_product_<?php echo $product_id; ?>'><?php echo $total_row; ?></td>
						<td><?php echo $export_cod; ?></td>
						<td><?php echo $warehouse_exit_count; ?></td>
						<td><?php echo round($products_array['sale_price'] - ($products_array['sale_price'] / 6), 2); ?></td>
			
					</tr>
                 
				 <?php endwhile; ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
					<th></th>
					<th></th>
					<th></th>
                    <th></th>
					<th></th>
					<th></th>
					<th class='total_warehouse'>0</th>
					<th class='total' style="font-weight: 500;">0</th>
					<th>Export կոդ</th>
					<th>Քանակ</th>
					<th>Գումար</th>
                  </tr>
                  </tfoot>
                </table>
				
				
				
				
				
				
              </div>
			  <div class="card-footer" style="text-align: right;">
			  <div class='ha_div' style="display: none; margin-bottom: 10px; color: #28a745;">Հաշիվ ապրանքագիրը ուղարկված է:</div>
				<?php 
					if($document_details_array['pay_type'] == '2' or $document_details_array['pay_type'] == '4' or $document_details_array['pay_type'] == '6'):
				?>
				
				<input type="button" class="btn btn-success ha_button" value="Հաշիվ ապրանքագիր">
				<input type="hidden" value="<?php echo $document_id; ?>" id="hidden_ha"> 
				<?php
				endif;
				?>
				
				
				
				<a href="/api/warehouse_exit_and_print.php?action=no_print&document_id=<?php echo $document_id; ?>" class="btn btn-success">Հաստատել</a>
				<a href="/api/warehouse_exit_and_print.php?document_id=<?php echo $document_id; ?>" class="btn btn-success"><i class="fa fa-print"></i></a>
				
				
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

<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->


<script>
$(document).ready(function(){
    $(this).scrollTop(500);
});
	var sum = 0.0;
	$('.totals').each(function()
	{
		sum += parseFloat($(this).text());
	});
	
	$('.total').text(sum); 

	var sum2 = 0.0;
	$('.totals_warehouse').each(function()
	{
		sum2 += parseFloat($(this).text());
	});
	
	$('.total_warehouse').text(sum2); 


$(document).on('change','#product_discount', function() {
	
		var transaction_id = $(this).data("documentid");
		var product_id = $(this).data("productid");
		var old_price = $('.old_price_'+product_id).text();
		var discount = $(this).val();
		var current_product_count = $(".product_exit_count_" + product_id).val();
		
		var current_price = old_price - (old_price * (discount / 100));
		var total_for_product = current_price * current_product_count;
		
		$( ".current_price_" + product_id ).text(current_price);
		$( ".total_for_warehouse_exit_" + product_id ).text(total_for_product);
		
		var sum = 0.0;
		
		$('.totals_warehouse').each(function()
		{
			sum += parseFloat($(this).text());
		});

		$('.total_warehouse').text(sum);
		
		
	   $.ajax({
	   type: 'POST',
	   url: '/api/add_warehouse_exit.php',
	   data: {'transaction_id':transaction_id, 'discount': discount, 'product_id': product_id, 'action':'edit_discount', 'product_current': current_price, total: $('.total_warehouse').text() },
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},

	   success: function(data)
	   {
				
	   },
	   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

		 });
		 
	
});

$(document).on('change','#product_manager_count', function() {

	   var transaction_id = $(this).data("documentid");
	   var product_id = $(this).data("productid");
	   var product_count = $(this).val();
	   
	   var current_price = $( ".current_price_" + product_id ).text();
	   var total_for_product = current_price * product_count;
	   $( ".total_for_product_" + product_id ).text(total_for_product);
	   
		var sum = 0.0;
		
		$('.totals').each(function()
		{
			sum += parseFloat($(this).text());
		});

		$('.total').text(sum);
	   
	   $.ajax({
	   type: 'POST',
	   url: '/api/add_warehouse_exit.php',
	   data: {'transaction_id':transaction_id, 'product_count': product_count, 'product_id': product_id,  'action':'edit_count', total: sum },
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},

	   success: function(data)
	   {
				
	   },
	   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

		 });
});


$(document).on('change','#warehouse_exit_count', function() {

	   var transaction_id = $(this).data("documentid");
	   var product_id = $(this).data("productid");
	   var product_count = $(this).val();
	   
		var warehouse = $('#warehouse').val();
		var courier = $('#courier').val();


	   var manager_product_count = $(this).data("managerproductcount");
	   
	   	if(warehouse == '0'){
		$('#warehouse').addClass('border border-danger');
			return false;
		}else{
			$('#warehouse').removeClass('border border-danger');
		}


		if(courier == '0'){
			$('#courier').addClass('border border-danger');
			return false;
		}else{
			$('#courier').removeClass('border border-danger');
		}	
	   
	   if(product_count > manager_product_count){
		   $(this).val(manager_product_count);
	   }
	   	
	

	   var current_price = $( ".current_price_" + product_id ).text();
	   var total_for_product = current_price * product_count;
	   $( ".total_for_warehouse_exit_" + product_id ).text(total_for_product);
	   
		var sum2 = 0.0;
		
		$('.totals_warehouse').each(function()
		{
			sum2 += parseFloat($(this).text());
		});

		$('.total_warehouse').text(sum2);
	   
	   $.ajax({
	   type: 'POST',
	   url: '/api/add_warehouse_exit.php',
	   data: {'transaction_id':transaction_id, 'product_count': product_count, 'product_id': product_id,  'action':'add', 'second_action': 'warehouse_edit', total: sum2, 'warehouse':warehouse, 'courier': courier  },
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},

	   success: function(data)
	   {
			if(data == 'pakas'){
					$(".error_div").css("display","block");
			}else{
				$(".error_div").css("display","none");
			}	
	   },
	   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

		 });
});




$("#warehouse_coming").submit(function(e) {
	
	var sum3 = 0.0;
		
		$('.totals_warehouse').each(function()
		{
			sum3 += parseFloat($(this).text());
		});

	$('.total_warehouse').text(sum3);
	
	
    e.preventDefault(); 
	var total = $('.total_warehouse').text();
	var warehouse = $('#warehouse').val();
	var courier = $('#courier').val();
	
		
	if(warehouse == '0'){
		$('#warehouse').addClass('border border-danger');
		return false;
	}else{
		$('#warehouse').removeClass('border border-danger');
	}


	if(courier == '0'){
		$('#courier').addClass('border border-danger');
		return false;
	}else{
		$('#courier').removeClass('border border-danger');
	}	

    var form = $(this);
    var url = form.attr('action');
	var barcode = $('#barcode').val();
	if (barcode == ''){
		$('#barcode').addClass('border border-danger');
		return false;
	}
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize() + '&total=' + sum3, 
           success: function(data)
           {	
				if(data == ''){
					$("#barcode").val("");
					$('#barcode').addClass('border border-danger');
					$(".error_div_chka").css("display","block");
					var audio = new Audio('/zvuk1.mp3');
					audio.play();

					return false;
				}
				
				if(data == 'yes'){
					location.reload();
				}
				
				if(data == 'pakas'){
					$(".error_div").css("display","block");
				}else{
					$(".error_div").css("display","none");
				}	
				
				if(data == 'avel'){
					$(".error_div_avel").css("display","block");
					var audio = new Audio('/zvuk1.mp3');
					audio.play();
				}else{
					$(".error_div_avel").css("display","none");
				}
				
				
			   $("#barcode").val("");
			   				
			   $('#barcode').removeClass('border border-danger');

           }
		   
         });
});
   
   $(".transaction_update").click(function(e) {
	   
	   var transaction = $(this);
	   var transaction_id = transaction.attr('id');
	   alert(transaction_id);
   });
   
   
   
$(document).on('click','.ha_button', function() {
	   	
	   var transaction_id = $('#hidden_ha').val();
	
	   $.ajax({
	   type: 'POST',
	   url: '/generate_ha.php',
	   data: {'transaction_id':transaction_id, 'action':'generate'},
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},

	   success: function(data)
	   {
			if(data == 'ok'){
				$(".ha_div").css("display","block");
			}
	   },
	   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

		 });
});   

$(document).on('change','#payment_type', function() {
	   	
	   var payment_type = $(this).val();
	   var transaction_id = $(this).data("documentid");
	   $.ajax({
	   type: 'POST',
	   url: '/api/add_warehouse_exit.php',
	   data: {'transaction_id':transaction_id, 'payment_type': payment_type, 'action':'change_payment_type'},
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},

	   success: function(data)
	   {
			
	   },
	   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

		 });
});


$(document).on('change','#depb_date, #order_start_date', function() {
	   	
	   var depb_date = $('#depb_date').val();
	   var order_start_date = $('#order_start_date').val();
	   var transaction_id = $('#document_id').val();
	   $.ajax({
	   type: 'POST',
	   url: '/api/add_warehouse_exit.php',
	   data: {'transaction_id':transaction_id, 'depb_date': depb_date, 'order_start_date': order_start_date, 'action': 'edit_document_dates'},
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},

	   success: function(data)
	   {
			
	   },
	   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

		 });
});

var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today.getDate()+1);
    var nextmonth=new Date();
    nextmonth.setMonth(nextmonth.getMonth()+1);


$('#depb_date').daterangepicker({
	  //autoUpdateInput: false,
      //minDate: tomorrow,

	locale: {
		format: 'YYYY-MM-DD', 
		firstDay: 1,
		cancelLabel: 'Clear'
    },
    singleDatePicker: true,
    showDropdowns: true,
});

    


$('#order_start_date').daterangepicker({
        "timePicker": true,
        "timePicker24Hour": true,


	  //autoUpdateInput: false,
     // minDate: tomorrow,
     // maxDate: nextmonth,

	locale: {
		
		format: 'YYYY-MM-DD H:mm', 
		firstDay: 1,
		cancelLabel: 'Clear',

    },
	
    singleDatePicker: true,
	setDate: "+1d",
    showDropdowns: true,
	//startDate: moment().startOf('hour'),
    //endDate: moment().startOf('hour').add(32, 'hour')

});

   
   
</script>
</body>
</html>
