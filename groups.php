<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Խմբեր</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/action_groups.php?action=add" class="btn btn-primary">Ավելացնել նորը</a>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Խմբի անուն</th>
                    <th>Խանութներ</th>
                    <th style="width:150px;">Խմբագրել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					
					$query = mysqli_query($con, "SELECT * FROM shop_group ORDER by id DESC");
					while ($array_groups = mysqli_fetch_array($query)):
					$group_id = $array_groups['id'];
					$group_name = $array_groups['group_name'];
				 ?> 
				  
                  <tr>
                    <td><?php echo $group_id; ?></td>
                    <td>
				
						<?php echo $group_name; ?>
					
							
					<!-- Modal delete shops -->
					<div class="modal fade" id="viewshops<?php echo $group_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $group_name; ?> խմբի խանութները</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">

							<table class="table table-bordered table-striped">
							  <thead>
								<tr>
									<th>Ջնջել</th>
									<th>Հ\Հ</th>
									<th>QR համար</th>
									<th>Անուն</th>
									<th>Հասցե</th>
								</tr>
							  </thead>
							  <tbody class="shops_area">
							  
							  <?php 
								$query_shops_to_groups = mysqli_query($con, "SELECT shops.shop_id as shop_reald_id, shops.qr_id, shops.name, shops.address, group_to_shop.group_id, group_to_shop.shop_id, group_to_shop.id AS row_id FROM group_to_shop, shops WHERE group_to_shop.shop_id = shops.shop_id AND group_to_shop.group_id = '$group_id' ");
								
								while($array_shops_to_groups = mysqli_fetch_array($query_shops_to_groups)):
								$shop_id = $array_shops_to_groups['shop_id'];
								$qr_id = $array_shops_to_groups['qr_id'];
								$name = $array_shops_to_groups['name'];
								$address = $array_shops_to_groups['address'];
								$row_id = $array_shops_to_groups['row_id'];

							  ?>
							  
							  
								<tr id="tr<?php echo $row_id; ?>">
									<td><input type='checkbox' checked class='active' name='active' value='<?php echo $row_id ?>' ></td>
									<td><?php echo $shop_id; ?></td>
									<td><?php echo $qr_id; ?></td>
									<td><?php echo $name; ?></td>
									<td><?php echo $address; ?></td>
								</tr>

								<?php endwhile; ?>		
							  
							  
							 
							  </tbody>
							  <tfoot>
							  <tr>
								<th>Ջնջել</th>
								<th>Հ\Հ</th>
								<th>QR համար</th>
								<th>Անուն</th>
								<th>Հասցե</th>
							  </tr>
							  </tfoot>
							</table>






								
						
							
						








						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
						  </div>
						</div>
					  </div>
					</div>
					
					
					
					
					
					
					
					
					
					
					
					
					</td>
                    <td>
					
					<a  href="#" data-toggle="modal" data-target="#viewshops<?php echo $group_id; ?>" class="btn btn-warning btn-sm rounded-0"><i class="fa fa-eye"></i></a>
					
					<a href="/attache_group.php?group_id=<?php echo $group_id; ?>" class="btn btn-success btn-sm rounded-0" title="Կցել խանութ"><i class="fa fa-plus"></i></a></td>
                    <td style="width:150px;">
						<a href="/action_groups.php?action=edit&group_id=<?php echo $group_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						<a href="#" id="<?php echo $group_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
					</td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Հ\Հ</th>
                    <th>Խմբի անուն</th>
                    <th>Խանութներ</th>
					<th style="width:150px;">Խմբ</th>

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



$(".shops_area").on('click', 'input', function() {

var check_id_delete = $(this).attr('value');

    $.ajax({
        type: "POST",
        url: "/api/region_select.php",
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
           url: "api/add_group.php",
           data: {group_id:client_to_delete, action:'delete_cient'},
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
