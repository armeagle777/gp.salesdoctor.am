<?php
session_start();
//	if(!isset($_SESSION['user_id'])){
//		header("Location: /index.php");
//	}	
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sales Doctor | Գլխավոր</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Custom css -->
  <link rel="stylesheet" href="plugins/custom_style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="display: none;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown" style="display: none;">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown" style="display: none;">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item" style="display: none;">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
	  
		<li class="nav-item">
		<a href="/logout.php" id="3" class="btn btn-default btn-sm  data-toggle="modal" data-target="#deletemodal" title="Ելք համակարգից"><i class="fa  fa-power-off"></i></a>
		</li>
					
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="display: none;">
    <!-- Brand Logo -->
	
	<?php 
	
	if($_SESSION['role'] != '1' ){
		$link_home = '/dashboard.php';
	}
	
	if($_SESSION['user_role'] == '1' ){
		$link_home = '/pr_new_order.php';	
	}else{
		$link_home = '/statistics.php';
	}
	?>
	
    <a href="<?php echo $link_home; ?>" class="brand-link">
      <img src="/logo2.png" alt="Sales Doctor" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sales Doctor</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
	  <?php if($_SESSION['role']!= '1' ): ?>
	  
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
	  
        <div class="image">
		<?php if($_SESSION['image']!= '' ): ?>
          <img src="/uploads/<?php echo $_SESSION['image']; ?>" class="img-circle elevation-2" alt="User Image">
		<?php endif; ?>
        </div>
		
		
        <div class="info">
          <a href="/action_user.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="d-block"><?php echo $_SESSION['user_name']; ?></a>
        </div>
      </div>
	 <?php endif; ?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
       		 with font-awesome or any other icon font library -->

		  <?php if($_SESSION['role']!= '1' &&  $_SESSION['user_role'] == ''): ?>
		  <li class="nav-item">
            <a href="/partners.php" class="nav-link">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
                Գործընկեր (beta)
              </p>
            </a>
          </li>
		  
		  		  
		  <li class="nav-item has-treeview">
            <a href="/finance.php" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
                Ֆինանսական (beta)
              </p>
            </a>
          </li>	
		  
		  <?php endif; ?>

       
		<?php if($_SESSION['role']!= '1' ): ?>
		
		
		<?php 
		
			if($_SESSION['user_role'] == '1' ){
				include 'menus/menu_manager.php';
			}	
			
			if($_SESSION['user_role'] == '2' ){
				include 'menus/menu_gortsavar.php';
			}
				
			if($_SESSION['user_role'] == '3' ){
				include 'menus/menu_warehouse.php';
			}		
			
			if($_SESSION['user_role'] == '4' ){
				include 'menus/menu_finance.php';
			}
				
			if($_SESSION['user_role'] == '5' ){
				include 'menus/menu_courier.php';
			}
			
			if($_SESSION['user_role'] == '6' ){
				include 'menus/menu_admin.php';
			}			
			if($_SESSION['user_role'] == '' ){
				include 'menus/main_menu.php';
			}
			
			
			
			
			
			
		?>
		
		
	 
		
	 <?php endif; ?> 
	  
	  
        </ul>  
		  
           
         
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside><?php include 'api/db.php'; ?>


<?php 

$shop_id = mysqli_real_escape_string($con, $_GET['shop_id']);
$shop_details = mysqli_query($con, "SELECT * FROM shops WHERE shop_id = $shop_id ");
while($shop_details_array = mysqli_fetch_array($shop_details)){
	$name = $shop_details_array['name'];
	$address = $shop_details_array['address'];
	$hvhh = $shop_details_array['hvhh'];
	$balance = $shop_details_array['balance'];
	$discount = $shop_details_array['discount'];
	$network = $shop_details_array['network'];
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Գումարի մուտք</h1>
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

              <!-- /.card-header -->
              <div class="card-body">

			  <table class="table table-borderless">
					<div style="font-size: 25px; padding-bottom: 10px; color: #28a745;"> <?php if($_GET['message'] == '1'){echo "Գումարը մուտքագրվել է"; } ?> </div>
				  <tbody>
				  
					  <tr>
						<td style="width: 190px;">Անվանում՝</td>
						<td><b><?php echo $name; ?></b></td>
						<td>Զեղչ՝ </td>
						<td><b><?php echo $discount; ?></b></td>
					  </tr>
				  
					  <tr>
						<td>Ընդհանուր պարտք՝</td>
						<td><b><?php echo $balance; ?></b></td>
						<td>ՀՎՀՀ՝</td>
						<td><b><?php echo $hvhh; ?></b></td>
					  </tr>
				  
					  <tr>
						<td>Առաքիչ՝</td>
						<td></td>
						<td>Հասցե՝</td>
						<td><b><?php echo $address; ?></b></td>
					  </tr>
				  
				
				  </tbody>
				  
			  
			  </table>
			  <hr>
			  <form id="add_finance" action="/api/add_pr_finance.php" style="margin-top: 30px;">
			  
				<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>">
				
				<div class="form-row">
				 <div class="form-group col-md-2">
							<label for="address">Գումարի մուտք</label>
							<input type="text" class="form-control product_count" id="input_summ" name="input_summ" placeholder="Գումար" >
				  </div>
				  
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
								 
								<option value="<?php echo $group_id; ?>" > <?php echo $group_name; ?></option>
								
								<?php endwhile; ?>
								
							</select>
					</div>
				  
				  <div class="form-group col-md-2">
							<label for="address">Վճարման տիպ</label>
							<select name="product_payment" id="product_payment" class="form-control">
								<option value="">Ընտրել</option>
								<?php 
									$query_product_payment = mysqli_query($con, "SELECT * FROM pr_payment_type");
									while($array_pr_payment = mysqli_fetch_array($query_product_payment)){
																
										echo "<option value='{$array_pr_payment['id']}'>{$array_pr_payment['payment_name']}</option>";
									}
								?>
							</select>
				  </div>
				  
				  <div class="form-group col-md-3">
							<label for="address">Դրամարկղ / բանկ</label>
							<select name="payer_payment_type" id="payer_payment_type" class="form-control">
								<option value="0">Ընտրել</option>
								<option value="1">Դրամարկղ</option>
								<option value="2">Բանկ</option>
							</select>
				  </div>
				  
				  <div class="form-group col-md-2">
							<label for="address">Բանկ</label>
							<select name="payer_payment_bank" id="payer_payment_bank" class="form-control">
								<option value="0">Ընտրել</option>
								<?php 
									$query_bank = mysqli_query($con, "SELECT * FROM pr_bank");
									while($bank_array = mysqli_fetch_array($query_bank)):
								?>
								<option value="<?php echo $bank_array['id'] ?>"><?php echo $bank_array['bank_name']; ?></option> 
								<?php endwhile; ?>
							</select>
				  </div>
				  
				  <div class="form-group col-md-3">
				 <button type="submit" class=" btn btn-primary">Մուտքագրել</button>
				  </div>
				
				
				</div>
				
				<div class="form-row">
				 <div class="form-group col-md-6" style="display:none;">
						Նշված պատվերների գումաը՝ <b><span id="total">0</span></b>
				</div>
				
				<input type="hidden" name="network" id="netowrk" value="<?php echo $network; ?>">
				
			</form>
			  
                <table id="example_0" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				  
                    <th>Ընտրել</th>
                    <th>Խումբ</th>
                    <th>Փաստաթուղթ</th>
                    <th>Մնացորդ</th>
                    <th>Վճարված գումար</th>
                    <th>Գումար</th>
					<th>Ամսաթիվ</th>
                    <th>Վճարման տիպ</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query = mysqli_query($con, "SELECT * FROM pr_orders_document LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE shop_id = $shop_id AND (order_type= '1' or order_type = '0') ");
					
					
					while($orders_array = mysqli_fetch_array($query)):
					
					
					
					$document_id = $orders_array['document_id'];
					$order_summ = $orders_array['order_last_summ'];
					$document_date = $orders_array['document_date'];
					$pay_type = $orders_array['payment_name'];
					$group_name = $orders_array['group_name'];
					
					$array_payed_summ = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS current_document_payed_summ FROM pr_orders_finance WHERE payed_document_id = '$document_id' AND payed_document_status = '3' "));
					
					if($array_payed_summ['current_document_payed_summ'] != $order_summ):
										
				 ?> 
				  
					<tr>
				  
						<td><input type="checkbox" class="document" id="<?php echo $document_id; ?>" value="<?php echo $order_summ-$array_payed_summ['current_document_payed_summ']; ?>" data-productgroup="<?php echo $group_name; ?>"></td>
						<td><?php echo $group_name; ?></td>
						<td><?php echo $document_id; ?></td>
						<td><?php echo $order_summ-$array_payed_summ['current_document_payed_summ']; ?></td>
						<td><?php echo $array_payed_summ['current_document_payed_summ']; ?></td>
						<td><b><?php echo $order_summ; ?></b></td>
						<td><?php echo $document_date; ?></td>
						<td><?php echo $pay_type; ?></td>
					</tr>
                 <?php endif; ?>
				 <?php endwhile; ?>
                  </tbody>
                  <tfoot>
                  <tr>
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

let arr = [];

$(document).on('change','.document', function(){
	var prodgroup = $(this).data("productgroup");
	arr.push(prodgroup);
	
	if(arr.length > 1){
		
		for (let i = 0; i < arr.length; i++) {
			
			if(arr[i] != prodgroup){
				arr.length = 0;
				$( ".document" ).prop( "checked", false );
				document_obj = {};
				$('#input_summ').val('0');
			} 
		  
		}
		

		
	}
	
	
});






$(document).on('keyup','#input_summ', function(){
	
	var check = $('td').find('.document:checked').length;
	if(check > 1){
		$( ".document" ).prop( "checked", false );
		document_obj = {};
	}
});



document_obj = {};
$(document).on('change','.document', function(){
		
		var check_count = $('td').find('.document:checked').length;
		
		if(check_count>0){
		   $("#product_payment").attr("disabled", true);
		   $("#group_id").attr("disabled", true);
		   
		}else{
			$("#product_payment").removeAttr("disabled");
			$("#group_id").removeAttr("disabled");
		}
		
		var pdocument_id = this.id;
		var order_sum = $(this).val();

	 if(this.checked) {

		document_obj[pdocument_id] = order_sum;
		
	}else{
		document_obj[pdocument_id] = '';
	}
});


$('.document').change(function ()
{
      var total = 0;
      $('input:checkbox:checked').each(function(){
       total += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
      });   
  
      $("#input_summ").val(total);
});


$("#add_finance").submit(function(e) {

    e.preventDefault(); 

    var form = $(this);
    var url = form.attr('action');
	var input_summ = $('#input_summ').val();
	
	var shop_id = $('#shop_id').val();
	var product_group = $('#product_group').val();
	var product_payment = $('#product_payment').val();
	var group_id = $('#group_id').val();
	var network = $('#network').val();
	var payer_payment_type = $('#payer_payment_type').val();
	var payer_payment_bank = $('#payer_payment_bank').val();

	
	if(payer_payment_type == '0'){
		$('#payer_payment_type').addClass('border border-danger');
		return false;
	}else{
		$('#payer_payment_type').removeClass('border border-danger')
	}
	
	if (input_summ == '' || input_summ < 0 || input_summ == 0){
		$('#input_summ').addClass('border border-danger');
		return false;
	}else{
		$('#input_summ').removeClass('border border-danger')
	}
	
	if (shop_id == ''){
		$('#shop_id').addClass('border border-danger');
		return false;
	}
   
	var check = $('td').find('.document:checked').length;
	
	if(check == 0){
		if(product_payment == ''){
			$('#product_payment').addClass('border border-danger');
			return false;
		}else{
			$('#product_payment').removeClass('border border-danger')
		}
		
		if(group_id == ''){
			$('#group_id').addClass('border border-danger');
			return false;
		}else{
			$('#group_id').removeClass('border border-danger')
		}	


		
	}
	
    $.ajax({
           type: "POST",
           url: url,
           data: {
				documents: JSON.stringify(document_obj),
				shop_id: shop_id,
				input_summ: input_summ,
				type: 'add_finance',
				user_id: <?php echo $_SESSION['user_id']; ?>,
				orders_count: check,
				network: network,
				payer_payment_type: payer_payment_type,
				payer_payment_bank: payer_payment_bank,
				product_payment: product_payment,
				group_id: group_id
				
		   }, 
           success: function(data)

           {
             window.location.replace('/add_pr_finance.php?message=1&shop_id=' + shop_id + '');

			 //  $('#shop_id').removeClass('border border-danger');
			 //  $('#qr_id').removeClass('border border-danger');
			 //  $('.success_message').text(data);
			   //$('.modal_answere').click();
			//   window.location.replace("/shops.php");

			//  $('.alert').show()
			  

           }
		   
         });
});
	
	

</script>
</body>
</html>
