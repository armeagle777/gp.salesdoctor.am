<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	
	$company_id =  mysqli_real_escape_string($con, $_GET['company_id']);
	
	
	$query_data_solution = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM question_company WHERE id='$company_id'"));
		
	$company_name = $query_data_solution['company_name'];
	$company_address = $query_data_solution['company_address'];
	$company_tel = $query_data_solution['company_tel'];
	$company_comment = $query_data_solution['company_comment'];

	
	
	if($action == 'delete') {
		
		mysqli_query($con, "DELETE FROM question_company WHERE id = '$company_id'");
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/question_company.php';

		</script>
		
		";
		
		
	}		
	
	if($company_id == '' AND $action == 'add') {
		
		

		$company_name = mysqli_real_escape_string($con, $_GET['company_name']);
		$company_address = mysqli_real_escape_string($con, $_GET['company_address']);
		$company_tel = mysqli_real_escape_string($con, $_GET['company_tel']);
		$company_comment = mysqli_real_escape_string($con, $_GET['company_comment']);
		
		if($company_name !=''){
			
			$query_add = "INSERT INTO question_company (company_name, company_address, company_tel, company_comment ) VALUES ('$company_name', '$company_address', '$company_tel', '$company_comment')";
			mysqli_query($con, $query_add);

		}
		
	  $last_id = mysqli_insert_id($con);

		
	
			
			
	//	echo $query_add;
		
//		exit;
		
		echo "
		<script type='text/javascript'>
		window.location.href = '/question_company_to_question.php?company_id=$last_id';

		</script>
		
		"; 
		
		
	}	
	if($company_id != '' and $action == 'edit') {
		
		$company_name = mysqli_real_escape_string($con, $_GET['company_name']);
		$company_address = mysqli_real_escape_string($con, $_GET['company_address']);
		$company_tel = mysqli_real_escape_string($con, $_GET['company_tel']);
		$company_comment = mysqli_real_escape_string($con, $_GET['company_comment']);
		
		
		if($company_name !=''){
		
		$query_add = "UPDATE question_company SET company_name = '$company_name', company_address = '$company_address', company_tel = '$company_tel', company_comment = '$company_comment'  WHERE id='$company_id' ";
		mysqli_query($con, $query_add);
		
	//	echo $query_add;

		}
		
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/question_company.php';

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
			
			Կազմակերպություն
			
		
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/question_company.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="/question_add_company.php">

				<div class="form-row">
									
					<div class="form-group col-md-4">
							<label for="question_type1">Անուն</label>
							
					<input type="text" class="form-control" id="company_name" name="company_name" required placeholder="Անուն" value="<?php echo $company_name; ?>">

					</div>
									
					<div class="form-group col-md-4">
							<label for="question_type1">Հասցե</label>
							
					<input type="text" class="form-control" id="company_address" name="company_address" required placeholder="Հասցե" value="<?php echo $company_address; ?>">

					</div>
									
					<div class="form-group col-md-4">
							<label for="question_type1">Հեռախոս</label>
							
					<input type="text" class="form-control" id="company_tel" name="company_tel" required placeholder="Հեռախոս" value="<?php echo $company_tel; ?>">

					</div>
									
					<div class="form-group col-md-12">
							<label for="question_type1">Մեկնաբանություն</label>
							
					<input type="text" class="form-control" id="company_comment" name="company_comment" required placeholder="Մեկնաբանություն" value="<?php echo $company_comment; ?>">

					</div>
				
			
				</div>



			<?php 
			
			if($company_id == '' ): 
			
			?>
			
			<input type="hidden" name="action" id="action" value="add">

			<?php 
				else:
			?>   
			
			<input type="hidden" name="action" id="action" value="edit">
			
			<?php endif; ?>
   
			
			<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
			
			<?php 
			if($company_id == '' ): 
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

<script type="text/javascript">


$( "#question_type1" ).change(function() {
	  
	  $('#question_type2 option').remove();
	  var url = 'api/question.php';
	  var question_type1 = $('#question_type1').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {question_type1: question_type1}, 
           success: function(data)
           {

			   $('#question_type2').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});

$( "#question_type2" ).change(function() {
	  
	  $('#question_type3 option').remove();
	  var url = 'api/question.php';
	  var question_type2 = $('#question_type2').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {question_type2: question_type2}, 
           success: function(data)
           {

			   $('#question_type3').append(data);
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


</script>



</body>
</html>
