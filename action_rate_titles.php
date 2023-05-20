<?php include 'header.php'; ?>
<?php
	include 'api/db.php';

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Խմբագրել  գնահատման ցուցանիշները</h1>
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
    				<div class="alert alert-success alert-dismissible fade show" style="display: none;" role="alert" id="success_message">
    				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				  </button>
    				</div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
    			    <form id="add_partner" action="api/edit_rates.php">
    				    <div class="form-row col-md-12 money_plan">		
    				        <?php
    				            $rows="";
    				            $sql="SELECT * FROM rates";
    				            $result= mysqli_query($con, $sql);
    				            while($row = mysqli_fetch_array($result)):
    				                extract($row);
    				                if($active == 1):
    				                    $isChecked='checked ';
				                    else:
				                        $isChecked='';
			                        endif;
    				                $rows .="<div class='form-group col-md-4 label_discount'>
                        						<label for='hy_$id'>Հայերեն</label>
                        						<input type='text' class='form-control' id='hy_$id' name='hy_$id'  value='$title_hy'>
                    						</div>						
                    						<div class='form-group col-md-4 label_discount'>
                        						<label for='en_$id'>Անգլերեն</label>
                        						<input type='text' class='form-control' id='en_$id' name='en_$id' value='$title_en'>
                    						</div>						
                    						<div class='form-group col-md-3 label_discount'>
                        						<label for='ru_$id'>Ռուսերեն</label>
                        						<input type='text' class='form-control' id='ru_$id' name='ru_$id' value='$title_ru'>
                    						</div>
                    						<div class='form-group col-md-1 label_discount text-center'>
                        						<label for='active_$id'>Ակտիվ</label>
                        						<input type='checkbox' class='form-control' id='active_$id' name='active_$id' value='$active' $isChecked>
                    						</div>
                    						";
				                endwhile;
				                echo $rows;
    						?>
    				    </div>
            			<button type="submit" class="btn btn-primary">Թարմացնել</button>
    			    </form>
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
  
    
   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary modal_answere" data-toggle="modal" data-target="#modal_answere" style="display:none;">
</button>

<!-- Modal -->
<div class="modal fade" id="modal_answere" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p class="success_message"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <a href="/dashboard.php" class="btn btn-primary">Գլխավոր էջ</a>
        <a href="/action_managers.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
      </div>
    </div>
  </div>
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


<script>

$( "#user_role").change(function() {
	  var user_role = $('#user_role').val();
	  if(user_role !='1'){
			$('.client_select').css("display", "none"); 
			$('.label_audit').css("display", "none"); 
			$('.label_discount').css("display", "none"); 
			$('.money_plan').css("display", "none"); 
	  }else{
			$('.client_select').css("display", "block"); 
			$('.label_audit').css("display", "block"); 
			$('.label_discount').css("display", "block"); 
			$('.money_plan').css("display", "flex"); 

	  }

});




$("#add_partner").submit(function(e) {
    e.preventDefault(); 
    var form = $(this);
    var url = form.attr('action');
    const data = form.serialize()
    $.ajax({
           type: "POST",
           url: url,
           data: data, 
           success: function(data)
           {
			   window.location.replace("/statistics.php");
           }
		   
         });
});
   
</script>
</body>
</html>
