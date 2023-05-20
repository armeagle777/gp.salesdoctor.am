<?php include 'header.php'; ?>
<?php
	include 'api/db.php';

	
?>
<div class="loading" style="display: none;">Loading&#8230;</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1>
				Ապրանքների տեղաշարժ պահեստներում 
			</h1>
          </div>
          <div class="col-sm-4 d-flex justify-content-end">
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
						
		
				  <div class="form-group col-md-3">
					<label for="product_group">Ապրանքների խումբ</label>
						
					<select name="product_group" id="product_group" class="form-control">

						<option>Ընտրել</option>
						<?php 
						
						$query_product_group = mysqli_query($con, "SELECT * FROM pr_groups");
						while($array_pr_groups = mysqli_fetch_array($query_product_group)){
							echo "<option value='{$array_pr_groups['id']}'>{$array_pr_groups['group_name']}</option>";
						}
						
						?>
					
					</select>
					
				  </div>
				  
				  <div class="form-group col-md-6">
					<label for="product">Ապրանք</label>
						
					<select name="product" id="product" class="form-control">

						<option>Ընտրել</option>
					
					
					</select>
					
				  </div>
				  				  
				  <div class="form-group col-md-3">
					<label for="product_count">Տեղափողվող Քանակ</label>
						
						<input type="number" class="form-control" name="product_count" id="product_count">
						
				  </div>
				  <br> <br>
					<br> <br>
		
					  <div class="form-group col-md-6">
							<label for="warehouse_from">Ո՞ր պահեստից</label>
								<select name="warehouse_from" id="warehouse_from" class="form-control">
									<option value="0"> Ընտրել </option>
								
										<?php 
										if($_SESSION['user_role'] == '3'){
											$user_id = $_SESSION['user_id'];
											$query_from = mysqli_query($con, "SELECT * FROM pr_warehouse WHERE warehouse_man = '$user_id' ORDER by id DESC");
										}else{
											$query_from = mysqli_query($con, "SELECT * FROM pr_warehouse ORDER by id DESC");
										}
										
											while ($array_from = mysqli_fetch_array($query_from)):
											$from_id = $array_from['id'];
											$from_name = $array_from['warehouse_name'];
										?> 
										 
									<option value="<?php echo $from_id; ?>"> <?php echo $from_name; ?></option>
							
									<?php endwhile; ?>
							
								</select>

						  </div>




				  <div class="form-group col-md-6">
					<label for="warehouse_to">Ո՞ր պահեստ</label>
						
					<select name="warehouse_to" id="warehouse_to" class="form-control">
									<option value="0"> Ընտրել </option>
										<?php 
										if($_SESSION['user_role'] == '3'){
											$user_id = $_SESSION['user_id'];
											$query_from = mysqli_query($con, "SELECT * FROM pr_warehouse WHERE warehouse_man = '$user_id' ORDER by id DESC");
										}else{
											$query_from = mysqli_query($con, "SELECT * FROM pr_warehouse ORDER by id DESC");
										}

										while ($array_to = mysqli_fetch_array($query_to)):
											$to_id = $array_to['id'];
											$to_name = $array_to['warehouse_name'];
										?> 
										 
									<option value="<?php echo $to_id; ?>"> <?php echo $to_name; ?></option>
							
									<?php endwhile; ?>
							
								</select>
					
				  </div>
				   <div class="form-group col-md-6">
				   Առքա քանակը որ պահեստից՝ <b><span class="count_from"> </span></b>
				   </div>
				   <div class="form-group col-md-6">
				   Առքա քանակը որ պահեստ՝ <b><span class="count_to"> </span></b>
				   </div>
					
				
				
	
		  
		


	  
						  
						  
			   </div>

			  <button type="submit" class="btn btn-primary" style="float: right;" id="transfer">Տեղափոխել</button>
	
	   
			   
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
  
 <!-- Button trigger modal -->
<button type="button" class="btn btn-primary modal_answere" data-toggle="modal" data-target="#modal_answere" style="display:none;">
</button>

<!-- Modal -->
<div class="modal fade" id="modal_answere" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p class="success_message"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <a href="/dashboard.php" class="btn btn-primary">Գլխավոր էջ</a>
        <a href="/action_shops.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
      </div>
    </div>
  </div>
</div> 
  
  
  
  
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



$( "#product_group").change(function() {
	  var product_group = $('#product_group').val();

	  $('#product option').remove();
	  var url = 'api/add_warehouse_transfer.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {product_group: product_group, action: 'choose_group'}, 
           success: function(data)
           {

			   $('#product').append(data);
			  // $('.alert').show()

           }
		   
         });
});



$(document).on('change','#warehouse_from', function(){
	var product_id = $('#product').val();
	var product_group = $('#product_group').val();
	var warehouse_from = $('#warehouse_from').val();
	var url = 'api/add_warehouse_transfer.php';
	$.ajax({
	   type: "POST",
	   url: url,
	   data: {product_id: product_id, warehouse_from: warehouse_from, product_group: product_group, action: 'warehouse_from'}, 
	   
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},
		
	   success: function(data)
	   {

		   $('.count_from').html(data);
		  // $('.alert').show()

	   },
		
		complete:function(data){

		$(".loading").css({ display: "none" });
		}
	   
	 });


});

$(document).on('change','#warehouse_to', function(){
	var product_id = $('#product').val();
	var product_group = $('#product_group').val();
	var warehouse_to = $('#warehouse_to').val();
	var url = 'api/add_warehouse_transfer.php';
	$.ajax({
	   type: "POST",
	   url: url,
	   data: {product_id: product_id, warehouse_to: warehouse_to, product_group: product_group, action: 'warehouse_to'}, 
	   
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},
		
	   success: function(data)
	   {

		   $('.count_to').html(data);
		  // $('.alert').show()

	   },
		
		complete:function(data){

		$(".loading").css({ display: "none" });
		}
	   
	 });


});

$(document).on('click','#transfer', function(){
	
	var product_id = $('#product').val();
	var product_group = $('#product_group').val();
	var warehouse_to = $('#warehouse_to').val();
	var warehouse_from = $('#warehouse_from').val();
	var product_count = $('#product_count').val();
	
	var url = 'api/add_warehouse_transfer.php';
	$.ajax({
	   type: "POST",
	   url: url,
	   data: {product_id: product_id, warehouse_to: warehouse_to, warehouse_from: warehouse_from, product_group: product_group, product_count: product_count, action: 'transfer'}, 
	   
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},
		
	   success: function(data)
	   {

		  // $('.count_to').html(data);
		  // $('.alert').show()

	   },
		
		complete:function(data){

		$(".loading").css({ display: "none" });
		}
	   
	 });


});

$(document).on('change','#product', function(){
	$('#warehouse_from').prop('selectedIndex',0);
	$('#warehouse_to').prop('warehouse_to',0);
	$('.count_from').html('');
	$('.count_to').html('');
	
});



 
</script>
</body>
</html>
