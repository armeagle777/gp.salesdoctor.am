<?php
include 'db.php';

$calendar_comment = mysqli_real_escape_string($con, $_POST['calendar_comment']);
$comment_date = mysqli_real_escape_string($con, $_POST['comment_date']);
$comment_id = mysqli_real_escape_string($con, $_POST['comment_id']);
$area = mysqli_real_escape_string($con, $_POST['area']);


$action = mysqli_real_escape_string($con, $_POST['action']);

if($action == 'add_new'){
	$add_comment = mysqli_query($con, "INSERT INTO calendar_comments (calendar_comment, comment_date, area) VALUES ('$calendar_comment', '$comment_date', '$area') ");
}

if($action == 'delete'){
	$delete_comment = mysqli_query($con, "DELETE FROM calendar_comments WHERE id='$comment_id' ");

}

if($action == 'edit_comment'){
	$comment_text = mysqli_real_escape_string($con, $_POST['comment_text']);

	$delete_comment = mysqli_query($con, "UPDATE calendar_comments SET calendar_comment ='$comment_text' WHERE id = '$comment_id' ");
}



?>