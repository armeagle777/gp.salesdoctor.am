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

$curr_warehouse_id = mysqli_real_escape_string($con, $_GET['warehouse_id']);


$manager_id_selected = mysqli_real_escape_string($con, $_GET['manager_select']);
$district_id_selected = mysqli_real_escape_string($con, $_GET['district_select']);

if($district_id_selected != 0 AND $district_id_selected != ''){
	$query_district_select = " AND shops.district = '$district_id_selected'";
}else{
	$query_district_select = '';
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
            <h1>Պարտքացուցակ</h1>
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
			  
				 <form action="/warehouse_orders.php" id="statistics_form" style="display: none;"> 
				  <div class="form-row">
				  
				 <div class="form-group col-md-3" style="display:none;">
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

		
				 
					  <div class="form-group col-md-2">
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
					 <th style="width:150px;">Գործողություն</th>

                    <th>Հ/Հ</th>
					<th>Խանութ</th>
					<th>Հասցե</th>
					<th  class="select-filter">Տարածք</th>
					<th  class="select-filter">Մենեջեր</th>
					<th>Հեռախոս</th>
					<th>ՀՎՀՀ</th>
					<th>Իրավաբանական անուն</th>

                    <th>Պարտք</th>
                    <th class="select-filter">Ցանց</th>
                    <th class="select-filter">Խումբ</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <?php 
					$query_shops_documents = mysqli_query($con, "SELECT sum(order_last_summ) AS shop_total, pr_orders_document.shop_id AS order_shop_id, shops.name, shops.address, shops.district, district.district_name, shops.static_manager, manager.login, shops.phone AS shop_phone, shops.hvhh, shops.law_name, network.network_name FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN manager ON manager.id = shops.static_manager LEFT JOIN network ON shops.network = network.id WHERE (pr_orders_document.order_type = 1 or pr_orders_document.order_type = 0) GROUP BY pr_orders_document.shop_id ");
										
					//$query_shops_documents = mysqli_query($con, "SELECT * FROM shops WHERE balance != '' ");
					while($shops_array = mysqli_fetch_array($query_shops_documents)):
					$shop_id = $shops_array['order_shop_id'];
					$name = $shops_array['name'];
					$address = $shops_array['address'];
					$balance = $shops_array['shop_total'];
					$law_name = $shops_array['law_name'];
					$district_name = $shops_array['district_name'];
					$static_manager = $shops_array['login'];
					$shop_phone = $shops_array['shop_phone'];
					$hvhh = $shops_array['hvhh'];
					$network_name = $shops_array['network_name'];

					$veraradz_array = mysqli_fetch_array(mysqli_query($con,"SELECT sum(order_last_summ) AS veradardz FROM pr_orders_document WHERE shop_id = '$shop_id' AND order_type = '2' AND order_status = '1' AND order_delivered = '1' "));
					
					$finance_array = mysqli_fetch_array(mysqli_query($con,"SELECT sum(order_summ) AS vcharvats FROM pr_orders_finance WHERE shop_id = '$shop_id' "));
									
					
				  ?>
				  
				  <tr> 
					<td>
					<a style="" href="/add_pr_finance_mobile.php?shop_id=<?php echo $shop_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fas fa-money-bill-wave"></i></a>
					
					<a style="" href="/finance_history_mobile.php?shop_id=<?php echo $shop_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fa fa-list" aria-hidden="true"></i></a>
					
					
					<a style="display: none;" href="/warehouse_exit.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0" title="Դիտել"><i class="fas fa-location-arrow"></i></i></a>
					</td>
					<td><?php echo $shop_id; ?></td>
					<td><?php echo $name; ?></td>
					<td><?php echo $address; ?></td>
					<td><?php echo $district_name; ?></td>
					<td><?php echo $static_manager; ?></td>
					<td><?php echo $shop_phone; ?></td>
					<td><?php echo $hvhh; ?></td>
					<td><?php echo $law_name; ?></td>
					
					<td><?php echo $balance - $veraradz_array['veradardz'] - $finance_array['vcharvats']; ?></td>
					<td><?php echo $network_name; ?></td>
					<td>
					
						<?php 
							$query_groups = mysqli_query($con, "SELECT * FROM shop_group LEFT JOIN group_to_shop ON shop_group.id = group_to_shop.group_id WHERE group_to_shop.shop_id = '$shop_id' ");
							$array_groups = mysqli_fetch_array($query_groups);
							echo $array_groups['group_name'];
						?>
					
					
					</td>

				  </tr>
				 
				 <?php endwhile; ?>
				 
                  </tbody>
                  <tfoot>
                  <tr>
				  
					<th style="width:150px;">Գործողություն</th>

                    <th>Հ/Հ</th>
					<th>Խանութ</th>
					<th>Հասցե</th>
					<th  class="select-filter">Տարածք</th>
					<th  class="select-filter">Մենեջեր</th>
					<th>Հեռախոս</th>
					<th>ՀՎՀՀ</th>
					<th>Իրավաբանական անուն</th>

                    <th>Պարտք</th>
                    <th class="select-filter">Ցանց</th>
                    <th class="select-filter">Խումբ</th>


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

// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});


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
      var table =  $("#example1").DataTable({
		
		   			"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 9 ).footer() ).html(
                ''+pageTotal +''
            );
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
    
		
		        dom: 'Bfrtip',
	    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
		"paging": false,
		"scrollX": true,
		"autoWidth": false,
        "buttons": [
			

			
			
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
