<?php

$servername = "91.236.136.156";
$username = "u310145_test";
$password = "u310145_test";
$db = "u310145_test";
// Create connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
mysqli_select_db($con, $db);
mysqli_set_charset($con, 'utf8');

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
