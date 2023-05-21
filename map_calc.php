<?php include 'header.php'; ?>
<?php include 'api/db.php'; 


$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);


if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND maps.map_manager_id = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}

if(isset($_GET['datebeet'])){
	
	$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " AND maps.map_date BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = " AND maps.map_date LIKE '$start_date%'";
	}

}


?>

<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>GPS հաշվարկներ</h1>
				</div>
				<div class="col-sm-6 d-flex justify-content-end">
					<a href="/dashboard.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
				</div>
			</div>
		</div>
	</section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
				<div class="card-header">
				</div>
              	<div class="card-body">			  
					<form action="/map_calc.php" id="visits"> 
						<div class="form-row">				  
							<div class="form-group col-md-3">
								<label>Ժամանակահատված</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
									<input type="text" class="form-control float-right" id="reservation" value="<?php echo $datebeet; ?>" name="datebeet">
								</div>
							</div>
							<div class="form-group col-md-2">
								<label for="login">Աշխատակից</label>
								<select name="manager_select" id="manager_select" class="form-control">
								<option value="0"> Ընտրել </option>
								<?php 
								$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' or user_role = '5' ORDER by id DESC");

								while ($array_manager = mysqli_fetch_array($query_manager)):
								$manager_id = $array_manager['id'];
								$manager_login = $array_manager['login'];
								?> 
								<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>

								<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group col-md-1" style="max-width:150px;display: flex;  flex-direction:column;  justify-content:flex-end;">
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
							</div>
						</div>
					</form>
					<table id="example1" class="table table-bordered table-striped" style="width: 100%">
						<thead>
							<tr>
								<th class="select-filter">ID</th>
								<th class="select-filter">Աշխատակից</th>
								<th class="select-filter">Ժամանակ</th>
								<th class="">Փաստացի կմ</th>
								<th class="">Նախնական կմ</th>
								<th class="">Արժեք</th>
								<th class="">Տարբերություն կմ</th>
								<th class="select-filter">Մեկնաբանություն</th>
								<th class="select-filter">Ջնջել</th>
							</tr>
						</thead>
						<tbody id="visits_body">
							<?php 
								if($datebeet !=''):
									$query = mysqli_query($con, "SELECT *, maps.id as map_id FROM maps LEFT JOIN manager on maps.map_manager_id = manager.id WHERE 1=1 $query_date_range $query_manager_select");
								
									while($maps_array = mysqli_fetch_array($query)): ?>
										<tr> 
											<td><?php echo $maps_array['map_id']; ?></td>
											<td><?php echo $maps_array['login']; ?></td>
											<td><?php echo $maps_array['map_date']; ?></td>
											<td style="font-weight: bold;"><?php echo $maps_array['map_real_km']; ?></td>
											<td><?php echo $maps_array['map_fake_km']; ?></td>
											<td><?php echo $maps_array['map_km_cost']; ?></td>
											<td><?php echo $maps_array['map_km_dif']; ?></td>
											<td><textarea class="map_comment_edit" data-id="<?php echo $maps_array['map_id']; ?>"><?php echo $maps_array['map_comment']; ?> </textarea> </td>
											<td><a href="#" id="<?php echo $maps_array['map_id']; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
							<?php 
									endwhile; 
								endif;
							?>
						</tbody>
						<tfoot>
							<tr>
								<th class="select-filter">ID</th>
								<th class="select-filter">Աշխատակից</th>
								<th class="select-filter">Ժամանակ</th>
								<th class="">Փաստացի կմ</th>
								<th class="">Նախնական կմ</th>
								<th class="">Արժեք</th>
								<th class="">Տարբերություն կմ</th>
								<th class="select-filter">Մեկնաբանություն</th>
								<th class="select-filter">Ջնջել</th>
							</tr>
						</tfoot>
					</table>
              	</div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
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

<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>




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
        <b>Ջնջե՞լ հաշվարկը</b>
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


	jQuery(".delete_client_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#client_to_delete').val(contentPanelId);
	});
	
		
		
		
	$("#click_delete").click(function() {
		var map_to_delete = $('#client_to_delete').val();
		var url = 'api/map.php';
		$.ajax({
			   type: "POST",
			   url: url,
			   data: { map_to_delete: map_to_delete,
			           action: 'delete_map'
					 },
			   success: function(data)
			   {
				   //alert(data); 
				 window.location.reload();
			   }
			   
			 });
	});
	

$('.map_comment_edit').change(function() {

	var map_comment = $(this).val();
	var map_id = $(this).data("id");

    var url = 'api/map.php';
	
$.ajax({
	type: "POST",
	url: url,
    data:  {
			map_comment: map_comment,
			map_id: map_id,
			action: 'edit_map'
			}, 
    success: function(data) {
   
   
   
    }
});


});




 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });
 
 $('#reservation2').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });
 
 
 

  $(function () {
   var table =  $("#example1").DataTable({
	   
	
						"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 3;
				while(j < 7){
					var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return Number(a) + Number(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal);
					j++;
				} 
			},
		  
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
		  
		"order": [[ 0, "desc" ]],
		dom: 'Bfrtip',
	   
		"paging": false,
		"scrollX": true,
		"autoWidth": false,
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
