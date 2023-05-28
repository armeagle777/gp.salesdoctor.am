<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Գույք 1</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/action_property1.php" class="btn btn-primary">Ավելացնել նորը</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12" >
      
	  

            <div class="card" style="overflow-y: scroll;">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Գույք 1</th>
                    <th>QR կոդ</th>
					          <th>Պահեստում է</th>
                    <th>Խանութի Հ\Հ</th>
                    <th>Անուն</th>
                    <th>Հասցե</th>
                    <th>Մենեջեր</th>
                    <th>ՀՎՀՀ</th>
                    <th>ՍՊԸ</th>
                    <th style="width:150px;">Ջնջել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
				    $sql=  "SELECT *, 
            					manager.name as manager_name, 
            					shops.name AS shop_name, 
            					pr_property1.id AS pr_property1_id, 
            					pr_property1.property_1 AS current_property_name 
        					FROM pr_property1 
            					LEFT JOIN shops ON pr_property1.property_1 = shops.property_1 
            					LEFT JOIN manager ON shops.static_manager = manager.id 
        					ORDER BY `pr_property1`.`id` DESC";

                  $query = mysqli_query($con, $sql);
                  while ($array_property = mysqli_fetch_array($query)):
                    $pr_property_id = $array_property['pr_property1_id'];
                    $pr_property1 = $array_property['current_property_name'];
                ?> 
				  
                  <tr>
                    <td><?php echo $pr_property_id; ?></td>
                    <td><?php echo $pr_property1; ?>					
                    <td style="width:150px;">
                      <input type="checkbox" class="property_check" id="<?php echo $pr_property_id; ?>"  <?php if($array_property['shop_id'] == ''){echo "checked disabled"; } ?> data-propertyid="<?php echo $pr_property1; ?>">
                    </td>
                    <td><?php echo $array_property['shop_id']; ?>
                    <td><?php echo $array_property['shop_name']; ?>
                    <td><?php echo $array_property['address']; ?>
                    <td><?php echo $array_property['manager_name']; ?>
                    <td><?php echo $array_property['hvhh']; ?>
                    <td><?php echo $array_property['law_name']; ?>					
                    <td style="width:150px;">
                      <a href="#" id="<?php echo $pr_property_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Գույք 1</th>
                    <th>QR կոդ</th>
					          <th>Պահեստում է</th>
                    <th>Խանութի Հ\Հ</th>
                    <th>Անուն</th>
                    <th>Հասցե</th>
                    <th>Մենեջեր</th>
                    <th>ՀՎՀՀ</th>
                    <th>ՍՊԸ</th>
                    <th style="width:150px;">Ջնջել</th>

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
        <b>Ջնջե՞լ գույք 1</b>
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

$('.property_check').on('change', function() { 
	var checkbox_id = $(this).attr("id");
	var dataId = $(this).data("propertyid");

        $.ajax({
           type: "POST",
           url: '/api/property.php',
           data: {checkbox_id: checkbox_id, dataId: dataId, action: 'remove'
		   }, 
	
           success: function(data)
           {

           }
		   
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
           url: "api/add_property.php",
           data: {property_id:client_to_delete, action:'delete_property_1'},
           success: function(data)
           {
               //alert(data); 
			   window.location.reload();
           }
		   
         });
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
