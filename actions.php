
<?php require 'api/db.php'; ?>

<?php

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

