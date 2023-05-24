<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$manager_id =  mysqli_real_escape_string($con, $_GET['manager_id']);
	if($action == 'edit'){
		
		$query_data_manager = mysqli_query($con, "SELECT * FROM manager WHERE id='$manager_id'");
		$array_managers = mysqli_fetch_array($query_data_manager);
		

		$client_id_edit = $array_managers['client_id'];
		$login = $array_managers['login'];
		$email = $array_managers['email'];
		$phone = $array_managers['phone'];
		$name = $array_managers['name'];
		$audit = $array_managers['audit_active'];
		$active = $array_managers['active'];
		$discount = $array_managers['discount'];
		$user_role = $array_managers['user_role'];
		$has_order = $array_managers['has_order'];
		$plan_visit = $array_managers['plan_visit'];
		$plan_audit = $array_managers['plan_audit'];
		$plan_task = $array_managers['plan_task'];
		$plan_order_summ = $array_managers['plan_order_summ'];
		$plan_shop_count = $array_managers['plan_shop_count'];
		$plan_shop_summ = $array_managers['plan_shop_summ'];
		
		$canRecord = $array_managers['canRecord'];
		$hasMic = $array_managers['hasMic'];
		$canRate = $array_managers['canRate'];
		
		
		$plan_visit_money = $array_managers['plan_visit_money'];
		$plan_audit_money = $array_managers['plan_audit_money'];
		$plan_task_money = $array_managers['plan_task_money'];
		$plan_order_summ_money = $array_managers['plan_order_summ_money'];
		$plan_shop_count_money = $array_managers['plan_shop_count_money'];
		$plan_shop_summ_money = $array_managers['plan_shop_summ_money'];

		
		$plan_comment = $array_managers['plan_comment'];
		
		
		$manager_comment = $array_managers['manager_comment'];
		$passport_details = $array_managers['passport_details'];
		$passport_address = $array_managers['passport_address'];
		$real_address = $array_managers['real_address'];
		
		
		$manager_origin_latitude = $array_managers['manager_origin_latitude'];
		$manager_origin_longitude = $array_managers['manager_origin_longitude'];
		$manager_destination_latitude = $array_managers['manager_destination_latitude'];
		$manager_destination_longitude = $array_managers['manager_destination_longitude'];

		$charge_cost = $array_managers['charge_cost'];
		$charge_km = $array_managers['charge_km'];
		
	}
	
?>

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
				echo "Ավելացնել աշխատակից";
			}elseif($action == 'edit'){
				echo "Խմբագրել աշխատակցին";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/managers.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>

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
               
			   
			<form id="add_partner" action="api/add_manager.php">
			
					  <div class="form-group col-md-12">
						<label for="user_role">Աշխատակցի տեսակը</label>
						<select name="user_role" id="user_role" class="form-control">
						<option value="0"> Ընտրել </option>
						
							<?php 
								$query_role = mysqli_query($con, "SELECT * FROM user_roles ORDER by id ASC");
								while ($array_role = mysqli_fetch_array($query_role)):
								$role_id = $array_role['id'];
								$role_name = $array_role['role_name'];
							?> 
							 
							<option value="<?php echo $role_id; ?>"  <?php if($user_role == $role_id ) {echo "selected"; } ?> > <?php echo $role_name; ?></option>
							
							<?php endwhile; ?>	
						</select>
					  </div>
						
					  <div class="form-group col-md-12 client_select">
						<label for="login">Ընտրել գործընկերոջը</label>
						<select name="client_select" id="client_select" class="form-control">
						<option value="0"> Ընտրել </option>
 							<?php 
								$query_client = mysqli_query($con, "SELECT * FROM client ORDER by id DESC");
								while ($array_client = mysqli_fetch_array($query_client)):
								$client_id = $array_client['id'];
								$client_name = $array_client['law_name'];
							?> 
							 
							<option value="<?php echo $client_id; ?>"  <?php if($client_id_edit == $client_id ) {echo "selected"; } ?> > <?php echo $client_name; ?></option>
							
							<?php endwhile; ?>
							
						</select>
					  </div>
			
			
					  <div class="form-group col-md-12">
						<label for="login">Մուտքանուն</label>
						<input type="text" class="form-control" id="login" name="login" placeholder="Մուտքանուն" value="<?php echo $login; ?>">
					  </div>
					  <div class="form-group col-md-12">
						<label for="password">Գաղտնաբառ</label>
						<input type="text" class="form-control" id="password" name="password" placeholder="Գաղտնաբառ" value="<?php echo $manager_password; ?>">
					  </div>
					  <div class="form-group col-md-12">
						<label for="email">E-mail</label>
						<input type="text" class="form-control" id="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>">
					  </div>
					  <div class="form-group col-md-12">
						<label for="phone">Հեռախոս</label>
						<input type="text" class="form-control" id="phone" name="phone" placeholder="Հեռախոս" value="<?php echo $phone; ?>">
					  </div>
					  
					  
					  <div class="form-group col-md-12">
						<label for="name">Անուն</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Անուն" value="<?php echo $name; ?>">
					  </div>
					  
					  					  
					  
					  <div class="form-group col-md-12">
						<label for="name">Անձնագրային տվյալներ</label>
						<input type="text" class="form-control" id="passport_details" name="passport_details" placeholder="Անձնագրային տվյալներ" value="<?php echo $passport_details; ?>">
					  </div>
					  
					  					  
					  
					  <div class="form-group col-md-12">
						<label for="name">Գրանցման հասցե</label>
						<input type="text" class="form-control" id="passport_address" name="passport_address" placeholder="Գրանցման հասցե" value="<?php echo $passport_address; ?>">
					  </div>
					  
					  					  
					  
					  <div class="form-group col-md-12">
						<label for="name">Փաստացի հասցե</label>
						<input type="text" class="form-control" id="real_address" name="real_address" placeholder="Փաստացի հասցե" value="<?php echo $real_address; ?>">
					  </div>
					  
					  					  
					  
					  <div class="form-group col-md-12">
						<label for="name">Աշխատակցի մեկնաբանություն</label>
						<input type="text" class="form-control" id="manager_comment" name="manager_comment" placeholder="Աշխատակցի մեկնաբանություն" value="<?php echo $manager_comment; ?>">
					  </div>
					  
					  
					  
					  
					  
					  

					  
					  <div class="form-group col-md-12">
						<label for="name">Ակտիվ</label>
						<input type="checkbox" class="active" id="active" name="active" <?php if($active=='on'){echo "checked";} ?>>
					  </div>
					  
					  
					  <div class="form-group col-md-12">
						<label for="name">Կարող է գնահատել</label>
						<input value='on' type="checkbox" class="active" id="canRate" name="canRate" <?php if($canRate=='1'){echo "checked";} ?>>
					  </div>
					  <div class="form-group col-md-12">
						<label for="name">Ցուցադրել  բարձախոսը</label>
						<input value='on' type="checkbox" class="active" id="hasMic" name="hasMic" <?php if($hasMic=='1'){echo "checked";} ?>>
					  </div>
					  <div class="form-group col-md-12">
						<label for="name">Կարող է ձայնագրել</label>
						<input value='on' type="checkbox" class="active" id="canRecord" name="canRecord" <?php if($canRecord=='1'){echo "checked";} ?>>
					  </div>

						
						
					  <div class="form-group col-md-12 label_audit">
						<label for="name">Աուդիտ</label>
						<input type="checkbox" class="audit" id="audit" name="audit" <?php if($audit=='on'){echo "checked";} ?>>

					  </div>		
					  
					  <div class="form-group col-md-12 label_discount">
						<label for="discount">Զեղչի փոփոխություն</label>
						<input type="checkbox" class="discount" id="discount" name="discount" <?php if($discount=='on'){echo "checked";} ?>>

					  </div>	
					  
					  <div class="form-group col-md-12 label_discount">
						<label for="has_order">Հավելվածով պատվերի հնար. </label>
						<input type="checkbox" class="has_order" id="has_order" name="has_order" <?php if($has_order=='1'){echo "checked";} ?>>

					  </div>
					  
					  
					  <?php if($user_role == '1'):  ?>
					  <div class="form-row col-md-12 money_plan">
						
						<div class="form-group col-md-12 ">
						<label for="">Աշխատավարձի հաշվարկի պլան</label>

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_visit">Այց</label>
						<input type="text" class="form-control" id="plan_visit" name="plan_visit" placeholder="Այց" value="<?php echo $plan_visit; ?>">

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_audit">Ցուցարություն</label>
						<input type="text" class="form-control" id="plan_audit" name="plan_audit" placeholder="Ցուցարություն" value="<?php echo $plan_audit; ?>">

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_task">Առաջադրանք</label>
						<input type="text" class="form-control" id="plan_task" name="plan_task" placeholder="Առաջադրանք" value="<?php echo $plan_task; ?>">

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_order_summ">Պատվերի գումար</label>
						<input type="text" class="form-control" id="plan_order_summ" name="plan_order_summ" placeholder="Պատվերի գումար" value="<?php echo $plan_order_summ; ?>">

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_shop_count">Խանութի քանակ</label>
						<input type="text" class="form-control" id="plan_shop_count" name="plan_shop_count" placeholder="Խանութի քանակ" value="<?php echo $plan_shop_count; ?>">

						</div>
						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_shop_summ">Խանութի գումար</label>
						<input type="text" class="form-control" id="plan_shop_summ" name="plan_shop_summ" placeholder="Խանութի գումար" value="<?php echo $plan_shop_summ; ?>">

						</div>		
						
						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_visit_money">Գումար</label>
						<input type="text" class="form-control" id="plan_visit_money" name="plan_visit_money" placeholder="Այց" value="<?php echo $plan_visit_money; ?>">

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_audit_money">Գումար</label>
						<input type="text" class="form-control" id="plan_audit_money" name="plan_audit_money" placeholder="Ցուցարություն" value="<?php echo $plan_audit_money; ?>">

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_task_money">Գումար</label>
						<input type="text" class="form-control" id="plan_task_money" name="plan_task_money" placeholder="Առաջադրանք" value="<?php echo $plan_task_money; ?>">

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_order_summ_money">Գումար</label>
						<input type="text" class="form-control" id="plan_order_summ_money" name="plan_order_summ_money" placeholder="Պատվերի գումար" value="<?php echo $plan_order_summ_money; ?>">

						</div>						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_shop_count_money">Գումար</label>
						<input type="text" class="form-control" id="plan_shop_count_money" name="plan_shop_count_money" placeholder="Խանութի քանակ" value="<?php echo $plan_shop_count_money; ?>">

						</div>
						
						<div class="form-group col-md-2 label_discount">
						<label for="plan_shop_summ_money">Գումար</label>
						<input type="text" class="form-control" id="plan_shop_summ_money" name="plan_shop_summ_money" placeholder="Խանութի գումար" value="<?php echo $plan_shop_summ_money; ?>">

						</div>
						
						
						
						
						
						<div class="form-group col-md-12 label_discount">
						<label for="plan_comment">Հաշվարկի մեկնաբանություն</label>
						<input type="text" class="form-control" id="plan_comment" name="plan_comment" placeholder="Հաշվարկի մեկնաբանություն" value="<?php echo $plan_comment; ?>">

						</div>
						
			
						
					  </div>
					<?php endif; ?>
					
					<?php if($user_role == '1' or $user_role == '5'):  ?>	
					
					<div class="form-row col-md-12">
					
					<div class="form-group col-md-2">
					<label for="manager_origin_latitude">Սկզբնական Latitude</label>
					<input type="text" class="form-control" id="manager_origin_latitude" name="manager_origin_latitude" placeholder="Կոորդինատ 1 (Latitude)" value="<?php echo $manager_origin_latitude; ?>">
					</div>	

					
					<div class="form-group col-md-2">
					<label for="manager_origin_longitude">Սկզբնական Longitude</label>
					<input type="text" class="form-control" id="manager_origin_longitude" name="manager_origin_longitude" placeholder="Կոորդինատ 2 (Longitude)" value="<?php echo $manager_origin_longitude; ?>">
					</div>
										
					<div class="form-group col-md-2">
					<label for="manager_destination_latitude">Վերջնական Latitude</label>
					<input type="text" class="form-control" id="manager_destination_latitude" name="manager_destination_latitude" placeholder="Կոորդինատ 1 (Latitude)" value="<?php echo $manager_destination_latitude; ?>">
					</div>	

					
					<div class="form-group col-md-2">
					<label for="manager_destination_longitude">Վերջնական Longitude</label>
					<input type="text" class="form-control" id="manager_destination_longitude" name="manager_destination_longitude" placeholder="Կոորդինատ 2 (Longitude)" value="<?php echo $manager_destination_longitude; ?>">
					</div>
					
					
					<div class="form-group col-md-2">
					<label for="charge_cost">Մեկ լիցքավորման արժեք</label>
					<input type="text" class="form-control" id="charge_cost" name="charge_cost" placeholder="Լիցքավորման արժեք" value="<?php echo $charge_cost; ?>">
					</div>			
		
					<div class="form-group col-md-2">
					<label for="charge_km">Մեկ լիցքավորման կմ</label>
					<input type="text" class="form-control" id="charge_km" name="charge_km" placeholder="Լիցքավորման կմ" value="<?php echo $charge_km; ?>">
					</div>
					
					
					</div>
					
					<?php endif; ?>

			<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
			
			<input type="hidden" name="manager_id" id="manager_id" value="<?php echo $_GET['manager_id']; ?>">
			
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
	var user_role = $('#user_role').val();
	
	if(user_role == '0'){
		return false;
	}
	
    var form = $(this);
    var url = form.attr('action');
	var login = $('#login').val();
	var client_id = $('#client_select').val();
	
	if (client_id == '0'){
		$('#client_select').addClass('border border-danger');
		//return false;
	}
	
	if (login == ''){
		$('#login').addClass('border border-danger');
		return false;
	}
	
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {
              // alert(data); 
			   $('#login').removeClass('border border-danger');
			   $('.success_message').text(data);
			   //$('.alert').show()
			   //$('.modal_answere').click();
			   window.location.replace("/managers.php");


           }
		   
         });
});
   
</script>
</body>
</html>
