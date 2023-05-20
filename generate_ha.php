<?php

include 'api/db.php';

$document_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
$action = mysqli_real_escape_string($con, $_POST['action']);

if($action == 'generate'){

	$query1 = mysqli_query($con, "SELECT * FROM pr_orders LEFT JOIN pr_products ON pr_orders.product_id = pr_products.id WHERE document_id = '$document_id' ");

	$query_shop = mysqli_query($con, "SELECT * FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN pr_groups ON pr_orders_document.product_group = pr_groups.id LEFT JOIN pr_payment_type ON pr_orders_document.pay_type = pr_payment_type.id WHERE document_id = '$document_id' ");

	$shop_array = mysqli_fetch_array($query_shop);

	$hvhh = $shop_array['hvhh'];
	$address = $shop_array['address'];
	$name = $shop_array['name'];
	$date = $shop_array['document_date'];
	$total = $shop_array['order_last_summ'] - ($shop_array['order_last_summ'] / 6);
	$product_group = $shop_array['group_name'];
	$payment_name = $shop_array['payment_name'];
	$order_type = $shop_array['order_type'];

	if($order_type == '2'){

		$file_name = "factures/veradardz-$hvhh-$address-$name-$date-$total-$payment_name-$product_group.xlsx";

	}else{
		$file_name = "factures/$hvhh-$address-$name-$date-$total-$payment_name-$product_group.xlsx";

	}

	$file_name = str_replace(" ", "-", $file_name);

  require_once 'PHPExcel/Classes/PHPExcel.php';

  $phpexcel = new PHPExcel();
  $page = $phpexcel->setActiveSheetIndex(0);
  $page->setCellValue("A1", "1CKOD");
  $page->setCellValue("B1", "QANAK");
  $page->setCellValue("C1", "GIN");

$s = 1;
while($row=mysqli_fetch_array($query1)){
	if($row['product_count_warehouse'] !=0){
		$product_last_cost = $row['product_last_cost'] - ($row['product_last_cost'] / 6);
		$s++;

		$page->setCellValue("A$s", $row['id2']);
		$page->setCellValue("B$s", $row['product_count_warehouse']);
		$page->setCellValue("C$s", $product_last_cost);


	}


}
  $page->setTitle("Example");
  $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
  $objWriter->save("$file_name");

if($order_type == '2'){
	$file_name_send = "veradardz-$hvhh-$address-$name-$date-$total-$payment_name-$product_group.xlsx";
}else{
	$file_name_send = "$hvhh-$address-$name-$date-$total-$payment_name-$product_group.xlsx";
}
$file_name_send = str_replace(" ", "-", $file_name_send);

	$path = "/var/www/u310145/data/www/salesdoctor.am/public/";

	$file = $path.$file_name;

	$array_ha = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'ha_email' "));
	$array_ha2 = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM configs WHERE param = 'ha_email2' "));

	$mailto = $array_ha['param_value'];
	$mailto2 = $array_ha2['param_value'];

//    $mailto = 'nargevorgyan@gmail.com';
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



	$query_update_document = mysqli_query($con, "UPDATE pr_orders_document SET ha_sended = '1' WHERE document_id = '$document_id'");
}





?>
