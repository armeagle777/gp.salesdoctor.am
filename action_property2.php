<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	
	$name = mysqli_real_escape_string($con, $_GET['name']);

	
	
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
			 
			Ավելացնել Գույք 2
		
			
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
				<a href="/property2.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   <?php 
			   
							   
					if($_GET['name'] != ''){
							
						$query_check = mysqli_query($con, "SELECT * FROM pr_property2 WHERE property_2='$name' ");
						if(mysqli_num_rows($query_check) == 0){
							echo "<p style='color: #1cb700; font-weight: bold; font-size: 21px;'> Ավելացված է </p>";
							$query=mysqli_query($con, "INSERT INTO pr_property2 (property_2) VALUES ('$name')");
						}else{
							echo "<p style='color: #ff0000; font-weight: bold; font-size: 21px;'> Արդեն առկա է, ավելացրեք ուրիշ տվյալ </p>";
						}
						
					}
							   
			   ?>
			   
			   
			<form id="add_partner" action="/action_property2.php">
			
					  <div class="form-group col-md-12">
						<label for="name">Գույք 2</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Գույք 2" value="<?php echo $network_name; ?>">
					  </div>				

			  <button type="submit" class="btn btn-primary" name="submit">Ավելացնել</button>
			
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

   
</script>
</body>
</html>
