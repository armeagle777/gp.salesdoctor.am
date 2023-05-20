<?php
	include 'header.php'; 
	include 'api/db.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Գլխավոր</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">


          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
				
				<?php
					$query_shops_count = mysqli_query($con, "SELECT name FROM shops");
					$rows_shops = mysqli_num_rows($query_shops_count);
					echo $rows_shops;
				?>
				
				
				</h3>

                <p>Խանութներ</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="/shops.php" class="small-box-footer">Ավելին <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
				<?php
					$query_clients_count = mysqli_query($con, "SELECT login FROM client");
					$rows_clients = mysqli_num_rows($query_clients_count);
					echo $rows_clients;
				?>
				</h3>

                <p>Գործընկերներ</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/partners.php" class="small-box-footer">Ավելին <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
				
				<?php
					$query_managers_count = mysqli_query($con, "SELECT name FROM manager");
					$rows_managers = mysqli_num_rows($query_managers_count);
					echo $rows_managers;
				?>
				
				</h3>

                <p>Մենեջերներ</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="/managers.php" class="small-box-footer">Ավելին <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
				<?php
					$query_visit_count = mysqli_query($con, "SELECT id FROM visits");
					$rows_visits = mysqli_num_rows($query_visit_count);
					echo $rows_visits;
				?></h3>

                <p>QR սքան</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="/statistics.php" class="small-box-footer">Ավելին <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Վիճակագրություն
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Վաճառք և մուտքեր</a>
                    </li>

                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                  </div>  
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

         
            
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable" style="display:none;">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
           
            
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->


       
	   
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include 'footer.php'; ?>


<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<?php


$jan = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jan FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 1"));
$feb = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS feb FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 2"));
$march = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS march FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 3"));
$apr = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS apr FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 4"));
$may = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS may FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 5"));
$jun = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jun FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 6"));
$jul = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jul FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 7"));
$aug = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS aug FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 8"));
$sep = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS sep FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 9"));
$oct = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS oct FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 10"));
$nov = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS nov FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 11"));
$dec = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS decem FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 12"));


$jan2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jan FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 1 AND pay_type !=5 AND pay_type !=6"));
$feb2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS feb FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 2 AND pay_type !=5 AND pay_type !=6"));
$march2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS march FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 3 AND pay_type !=5 AND pay_type !=6"));
$apr2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS apr FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 4 AND pay_type !=5 AND pay_type !=6"));
$may2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS may FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 5 AND pay_type !=5 AND pay_type !=6"));
$jun2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jun FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 6 AND pay_type !=5 AND pay_type !=6"));
$jul2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jul FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 7 AND pay_type !=5 AND pay_type !=6"));
$aug2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS aug FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 8 AND pay_type !=5 AND pay_type !=6"));
$sep2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS sep FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 9 AND pay_type !=5 AND pay_type !=6"));
$oct2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS oct FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 10 AND pay_type !=5 AND pay_type !=6"));
$nov2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS nov FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 11 AND pay_type !=5 AND pay_type !=6"));
$dec2 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS decem FROM pr_orders_document WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 12 AND pay_type !=5 AND pay_type !=6"));


$jan1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jan FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 1"));
$feb1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS feb FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 2"));
$march1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS march FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 3"));
$apr1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS apr FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 4"));
$may1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS may FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 5"));
$jun1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jun FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 6"));
$jul1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS jul FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 7"));
$aug1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS aug FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 8"));
$sep1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS sep FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 9"));
$oct1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS oct FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 10"));
$nov1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS nov FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 11"));
$dec1 = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(order_summ) AS decem FROM pr_orders_finance WHERE YEAR(`document_date`) = YEAR(CURDATE()) AND MONTH(`document_date`) = 12"));

if($jan['jan'] == ''){$jan['jan'] = 0; }
if($feb['feb'] == ''){$feb['feb'] = 0; }
if($march['march'] == ''){$march['march'] = 0; }
if($apr['apr'] == ''){$apr['apr'] = 0; }
if($may['may'] == ''){$may['may'] = 0; }
if($jun['jun'] == ''){$jun['jun'] = 0; }
if($jul['jul'] == ''){$jul['jul'] = 0; }
if($aug['aug'] == ''){$aug['aug'] = 0; }
if($sep['sep'] == ''){$sep['sep'] = 0; }
if($oct['oct'] == ''){$oct['oct'] = 0; }
if($nov['nov'] == ''){$nov['nov'] = 0; }
if($dec['dec'] == ''){$dec['dec'] = 0; }


if($jan1['jan'] == ''){$jan1['jan'] = 0; }
if($feb1['feb'] == ''){$feb1['feb'] = 0; }
if($march1['march'] == ''){$march1['march'] = 0; }
if($apr1['apr'] == ''){$apr1['apr'] = 0; }
if($may1['may'] == ''){$may1['may'] = 0; }
if($jun1['jun'] == ''){$jun1['jun'] = 0; }
if($jul1['jul'] == ''){$jul1['jul'] = 0; }
if($aug1['aug'] == ''){$aug1['aug'] = 0; }
if($sep1['sep'] == ''){$sep1['sep'] = 0; }
if($oct1['oct'] == ''){$oct1['oct'] = 0; }
if($nov1['nov'] == ''){$nov1['nov'] = 0; }
if($dec1['dec'] == ''){$dec1['dec'] = 0; }

if($jan2['jan'] == ''){$jan2['jan'] = 0; }
if($feb2['feb'] == ''){$feb2['feb'] = 0; }
if($march2['march'] == ''){$march2['march'] = 0; }
if($apr2['apr'] == ''){$apr2['apr'] = 0; }
if($may2['may'] == ''){$may2['may'] = 0; }
if($jun2['jun'] == ''){$jun2['jun'] = 0; }
if($jul2['jul'] == ''){$jul2['jul'] = 0; }
if($aug2['aug'] == ''){$aug2['aug'] = 0; }
if($sep2['sep'] == ''){$sep2['sep'] = 0; }
if($oct2['oct'] == ''){$oct2['oct'] = 0; }
if($nov2['nov'] == ''){$nov2['nov'] = 0; }
if($dec2['dec'] == ''){$dec2['dec'] = 0; }

?>

<script type="text/javascript">

  /* Chart.js Charts */
  // Sales chart
  var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
  //$('#revenue-chart').get(0).getContext('2d');

  var salesChartData = {
    labels  : ['Հունվար', 'Փետրվար', 'Մարտ', 'Ապրիլ', 'Մայիս', 'Հունիս', 'Հուլիս', 'Օգոստոս', 'Սեպտեմբեր', 'Հոկտեմբեր',  'Նոյեմբեր', 'Դեկտեմբեր'],
    datasets: [
      {
        label               : 'Digital Goods',
        backgroundColor     : 'rgba(0,128,0,0.6)', 
        borderColor         : 'rgba(0,128,0,0.6)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
		
		  data                : [<?php echo $jan1['jan']; ?>, <?php echo $feb1['feb']; ?>, <?php echo $march1['march']; ?>, <?php echo $apr1['apr']; ?>, <?php echo $may1['may']; ?>, <?php echo $jun1['jun']; ?>, <?php echo $jul1['jul']; ?>, <?php echo $aug1['aug']; ?>, <?php echo $sep1['sep']; ?>, <?php echo $oct1['oct']; ?>, <?php echo $nov1['nov']; ?>, <?php echo $dec1['decem']; ?>]
       
      },
      {
        label               : 'Electronics',
        backgroundColor     : 'rgba(210, 214, 222, 0.6)',
        borderColor         : 'rgba(210, 214, 222, 0.6)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 0.6)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
		
		 data                : [<?php echo $jan['jan']; ?>, <?php echo $feb['feb']; ?>, <?php echo $march['march']; ?>, <?php echo $apr['apr']; ?>, <?php echo $may['may']; ?>, <?php echo $jun['jun']; ?>, <?php echo $jul['jul']; ?>, <?php echo $aug['aug']; ?>, <?php echo $sep['sep']; ?>, <?php echo $oct['oct']; ?>, <?php echo $nov['nov']; ?>, <?php echo $dec['decem']; ?>]
      
      },
	  
	  {
        label               : 'Electronics1',
        backgroundColor     : 'rgba(0, 123, 255, 1)',
        borderColor         : 'rgba(0, 123, 255, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
		
		 data                : [<?php echo $jan2['jan']; ?>, <?php echo $feb2['feb']; ?>, <?php echo $march2['march']; ?>, <?php echo $apr2['apr']; ?>, <?php echo $may2['may']; ?>, <?php echo $jun2['jun']; ?>, <?php echo $jul2['jul']; ?>, <?php echo $aug2['aug']; ?>, <?php echo $sep2['sep']; ?>, <?php echo $oct2['oct']; ?>, <?php echo $nov2['nov']; ?>, <?php echo $dec2['decem']; ?>]
      
      },
    ]
  }

  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines : {
          display : false,
        }
      }],
      yAxes: [{
        gridLines : {
          display : false,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas, { 
      type: 'line', 
      data: salesChartData, 
      options: salesChartOptions
    }
  )



</script>

</body>
</html>

