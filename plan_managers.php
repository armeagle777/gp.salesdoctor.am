<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
<?php 

$manager_id = mysqli_real_escape_string($con, $_GET['manager_id']);
$visit_money_plan = mysqli_real_escape_string($con, $_GET['visit_money_plan']);
$audit_money_plan = mysqli_real_escape_string($con, $_GET['audit_money_plan']);
$tasks_money_plan = mysqli_real_escape_string($con, $_GET['tasks_money_plan']);
$order_summ_money_plan = mysqli_real_escape_string($con, $_GET['order_summ_money_plan']);
$shop_count_money_plan = mysqli_real_escape_string($con, $_GET['shop_count_money_plan']);
$shop_finance_money_plan = mysqli_real_escape_string($con, $_GET['shop_finance_money_plan']);

$selected_year = mysqli_real_escape_string($con, $_GET['selected_year']);
$selected_month = mysqli_real_escape_string($con, $_GET['selected_month']);


$array_manager = mysqli_fetch_array(mysqli_query($con, "SELECT  * FROM manager WHERE id = '$manager_id' "));


if(isset($_GET['selected_month'])){
	
	$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = " LIKE '$start_date%'";
	}
	
	if($selected_year != '0' and $selected_month != '0'){
		$query_date_range = 1;
	}
	
	
	$array_visits_count = mysqli_fetch_array(mysqli_query($con, "SELECT *, COUNT(*) as count FROM visits WHERE manager_id = '$manager_id' AND MONTH(date) = $selected_month AND YEAR(date) = $selected_year"));
		
		
	$array_audit = mysqli_query($con, "SELECT * FROM visit_images WHERE manager_id = '$manager_id' AND shop_id != '0' AND MONTH(date) = $selected_month AND YEAR(date) = $selected_year GROUP BY shop_id");
	$array_audit_count = mysqli_num_rows($array_audit);	
		
	$array_tasks_count = mysqli_fetch_array(mysqli_query($con, "SELECT *, COUNT(*) as count FROM tasks WHERE manager_id = '$manager_id' AND admin_task_ok = '1' AND MONTH(created_date) = $selected_month AND YEAR(created_date) = $selected_year"));
	
	
	
	$array_order_summ = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id WHERE shops.static_manager = '$manager_id' AND order_type = '1' AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4') AND MONTH(document_date) = $selected_month AND YEAR(document_date) = $selected_year"));
	

	$array_summ_veradardz = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id WHERE shops.static_manager = '$manager_id' AND order_type = '2' AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4') AND MONTH(document_date) = $selected_month AND YEAR(document_date) = $selected_year"));


	
	$array_shops = mysqli_query($con, "SELECT * FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id WHERE shops.static_manager = '$manager_id' AND order_type = '1' AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4') AND MONTH(document_date) = $selected_month AND YEAR(document_date) = $selected_year GROUP BY pr_orders_document.shop_id");
	$array_shop_count = mysqli_num_rows($array_shops);
	
	$array_finance_summ = mysqli_fetch_array(mysqli_query($con, "SELECT *, SUM(order_summ) AS total FROM pr_orders_finance LEFT JOIN shops ON pr_orders_finance.shop_id = shops.shop_id WHERE shops.static_manager = '$manager_id' AND MONTH(document_date) = $selected_month AND YEAR(document_date) = $selected_year"));
	
	
	

}



/*
SELECT *
FROM order_details
WHERE order_date >= CAST('2014-02-01' AS DATE)
AND order_date <= CAST('2014-02-28' AS DATE);
*/

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Հաշվարկ (<?php $manager_name = mysqli_fetch_array(mysqli_query($con, "SELECT name FROM manager WHERE id = '$manager_id'")); echo $manager_name['name']; ?>)</h1> 
          </div>
         <div class="col-sm-6 d-flex justify-content-end">
			<a href="/managers_finance.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
			   <form action="/plan_managers.php" id="statistics_form"> 
					<input type="hidden" name="manager_id" value="<?php echo $manager_id; ?>">
					<div class="form-row">
					
					
					
					 <div class="form-group col-md-4">
					  <label>Ժամանակահատված</label>
					  
					  
					  <div class="input-group">

						<select class="form-select form-control" aria-label="Default select example" name="selected_year">
						  <option value="0" <?php if($selected_year == '0'){echo "selected"; } ?>>Տարի</option>
						  <option value="2020" <?php if($selected_year == '2020'){echo "selected"; } ?>>2020</option>
						  <option value="2021" <?php if($selected_year == '2021'){echo "selected"; } ?>>2021</option>
						  <option value="2022" <?php if($selected_year == '2022'){echo "selected"; } ?>>2022</option>
						  <option value="2023" <?php if($selected_year == '2023'){echo "selected"; } ?>>2023</option>
						  <option value="2024" <?php if($selected_year == '2024'){echo "selected"; } ?>>2024</option>
						  <option value="2025" <?php if($selected_year == '2025'){echo "selected"; } ?>>2025</option>
						  <option value="2026" <?php if($selected_year == '2026'){echo "selected"; } ?>>2026</option>
						  <option value="2027" <?php if($selected_year == '2027'){echo "selected"; } ?>>2027</option>
						  <option value="2028" <?php if($selected_year == '2028'){echo "selected"; } ?>>2028</option>
						  <option value="2029" <?php if($selected_year == '2029'){echo "selected"; } ?>>2029</option>
						  <option value="2030" <?php if($selected_year == '2030'){echo "selected"; } ?>>2030</option>
						</select>




						<select class="form-select form-control" aria-label="Default select example" name="selected_month">
						  <option value="0" <?php if($selected_month == '0'){echo "selected"; } ?>>Ամիս</option>
						  <option value="1" <?php if($selected_month == '1'){echo "selected"; } ?>>Հունվար</option>
						  <option value="2" <?php if($selected_month == '2'){echo "selected"; } ?>>Փետրվար</option>
						  <option value="3" <?php if($selected_month == '3'){echo "selected"; } ?>>Մարտ</option>
						  <option value="4" <?php if($selected_month == '4'){echo "selected"; } ?>>Ապրիլ</option>
						  <option value="5" <?php if($selected_month == '5'){echo "selected"; } ?>>Մայիս</option>
						  <option value="6" <?php if($selected_month == '6'){echo "selected"; } ?>>Հունիս</option>
						  <option value="7" <?php if($selected_month == '7'){echo "selected"; } ?>>Հուլիս</option>
						  <option value="8" <?php if($selected_month == '8'){echo "selected"; } ?>>Օգոստոս</option>
						  <option value="9" <?php if($selected_month == '9'){echo "selected"; } ?>>Սեպտեմբեր</option>
						  <option value="10" <?php if($selected_month == '10'){echo "selected"; } ?>>Հոկտեմբեր</option>
						  <option value="11" <?php if($selected_month == '11'){echo "selected"; } ?>>Նոյեմբեր</option>
						  <option value="12" <?php if($selected_month == '12'){echo "selected"; } ?>>Դեկտեմբեր</option>
						</select>




					  </div>
					  <!-- /.input group -->
					</div>
					
					
					
					
					<div class="form-group col-md-8">
					  <label>Մեկնաբանություն</label>

					  <div class="input-group">
						<?php 
						
						echo $array_manager['plan_comment'];
						
						?>
						
					  </div>
					  <!-- /.input group -->
					</div>
					</div>
				
			  
                <table id="example1" class="table table-bordered table-striped modal_table">
                  <thead>
                  <tr>
                    <th>Տեսակ</th>
                    <th>Պլան</th>
					<th>Փաստացի</th>
					<th>Գումար</th>
					<th>Կորուստ</th>
					<th>Հաշվարկ</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				  <tr>
				  
                    <td>Այց</td>
                    <td><?php echo $array_manager['plan_visit']; ?> (100%)</td>
                    <td>
					
					<?php 
					
					if($array_visits_count['count'] > $array_manager['plan_visit']){
						$array_visits_count['count'] = $array_manager['plan_visit'];
						echo  '<span style="color: #f00;"> '.$array_visits_count['count'] .'</snan>';
					}else{
						echo $array_visits_count['count']; 
					}
					
					
					
					?> 
					
					
					
					(<?php echo $fackt_visit = round (( $array_visits_count['count'] / $array_manager['plan_visit'] ) * 100, 2); ?>%)</td>
                    <td>
					<input type="text" class="form-control" name="visit_money_plan" value="<?php if($visit_money_plan == ''){echo $array_manager['plan_visit_money'];}else{ echo $visit_money_plan; } ?>" style="width: 200px;"> 
						</td>
                    <td>
					
					<?php 
						echo round ($visit_money_lost = $visit_money_plan / 100 * (100 - $fackt_visit), 2);
					?>
						
					</td>
					
					<td>
					
					<?php 
						echo round ($visit_money = $visit_money_plan / 100 * $fackt_visit, 2);
					?>
						
					</td>
					
					</tr>
					
					
					
					<tr>
                    <td>Ցուցարություն</td>
                    <td><?php echo $array_manager['plan_audit']; ?> (100%)</td>
                    <td>
					
					
					<?php 
					
					if($array_audit_count > $array_manager['plan_audit']){
						$array_audit_count = $array_manager['plan_audit']; 
						echo "<span style='color: #f00;'>$array_audit_count</span>";
					}else{
						echo $array_audit_count;				
					}
					
					
					?> 
					
					
					
					(<?php echo $fackt_audit =  round (( $array_audit_count / $array_manager['plan_audit'] ) * 100, 2); ?>%)</td>
                    <td>
					<input type="text" class="form-control" name="audit_money_plan" value="<?php if($audit_money_plan == ''){echo $array_manager['plan_audit_money'];}else{ echo $audit_money_plan; } ?>" style="width: 200px;"> 
						</td>
                    <td>
					
					<?php 
						echo round ($audit_money_lost = $audit_money_plan / 100 * (100 - $fackt_audit), 2);
					?>
						
					</td>
					
					<td>
					
					<?php 
						echo round ($audit_money = $audit_money_plan / 100 * $fackt_audit, 2);
					?>
						
					</td>					
					</tr>
										
					
					
					<tr>
                    <td>Առաջադրանք</td>
                    <td><?php echo $array_manager['plan_task']; ?> (100%)</td>
                    <td>
					
					<?php 
					
					if($array_tasks_count['count'] > $array_manager['plan_task']){
						$array_tasks_count['count'] = $array_manager['plan_task'];
						echo '<span style="color: #f00;"> '.$array_tasks_count['count'] .'</snan>';
					}else{
						echo $array_tasks_count['count'];
					}
					
					?>




					(<?php echo $fackt_tasks =  round (( $array_tasks_count['count'] / $array_manager['plan_task'] ) * 100, 2); ?>%)</td>
                    <td>
					<input type="text" class="form-control" name="tasks_money_plan" value="<?php if($tasks_money_plan == ''){echo $array_manager['plan_task_money'];}else{ echo $tasks_money_plan; } ?>" style="width: 200px;"> 
						</td>
                    <td>
					
					<?php 
						echo round ($tasks_money_lost = $tasks_money_plan / 100 * (100 - $fackt_tasks), 2);
					?>
						
					</td>
					
					<td>
					
					<?php 
						echo round ($tasks_money = $tasks_money_plan / 100 * $fackt_tasks, 2);
					?>
						
					</td>					
					</tr>
	

					
					<tr>
                    <td>Խանութի քանակ</td>
                    <td><?php echo $array_manager['plan_shop_count']; ?> (100%)</td>
                    <td>
					
					<?php 
					
					if($array_shop_count > $array_manager['plan_shop_count']){
						
						$array_shop_count = $array_manager['plan_shop_count'];
						echo "<span style='color: #f00;'>$array_shop_count</span>";
						
					}else{
						echo $array_shop_count; 						
					}
					
					
					
					?>



					(<?php echo $fackt_shop_count =  round (( $array_shop_count / $array_manager['plan_shop_count'] ) * 100, 2); ?>%)</td>
                    <td>
					<input type="text" class="form-control" name="shop_count_money_plan" value="<?php if($shop_count_money_plan == ''){echo $array_manager['plan_shop_count_money'];}else{ echo $shop_count_money_plan; } ?>" style="width: 200px;"> 
						</td>
                    <td>
					
					<?php 
						echo round ($shop_count_money_lost = $shop_count_money_plan / 100 * (100 - $fackt_shop_count), 2);
					?>
						
					</td>
					
					<td>
					
					<?php 
						echo round ($shop_count_money = $shop_count_money_plan / 100 * $fackt_shop_count, 2);
					?>
						
					</td>					
					</tr>
	
							
					
					<tr>
                    <td>Պատվերի գումար</td>
                    <td><?php echo $array_manager['plan_order_summ']; ?> (100%)</td>
                    <td>
					
					<?php 
					
					
					$all_summ = $array_order_summ['total'] - $array_summ_veradardz['total'];
					
					if($all_summ > $array_manager['plan_order_summ']){
						$all_summ = $array_manager['plan_order_summ'];
						echo  "<span style='color: #f00;'> $all_summ </snan>";
					}else{
						echo $all_summ; 
					}
					
					
					
					?> 
					
					
					
					(<?php echo $fackt_order_summ =  round (( $all_summ / $array_manager['plan_order_summ'] ) * 100, 2); ?>%)</td>
                    <td>
					<input type="text" class="form-control" name="order_summ_money_plan" value="<?php if($order_summ_money_plan == ''){echo $array_manager['plan_order_summ_money'];}else{ echo $order_summ_money_plan; } ?>" style="width: 200px;"> 
						</td>
                    <td>
					
					<?php 
						echo round ($order_summ_money_lost = $order_summ_money_plan / 100 * (100 - $fackt_order_summ), 2);
					?>
						
					</td>
					
					<td>
					
					<?php 
						echo round ($order_summ_money = $order_summ_money_plan / 100 * $fackt_order_summ, 2);
					?>
						
					</td>					
					</tr>							

					
					
					
					
					
					<tr>
                    <td>Խանութի գումար</td>
                    <td><?php echo $array_manager['plan_shop_summ']; ?> (100%)</td>
                    <td>
					
					<?php

					if($array_finance_summ['total'] > $array_manager['plan_shop_summ']){
						$array_finance_summ['total'] = $array_manager['plan_shop_summ'];
						echo '<span style="color: #f00;"> '.$array_finance_summ['total'].'</snan>'; 
					}else{
						echo $array_finance_summ['total']; 
					}

					?> 
					
					
					
					
					(<?php echo $fackt_finance_summ =  round (( $array_finance_summ['total'] / $array_manager['plan_shop_summ'] ) * 100, 2); ?>%)</td>
                    <td>
					<input type="text" class="form-control" name="shop_finance_money_plan" value="<?php if($shop_finance_money_plan == ''){echo $array_manager['plan_shop_summ_money'];}else{ echo $shop_finance_money_plan; } ?>" style="width: 200px;"> 
						</td>
                    <td>
					
					<?php 
						echo round ($shop_summ_money_lost = $shop_finance_money_plan / 100 * (100 - $fackt_finance_summ), 2);
					?>
						
					</td>
					
					<td>
					
					<?php 
						echo round ($shop_summ_money = $shop_finance_money_plan / 100 * $fackt_finance_summ, 2);
					?>
						
					</td>					
					</tr>
							


					<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>

					<?php
						$all_plans_summ = $visit_money_plan + $audit_money_plan + $tasks_money_plan + $order_summ_money_plan + $shop_count_money_plan + $shop_finance_money_plan;
						
						echo round($all_plans_summ, 2);
						
					?>
					
					</td>
					<td>
						<span style="color: #f00">
					<?php
						$total_manager_summ_lost = $visit_money_lost + $audit_money_lost + $tasks_money_lost + $order_summ_money_lost + $shop_count_money_lost + $shop_summ_money_lost;
						 echo round($total_manager_summ_lost, 2);
					?>
					</span>
					</td>
					
					<td>					
					<b>
					<?php
						 $total_manager_summ = $visit_money + $audit_money + $tasks_money + $order_summ_money + $shop_count_money + $shop_summ_money;
						 echo round($total_manager_summ, 2);
					?>
					</b>
					</td>
						
					</tr>
				
					
					
							
                 
                  </tbody>
                  <tfoot>
                  <tr>
				  
                    <th></th>
                    <th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
                  </tr>
                  </tfoot>
                </table>
					<div class="form-row">
					 <div class="form-group col-md-2">
								<label for="login"> </label>
								<button type="submit" class="btn btn-success">Հաշվարկել</button>
					  </div>
				
					 <div class="form-group col-md-2" style="">
								<label for="login"> </label>
								<a href="/action_pr_expenses.php?action=add&from=salary&summ=<?php echo $total_manager_summ; ?>" class="btn btn-primary">Պահպանել</a>
					  </div>
					  </div>
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

<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>


<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->



<script>

 $('#reservation').daterangepicker({
	locale: {
      format: 'YYYY-MM-DD', 
	  firstDay: 1
    }
 });




	
	
</script>
</body>
</html>
