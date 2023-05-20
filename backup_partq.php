<?php

include 'api/db.php';

$document_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
$action = mysqli_real_escape_string($con, $_POST['action']);




$query_shops_documents = mysqli_query($con, "SELECT sum(order_last_summ) AS shop_total, pr_orders_document.shop_id AS order_shop_id, shops.name, shops.address, shops.district, shops.region, district.district_name, shops.static_manager, manager.login, shops.phone AS shop_phone, shops.hvhh, shops.law_name, network.network_name FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id LEFT JOIN district ON shops.district = district.id LEFT JOIN manager ON manager.id = shops.static_manager LEFT JOIN network ON shops.network = network.id WHERE (pr_orders_document.order_type = 1 or pr_orders_document.order_type = 0) GROUP BY pr_orders_document.shop_id ");
										

	
		$today = date("d-m-Y");   
		$file_name = "backups/$today-partqacucak.xlsx";

  require_once 'PHPExcel/Classes/PHPExcel.php';

  $phpexcel = new PHPExcel(); 
  $page = $phpexcel->setActiveSheetIndex(0); 
  $page->setCellValue("A1", "Հ/Հ"); 
  $page->setCellValue("B1", "Խանութ");
  $page->setCellValue("C1", "Հասցե");
  $page->setCellValue("D1", "Տարածք"); 
  $page->setCellValue("E1", "Մենեջեր");
  $page->setCellValue("F1", "Հեռախոս");
  $page->setCellValue("G1", "ՀՎՀՀ"); 
  $page->setCellValue("H1", "Իրավաբանական անուն");
  $page->setCellValue("I1", "Պարտք");
  $page->setCellValue("J1", "Ցանց");
  $page->setCellValue("K1", "Խումբ");

$s = 1;
while($shops_array=mysqli_fetch_array($query_shops_documents)){

			$shop_id = $shops_array['order_shop_id'];
			$name = $shops_array['name'];
			$address = $shops_array['address'];
			$balance = $shops_array['shop_total'];
			$law_name = $shops_array['law_name'];
			$district_name = $shops_array['district_name'];
			$static_manager = $shops_array['login'];
			$shop_phone = $shops_array['shop_phone'];
			$hvhh = $shops_array['hvhh'];
			$network_name = $shops_array['network_name'];

			$veraradz_array = mysqli_fetch_array(mysqli_query($con,"SELECT sum(order_last_summ) AS veradardz FROM pr_orders_document WHERE shop_id = '$shop_id' AND order_type = '2' AND order_status = '1'"));
			
			$finance_array = mysqli_fetch_array(mysqli_query($con,"SELECT sum(order_summ) AS vcharvats FROM pr_orders_finance WHERE shop_id = '$shop_id' "));

			$total_balance = $balance - $veraradz_array['veradardz'] - $finance_array['vcharvats']; 

			$query_groups = mysqli_query($con, "SELECT * FROM shop_group LEFT JOIN group_to_shop ON shop_group.id = group_to_shop.group_id WHERE group_to_shop.shop_id = '$shop_id' ");
			$array_groups = mysqli_fetch_array($query_groups);
			$group_name =  $array_groups['group_name'];

		$s++;		

		$page->setCellValue("A$s", $shop_id); 
		$page->setCellValue("B$s", $name);
		$page->setCellValue("C$s", $address);
		$page->setCellValue("D$s", $district_name);
		$page->setCellValue("E$s", $static_manager);
		$page->setCellValue("F$s", $shop_phone);
		$page->setCellValue("G$s", $hvhh);
		$page->setCellValue("H$s", $law_name);
		$page->setCellValue("I$s", $total_balance);
		$page->setCellValue("J$s", $network_name);
		$page->setCellValue("K$s", $group_name);

		
	
	

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