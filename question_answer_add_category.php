<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$category_name =  mysqli_real_escape_string($con, $_GET['category_name']);
	
	$question_id =  mysqli_real_escape_string($con, $_GET['question_id']);
	
	
	$query_data_question = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM question_categrory WHERE id='$question_id'"));
		
	$category_name1 = $query_data_question['category_name'];
	$category_parrent = $query_data_category['category_parrent'];

	
	
	if($action == 'delete') {
		
		mysqli_query($con, "DELETE FROM question_categrory WHERE id = '$category_id'");
		mysqli_query($con, "DELETE FROM question_categrory WHERE category_parrent = '$category_id'");
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/custom_expenses_category.php';

		</script>
		
		";
		
		
	}		
	
	if($question_id == '' AND $action == 'add') {
		
		$question_type1 = mysqli_real_escape_string($con, $_GET['question_type1']);
		$question_type2 = mysqli_real_escape_string($con, $_GET['question_type2']);
		$question_name = mysqli_real_escape_string($con, $_GET['question_name']);
		
		if($question_type1 == '0') {
			
			$query_add = "INSERT INTO question_categrory (category_name, category_parrent, category_type) VALUES ('$question_name', '0', '2')";
			mysqli_query($con, $query_add);

		}	
		
		if($question_type1 != '0' and $question_type2 == '0') {
			
			$query_add = "INSERT INTO question_categrory (category_name, category_parrent, category_type) VALUES ('$question_name', '$question_type1', '2') ";
			mysqli_query($con, $query_add);

		}	
		if($question_type1 != '0' and $question_type2 != '0') {
			
			$query_add = "INSERT INTO question_categrory (category_name, category_parrent, category_type) VALUES ('$question_name', '$question_type2', '2') ";
			mysqli_query($con, $query_add);

		}
		
			
			
		//echo $query_add;
		
		
		echo "
		<script type='text/javascript'>
		window.location.href = '/question_answer_add_category.php';

		</script>
		
		"; 
		
		
	}	
	if($question_id != '' and $action == 'edit') {
		
		//$question_type1 = mysqli_real_escape_string($con, $_GET['question_type1']);
		//$question_type2 = mysqli_real_escape_string($con, $_GET['question_type2']);
		
		$question_name = mysqli_real_escape_string($con, $_GET['question_name']);
		
		
			
		$query_add = "UPDATE question_categrory SET category_name = '$question_name' WHERE id='$question_id' ";
		mysqli_query($con, $query_add);

		
		
		/*
		if($question_type1 == '0') {
			
			$query_add = "UPDATE question_categrory SET category_name = '$question_name', category_parrent = '0' WHERE id='$question_id' ";
			mysqli_query($con, $query_add);

		}	
		
		if($question_type1 != '0' and $question_type2 == '0') {
			
			$query_add = "UPDATE question_categrory SET category_name = '$question_name', category_parrent = $question_type1' WHERE id='$question_id' ";
			mysqli_query($con, $query_add);

		}
		
		if($question_type1 != '0' and $question_type2 != '0') {
			
			$query_add = "UPDATE question_categrory SET category_name = '$question_name', category_parrent = $question_type2' WHERE id='$question_id' ";
			mysqli_query($con, $query_add);
		}
		
		*/
		
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/question_category.php';

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
			
			Խնդիրների խումբ
			
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
			<a href="/question_category.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="/question_answer_add_category.php">

				<div class="form-row">
				
					<?php if($question_id == ''): ?>
					
					
					<div class="form-group col-md-3">
							<label for="question_type1">Խումբ</label>
							
								<select name="question_type1" class="form-control" id="question_type1">										
								<option value="0">Ընտրել</option>
								<?php 
									$query_data_category1 = mysqli_query($con, "SELECT * FROM question_categrory WHERE category_parrent='0' AND category_type = '2' ");
									while($category1_array = mysqli_fetch_array($query_data_category1)):
								
								?>
								
								<option value="<?php echo $category1_array['id']; ?>"><?php echo $category1_array['category_name']; ?></option>
								
								<?php 
									endwhile;
								?>
							
								</select>
					</div>
					
					<div class="form-group col-md-3">
							<label for="question_type2">Ենթախումբ</label>
							
								<select name="question_type2" class="form-control" id="question_type2">										
									<option value="0">Ընտրել</option>
														
								</select>
					</div>
					
					<?php endif; ?>
						  
				  <div class="form-group col-md-6">
					<label for="name">Խմբի Անուն</label>
					<input type="text" class="form-control" id="question_name" name="question_name" required placeholder="Խմբի Անուն" value="<?php echo $category_name1; ?>">
				  </div>

				


			
				</div>



			<?php 
			
			if($question_id == '' ): 
			
			?>
			
			<input type="hidden" name="action" id="action" value="add">

			<?php 
				else:
			?>   
			
			<input type="hidden" name="action" id="action" value="edit">
			
			<?php endif; ?>
   
			
			<input type="hidden" name="question_id" id="question_id" value="<?php echo $question_id; ?>">
			
			<?php 
			if($question_id == '' ): 
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
