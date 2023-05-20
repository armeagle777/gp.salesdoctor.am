<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	
	$company_id =  mysqli_real_escape_string($con, $_GET['company_id']);
	
	
	$query_data_company = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM question_company WHERE id='$company_id'"));
		
	$company_name = $query_data_company['company_name'];


	
	
	
	
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
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
			  
			    <h3>
			
					Կազմակերպություն՝ <?php echo $company_name; ?>
					
					
				
				</h3>
			  
				<div class="alert alert-success alert-dismissible fade show" style="display: none;" role="alert" id="success_message">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				 

				</div>

	   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
			   
			
	   
	   
		   <table id="example3" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
					<th class="select-filter">Խումբ</th>
                    <th class="select-filter">Ենթախումբ</th>

                    <th class="select-filter">Խնդիր</th>
					<th class="select-filter">Ամսաթիվ</th>
                    <th class="select-filter">Մեկնաբանություն</th>
                    <th style="width:250px;">Լուծումներ</th>
                   
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
                    <td><?php echo $question_2['category_name']; ?></td>
                    <td><?php echo $question_3['category_name']; ?></td>
                    <td><?php echo $question_date; ?></td>
                    <td><?php echo $question_comment; ?></td>
                    <td>
					
					<?php 
					
					
					$query_ceck_done = mysqli_query($con, "SELECT * FROM question_company_to_solution LEFT JOIN question_solution ON question_company_to_solution.solution_id = question_solution.id WHERE company_id = '$company_id' AND question_id = '$question_id' ");
					
					while($ready_solutions = mysqli_fetch_array($query_ceck_done)):

					
					?>
						
						
						<div class="form-check" style="margin-bottom: 15px;">
							
							
						<b> <?php echo $ready_solutions['solution_name']; ?></b>
						<br>
						<?php echo $ready_solutions['solution_comment']; ?>
						</hr>
					
						
						
						</div>
					<?php endwhile; ?>
					
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
                    <th class="select-filter">Լուծումներ</th>

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


$(document).on('click','.solution_client', function(){
	var solutionid =  $(this).data("solutionid");
	var companyid = $(this).data("companyid");
	var questionid = $(this).data("questionid");
	var questioncomment =  $('.comment_' + solutionid).val();
//	var questioncomment = $('.comment_' + questionid).val();
	console.log(questionid);
	$.ajax({
        type: "POST",
        url: "/api/question.php",
        data: {solutionid: solutionid, companyid: companyid, questionid: questionid, questioncomment: questioncomment, check_solution: "check_solution"},
        success: function(){
           // alert ('minpen');

        }
	});
});


$(document).on('change','.solution_comment', function(){
	var solutionid =  $(this).data("solutionid");
	var companyid = $(this).data("companyid");
	var questionid = $(this).data("questionid");
	var questioncomment =  $('.comment_' + solutionid).val();
//	var questioncomment = $('.comment_' + questionid).val();
	console.log(questionid);
	$.ajax({
        type: "POST",
        url: "/api/question.php",
        data: {solutionid: solutionid, companyid: companyid, questionid: questionid, questioncomment: questioncomment, check_comment: "check_comment"},
        success: function(){
           // alert ('minpen');

        }
	});
});




	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	window.location.href = '/question_company_to_question1.php?line_id=' + client_to_delete + '&company_id='+ <?php echo $company_id; ?> +'&action=delete';

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
