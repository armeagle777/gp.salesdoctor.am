<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 


if(isset($_GET['datebeet'])){
	
	$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " AND M.created_at BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = "  AND M.created_at LIKE '$start_date%'";
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
            <h1>Մարքեթինգային վճարներ</h1>
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
				<form action="/marketing_payments.php" id="statistics_form"> 
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
				
					 <div class="form-group col-md-1" style="max-width:150px;display: flex;  flex-direction:column;  justify-content:flex-end;">
							<button type="submit" class="btn btn-success">Ցուցադրել</button>
					</div>
				</div>
				</form>

				<div class="form-row">
					<div class="form-group col-md-12">
						<table id="example1" class="table table-bordered table-striped">
						    <thead>
						        <!--<tr>-->
							       <!-- <th colspan="9">-->
								      <!--  <a href="/marketing_payments_add.php" class="btn btn-success">Ավելացնել ծախս</a>-->
							       <!-- </th>-->
						        <!--</tr>-->
						        <tr>
        							<th>ID</th>
        							<th>Խանութի Անուն</th>
        							<th>Խանութի Հասցե</th>
        							<th>Պլան</th>
        							<th>Վճարում</th>
        							<th>Հաստատված գումար</th>
        							<th>Տարբերություն</th>
        							<th>Ամիսներ</th>
	    							<th>Մենեջեր</th>
    							    <th>Վճարման ա/թ</th>
    							    <th>Հաստատել</th>
						        </tr>
					        </thead>
    					    <tbody>
        					    <?php
        					        $sql = "SELECT 
                                            	M.id, 
                                            	M.debt, 
                                            	M.visit, 
                                            	M.comment, 
                                            	M.is_verified, 
                                            	M.accepted_sum, 
                                            	M.created_at,
                                            	M.shop,
                                                S.shop_id,
                                                S.name AS SHOP_NAME,
                                                S.address AS SHOP_ADDRESS,
                                                S.marketing_payment,
                                                G.name AS MANAGER_NAME
                                            FROM 
                                            	`marketing_payments` M 
                                            	LEFT JOIN shops S ON S.id=M.shop
                                                LEFT JOIN manager G ON G.id=M.user_id
                                            WHERE 
                                            	1 $query_date_range";
                                    $total_plans=0;
                                    $total_payments=0;
                                    $total_accepted=0;
        							$query = mysqli_query($con, $sql);
        							while ($row = mysqli_fetch_array($query)):
        							    extract($row);
        							    $total_plans += (int)$marketing_payment;
        							    $total_payments += (int)$debt;
        							    $total_accepted += (int)$accepted_sum;
										$is_disabled = $is_verified === '1' ? " disabled" : "";
        							    
        							    $sql_sum = "SELECT SUM(accepted_sum) AS ACCEPTED_SUM FROM marketing_payments WHERE YEAR(created_at)= YEAR('$created_at') AND created_at <= '$created_at' AND shop = '$shop' GROUP BY shop";
        							 //   echo $sql_sum;
        							    $query_sum = mysqli_query($con, $sql_sum);
        							    $row_sum = mysqli_fetch_array($query_sum);
        							    extract($row_sum);
        					    ?> 
        					        <tr>
            							<!--<td><a href="/custom_expenses_all.php?datebeet=<?php echo $datebeet;?>&category_id=<?php echo $category_id; ?>"> <?php echo $category_name; ?> </a></td>-->
            							<td><?php  echo $shop_id ; ?></td>
            							<td><?php  echo $SHOP_NAME ; ?></td>
            							<td><?php  echo $SHOP_ADDRESS ; ?></td>
            							<td><?php  echo $marketing_payment ; ?></td>
            							<td><?php  echo $debt ; ?></td>
            							<td><?php  echo $accepted_sum ; ?></td>
            							<td><?php  echo $marketing_payment - $ACCEPTED_SUM ; ?></td>
            							<td><?php  echo $comment ; ?></td>
            							<td><?php  echo $MANAGER_NAME ; ?></td>
            							<td><?php  echo $created_at ; ?></td>
										<td><button payment_id="<?php echo $id; ?>" debt="<?php echo $debt; ?>" class="btn btn-outline-success btn-sm verify_debt" title="Հաստատել" <?php echo $is_disabled; ?> >
												<i class="fa fa-check"></i>
											</button>
										</td>
        					        </tr>
						        <?php endwhile; ?>
					        </tbody>    
    					    <tfoot>
    						    <tr>
        							<th>ID</th>
        							<th>Խանութի Անուն</th>
        							<th>Խանութի Հասցե</th>
        							<th><?php echo $total_plans ; ?></th>
        							<th><?php echo $total_payments; ?></th>
        							<th><?php echo $total_accepted; ?></th>
        							<th>Տարբերություն</th>
        							<th>Ամիսներ</th>
        							<th>Մենեջեր</th>
        							<th>Վճարման ա/թ</th>
									<th>Հաստատել</th>
    						    </tr>
    					    </tfoot>
    					</table>
    				</div>
    			</div>
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
<!-- AdminLTE App -->

<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>


<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->


<!-- Modal -->
<div class="modal fade" id="verify_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Հաստատել</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form action="actions.php?cmd=verify_debt" method="POST">
			<div class="form-group">
				<label>Գումարը</label>
				<input name="sum_input" id="sum_input" type="number" class="form-control"/>
				<input name="id_input" id="id_input"  type="hidden"  />
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
			<button type="submit" class="btn btn-danger" id="">Հաստատել</button>
		</div>
			</form>
		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).on('click', '.verify_debt', function(){
		const debt = $(this).attr('debt')
		const payment_id = $(this).attr('payment_id')		

		$('#verify_modal #sum_input').val(debt)
		$('#id_input').val(payment_id)

		$('#verify_modal').modal('show');
		
		
	})

	$('#reservation').daterangepicker({
		locale: {
		format: 'YYYY-MM-DD', 
		firstDay: 1
		},
		startDate: moment().startOf('month'),
		endDate: moment().endOf('month'),
	});
 



	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {
		var client_to_delete = $('#client_to_delete').val();
		window.location.href = '/custom_expenses_add_category.php?category_id=' + client_to_delete + '&action=delete';
	});
	
	

  $(function () {
    $("#example1").DataTable({
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
		},
		"paging": false,
		"searching": false,
		"info": false
		
		
		
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
</body>
</html>
