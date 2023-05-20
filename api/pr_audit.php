<?php 
include 'db.php';
if(isset($_POST['check_comment'])){
	
	$visit_id = mysqli_real_escape_string($con, $_POST['visit_id']);
	$visit_comment = mysqli_real_escape_string($con, $_POST['visit_comment']);
	
	$query_update = mysqli_query($con, "UPDATE visits SET comment = '$visit_comment' WHERE id = '$visit_id' ");


}



?>