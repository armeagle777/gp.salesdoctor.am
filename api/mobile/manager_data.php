<?php
include '../db.php';

$manager_id = mysqli_real_escape_string($con, $_GET['user_id']);
$total_summ = 0;
$shops_count = 0;
$visits_count = 0;
$today_summ = 0;
header('Content-Type: application/json');

$array_order = mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total, COUNT(DISTINCT(pr_orders_document.shop_id)) AS shop_counts,  manager.name AS manager_name FROM `pr_orders_document` LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN manager ON shops.static_manager = manager.id WHERE order_last_summ !='' 
  AND pr_orders_document.order_type = '1' 
  AND MONTH(document_date) = MONTH(CURRENT_DATE())
  AND YEAR(document_date) = YEAR(CURRENT_DATE())
  AND (pay_type = '1' or pay_type = '2' or pay_type = '3' or pay_type = '4')
  AND shops.static_manager = '$manager_id' GROUP by shops.static_manager");
$array_order = mysqli_fetch_assoc($array_order);

//new query
$array_visits_count = mysqli_query($con, "SELECT *, COUNT(shop_id) AS total_visits FROM `visits` WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) AND manager_id = '$manager_id' ");
$array_visits_count = mysqli_fetch_assoc($array_visits_count);

//new query
$array_todays_total_summ = mysqli_query($con, "SELECT *, SUM(order_summ) AS today_total_summ FROM `pr_orders_document` WHERE DATEDIFF(document_date, DATE_ADD(CURDATE(), INTERVAL 1 DAY)) = 0 AND manager_id = '$manager_id'");
$array_todays_total_summ = mysqli_fetch_assoc($array_todays_total_summ);


$array_return = mysqli_query($con, "SELECT *, SUM(order_last_summ) AS total, COUNT(DISTINCT(pr_orders_document.shop_id)) AS shop_counts,  manager.name AS manager_name FROM `pr_orders_document` LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN manager ON shops.static_manager = manager.id WHERE order_last_summ !='' 
  AND pr_orders_document.order_type = '2' 
  AND MONTH(document_date) = MONTH(CURRENT_DATE())
  AND YEAR(document_date) = YEAR(CURRENT_DATE())
  AND shops.static_manager = '$manager_id' GROUP by shops.static_manager;");
$array_return = mysqli_fetch_assoc($array_return);
if ($array_order) {
  $total_summ = round($array_order['total'] - $array_return['total'], 2);
  $shops_count = $array_order['shop_counts'];
  $visits_count = $array_visits_count['total_visits']; //new variable
  $today_summ = round($array_todays_total_summ['today_total_summ'], 2); //new variable
}
echo json_encode(array(
  'user_id' => $manager_id,
  'shops' => $shops_count,
  'visits' => $visits_count, //new variable
  'today_sum' => number_format($today_summ, 2, ',', ''), //new variable
  'sum' => number_format($total_summ, 2, ',', '')
)); die;
