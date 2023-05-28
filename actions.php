
<?php require 'api/db.php'; ?>

<?php

if(isset($_GET['cmd']) && $_GET['cmd'] === 'save_qr_edit'){
    try{
        $property_select = $_POST['property_select'];
        $shop_select = $_POST['shop_select'];
        $qr_id = $_POST['qr_id'];
        $qr_code = $_POST['qr_code'];

        $sql = "UPDATE pr_qr SET qr_shop=''  WHERE qr_shop='$shop_select' AND id !='$qr_id'";
        $query = mysqli_query($con, $sql);

        $sql = "UPDATE shops SET qr_id=''  WHERE qr_id='$qr_code'";
        $query = mysqli_query($con, $sql);

        $sql = "UPDATE shops SET qr_id='$qr_code'  WHERE id='$shop_select'";
        $query = mysqli_query($con, $sql);

        $sql = "UPDATE pr_qr SET qr_property=''  WHERE qr_property='$property_select' AND id !='$qr_id'";
        $query = mysqli_query($con, $sql);
    
        $sql = "UPDATE pr_qr SET qr_shop='$shop_select', qr_property='$property_select' WHERE id='$qr_id'";
        $query = mysqli_query($con, $sql);
    
        header('Location: /qrs.php');

    }catch(Exception $e){
        echo $e -> getMessage();
    }



}


if(isset($_GET['cmd']) && $_GET['cmd'] === 'qr_edit_modal'){
    
    $qr_id = $_POST['qr_id'];
    $qr_code = $_POST['qr_code'];
    $qr_property = $_POST['qr_property'];
    $qr_shop = $_POST['qr_shop'];
    $result="
                <div class='form-group col-md-6'>
                <input type='hidden' name='qr_id' value='$qr_id' />
                <input type='hidden' name='qr_code' value='$qr_code' />
                    <label for='owner_name'>Գույք</label>
                    <select name='property_select' id='property_select' class='form-control'>
                        <option value='0' hidden>Ընտրել</option>";

    $sql_properties = "SELECT * FROM pr_property1";
    $result_properties = mysqli_query($con,$sql_properties);
    while($row = mysqli_fetch_array($result_properties)){
      extract($row);
      $selected = $qr_property == $id ? " selected " : "";
      $result .= "<option value='$id' $selected >$property_1</option>";
    }
    $result .=   "</select>
                </div>
                <div class='form-group col-md-2'>
                    <label for='owner_name'>Խանութ</label>
                    <select name='shop_select' id='shop_select'  class='form-control'>
                        <option value='0'>Ընտրել</option>";

    $sql_shops = "SELECT id, name, address FROM shops";
    $result_shops = mysqli_query($con,$sql_shops);
    while($row = mysqli_fetch_array($result_shops)){
      extract($row);
      $selected = $qr_shop == $id ? " selected" : "";
      $result .= "<option value='$id' $selected >$name($address)</option>";
    }
    $result .= "</select></div><script>

    $('#shop_select').chosen()
    $('#property_select').chosen()
    
    </script>";

    echo $result;
}

if(isset($_GET['cmd']) && $_GET['cmd'] === 'verify_debt'){
    $sum_input = mysqli_real_escape_string($con, $_POST['sum_input']);
    $id_input = mysqli_real_escape_string($con, $_POST['id_input']);

    
    $sql = "UPDATE `marketing_payments` SET `is_verified`='1',`accepted_sum`='$sum_input'  WHERE id='$id_input'";
    
    $query_update = mysqli_query($con, $sql);

    if($query_update) {
    	header("Location: /marketing_payments.php");
    }else{
    	echo "Ստուգեք տվյալները";
    }

}

if(isset($_GET['cmd']) && $_GET['cmd'] === 'add_task_from_comment'){
    $visit_id = mysqli_real_escape_string($con, $_POST['visit_id']);
    $manager_id = mysqli_real_escape_string($con, $_POST['manager_id']);
    $task_text = mysqli_real_escape_string($con, $_POST['task_text']);
    
    $today = date("Y-m-d");
    
    $calendar_date = $today;
    
    $sql = "INSERT INTO tasks 
            (manager_id, task, created_date, calendar_date, visit_id) 
            VALUES ('$manager_id', '$task_text', '$today', '$calendar_date', '$visit_id')";
    
    $query_insert = mysqli_query($con, $sql);

    if($query_insert) {
    	echo "Հաջողությամբ ավելացված է";
    }else{
    	echo "Ստուգեք տվյալները";
    }

}

if(isset($_GET['cmd']) &&  $_GET['cmd'] === 'upload_ktron_image'){
    try{
        $target_dir = dirname(__FILE__) . "/uploads/ktronner";
        $order_document_id = mysqli_real_escape_string($con, $_POST['order_document_id']); 
    
        $filename = $_FILES['ktron_image']['name'];
        $fileNameArray = explode(".", $filename);
        $filename = time() . '-' . mt_rand() .'.' .end($fileNameArray);
    
        $full_path =$target_dir. "/" . $filename;
        move_uploaded_file($_FILES['ktron_image']['tmp_name'], $full_path);
        
        $update_query= "UPDATE pr_orders_document SET `ktron_image`='$filename' WHERE document_id=$order_document_id";
        mysqli_query($con, $update_query);
        
        $select_query = "SELECT document_id, ktron_image FROM pr_orders_document WHERE document_id = $order_document_id";
        $select_result = mysqli_query($con, $select_query);
        echo json_encode(mysqli_fetch_assoc($select_result));

    }catch(Exception $e){
        echo $e;
    }

}




?>

