<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ֆինանսական շարժ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
		  <a href="/dashboard.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
			<a href="/action_partners.php?action=add" class="btn btn-primary" style="display: none;">Ավելացնել նորը</a>
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
                    <th>Գումար</th>
					<th>Մնացորդ</th>

                    <th style="width:150px;">Շարժ</th>
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
                    <td><?php echo $finance; ?></td>
                    <td>
					
					<?php 
						$query_balance = mysqli_query($con, "SELECT SUM(summ) total FROM finance WHERE client_id = '$client_id' ");
						$array_balance_client = mysqli_fetch_array($query_balance);
						echo ($finance - $array_balance_client['total']);
					?>
					
					</td>
                    <td>
					
					
					
					
					
					
						<a  href="#" data-toggle="modal" data-target="#viewshops<?php echo $client_id; ?>" class="btn btn-warning btn-sm rounded-0" title="Դիտել խանութները"><i class="fa fa-eye"></i></a>
							
					<!-- Modal view finance -->
					<div class="modal fade" id="viewshops<?php echo $client_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $name; ?> -ի մուտքերը</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">

							<table class="table table-bordered table-striped">
							  <thead>
								<tr>
									<th>Հ\Հ</th>
									<th>Գործընկերներ</th>									
									<th>Գումար</th>
									<th>Ամսաթիվ</th>
									<th>Մեկնաբանություն</th>
									<th>Խմբագրել</th>

								</tr>
							  </thead>
							  <tbody class="shops_area">
							  
							  <?php 
								$query_client_finance = mysqli_query($con, "SELECT * FROM finance WHERE client_id = '$client_id' ");
								
								while($array_client_finance = mysqli_fetch_array($query_client_finance)):
								$id = $array_client_finance['id'];
								$add_date = $array_client_finance['add_date'];
								$comment = $array_client_finance['comment'];
								$summ = $array_client_finance['summ'];
							  ?>
							  
							  
								<tr id="tr_delete<?php echo $id; ?>">
									<td><?php echo $id; ?></td>
									<td><?php echo $name; ?></td>
									<td><?php echo $summ; ?></td>
									<td><?php echo $add_date; ?></td>
									<td><?php echo $comment; ?></td>
									<td>
										<a  href="#" data-toggle="modal" data-target="#edit<?php echo $id; ?>"  class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
										<a  href="#" data-toggle="modal" data-target="#delete_modal" id="<?php echo $id; ?>"  class="btn btn-danger btn-sm rounded-0 delete_finance_button" title="Ջնջել"><i class="fa fa-trash"></i></a>
										
										
										
										
										
										
												
						<!-- Modal edit money -->
					<div class="modal fade" id="edit<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $name; ?> -ի գումարը</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							
							<?php
							
							$query_client_finance_one = mysqli_query($con, "SELECT * FROM finance WHERE id= '$id' ");
							$array_finance_one = mysqli_fetch_array($query_client_finance_one);
								$one_summ = $array_finance_one['summ'];
								$one_add_date = $array_finance_one['add_date'];
								$one_comment = $array_finance_one['comment'];
							
							?>
							

							
						 <form id="edit_finance_one" action="api/add_finance.php">

							<div class="form-group col-md-12">
								<label for="finance">Մուտքագրել գումար (ՀՀ դրամ)</label>
								<input type="number" class="form-control" id="finance" name="finance" placeholder="Մուտքագրել գումար" value="<?php echo $one_summ; ?>">
							 </div>

							<div class="form-group col-md-12">
								<label for="comment">Մեկնաբանություն</label>
								<input type="text" class="form-control" id="comment" name="comment" placeholder="Մեկնաբանություն" value="<?php echo $one_comment; ?>" >
							</div>
							
							<div class="form-group col-md-12">
								<label for="add_date">Ամսաթիվ</label>
								<input type="date" class="form-control" id="add_date" name="add_date" placeholder="Ամսաթիվ" value="<?php echo $one_add_date; ?>" >
							</div>
							 
							 <input type="hidden" name="action" value="edit_finance_one">
							 <input type="hidden" name="finance_id" value="<?php echo $id; ?>">
							 
							 <div class="form-group col-md-12">
								  <button type="submit" id="finance_submit" class="btn btn-primary">Թարմացնել</button>
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
								<th></th>
								<th>Ընդհանուր՝ </th>
								<th><?php

										$query_balance = mysqli_query($con, "SELECT SUM(summ) total FROM finance WHERE client_id = '$client_id' ");
										$array_balance_client = mysqli_fetch_array($query_balance);
										echo $array_balance_client['total'];

									?></th>
								<th></th>
								<th></th>
								<th></th>
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
						
						
						
				
						<a href="/action_partners.php?action=edit&partner_id=<?php echo $client_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել" style="display:none;"><i class="fa fa-edit"></i></a>
						
						
						
						
						
						
						
						<a  href="#" data-toggle="modal" data-target="#finance<?php echo $client_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել խանութները"><i class="nav-icon fas fa-plus"></i></a>
						
						
						
						
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
								<input type="number" class="form-control" id="finance" name="finance" placeholder="Մուտքագրել գումար" >
							 </div>

							<div class="form-group col-md-12">
								<label for="comment">Մեկնաբանություն</label>
								<input type="text" class="form-control" id="comment" name="comment" placeholder="Մեկնաբանություն">
							</div>
							
							<div class="form-group col-md-12">
								<label for="add_date">Ամսաթիվ</label>
								<input type="date" class="form-control" id="add_date" name="add_date" placeholder="Ամսաթիվ">
							</div>
							 
							 <input type="hidden" name="action" value="add_finance_month_client">
							 <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
							 
							 <div class="form-group col-md-12">
								  <button type="submit" id="finance_submit" class="btn btn-primary">Ավելացնել</button>
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
                    <th>Գումար</th>
                    <th>Մնացորդ</th>
					<th style="width:150px;">Շարժ</th>

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
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
	
	<form action="/api/add_finance.php" method="GET">
	
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <b>Ջնջե՞լ գործընկերոջը</b>
	   <input type="hidden" value="" name="finance_id" id="finance_id">
	   <input type="hidden" name="action" value="finance_delete">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="submit" class="btn btn-danger" id="click_delete">Այո</button>
      </div>
	  
	  </form>
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
              //alert(data); 

			   window.location.reload();

           }
		   
         });
});



	jQuery(".delete_finance_button").click(function() {
		var contentPanelId = jQuery(this).attr("id");
		$('#finance_id').val(contentPanelId);
	});
	
	
		

  $(function () {
    $("#example1").DataTable({
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
