<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$shop_id = mysqli_real_escape_string($con, $_GET['shop_id']);
$shop_details = mysqli_query($con, "SELECT * FROM shops WHERE shop_id = '$shop_id' ");
while($shop_details_array = mysqli_fetch_array($shop_details)){
	$name = $shop_details_array['name'];
	$address = $shop_details_array['address'];
	$hvhh = $shop_details_array['hvhh'];
	$balance = $shop_details_array['balance'];
	$discount = $shop_details_array['discount'];
	$network = $shop_details_array['network'];
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Խանութի հետ փոխհաշվարկ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="#" onclick="window.print()" class="btn btn-success" style="margin-right: 20px;"><i class="fa fa-print"></i></a>
			<a href="/pr_finance.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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

              <!-- /.card-header -->
              <div class="card-body">
			  
                <table id="example_0" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Դիտել</th>
                    <th>Փաստաթուղթ</th>
                    <th class="select-filter">Տեսակ</th>
                    <th class="select-filter">Ապրանքի խումբ</th>
                    <th>Գումար</th>
					<th>Ամսաթիվ</th>
                    <th class="select-filter">Վճարման տիպ</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query = mysqli_query($con, "SELECT * FROM pr_orders_document LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE shop_id = '$shop_id' ");
					
					
					while($orders_array = mysqli_fetch_array($query)):
					
					
					
					$document_id = $orders_array['document_id'];
					$order_summ = $orders_array['order_last_summ'];
					$document_date = $orders_array['document_date'];
					$pay_type = $orders_array['payment_name'];
					$order_type = $orders_array['order_type'];
					$group_name = $orders_array['group_name'];
															
				 ?> 
				  
					<tr>
						<td><a href="/view_order.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i></a></td>
						<td><?php echo $document_id; ?></td>
						<td>
							<?php
							if($order_type == '1'){
								echo "Պատվեր";
							}if($order_type == '2'){
								echo "Վերադարձ";
							}if($order_type == '0'){
								echo "Հին պարտք";
							}
							?>
						<td><?php echo $group_name; ?></td>
						<td> 
						
						<?php
						if($order_type == '2'){
								echo "-";
						}
						echo $order_summ; ?>
						
						
						</td>
						<td><?php echo $document_date; ?></td>
						<td><?php echo $pay_type; ?></td>
					</tr>
				 <?php endwhile; ?>
				 
				 <?php
					$query = mysqli_query($con, "SELECT * FROM pr_orders_finance LEFT JOIN pr_payment_type ON pr_orders_finance.pay_type = pr_payment_type.id LEFT JOIN pr_groups ON pr_orders_finance.payed_product_group = pr_groups.id WHERE shop_id = '$shop_id' ");
					
					while($orders_array = mysqli_fetch_array($query)):
					
					$document_id = $orders_array['payed_document_id'];
					$order_summ = $orders_array['order_summ'];
					$document_date = $orders_array['document_date'];
					$pay_type = $orders_array['payment_name'];
					$group_name = $orders_array['group_name'];

				 ?>
				 
					<tr>
						<td><a href="/view_order.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i></a></td>
						<td><?php echo $document_id; ?></td>
						<td>Գումարի մուտք<td><?php echo $group_name; ?></td>
						<td>-<?php echo $order_summ; ?></td>
						<td><?php echo $document_date; ?></td>
						<td><?php echo $pay_type; ?></td>
					</tr>
				 <?php endwhile; ?> 
				 
				 
				 
				 
				 
				 
                  </tbody>
                  <tfoot>
                  <tr>
					<th></th>
					<th></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th></th>
					<th></th>
					<th class="select-filter"></th>
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
<!-- jQuery -->
<script src="/dist/js/jquery.tableTotal.js"></script>



<script>



  $(function () {
    var table = $("#example_0").DataTable({

	   				"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 3;
				while(j < 5){
					var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return Number(a) + Number(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal);
					j++;
				} 
			},
		
			initComplete: function () {
            this.api().columns( '.select-filter' ).every( function (index) {
				
				//    var column = table.column( index );
 
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
						"paging": false,

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
