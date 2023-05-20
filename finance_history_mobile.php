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
            <h1>Խանութի հետ փոխհաշվարկ</h1>
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
			  
                <table id="example_0" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Դիտել</th>
                    <th>Փաստաթուղթ</th>
                    <th class="select-filter">Տեսակ</th>
                    <th class="select-filter">Ապրանքի խումբ</th>
                    <th>Գումար</th>
					<th>Ամսաթիվ</th>
                    <th class="select-filter">Վճարման տիպ</th>
                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
					$query = mysqli_query($con, "SELECT * FROM pr_orders_document LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id WHERE shop_id = $shop_id ");
					
					
					while($orders_array = mysqli_fetch_array($query)):
					
					
					
					$document_id = $orders_array['document_id'];
					$order_summ = $orders_array['order_last_summ'];
					$document_date = $orders_array['document_date'];
					$pay_type = $orders_array['payment_name'];
					$order_type = $orders_array['order_type'];
					$group_name = $orders_array['group_name'];
															
				 ?> 
				  
					<tr>
						<td><a href="/view_order.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i></a></td>
						<td><?php echo $document_id; ?></td>
						<td>
							<?php
							if($order_type == '1'){
								echo "Պատվեր";
							}if($order_type == '2'){
								echo "Վերադարձ";
							}if($order_type == '0'){
								echo "Հին պարտք";
							}
							?>
						<td><?php echo $group_name; ?></td>
						<td> 
						
						<?php
						if($order_type == '2'){
								echo "-";
						}
						echo $order_summ; ?>
						
						
						</td>
						<td><?php echo $document_date; ?></td>
						<td><?php echo $pay_type; ?></td>
					</tr>
				 <?php endwhile; ?>
				 
				 <?php
					$query = mysqli_query($con, "SELECT * FROM pr_orders_finance LEFT JOIN pr_payment_type ON pr_orders_finance.pay_type = pr_payment_type.id LEFT JOIN pr_groups ON pr_orders_finance.payed_product_group = pr_groups.id WHERE shop_id = $shop_id ");
					
					while($orders_array = mysqli_fetch_array($query)):
					
					$document_id = $orders_array['payed_document_id'];
					$order_summ = $orders_array['order_summ'];
					$document_date = $orders_array['document_date'];
					$pay_type = $orders_array['payment_name'];
					$group_name = $orders_array['group_name'];

				 ?>
				 
					<tr>
						<td><a href="/view_order.php?document_id=<?php echo $document_id; ?>" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i></a></td>
						<td><?php echo $document_id; ?></td>
						<td>Գումարի մուտք<td><?php echo $group_name; ?></td>
						<td>-<?php echo $order_summ; ?></td>
						<td><?php echo $document_date; ?></td>
						<td><?php echo $pay_type; ?></td>
					</tr>
				 <?php endwhile; ?> 
				 
				 
				 
				 
				 
				 
                  </tbody>
                  <tfoot>
                  <tr>
					<th></th>
					<th></th>
					<th class="select-filter"></th>
					<th class="select-filter"></th>
					<th></th>
					<th></th>
					<th class="select-filter"></th>
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



  $(function () {
    var table = $("#example_0").DataTable({

	   				"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 3;
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
    
		
		        dom: 'Bfrtip',
						"paging": false,

	    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
  
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
