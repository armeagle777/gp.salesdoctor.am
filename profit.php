<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

if(isset($_GET['datebeet'])){
	
	$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = " LIKE '$start_date%'";
	}

}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Շահույթ</h1>
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
			  
			  <form action="/profit.php" id="statistics_form"> 
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
	
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  
					  
					  
					
					</div>
				
				
				  </form>
			  
			  
			  
			  
			  
                <table id="example_0" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="select-filter">Տեսակ</th>
                    <th class="select-filter">Ապրանքի խումբ</th>
                    <th>Գումար</th>
					<th>Ամսաթիվ</th>
                    <th class="select-filter">Վճարման տիպ</th>
                    <th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Ծախսի տեսակ</th>

                  </tr>
                  </thead>
                  <tbody>
		 
				 <?php
					$query = mysqli_query($con, "SELECT *, sum(order_summ) AS order_all_summ FROM pr_orders_finance LEFT JOIN pr_payment_type ON pr_orders_finance.pay_type = pr_payment_type.id LEFT JOIN pr_groups ON pr_orders_finance.payed_product_group = pr_groups.id WHERE 1=1 AND pr_orders_finance.payed_document_status = '3' AND pr_orders_finance.document_date $query_date_range GROUP BY pr_orders_finance.transaction_id" );
										
					while($orders_array = mysqli_fetch_array($query)):
					
					$document_id = $orders_array['payed_document_id'];
					$order_summ = $orders_array['order_all_summ'];
					$document_date = $orders_array['document_date'];
					$pay_type = $orders_array['payer_payment_type'];
					$group_name = $orders_array['group_name'];

				 ?>
				 
					<tr>
						<td>Գումարի մուտք</td>
						<td><?php echo $group_name; ?></td>
						<td><?php echo $order_summ; ?></td>
						<td><?php echo $document_date; ?></td>
						<td>
						
						<?php
						if($pay_type == '1') {
							echo "Դրամարկղ";
						}if($pay_type == '2') {
							echo "Բանկ";
						}
						?>
						
						
						</td>
						<td> </td>
						<td> </td>
					</tr>
				 <?php endwhile; ?> 
				 	 
					 
				 <?php
					$query = mysqli_query($con, "SELECT * FROM pr_expenses LEFT JOIN pr_groups ON pr_expenses.expenses_group = pr_groups.id LEFT JOIN pr_finance_type ON pr_expenses.expenses_type = pr_finance_type.id WHERE 1=1 AND pr_expenses.expenses_date $query_date_range " );
										
					while($orders_array = mysqli_fetch_array($query)):
					
					$expenses_summ = $orders_array['expenses_summ'];
					$document_date = $orders_array['expenses_date'];
					$pay_type = $orders_array['expenses_payment_type'];
					$group_name = $orders_array['group_name'];
					$expenses_comment = $orders_array['expenses_comment'];
					$finance_type_name = $orders_array['finance_type_name'];

				 ?>
				 
					<tr>
						<td>Գումարի ելք</td>
						<td><?php echo $group_name; ?></td>
						<td>-<?php echo $expenses_summ; ?></td>
						<td><?php echo $document_date; ?></td>
						<td>						<?php
							if($pay_type == '1') {
								echo "Դրամարկղ";
							}if($pay_type == '2') {
								echo "Բանկ";
							}
							?>
						</td>
						<td>
						<?php echo $expenses_comment; ?>
						</td>
						
						<td>
						<?php echo $finance_type_name; ?>
						</td>

					</tr>
				 <?php endwhile; ?> 
				 
				 
				 
				 
				 
				 
                  </tbody>
                  <tfoot>
                  <tr>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th></th>
					<th></th>
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

// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});

 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });



  $(function () {
    var table = $("#example_0").DataTable({

	   				"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 2;
				while(j < 4){
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
