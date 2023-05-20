<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$expenses_id = mysqli_real_escape_string($con, $_POST['expenses_id']);

$expenses_type = mysqli_real_escape_string($con, $_POST['finance_type']);
$expenses_date = mysqli_real_escape_string($con, $_POST['expenses_date']);
$expenses_comment = mysqli_real_escape_string($con, $_POST['expenses_comment']);
$expenses_summ = mysqli_real_escape_string($con, $_POST['expenses_summ']);
$expenses_bank = mysqli_real_escape_string($con, $_POST['bank']);
$expenses_payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);
$expenses_group = mysqli_real_escape_string($con, $_POST['exp_group']);

if($action == 'add'){
	$query_insert = mysqli_query($con, "INSERT INTO pr_expenses (expenses_type, expenses_date, expenses_comment, expenses_summ, expenses_bank, expenses_payment_type, expenses_group) VALUES ('$expenses_type', '$expenses_date', '$expenses_comment', '$expenses_summ', '$expenses_bank', '$expenses_payment_type', '$expenses_group')");
	
	if($expenses_type == '6'){
		mysqli_query($con, "INSERT INTO custom_expenses (expenses_name, expenses_category, expenses_sum, expenses_type) VALUES ('Աշխատավարձ', '5', '$expenses_summ', '1') ");
	}
		
	
	
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'edit'){
	$expenses_id = mysqli_real_escape_string($con, $_POST['expenses_id']);
	$query_update = mysqli_query($con, "UPDATE pr_expenses SET expenses_type = '$expenses_type', expenses_date = '$expenses_date', expenses_comment = '$expenses_comment', expenses_summ = '$expenses_summ', expenses_bank = '$expenses_bank', expenses_payment_type = '$expenses_payment_type',  expenses_group = '$expenses_group'  WHERE id = '$expenses_id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete_cient'){
	$expenses_id = mysqli_real_escape_string($con, $_POST['expenses_id']);
	$query_delete = mysqli_query($con, "DELETE FROM pr_expenses WHERE id = $expenses_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}


if($action === 'finance_type_filter'){
    $direction_id =  mysqli_real_escape_string($con, $_POST['direction_id']);
    $result= "<option value=''>Ընտրել նպատակ</option>";
    
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
	WHERE T.active=1 AND T.direction_id=$direction_id
    ORDER by 
    	T.id DESC";
    	
	$query_result = mysqli_query($con, $query);
	while ($array_finance_type = mysqli_fetch_array($query_result)):
	    extract($array_finance_type);
	    
	    $row_value = '';
	    if($DIRECTION_ID == 1){
	        $row_value = $MANAGER_NAME;
	    }else if($DIRECTION_ID == 2){
	        $row_value = $supplier_name;
	    }else if($DIRECTION_ID == 3){
	        $row_value = $SHOP_NAME." ($SHOP_ADDRESS)";
	    }else{
	        $row_value = $text;
	    }
	    
	    $result .= "<option value='$id'>$row_value</option>";
	    
    endwhile;
    
    echo $result;
}

?>