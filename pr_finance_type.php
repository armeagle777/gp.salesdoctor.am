<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ծախսերի նպատակներ</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/action_pr_finance_type.php?action=add" class="btn btn-primary">Ավելացնել նորը</a>
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
                    <th>Նպատակ</th>
                    <th style="width:150px;">Խմբագրել</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query="SELECT 
                        T.id,
                        D.id AS DIRECTION_ID,
                        D.name AS DIRECTION_NAME,
                        M.name AS MANAGER_NAME,
                        S.name AS SHOP_NAME,
                        S.address AS SHOP_ADDRESS,
                        SP.supplier_name,
                        T.text,
                        T.active
                    FROM 
                    	pr_finance_type T
                        LEFT JOIN pr_expense_directions D ON D.id=T.direction_id
                        LEFT JOIN shops S ON S.id=T.shop_id
                        LEFT JOIN manager M ON M.id = T.employee_id
                    	LEFT JOIN pr_supplier SP ON SP.id = T.provider_id
                    ORDER by 
                    	T.id DESC";
					$result = mysqli_query($con, $query);
					while ($array_finance_type = mysqli_fetch_array($result)):
					    extract($array_finance_type);
					    $is_active = $active == 0 ? " " : " checked";
					    $row_value = '';
					    if($DIRECTION_ID == 1){
					        $row_value = $DIRECTION_NAME." ".$MANAGER_NAME;
					    }else if($DIRECTION_ID == 2){
					        $row_value = $DIRECTION_NAME." ".$supplier_name;
					    }else if($DIRECTION_ID == 3){
					        $row_value = $DIRECTION_NAME." ".$SHOP_NAME." ($SHOP_ADDRESS)";
					    }else{
					        $row_value = $DIRECTION_NAME." ".$text;
					    }
				 ?> 
				  
                  <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $row_value; ?></td>
                    <td style="width:150px;">
						<a href="/action_pr_finance_type.php?action=edit&finance_type_id=<?php echo $id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
						<!--<a href="#" id="<?php echo $id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>-->
						<input type="checkbox" finance-type-id="<?php echo $id ; ?>"  <?php echo $is_active ; ?>  data-toggle="toggle" data-onstyle="outline-primary" data-offstyle="outline-danger" data-size="sm" class="switch-active">
					</td>
                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                      <tr>
    					<th>Հ\Հ</th>
                        <th>Նպատակ</th>
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

<!-- toggle button script   -->
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<!-- Modal -->
<!--<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">-->
<!--  <div class="modal-dialog modal-dialog-centered" role="document">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <h5 class="modal-title" id="exampleModalLongTitle"></h5>-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--          <span aria-hidden="true">&times;</span>-->
<!--        </button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        <b>Ջնջե՞լ նպատակը</b>-->
<!--	    <input type="hidden" value="" name="client_to_delete" id="client_to_delete">-->
<!--      </div>-->
<!--      <div class="modal-footer">-->
<!--        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>-->
<!--        <button type="button" class="btn btn-danger" id="click_delete">Այո</button>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->


<script>

// 	jQuery(".delete_client_button").click(function() {
// 		var contentPanelId = jQuery(this).attr("id");
// 		$('#client_to_delete').val(contentPanelId);
// 	});
	
	$(function() {
        $('.switch-active').change(function() {
            let financeTypeId = $(this).attr('finance-type-id')
            let activeValue = $(this).prop('checked') ? 1 : 0
            
            $.ajax({
               type: "POST",
               url: "api/add_pr_finance_type.php",
               data: {finance_type_id:financeTypeId,activeValue, action:'delete_cient'},
               success: function(data)
               {
                   //alert(data); 
        		  // window.location.reload();
               }
    		   
            });
        })
    })
	
// 	$("#click_delete").click(function() {

	
	
//     $.ajax({
//       type: "POST",
//       url: "api/add_pr_finance_type.php",
//       data: {finance_type_id:client_to_delete, action:'delete_cient'},
//       success: function(data)
//       {
//           //alert(data); 
// 		   window.location.reload();
//       }
		   
//     });
// });
	
	

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
