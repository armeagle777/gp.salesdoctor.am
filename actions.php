
<?php require 'api/db.php'; ?>

<?php

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

