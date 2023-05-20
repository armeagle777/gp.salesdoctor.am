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
            <h1>Հաշվարկ</h1>
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
			  
				<form action="/custom_expenses.php" id="statistics_form"> 
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
				
					 <div class="form-group col-md-1">
							<label for="login"> </label>
							<button type="submit" class="btn btn-success">Ցուցադրել</button>
					</div>
				  
				</div>
				
			
					  
					  
				</form>

				<div class="form-row">

					<div class="form-group col-md-5">
					
										 
						<table id="example1" class="table table-bordered table-striped">
						  <thead>
						  <tr>
							<th colspan="4">
								<a href="/custom_expenses_add.php?expenses_type=1" class="btn btn-success">Ավելացնել եկամուտ</a>
								Ընդհանուր՝ <?php 
								

									$query_items_total = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(expenses_sum) AS total FROM custom_expenses WHERE  expenses_date $query_date_range AND expenses_type = 1 ")); 
									echo $query_items_total['total'];
									
									$query_items_total_category = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(category_plan) AS total FROM custom_expenses_category WHERE category_type = 1 ")); 

								?>
							
								
							</th>

						  </tr>
						  
						  <tr>
							<th colspan="2">
							Խումբ <a href="/custom_expenses_add_category.php" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i></a>
							
							</th>
								
							<th>
							<?php //echo $query_items_total_category['total'] - $query_items_total['total']; ?>
							</th>
							
							<th>
								<?php 
									
									echo $query_items_total_category['total'];
								?>
							
							</th>

						  </tr>
						  
						  <tr>
							<th>Խումբ</th>
							<th>Գումար</th>
							<th>Տարբերություն</th>
							<th>Պլան</th>
						  </tr>
						  </thead>
						  <tbody>
						  
						  
						 <?php 
							
							$query = mysqli_query($con, "SELECT * FROM `custom_expenses_category` WHERE category_type = 1");
							
							$ekamut_total = 0;
							
							while ($array_category = mysqli_fetch_array($query)):
							$category_id = $array_category['id'];
							$category_name = $array_category['category_name'];

							$category_plan = $array_category['category_plan'];
						 ?> 
						  
						  <tr>
							<td><a href="/custom_expenses_all.php?datebeet=<?php echo $datebeet;?>&category_id=<?php echo $category_id; ?>"> <?php echo $category_name; ?> </a></td>
							<td>
							<?php
								$query_items = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(expenses_sum) AS total FROM custom_expenses WHERE expenses_category = '$category_id' AND expenses_date $query_date_range"));
							
								echo $query_items['total']; ?>
							</td>
							
							<td>
							<?php 
							
							
							
							$diference_ekamut = $category_plan - $query_items['total']; 
							if($diference_ekamut < 0) {
								$diference_ekamut = 0;
							}
							
							echo $diference_ekamut;
							
							$ekamut_total = $ekamut_total + $diference_ekamut;
							
							?>
							</td>
							<td><?php echo $category_plan; ?></td>
						  </tr>
						 
						 <?php endwhile; ?>
						 
						  </tbody>
						  <tfoot>
						  <tr>
							<th>Խումբ</th>
							<th>Գումար</th>
							<th><?php echo $ekamut_total; ?></th>
							<th>Պլան</th>

						  </tr>
						  </tfoot>
						</table>

					</div>
					
					<div class="form-group col-md-2">
					
					
								<table id="example1" class="table table-bordered table-striped">
						  <thead>
					
						  <tr>
							<th>Տարբերություն</th>
						  </tr>
						  </thead>
						  <tbody>
						  
					
						  
						  <tr>
							<td style="text-align: center;">
							<?php 
								$query_items_total_caxs = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(expenses_sum) AS total FROM custom_expenses WHERE  expenses_date $query_date_range AND expenses_type = 2 ")); 
							?>
							
							<b> <?php echo $query_items_total['total'] - $query_items_total_caxs['total']; ?> </b>
							
							
							</td>
							
						  </tr>
						 
						 
						  </tbody>
						  <tfoot>
						  <tr>
							<th></th>
						

						  </tr>
						  </tfoot>
						</table>
					
					
					
					
					

					</div>
					
					
					<div class="form-group col-md-5">
					
					
											<table id="example1" class="table table-bordered table-striped">
						  <thead>
						  <tr>
							<th colspan="4">
								<a href="/custom_expenses_add.php?expenses_type=2" class="btn btn-success">Ավելացնել ծախս</a>
								Ընդհանուր՝ <?php 
								

									$query_items_total_caxs = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(expenses_sum) AS total FROM custom_expenses WHERE  expenses_date $query_date_range AND expenses_type = 2 ")); 
									echo $query_items_total_caxs['total'];
									
									$query_items_total_category = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(category_plan) AS total FROM custom_expenses_category WHERE category_type = 2 ")); 

								?>
							
								
							</th>

						  </tr>
						  
						  <tr>
							<th colspan="2">
							Խումբ <a href="/custom_expenses_add_category.php" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i></a>
							
							</th>
								
							<th>
							<?php  
								$total_all1 =  $query_items_total_category['total'] - $query_items_total_caxs['total'];
							
							/*		
								if($total_all1 < 0){
									$total_all1 = -1 * $total_all1;
								}
							*/
								// echo $total_all1;


							?>
							
							
							
							
							
							</th>
							
							<th>
								<?php 
									
									echo $query_items_total_category['total'];
								?>
							
							</th>

						  </tr>
						  
						  <tr>
							<th>Խումբ</th>
							<th>Գումար</th>
							<th>Տարբերություն</th>
							<th>Պլան</th>
						  </tr>
						  </thead>
						  <tbody>
						  
						  
						 <?php 
							
							$query = mysqli_query($con, "SELECT * FROM `custom_expenses_category` WHERE category_type = 2");
							
							$caxs_total = 0;
							while ($array_category = mysqli_fetch_array($query)):
							$category_id = $array_category['id'];
							$category_name = $array_category['category_name'];

							$category_plan = $array_category['category_plan'];
						 ?> 
						  
						  <tr>
							<td><a href="/custom_expenses_all.php?datebeet=<?php echo $datebeet;?>&category_id=<?php echo $category_id; ?>"> <?php echo $category_name; ?> </a></td>

							<td>
							<?php
								$query_items = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(expenses_sum) AS total FROM custom_expenses WHERE expenses_category = '$category_id' AND expenses_date $query_date_range"));
							
								echo $query_items['total']; ?>
							</td>
							
							<td>
							
							<?php 
							
							$diference_caxs = $category_plan - $query_items['total']; 
							if($diference_caxs < 0) {
								$diference_caxs = 0;
							}
							
							echo $diference_caxs;
							
							$caxs_total = $caxs_total + $diference_caxs;

							
							?>
							
							
							
							</td>
							<td><?php echo $category_plan; ?></td>
						  </tr>
						 
						 <?php endwhile; ?>
						 
						  </tbody>
						  <tfoot>
						  <tr>
							<th>Խումբ</th>
							<th>Գումար</th>
							<th><?php echo $caxs_total; ?></th>
							<th>Պլան</th>

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
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <b>Ջնջե՞լ խումբը</b>
	   <input type="hidden" value="" name="client_to_delete" id="client_to_delete">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger" id="click_delete">Այո</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">


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
