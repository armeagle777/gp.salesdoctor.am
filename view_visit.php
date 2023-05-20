<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php
function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
  $theta = $longitude1 - $longitude2; 
  $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
  $distance = acos($distance); 
  $distance = rad2deg($distance); 
  $distance = $distance * 60 * 1.1515; 
  switch($unit) { 
    case 'Mi': 
      break; 
    case 'Km' : 
      $distance = $distance * 1.609344 * 1000; 
  } 
  
 // echo $distance;
  return (round($distance,2)); 
}
?>



<?php
  $curr_client_id = mysqli_real_escape_string($con, $_GET['client']);
  $manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
  $visit_count = mysqli_real_escape_string($con, $_GET['visit_count']);
  $get_shop_id = mysqli_real_escape_string($con, $_GET['shop_id']);
  $datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
  $date_ex = explode(" - ", $datebeet);
  $start_date = $date_ex[0];
  $end_date = $date_ex[1];

  if($start_date != $end_date){
    $query_date_range = " BETWEEN '$start_date' AND '$end_date'";
  }else{
    $query_date_range = " LIKE '$start_date%'";
  }
					
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Դիտել այցերը</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/dashboard.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
              <div class="card-body">		  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>				  
                      <th>Հ\Հ</th>
                      <th>QR համար</th>
                      <th>Խանութի Անուն</th>
                      <th>Խանութի Հասցե</th>
                      <th>Մենեջեր</th>
                      <th>Գործընկեր</th>
                      <th>Ժամանակ</th>
                      <th>Մեկնաբանություն</th>
                      <th>Ռադիուս</th>
                      <th style="width:150px;">Դիտել</th>
                      <th>Կոորդինատներ</th>
                      <th><i class="fa fa-truck" aria-hidden="true"></i></th>
                      <th><i class="fa fa-image"></i></th>
                      <th><i class="fa fa-music" ></i></th>
                      <th><i class="fa fa-star" aria-hidden="true"></i></th>
                    </tr>
                  </thead>
                  <tbody>				  
                    <?php
                      $sql= "SELECT 
                                A.audio,
                                I.image,
                                E.id AS IS_EVALUATED,
                                O.id AS HAS_ORDER,
                                V.id, 
                                V.shop_id AS SHOP_ID, 
                                V.manager_id, 
                                V.date, 
                                V.comment, 
                                V.latitude, 
                                V.longitude  
                            FROM visits V
                            LEFT JOIN evaluation_audio A ON A.visit_id=V.id
                            LEFT JOIN visit_images I ON I.visit_id = V.id
                            LEFT JOIN shop_evaluation E ON E.visit_id=V.id
                            LEFT JOIN pr_orders_document O ON O.document_date LIKE 'V.date%' AND O.shop_id=V.shop_id
                            WHERE V.shop_id = '$get_shop_id'
                                AND V.manager_id = '$manager_id_selected' 
                                AND V.date $query_date_range 
                            ORDER by V.id DESC";

                      $query = mysqli_query($con, $sql);
                      while ($array_visits = mysqli_fetch_array($query)):				
                        $visit_id = $array_visits['id'];
                        $shop_id = $array_visits['SHOP_ID'];
                        $manager_id = $array_visits['manager_id'];
                        $date = $array_visits['date'];
                        $comment = $array_visits['comment'];
                        $latitude = $array_visits['latitude'];
                        $longitude = $array_visits['longitude'];
                        $visit_count = $array_visits['visit_count'];
                        $audio = $array_visits['audio'];
                        $image = $array_visits['image'];
                        $IS_EVALUATED = $array_visits['IS_EVALUATED'];
                        $HAS_ORDER = $array_visits['HAS_ORDER'];
                        
                        if($active == 'on'){
                          $active = 'Այո';
                        }else{
                          $active = 'Ոչ';
                        }

                        $query_shop = mysqli_query($con, "SELECT qr_id, name, address, shop_latitude, shop_longitude FROM shops WHERE shop_id='$shop_id' ");
                        $array_shop = mysqli_fetch_array($query_shop);
                      
                        $shop_qr_id = $array_shop['qr_id'];
                        $shop_name = $array_shop['name'];
                        $shop_address = $array_shop['address'];
                        $shop_latitude = $array_shop['shop_latitude'];
                        $shop_longitude = $array_shop['shop_longitude'];
                      
                        $query_manager = mysqli_query($con, "SELECT manager.login AS manager_login, client.law_name AS client_name from manager, client WHERE manager.id='$manager_id' AND manager.client_id = client.id ");
                        $array_manager = mysqli_fetch_array($query_manager);					
                    ?> 
				  
                    <tr>
                      <td><?php echo $visit_id; ?></td>
                      <td><?php echo $shop_qr_id; ?></td>
                      <td><?php echo $shop_name; ?></td>
                      <td><?php echo $shop_address; ?></td>
                      <td><?php echo $array_manager['manager_login']; ?></td>
                      <td><?php echo $array_manager['client_name']; ?></td>
                      <td><?php echo $date; ?></td>
                      <td><?php echo $comment; ?></td>
                      <td>				 
                        <?php 
                        if($shop_latitude != ''){
                            $km = getDistanceBetweenPointsNew($latitude, $longitude, $shop_latitude, $shop_longitude, $unit = 'Km');
                            $km2 = getDistanceBetweenPointsNew($latitude, $longitude, $shop_latitude, $shop_longitude, $unit = 'Km');
                            echo $km;
                            $km = intval($km);
                            if($km < 50 or $km2 == 'NAN'){
                              echo "<i class='fa fa-check' style='color:#28a745'>";
                            }else{
                              echo "<i class='fa fa-times' style='color:#bd2130'>";
                            }
                        }
                        ?>
				 
				              </td>				
                      <td style="width:150px;">
                         <a href="#"   data-toggle="modal" data-target="#map<?php echo $visit_id; ?>"  class="btn btn-warning btn-sm rounded-0 delete_client_button" title="Դիտել"><i class="fas fa-map-marker-alt"></i></a>						
                        			
                        <!-- Modal -->
                        <div class="modal fade" id="map<?php echo $visit_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">N<?php echo $visit_id; ?> այցի քարտեզը</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <iframe  width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $latitude; ?>,<?php echo $longitude; ?>&hl=es&z=14&amp;output=embed"></iframe>									
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
                              </div>
                            </div>
                          </div>
                        </div>							
				              </td>					
                      <td><?php echo $latitude; ?> , <?php echo $longitude; ?></td>				                    
                      <td>
                        <?php if($HAS_ORDER): ?>
                            <!--<input type="checkbox" class="form-control" onclick='return false' checked disabled />-->
                            <i class="fa fa-truck text-muted" aria-hidden="true"></i>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if($image): ?>
                            <a href="/api/mobile/upload/<?php echo $image; ?>" class="text-muted" target="_blank" download ><i class="fa fa-image"></i></a>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if($audio): ?>
                            <a href="/api/mobile/upload/sound/<?php echo $audio; ?>" class="text-muted" target="_blank" download ><i class="fa fa-music" ></i></a>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if($IS_EVALUATED): ?>
                            <!--<input type="checkbox" class="form-control" onclick='return false' checked disabled />-->
                            <i class="fa fa-star text-muted" aria-hidden="true"></i>
                        <?php endif; ?>
                      </td>
                    </tr>                 
                      <?php endwhile; ?>                 
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Հ\Հ</th>
                      <th>QR համար</th>
                      <th>Խանութի Անուն</th>
                      <th>Խանութի Հասցե</th>
                      <th>Մենեջեր</th>
                      <th>Գործընկեր</th>
                      <th>Ժամանակ</th>
                      <th>Մեկնաբանություն</th>
                      <th>Ռադիուս</th>
                      <th style="width:150px;">Դիտել</th>
                      <th>Կոորդինատներ</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
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
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

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
        <b>Ջնջե՞լ Խանութը</b>
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
      format: 'YYYY-MM-DD'
    }
 });
 

//#statistics_form

	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	
    $.ajax({
           type: "POST",
           url: "api/add_shop.php",
           data: {shop_id:client_to_delete, action:'delete_cient'},
           success: function(data)
           {
               //alert(data); 
			   window.location.reload();
           }
		   
         });
});
	
	

  $(function () {
    $("#example1").DataTable({
		"scrollX": true,
		"autoWidth": true,
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
