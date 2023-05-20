<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);

	if($action == 'regions_add'){
		$region_name = mysqli_real_escape_string($con, $_GET['region_name']);
		$query_add_region = mysqli_query($con, "INSERT INTO region (region_name) VALUES ('$region_name') ");
	}
	
	if($action == 'district_add'){
		$district_name = mysqli_real_escape_string($con, $_GET['district_name']);
		$region_id = mysqli_real_escape_string($con, $_GET['region_select']);
		$query_add_region = mysqli_query($con, "INSERT INTO district (district_name, region_id) VALUES ('$district_name', '$region_id') ");
	}
	
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Մարզեր և քաղաքներ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">

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
				  <p class="success_message"></p>

				</div>


              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
			   
			
				<div class="form-row">
					  <div class="form-group col-md-2">
						<a href="/action_regions.php?action=add" class="form-control btn btn-success"> Ավելացնել մարզ </a>
					  </div>
				

					  <div class="form-group col-md-3">
						<a href="/action_districts.php?action=add" class="form-control btn btn-success"> Ավելացնել վարչական շրջան </a>
					  </div>
				
				</div>
							
			
			
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Մարզի անուն</th>
                    <th style="width:150px;">Խմբագրել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
					while ($array_regions = mysqli_fetch_array($query_region)):
					$region_id = $array_regions['id'];
					$region_name = $array_regions['region_name'];
				 ?> 
				  
                  <tr>
                    <td><?php echo $region_id; ?></td>
                    <td><?php echo $region_name; ?></td>
                    <td style="width:150px;">
					<a href="/action_regions.php?action=edit&region_id=<?php echo $region_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>

						<a href="#" id="<?php echo $region_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  name="region" title="Ջնջել"><i class="fa fa-trash"></i></a>
					</td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Հ\Հ</th>
                    <th>Մարզի անուն</th>
					<th style="width:150px;">Խմբագրել</th>

                  </tr>
                  </tfoot>
                </table>
			
			
			<form id="add_partner" action="/regions.php" style="margin-bottom: 30px;margin-top: 50px;display: none;" method="GET" >
			
					  <div class="form-group col-md-12">
						<label for="district_name">Վարչական շրջան</label>
						<input type="text" class="form-control" id="district_name" name="district_name" placeholder="Մարզի անուն" required>
					  </div>
					  
					  <div class="form-group col-md-12">
						<label for="region_name">Ընտրել մարզը</label>
						<select name="region_select" class="form-control">
						<option value="0"> Ընտրել </option>
 							<?php 
								$query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
								while ($array_regions = mysqli_fetch_array($query_region)):
								$region_id = $array_regions['id'];
								$region_name = $array_regions['region_name'];
							?> 
							 
							<option value="<?php echo $region_id; ?>"> <?php echo $region_name; ?></option>
							
							<?php endwhile; ?>
							
						</select>
						
						
					  </div>
				

					<input type="hidden" name="action" id="action" value="district_add">
					
					<div class="form-group col-md-12">
					    <button type="submit" class="btn btn-primary">Ավելացնել</button>
					</div>
			</form>
			
			
			
			
			
			
			<div style="padding-top: 50px; margin-bottom: 20px;"> <h3>Վարչական շրջաններ</h3> </div>
			
			<table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Վարչական շրջան</th>
                    <th>Մարզը</th>
                    <th style="width:150px;">Խմբագրել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					
					$query = mysqli_query($con, "SELECT district.id as dist_id, district.district_name as dist_name, region.region_name as reg_name FROM district, region WHERE district.region_id = region.id");
					while ($array_district = mysqli_fetch_array($query)):
					$district_id = $array_district['dist_id'];
					$district_name = $array_district['dist_name'];
					$region_name = $array_district['reg_name'];
					
					
				 ?> 
				  
                  <tr>
                    <td><?php echo $district_id; ?></td>
                    <td><?php echo $district_name; ?></td>
                    <td><?php echo $region_name; ?></td>
                    <td style="width:150px;">
					
					<a href="/action_districts.php?action=edit&district_id=<?php echo $district_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>

					<a href="#" id="<?php echo $district_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել" name="district"><i class="fa fa-trash"></i></a>
					
					</td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Հ\Հ</th>
                    <th>Վարչական շրջան</th>
                    <th>Մարզը</th>
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
        <b>Ջնջե՞լ մարզը կամ քաղաքը</b>
	   <input type="hidden" value="" name="client_to_delete" id="client_to_delete">
	   <input type="hidden" value="" name="region_or_district" id="region_or_district">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger" id="click_delete">Այո</button>
      </div>
    </div>
  </div>
</div>



<script>

	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		var contentPanelname = jQuery(this).attr("name");
		
		$('#client_to_delete').val(contentPanelId);
		$('#region_or_district').val(contentPanelname);
	});
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	var region_or_district =  $('#region_or_district').val();
    $.ajax({
           type: "POST",
           url: "api/add_region.php",
           data: {delete_id:client_to_delete, action:region_or_district},
           success: function(data)
           {
               //alert(data); 
			   window.location = "/regions.php";
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
	
	$("#example2").DataTable({
		
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
