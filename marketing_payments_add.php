<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	
	if($action == 'add') {
	    $sql = "";
		mysqli_query($con, $sql);
		header("Location: /marketing_payments.php");
	}	
?>
<style>
    .chosen-container, .chosen-container-single,.chosen-single{
        height: 37px!important;  
        width:100%;
    }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ավելացնել</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/marketing_payments.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
    			<form id="add_partner" action="/custom_expenses_add.php">
    				<div class="form-row">
    					<div class="form-group col-md-3">
    						<label for="shops_select">Խանութ</label>
    						<select name="shops_select" class="form-control" id="shops_select">
    						    <option value="0">Ընտրել</option>
    						    <?php
    								$query_category = mysqli_query($con, "SELECT * FROM shops ");
    								while($category_array = mysqli_fetch_array($query_category)):
    								    extract($category_array);
								?>
						    		<option value="<?php echo $id; ?>" > <?php echo  $name; ?> </option>
                                <?php endwhile; ?>
							</select>
					    </div>
    					<div class="form-group col-md-3">
    						<label for="manager">Մենեջեր</label>
    						<select name="manager" class="form-control" id="manager">
    						    <option value="0">Ընտրել</option>
    						    <?php
    								$query_category = mysqli_query($con, "SELECT * FROM custom_expenses_category WHERE category_type = '$expenses_type' ");
    								while($category_array = mysqli_fetch_array($query_category)):
								?>
						    		<option value="<?php echo $category_array['id']; ?>" <?php if($category_array['id'] == $expenses_category ){ echo "selected"; } ?>> <?php echo  $category_array['category_name']; ?> </option>
                                <?php endwhile; ?>
							</select>
					    </div>
    					<div class="form-group col-md-2">
    						<label for="visit">Այց</label>
    						<select name="visit" class="form-control" id="visit">
    						    <option value="0">Ընտրել</option>
    						    <?php
    								$query_category = mysqli_query($con, "SELECT * FROM custom_expenses_category WHERE category_type = '$expenses_type' ");
    								while($category_array = mysqli_fetch_array($query_category)):
								?>
						    		<option value="<?php echo $category_array['id']; ?>" <?php if($category_array['id'] == $expenses_category ){ echo "selected"; } ?>> <?php echo  $category_array['category_name']; ?> </option>
                                <?php endwhile; ?>
							</select>
					    </div>
    				    <div class="form-group col-md-2">
        					<label for="debt">Գումար</label>
        					<input type="number" class="form-control" id="debt" name="debt" required placeholder="Գումար"  />
    				    </div>
    				    <div class="form-group col-md-2">
        					<label for="comment">Ամիսներ</label>
        					<input type="text" class="form-control" id="comment" name="comment" required placeholder="Նշում"  />
    				    </div>
    				</div>
                    <input type="hidden" name="action" id="action" value="add">
        			<button type="submit" class="btn btn-primary">Ավելացնել</button>
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


<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>



<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

<!-- Chosen script  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
        
<!-- page script -->
<script>
    $("#shops_select").chosen()
    $("#manager").chosen()
    $("#visit").chosen()
    
    $("#shops_select").change(function(){
        const shop_id = $(this).val()
        $.ajax({
        	url: "/actions.php?marketing_payment_managers_visits=1", 
        	data: {
                name : "The name",
                desc : "The description"
            },
        	success: function(data, textStatus, jqXHR)
        	{
            	alert("Success: " + response); 
        	}
        });
    })
    
</script>


</body>
</html>
