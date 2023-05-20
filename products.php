<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ապրաքների անվանացանկ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/action_products.php?action=add" class="btn btn-primary">Ավելացնել նորը</a>
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
                    <th class="select-filter" style="width: 200px;">Խումբ</th>
					<th class="select-filter" style="vertical-align: middle;">Հերթական N</th>
					<th class="word_break_header select-filter"  style="vertical-align: middle;">Անավանում</th>
                    <th class="select-filter" style="vertical-align: middle;">Կոդ</th>
					<th class="select-filter" style="vertical-align: middle;">Export կոդ</th>
					<th class="select-filter" style="vertical-align: middle;">Վաճառքի գին</th>
					<th class="select-filter" style="vertical-align: middle;">Մինիմալ մնացորդ</th>
					<th class="select-filter" style="vertical-align: middle;">Ակտիվ</th>
					<th class="" style="vertical-align: middle;">Նկար</th>
					<th class="" style="vertical-align: middle;">Գործողություններ</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query = mysqli_query($con, "SELECT * FROM pr_products ORDER by id DESC");
					while ($array_products = mysqli_fetch_array($query)):
					$product_id = $array_products['id'];
					$product_group = $array_products['product_group'];
					$name = $array_products['name'];
					$sale_price = $array_products['sale_price'];
					$last_price = $array_products['last_price'];
					$middle_price = $array_products['middle_price'];
					$balance = $array_products['balance'];
					$code = $array_products['code'];
					$id2 = $array_products['id2'];
					$regular_n = $array_products['regular_n'];
					$active = $array_products['active'];
					
					if($active == 'on'){
						$active = 'Այո';
					}else{
						$active = 'Ոչ';
					}
					
					$query_region = mysqli_query($con, "SELECT * from region WHERE id='$region' ");
					$array_region = mysqli_fetch_array($query_region);
					
					$query_district = mysqli_query($con, "SELECT * from district WHERE id='$district' ");
					$array_district = mysqli_fetch_array($query_district);
					
				 ?> 
				  
                  <tr>
				  
				 <td class="word_break">
				 
				 <?php
					$product_group_query = mysqli_query($con, "SELECT * FROM pr_groups WHERE id = $product_group" );
					while($product_group_array = mysqli_fetch_array($product_group_query)) {
						echo $product_group_array['group_name'];
					}
				 ?>				 
				 
				 </td>
				 <td><?php echo $regular_n; ?></td>
				 <td><?php echo $name; ?></td>
				 <td><?php echo $code; ?></td>
				 <td><?php echo $id2; ?></td>
				 <td><?php echo $sale_price; ?></td>
				 <td><?php echo $balance; ?></td>
				 <td><?php echo $active; ?></td>
				 <td></td>

                 <td style="width:170px;">
				 
				
												
						<a href="#" id="<?php echo $product_id; ?>" class="btn btn-primary btn-sm rounded-0 add_barcode_button" data-toggle="modal" data-target="#barcode_modal_<?php echo $product_id; ?>"  title="Շտրիխ կոդ"><i class="fa fa-barcode"></i></a>

						<a href="/action_products.php?action=edit&product_id=<?php echo $product_id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						
						<a href="#" id="<?php echo $product_id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
						
							<!-- Modal for barcodes-->
					<div class="modal fade" id="barcode_modal_<?php echo $product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Ապրանքի շտրիխ կոդեր</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
						  
						  <form id="form<?php echo $product_id?>" name="form_for_<?php echo $product_id?>" action="api/add_pr_barcode.php">
								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="barcode_text">Շտրիխ կոդ</label>
										<input type="text" class="form-control" id="barcode_text<?php echo $product_id?>" name="barcode_text" value=""  placeholder="">
									  </div>

									  <div class="form-group col-md-3">
										<label for="barcode_count">Քանակ</label>
										<input type="text" class="form-control" id="barcode_count<?php echo $product_id?>" name="barcode_count" placeholder="" value="">
									  </div>
									  
									  <input type="hidden" id="barcode_product_id" name="barcode_product_id" value="<?php echo $product_id; ?>">
									  <div class="form-group col-md-3">
										<label for="last_price">Ավելացնել</label>

										<button type="submit" class="btn btn-primary form_submit_button" id="<?php echo $product_id?>">Ավելացնել</button>
									  </div>
								  </div>
						   </form>
							
						  
						   <table id="" class="table table-bordered table-striped">
							  <thead>
							  <tr>
								<th class="word_break_header">Շտրիխ կոդ</th>
								<th class="word_break_header">Ապրանքի քանակ</th>
								<th class="word_break_header">Ջնջել</th>
							  </tr>
							  </thead>
						  <tbody class="barccode_table_<?php echo $product_id; ?>">
						  <?php

								$query_select_barcodes = mysqli_query($con, "SELECT * FROM pr_barcodes WHERE  product_id= '$product_id' ");
								while ($array_barcodes = mysqli_fetch_array($query_select_barcodes)):
							?>
								<tr class="<?php echo $array_barcodes['barcode']; ?>">
									<td><?php echo $array_barcodes['barcode']; ?></td>
									<td><?php echo $array_barcodes['product_count']; ?></td>
									<td> 
									
									<button id="<?php echo $array_barcodes['barcode']; ?>" class="btn btn-danger btn-sm rounded-0 delete_barcode" title="Ջնջել"><i class="fa fa-trash"></i></button>
									
									</td>
									
								</tr>
							<?php endwhile; ?>
						  </tbody>
						  
						  <tfoot>
						   <tr>
								<th class="word_break_header">Շտրիխ կոդ</th>
								<th class="word_break_header">Ապրանքի քանակ</th>
								<th class="word_break_header">Ջնջել</th>
							  </tr>
						  </tfoot>
						  
						  
						 </table>
						   <input type="hidden" value="" name="product_to_barcode" id="product_to_barcode">

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
                    <th class="select-filter"></th>
                    <th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
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
        <b>Ջնջե՞լ Ապրաքը</b>
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
	
	
	
	$(document).on('click','.delete_barcode', function() {
		
		var barcode_id = $(this).attr("id");
		
		$.ajax({
		type: "POST",
		url: '/api/add_pr_barcode.php',
		data: {"barcode": barcode_id, "action": 'delete_barcode'},    
		success: function(data)
		{
			$('.'+barcode_id).remove();
		}

		});

	
	});
	
	
	$(".form_submit_button").click(function(){
		
		
		var form_id = $(this).attr("id");
		
		//alert(form_id);
		
		$("#form"+form_id).submit(function(e) {

		e.preventDefault(); 
		
		//alert('mtav');

		var form = $(this);
		var url = form.attr('action');
		var barcode_text = $('#barcode_text'+form_id).val();
		var barcode_count = $('#barcode_count'+form_id).val();
		var product_id = $('#barcode_product_id'+form_id).val();
		
		if (barcode_text == ''){
			$('#barcode_text'+form_id).addClass('border border-danger');
			return false;
		}
		
		if (barcode_count == ''){
			$('#barcode_count'+form_id).addClass('border border-danger');
			return false;
		}
		
		$.ajax({
			   type: "POST",
			   url: url,
			   data: form.serialize(), 
			   success: function(data)
			   {
				  // alert(data); 
				   $('#barcode_text'+form_id).removeClass('border border-danger');
				   $('#barcode_count'+form_id).removeClass('border border-danger');
				   $( ".barccode_table_"+form_id ).append(data);
				   return false;
			   }
			   
			 });
			 
			  reset();
	});	
		e.stopImmediatePropagation()

		debugger;

	});
	
	
	
		
	
	
	$("#click_delete").click(function() {

	var client_to_delete = $('#client_to_delete').val();
	
    $.ajax({
           type: "POST",
           url: "api/add_product.php",
           data: {product_id:client_to_delete, action:'delete_product'},
           success: function(data)
           {
               //alert(data); 
			 window.location.reload();
           }
		   
         });
});
	
	

  $(function () {
    var table = $("#example1").DataTable({

	 
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
    
		
		        dom: 'Bfrtip',
						"paging": false,

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
