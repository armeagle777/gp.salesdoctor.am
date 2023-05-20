<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 


$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$not_grouped = mysqli_real_escape_string($con, $_GET['not_grouped']);

if($manager_id_selected != '0'){
	$query_manager_id_selected = " AND K.user_id = '$manager_id_selected'  ";
}else{
	$query_manager_id_selected = '';
}


$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
$date_ex = explode(" - ", $datebeet);
$start_date = $date_ex[0];
$end_date = $date_ex[1];

if($start_date != $end_date){
	$query_date_range = " AND K.created_at  BETWEEN '$start_date' AND '$end_date'";
}else{
	$query_date_range = " AND K.created_at LIKE '$start_date%'";
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
            <h1>Մեքենայի  վազքի վիճակագրություն</h1>
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
				 <form action="/passed_km.php" id="statistics_form"> 
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
    				<label for="login">Մենեջեր</label>
    				<select name="manager_select" id="manager_select" class="form-control">
    				    <option value="0"> Ընտրել </option>
    					<?php 
    						$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' AND active = 'on' ORDER by id DESC");
    						while ($array_manager = mysqli_fetch_array($query_manager)):
    						$manager_id = $array_manager['id'];
    						$manager_login = $array_manager['login'];
    					?> 
    					<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
    					<?php endwhile; ?>
    				</select>
    			  </div>
    			  <div class="form-group col-md-1" align="center">
					<label for="login" >Բացվածք</label>
					<input type="checkbox" class="form-control" id="not_grouped" name="not_grouped" value="1" <?php if($not_grouped == '1'){echo "checked"; } ?>>
				  </div>
				 <div class="form-group col-md-1" style="max-width:150px;display: flex;  flex-direction:column;  justify-content:flex-end;">
					<button type="submit" class="btn btn-success">Ցուցադրել</button>
				  </div>
				</div>
			  </form>
			  
		
			  
                <table id="example2" class="table table-bordered table-striped " style="width:100%">
                    <thead>
                      <tr>
                          <th>ID</th>
                          <th>Մենեջեր</th>
                          <th>ԿՄ</th>
                            <?php if($not_grouped == '1'): ?>
                          <th>Ամսաթիվ</th>
    					    <? endif; ?>
                      </tr>
                    </thead>
                    <tbody>
				  
				    <?php
				        if($not_grouped == '1'):
    					    $sql="SELECT 
                                	K.id, 
                                	K.km, 
                                	K.created_at,
                                    M.name
                                FROM 
                                	`km_passed` K
                                	LEFT JOIN manager M ON M.id=K.user_id
                                WHERE 1 
                                $query_date_range 
                                $query_manager_id_selected";
                        else:
                            $sql="SELECT 
                                	K.id, 
                                	SUM(K.km) AS MANAGER_TOTAL, 
                                    M.name
                                FROM 
                                	`km_passed` K
                                	LEFT JOIN manager M ON M.id=K.user_id
                                WHERE 1 
                                $query_date_range 
                                $query_manager_id_selected
                                GROUP BY K.user_id";
                        endif;
    					    $query = mysqli_query($con, $sql);
    					    
        					while ($row = mysqli_fetch_array($query)):
        					    extract($row);
    				    ?> 
                            <tr>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $name ; ?></td>
                                    <?php if($not_grouped == '1'): ?>
                                <td><?php echo $km ; ?></td>
                                <td><?php echo $created_at ; ?></td>
                                    <?php else: ?>
                                <td><?php echo $MANAGER_TOTAL ; ?></td>
                                    <? endif; ?>
                            </tr>
                            
                            <?php 
                                endwhile; 
                            ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th> </th>
                        <th> </th>
                            <?php if($not_grouped == '1'): ?>
                        <th> </th>
                            <? endif; ?>
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


 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });

	

  $(function () {
    $("#example2").DataTable({
  		footerCallback: function ( row, data, start, end, display ){
			var api = this.api();

			var nb_cols = api.columns().nodes().length;
			var j = 2;
			while(j < 3){
			    console.log('j',j)
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