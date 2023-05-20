<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$category_id =  mysqli_real_escape_string($con, $_GET['category_id']);

	
	
	$query_data_category = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM custom_expenses_category WHERE id='$category_id'"));
		
	$category_name1 = $query_data_category['category_name'];
	$category_type1 = $query_data_category['category_type'];
	$category_plan1 = $query_data_category['category_plan'];

	
	
	if($action == 'delete') {
		
		mysqli_query($con, "DELETE FROM custom_expenses_category WHERE id = '$category_id'");
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/custom_expenses_category.php';

		</script>
		
		";
		
		
	}		
	
	if($category_id == '' and $action == 'add') {
		
		$category_name = mysqli_real_escape_string($con, $_GET['category_name']);
		$category_type = mysqli_real_escape_string($con, $_GET['category_type']);
		$category_plan = mysqli_real_escape_string($con, $_GET['category_plan']);
		
		mysqli_query($con, "INSERT INTO custom_expenses_category (category_name, category_type, category_plan) VALUES ('$category_name', '$category_type', '$category_plan') ");
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/custom_expenses.php';

		</script>
		
		";
		
		
	}	
	if($category_id != '' and $action == 'edit') {
		
		$category_name = mysqli_real_escape_string($con, $_GET['category_name']);
		$category_type = mysqli_real_escape_string($con, $_GET['category_type']);
		$category_plan = mysqli_real_escape_string($con, $_GET['category_plan']);
		
		mysqli_query($con, "UPDATE custom_expenses_category SET category_name = '$category_name', category_type = '$category_type', category_plan = '$category_plan' WHERE id = '$category_id' ");
			
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/custom_expenses_category.php';

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
			<?php 
			if($action == 'add'){
				echo "Ավելացնել խումբ";
			}elseif($action == 'edit'){
				echo "Խմբագրել խումբ";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/custom_expenses_category.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="/custom_expenses_add_category.php">

				<div class="form-row">
				
					<div class="form-group col-md-4">
							<label for="category_type">Խմբի Տեսակ</label>
							
								<select name="category_type" class="form-control" id="category_type">										
									<option value="1" <?php if($category_type1 == '1'){ echo "selected"; } ?>> Եկամուտ</option>
									<option value="2" <?php if($category_type1 == '2'){ echo "selected"; } ?>> Ծախս</option>
							
							
								</select>
					  </div>
						  
						  
						  <div class="form-group col-md-4">
							<label for="name">Խմբի Անուն</label>
							<input type="text" class="form-control" id="category_name" name="category_name" required placeholder="Խմբի Անուն" value="<?php echo $category_name1; ?>">
						  </div>

						<div class="form-group col-md-4">
							<label for="category_plan">Պլան</label>
							<input type="text" class="form-control" id="category_plan" name="category_plan" value="<?php echo $category_plan1; ?>"  placeholder="Պլան">
						  </div>


			
				</div>



			<?php 
			
			if($category_id == '' ): 
			
			?>
			
			<input type="hidden" name="action" id="action" value="add">

			<?php 
				else:
			?>   
			
			<input type="hidden" name="action" id="action" value="edit">
			
			<?php endif; ?>
   
			
			<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>">
			
			<?php 
			if($category_id == '' ): 
			?>
			  <button type="submit" class="btn btn-primary">Ավելացնել</button>
			<?php else: ?> 
			
			  <button type="submit" class="btn btn-primary">Թարմացնել</button>

			<?php endif; ?>
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

</body>
</html>
