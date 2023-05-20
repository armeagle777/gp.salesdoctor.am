<?php

include 'api/db.php';

$document_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
$action = mysqli_real_escape_string($con, $_POST['action']);


$query_shops_documents = mysqli_query($con, "SELECT * FROM `pr_warehouse_products` LEFT JOIN pr_products ON pr_warehouse_products.product_id = pr_products.id LEFT JOIN pr_warehouse ON pr_warehouse_products.warehouse_id = pr_warehouse.id LEFT JOIN pr_groups ON pr_warehouse_products.warehouse_product_group = pr_groups.id ");

										

	
		$today = date("d-m-Y");   
		$file_name = "backups/$today-mnacord.xlsx";

  require_once 'PHPExcel/Classes/PHPExcel.php';

  $phpexcel = new PHPExcel(); 
  $page = $phpexcel->setActiveSheetIndex(0); 
  $page->setCellValue("A1", "Պահեստ"); 
  $page->setCellValue("B1", "Խումբ");
  $page->setCellValue("C1", "Հ/Հ");
  $page->setCellValue("D1", "Ապրանք"); 
  $page->setCellValue("E1", "Գին");
  $page->setCellValue("F1", "Քանակ");
  $page->setCellValue("G1", "Ընդհանուր"); 

$s = 1;
while($shops_array=mysqli_fetch_array($query_shops_documents)){

		$total_product_cost = $shops_array['product_count'] * $shops_array['sale_price'];

		$s++;		

		$page->setCellValue("A$s", $shops_array['warehouse_name']); 
		$page->setCellValue("B$s", $shops_array['group_name']);
		$page->setCellValue("C$s", $shops_array['id2']);
		$page->setCellValue("D$s", $shops_array['name']);
		$page->setCellValue("E$s", $shops_array['sale_price']);
		$page->setCellValue("F$s", $shops_array['product_count']);
		$page->setCellValue("G$s", $total_product_cost);	

} 
  $page->setTitle("Example"); 
  $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
  $objWriter->save("$file_name");

	$file_name_send = $file_name;

	$path = "/var/www/u310145/data/www/salesdoctor.am/";

	$file = $path.$file_name;
	
	$array_ha = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'back_email' "));
	
	$mailto = $array_ha['param_value'];

	    $subject = 'SalesDoctor';
    $message = "$file_name_send";

    $content = file_get_contents($file);
    $content = chunk_split(base64_encode($content));

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers = "From: SalesDoctor <info@salesdoctor.am>" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;

    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $file_name_send . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment; filename=$file_name_send" . $eol;
    $body .= $eol . $content . $eol . $eol;
    $body .= "--" . $separator . "--";

    //SEND Mail
	
	if($mailto2 ==''){
		if (mail($mailto, $subject, $body, $headers)) {
			echo "ok"; // or use booleans here
		} else {
			echo "mail send ... ERROR!";
			print_r( error_get_last() );
		}
	}else{
		if (mail($mailto, $subject, $body, $headers) AND mail($mailto2, $subject, $body, $headers)) {
			echo "ok"; // or use booleans here
		} else {
			echo "mail send ... ERROR!";
			print_r( error_get_last() );
		}
	}






?>