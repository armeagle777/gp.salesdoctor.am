<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$supplier_id =  mysqli_real_escape_string($con, $_GET['supplier_id']);
	if($action == 'edit'){
		
		$query_data_supplier = mysqli_query($con, "SELECT * FROM pr_supplier WHERE id='$supplier_id'");
		$array_supplier = mysqli_fetch_array($query_data_supplier);
		
		$supplier_name = $array_supplier['supplier_name'];
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
				echo "Ավելացնել Մատակարար";
			}elseif($action == 'edit'){
				echo "Խմբագրել Մատակարարը";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
				<a href="/pr_supplier.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="api/add_pr_supplier.php">
			
					  <div class="form-group col-md-12">
						<label for="name">Մատակարարի անուն</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Մատակարարի անուն" value="<?php echo $supplier_name; ?>">
					  </div>
				

			<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
			
			<input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $_GET['supplier_id']; ?>">
			
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
			   //$('.alert').show()
				window.location.replace("/pr_supplier.php");


           }
		   
         });
});
   
</script>
</body>
</html>