<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$task_done = mysqli_real_escape_string($con, $_GET['task_done']);

if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND manager_id = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}

if($task_done != 3 AND $task_done != ''){
	$query_task_done = " AND admin_task_ok = '$task_done'";
}else{
	$query_task_done = '';
}


?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Առաջադրանքներ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/action_tasks.php?action=add" class="btn btn-primary">Ավելացնել նորը</a>
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
			  
			  <form action="/tasks.php" id="statistics_form"> 
				  <div class="form-row">
				  
				 
		
				 
					  <div class="form-group col-md-2">
								<label for="manager_select">Մենեջեր</label>
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
								<label for="task_done">Կատարած</label>
								<select name="task_done" id="task_done" class="form-control">
								<option value="3"> Ընտրել </option>
								<option value="1" <?php if($task_done == '1'){ echo "selected"; } ?>> Այո </option>
								<option value="0" <?php if($task_done == '0'){ echo "selected"; } ?>> Ոչ </option>
								
									
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
				  
					<th class="select-filter">Հ\Հ</th>
                    <th class="select-filter">Գործընկեր</th>
                    <th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Կատարած</th>

					<th class="select-filter">Առաջադրանք</th>
                    <th class="select-filter">Պատասխան</th>
					<th class="select-filter">Մենեջերի պատասխան</th>
					<th class="select-filter">Կատարած</th>
					<th class="select-filter">Ստեղծման օր</th>
					<th class="select-filter">Պատասխանի օր</th>
					<th class="select-filter">Օրացույց</th>

                    <th style="width:150px;">Խմբագրել</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query = mysqli_query($con, "SELECT * FROM tasks WHERE 1=1 $query_manager_select $query_task_done ORDER by id DESC");
					while ($array_tasks = mysqli_fetch_array($query)):
					$id = $array_tasks['id'];
					$manager_id = $array_tasks['manager_id'];
					$task = $array_tasks['task'];
					$answer = $array_tasks['answer'];
					$manager_task_ok = $array_tasks['manager_task_ok'];
					$admin_task_ok = $array_tasks['admin_task_ok'];
					$created_date = $array_tasks['created_date'];
					$answer_date = $array_tasks['answer_date'];
					$calendar_date = $array_tasks['calendar_date'];

					
					if($manager_task_ok == '1'){
						$manager_task_ok = 'Այո';
					}else{
						$manager_task_ok = 'Ոչ';
					}
					
					if($admin_task_ok == '1'){
						$admin_task_ok_text = 'Այո';
					}else{
						$admin_task_ok_text = 'Ոչ';
					}
					
					$query_client = mysqli_query($con, "SELECT client.law_name AS client_name, manager.* from manager, client WHERE manager.id='$manager_id' AND manager.client_id = client.id ");
					$array_client = mysqli_fetch_array($query_client);
					
					$query_manager = mysqli_query($con, "SELECT login, id from manager WHERE id='$manager_id' ");
					$array_manager = mysqli_fetch_array($query_manager);
					
				 ?> 
				  
                  <tr>
				  
				 <td><?php echo $id; ?></td>
				 <td><?php echo $array_client['client_name']; ?></td>
				 <td><?php echo $array_manager['login']; ?></td>
				 <td><input type="checkbox" class="form-control task_ok" id="<?php echo $id; ?>" <?php if($admin_task_ok == '1'){echo "checked"; } ?>></td>
				 <td><?php echo $task; ?></td>
				 <td><?php echo $answer; ?></td>
				 <td><?php echo $manager_task_ok; ?></td>
				 <td><?php echo $admin_task_ok_text; ?></td>
				 <td><input type="text" value="<?php echo $created_date; ?>" class="form-control editable_date" style="width: 150px;" id="<?php echo $id; ?>"> </td>
				 <td><?php echo $answer_date; ?></td>
				 <td><?php echo $calendar_date; ?></td>

                 <td style="width:150px;">
						<a href="/action_tasks.php?action=edit&task_id=<?php echo $id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						<a href="#" id="<?php echo $id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
				  </td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
					<th class="select-filter">Հ\Հ</th>
                    <th class="select-filter">Գործընկեր</th>
                    <th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Կատարած</th>
					<th class="select-filter">Առաջադրանք</th>
                    <th class="select-filter">Պատասխան</th>
					<th class="select-filter">Մենեջերի պատասխան</th>
					<th class="select-filter">Կատարած</th>
					<th class="select-filter">Գրանցման օր</th>
					<th class="select-filter">Ստեղծման օր</th>
					<th class="select-filter">Օրացույց</th>

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
        <b>Ջնջե՞լ Առաջադրանքը</b>
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

$(document).on('change','.task_ok', function(){
	
	var task_val = $(this).val();
	var task_id = $(this).attr('id');
	var url = '/api/pr_task.php';
	
	if($(this).is(':checked')){
		task_val = 'on';
	}else{
		task_val = 'off';
	}
		
    $.ajax({
           type: "POST",
           url: url,
           data: {
				task_val: task_val,
				task_id: task_id,
				action: "change_status"
		   }, 
           success: function(data)
			   {			  

			   }
		   
         });
	
	});

$(document).ready(function(){
        $('.editable_date').change(function(){
 
			var task_id = $(this).attr('id');
			var task_date = $(this).val();
			$.ajax({
				type: "POST",
				url: "api/pr_task.php",
				data: {task_id:task_id, task_date: task_date, action: 'change_date_created'},
				success: function(data)
				{
				   //alert(data); 
				   window.location.reload();
				}
			   
			});
        });
    });
	



	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	
    $.ajax({
           type: "POST",
           url: "api/add_task.php",
           data: {task_id:client_to_delete, action:'delete_cient'},
           success: function(data)
           {
               //alert(data); 
			   window.location.reload();
           }
		   
         });
});
	
	

  $(function () {
    var table = $("#example1").DataTable({

	 
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
