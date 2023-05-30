<?php
include '../db.php';
$login = mysqli_real_escape_string($con, $_POST['login']);
$password = mysqli_real_escape_string($con, $_POST['password']);
header('Content-Type: application/json');

$password_hashed = hash('sha256', $password);
$login_query = mysqli_query($con, "SELECT id, login, email, phone, name, audit_active, client_id, active, has_order, canRate, canRecord, hasMic FROM manager WHERE login='$login' and password='$password_hashed'; ");
$manager = mysqli_fetch_assoc($login_query);
http_response_code(200);
echo json_encode(array('manager' => $manager));die;
