<?php include 'header.php'; ?>
<?php
	include 'api/db.php';

	$array_ha = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'ha_email' "));
	$array_ha2 = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'ha_email2' "));
	$array_back = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'back_email' "));
	$array_lat = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'warehouse_lat' "));
	$array_long = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'warehouse_long' "));
	
	$ha_email = mysqli_real_escape_string($con, $_GET['ha_email']);
	$ha_email2 = mysqli_real_escape_string($con, $_GET['ha_email2']);
	$back_email = mysqli_real_escape_string($con, $_GET['back_email']);
	$warehouse_lat = mysqli_real_escape_string($con, $_GET['warehouse_lat']);
	$warehouse_long = mysqli_real_escape_string($con, $_GET['warehouse_long']);
	
	if($ha_email !=''){
		$query_update = mysqli_query($con, "UPDATE configs SET param_value = '$ha_email' WHERE param = 'ha_email'");
		$query_update = mysqli_query($con, "UPDATE configs SET param_value = '$ha_email2' WHERE param = 'ha_email2'");
		$query_update = mysqli_query($con, "UPDATE configs SET param_value = '$back_email' WHERE param = 'back_email'");
		$query_update = mysqli_query($con, "UPDATE configs SET param_value = '$warehouse_lat' WHERE param = 'warehouse_lat'");
		$query_update = mysqli_query($con, "UPDATE configs SET param_value = '$warehouse_long' WHERE param = 'warehouse_long'");
		echo "
		
		<script type='text/javascript'>
			window.location.href = '/configs.php';
		</script>
		
		
		";
	}
	
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
				Կարգավորումներ
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
				</div>


              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
			   
			<form id="add_partner" action="/configs.php">
			
					  <div class="form-group col-md-12">
						<label for="user_role">Հաշիվ ապրանքագրի E-mail (1)</label>
						<input type="text" value="<?php echo $array_ha['param_value']; ?>" class="form-control" name="ha_email" >
					  </div>			
					  
					  <div class="form-group col-md-12">
						<label for="user_role">Հաշիվ ապրանքագրի E-mail (2)</label>
						<input type="text" value="<?php echo $array_ha2['param_value']; ?>" class="form-control" name="ha_email2" >
					  </div>
						
					  <div class="form-group col-md-12 client_select">
						<label for="login">Պահուստավորման Email</label>
						<input type="text" value="<?php echo $array_back['param_value']; ?>" class="form-control" name="back_email" >

					  </div>
									
					  <div class="form-group col-md-4 client_select">
						<label for="login">Պահեստի կոորդինատ 1 (Latitude)</label>
						<input type="text" value="<?php echo $array_lat['param_value']; ?>" class="form-control" name="warehouse_lat" >
					  </div>
					  
					  <div class="form-group col-md-4 client_select">
						<label for="login">Պահեստի կոորդինատ 2 (Longitude)</label>
						<input type="text" value="<?php echo $array_long['param_value']; ?>" class="form-control" name="warehouse_long" >
					  </div>
			
			  <button type="submit" class="btn btn-primary">Թարմացնել</button>

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
        <a href="/action_managers.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
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
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->


</body>
</html>
