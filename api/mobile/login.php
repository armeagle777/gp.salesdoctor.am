<?php
$SERVERS = array(
    'api' => 'http://gp.salesdoctor.am/api/mobile/',
    // 'api' => 'http://salesdoctor.am/api/mobile/',
    'other' => array(
        'http://gp.salesdoctor.am/api/mobile/',
        'http://1.salesdoctor.am/api/mobile/',
        'http://2.salesdoctor.am/api/mobile/',
        'http://3.salesdoctor.am/api/mobile/',
        'http://rvr.salesdoctor.am/api/mobile/',
        'http://pb.salesdoctor.am/api/mobile/',
        'http://netta.salesdoctor.am/api/mobile/',
        'http://as.salesdoctor.am/api/mobile/',
        'http://anira.salesdoctor.am/api/mobile/',
        'http://pobeda.salesdoctor.am/api/mobile/',
        'http://anika.salesdoctor.am/api/mobile/',
        'http://brothers.salesdoctor.am/api/mobile/',
        'http://yeremyan.salesdoctor.am/api/mobile/'
    )
);
include '../db.php';
$login = mysqli_real_escape_string($con, $_POST['login']);
$password = mysqli_real_escape_string($con, $_POST['password']);
header('Content-Type: application/json');

function login($url, $login, $password) {
    $data = array(
        "login" => $login,
        "password" => $password
    );
    $data_string = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url .'login.php');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 


    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result);
    return $result;
}

$password_hashed = hash('sha256', $password);
$login_query = mysqli_query($con, "SELECT id, login, email, phone, name, audit_active, client_id, active, has_order,canRate,hasMic,canRecord FROM manager WHERE login='$login' and password='$password_hashed'; ");
$manager = mysqli_fetch_assoc($login_query);
if (!$manager) {
    foreach($SERVERS['other'] as $url) {
        $res = login($url, $login, $password);
        if ($res->manager) {
            $res->manager->api = $url;
            if ($res->manager->active != 'on')  {
                http_response_code(400);
                echo json_encode(array(
                    'message' => 'user_not_active'
                ));die;
            }
            echo json_encode($res->manager); die;
            break;
        }
    }
    http_response_code(404);
    $response['message'] = 'user_not_found';
} else if ($manager['active'] != 'on') {
    http_response_code(400);
    $response['message'] = 'user_not_active';
} else {
    $manager['api'] = $SERVERS['api'];
    http_response_code(200);
    $response = $manager;
}
echo json_encode($response);
