<?php
session_start();

if($_SESSION['user_role'] == 1){
    header("Location: /pr_new_order.php ");
}else{
  header("Location: /pr_finance.php ");
}

?>