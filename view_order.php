<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

$document_id = mysqli_real_escape_string($con, $_GET['document_id']);


$document_details_query = mysqli_query($con, "SELECT *, shops.discount AS shop_discount, shops.name AS shop_name, manager.name AS manager_name FROM pr_orders_document LEFT JOIN shops on pr_orders_document.shop_id = shops.shop_id LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id LEFT JOIN manager ON pr_orders_document.manager_id = manager.id LEFT JOIN district ON shops.district = district.id WHERE document_id = '$document_id'");

$document_details = mysqli_fetch_array($document_details_query);

//warehouse for exit from warehouse
$warehouse_id = $document_details['warehouse_id'];


	
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Պատվերի մանրամասն</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="#" onclick="window.print()" class="btn btn-success" style="margin-right: 20px;"><i class="fa fa-print"></i></a>
			<button onclick="history.go(-2)" class="btn btn-info"><i class="fa fa-window-close"></i></button>
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
              <div class="card-header" style="text-align: center;">
			  Պատվեր <b>No <?php echo $document_id; ?> <br> <?php $today = date("d.m.y");  echo $today; ?></b>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

			  <table class="table table-borderless">
			  
				  <tbody>
				  
					  <tr>
						<td style="width: 160px;">Վճարման տիպ՝</td>
						<td><b><?php echo $document_details['payment_name']; ?></b></td>
						<td>Զեղչ՝</td>
						<td><b><?php echo $document_details['shop_discount']; ?></b></td>
					  </tr>
				  
					  <tr>
						<td>Գնորդ՝</td>
						<td><b><?php echo $document_details['shop_name']; ?></b></td>
						<td>ՀՎՀՀ՝</td>
						<td><b><?php echo $document_details['hvhh']; ?></b></td>
					  </tr>
				  
					  <tr>
						<td>Մենեջեր՝</td>
						<td><b><?php echo $document_details['manager_name']; ?></b></td>
						<td>Տարածք՝</td>
						<td><b><?php echo $document_details['district_name']; ?></b></td>
					  </tr>
				  
					  <tr>
						<td>Առաքիչ՝</td>
						<td><b><?php
						$courier_id = $document_details['courier_id'];
						$array_courier = mysqli_fetch_array(mysqli_query($con, "SELECT name FROM manager WHERE id='$courier_id' "));
						echo $array_courier['name'];						
						
						?></b></td>
						<td>Հասցե՝</td>
						<td><b><?php echo $document_details['address']; ?></b></td>
					  </tr>
					  
				  </tbody>
				  
			  
			  </table>
			  
			  
                <table id="example_0" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
                    <th>Հ\Հ</th>
                    <th>Խումբ</th>
					<th>Անվանում</th>
                    <th>Զեղչ</th>
					<th>Քանակ</th>
					<th>Գին</th>
					<th>Ընդհամենը</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
				 
					$i = 0;
					$cont_total = 0;
					$price_total = 0;
					$query = mysqli_query($con, "SELECT * FROM pr_orders WHERE document_id = '$document_id' ORDER by id DESC");
					while($document_array = mysqli_fetch_array($query)):
					
					$shop_id = $document_array['shop_id'];
					$manager_id = $document_array['manager_id'];
					$product_id = $document_array['product_id'];
					$product_count = $document_array['product_count_warehouse'];
					
					if($product_count != '0'):
					$i = $i +1;
					$query_products = mysqli_query($con, "SELECT * FROM `pr_products` LEFT JOIN pr_groups on pr_products.product_group = pr_groups.id where pr_products.id = $product_id");
					
					$products_array = mysqli_fetch_array($query_products);
					
					$total_row = $product_count * $document_array['product_last_cost'] ;
					
				 ?> 
				  
					<tr>
				  
						<td><?php echo $i; ?></td>
						<td><?php echo $products_array['group_name'] ?></td>
						<td><?php echo $products_array['name'] ?></td>
						<td><?php echo $document_array['product_procent'] ?></td>
						<td><?php echo $product_count; ?></td>
						<td><?php echo $document_array['product_last_cost']; ?></td>
						<td><?php echo $total_row; ?></td>
			
						<?php 
						$cont_total = $cont_total + $product_count;
						$price_total = $price_total + $total_row;
						?>
					</tr>
                 <?php endif; ?>
				 <?php endwhile; ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
					<th></th>
                    <th></th>
					<th><?php echo $cont_total; ?></th>
					<th></th>
					<th><?php echo $price_total; ?></th>

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
<!-- jQuery -->
<script src="/dist/js/jquery.tableTotal.js"></script>



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
