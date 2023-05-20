<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	
	$solution_id =  mysqli_real_escape_string($con, $_GET['solution_id']);
	
	
	$query_data_solution = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM question_solution WHERE id='$solution_id'"));
		
	$solution_name = $query_data_solution['solution_name'];
	$question_id_selected1 = $query_data_solution['question_id1'];
	$question_id_selected2 = $query_data_solution['question_id2'];
	$question_id_selected3 = $query_data_solution['question_id3'];

	
	
	if($action == 'delete') {
		
		mysqli_query($con, "DELETE FROM question_solution WHERE id = '$solution_id'");
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/question_solutions.php';

		</script>
		
		";
		
		
	}		
	
	if($solution_id == '' AND $action == 'add') {
		
		$question_type1 = mysqli_real_escape_string($con, $_GET['question_type1']);
		$question_type2 = mysqli_real_escape_string($con, $_GET['question_type2']);
		$question_type3 = mysqli_real_escape_string($con, $_GET['question_type3']);
		$solution_name = mysqli_real_escape_string($con, $_GET['solution_name']);
		
		if($question_type1 !='0' and $question_type2 !='0' and $question_type3 !='0' AND $solution_name !=''){
			
			$query_add = "INSERT INTO question_solution (solution_name, question_id1, question_id2, question_id3 ) VALUES ('$solution_name', '$question_type1', '$question_type2', '$question_type3')";
			mysqli_query($con, $query_add);

		}
			

	
			
			
	//	echo $query_add;
		
//		exit;
		
		echo "
		<script type='text/javascript'>
		window.location.href = '/question_solutions.php';

		</script>
		
		"; 
		
		
	}	
	if($solution_id != '' and $action == 'edit') {
		
		$question_type1 = mysqli_real_escape_string($con, $_GET['question_type1']);
		$question_type2 = mysqli_real_escape_string($con, $_GET['question_type2']);
		$question_type3 = mysqli_real_escape_string($con, $_GET['question_type3']);
		
		$solution_name = mysqli_real_escape_string($con, $_GET['solution_name']);
		
		
		if($question_type1 !='0' and $question_type2 !='0' and $question_type3 !='0' and $solution_name !=''){
		
		$query_add = "UPDATE question_solution SET solution_name = '$solution_name', question_id1 = '$question_type1', question_id2 = '$question_type2', question_id3 = '$question_type3'  WHERE id='$solution_id' ";
		mysqli_query($con, $query_add);
		
	//	echo $query_add;

		}
		
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/question_solutions.php';

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
			
			Լուծումներ
			
			<?php 
			if($action == 'add'){
				echo "Ավելացնել լուծում";
			}elseif($action == 'edit'){
				echo "Խմբագրել լուծում";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/question_solutions.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="/question_add_solution.php">

				<div class="form-row">
				
					
					
		<div class="form-group col-md-4">
							<label for="question_type1">Խումբ</label>
							
								<select name="question_type1" class="form-control" id="question_type1">										
								<option value="0">Ընտրել</option>
								<?php 
									$query_data_category1 = mysqli_query($con, "SELECT * FROM question_categrory WHERE category_parrent='0'  ");
									while($category1_array = mysqli_fetch_array($query_data_category1)):
								
								?>
								
								<option value="<?php echo $category1_array['id']; ?>" <?php if($question_id_selected1 == $category1_array['id']){echo 'selected'; } ?>><?php echo $category1_array['category_name']; ?></option>
								
								<?php 
									endwhile;
								?>
							
								</select>
					</div>
					
					<div class="form-group col-md-4">
							<label for="question_type2">Ենթախումբ</label>
								
								<select name="question_type2" class="form-control" id="question_type2">										
									<option value="0">Ընտրել</option>
										
									<?php 
									$query_data_category2 = mysqli_query($con, "SELECT * FROM question_categrory WHERE category_parrent='$question_id_selected1' ");
									while($category2_array = mysqli_fetch_array($query_data_category2)):
								
									?>
									<option value="<?php echo $category2_array['id']; ?>" <?php if($question_id_selected2 == $category2_array['id']){echo 'selected'; } ?>><?php echo $category2_array['category_name']; ?></option>

									<?php 
									endwhile;
									?>
							
								</select>
					</div>
										
					<div class="form-group col-md-4">
							<label for="question_type3">Ենթա Ենթախումբ</label>
								
								<select name="question_type3" class="form-control" id="question_type3">										
									<option value="0">Ընտրել</option>
										
									<?php 
									$query_data_category3 = mysqli_query($con, "SELECT * FROM question_categrory WHERE category_parrent='$question_id_selected2' ");
									while($category3_array = mysqli_fetch_array($query_data_category3)):
								
									?>
									<option value="<?php echo $category3_array['id']; ?>" <?php if($question_id_selected3 == $category3_array['id']){echo 'selected'; } ?>><?php echo $category3_array['category_name']; ?></option>

									<?php 
									endwhile;
									?>
							
								</select>
					</div>
					
				
						  
				  <div class="form-group col-md-12">
					<label for="name">Լուծում</label>
					<input type="text" class="form-control" id="solution_name" name="solution_name" required placeholder="Լուծում" value="<?php echo $solution_name; ?>">
				  </div>

				


			
				</div>



			<?php 
			
			if($solution_id == '' ): 
			
			?>
			
			<input type="hidden" name="action" id="action" value="add">

			<?php 
				else:
			?>   
			
			<input type="hidden" name="action" id="action" value="edit">
			
			<?php endif; ?>
   
			
			<input type="hidden" name="solution_id" id="solution_id" value="<?php echo $solution_id; ?>">
			
			<?php 
			if($solution_id == '' ): 
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
