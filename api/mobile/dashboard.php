<?php
$user_id=mysqli_real_escape_string($_GET['user_id'] );
echo $user_id;
// session_start();

// if($_SESSION['user_role'] == 1){
//     header("Location: /pr_new_order.php ");
// }else{
//   header("Location: /pr_finance.php ");
// }

?>