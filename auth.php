<?php

include 'api/db.php';
if (isset($_POST['login'])) {
  $login=mysqli_real_escape_string($con, $_POST['login']);
  $password=mysqli_real_escape_string($con, $_POST['password']);
  $password_hashed = hash('sha256', $password);

  $query = "SELECT * FROM users WHERE login='$login' AND password='$password_hashed'";
  $res = mysqli_query($con, $query) or trigger_error(mysql_error().$query);

  $query_client = "SELECT * FROM client WHERE login='$login' AND password='$password_hashed'";
  $res_client = mysqli_query($con, $query_client) or trigger_error(mysql_error().$query);

  $query_other = "SELECT * FROM manager WHERE login='$login' AND password='$password_hashed' AND active='on' ";
  $res_other = mysqli_query($con, $query_other) or trigger_error(mysql_error().$query);
  
  if ($row = mysqli_fetch_assoc($res)) {
    session_start();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['image'] = $row['image'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	header("Location: /dashboard.php ");

  }elseif($row_client = mysqli_fetch_assoc($res_client)){
	  session_start();
	  $_SESSION['user_id'] = $row_client['id'];
	  $_SESSION['user_name'] = $row_client['name'];
      $_SESSION['role'] = $row_client['role'];
	  header("Location: /statistics.php ");

  }elseif($row_other = mysqli_fetch_assoc($res_other)){
	  session_start();
	  $_SESSION['user_id'] = $row_other['id'];
	  $_SESSION['user_name'] = $row_other['name'];
     // $_SESSION['role'] = $row_other['role'];
      $_SESSION['user_role'] = $row_other['user_role'];
	  if($_SESSION['user_role'] == 1){
			header("Location: /pr_new_order.php ");
	  }else{
		  header("Location: /pr_finance.php ");
	  }

  }else{
	  	  header("Location: /index.php?action=error ");
	  
  }
  
}

?>
