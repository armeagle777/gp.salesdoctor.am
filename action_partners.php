<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$partner_id =  mysqli_real_escape_string($con, $_GET['partner_id']);
	if($action == 'edit'){
		
		$query_data_partners = mysqli_query($con, "SELECT * FROM client WHERE id=$partner_id");
		$array_partners = mysqli_fetch_array($query_data_partners);
		
		$login = $array_partners['login'];
		$name = $array_partners['law_name'];
		$address = $array_partners['law_address'];
		$hvhh = $array_partners['hvhh'];
		$aah = $array_partners['vat'];
		$telephone = $array_partners['phone'];
		$email = $array_partners['mail'];
		$summ = $array_partners['price'];
		$discount = $array_partners['discount'];
		$comment = $array_partners['comment'];
		
	}
	
?>
<style type="text/css">
.aah {
	clear: both;
    display: block;
    height: 33px;
    width: 34px;
} 
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
			<?php 
			if($action == 'add'){
				echo "Ավելացնել գործընկեր";
			}elseif($action == 'edit'){
				echo "Խմբագրել գործընկերոջը";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/partners.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="api/add_partner.php">
				<div class="form-row">
					  <div class="form-group col-md-6">
						<label for="login">Մուտքանուն</label>
						<input type="text" class="form-control" id="login" name="login" placeholder="Մուտքանուն" value="<?php echo $login; ?>">
					  </div>
					  <div class="form-group col-md-6">
						<label for="password">Գաղտնաբառ</label>
						<input type="password" class="form-control" id="password" name="password" value=""  placeholder="Գաղտնաբառ">
					  </div>
			  </div>
			  
			 <div class="form-row">
					  <div class="form-group col-md-12">
						<label for="name">Անուն</label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>"  placeholder="Անուն">
					  </div>
			  </div>
			  
			  <div class="form-row">
					  <div class="form-group col-md-6">
						<label for="address">Հասցե</label>
						<input type="text" class="form-control" id="address" name="address"  value="<?php echo $address; ?>"  placeholder="Հասցե">
					  </div>
					  <div class="form-group col-md-6">
						<label for="hvhh">ՀՎՀՀ</label>
						<input type="text" class="form-control" id="hvhh" name="hvhh" value="<?php echo $hvhh; ?>"  placeholder="ՀՎՀՀ">
					  </div>
			  </div>
			  <div class="form-row">

					  <div class="form-group col-md-6">
						<label for="telephone">Հեռախոս</label>
						<input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $telephone; ?>"   placeholder="Հեռախոս">
					  </div>
					  <div class="form-group col-md-6">
						<label for="email">E-mail</label>
						<input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>"  placeholder="E-mail">
					  </div>
				  
				</div>
				<div class="form-row">
				
					  <div class="form-group col-md-6">
						<label for="summ">Գումար</label>
						<input type="text" class="form-control" id="summ" name="summ" value="<?php echo $summ; ?>"  placeholder="Գումար">
					  </div>
					  <div class="form-group col-md-5">
						<label for="discount">Զեղչ</label>
						<input type="text" class="form-control" id="discount" name="discount" value="<?php echo $discount; ?>"  placeholder="Զեղչ">
					  </div>
					  <div class="form-group col-md-1">
						<label for="aah">ԱԱՀ</label>
						<input type="checkbox" class="aah" id="aah" name="aah" <?php if($aah=='on'){echo "checked";} ?>>
					  </div>
					  
			  </div>
			  <div class="form-group">
				<label for="comment">Մեկնաբանություն</label>
				<textarea class="form-control" id="comment"  placeholder="Մեկնաբանություն" name="comment" rows="3"><?php echo $comment; ?></textarea>
			  </div>

			<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
			
			<input type="hidden" name="partner_id" id="partner_id" value="<?php echo $_GET['partner_id']; ?>">
			
			<?php 
			if($action == 'add'):
			?>
			  <button type="submit" class="btn btn-primary">Ավելացնել</button>
			<?php else: ?> 
			
			  <button type="submit" class="btn btn-primary">Թարմացնել</button>

			<?php endif; ?>
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
        <a href="/action_partners.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
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

$("#add_partner").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');
	var name = $('#name').val();
	if (name == ''){
		$('#name').addClass('border border-danger');
		return false;
	}
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {
              // alert(data); 
			   $('#name').removeClass('border border-danger');
			   $('.success_message').text(data);
			 //  $('.alert').show()
			  // $('.modal_answere').click();
			   window.location.replace("/partners.php");


           }
		   
         });
});
   
</script>
</body>
</html>
