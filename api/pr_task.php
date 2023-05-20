<?php
	include 'db.php';
	
	if(isset($_POST['action']) AND $_POST['action'] == 'change_date_created' ){
		
		$task_id = mysqli_real_escape_string($con, $_POST['task_id']);
		$task_date = mysqli_real_escape_string($con, $_POST['task_date']);
			
		$query_update_date = mysqli_query($con, "UPDATE tasks SET created_date = '$task_date' WHERE id = '$task_id' ");
		
	}	
	
	if(isset($_POST['action']) AND $_POST['action'] == 'change_status' ){
		
		$task_id = mysqli_real_escape_string($con, $_POST['task_id']);
		$task_val = mysqli_real_escape_string($con, $_POST['task_val']);
			
		if($task_val == 'on'){
			$status = '1';
		}else{
			$status = '0';
		}

		
		$query_update_date = mysqli_query($con, "UPDATE tasks SET admin_task_ok = '$status' WHERE id = '$task_id' ");
		
	}


?>