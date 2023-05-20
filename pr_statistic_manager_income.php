<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$credit = mysqli_real_escape_string($con, $_GET['credit']);

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);

$year_selected = mysqli_real_escape_string($con, $_GET['year']);

$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);

$group_selected = mysqli_real_escape_string($con, $_GET['group_id']);


if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND shops.static_manager = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}

if($group_selected != 0 AND $group_selected != ''){
	$query_group_selected = " AND pr_orders_finance.payed_product_group = '$group_selected' ";
}else{
	$query_group_selected = '';
}


if($credit == 'on'){
	$query_paytype_select = " AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4' or pay_type = '5' or pay_type = '6') ";
}else{
	$query_paytype_select = " AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4') ";	
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
            <h1>Մենեջերներ մուտք</h1>
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
			  
				 <form action="/pr_statistic_manager_income.php" id="statistics_form"> 
				  <div class="form-row">
				  
				 <div class="form-group col-md-3" style="display:none;">
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
								<label for="login">Մենեջեր</label>
								<select name="manager_select" id="manager_select" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 

										$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' ORDER by id DESC");

										while ($array_manager = mysqli_fetch_array($query_manager)):
										$manager_id = $array_manager['id'];
										$manager_login = $array_manager['login'];
									?> 
									 
									<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>		 
					  
					  <div class="form-group col-md-2">
								<label for="login">Տարի</label>
								<select name="year" id="year" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 
										$query_year = mysqli_query($con, "SELECT YEAR(document_date) as years FROM pr_orders_finance GROUP by years ORDER BY years DESC");
										while($year_array = mysqli_fetch_array($query_year)):
										$year = $year_array['years'];
									?> 
									 
									<option value="<?php echo $year; ?>"  <?php if($year_selected == $year ) {echo "selected"; } ?> > <?php echo $year; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>
					  
					  <div class="form-group col-md-2">
							<label for="login">Խումբ</label>
							<select name="group_id" id="group_id" class="form-control">
							<option value="0"> Ընտրել </option>
								<?php 
									$query_groups = mysqli_query($con, "SELECT * FROM pr_groups");
									while($groups_array = mysqli_fetch_array($query_groups)):
									$group_id = $groups_array['id'];
									$group_name = $groups_array['group_name'];
								?> 
								 
								<option value="<?php echo $group_id; ?>"  <?php if($group_selected == $group_id ) {echo "selected"; } ?> > <?php echo $group_name; ?></option>
								
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
				  
                    <th  class='select-filter'>Մենեջեր</th>
					<th>Հունվար</th>
					<th>Փետրվար</th>
					<th>Մարտ</th>
					<th>Ապրիլ</th>
					<th>Մայիս</th>
					<th>Հունիս</th>
					<th>Հուլիս</th>
					<th>Օգոստոս</th>
					<th>Սեպտեմբեր</th>
					<th>Հոկտեմբեր</th>
					<th>Նոյեմբեր</th>
					<th>Դեկտեմբեր</th>

                    <th>Ընդհանուր</th>
                    <th>Միջին</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 				  

					$query_shops_statistic = mysqli_query($con, "SELECT *, SUM(order_summ) AS order_total, shops.static_manager AS real_static_manager FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected $query_manager_select GROUP BY shops.static_manager");
															
					while($statistic_array = mysqli_fetch_array($query_shops_statistic)):
					$manager_cur_id = $statistic_array['real_static_manager'];
					$year_total = 0;

					$shop_id = $statistic_array['shop_id'];
				  ?>
				  
				  <tr> 
					<td><?php
		
					$array_manaer_name = mysqli_fetch_array(mysqli_query($con, "SELECT login FROM manager WHERE id = '$manager_cur_id' "));
					echo $array_manaer_name['login'];
					?></td>

					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '1' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];

						?>
						
					</td>
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '2' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected"));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];

						?>
						
					</td>
					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '3' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '4' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '5' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '6' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '7' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '8' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '9' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '10' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '11' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>					
					<td>
					
						<?php
						$january_array = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS january FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE payed_document_status = '3' AND MONTH(document_date) = '12' AND shops.static_manager = '$manager_cur_id' AND YEAR(pr_orders_finance.document_date) = '$year_selected' $query_group_selected "));
												
						echo $january_array['january'];
						
						$year_total = $year_total + $january_array['january'];
						
						?>
						
					</td>
					
					<td><?php echo $year_total; ?></td>
					<td><?php
					$month = date('m');
					$mijin = $year_total / $month;
					echo round($mijin, 2)
					
					?></td>


				  </tr>
				 
				 <?php endwhile; ?>
				 
                  </tbody>
                  <tfoot>
				<tr>
				  
                    <th  class='select-filter'> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th> </th>


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



  $(function () {
    var table = $("#example1").DataTable({

	   				"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 1;
				while(j < 15){
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
		"autoWidth": true,
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
