<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
	$action = mysqli_real_escape_string($con, $_GET['action']);
	$finance_type_id =  mysqli_real_escape_string($con, $_GET['finance_type_id']);
	
	$selected_finance_type_id=null;
	$selected_direction = null;
	$selected_employee=null;
	$selected_provider=null;
	$selected_shop=null;
	$selected_text=null;
	
	if($action == 'edit'){		
		$query_data_finance_type = mysqli_query($con, "SELECT * FROM pr_finance_type WHERE id='$finance_type_id'");
		$array_finance_type = mysqli_fetch_array($query_data_finance_type);	
		extract($array_finance_type);
		
		$finance_type_name=$finance_type_name;
		$selected_finance_type_id=$id;
		$selected_direction = $direction_id;
    	$selected_employee=$employee_id;
    	$selected_provider=$provider_id;
    	$selected_shop=$shop_id;
    	$selected_text=$text;

	}

    //Creating directions select
    $direction_select = "<label for='direction'>Ուղղություն</label><select name='direction' id='direction' class='form-control' ><option value='' selected hidden>Ընտրել ծախսի ուղղություն</option>";
    $direction_query = "SELECT id, name AS DIRECTION_NAME FROM pr_expense_directions WHERE active=1";
    $result_direction = mysqli_query($con, $direction_query);
    while($row_direction = $result_direction -> fetch_assoc()){
        extract($row_direction);
        $mark_selected = isset($selected_direction) && $selected_direction == $id ? " selected" : "";
        $direction_select .= "<option $mark_selected value='$id'>$DIRECTION_NAME</option>";
    }
    $direction_select .="</select>";

    // Creating employee select
    $employee_select = "<label for='employee'>Աշխատակից</label><select name='employee' id='employee' class='form-control' ><option value=''>Ընտրել աշխատակից</option>";
    $employees_query = "SELECT id,name AS MANAGER_NAME  FROM manager";
    $result_employee = mysqli_query($con, $employees_query);
    while($row_employee = $result_employee -> fetch_assoc()){
        extract($row_employee);
        $mark_selected = isset($selected_employee) && $selected_employee == $id ? " selected" : "";
        $employee_select .= "<option $mark_selected value='$id'>$MANAGER_NAME</option>";
    }
    $employee_select .="</select>";


    //Creating providers select
    $provider_select = "<label for='provider'>Մատակարար</label><select name='provider' id='provider' class='form-control' ><option value=''>Ընտրել մատակարար</option>";
    $providers_query = "SELECT id,supplier_name  FROM pr_supplier";
    $result_provider = mysqli_query($con, $providers_query);
    while($row_provider = $result_provider -> fetch_assoc()){
        extract($row_provider);
        $mark_selected = isset($selected_provider) && $selected_provider == $id ? " selected" : "";    
        $provider_select .= "<option $mark_selected value='$id'>$supplier_name</option>";
    }
    $provider_select .="</select>";

    //Creating shops select
    $shop_select = "<label for='shop'>Խանութներ</label><select name='shop' id='shop' class='form-control' ><option value=''>Ընտրել խանութ</option>";
    $shops_query = "SELECT id,name AS SHOP_NAME, address AS SHOP_ADDRESS   FROM shops";
    $result_shop = mysqli_query($con, $shops_query);
    while($row_shop = $result_shop -> fetch_assoc()){
        extract($row_shop);
        $mark_selected = isset($selected_shop) && $selected_shop == $id ? " selected" : "";
        $shop_select .= "<option $mark_selected value='$id'>$SHOP_NAME ($SHOP_ADDRESS)</option>";
    }
    $shop_select .="</select>";

    $default_value= isset($selected_text) ? " value='$selected_text' " : "";
    $text_input =   "<label for='text'>Նկարագրություն</label><input $default_value class='form-control form-control-md' id='text' name='text' />";

    $page_title = $action == 'add' ? "Ավելացնել նպատակ" : "Խմբագրել նպատակ";	
    $button_text = $action == 'add' ? "Ավելացնել" : "Թարմացնել";	
?>





<style>
.chosen-container, .chosen-container-single,.chosen-single{
    height: 37px!important;  
}
</style>   
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $page_title; ?></h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <a href="/pr_finance_type.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
                            <div class=" col-12">
                                <label>Հին անուն</label>
                                <input type="text" readonly class="form-control" value="<?php echo $finance_type_name ; ?>" />
                            </div>
                            <form id="add_partner" action="api/add_pr_finance_type.php">
                                <div class="row">			
                                    <div class="form-group col-md-6"> 
                                        <?php echo $direction_select; ?>
                                        <!-- <input type="text" class="form-control" id="name" name="name" placeholder="Նպատակ" value="<?php echo $finance_type_name; ?>"> -->
                                    </div>
                                    <div class="form-group col-md-6" id="conditional_container">
                                        <?php
                                            if(isset($finance_type_id) && $selected_direction == 1){
                                                echo $employee_select;
                                            }else if(isset($finance_type_id) && $selected_direction == 2){
                                                echo $provider_select;
                                            }else if(isset($finance_type_id) && $selected_direction == 3){
                                                echo $shop_select;
                                            }else if(isset($finance_type_id)){
                                                echo $text_input;
                                            }
                                        ?>
                                    </div>
                                </div>
                                <input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
                                <input type="hidden" name="finance_type_id" id="finance_type_id" value="<?php echo $finance_type_id; ?>">
                                <button type="submit" class="btn btn-primary"><?php echo $button_text; ?></button>
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
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->

<!-- Choosen select script  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>

$("#employee").chosen()
$("#provider").chosen()
$("#shop").chosen()

$(document).on('change', '#direction', function(){
    $('#error_message').html('')
    let direction_id = $(this).val()
    let newVal 
    if(direction_id == 1){
        newVal = "<?php echo $employee_select  ?>"
    }else if(direction_id == 2){
        newVal= "<?php echo $provider_select  ?>"
    }else if(direction_id == 3){
        newVal= "<?php echo $shop_select  ?>"
    }else {
        newVal = "<?php echo $text_input  ?>"
    }
   
    $('#conditional_container').html(newVal)
    $("#employee").chosen()
    $("#provider").chosen()
    $("#shop").chosen()
})

$("#add_partner").submit(function(e) {
    e.preventDefault();
    $('#error_message').html('')
    var form = $(this);
    var url = form.attr('action');
	var direction = $('#direction').val();
	var employee = $('#employee').val();
	var provider = $('#provider').val();
	var shop = $('#shop').val();
	var text = $('#text').val();


	if (direction == ''){
		$('#error_message').html('Ուղղությունը պարտադիր է նշել։')
		return false;
	}
	if (direction == 1 && employee == ''){
	    $('#error_message').html('Աշխատակիցը պարտադիր է նշել։')
		return false;
	}
	if (direction == 2 && provider == ''){
		$('#error_message').html('Մատակարարը պարտադիր է նշել։')
		return false;
	}
	if (direction == 3 && shop == ''){
		$('#error_message').html('Խանութը պարտադիր է նշել։')
		return false;
	}
	if(direction && parseInt(direction) > 3 && text==''){
    	$('#error_message').html('Նկարագրությունը պարտադիր է նշել։')
		return false;
	}
	
    

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), 
           success: function(data)
           {
               console.log(data)
               $('#conditional_container').html('')
                // alert(data); 
                $('#error_message').html()
                // $('.success_message').text(data);
                //$('.alert').show()
                window.location.replace("/pr_finance_type.php");
           },
           error: function(err){
               alert(err.statusText)
           }
    });
});
   
</script>
</body>
</html>