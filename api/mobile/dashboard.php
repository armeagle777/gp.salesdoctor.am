<?php
$user_id=$_GET['user_id'];
$sql = "SELECT * FROM manager WHERE id=$user_id";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);
extract($row);

if($user_role == 1){
    header("Location: /pr_new_order.php ");
}else{
  header("Location: /pr_finance.php ");
}

?>