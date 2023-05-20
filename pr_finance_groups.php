<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$group_id_selected = mysqli_real_escape_string($con, $_GET['group_select']);



if($group_id_selected != 0 AND $group_id_selected != ''){
	$query_group_select = " AND shop_group.id = '$group_id_selected'";
}else{
	$query_group_select = '';
}



$group_post_id = mysqli_real_escape_string($con, $_POST['group_id']);
$group_text = mysqli_real_escape_string($con, $_POST['text']);

if($group_post_id !=''){
	$query_update_group = mysqli_query($con, "UPDATE shop_group SET group_comment = '$group_text' WHERE id='$group_post_id' ");
}



?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Խմբերի պատքացուցակ</h1>
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

              <!-- /.card-header -->
              <div class="card-body">
			  
			  
			  			  <table id="example" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
                    <th>Հ/Հ</th>
                    <th>Խումբ</th>
                    <th>Պարտք</th>
                    <th>Մեկնաբանություն</th>
					
				  </tr>
                  </thead>
				<tbody>
				
				<?php 
				
				$group_networks = mysqli_query($con, "SELECT * FROM shop_group");
				while($array_group = mysqli_fetch_array($group_networks)):
				$group_id = $array_group['id'];
				$group_name = $array_group['group_name'];
				$group_comment = $array_group['group_comment'];
				
				$query_shops = mysqli_query($con, "SELECT *, shops.shop_id AS shop_ids FROM group_to_shop LEFT JOIN shops ON shops.shop_id = group_to_shop.shop_id WHERE group_to_shop.group_id = '$group_id' ");
				
				$total_shops_orders = 0;
				$total_shops_veradardz = 0;
				$total_shops_payed = 0;
				
				while($array_shops = mysqli_fetch_array($query_shops)){
						
						
						$shop_id = $array_shops['shop_ids'];
						
						$array_shops_orders = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total_sum FROM pr_orders_document WHERE shop_id = '$shop_id' AND order_type !='2' "));
						
						$array_shops_veradardz = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total_sum FROM pr_orders_document  WHERE shop_id = '$shop_id' AND order_type = '2' AND order_status = '1' AND order_delivered = '1' "));

						$array_shops_payed = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_summ) AS total_sum FROM pr_orders_finance WHERE shops_id = '$shop_id' "));

						
						$total_shops_orders = $total_shops_orders + $array_shops_orders['total_sum'];
						
						$total_shops_veradardz = $total_shops_veradardz + $array_shops_veradardz['total_sum'];
						
						$total_shops_payed = $total_shops_payed + $array_shops_payed['total_sum'];
						
						
				}
				
								
				?>
				<tr>
                    <td><?php echo $group_id; ?></td>
                    <td><?php echo $group_name; ?></td>
                    <td><?php echo $total_shops_orders - $total_shops_veradardz - $total_shops_payed; ?> </td>
                    <td>
					<textarea style="width: 100%" id="<?php echo $group_id; ?>" class="group_comment form-control"><?php echo $group_comment; ?></textarea>
					</td>

                  </tr>
				  <?php endwhile; ?>
				  
                </tbody>
                  <tfoot>
                  <tr>
                    <th>Հ/Հ</th>
                    <th>Խումբ</th>
                    <th>Պարտք</th>
                    <th>Մեկնաբանություն</th>

                  </tr>
                  </tfoot>
                </table>
			  
				 <form action="/pr_finance_groups.php" id="statistics_form"> 
				  <div class="form-row">
				  

                <!-- /.form group -->
				  
					  <div class="form-group col-md-2">
								<label for="group">Խումբ</label>
								<select name="group_select" id="group_select" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 
										
										$query_group = mysqli_query($con, "SELECT * FROM shop_group ORDER by id");
										
										while ($array_group = mysqli_fetch_array($query_group)):
										$group_id = $array_group['id'];
										$group_name = $array_group['group_name'];
									?> 
									 
									<option value="<?php echo $group_id; ?>"  <?php if($group_id_selected == $group_id ) {echo "selected"; } ?> > <?php echo $group_name; ?></option>
									
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
				  
                    <th>Հ/Հ</th>
                    <th class="select-filter">Ցանց</th>
                    <th>Խանութ</th>
                    <th>Հասցե</th>
                    <th>Գումար</th>
					
				  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					
					
					$query = mysqli_query($con, "SELECT * FROM shops LEFT JOIN group_to_shop ON group_to_shop.shop_id = shops.shop_id LEFT JOIN shop_group ON group_to_shop.group_id = shop_group.id WHERE shop_group.id is not null $query_group_select");

					while($shops_array = mysqli_fetch_array($query)):
					
					$shop_id = $shops_array['shop_id'];
					$name = $shops_array['name'];
					$address = $shops_array['address'];
					$shop_group_name = $shops_array['group_name'];
					
					$array_shops_orders = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total_sum FROM pr_orders_document WHERE shop_id = '$shop_id' AND order_type !='2' "));
					
					$array_shops_veradardz = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total_sum FROM pr_orders_document WHERE shop_id = '$shop_id' AND order_type = '2' AND order_status = '1' AND order_delivered = '1' "));
					
					$array_shops_payed = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_summ) AS total_sum FROM pr_orders_finance WHERE shop_id = '$shop_id' "));

					
					
										
				 ?> 
				  
					<tr>
				  
						<td><?php echo $shop_id; ?></td>
						<td><?php echo $shop_group_name; ?></td>
						<td><?php echo $name; ?></td>
						<td><?php echo $address; ?></td>
						<td><?php echo $array_shops_orders['total_sum'] - $array_shops_veradardz['total_sum'] - $array_shops_payed['total_sum']; ?></td>
					</tr>
                 
				 <?php endwhile; ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Հ/Հ</th>
                    <th class="select-filter">Ցանց</th>
                    <th>Խանութ</th>
                    <th>Հասցե</th>
                    <th>Գումար</th>

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

$(document).on('change','.group_comment', function(){
  var group_id = this.id;
	var text = $(this).val();
	var url = '/pr_finance_groups.php';

 $.ajax({
           type: "POST",
           url: url,
           data: {
				group_id: group_id,
				text: text,
		   }, 
		   
		   error: function(){
			   $('.order_false').css("display", "block"); 
			    return false;
			},
           success: function(data)

           {
				
           },
		   timeout: 10000
		   
         });
	
});
	

  $(function () {
   var table =  $("#example1").DataTable({
	   
	   			"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                ''+pageTotal +''
            );
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
<style>
.dataTables_wrapper{
	width: 100%;
}
</style>
</body>
</html>
