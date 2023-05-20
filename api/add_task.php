<?php 
include 'db.php';
$action = mysqli_real_escape_string($con, $_POST['action']);
$manager_id = mysqli_real_escape_string($con, $_POST['managers']);
$task = mysqli_real_escape_string($con, $_POST['task']);
$calendar_date = mysqli_real_escape_string($con, $_POST['calendar_date']);
$today = date("Y-m-d");
$yes = mysqli_real_escape_string($con, $_POST['yes']);


if($action == 'add'){
	$query_insert = mysqli_query($con, "INSERT INTO tasks (manager_id, task, created_date, calendar_date) VALUES ('$manager_id', '$task', '$today', '$calendar_date')");
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}


if($action == 'delete_cient'){
	$task_id = mysqli_real_escape_string($con, $_POST['task_id']);
	$query_delete = mysqli_query($con, "DELETE FROM tasks WHERE id = $task_id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}



if($action == 'edit'){
	$task_id = mysqli_real_escape_string($con, $_POST['task_id']);
	
	if($yes == 'on'){
		$yes = '1';
	}else {
		$yes = '0';
	}
	
	$query_update = mysqli_query($con, "UPDATE tasks SET manager_id = '$manager_id', task = '$task', admin_task_ok = '$yes', calendar_date = '$calendar_date' WHERE id = '$task_id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}


?>