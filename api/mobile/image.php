<?php
include '../db.php';
$target_dir = dirname(__FILE__) . "/upload/";
$manager_id = mysqli_real_escape_string($con, $_POST['manager_id']);
$shop_id = mysqli_real_escape_string($con, $_POST['shop_id']);
$visit_id = mysqli_real_escape_string($con, $_POST['visit_id']);
$photo = $_POST['photo'];
header('Content-Type: application/json');
$fileName = time() . '-' . mt_rand() . '.jpg';
function base64ToImage($base64_string, $output_file)
{
    $file = fopen($output_file, "wb");
    fwrite($file, base64_decode($base64_string));
    fclose($file);
    return $output_file;
}
base64ToImage($photo, $target_dir . $fileName);
mysqli_query($con, "INSERT INTO visit_images(manager_id, shop_id, visit_id, image)
    VALUES('$manager_id', '$shop_id', '$visit_id', '$fileName');");
$visit_image_query = mysqli_query($con, "SELECT *  FROM visit_images WHERE id=(SELECT LAST_INSERT_ID());");
echo json_encode(mysqli_fetch_assoc($visit_image_query));
mysqli_close($con);
exit;
