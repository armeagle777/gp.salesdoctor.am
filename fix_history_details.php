<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$shop_id = mysqli_real_escape_string($con, $_GET['shop_id']);
$shop_details = mysqli_query($con, "SELECT * FROM shops WHERE shop_id = $shop_id ");
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
            <h1>Պատմության մանրամասն</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="#" onclick="window.print()" class="btn btn-success" style="margin-right: 20px;"><i class="fa fa-print"></i></a>
			<a href="/fix_history.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
			  
                <table id="" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Գումար</th>
					<th>Ամսաթիվ</th>
					<th>Գործողություն</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query = mysqli_query($con, "SELECT * FROM shop_fix WHERE fix_shop_id = '$shop_id' ");
					
					
					while($fix_array = mysqli_fetch_array($query)):
					
																			
				 ?> 
				  
					<tr>
				
						<td><?php echo $fix_array['fix_summ']; ?></td>
						
						<td><?php echo $fix_array['fix_date']; ?></td>
						<td>
						
						<button id="<?php echo $fix_array['id']; ?>" class="btn btn-danger btn-sm rounded-0 delete_fix"><i class="fa fa-trash"></i></button>
	
	</td>
					</tr>
				 <?php endwhile; ?>
				 
				
				 
				 
				 
				 
				 
				 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Գումար</th>
					<th>Ամսաթիվ</th>
					<th>Գործողություն</th>
					
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

$(document).on('click','.delete_fix', function(e){
	
	var delete_fix = $(this).attr("id");
	var url = '/api/pr_shop_fix.php';		
    $.ajax({
           type: "POST",
           url: url,
           data: {
			    action: 'delete_fix',
				delete_fix: delete_fix,
		   }, 
		 
           success: function(data)

           {
				location.reload();
           }
		   
         });
});

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
