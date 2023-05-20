<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

	$category_id =  mysqli_real_escape_string($con, $_GET['category_id']);
	$category_type =  mysqli_real_escape_string($con, $_GET['category_type']);

	
	if(isset($_GET['datebeet'])){
		

	$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " AND expenses_date BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = " AND expenses_date LIKE '$start_date%'";
	}
	
}else{
	$query_date_range = '';
}
	
	
if($category_id != 0 AND $category_id != ''){
	$query_category_selected = " AND expenses_category = '$category_id'";
}else{
	$query_category_selected = '';
}
	
	
if($category_type != 0 AND $category_type != ''){
	$query_category_type = " AND expenses_type = '$category_type'";
}else{
	$query_category_type = '';
}


?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Գումարի մուտքեր</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end" style="display: none !important">
			<a href="/custom_expenses_add.php" class="btn btn-primary">Ավելացնել</a>
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
			  
			   <form action="/custom_expenses_all.php" id="statistics_form"> 
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
								  
					<div class="form-group col-md-2">
								<label for="category_id">Խումբ</label>
								<select name="category_id" id="category_id" class="form-control">
								<option value="0"> Ընտրել </option>
								<?php 
								
								$query_category = mysqli_query($con, "SELECT * FROM custom_expenses_category");
								while($array_category_loop = mysqli_fetch_array($query_category)):								
								?>
								
									<option value="<?php echo $array_category_loop['id']; ?>" <?php if($array_category_loop['id'] == $category_id) {echo "selected"; } ?> > <?php echo $array_category_loop['category_name']; ?> </option>

								<?php endwhile; ?>
								
								
								
								</select>
					</div>		
					
					<div class="form-group col-md-2">
								<label for="category_type">Տեսակ</label>
								<select name="category_type" id="category_type" class="form-control">
								<option value="0"> Ընտրել </option>
								<option value="1" <?php if ($category_type == '1') {echo "selected"; } ?>> Եկամուտ </option>
								<option value="2" <?php if ($category_type == '2') {echo "selected"; } ?>> Ծախս </option>
								</select>
					</div>
				
				
					  
					 <div class="form-group col-md-1">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
				
				
                <!-- /.form group -->
				</div>
			
			  </form>
			  
		
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Խումբ</th>
                    <th>Նշում</th>
					<th>Գումար</th>
                    <th>Տեսակ</th>
                    <th>Օր</th>
                    <th style="width:150px;">Խմբագրել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					
					$query = mysqli_query($con, "SELECT * FROM custom_expenses WHERE 1=1 $query_category_selected $query_date_range  $query_category_type  ORDER by id DESC");

				
					
					
					while ($array_expenses = mysqli_fetch_array($query)):
					$expenses_id = $array_expenses['id'];
					$expenses_name = $array_expenses['expenses_name'];
					$expenses_category = $array_expenses['expenses_category'];
					$expenses_date = $array_expenses['expenses_date'];
					$expenses_sum = $array_expenses['expenses_sum'];
					$expenses_type = $array_expenses['expenses_type'];
				 ?> 
				  
                  <tr>
                    <td><?php echo $expenses_id; ?></td>
                    <td><?php

					$array_category = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM custom_expenses_category WHERE id = '$expenses_category' "));
					echo $array_category['category_name'];


					?></td>
					                    <td><?php echo $expenses_name; ?></td>
 <td><?php echo $expenses_sum; ?></td>
                   
                    <td><?php 
					
					if($expenses_type == 1) {
						echo 'Եկամուտ';
					}					
					if($expenses_type == 2) {
						echo 'Ծախս';
					}
					
					?></td>
					
					<td><?php echo $expenses_date; ?></td>

										
					
                    <td style="width:150px;">
						<a href="/custom_expenses_add.php?expenses_id=<?php echo $expenses_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						<a href="#" id="<?php echo $expenses_id ; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
					</td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Խումբ</th>
                    <th>Նշում</th>
                    <th>Տեսակ</th>
                    <th>Օր</th>
                    <th>Գումար</th>
                    <th style="width:150px;">Խմբագրել</th>

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


<script>
 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });
 
	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	window.location.href = '/custom_expenses_add.php?expenses_id=' + client_to_delete + '&action=delete';

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
					}
		
		
		
		
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
