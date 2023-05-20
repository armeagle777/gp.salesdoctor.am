<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);


$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);

if($district_id_selected != 0 AND $district_id_selected != ''){
	$query_district_select = " AND shops.district = '$district_id_selected'";
}else{
	$query_district_select = '';
}


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
	
	$query = "SELECT *, SUM(order_summ) as total_summ, manager.name as user_name, shops.name AS shop_name, pr_orders_finance.id AS pr_orders_finance_id FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id LEFT JOIN pr_payment_type ON pr_orders_finance.pay_type = pr_payment_type.id LEFT JOIN manager ON pr_orders_finance.user_id = manager.id WHERE 1=1 AND document_date $query_date_range GROUP BY transaction_id";

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
            <h1>Գումարի մուտքեր</h1>
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
			  
				 <form action="/pr_finance_history.php" id="statistics_form"> 
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
				  
					<div class="form-group col-md-2" style="display: none;">
								<label for="login">Խանութ</label>
								<select name="warehouse_id" id="warehouse_id" class="form-control mdb-select md-form"">
								<option value="0"> Ընտրել </option>
									<?php 
										$query_shops = mysqli_query($con, "SELECT * FROM shops ORDER by id DESC");
										while ($array_shop = mysqli_fetch_array($query_shops)):
										$shop_id = $array_shop['shop_id'];
										$shop_name = $array_shop['name'];
									?> 
									 
									<option value="<?php echo $shop_id; ?>"  <?php if($curr_warehouse_id == $shop_id ) {echo "selected"; } ?> > <?php echo $shop_name; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>

		
				 
					  <div class="form-group col-md-2" style="display: none;">
								<label for="login">Մենեջեր</label>
								<select name="manager_select" id="manager_select" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 
										if($_SESSION['role'] == '1' ){
											$session_client_id = $_SESSION['user_id'];
											$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE client_id = '$session_client_id' ORDER by id DESC");

										}else{
											$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE client_id = '$curr_client_id' ORDER by id DESC");
										}
										while ($array_manager = mysqli_fetch_array($query_manager)):
										$manager_id = $array_manager['id'];
										$manager_login = $array_manager['login'];
									?> 
									 
									<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
									
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
				  
                    <th class="select-filter">Հ/Հ</th>
                    <th class="select-filter">Մուտքի Հ/Հ</th>
                    <th class="select-filter">Ժամանակ</th>
                    <th class="select-filter">Աշխատակից</th>
                    <th>Գումար</th>
                    <th class="select-filter">Կարգավիճակ (գործավար)</th>
                    <th class="select-filter">Վճ. տիպ</th>
                    <th class="select-filter">Բանկ</th>
                    <th style="width:150px;">Գործողություն</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
				  
					$query_shops_documents = mysqli_query($con, "$query");
					
					//echo $query;
					
					while($shops_array = mysqli_fetch_array($query_shops_documents)):
					$shop_id = $shops_array['shop_id'];
					$qr_id = $shops_array['qr_id'];
					$curr_shop_name = $shops_array['shop_name'];
					$address = $shops_array['address'];
					$total = $shops_array['total_summ'];
					$transaction_id = $shops_array['transaction_id'];
					$user_name = $shops_array['user_name'];
					$document_date = $shops_array['document_date'];
					$payer_payment_type = $shops_array['payer_payment_type'];
					$payer_payment_bank = $shops_array['payer_payment_bank'];
					$pr_orders_finance_id = $shops_array['pr_orders_finance_id'];

					
				  ?>
				  
				  <tr> 
					<td><?php echo $shop_id; ?></td>
					<td><?php echo $transaction_id; ?></td>
					<td><input type="text" value="<?php echo $document_date; ?>" class="form-control editable_date" id="<?php echo $transaction_id; ?>" style="width: 100px;"></td>
					<td><?php echo $user_name; ?></td>
					<td><?php echo $total; ?></td>
					

					 
					<td>
					<?php 
					$query_all_document_statuses = mysqli_query($con, "SELECT * FROM pr_orders_finance WHERE payed_document_status = '1' AND transaction_id = '$transaction_id' ");
					$num_count_rows = mysqli_num_rows($query_all_document_statuses);

					?> 
					<input type="checkbox" class="form-control order_full_payed_from_transaction" id="<?php echo $transaction_id; ?>" <?php if($num_count_rows == '0'){ echo "checked"; } ?>>
					
					
					</td>

					
					
					<td><?php 
					if($payer_payment_type == '1'){
						echo "Դրամարկղ";
					}if($payer_payment_type == '2'){
						echo "Բանկ";
					}
					?></td>
					<td>
						<?php 
							$bank_array = mysqli_fetch_array(mysqli_query($con, "SELECT bank_name FROM pr_bank WHERE id='$payer_payment_bank' "));
							echo $bank_array['bank_name'];
						
						?>
					</td>
					<td>
					<a style="" href="/pr_finance_history_edit.php?transaction_id=<?php echo $transaction_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fa fa-search"></i></a>
					</td>
				  </tr>
				 
				 <?php endwhile; ?>
				 
                  </tbody>
                  <tfoot>
                  <tr>
				  
                    <th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th></th>
                    <th class="select-filter"></th>
					<th class="select-filter"></th>
                    <th class="select-filter"></th>
                    <th style="width:150px;"></th>


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


$(document).ready(function(){
        $('.editable_date').change(function(){
 
			var pr_orders_finance_id = $(this).attr('id');
			var editable_date = $(this).val();
			$.ajax({
				type: "POST",
				url: "api/add_pr_finance.php",
				data: {pr_orders_finance_id:pr_orders_finance_id, editable_date: editable_date, action: 'change_payment_date'},
				success: function(data)
				{
				   //alert(data); 
				   window.location.reload();
				}
			   
			});
        });
    });
	
	
	
$(document).ready(function(){
        $('.order_full_payed_from_transaction').click(function(){
            if($(this).is(":checked")){
                var status = '3';
            }
            else if($(this).is(":not(:checked)")){
                var status = '1';
            }
			
			var transaction_id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "api/add_pr_finance.php",
				data: {transaction_id:transaction_id, action:'order_full_payed_from_transaction', status: status},
				success: function(data)
				{
				   //alert(data); 
				   window.location.reload();
				}
			   
			});
        });
    });


// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});


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
		
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 4;
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
	    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
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
</body>
</html>
