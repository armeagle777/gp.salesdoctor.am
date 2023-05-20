<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$expenses_id =  mysqli_real_escape_string($con, $_GET['expenses_id']);
	

	
	$from = mysqli_real_escape_string($con, $_GET['from']);
	if($from == 'warehouse'){
		$expenses_summ =  mysqli_real_escape_string($con, $_GET['summ']);
		$expenses_group = mysqli_real_escape_string($con, $_GET['group']);
		$expenses_type = '24';
	}
	
	if($from == 'salary'){
		$expenses_summ =  mysqli_real_escape_string($con, $_GET['summ']);
	}
	
	
	if($action == 'edit'){
		$query="SELECT 
		            E.*, 
		            T.direction_id 
		        FROM pr_expenses E 
		        LEFT JOIN pr_finance_type T ON E.expenses_type = T.id  
		        WHERE E.id='$expenses_id'";
		$query_data_expenses = mysqli_query($con, $query);
		$array_expenses = mysqli_fetch_array($query_data_expenses);
		
		$expenses_type          = $array_expenses['expenses_type'];
		$expenses_date          = $array_expenses['expenses_date'];
		$expenses_comment       = $array_expenses['expenses_comment'];
		$expenses_summ          = $array_expenses['expenses_summ'];
		$expenses_bank          = $array_expenses['expenses_bank'];
		$expenses_payment_type  = $array_expenses['expenses_payment_type'];
		$expense_direction      = $array_expenses['direction_id'];
		$expenses_group         = $array_expenses['expenses_group'];
	}
	
	$page_title=$action == 'add' ? "Ավելացնել ծախս": "Խմբագրել ծախսը";
	$button_text = $action == 'add' ? "Ավելացնել" : "Թարմացնել";	
	
	
?>
<style>
    .chosen-container, .chosen-container-single,.chosen-single{
        height: 37px!important;  
        width:100%;
    }
</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $page_title ; ?></h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
				<a href="/pr_expenses.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
    				  <p class="success_message"></p>
    				</div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
        			<form id="add_partner" action="api/add_pr_expenses.php">
        				<div class="form-row">
        				    <div class="form-group col-md-6">
        						<label for="name">Ամսաթիվ</label>
        						<input type="text" class="form-control" id="expenses_date" name="expenses_date" placeholder="Ամսաթիվ" value="<?php echo $expenses_date; ?>">
        				    </div>
        				    <div class="form-group col-md-6">
        						<label for="bank">Գումար</label>
        							<input type="number" name="expenses_summ" value="<?php echo $expenses_summ; ?>" class="form-control" id="expenses_summ">
        				    </div>
        					<div class="form-group col-md-6">
        						<label for="payment_type">Վճարման տիպ</label>
        						<select name="payment_type" id="payment_type" class="form-control">
        							<option value="">Ընտրել</option>
        							<?php 
        							    $query="SELECT id AS PAYMENT_ID, payment_name  FROM pr_payment_type";
        							    $result = mysqli_query($con, $query);
        							    while($array_finance_type = mysqli_fetch_array($result)):
        							        extract($array_finance_type);
        					        ?>
        							    <option <?php if($expenses_payment_type == $PAYMENT_ID){ echo " selected";}  ?> value="<?php echo $PAYMENT_ID;  ?>"><?php echo  $payment_name; ?></option>
        							<?php 
        							    endwhile;
        							?>
        						</select>
        				    </div>
            				<div class="form-group col-md-6">
        						<label for="bank">Բանկ</label>
        						<select name="bank" id="bank" class="form-control">
        							<option value=""> Ընտրել </option>
        								<?php 
        									$bank_query = mysqli_query($con, "SELECT * FROM pr_bank ORDER by id DESC");
        									while ($array_bank = mysqli_fetch_array($bank_query)):
        									$bank_id = $array_bank['id'];
        									$bank_name = $array_bank['bank_name'];
        								?> 
        								 
        							<option value="<?php echo $bank_id; ?>" <?php if($expenses_bank == $bank_id ){ echo "selected"; } ?>> <?php echo $bank_name; ?></option>
        					
        							<?php endwhile; ?>
        						</select>
        				    </div>
        				    <div class="form-group col-md-6">
        					    <label for="exp_group">Խումբ</label>
        						<select name="exp_group" id="exp_group" class="form-control">
        							<option value=""> Ընտրել </option>
        								<?php 
        									$group_query = mysqli_query($con, "SELECT * FROM pr_groups ORDER by id DESC");
        									while ($array_group = mysqli_fetch_array($group_query)):
        									$group_id = $array_group['id'];
        									$group_name = $array_group['group_name'];
        								?> 
        								 
        							<option value="<?php echo $group_id; ?>" <?php if($expenses_group == $group_id ){ echo "selected"; } ?>> <?php echo $group_name; ?></option>
        					
        							<?php endwhile; ?>
        						</select>
        				    </div>
        				    <div class="form-group col-md-6">
            					<label for="bank">Մեկնաբանություն</label>
            					<input type="text" name="expenses_comment" value="<?php echo $expenses_comment; ?>" class="form-control" id="expenses_comment">
            				</div>
        				    <div class="form-group col-md-6">
        						<label for="direction">Ուղղություն</label>
        						<select name="direction" id="direction" class="form-control">
        							<option hidden value="">Ընտրել</option>
        							<?php 
        							    $query="SELECT id AS DIRECTION_ID, name AS DIRECTION_NAME  FROM pr_expense_directions WHERE active=1 AND id IN (SELECT direction_id FROM pr_finance_type WHERE active = 1)";
        							    $result = mysqli_query($con, $query);
        							    while($array_finance_type = mysqli_fetch_array($result)):
        							        extract($array_finance_type);
        					        ?>
        							    <option <?php if($expense_direction == $DIRECTION_ID){ echo " selected";}  ?> value="<?php echo $DIRECTION_ID;  ?>"><?php echo  $DIRECTION_NAME; ?></option>
        							<?php 
        							    endwhile;
        							?>
        						</select>
        				    </div>
        					<div class="form-group col-md-6">
                            	<label for='employee'>Նպատակ</label>
                            	<select name='finance_type' id='finance_type' class='form-control' >
                            	    <option value=''>Ընտրել նպատակ</option>
                                	    <?php
                                	    $direction_where_condition = $expense_direction ? " WHERE T.direction_id=$expense_direction" : "";
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
                                                	$direction_where_condition
                                                ORDER by 
                                                	T.id DESC";
                                                	
                                        	$query_result = mysqli_query($con, $query);
                                        	while ($array_finance_type = mysqli_fetch_array($query_result)):
                                    	    extract($array_finance_type);
                                    	    
                                    	    $row_value = '';
                                    	    if($DIRECTION_ID == 1){
                                    	        $row_value = $DIRECTION_NAME." ֊ ".$MANAGER_NAME;
                                    	    }else if($DIRECTION_ID == 2){
                                    	        $row_value = $DIRECTION_NAME." ֊ ".$supplier_name;
                                    	    }else if($DIRECTION_ID == 3){
                                    	        $row_value = $DIRECTION_NAME." ֊ ".$SHOP_NAME." ($SHOP_ADDRESS)";
                                    	    }else{
                                    	        $row_value = $DIRECTION_NAME." ֊ ".$text;
                                    	    }
                                	    ?>   
                                    <option <?php if($id == $expenses_type) echo " selected" ?> value='<?php echo $id ; ?>'><?php echo $row_value; ?></option>
                                        	  
                                	        <?php  
                                        endwhile;
                                            ?>
                        	    </select>
                            </div>  
                			<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
                			<input type="hidden" name="expenses_id" id="expenses_id" value="<?php echo $_GET['expenses_id']; ?>">
                			<div class="form-group col-md-12">
                			  <button type="submit" class="btn btn-primary"><?php echo $button_text ; ?></button>
                			</div>
        		        </div>
        		    </form>
        	        <p id="error_message" class="text-danger"></p>
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

<!-- DataTables -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
jQuery.event.special.touchstart = {
  setup: function( _, ns, handle ){
    if ( ns.includes("noPreventDefault") ) {
      this.addEventListener("touchstart", handle, { passive: false });
    } else {
      this.addEventListener("touchstart", handle, { passive: true });
    }
  }
};
jQuery.event.special.touchmove = {
  setup: function( _, ns, handle ){
    if ( ns.includes("noPreventDefault") ) {
      this.addEventListener("touchmove", handle, { passive: false });
    } else {
      this.addEventListener("touchmove", handle, { passive: true });
    }
  }
};
jQuery.event.special.mousewheel = {
  setup: function( _, ns, handle ){
    if ( ns.includes("noPreventDefault") ) {
      this.addEventListener("mousewheel", handle, { passive: false });
    } else {
      this.addEventListener("mousewheel", handle, { passive: true });
    }
  }
};


$("#finance_type").chosen()
$(".chosen-single").css('font-size','16px');

 
$('#direction').change( function(){
    $('#error_message').html('')
    let direction_id = $(this).val()
    $.ajax({
           type: "POST",
           url: "api/add_pr_expenses.php",
           data: {direction_id, action:'finance_type_filter'}, 
           success: function(data)
           {
				$('#finance_type').html(data).trigger('chosen:updated')
           },
           error: function(err){
               alert(err.statusText)
           }
    });
   
})
     
$("#add_partner").submit(function(e) {
    e.preventDefault(); 
    var form = $(this);
    var url = form.attr('action');
    
    var finance_type    = $('#finance_type').val()
	var payment_type    = $('#payment_type').val();
	var exp_group       = $('#exp_group').val();
	var expenses_summ   = $('#expenses_summ').val();
	var direction       = $('#direction').val();

    if (direction == ''){
		$('#error_message').html('Ուղղությունը պարտադիր է նշել։')
		return false;
	}
	
    if (finance_type == ''){
		$('#error_message').html('Նպատակը պարտադիր է նշել։')
		return false;
	}
	
	if(payment_type == '' || exp_group == '' || expenses_summ == ''){
	    $('#error_message').html('Թերի  լրացված դաշտեր' )
	    return false;
	}

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {
                $('#conditional_container').html('')              
    	        $('#error_message').html()
				window.location.replace("/pr_expenses.php");
           },
           error: function(err){
               alert(err.statusText)
           }
    });
});

$('#expenses_date').daterangepicker({
    //autoUpdateInput: false, 
	locale: {
		format: 'YYYY-MM-DD', 
		firstDay: 1,
		cancelLabel: 'Clear'
    },
    singleDatePicker: true,
    showDropdowns: true,
});

   
</script>
</body>
</html>