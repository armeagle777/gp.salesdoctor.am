<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Գործընկերներ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/action_partners.php?action=add" class="btn btn-primary">Ավելացնել նորը</a>
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
                    <th>Մուտքանուն</th>
                    <th>Անուն</th>
                    <th>Հասցե</th>
                    <th>ՀՎՀՀ</th>
					<th>Հեռախոս</th>
					<th>E-mail</th>
                    <th>Գումար</th>
                    <th>Զեղչ</th>
                    <th>Մեկնաբանություն</th>
                    <th>ԱԱՀ</th>
                    <th>Խանութներ</th>
                    <th style="width:150px;">Խմբագրել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					
					$query = mysqli_query($con, "SELECT * FROM client ORDER by id DESC");
					while ($array_clients = mysqli_fetch_array($query)):
					$client_id = $array_clients['id'];
					$login = $array_clients['login'];
					$name = $array_clients['law_name'];
					$address = $array_clients['law_address'];
					$hvhh = $array_clients['hvhh'];
					$aah = $array_clients['vat'];
					$telephone = $array_clients['phone'];
					$email = $array_clients['mail'];
					$summ = $array_clients['price'];
					$discount = $array_clients['discount'];
					$comment = $array_clients['comment'];
					$finance = $array_clients['finance'];
					if($aah == 'on'){
						$aah = 'Այո';
					}else{
						$aah = 'Ոչ';
					}
					
				 ?> 
				  
                  <tr>
                    <td><?php echo $client_id; ?></td>
                    <td><?php echo $login; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $address; ?></td>
                    <td><?php echo $hvhh; ?></td>
                    <td><?php echo $telephone; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $finance; ?></td>
                    <td><?php echo $discount; ?></td>
                    <td><?php echo $comment; ?></td>
                    <td><?php echo $aah; ?></td>
                    <td>
						<a  href="#" data-toggle="modal" data-target="#viewshops<?php echo $client_id; ?>" class="btn btn-warning btn-sm rounded-0" title="Դիտել խանութները"><i class="fa fa-eye"></i></a>
						
						
						
						
						
						
						
					<!-- Modal delete shops -->
					<div class="modal fade" id="viewshops<?php echo $client_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $name; ?> -ի խանութները</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">

							<table class="table table-bordered table-striped modal_table">
							  <thead>
								<tr>
									<th>Հ\Հ</th>
									<th class="word_break">QR համար</th>
									<th>Անուն</th>
									<th>Հասցե</th>
									<th style="width: auto;">Շրջան</th>

									<th>Մենեջեր</th>

								</tr>
							  </thead>
							  <tbody class="shops_area">
							  
							  <?php 
								$query_client_to_shops = mysqli_query($con, "SELECT shops.shop_id, shops.qr_id, shops.name, shops.district as shop_district, shops.address, manager_to_shop.*, client.id, manager.id, manager.login, manager.client_id FROM shops, manager_to_shop, client, manager WHERE shops.shop_id = manager_to_shop.shop_id AND manager.client_id = '$client_id' AND client.id='$client_id' AND manager_to_shop.manager_id = manager.id");
								
								while($array_client_to_shops = mysqli_fetch_array($query_client_to_shops)):
								$shop_id = $array_client_to_shops['shop_id'];
								$qr_id = $array_client_to_shops['qr_id'];
								$name_shop = $array_client_to_shops['name'];
								$address = $array_client_to_shops['address'];
								$manager_login = $array_client_to_shops['login'];
								$shop_district = $array_client_to_shops['shop_district'];

								$query_district_name = mysqli_query($con, "SELECT * FROM district WHERE id='$shop_district' ");
								$array_district_name = mysqli_fetch_array($query_district_name);
								
								$shop_district_not_name = $array_district_name['district_name'];

							  ?>
							  
							  
								<tr id="tr<?php echo $row_id; ?>">
									<td><?php echo $shop_id; ?></td>
									<td><?php echo $qr_id; ?></td>
									<td><?php echo $name_shop; ?></td>
									<td><?php echo $address; ?></td>
									<td><?php echo $shop_district_not_name ; ?></td>
									<td><?php echo $manager_login; ?></td>
								</tr>

								<?php endwhile; ?>		
							  
							  
							 
							  </tbody>
							  <tfoot>
							  <tr>
								<th>Հ\Հ</th>
								<th>QR համար</th>
								<th>Անուն</th>
								<th>Հասցե</th>
								<th style="width: auto;">Շրջան</th>

								<th>Մենեջեր</th>
								
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
                    <td style="width:150px;">
						<a href="/action_partners.php?action=edit&partner_id=<?php echo $client_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						
						<a  href="#" data-toggle="modal" data-target="#finance<?php echo $client_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել խանութները"><i class="nav-icon fas fa-money-bill-wave"></i></a>

						<a href="#" id="<?php echo $client_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
						
						
						
						<!-- Modal money client -->
					<div class="modal fade" id="finance<?php echo $client_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $name; ?> -ի գումարը</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							
						 <form id="add_finance" action="api/add_finance.php">

							<div class="form-group col-md-12">
								<label for="finance">Մուտքագրել գումար (ՀՀ դրամ)</label>
								<input type="number" class="form-control" id="finance" name="finance" placeholder="Մուտքագրել գումար" value="<?php echo $finance; ?>">
							 </div>
							 <input type="hidden" name="action" value="add_finance_client">
							 <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
							 <div class="form-group col-md-12">
								  <button type="submit" id="finance_submit" class="btn btn-primary">Պահպանել</button>
							 </div>
						  </form>
						 
						 </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
						  </div>
						</div>
					  </div>
					</div>
					
					

					</td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Հ\Հ</th>
                    <th>Մուտքանուն</th>
                    <th>Անուն</th>
                    <th>Հասցե</th>
                    <th>ՀՎՀՀ</th>
					<th>Հեռախոս</th>
					<th>E-mail</th>
                    <th>Գումար</th>
                    <th>Զեղչ</th>
                    <th>Մեկնաբանություն</th>
                    <th>ԱԱՀ</th>
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
        <b>Ջնջե՞լ գործընկերոջը</b>
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


$("#add_finance").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {
              // alert(data); 

			   window.location.reload();

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
           url: "api/add_partner.php",
           data: {partner_id:client_to_delete, action:'delete_cient'},
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
