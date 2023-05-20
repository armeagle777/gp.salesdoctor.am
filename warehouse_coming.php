<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$group_id =  mysqli_real_escape_string($con, $_GET['group_id']);
	if($action == 'edit'){
		
		$query_data_groups = mysqli_query($con, "SELECT * FROM pr_groups WHERE id='$group_id'");
		$array_groups = mysqli_fetch_array($query_data_groups);
		
		$group_name = $array_groups['group_name'];
	}
		
	  $date = date_create();
	  $document_id = date_timestamp_get($date);


?>

<div class="loading" style="display: none;">Loading&#8230;</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ապրանքների մուտք պահեստ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
				<a href="/dashboard.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   <form id="warehouse_coming" action="api/add_warehouse_coming.php">
			   
					<div class="form-row">
					  <div class="form-group col-md-6">
						<label for="warehouse">Պահեստ</label>


						 <select name="warehouse" id="warehouse" class="form-control"> 
							
							<option id="0" value="0">Ընտրել</option>

							
							<?php 
								
								$warehouse_query = mysqli_query($con, "SELECT * FROM pr_warehouse");
								while($warehouse_array = mysqli_fetch_array($warehouse_query)):
									
							?>
								<option id="<?php echo $warehouse_array['id']; ?>" value="<?php echo $warehouse_array['id']; ?>"><?php echo $warehouse_array['warehouse_name']; ?></option>
							
							<?php 
								endwhile;
							?>
						 
						 </select>



					  </div>
					  
					  <div class="form-group col-md-6">
						<label for="supplier">Մատակարար</label>
						
						 <select name="supplier" id="supplier" class="form-control"> 
							
							<option id="0" value="0">Ընտրել</option>

							
							<?php 
								
								$supplier_query = mysqli_query($con, "SELECT * FROM pr_supplier");
								while($supplier_array = mysqli_fetch_array($supplier_query)):
									
							?>
								<option id="<?php echo $supplier_array['id']; ?>" value="<?php echo $supplier_array['id']; ?>"><?php echo $supplier_array['supplier_name']; ?></option>
							
							<?php 
								endwhile;
							?>
						 
						 </select>
					  
					  </div>
					</div>			   
			   
					<div class="form-row">
					  <div class="form-group col-md-6">
						<label for="product_group">Ապրանքների խումբ</label>


						 <select name="product_group_select" id="product_group_select" class="form-control"> 
							
							<option id="0">Ընտրել</option>

							
							<?php 
								
								$product_group_query = mysqli_query($con, "SELECT * FROM pr_groups");
								while($groups_array = mysqli_fetch_array($product_group_query)):
									
							?>
								<option id="<?php echo $groups_array['id']; ?>" value="<?php echo $groups_array['id']; ?>"><?php echo $groups_array['group_name']; ?></option>
							
							<?php 
								endwhile;
							?>
						 
						 </select>



					  </div>
					  
					  <div class="form-group col-md-6">
						<label for="name">Ապրանք</label>
						
						<select name="product_select" id="product_select" class="form-control"> 
						
						</select>
					  
					  </div>
					</div>
					
			   
			
					<div class="form-row">
					  <div class="form-group col-md-8">
						<label for="barcode">Շտրիխ կոդ</label>
						<input type="text" class="form-control" id="barcode" name="barcode" placeholder="Շտրիխ կոդ">
					  </div>
					  
					  <div class="form-group col-md-4">
						<label for="name">Ավելացնել</label>
						<br>
						<button type="submit" class="btn btn-primary">Ավելացնել</button>

					  </div>
					</div>

			<input type="hidden" name="action" id="action" value="add">
			
			<input type="hidden" name="document_id" id="document_id" value="<?php echo $document_id; ?>">
			
	
			</form>
	   
			<table class="table table-bordered table-striped dataTable">
                <thead>
                  <tr>
                    <th>Ապրանքի անվանում</th>
                    <th>Ապրանքի քանակ</th>
                    <th>Ձեռքբերման գին</th>
                    <th>Փոփոխել</th>
                  </tr>
				</thead>
                  <tbody class="product_body">
				  
				  </tbody>
			   <tfoot>
                  <tr>
                    <th>Ապրանքի անվանում</th>
                    <th>Ապրանքի քանակ</th>
					<th>Ձեռքբերման գին</th>
                    <th>Փոփոխել</th>
                  </tr>
				</tfoot>
				</table>
				<button class="btn btn-success next_step" style="float: right; margin-top: 20px;">Շարունակել</button>
				<button class="btn btn-danger back_step" style="float: right; margin-top: 20px;margin-right: 20px;">Չեղարկել</button>

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



$( "#product_group_select" ).change(function() {
	  
	  $('#product_select option').remove();
	  var url = 'api/add_warehouse_coming.php';
	  var product_group_select = $('#product_group_select').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {product_group_select: product_group_select, action: 'select_product'}, 
           success: function(data)
           {

			   $('#product_select').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});


$(document).on('change','#product_select', function() {
	
	var product_select = $('#product_select').val();
	var document_id = $('#document_id').val();
	var warehouse = $('#warehouse').val();
	var supplier = $('#supplier').val();
	
	var warehouse = $('#warehouse').val();
	var supplier = $('#supplier').val();
	
	if (warehouse == '0'){
		$('#warehouse').addClass('border border-danger');
		return false;
	}else{
		$('#warehouse').removeClass('border border-danger');
	}
	
	if (supplier == '0'){
		$('#supplier').addClass('border border-danger');
		return false;
	}else{
		$('#supplier').removeClass('border border-danger');
	}
	
	$.ajax({
	type: "POST",
	url: '/api/add_warehouse_coming.php',
	data: {"product_select": product_select, "action_select": 'with_select', "action": 'add', "document_id": document_id, "warehouse": warehouse, "supplier": supplier},    
	success: function(data)
	{
		   $(".product_body").html("");
		   $(".product_body").append(data);
	}

	});


});


$(document).on('click','.transaction_delete', function() {
	
	var product_for_delete = $(this).attr('id');
	var document_id = $('#document_id').val();
	
	$.ajax({
	type: "POST",
	url: '/api/add_warehouse_coming.php',
	data: {"action": 'delete', "document_id": document_id, "product_for_delete": product_for_delete},    
	
	beforeSend: function(){
			$(".loading").css({ display: "block" });
	},
	
	success: function(data)
	{
		 $('.prod_'+product_for_delete).remove();
	},
	
		   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

	});


});

$(document).on('change','.prod_count', function() {

	   var transaction_id = $(this).attr('id');
	   var product_count = $(this).val();
	   $.ajax({
	   type: 'POST',
	   url: '/api/add_warehouse_coming.php',
	   data: {'transaction_id':transaction_id, 'product_update_count': product_count, 'action':'edit_count'},
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},

	   success: function(data)
	   {
				
	   },
	   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

		  
		   
		 });
	  
	  //alert(transaction_id);
});

$(document).on('change','.prod_buy_price', function() {

	   var transaction_id = $(this).attr('id');
	   var product_price = $(this).val();
	   $.ajax({
	   type: 'POST',
	   url: '/api/add_warehouse_coming.php',
	   data: {'transaction_id':transaction_id, 'product_price': product_price, 'action':'edit_buy_price'},
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},

	   success: function(data)
	   {
				
	   },
	   
	  complete:function(data){

		$(".loading").css({ display: "none" });
	   }

		  
		   
		 });
	  
	  //alert(transaction_id);
});




$("#warehouse_coming").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');
	var barcode = $('#barcode').val();
	var warehouse = $('#warehouse').val();
	var supplier = $('#supplier').val();
	
	
	if (barcode == ''){
		$('#barcode').addClass('border border-danger');
		return false;
	}	
	
	if (warehouse == '0'){
		$('#warehouse').addClass('border border-danger');
		return false;
	}else{
		$('#warehouse').removeClass('border border-danger');
	}
	
	if (supplier == '0'){
		$('#supplier').addClass('border border-danger');
		return false;
	}else{
		$('#supplier').removeClass('border border-danger');
	}
	
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {	
				if(data == ''){
					$("#barcode").val("");
					$('#barcode').addClass('border border-danger');
					return false;
				}
			   $("#barcode").val("");
			   
			   $(".product_body").html("");
			   $(".product_body").append(data);
				
              // alert(data); 
			   $('#barcode').removeClass('border border-danger');
			  // $('.success_message').text(data);

           }
		   
         });
});
   
   $(".transaction_update").click(function(e) {
	   
	   var transaction = $(this);
	   var transaction_id = transaction.attr('id');
	   alert(transaction_id);
   });
   
   
  
$(document).on('click','.next_step', function() {
		
		if($('.prod_count').val() == '0'){
			return false;
		}
		
		if($('.prod_buy_price').val() == ''){
			return false;
		}
			
				

		var product_select = $('#product_select').val();
		
		if(product_select == '0'  || product_select == null){
			return false;
		}
		
		hook = false;
		var document_id = $('#document_id').val();
		var product_group_select = $('#product_group_select').val();

		$.ajax({
		type: 'POST',
		url: '/api/add_warehouse_coming.php',
		data: {'document_id':document_id, 'action':'next_step'},
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},
		success: function(data)
		{	
			window.location.replace("/action_pr_expenses.php?action=add&summ=" + data + "&group=" + product_group_select + "&finance_type=1&from=warehouse");
		},
		complete:function(data){

		$(".loading").css({ display: "none" });
		}
		   
	});
	  
	  //alert(transaction_id);
})  

$(document).on('click','.back_step', function() {
		hook = false;
	   
		var document_id = $('#document_id').val();

		$.ajax({
		type: 'POST',
		url: '/api/add_warehouse_coming.php',
		data: {'document_id':document_id, 'action':'back_step'},
		
		beforeSend: function(){
			$(".loading").css({ display: "block" });
		},
		success: function(data)
		{
			location.reload();

		},
		complete:function(data){

		$(".loading").css({ display: "none" });
		}
		   
	});
	  
	  //alert(transaction_id);
}); 
   
   
var hook = true;
window.onbeforeunload = function() {
	if (hook) {
	  return "Did you save your stuff?"
	}
}
function unhook() {
	hook=false;
}

   
   
</script>
</body>
</html>
