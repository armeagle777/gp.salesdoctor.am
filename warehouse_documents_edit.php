<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 


$document_id = mysqli_real_escape_string($con, $_GET['document_id']);



					
?>


<div class="loading" style="display: none;">Loading&#8230;</div>


<style type="text/css">
.dt-buttons {
	float: right;
    margin-top: 15px;
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ապրանքի ձեռքբերում N <?php echo $document_id; ?></h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/warehouse_documents.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  
			
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
                    <th>Պահեստ</th>
                    <th>Ապրանք</th>
                    <th>Քանակ</th>
                    <th>Գումար</th>
					<th>Ժամանակ</th>
					<th>Ջնջել</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
					$query_warehouse_documents = mysqli_query($con, "SELECT * FROM pr_warehouse_trans LEFT JOIN pr_warehouse ON pr_warehouse_trans.warehouse_id = pr_warehouse.id LEFT JOIN pr_products ON pr_warehouse_trans.product_id = pr_products.id WHERE pr_warehouse_trans.document_id = $document_id ");
					// $query_warehouse_documents = mysqli_query($con, "SELECT * FROM pr_warehouse_trans WHERE document_date $query_date_range GROUP BY document_id");
					while($warehouse_doc_array = mysqli_fetch_array($query_warehouse_documents)):
					$product_summ = $warehouse_doc_array['product_count'] * $warehouse_doc_array['buy_price'];
					$total = $total + $product_summ;
					
				  ?>
				  <tr> 
					<td><?php echo $warehouse_doc_array['warehouse_name']; ?></td>
					<td><?php echo $warehouse_doc_array['name']; ?></td>
					<td><input type="text" value="<?php echo $warehouse_doc_array['product_count']; ?>" data-oldcount="<?php echo $warehouse_doc_array['product_count']; ?>" data-productid="<?php echo $warehouse_doc_array['product_id']; ?>"  data-warehouseid="<?php echo $warehouse_doc_array['warehouse_id']; ?>"  name="product_count_eidt" class="form-control product_count_eidt"></td>
					<td><input type="text" value="<?php echo $warehouse_doc_array['buy_price']; ?>"data-oldprice="<?php echo $warehouse_doc_array['buy_price']; ?>" data-productid="<?php echo $warehouse_doc_array['product_id']; ?>" data-warehouseid="<?php echo $warehouse_doc_array['warehouse_id']; ?>" name="product_price_edit" class="form-control product_price_edit"></td>
					
					<td><?php echo $warehouse_doc_array['document_date']; ?></td>
					<td> <a href="#" id="9" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal<?php echo $warehouse_doc_array['product_id']; ?>" title="Ջնջել"><i class="fa fa-trash"></i></a>
					
					
					
					
					
					
					<!-- Modal -->
						<div class="modal fade" id="deletemodal<?php echo $warehouse_doc_array['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						  <div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle"></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<b>Ջնջե՞լ ապրանքի մուտքը</b>
							   <input type="hidden" value="" name="client_to_delete" id="client_to_delete">

							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
								<button type="button" class="btn btn-danger" id="click_delete" 
								
								
								data-oldcount="<?php echo $warehouse_doc_array['product_count']; ?>" data-productid="<?php echo $warehouse_doc_array['product_id']; ?>"  data-warehouseid="<?php echo $warehouse_doc_array['warehouse_id']; ?>" 
								
								
								>Այո</button>
							  </div>
							</div>
						  </div>
						</div>


					
					
					
					
					
					
					
					
					
					</td>
				  </tr>
				 
				 <?php endwhile; ?>
				 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th>Ընդհանուր</th>
                    <th><?php echo $total; ?></th>
					<th></th>
					<th></th>


                  </tr>
                  </tfoot>
                </table>
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
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->



<!-- Export -->

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>



<script>

$(document).on('change','.product_count_eidt', function() {
	
	var product_count_new = $(this).val();
	var oldcount = $(this).data("oldcount");
	var productid = $(this).data("productid");
	var warehouse_id = $(this).data("warehouseid");
	$.ajax({
	type: "POST",
	url: '/api/add_warehouse_coming.php',
	data: {"product_count_new": product_count_new, "action": 'edit_added_count', "oldcount": oldcount, "document_id": <?php echo $document_id; ?>, "product_id": productid, "warehouse_id": warehouse_id },    
	
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


});

$(document).on('change','.product_price_edit', function() {
	
	var product_price_new = $(this).val();
	var productid = $(this).data("productid");
	$.ajax({
	type: "POST",
	url: '/api/add_warehouse_coming.php',
	data: {"product_price_new": product_price_new, "action": 'edit_added_price', "document_id": <?php echo $document_id; ?>, "product_id": productid},    
	
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


});

$(document).on('click','#click_delete', function() {
	
	var oldcount = $(this).data("oldcount");
	var productid = $(this).data("productid");
	var warehouse_id = $(this).data("warehouseid");
	$.ajax({
	type: "POST",
	url: '/api/add_warehouse_coming.php',
	data: {"action": 'delete_added_product', "oldcount": oldcount, "document_id": <?php echo $document_id; ?>, "product_id": productid, "warehouse_id": warehouse_id },    
	
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


});

	
	

  $(function () {
    $("#example1").DataTable({
		

    
		
		        dom: 'Bfrtip',
	    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
  
		"scrollX": true,
		"autoWidth": false,
        "buttons": [
			
						{
                       extend: 'print',
                       exportOptions: {
                       columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                           }
                         },
                         {
                          extend: 'excel',
                          exportOptions: {
                          columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                         }
                       },
					   
					   'copy', 'pageLength',

			
			
        ],
		"language":{
					  "sEmptyTable": "Տվյալները բացակայում են",
					  "sProcessing": "Կատարվում է...",
					  "sInfoThousands":  ",",
					  "sLengthMenu": "Ցուցադրել արդյունքներ մեկ էջում _MENU_ ",
					  "sLoadingRecords": "Բեռնվում է ...",
					  "sZeroRecords": "Հարցմանը համապատասխանող արդյունքներ չկան",
					  "sInfo": "Ցուցադրված են _START_-ից _END_ արդյունքները ընդհանուր _TOTAL_-ից",
					  "sInfoEmpty": "Արդյունքներ գտնված չեն",
					  "sInfoFiltered": "(ֆիլտրվել է ընդհանուր _MAX_ արդյունքներից)",
					  "sInfoPostFix":  "",
					  "sSearch": "Փնտրել",
					  "oPaginate": {
						  "sFirst": "Առաջին էջ",
						  "sPrevious": "Նախորդ էջ",
						  "sNext": "Հաջորդ էջ",
						  "sLast": "Վերջին էջ"
					  },
					  "oAria": {
						  "sSortAscending":  ": ակտիվացրեք աճման կարգով դասավորելու համար",
						  "sSortDescending": ": ակտիվացրեք նվազման կարգով դասավորելու համար"
					  }
					}
		
		
		
		
    });



  });
</script>
</body>
</html>
