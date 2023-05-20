<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$finance_type_id = mysqli_real_escape_string($con, $_POST['finance_type_id']);
$direction = mysqli_real_escape_string($con, $_POST['direction']);

$employee = null; 
if(isset($_POST['employee']) ):
    $employee=mysqli_real_escape_string($con, $_POST['employee']);
endif;
$provider = null; 
if(isset($_POST['provider'])): 
    $provider=mysqli_real_escape_string($con, $_POST['provider']);
endif;
$shop = null; 
if(isset($_POST['shop'])): 
    $shop=mysqli_real_escape_string($con, $_POST['shop']);
endif;
$text = null; 
if(isset($_POST['text'])): 
    $text=mysqli_real_escape_string($con, $_POST['text']);
endif;

if($action == 'add'){
    try{
    	$query_insert = mysqli_query($con, "INSERT INTO pr_finance_type (direction_id,employee_id,shop_id,provider_id,text) VALUES ('$direction',NULLIF('$employee', ''),NULLIF('$shop', ''),NULLIF('$provider', ''),NULLIF('$text', ''))");
    	if($query_insert) {
    		echo "Հաջողությամբ ավելացված է";
    	}
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        // echo "Ստուգեք տվյալները";
    }
}

if($action == 'edit'){
    try{
    	$query_update = mysqli_query($con, "UPDATE pr_finance_type SET direction_id = '$direction',employee_id= NULLIF('$employee', ''), shop_id=NULLIF('$shop', ''),provider_id= NULLIF('$provider', ''),text=NULLIF('$text', '') WHERE id = '$finance_type_id' ");
    	if($query_update) {
    		echo "Հաջողությամբ թարմացված է";
    	}
        
    }catch (Exception $e){
        $message = $e->getMessage();
        echo header("HTTP/1.1 409 $message");
    }
}

if($action == 'delete_cient'){
	$finance_type_id = mysqli_real_escape_string($con, $_POST['finance_type_id']);
	$active_value=mysqli_real_escape_string($con, $_POST['activeValue']);
	$query_delete = mysqli_query($con, "UPDATE `pr_finance_type` SET `active`=$active_value WHERE id = $finance_type_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}
?>