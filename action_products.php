<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$product_id =  mysqli_real_escape_string($con, $_GET['product_id']);
	if($action == 'edit'){
		
		$query_data_product = mysqli_query($con, "SELECT * FROM pr_products WHERE id='$product_id'");
		$array_products = mysqli_fetch_array($query_data_product);
		

		$product_id = $array_products['id'];
		$product_group = $array_products['product_group'];
		$name = $array_products['name'];
		$sale_price = $array_products['sale_price'];
		$last_price = $array_products['last_price'];
		$middle_price = $array_products['middle_price'];
		$balance = $array_products['balance'];
		$code = $array_products['code'];
		$id2 = $array_products['id2'];
		$regular_n = $array_products['regular_n'];
		$active = $array_products['active'];
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
				echo "Ավելացնել ապրանք";
			}elseif($action == 'edit'){
				echo "Խմբագրել ապրանք";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/products.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="api/add_product.php">

				<div class="form-row">
				
					<div class="form-group col-md-6">
							<label for="group">Խումբ</label>
							
								<select name="group" class="form-control" id="product_group">
									<option value="0"> Ընտրել </option>
										<?php 
											$query_group = mysqli_query($con, "SELECT * FROM pr_groups ORDER by id DESC");
											while ($array_group = mysqli_fetch_array($query_group)):
											$group_id = $array_group['id'];
											$group_name = $array_group['group_name'];
										?> 
										 
									<option value="<?php echo $group_id; ?>" <?php if($product_group == $group_id ){ echo "selected"; } ?>> <?php echo $group_name; ?></option>
							
									<?php endwhile; ?>
							
								</select>
					  </div>
						  
						  
						  <div class="form-group col-md-6">
							<label for="name">Անուն</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Անուն" value="<?php echo $name; ?>">
						  </div>

						  
			
				</div>




				<div class="form-row">
						<div class="form-group col-md-6">
							<label for="sale_price">Վաճառքի գին</label>
							<input type="text" class="form-control" id="sale_price" name="sale_price" value="<?php echo $sale_price; ?>"  placeholder="Վաճառքի գին">
						  </div>

						  <div class="form-group col-md-6">
							<label for="last_price">Ինքնարժեք</label>
							<input type="text" class="form-control" id="last_price" name="last_price" placeholder="Ինքնարժեք" value="<?php echo $last_price; ?>">
						  </div>
			   </div>

			   
				<div class="form-row">
						  <div class="form-group col-md-6">
							<label for="balance">Մինիմալ մնացորդ</label>
							<input type="text" class="form-control" id="balance" name="balance" placeholder="Մինիմալ մնացորդ" value="<?php echo $balance; ?>">
						  </div>
						  <div class="form-group col-md-6">
							<label for="code">ID</label>
							<input type="text" class="form-control" id="code" name="code" value="<?php echo $code; ?>"  placeholder="ID">
						  </div>
			   </div>	
			   

			   
			   <div class="form-row">
						  <div class="form-group col-md-6">
							<label for="id2">Export կոդ</label>
							<input type="text" class="form-control" id="id2" name="id2" placeholder="Export կոդ" value="<?php echo $id2; ?>">
						  </div>
						  <div class="form-group col-md-6">
							<label for="regular_n">Հերթական N</label>
							<input type="text" class="form-control" id="regular_n" name="regular_n" placeholder="Հերթական N" value="<?php echo $regular_n; ?>">
						  </div>
			   </div>			   
			   <div class="form-row">
						  <div class="form-group col-md-6">
							<label for="active">Ակտիվ</label>
							<input type="checkbox" class="active" id="active" name="active" <?php if($active=='on'){echo "checked";} ?>>
						  </div>
			   </div>
			   
			   
			   
			<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
			
			<input type="hidden" name="product_id" id="product_id" value="<?php echo $_GET['product_id']; ?>">
			
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
        <a href="/action_shops.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
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


<script>


$( "#region" ).change(function() {
	  
	  $('#district option').remove();
	  var url = 'api/region_select.php';
	  var region = $('#region').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {region_select: region}, 
           success: function(data)
           {

			   $('#district').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});



$("#add_partner").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');
	var shop_id = $('#shop_id').val();
	var qr_id = $('#qr_id').val();
	
	var product_group = $('#product_group').val();
	var product_name = $('#name').val();
	
	if (product_group == '0'){
		$('#product_group').addClass('border border-danger');
		return false;
	}
	
	if (product_name == ''){
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
			   $('#shop_id').removeClass('border border-danger');
			   $('#qr_id').removeClass('border border-danger');
			   $('.success_message').text(data);
			   //$('.modal_answere').click();
			   window.location.replace("/products.php");

			  // $('.alert').show()
			  

           }
		   
         });
});
   
</script>
</body>
</html>
