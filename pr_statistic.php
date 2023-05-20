<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$credit = mysqli_real_escape_string($con, $_GET['credit']);

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);

$year_selected = mysqli_real_escape_string($con, $_GET['year']);

$group_selected = mysqli_real_escape_string($con, $_GET['group_id']);

$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);

$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);

if($district_id_selected != 0 AND $district_id_selected != ''){
	$query_district_select = " AND S.district = '$district_id_selected'";
}else{
	$query_district_select = '';
}

if($group_selected != 0 AND $group_selected != ''){
	$query_group_selected = " AND O.product_group = '$group_selected' ";
}else{
	$query_group_selected = '';
}

if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND S.static_manager = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}


if($credit == 'on'){
	$query_paytype_select = " AND O.pay_type IN (1,2,3,4,5,6) ";
}else{
	$query_paytype_select = " AND O.pay_type IN (1,2,3,4) ";	
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

$average_months_count = $year_selected === date('Y') ? date('m') : 12;
					
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
            <h1>Վաճառք</h1>
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
			  
			    <form action="/pr_statistic.php" id="statistics_form"> 
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
										$query_year = mysqli_query($con, "SELECT YEAR(document_date) as years FROM pr_orders_document GROUP by years ORDER BY years DESC");
										while($year_array = mysqli_fetch_array($query_year)):
										$year = $year_array['years'];
									    if(!empty($year)):
        							?> 
        						                <option value="<?php echo $year; ?>"  <?php if($year_selected == $year ) {echo "selected"; } ?> > <?php echo $year; ?></option>
        							<?php
        							        endif;
        							    endwhile; 
        							?>
									
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
					  
					 <div class="form-group col-md-1"  style="display:flex;flex-direction: column;align-items:center; ">
								<label for="credit">Կրեդիտ</label>
								<input style="width:30px; height:30px; margin-top:3px" type="checkbox" name="credit" id="credit" <?php if($credit == 'on'){ echo "checked"; } ?>>
					  </div>
					  
					 <div class="form-group col-md-2" style="max-width:150px; display: flex;  flex-direction:column;  justify-content:flex-end;">
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  
					  
					  
					
					</div>
				
				
				  </form>
			  
		
			  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
                    <th  class='select-filter'>Գնորդ</th>
                    <th  class='select-filter'>Հասցե</th>
					<th  class='select-filter'>Տարածք</th>
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

					<th  class='select-filter'>Հեռախոս</th>
                    <th  class='select-filter'>Զեղչ</th>
                    <th  class='select-filter'>Մենեջեր</th>
                    <th  class='select-filter'>Ստենդ</th>
                    <th  class='select-filter'>Ցանց</th>
                    <th  class='select-filter'>Խումբ</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php
				    $query="SELECT 
            		SALES_STAT.shop_name, 
                	SALES_STAT.shop_address, 
                	SALES_STAT.district_name, 
                	SALES_STAT.shop_phone, 
                	SALES_STAT.discount, 
                	SALES_STAT.manager_name, 
                	SALES_STAT.stend_count, 
                	SALES_STAT.network_name, 
                	SALES_STAT.group_name,
                	SUM(if(SALES_STAT.order_type = '1',SALES_STAT.TOTAL,  -1* SALES_STAT.TOTAL )) AS TOTAL,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.JANUARY,  -1* SALES_STAT.JANUARY )) AS JANUARY_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.FEBRUARY,  -1* SALES_STAT.FEBRUARY )) AS FEBRUARY_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.MARCH,  -1* SALES_STAT.MARCH )) AS MARCH_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.APRIL,  -1* SALES_STAT.APRIL )) AS APRIL_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.MAY,  -1* SALES_STAT.MAY )) AS MAY_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.JUNE,  -1* SALES_STAT.JUNE )) AS JUNE_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.JULY,  -1* SALES_STAT.JULY )) AS JULY_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.AUGUST,  -1* SALES_STAT.AUGUST )) AS AUGUST_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.SEPTEMBER,  -1* SALES_STAT.SEPTEMBER )) AS SEPTEMBER_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.OCTOBER,  -1* SALES_STAT.OCTOBER )) AS OCTOBER_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.NOVEMBER,  -1* SALES_STAT.NOVEMBER )) AS NOVEMBER_RESULT,
                    SUM(if(SALES_STAT.order_type = '1',SALES_STAT.DECEMBER,  -1* SALES_STAT.DECEMBER )) AS DECEMBER_RESULT
                FROM 
                	(
                		SELECT 
                			O.order_last_summ, 
                			O.document_date, 
                			O.order_type, 
                			O.shop_id AS GROUP_SHOP_ID, 
                			S.name AS shop_name, 
                			S.phone AS shop_phone, 
                			S.address AS shop_address, 
                			S.stend_count, 
                			S.discount, 
                			D.district_name, 
                			N.network_name, 
                			M.name AS manager_name, 
                			G.group_name,
                			SUM(O.order_last_summ) AS TOTAL,
                			SUM(
                				if(
                					MONTH(O.document_date) = '1', 
                					O.order_last_summ, 
                					null
                				)
                			) AS JANUARY, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '2', 
                					O.order_last_summ, 
                					null
                				)
                			) AS FEBRUARY, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '3', 
                					O.order_last_summ, 
                					null
                				)
                			) AS MARCH, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '4', 
                					O.order_last_summ, 
                					null
                				)
                			) AS APRIL, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '5', 
                					O.order_last_summ, 
                					null
                				)
                			) AS MAY, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '6', 
                					O.order_last_summ, 
                					null
                				)
                			) AS JUNE, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '7', 
                					O.order_last_summ, 
                					null
                				)
                			) AS JULY, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '8', 
                					O.order_last_summ, 
                					null
                				)
                			) AS AUGUST, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '9', 
                					O.order_last_summ, 
                					null
                				)
                			) AS SEPTEMBER, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '10', 
                					O.order_last_summ, 
                					null
                				)
                			) AS OCTOBER, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '11', 
                					O.order_last_summ, 
                					null
                				)
                			) AS NOVEMBER, 
                			SUM(
                				if(
                					MONTH(O.document_date) = '12', 
                					O.order_last_summ, 
                					null
                				)
                			) AS DECEMBER
                		FROM 
                			`pr_orders_document` O 
                			LEFT JOIN shops S ON O.shop_id = S.shop_id 
                			LEFT JOIN group_to_shop SG ON SG.shop_id = S.shop_id 
                			LEFT JOIN shop_group G ON G.id = SG.group_id 
                			LEFT JOIN district D ON S.district = D.id 
                			LEFT JOIN region R ON D.region_id = R.id 
                			LEFT JOIN manager M ON M.id = S.static_manager 
                			LEFT JOIN network N ON S.network = N.id 
                		WHERE 
                			YEAR(O.document_date) = '$year_selected' 
                            $query_paytype_select 
                            $query_group_selected 
                            $query_manager_select 
                		GROUP BY 
                			O.order_type, O.shop_id
                	) SALES_STAT
                    GROUP BY SALES_STAT.GROUP_SHOP_ID";

                            
					$query_shops_statistic = mysqli_query($con, $query);
					
					
					while($statistic_array = mysqli_fetch_array($query_shops_statistic)):
                        extract($statistic_array);
				    ?>
				    <tr> 
    					<td><?php echo $shop_name; ?></td>
    					<td><?php echo $shop_address; ?></td>
    					<td><?php echo $district_name; ?></td>
    					<td><?php echo $JANUARY_RESULT; ?></td>
    					<td><?php echo $FEBRUARY_RESULT; ?></td>
    					<td><?php echo $MARCH_RESULT; ?></td>
    					<td><?php echo $APRIL_RESULT; ?></td>
    					<td><?php echo $MAY_RESULT; ?></td>
    					<td><?php echo $JUNE_RESULT; ?></td>
    					<td><?php echo $JULY_RESULT; ?></td>
    					<td><?php echo $AUGUST_RESULT; ?></td>
    					<td><?php echo $SEPTEMBER_RESULT; ?></td>
    					<td><?php echo $OCTOBER_RESULT; ?></td>
    					<td><?php echo $NOVEMBER_RESULT; ?></td>
    					<td><?php echo $DECEMBER_RESULT; ?></td>
    					<td><?php echo $TOTAL; ?></td>
    					<td><?php echo $TOTAL / $average_months_count; ?></td>
    					<td><?php echo $shop_phone; ?></td>
    					<td><?php echo $discount; ?></td>
    					<td><?php echo $manager_name; ?></td>
    					<td><?php echo $stend_count; ?></td>
    					<td><?php echo $network_name; ?></td>
    					<td><?php echo $group_name;	?></td>
				    </tr>
				 
				 <?php endwhile; ?>
				 
                  </tbody>
                  <tfoot>
				<tr>
				  
                    <th  class='select-filter'> </th>
                    <th  class='select-filter'> </th>
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
                    <th class='select-filter'> </th>
                    <th class='select-filter'> </th>
                    <th class='select-filter'> </th>
                    <th class='select-filter'> </th>
                    <th class='select-filter'> </th>
                    <th class='select-filter'> </th>


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
<!-- fixed header CDN -->
<script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>



<script>



  $(function () {
    var table = $("#example1").DataTable({
   			footerCallback: function ( row, data, start, end, display ){
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 3;
				while(j < 17){
					var pageTotal = api
                        .column( j, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            let columnValue=Number(a) + Number(b)
                            return columnValue.toFixed(1);
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
        //Format number cells
        columnDefs:
        [
            {
                targets: [3,4,5,6,7,8,9,10,11,12,13,14,15,16],
                render: $.fn.dataTable.render.number(' ', '.', 0, '','')
            }
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
