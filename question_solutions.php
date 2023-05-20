<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$question_type1 = mysqli_real_escape_string($con, $_GET['question_type1']);
$question_type2 = mysqli_real_escape_string($con, $_GET['question_type2']);
$question_type3 = mysqli_real_escape_string($con, $_GET['question_type3']);




?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Լուծումներ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/question_add_category.php" class="btn btn-primary">Ավելացնել խնդիր</a>  
			<a href="/question_add_solution.php" class="btn btn-primary">Ավելացնել լուծում</a>
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
              <div class="card-header">	<form id="add_partner" action="/question_solutions.php">

				<div class="form-row">
				
													
				
					<div class="form-group col-md-4">
							<label for="question_type1">Խումբ</label>
							
								<select name="question_type1" class="form-control" id="question_type1">										
								<option value="0">Ընտրել</option>
								<?php 
									$query_data_category1 = mysqli_query($con, "SELECT * FROM question_categrory WHERE category_parrent='0'  ");
									while($category1_array = mysqli_fetch_array($query_data_category1)):
								
								?>
								
								<option value="<?php echo $category1_array['id']; ?>" <?php if($question_type1 == $category1_array['id']){echo 'selected'; } ?>><?php echo $category1_array['category_name']; ?></option>
								
								<?php 
									endwhile;
								?>
							
								</select>
					</div>
					
					<div class="form-group col-md-4">
							<label for="question_type2">Ենթախումբ</label>
								
								<select name="question_type2" class="form-control" id="question_type2">										
									<option value="0">Ընտրել</option>
										
									<?php 
									$query_data_category2 = mysqli_query($con, "SELECT * FROM question_categrory WHERE category_parrent='$question_type1' ");
									while($category2_array = mysqli_fetch_array($query_data_category2)):
								
									?>
									<option value="<?php echo $category2_array['id']; ?>" <?php if($question_type2 == $category2_array['id']){echo 'selected'; } ?>><?php echo $category2_array['category_name']; ?></option>

									<?php 
									endwhile;
									?>
							
								</select>
					</div>
										
					<div class="form-group col-md-4">
							<label for="question_type3">Ենթա Ենթախումբ</label>
								
								<select name="question_type3" class="form-control" id="question_type3">										
									<option value="0">Ընտրել</option>
										
									<?php 
									$query_data_category3 = mysqli_query($con, "SELECT * FROM question_categrory WHERE category_parrent='$question_type2' ");
									while($category3_array = mysqli_fetch_array($query_data_category3)):
								
									?>
									<option value="<?php echo $category3_array['id']; ?>" <?php if($question_type3 == $category3_array['id']){echo 'selected'; } ?>><?php echo $category3_array['category_name']; ?></option>

									<?php 
									endwhile;
									?>
							
								</select>
					</div>
						  
					<div class="form-group col-md-3">
							<label for="question_type2">Ցուցադրել</label>
							<br>
								  <button type="submit" class="btn btn-primary">Ցուցադրել</button>

					</div>

				


			
				</div>



			
			

			</form>
			  
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  
			  			   
		
		
			  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th >Հ\Հ</th>
                    <th class="select-filter">Խմբի անուն</th>
                    <th style="width:150px;">Խմբագրել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					
					$query = mysqli_query($con, "SELECT * FROM question_solution WHERE question_id3 = '$question_type3' ORDER by id DESC");
					while ($array_solution = mysqli_fetch_array($query)):
					$solution_id = $array_solution['id'];
					$solution_name = $array_solution['solution_name'];
				 ?> 
				  
                  <tr>
                    <td><?php echo $solution_id; ?></td>
                    <td><?php echo $solution_name; ?></td>
           
										
					
                    <td style="width:150px;">
						<a href="/question_add_solution.php?solution_id=<?php echo $solution_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						<a href="#" id="<?php echo $solution_id ; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
					</td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Հ\Հ</th>
                    <th class="select-filter">Խմբի անուն</th>
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




$( "#question_type1" ).change(function() {
	  
	  $('#question_type2 option').remove();
	  var url = 'api/question.php';
	  var question_type1 = $('#question_type1').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {question_type1: question_type1}, 
           success: function(data)
           {

			   $('#question_type2').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});

$( "#question_type2" ).change(function() {
	  
	  $('#question_type3 option').remove();
	  var url = 'api/question.php';
	  var question_type2 = $('#question_type2').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {question_type2: question_type2}, 
           success: function(data)
           {

			   $('#question_type3').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});



$( "#district" ).change(function() {
	  var district = $('#district').val();
	  $('#shop option').remove();
	  var url = 'api/shop_select.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {district: district}, 
           success: function(data)
           {

			   $('#shop').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});







	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	window.location.href = '/question_add_solution.php?solution_id=' + client_to_delete + '&action=delete';

});
	
	

  $(function () {
    $("#example1").DataTable({
		
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
