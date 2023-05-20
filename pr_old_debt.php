<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	

	

	
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
				Հին պարտք
			</h1>
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
				<div class="alert alert-success alert-dismissible fade show" style="display: none;" role="alert" id="success_message">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				 

				</div>


              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
			   
	   
				<div class="form-row">
						
						  <div class="form-group col-md-6">
							<label for="address">Մարզ</label>

								<select name="region" id="region" class="form-control">
									<option value="0"> Ընտրել </option>
										<?php 
											$query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
											while ($array_regions = mysqli_fetch_array($query_region)):
											$region_id = $array_regions['id'];
											$region_name = $array_regions['region_name'];
										?> 
										 
									<option value="<?php echo $region_id; ?>"> <?php echo $region_name; ?></option>
							
									<?php endwhile; ?>
							
								</select>

						  </div>




				  <div class="form-group col-md-6">
					<label for="district">Տարածք</label>
						
					<select name="district" id="district" class="form-control">

						<option>Ընտրել</option>
					
					</select>
					
				  </div>
				  
				  <div class="form-group col-md-6">
					<label for="shop">Խանութ</label>
						
					<select name="shop" id="shop" class="form-control">

						<option value="0">Ընտրել</option>
					
					</select>
					
				  </div>

				
				  <div class="form-group col-md-6">
					<label for="product_group">Ապրանքների խումբ</label>
						
					<select name="product_group" id="product_group" class="form-control">

						<option value="0">Ընտրել</option>
						<?php 
						
						$query_product_group = mysqli_query($con, "SELECT * FROM pr_groups");
						while($array_pr_groups = mysqli_fetch_array($query_product_group)){
							echo "<option value='{$array_pr_groups['id']}'>{$array_pr_groups['group_name']}</option>";
						}
						
						?>
					
					</select>
					
				  </div>
				  
				  <div class="form-group col-md-6">
					<label for="product_payment">Վճարման տիպ</label>
						
					<select name="product_payment" id="product_payment" class="form-control">

						<option value="">Ընտրել</option>
						<?php 
						
						$query_product_payment = mysqli_query($con, "SELECT * FROM pr_payment_type");
						while($array_pr_payment = mysqli_fetch_array($query_product_payment)){
													
							echo "<option value='{$array_pr_payment['id']}'>{$array_pr_payment['payment_name']}</option>";
						}
						
						?>
					
					</select>
					
				  </div>	
				  
				  <div class="form-group col-md-6">
					<label for="product_payment">Մեկնաբանություն</label>
						
						<label for="summ">Մեկնաբանություն</label>
						<input type="text" class="form-control" id="comment" name="comment" placeholder="Մեկնաբանություն" value="">

					
				  </div>	
 
						  
						  
			   </div>
			   
				<div class="form-row">
						  <div class="form-group col-md-6">
							<label for="summ">Գումար</label>
							<input type="text" class="form-control" id="summ" name="summ" placeholder="Գումար" value="">
						  </div>
			   </div>	
			 <div id="message" style="display: none; padding-bottom: 10px;">Պարտքը ավելացել է </div>
			  
			  <button type="submit" class="btn btn-primary add_debt">Ավելացնել</button>
	
			
	   
			   
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


$( ".add_debt").click(function() {
	
	var	shop_id = $('#shop').val();
	var	product_group = $('#product_group').val();
	var	product_payment = $('#product_payment').val();
	var	summ = $('#summ').val();
	var	comment = $('#comment').val();


	if (product_payment == ''){
		$('#limits').addClass('border border-danger');
		return false;
	}else{
		$('#limits').removeClass('border border-danger');
	}
			
	if (product_group == ''){
		$('#product_group').addClass('border border-danger');
		return false;
	}else{
		$('#product_group').removeClass('border border-danger');
	}
	
	if (shop_id == '0'){
		$('#shop').addClass('border border-danger');
		return false;
	}else{
		$('#shop').removeClass('border border-danger');
	}	
	
	if (summ == '0'){
		$('#summ').addClass('border border-danger');
		return false;
	}else{
		$('#summ').removeClass('border border-danger');
	}

	var url = 'api/pr_old_debt.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {shop_id:shop_id, product_group:product_group, product_payment:product_payment, summ:summ, comment: comment, action:'add_old_debt'}, 
           success: function(data)
           {
			   
			$("#message").css("display", "block");
			$('#summ').val('');
			 // alert(get_data[1]);

           }
		   
         });
});


 
</script>
</body>
</html>
