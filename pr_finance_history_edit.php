<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$transaction_id = mysqli_real_escape_string($con, $_GET['transaction_id']);





					
?>




<style type="text/css">
.dt-buttons {
	float: right;
    margin-top: 15px;
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Մուտք N <?php echo $transaction_id; ?></h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="#" onclick="history.go(-1)" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
			  
				 <form action="/pr_finance_history.php" id="statistics_form" style="display: none;"> 
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
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
				  
					<div class="form-group col-md-2" style="display: none;">
								<label for="login">Խանութ</label>
								<select name="warehouse_id" id="warehouse_id" class="form-control mdb-select md-form"">
								<option value="0"> Ընտրել </option>
									<?php 
										$query_shops = mysqli_query($con, "SELECT * FROM shops ORDER by id DESC");
										while ($array_shop = mysqli_fetch_array($query_shops)):
										$shop_id = $array_shop['shop_id'];
										$shop_name = $array_shop['name'];
									?> 
									 
									<option value="<?php echo $shop_id; ?>"  <?php if($curr_warehouse_id == $shop_id ) {echo "selected"; } ?> > <?php echo $shop_name; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>

		
				 
					  <div class="form-group col-md-2" style="display: none;">
								<label for="login">Մենեջեր</label>
								<select name="manager_select" id="manager_select" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 
										if($_SESSION['role'] == '1' ){
											$session_client_id = $_SESSION['user_id'];
											$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE client_id = '$session_client_id' ORDER by id DESC");

										}else{
											$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE client_id = '$curr_client_id' ORDER by id DESC");
										}
										while ($array_manager = mysqli_fetch_array($query_manager)):
										$manager_id = $array_manager['id'];
										$manager_login = $array_manager['login'];
									?> 
									 
									<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
									
									<?php endwhile; ?>
									
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
				  
                    <th>Հ/Հ</th>
                    <th>Պատվերի Հ/Հ</th>
					<th>Խանութ</th>
					<th>Հասցե</th>
                    <th>Աշխատակից</th>
                    <th>Գումար</th>
                    <th>Կարգավիճակ (գործավար)</th>
                    <th style="width:150px;">Գործողություն</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
				  
					$query_shops_documents = mysqli_query($con, "SELECT *, pr_orders_finance.id AS current_payed_id, manager.name as user_name, shops.name AS shop_name FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id LEFT JOIN pr_payment_type ON pr_orders_finance.pay_type = pr_payment_type.id LEFT JOIN manager ON pr_orders_finance.user_id = manager.id WHERE transaction_id = '$transaction_id' ");

					//echo $query;
					
					while($shops_array = mysqli_fetch_array($query_shops_documents)):
					$dataid = $shops_array['current_payed_id'];
					$shop_id = $shops_array['shop_id'];
					$qr_id = $shops_array['qr_id'];
					$curr_shop_name = $shops_array['shop_name'];
					$address = $shops_array['address'];
					$order_summ = $shops_array['order_summ'];
					$document_id = $shops_array['payed_document_id'];
					$user_name = $shops_array['user_name'];
					$current_payed_id = $shops_array['current_payed_id'];

					
				  ?>
				  
				  <tr> 
					<td class="shop_id_<?php echo $document_id; ?>"><?php echo $shop_id; ?></td>
					<td><input type="text" value="<?php echo $document_id; ?>" class="form-control payed_doc_id" style="width: 150px;" id="<?php echo $dataid; ?>"> </td>
					<td><?php echo $curr_shop_name; ?></td>
					<td><?php echo $address; ?></td>
					<td><?php echo $user_name; ?></td>
					<td class="summ_<?php echo $document_id; ?>"><?php echo $order_summ; ?></td>
					<td><input type="checkbox" class="form-control order_full_payed" id="<?php echo $document_id; ?>" <?php if($shops_array['payed_document_status'] == '3') {echo "checked"; } ?>></td>
					<td>
						<button href="#" id="<?php echo $document_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal<?php echo $document_id; ?>"  title="Ջնջել" <?php if($shops_array['payed_document_status'] == '3' or $shops_array['payed_document_status'] == '2') {echo "disabled"; } ?>><i class="fa fa-trash"></i></button>
						
					
						<!-- Modal -->
						<div class="modal fade" id="deletemodal<?php echo $document_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						  <div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle"></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<b>Ջնջե՞լ մուտքը</b>
							   <input type="hidden" value="" name="client_to_delete" id="client_to_delete">

							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
								<button type="button" class="btn btn-danger click_delete" id="<?php echo $current_payed_id; ?>">Այո</button>
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
				  
                    <th>Հ/Հ</th>
                    <th>Պատվերի Հ/Հ</th>
					<th>Խանութ</th>
					<th>Հասցե</th>
                    <th>Աշխատակից</th>
                    <th>Գումար</th>
                    <th>Կարգավիճակ (գործավար)</th>
                    <th style="width:150px;">Գործողություն</th>


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

<!-- Export -->

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>



<script>

$(document).on('change','.payed_doc_id', function(){
	var data_id = this.id;
	var data_val = $(this).val();
	
	var url = '/api/add_pr_finance.php';

 $.ajax({
           type: "POST",
           url: url,
           data: {
				data_id: data_id,
				data_val: data_val,
				action: "change_payment_document_id"
		   }, 
		   
		   error: function(){
			   $('.order_false').css("display", "block"); 
			    return false;
			},
           success: function(data)

           {
				 window.location.reload();
           },
		   timeout: 10000
		   
         });
	
});


$(document).ready(function(){
        $('.order_full_payed').click(function(){
            if($(this).is(":checked")){
                var status = '3';
            }
            else if($(this).is(":not(:checked)")){
                var status = '1';
            }
			
			var document_id = $(this).attr('id');

			var order_summ = $('.summ_' + document_id).text();
			var shop_id = $('.shop_id_' + document_id).text();
			
			$.ajax({
				type: "POST",
				url: "api/add_pr_finance.php",
				data: {document_id:document_id, action:'order_full_payed', status: status, order_summ: order_summ, shop_id: shop_id},
				success: function(data)
				{
				   //alert(data); 
				   window.location.reload();
				}
			   
			});
        });
    });



 

//#statistics_form
	
	$(".click_delete").click(function() {

	var document_id = $(this).attr('id');
	
    $.ajax({
           type: "POST",
           url: "api/add_pr_finance.php",
           data: {document_id:document_id, action:'delete_transaction'},
           success: function(data)
           {
               //alert(data); 
			   window.location.reload();
           }
		   
         });
});
	
	

  $(function () {
    $("#example1").DataTable({
		
    
		
		        dom: 'Bfrtip',
	    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
  
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
