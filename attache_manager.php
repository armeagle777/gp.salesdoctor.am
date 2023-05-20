<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	//$action = mysqli_real_escape_string($con, $_GET['action']);
	$get_curr_manager =  mysqli_real_escape_string($con, $_GET['manager_id']);
	
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
			<?php 
			if($action == 'add'){
				echo "Ավելացնել ցանց";
			}elseif($action == 'edit'){
				echo "Խմբագրել ցանցը";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
				<a href="/managers.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
				  <p class="success_message"></p>

				</div>


              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
			   
			<form id="add_partner" action="api/action_network.php">
			
				  <div class="form-group col-md-12">
					<label for="managers">Ընտրել Մենեջերին</label>
						
					<select name="managers" id="managers" class="form-control">
						<?php 
						
						$query_managers = mysqli_query($con, "SELECT id, login FROM manager");
						while($managers_array = mysqli_fetch_array($query_managers)):
						?>

							<option value="<?php echo $managers_array['id']; ?>" <?php if($get_curr_manager == $managers_array['id']){ echo 'selected'; } ?>><?php echo $managers_array['login']; ?> </option>

						<?php endwhile; ?>
					</select>
					
				  </div>	

				  <div class="form-group col-md-12">
					<label for="region">Ընտրել Մարզը</label>
						
					<select name="region" id="region" class="form-control">
					<option value="0"> Ընտրել </option>
						<?php 
						
						$query_regions = mysqli_query($con, "SELECT * FROM region");
						while($regions_array = mysqli_fetch_array($query_regions)):
						?>

							<option value="<?php echo $regions_array['id']; ?>"><?php echo $regions_array['region_name']; ?> </option>

						<?php endwhile; ?>
					</select>
					
				  </div>
				  
				  <div class="form-group col-md-12">
					<label for="district">Ընտրել քազաքը</label>
						
					<select name="district" id="district" class="form-control">
					<option>Ընտրել</option>
					</select>
					
				  </div>	

				  
				  <div class="form-group col-md-12">
					<label for="district">Խանութներ</label>
					
					
					
						<table class="table table-bordered table-striped">
							  <thead>
								<tr>
									<th>Ավելացնել</th>
									<th>Հ\Հ</th>
									<th>QR համար</th>
									<th>Անուն</th>
									<th>Հասցե</th>
								</tr>
							  </thead>
							  <tbody class="shops_area">
							 
							  </tbody>
							  <tfoot>
							  <tr>
								<th>Ավելացնել</th>
								<th>Հ\Հ</th>
								<th>QR համար</th>
								<th>Անուն</th>
								<th>Հասցե</th>
							  </tr>
							  </tfoot>
							</table>
					
					
					
				  </div>
				
			
			
			</form>
	   
			   
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
	
	$('.shops_area tr').remove();
	
	  var url = 'api/region_select.php';
	  var district_id = $('#district').val();
	  var district_selected_id = $('#managers').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {district_id: district_id, district_selected_id: district_selected_id}, 
           success: function(data)
           {

			   $('.shops_area').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});

$( "#managers" ).change(function() {
	$('.shops_area tr').remove();
});


$(".shops_area").on('click', 'input', function() {

if ($(this).is(':checked')) {
  var check_active = 1;
} else {
  var check_active = 0;
}


var check_id = $(this).attr('value');
var check_manager_id = $('#managers').val();

console.log(check_id);

    $.ajax({
        type: "POST",
        url: "/api/manager_select.php",
        data: {shop_id: check_id, check_manager_id: check_manager_id, check_active: check_active},
        success: function(){
           // alert ('minpen');

        }
    });
return true;
});
   
</script>
</body>
</html>
