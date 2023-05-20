<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	
	$company_id =  mysqli_real_escape_string($con, $_GET['company_id']);
	
	
	$query_data_company = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM question_company WHERE id='$company_id'"));
		
	$company_name = $query_data_company['company_name'];

	
	
	if($action == 'delete') {
		
		$line_id =  mysqli_real_escape_string($con, $_GET['line_id']);
		$company_id =  mysqli_real_escape_string($con, $_GET['company_id']);

		
		mysqli_query($con, "DELETE FROM question_company_to_question WHERE id = '$line_id'");
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/question_company_to_question.php?company_id=$company_id';

		</script>
		
		";
		
		
	}		
	
	if(isset($_GET['question_type3'])) {
		
		$question_type3 = mysqli_real_escape_string($con, $_GET['question_type3']);
		$question_comment = mysqli_real_escape_string($con, $_GET['question_comment']);
		
		if($question_type3 !='0'){
			
			$query_add = "INSERT INTO question_company_to_question (company_id, question_id, question_comment) VALUES ('$company_id', '$question_type3', '$question_comment')";
			mysqli_query($con, $query_add);
			
			

		}
			

	
			
			
	//	echo $query_add;
		
//		exit;
		
		echo "
		<script type='text/javascript'>
		window.location.href = '/question_company_to_question.php?company_id=$company_id';

		</script>
		
		"; 
		
		
	}	
	if($solution_id != '' and $action == 'edit') {
		
		$question_type1 = mysqli_real_escape_string($con, $_GET['question_type1']);
		$question_type2 = mysqli_real_escape_string($con, $_GET['question_type2']);
		$question_type3 = mysqli_real_escape_string($con, $_GET['question_type3']);
		
		$solution_name = mysqli_real_escape_string($con, $_GET['solution_name']);
		
		
		if($question_type1 !='0' and $question_type2 !='0' and $question_type3 !='0' and $solution_name !=''){
		
		$query_add = "UPDATE question_solution SET solution_name = '$solution_name', question_id1 = '$question_type1', question_id2 = '$question_type2', question_id3 = '$question_type3'  WHERE id='$solution_id' ";
		mysqli_query($con, $query_add);
		
	//	echo $query_add;

		}
		
		
		echo "
		
		<script type='text/javascript'>
		window.location.href = '/question_solutions.php?company_id=$company_id';

		</script>
		
		";
	}

	
	
	
	
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
			
			Կազմակերպություն՝ <?php echo $company_name; ?>
			
			
			
			</h1>
          </div>
		
          <div class="col-sm-6 d-flex justify-content-end">
		  <a href="/question_add_category.php" class="btn btn-primary">Ավելացնել խնդիր</a>&nbsp;&nbsp;
			<a href="/question_add_solution.php" class="btn btn-primary">Ավելացնել լուծում</a>&nbsp;&nbsp;
			
			<a href="/question_company.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
				<div class="alert alert-success alert-dismissible fade show" style="display: none;" role="alert" id="success_message">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				 

				</div>

<form id="add_partner" action="/question_company_to_question.php">

				<div class="form-row">
				
					
					
		<div class="form-group col-md-4">
							<label for="question_type1">Խումբ</label>
							
								<select name="question_type1" class="form-control" id="question_type1">										
								<option value="0">Ընտրել</option>
								<?php 
									$query_data_category1 = mysqli_query($con, "SELECT * FROM question_categrory WHERE category_parrent='0'  ");
									while($category1_array = mysqli_fetch_array($query_data_category1)):
								
								?>
								
								<option value="<?php echo $category1_array['id']; ?>" ><?php echo $category1_array['category_name']; ?></option>
								
								<?php 
									endwhile;
								?>
							
								</select>
					</div>
					
					<div class="form-group col-md-4">
							<label for="question_type2">Ենթախումբ</label>
								
								<select name="question_type2" class="form-control" id="question_type2">										
									<option value="0">Ընտրել</option>
										
							
								</select>
					</div>
										
					<div class="form-group col-md-4">
							<label for="question_type3">Ենթա Ենթախումբ</label>
								
								<select name="question_type3" class="form-control" id="question_type3">										
									<option value="0">Ընտրել</option>
										
							
								</select>
					</div>
					
				
						  
				  <div class="form-group col-md-12">
					<label for="name">Մեկնաբանություն</label>
					<input type="text" class="form-control" id="question_comment" name="question_comment" required placeholder="Մեկնաբանություն" value="<?php echo $question_comment; ?>">
				  </div>

				


			
				</div>

	<input type="hidden" name="company_id" value="<?php echo $company_id; ?>">

			  <button type="submit" class="btn btn-primary">Ավելացնել</button>
			

			</form>
	   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
			   
			
	   
	   
		   <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
                    <th class="select-filter">Խումբ</th>
                    <th class="select-filter">Ենթախումբ</th>
                    <th class="select-filter">Խնդիր</th>
					<th class="select-filter">Ամսաթիվ</th>
                    <th class="select-filter">Մեկնաբանություն</th>
                    <th style="width:150px;">Խմբագրել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					
					$query = mysqli_query($con, "SELECT * FROM question_company_to_question WHERE company_id = '$company_id' ORDER by id DESC");
					while ($array_questions = mysqli_fetch_array($query)):
					$line_id = $array_questions['id'];
					$question_id = $array_questions['question_id'];
					$question_date = $array_questions['question_date'];
					$question_comment = $array_questions['question_comment'];
					
					$question_3 = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM question_categrory WHERE id='$question_id' "));
					$question_3_parrent = $question_3['category_parrent'];
					
					$question_2 = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM question_categrory WHERE id='$question_3_parrent' "));
					$question_2_parrent = $question_2['category_parrent'];
					
					$question_1 = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM question_categrory WHERE id='$question_2_parrent' "));


				 ?> 
				  
                  <tr>
                    <td><?php echo $line_id; ?></td>
                    <td><?php echo $question_1['category_name']; ?></td>
                    <td> <?php echo $question_2['category_name']; ?></td>
                    <td>
					<?php echo $question_3['category_name']; ?>
					
					</td>
                    <td><?php echo $question_date; ?></td>
                    <td><?php echo $question_comment; ?></td>
           
										
					
                    <td style="width:150px;">
						<a href="#" id="<?php echo $line_id ; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
					</td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Հ\Հ</th>
                    <th class="select-filter">Խումբ</th>
                    <th class="select-filter">Ենթախումբ</th>
                    <th class="select-filter">Խնդիր</th>
                    <th class="select-filter">Ամսաթիվ</th>
                    <th class="select-filter">Մեկնաբանություն</th>
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
        <b>Ջնջե՞լ խնդիրը</b>
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


	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	window.location.href = '/question_company_to_question.php?line_id=' + client_to_delete + '&company_id='+ <?php echo $company_id; ?> +'&action=delete';

});

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
