<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Աշխատակիցներ</h1> 
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
		  <?php if($_SESSION['user_role'] == '' ): ?>
			<a href="/action_managers.php?action=add" class="btn btn-primary">Ավելացնել նորը</a>
		 <?php endif; ?>
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
                <table id="example1" class="table table-bordered table-striped modal_table">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Մուտքանուն</th>
                    <th>Տեսակ</th>
					<th>Անուն</th>
					<th>E-mail</th>
					<th>Հեռախոս</th>
					<th>Գործընկեր</th>
					<th>Աուդիտ</th>
					<th>Խանութներ</th>
					<?php if($_SESSION['role']!= '1' ): ?>
                    <th style="width:150px;">Խմբագրել</th>
					<?php endif; ?>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					if($_SESSION['role']== '1'){
						$session_client_id = $_SESSION['user_id'];
						$query = mysqli_query($con, "SELECT manager.*, client.law_name as client_name FROM manager, client WHERE manager.client_id = '$session_client_id' AND client.id = '$session_client_id' ORDER by id DESC
");

					}else{
						$query = mysqli_query($con, "SELECT manager.*, client.law_name as client_name FROM manager, client WHERE manager.client_id = client.id ORDER by id DESC");

					}
					
					
					$query = mysqli_query($con, "SELECT manager.*, client.law_name as client_name FROM manager LEFT JOIN client ON manager.client_id = client.id
");

					while ($array_managers = mysqli_fetch_array($query)):
					$manager_id = $array_managers['id'];
					$login = $array_managers['login'];
					$name = $array_managers['name'];
					$phone = $array_managers['phone'];
					$email = $array_managers['email'];
					$client = $array_managers['client_name'];
					$audit = $array_managers['audit_active'];
					$user_rope = $array_managers['user_role'];

					if($audit == 'on'){
						$audit = 'Այո';
					}else{
						$audit = 'Ոչ';
					}
					
				 ?> 
				  
                  <tr>
                    <td><?php echo $manager_id; ?></td>
                    <td> <?php echo $login; ?></td>
                    <td><?php 
					$query_role = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM user_roles WHERE id = '$user_rope' "));
					echo $query_role['role_name'];
					
					$manager_id; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $phone; ?></td>
                    <td><?php echo $client; ?></td>
                    <td><?php echo $audit; ?></td>
					
                    <td>
					  <?php if($_SESSION['role']!= '1' ): ?>

						<a href="/attache_manager.php?manager_id=<?php echo $manager_id; ?>" class="btn btn-success btn-sm rounded-0" title="Կցել խանութ"><i 	class="fa fa-plus"></i></a>
					<?php endif; ?>

					<a  href="/view_manager_shops.php?manager_id=<?php echo $manager_id; ?>"  class="btn btn-warning btn-sm rounded-0" title="Դիտել խանութները"><i class="fa fa-eye"></i></a>
					
				
					
					
					
					
					
					
					
					</td>
											<?php if($_SESSION['role']!= '1' ): ?>

                    <td style="width:150px;">
						<?php if($manager_id != '999'): ?>
						<a href="/action_managers.php?action=edit&manager_id=<?php echo $manager_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						
						<a href="#" id="<?php echo $manager_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
						<?php endif; ?>
					</td>
											<?php endif; ?>

                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
				  
                    <th>Հ\Հ</th>
					<th>Տեսակ</th>
                    <th>Մուտքանուն</th>
					<th>Անուն</th>
					<th>E-mail</th>
					<th>Հեռախոս</th>
					<th>Գործընկեր</th>
					<th>Աուդիտ</th>
					<th>Խանութներ</th>
					<?php if($_SESSION['role']!= '1' ): ?>
                    <th style="width:150px;">Խմբագրել</th>
					<?php endif; ?>
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
        <b>Ջնջե՞լ մենեջերին</b>
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



$(".shops_area").on('click', 'input', function() {

var check_id_delete = $(this).attr('value');

    $.ajax({
        type: "POST",
        url: "/api/manager_select.php",
        data: {check_id_delete: check_id_delete},
        success: function(){
           // alert ('minpen');
			$("#tr"+check_id_delete).remove();
        }
    });
return true;
});



	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	
    $.ajax({
           type: "POST",
           url: "api/add_manager.php",
           data: {manager_id:client_to_delete, action:'delete_cient'},
           success: function(data)
           {
               //alert(data); 
			   window.location.reload();
           }
		   
         });
});
	
	

  $(function () {
    $(".modal_table").DataTable({
		
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
		"paging": false,
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
