<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$task_id =  mysqli_real_escape_string($con, $_GET['task_id']);
	if($action == 'edit'){
		
		$query_data_task = mysqli_query($con, "SELECT * FROM tasks WHERE id='$task_id'");
		$array_tasks = mysqli_fetch_array($query_data_task);
		

		$id = $array_tasks['id'];
		$get_curr_manager = $array_tasks['manager_id'];
		$task = $array_tasks['task'];
		$admin_task_ok = $array_tasks['admin_task_ok'];
		$calendar_date = $array_tasks['calendar_date'];
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
				echo "Ավելացնել առաջադրանք";
			}elseif($action == 'edit'){
				echo "Խմբագրել առաջադրանք";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/tasks.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="api/add_task.php">

				

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
				<label for="task">Առաջադրանք</label>
				<input type="text" class="form-control" id="task" name="task" placeholder="Առաջադրանք" value="<?php echo $task; ?>">
			  </div>			   
	
			  <div class="form-group col-md-12">
				<label for="task">Օրացույց</label>
				<input id="comment_date" type="text" class="form-control" name="calendar_date" placeholder="Օր" value="<?php echo $calendar_date; ?>">
			  </div>
			  
			  <?php 
			if($action == 'edit'):
			?>
			  
			  <div class="form-group col-md-1">
				<label for="yes">Կատարված</label>
				<input type="checkbox" class="form-control" id="yes" name="yes" <?php if($admin_task_ok == '1'){echo "checked";} ?>>
			  </div>
						
			  <?php endif; ?>
			   
			   
			   
			<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
			<input type="hidden" name="task_id" id="task_id" value="<?php echo $task_id; ?>">
			
			
			<?php 
			if($action == 'add'):
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
        <a href="/action_tasks.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
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
<script src="../../plugins/moment/moment.min.js"></script>

<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->


<script>

$('#comment_date').daterangepicker({
	  //autoUpdateInput: false,

	locale: {
		format: 'YYYY-MM-DD', 
		firstDay: 1,
		cancelLabel: 'Clear'
    },
    singleDatePicker: true,
    showDropdowns: true,
});


$("#add_partner").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');
	var task = $('#task').val();
	
	if (task == ''){
		$('#task').addClass('border border-danger');
		return false;
	}
	
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {
              // alert(data); 
			   $('#task').removeClass('border border-danger');
			   $('.success_message').text(data);
			   $('.modal_answere').click();
			   
			  // $('.alert').show()
			  

           }
		   
         });
});
   
</script>
</body>
</html>
