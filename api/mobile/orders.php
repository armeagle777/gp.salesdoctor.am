<?php require '../db.php'; ?>

<?php 

$user_id=mysqli_real_escape_string($con, $_GET['user_id']);
$sql = "SELECT * FROM manager WHERE id=$user_id";


$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);

extract($row);

$order_type = 1;

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);



$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$courier_id_selected = mysqli_real_escape_string($con, $_GET['courier_select']);

$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);

$selected_region = mysqli_real_escape_string($con, $_GET['region']);
$selected_district = mysqli_real_escape_string($con, $_GET['district']);
$selected_shop = mysqli_real_escape_string($con, $_GET['shop']);
$selected_network = mysqli_real_escape_string($con, $_GET['network_select']);
$selected_payment_type = mysqli_real_escape_string($con, $_GET['payment_type']);

if($user_role == '1'){
	$query_manager_select = " AND pr_orders_document.manager_id = '$user_id'";
}else if($manager_id_selected != 0 AND $manager_id_selected != ''){
	$query_manager_select = " AND pr_orders_document.manager_id = '$manager_id_selected'";
}else{
	$query_manager_select = '';
}

if($courier_id_selected != 0 AND $courier_id_selected != ''){
	$query_courier_select = " AND pr_orders_document.courier_id = '$courier_id_selected'";
}else{
	$query_courier_select = '';
}


$group_selected = mysqli_real_escape_string($con, $_GET['group_id']);


if($group_selected != 0 AND $group_selected != ''){
	$query_group_selected = " AND pr_orders_document.product_group = '$group_selected' ";
}else{
	$query_group_selected = '';
}


//new
if($selected_region != 0 AND $selected_region != ''){
	$query_region_select = " AND shops.region = '$selected_region'";
}else{
	$query_region_select = '';
}

if($selected_district != 0 AND $selected_district != ''){
	$query_district_select = " AND shops.district = '$selected_district'";
}else{
	$query_district_select = '';
}

if($selected_shop != 0 AND $selected_shop != ''){
	$query_shop_select = " AND shops.shop_id = '$selected_shop'";
}else{
	$query_shop_select = '';
}


if($selected_network != 0 AND $selected_network != ''){
	$query_network_select = " AND shops.network = '$selected_network'";
}else{
	$query_network_select = '';
}


if($selected_payment_type != 0 AND $selected_payment_type != ''){
	$payment_type_select = " AND pr_orders_document.pay_type = '$selected_payment_type'";
}else{
	$payment_type_select = '';
}





$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
$date_ex = explode(" - ", $datebeet);
$start_date = $date_ex[0];
$end_date = $date_ex[1];

if($start_date != $end_date){
	$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
}else{
	$query_date_range = " LIKE '$start_date%'";
}

	if($_SESSION['user_role'] == '3' ){
		$disabled = 'disabled';
	}else{
		$disabled = '';
	}

					
?>

<link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../../plugins/summernote/summernote-bs4.css">
  <!-- Custom css -->
  <link rel="stylesheet" href="../../../plugins/custom_style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
    <!-- Bootstrap toggle button styles  -->
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <!-- Choosen select  styles  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
        integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


<style type="text/css">
.dt-buttons {
	float: right;
    margin-top: 15px;
}
.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 999px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  background: red;
  cursor: inherit;
  display: block;
}
input[readonly] {
  background-color: white !important;
  cursor: text !important;
}


/* Image modal styles   */
.myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */

.image-modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.image-modal .modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.image-modal .modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .image-modal .modal-content {
    width: 100%;
  }
}

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php if($order_type == '2'){ echo "Վերադարձներ"; }else {echo "Պատվերներ"; } ?></h1>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
				 <form action="/api/mobile/orders.php" id="statistics_form"> 
					<input name="user_id" type="hidden" value="<?php echo $user_id; ?>"  />
				  <div class="form-row">
				 <div class="form-group col-md-3">
                  <label>Ժամանակահատված</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right " id="reservation" value="<?php echo $datebeet; ?>" name="datebeet">
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
				  
					  <div class="form-group col-md-2">
								<label for="login">Խումբ</label>
								<select name="group_id" id="group_id" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 
										$query_groups = mysqli_query($con, "SELECT * FROM pr_groups");
										while($groups_array = mysqli_fetch_array($query_groups)):
										$group_id = $groups_array['id'];
										$group_name = $groups_array['group_name'];
									?> 
									 
									<option value="<?php echo $group_id; ?>"  <?php if($group_selected == $group_id ) {echo "selected"; } ?> > <?php echo $group_name; ?></option>
									
									<?php endwhile; ?>
									
								</select>
					  </div>
					  
					  
					  
					  
					  
					  
					  
					  
					  			  
			  
			   <div class="form-group col-md-2">
							<label for="address">Մարզ</label>

								<select name="region" id="region" class="form-control">
									<option value="0"> Ընտրել </option>
										<?php 
											$query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
											while ($array_regions = mysqli_fetch_array($query_region)):
											$region_id = $array_regions['id'];
											$region_name = $array_regions['region_name'];
										?> 
										 
									<option value="<?php echo $region_id; ?>" <?php if($region_id == $selected_region) {echo "selected"; } ?>> <?php echo $region_name; ?></option>
							
									<?php endwhile; ?>
							
								</select>

						  </div>




				  <div class="form-group col-md-2">
					<label for="district">Տարածք</label>
						
					<select name="district" id="district" class="form-control">
					
						<option value="0">Ընտրել</option>
							
						<?php 
							$district_query = mysqli_query($con, "SELECT * FROM district WHERE region_id = '$selected_region' ORDER by id DESC");
							while ($array_district = mysqli_fetch_array($district_query)):
							$district_id = $array_district['id'];
							$district_name = $array_district['district_name'];
						?> 
						 
					<option value="<?php echo $district_id; ?>" <?php if($district_id == $selected_district) {echo "selected"; } ?>> <?php echo $district_name; ?></option>
			
					<?php endwhile; ?>	
			
					</select>
					
				  </div>
				  
				  <div class="form-group col-md-2">
					<label for="shop">Խանութ</label>
						
					<select name="shop" id="shop" class="form-control">

						<option value="0">Ընտրել</option>
					
					<?php 
							$shops_query = mysqli_query($con, "SELECT shop_id, name, district FROM shops WHERE district = '$selected_district' ORDER by id DESC");
							while ($array_shops = mysqli_fetch_array($shops_query)):
							$shop_id = $array_shops['shop_id'];
							$shop_name = $array_shops['name'];
						?> 
						 
					<option value="<?php echo $shop_id; ?>" <?php if($shop_id == $selected_shop) {echo "selected"; } ?>> <?php echo $shop_name; ?></option>
			
					<?php endwhile; ?>
					
					</select>
					
				  </div>
				  
					  <div class="form-group col-md-2">
							<label for="login">Ցանց</label>
							<select name="network_select" id="network_select" class="form-control">
							<option value="0"> Ընտրել </option>
								<?php 
									if($selected_district):
									$query_network = mysqli_query($con, "SELECT * FROM network ORDER by id DESC");

									while ($array_network = mysqli_fetch_array($query_network)):
									$network_id = $array_network['id'];
									$network_name = $array_network['network_name'];
								?> 
								 
								<option value="<?php echo $network_id; ?>"  <?php if($network_id == $selected_network ) {echo "selected"; } ?> > <?php echo $network_name; ?></option>
								
								<?php 

									endwhile; 
								endif;
							?>
								
							</select>
				  </div>
				  
				  <div class="form-group col-md-2">
							<label for="login">Վճ. տիպ</label>
							<select name="payment_type" id="payment_type" class="form-control">
							<option value="0"> Ընտրել </option>
								<?php 

									$query_payment_type = mysqli_query($con, "SELECT * FROM pr_payment_type ORDER by id DESC");

									while ($array_payment_type = mysqli_fetch_array($query_payment_type)):
									$payment_type_id = $array_payment_type['id'];
									$payment_type_name = $array_payment_type['payment_name'];
								?> 
								 
								<option value="<?php echo $payment_type_id; ?>"  <?php if($payment_type_id == $selected_payment_type ) {echo "selected"; } ?> > <?php echo $payment_type_name; ?></option>
								
								<?php endwhile; ?>
								
							</select>
				  </div>
		  
				<?php if($user_role != '1'): ?>
				  <div class="form-group col-md-2">
								<label for="login">Մենեջեր</label>
								<select name="manager_select" id="manager_select" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 

										$query_manager = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '1' ORDER by id DESC");

										while ($array_manager = mysqli_fetch_array($query_manager)):
										$manager_id = $array_manager['id'];
										$manager_login = $array_manager['login'];
									?> 
									 
									<option value="<?php echo $manager_id; ?>"  <?php if($manager_id_selected == $manager_id ) {echo "selected"; } ?> > <?php echo $manager_login; ?></option>
									
									<?php endwhile; ?>
									
								</select>
				  </div>	
				  <?php endif; ?>
				  <div class="form-group col-md-2">
								<label for="login">Առաքիչ</label>
								<select name="courier_select" id="courier_select" class="form-control">
								<option value="0"> Ընտրել </option>
									<?php 

										$query_courier = mysqli_query($con, "SELECT * FROM manager WHERE user_role = '5' ORDER by id DESC");

										while ($array_courier = mysqli_fetch_array($query_courier)):
										$courier_id = $array_courier['id'];
										$courier_login = $array_courier['login'];
									?> 
									 
									<option value="<?php echo $courier_id; ?>"  <?php if($courier_id_selected == $courier_id ) {echo "selected"; } ?> > <?php echo $courier_login; ?></option>
									
									<?php endwhile; ?>
									
								</select>
				  </div>

					  
					 <div class="form-group col-md-1" >
								<button type="submit" class="btn btn-success">Ցուցադրել</button>
					  </div>
					  
					  
					  <input type="hidden" name="order_type" value="<?php echo $order_type; ?>">
					  
					  
					
					</div>
				
				
				  </form>
			  
		<?php //echo "SELECT * FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN network ON shops.network = network.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE pr_orders_document.order_type = '$order_type' AND document_date $query_date_range $query_district_select $query_manager_select "; ?>
			  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Ժամանակ</th>
                    <th style="width:150px;">Գործողություն</th>
					<th>Ավարտ</th>					
					<th style="width: 200px;">Նախնական գումար</th>
					<th style="width: 200px;">Գումար</th>
					<th class="select-filter">Վճ. տիպ</th>
					<th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Խումբ</th>
                    <th class="select-filter">Խանութ</th>
                    <th class="select-filter">Հասցե</th>
                    <th class="select-filter">Տարածք</th>
					<th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Հ/Ա</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Խումբ</th>
					<th class="select-filter">Առաքիչ</th>
					<th class="select-filter">Կտրոն</th>
					<th class="select-filter">Համար</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
					if(false):
						$query =   "SELECT *, 
						                M.name AS manager_name,
						                C.name AS courier_name,
						                G.group_name AS SHOP_GROUP_NAME,
						                shops.name AS SHOP_NAME,
						                shops.shop_id AS SHOP_ID
					                FROM pr_orders_document 
                						LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id 
                						LEFT JOIN district ON shops.district = district.id 
                						LEFT JOIN network ON shops.network = network.id 
                						LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id 
                						LEFT JOIN pr_payment_type ON pr_payment_type.id= pr_orders_document.pay_type
                						LEFT JOIN manager M ON M.id=pr_orders_document.manager_id
                						LEFT JOIN manager C ON C.id=pr_orders_document.courier_id
                						LEFT JOIN group_to_shop GS ON shops.shop_id = GS.shop_id
                						LEFT JOIN shop_group G ON G.id = GS.group_id
        						    WHERE pr_orders_document.order_type = '$order_type' 
                						AND document_date 
                						$query_date_range 
                						$query_district_select 
                						$query_region_select 
                						$query_shop_select 
                						$query_network_select 
                						$payment_type_select 
                						$query_manager_select 
                						$query_group_selected 
                						$query_courier_select";
					
					
					$query_order_documents = mysqli_query($con, $query);
					while($warehouse_order_array = mysqli_fetch_array($query_order_documents)):
    					$document_id = $warehouse_order_array['document_id'];
    					$shop_id = $warehouse_order_array['SHOP_ID'];
    					$manager_name = $warehouse_order_array['manager_name'];
    					$courier_name = $warehouse_order_array['courier_name'];
    					$product_id = $warehouse_order_array['product_id'];
    					$product_count = $warehouse_order_array['product_count'];
    					$document_date = $warehouse_order_array['document_date'];
    					$shop_name = $warehouse_order_array['SHOP_NAME'];
    					$shop_address = $warehouse_order_array['address'];
    					$order_summ = $warehouse_order_array['order_summ'];
    					$order_last_summ = $warehouse_order_array['order_last_summ'];
    					$order_delivered = $warehouse_order_array['order_delivered'];
    					$order_pay_status = $warehouse_order_array['order_pay_status'];
    					$product_group_name = $warehouse_order_array['group_name'];
    					$order_pay_type = $warehouse_order_array['payment_name'];
    					$district_name = $warehouse_order_array['district_name'];
    					$network = $warehouse_order_array['network_name'];
    					$order_comment = $warehouse_order_array['order_comment'];
    					$ktron_image = $warehouse_order_array['ktron_image'];
    					$SHOP_GROUP_NAME = $warehouse_order_array['SHOP_GROUP_NAME'];
    					
    					if($order_last_summ == ''){
    						$order_last_summ = '0'; 
    					}
					
				  ?>
				  <tr> 
					<td><?php echo $document_date; ?></td>
					<td>
    					<a href="/warehouse_exit.php?document_id=<?php echo $document_id; ?><?php if ($order_type == '2'){ echo "&order_type=2"; }?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="far fa-file"></i></a>
    					<a href="/view_order.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fa fa-search"></i></a>
    					<a href="#" class="btn btn-danger btn-sm delete_document" title="Ջնջել" data-toggle="modal" data-documentid="<?php echo $document_id; ?>"<?php echo $disabled; ?>><i class="fa fa-trash"></i></a>
    					 <?php
    						$query_check_full_pay = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) as payed_summ FROM pr_orders_finance WHERE payed_document_id = '$document_id' "));
    						if($query_check_full_pay['payed_summ'] < $order_last_summ AND $order_pay_status == '3'){
    							echo '<button class="btn btn-warning btn-sm rounded-0"><i class="fas fa-check"></i></button>';
    						}elseif($query_check_full_pay['payed_summ'] >= $order_last_summ AND $order_pay_status == '3'){
    							echo '<button class="btn btn-success btn-sm rounded-0"><i class="fas fa-check"></i></button>';
    						}else{
    							echo '<button class="btn btn-danger btn-sm rounded-0"><i class="fas fa-window-close"></i></button>';
    						}					
    					 ?>
					</td>
					<td style="text-align: center;">
					    <input type="checkbox" class="form-control order_delivered" <?php if($order_delivered == '1') {echo "checked"; } ?> id="<?php echo $document_id; ?>" <?php echo $disabled; ?> >
					</td>
					<td style="font-size: 15px;"><?php echo $order_summ; ?></td>
					<td style="font-weight: bold;"><?php echo $order_last_summ; ?></td>
					<td><?php echo $order_pay_type; ?></td>
					<td><?php echo $order_comment; ?></td>
					<td><?php echo $product_group_name; ?></td>
					<td><b><?php echo $shop_id; ?>.<?php echo $shop_name; ?></b></td>
					<td><b><?php echo $shop_address; ?></b></td>
					<td><?php echo $district_name; ?></td>
					<td><?php echo $manager_name; ?></td>
					<td>
						<?php if($warehouse_order_array['ha_sended']== '1'): ?>
						    <button class="btn btn-success btn-sm rounded-0"><i class="fas fa-check"></i></button>
						<?php endif; ?>
					</td>
					<td><?php echo $network; ?></td>
					<td><?php echo $SHOP_GROUP_NAME; ?> </td>
					<td style="text-align: center; width: 55px;"><?php echo $courier_name; ?> </td>	
					<td id="<?php echo $document_id; ?>_image_cell">
					    <?php if($ktron_image): ?>
					        <img class="myImg" src="/uploads/ktronner/<?php echo $ktron_image;  ?>" style="width:50px; heigth:70px"  />
					        <button class="btn btn-outline-warning btn-xs add_image " type="button" document_id="<?php echo $document_id;  ?>" style="width:50px; padding:2px 0;"><i class="fa fa-upload" style="font-size:8px"></i></button>
				        <?php else : ?>
				            <button document_id="<?php echo $document_id;  ?>" type="button" class="btn btn-outline-primary btn-sm add_image"><i class="fa fa-upload" aria-hidden="true"></i></button>
					    <?php endif;  ?>
				    </td>
					<td><?php echo $document_id; ?></td>
				  </tr>
			        <?php endwhile; ?>
					<?php endif; ?>
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Ժամանակ</th>
                    <th style="width:150px;">Գործողություն</th>
					<th>Ավարտ</th>
					<th style="width: 200px;">Նախնական գումար</th>
					<th style="width: 200px;">Գումար</th>
					<th class="select-filter">Վճ. տիպ</th>
					<th class="select-filter">Մեկնաբանություն</th>
					<th class="select-filter">Խումբ</th>
                    <th class="select-filter">Խանութ</th>
                    <th class="select-filter">Հասցե</th>
                    <th class="select-filter">Տարածք</th>
					<th class="select-filter">Մենեջեր</th>
					<th class="select-filter">Հ/Ա</th>
					<th class="select-filter">Ցանց</th>
					<th class="select-filter">Խումբ</th>
					<th class="select-filter">Առաքիչ</th>
					<th class="select-filter">Կտրոն</th>
					<th class="select-filter">Համար</th>
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
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- InputMask -->
<script src="../../../plugins/moment/moment.min.js"></script>
<script src="../../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../../plugins/daterangepicker/daterangepicker.js"></script>

<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../dist/js/demo.js"></script>
<!-- page script -->

<!-- Export -->

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>


<!-- upload modal  -->
<div class="modal fade" id="upload_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="upload_modal_header" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">×</button>                        
            </div>
            <form method="post" enctype="multipart/form-data"  id="ktron_image_form">
                <div class="modal-body">
                        <input type="hidden" id="documetn_input" name="order_document_id"/>   
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Բեռնել... 
                                    <input required  accept="image/png, image/jpg, image/jpeg" name="ktron_image" type="file" id="image_upload">
                                </span>
                            </span>
                            <input readonly="readonly" placeholder="Կտրոնի նկար" class="form-control" name="filename" type="text">
                        </div>
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ՓԱԿԵԼ</button>
                    <button type="submit" class="btn btn-success">Պահպանել</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="delete_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Ջնջե՞լ պատվերը
		<div id="message_text" style="font-weight: bold; margin-top: 30px;">
		</div>
		<input type="hidden" id="delete_document_id" value=""> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger end_delete_document">Ջնջել</button>
      </div>
    </div>
  </div>
</div>


//Image modal
<!-- The Modal -->
<div id="imageModal" class="modal image-modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>


<script>

//Image modal code

$(document).on("click",".myImg", function(){
    $("#imageModal").show()
    $("#img01").attr("src", $(this).attr('src')) 
    $("#caption").html($(this).attr('alt'))
})

$(document).on("click",".close", function(){
  $("#imageModal").hide()  
})




//Modal opening function
$(document).on("click", ".add_image", function(){
    $("input[name='filename']").val('')
    $("#image_upload").val('')
    let document_id= $(this).attr('document_id')
    let header_text = `Ներբեռնել  N${document_id}  փաստաթղթի կտրոնը `
    $('#upload_modal_header').html(header_text)
    $('#documetn_input').val(document_id) 
    $("#upload_modal").modal({ backdrop: "static" });
})

//On file input change filename into preview
$(document).on("change", "#image_upload", function(e){
    let value= $(this)[0].files[0].name
    $("input[name='filename']").val(value)
})

//Image upload form submit
$(document).ready(function (e) {
    $("#ktron_image_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "actions.php?cmd=upload_ktron_image",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            // beforeSend : function(){
            //     //$("#preview").fadeOut();
            //     $("#err").fadeOut();
            // },
            success: function(data){
                const {document_id, ktron_image} = JSON.parse(data)
                $(`#${document_id}_image_cell`).html(`<img class="myImg" src="/uploads/ktronner/${ktron_image}" style="width:50px; heigth:70px"  /><button class="btn btn-outline-warning btn-xs add_image " type="button" document_id="${document_id}" style="width:50px; padding:2px 0;"><i class="fa fa-upload" style="font-size:8px"></i></button>`)
                $("#upload_modal").modal('hide');
            },
            error: function(e){
                console.log(e)
            }          
        });
    }));
});


$( "#region" ).change(function() {
	  $('#district option').remove();
	  var url = '../region_select.php';
	  var region = $('#region').val();
      $.ajax({
           type: "POST",
           url: url,
           data: {region_select: region}, 
           success: function(data)
           {

			   $('#district').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});


$( "#district" ).change(function() {
	  var district = $('#district').val();
	  $('#shop option').remove();
	  var url = '../shop_select.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {district: district}, 
           success: function(data)
           {

			   $('#shop').append(data);
			  // $('.alert').show()

           }
		   
         });

  
});



        $('.delete_document').click(function(){
			var document_id = $(this).data('documentid');
			
			$('#delete_document_id').val(document_id);
			$('#delete_document').modal('show');

        });


$(document).ready(function(){
        $('.end_delete_document').click(function(){
			
			var delete_document_id = $('#delete_document_id').val();
			
			$.ajax({
				type: "POST",
				url: "../add_warehouse_order_edit.php",
				data: {delete_document_id:delete_document_id, action:'delete_document'},
				success: function(data)
				{
					var get_data = JSON.parse(data);
					
					$('#message_text').html(get_data[0]);
					
					if(get_data[1] == '1'){
						window.location.reload();
					}
					
				   //alert(data); 
				   //window.location.reload();
				}
			   
			});
			
			
			
        });
    });

$(document).ready(function(){
        $('.order_delivered').click(function(){
            if($(this).is(":checked")){
                var status = '1';
            }
            else if($(this).is(":not(:checked)")){
                var status = '0';
            }
			
			var document_id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "../add_warehouse_order_edit.php",
				data: {document_id:document_id, action:'order_delivered', status: status},
				success: function(data)
				{
				   //alert(data); 
				   //window.location.reload();
				}
			   
			});
			
			
			
        });
    });





// // Material Select Initialization
//     $(document).ready(function() {
//     $('.mdb-select').materialSelect();
// });


$('#not_grouped').click(function() {
    if( $(this).is(':checked')) {
        $(".not_visited_check").hide();
    } else {
        $(".not_visited_check").show();
    }
}); 

 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
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
           url: "../add_shop.php",
           data: {shop_id:client_to_delete, action:'delete_cient'},
           success: function(data)
           {
               //alert(data); 
			   window.location.reload();
           }
		   
         });
});
	
	

  $(function () {
   var table =  $("#example1").DataTable({
	   
	
						"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 2;
				while(j < 5){
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
