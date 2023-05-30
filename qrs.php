<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
<style>
    .chosen-container, .chosen-container-single,.chosen-single{
        height: 37px!important;  
        width:400px!important;
    }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>QR կոդերի ցանկ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/action_qrs.php" class="btn btn-primary">Ավելացնել նորը</a>
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
                    <th>QR</th>
                    <th width="20%">Գույք</th>
                    <th width="40%">Խանութ</th>
                    <th style="width:150px;">Ջնջել</th>
                  </tr>
                  </thead>
                  <tbody>				  
                    <?php           
                      $sql="SELECT 
                              Q.id, 
                              Q.qr_code, 
                              Q.qr_shop, 
                              Q.qr_property,
                              S.id AS shop_id, 
                              S.name AS shop_name, 
                              S.address AS shop_address,
                              P.property_1 AS property_name 
                            FROM pr_qr Q
                              LEFT JOIN shops S ON S.id=Q.qr_shop
                              LEFT JOIN pr_property1 P ON P.id=Q.qr_property
                            ORDER by Q.id DESC";
                      $query = mysqli_query($con, $sql);
                      while ($array_property = mysqli_fetch_array($query)):
                        $pr_qr_id = $array_property['id'];
                        $qr_code = $array_property['qr_code'];
                        $qr_shop = $array_property['qr_shop'];
                        $qr_property = $array_property['qr_property'];

                        $shop_name = $array_property['shop_name'];
                        $shop_address = $array_property['shop_address'];
                        
                        $property_name = $array_property['property_name'];
                    ?>				  
                      <tr>
                        <td><?php echo $pr_qr_id; ?></td>
                        <td><?php echo $qr_code; ?></td>				
                        <td><?php echo $property_name; ?></td>				
                        <td><?php if($shop_name) echo $shop_name."($shop_address)"; ?></td>				
                        <td style="width:150px;">
                          <button class="btn btn-primary btn-sm edit_qr" 
                                  qr_shop = "<?php echo $qr_shop; ?>" 
                                  qr_property= "<?php echo $qr_property; ?>" 
                                  qr_id="<?php echo $pr_qr_id ; ?>" 
                                  qr_code="<?php echo $qr_code ; ?>" 
                                  title="Խմբագրել">
                            <i class="fa fa-edit"></i>
                          </button>
                          <a href="#" id="<?php echo $pr_qr_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>                 
                    <?php endwhile; ?>                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>QR</th>
                    <th>Գույք</th>
                    <th>Խանութ</th>
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
<!-- Chosen script  -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
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
        <b>Ջնջե՞լ QR</b>
	      <input type="hidden" value="" name="client_to_delete" id="client_to_delete">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger" id="click_delete">Այո</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal edit -->
<div class="modal  fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id='save_qr_edit' action='/actions.php?cmd=save_qr_edit' method='POST'>
        <div class="modal-body" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
          <button type="submit" class="btn btn-success" id="click_edit">Պահպանել</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>


  $(document).on('click', '.edit_qr', function(){
    const qr_id = $(this).attr('qr_id')
    const qr_code = $(this).attr('qr_code')
    const qr_shop = $(this).attr('qr_shop')
    const qr_property = $(this).attr('qr_property')
    
    $.ajax({
      type: "POST",
      url: "actions.php?cmd=qr_edit_modal",
      data: {qr_id,qr_code,qr_shop,qr_property},
      success: function(data)
      {
        $('#editmodal .modal-body').html(data)
		    $('#editmodal').modal('show');
      }
		   
    });
    
  })

	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	
    $.ajax({
           type: "POST",
           url: "api/add_property.php",
           data: {property_id:client_to_delete, action:'delete_qr'},
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
