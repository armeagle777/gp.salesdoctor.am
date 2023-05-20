<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 


$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);


if($curr_warehouse_id != 0 AND $curr_warehouse_id != ''){
	$query_warehouse_select = " AND pr_warehouse_trans.warehouse_id = '$curr_warehouse_id'";
}else{
	$query_warehouse_select = '';
}




$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
$date_ex = explode(" - ", $datebeet);
$start_date = $date_ex[0];
$end_date = $date_ex[1];

if($start_date != $end_date){
	$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
}else{
	$query_date_range = " LIKE '$start_date%'";
}


					
?>




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
            <h1>Ապրանքի ձեռքբերումներ</h1>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  
				 <form action="/warehouse_documents.php" id="statistics_form"> 
				  <div class="form-row">
				  
				 <div class="form-group col-md-3">
                  <label>Ժամանակահատված</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation" value="<?php echo $datebeet; ?>" name="datebeet">
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
				  
					<div class="form-group col-md-2">
								<label for="login">Պահեստ</label>
								<select name="warehouse_id" id="warehouse_id" class="form-control"">
								<option value="0"> Ընտրել </option>
									<?php 
										$query_warehouse = mysqli_query($con, "SELECT * FROM pr_warehouse ORDER by id DESC");
										while ($array_warehouse = mysqli_fetch_array($query_warehouse)):
										$warehouse_id = $array_warehouse['id'];
										$warehouse_name = $array_warehouse['warehouse_name'];
									?> 
									 
									<option value="<?php echo $warehouse_id; ?>"  <?php if($curr_warehouse_id == $warehouse_id ) {echo "selected"; } ?> > <?php echo $warehouse_name; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>

	
					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  
					  
					  
					
					</div>
				
				
				  </form>
			  
		
			  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
                    <th>Համար</th>
                    <th>Պահեստ</th>
                    <th>Գումար</th>
					<th>Ժամանակ</th>
                    <th style="width:150px;">Դիտել</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
					$query_warehouse_documents = mysqli_query($con, "SELECT * FROM pr_warehouse_trans LEFT JOIN pr_warehouse ON pr_warehouse_trans.warehouse_id = pr_warehouse.id WHERE transaction_type = '2' AND document_date $query_date_range $query_warehouse_select GROUP BY document_id ORDER BY document_date DESC");
					// $query_warehouse_documents = mysqli_query($con, "SELECT * FROM pr_warehouse_trans WHERE document_date $query_date_range GROUP BY document_id");
					
					while($warehouse_doc_array = mysqli_fetch_array($query_warehouse_documents)):
					$document_id = $warehouse_doc_array['document_id'];
					$warehouse_id = $warehouse_doc_array['warehouse_id'];
					$transaction_type = $warehouse_doc_array['transaction_type'];
					$manager_id = $warehouse_doc_array['manager_id'];
					$document_date = $warehouse_doc_array['document_date'];
					$warehouse_name = $warehouse_doc_array['warehouse_name'];
					//$product_summ = $warehouse_doc_array['product_count'] * $warehouse_doc_array['buy_price'];
					//$total = $total + $product_summ;
					
				  ?>
				  <tr> 
					<td><?php echo $document_id; ?></td>
					<td><?php echo $warehouse_name; ?></td>
					<td>
					
					
				  <?php 
					$query_warehouse_documents2 = mysqli_query($con, "SELECT * FROM pr_warehouse_trans LEFT JOIN pr_warehouse ON pr_warehouse_trans.warehouse_id = pr_warehouse.id LEFT JOIN pr_products ON pr_warehouse_trans.product_id = pr_products.id WHERE pr_warehouse_trans.document_id = $document_id ");
					$total = 0;

					while($warehouse_doc_array_total = mysqli_fetch_array($query_warehouse_documents2)){
						$product_summ = $warehouse_doc_array_total['product_count'] * $warehouse_doc_array_total['buy_price'];
						$total = $total + $product_summ;
					}
					
					echo $total;
				  ?>
					
					
					
					</td>
					<td><?php echo $document_date; ?></td>
					<td>
					
					<a href="/warehouse_documents_view.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0"><i class="fa fa-eye"></i></a> 
					
					<a href="/warehouse_documents_edit.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0"><i class="fa fa-edit"></i></a> 
					
					</td>
				  </tr>
				 
				 <?php endwhile; ?>
				 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Համար</th>
                    <th>Պահեստ</th>
                    <th>Գումար</th>
					<th>Ժամանակ</th>
                    <th style="width:150px;">Դիտել</th>


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

$('#not_grouped').click(function() {
    if( $(this).is(':checked')) {
        $(".not_visited_check").hide();
    } else {
        $(".not_visited_check").show();
    }
}); 

 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });
 

//#statistics_form

	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	
    $.ajax({
           type: "POST",
           url: "api/add_shop.php",
           data: {shop_id:client_to_delete, action:'delete_cient'},
           success: function(data)
           {
               //alert(data); 
			   window.location.reload();
           }
		   
         });
});
	
	

  $(function () {
    $("#example1").DataTable({
		
		initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select style="max-width: 100px;"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
    
		
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
