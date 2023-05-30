<?php 
include 'db.php';

$action = mysqli_real_escape_string($con, $_POST['action']);
$name = mysqli_real_escape_string($con, $_POST['name']);



if($action == 'add'){
	$query_insert = mysqli_query($con, "INSERT INTO as_classifications (name) VALUES ('$name')");
	if($query_insert) {
		echo "Հաջողությամբ ավելացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'edit'){
    $id = mysqli_real_escape_string($con, $_POST['id']);
	$query_update = mysqli_query($con, "UPDATE as_classifications SET name = '$name' WHERE id = '$id' ");
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}

if($action == 'delete'){
	$id = mysqli_real_escape_string($con, $_POST['id']);
	$query_delete = mysqli_query($con, "DELETE FROM as_classifications WHERE id = $id");
	if($query_delete) {
		echo "Հաջողությամբ ջնջված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
}
?>