<?php include 'header.php'; ?>
<?php include 'api/db.php'; 

$manager_id = mysqli_real_escape_string($con, $_GET['manager_id']);

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Աշխատակցի խանութները</h1> 
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/managers.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
          
<table class="table table-bordered table-striped modal_table">
							  <thead>
								<tr>
									<?php if($_SESSION['role']!= '1' ): ?>

									<th>Ջնջել</th>
									<?php endif; ?>
									<th>Հ\Հ</th>
									<th class="word_break">QR համար</th>
									<th style="width: auto;">Անուն</th>
									<th style="width: auto;">Հասցե</th>
									<th style="width: auto;">Շրջան</th>
								</tr>
							  </thead>
							  <tbody class="shops_area">
							  
							  <?php 
								$query_shops_to_groups = mysqli_query($con, "SELECT shops.shop_id as shop_reald_id, shops.qr_id,  shops.district as shop_district, shops.name, shops.address, manager_to_shop.manager_id, manager_to_shop.shop_id, manager_to_shop.id AS row_id FROM manager_to_shop, shops WHERE manager_to_shop.shop_id = shops.shop_id AND manager_to_shop.manager_id = '$manager_id' ");
								
								while($array_shops_to_groups = mysqli_fetch_array($query_shops_to_groups)):
								$shop_id = $array_shops_to_groups['shop_id'];
								$qr_id = $array_shops_to_groups['qr_id'];
								$name = $array_shops_to_groups['name'];
								$address = $array_shops_to_groups['address'];
								$row_id = $array_shops_to_groups['row_id'];
								$shop_district = $array_shops_to_groups['shop_district'];
																
								$query_district_name = mysqli_query($con, "SELECT * FROM district WHERE id='$shop_district' ");
								$array_district_name = mysqli_fetch_array($query_district_name);
								
								$shop_district_not_name = $array_district_name['district_name'];


							  ?>
							  
							  
								<tr id="tr<?php echo $row_id; ?>">
								
								<?php if($_SESSION['role']!= '1' ): ?>
									<td><input type='checkbox' checked class='active' name='active' value='<?php echo $row_id ?>' ></td>
								<?php endif; ?>
								
									<td><?php echo $shop_id; ?></td>
									<td class="word_break"><?php echo $qr_id; ?></td>
									<td><?php echo $name; ?></td>
									<td><?php echo $address; ?></td>
									<td><?php echo $shop_district_not_name; ?></td>
								</tr>

								<?php endwhile; ?>		
							  
							  
							 
							  </tbody>
							  <tfoot>
							  <tr>
								<?php if($_SESSION['role']!= '1' ): ?>
									<th>Ջնջել</th>
								<?php endif; ?>
								
								<th>Հ\Հ</th>
								<th>QR համար</th>
								<th>Անուն</th>
								<th>Հասցե</th>
								<th>Շրջան</th>

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
