<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$network_id =  mysqli_real_escape_string($con, $_GET['network_id']);
	if($action == 'edit'){
		
		$query_data_networks = mysqli_query($con, "SELECT * FROM network WHERE id=$network_id");
		$array_networks = mysqli_fetch_array($query_data_networks);
		
		$network_name = $array_networks['network_name'];
		$network_comment_info = $array_networks['network_comment_info'];
		$network_limit = $array_networks['network_limit'];
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
				echo "Ավելացնել ցանց";
			}elseif($action == 'edit'){
				echo "Խմբագրել ցանցը";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
				<a href="/networks.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="api/add_network.php">
			
					  <div class="form-group col-md-12">
						<label for="name">Ցանցի անուն</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Ցանցի անուն" value="<?php echo $network_name; ?>">
					  </div>
				
					  <div class="form-group col-md-12">
						<label for="name">Մեկնաբանություն</label>
						<input type="text" class="form-control" id="name" name="network_comment_info" placeholder="Մեկնաբանություն" value="<?php echo $network_comment_info; ?>">
					  </div>
				
					  <div class="form-group col-md-12">
						<label for="name">Լիմիտ</label>
						<input type="text" class="form-control" id="name" name="network_limit" placeholder="Լիմիտ" value="<?php echo $network_limit; ?>">
					  </div>
				

			<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
			
			<input type="hidden" name="network_id" id="network_id" value="<?php echo $_GET['network_id']; ?>">
			
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

$("#add_partner").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');
	var name = $('#name').val();
	if (name == ''){
		$('#name').addClass('border border-danger');
		return false;
	}
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {
              // alert(data); 
			   $('#name').removeClass('border border-danger');
			   $('.success_message').text(data);
			   $('.alert').show()
			   window.location.replace("/networks.php");

           }
		   
         });
});
   
</script>
</body>
</html>
