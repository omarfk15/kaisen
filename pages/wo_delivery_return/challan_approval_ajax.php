<?

session_start();

require_once "../../../assets/template/layout.top.php";

   $return_no = $_REQUEST['return_no'];
   $app_val = $_REQUEST['val'];
   $status = 'CHECKED';

	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');

 if ($app_val==1) {
 $up_1='UPDATE sale_do_chalan_return SET status="'.$status.'", checked_by="'.$checked_by.'", checked_at="'.$checked_at.'"
 WHERE return_no ="'.$return_no.'" ';
mysql_query($up_1);

 $up_2='UPDATE sale_do_chalan d, sale_do_chalan_return r SET d.total_unit=d.total_unit-r.total_unit WHERE d.id=r.order_no and r.return_no="'.$return_no.'" ';
mysql_query($up_2);

echo 'Approved';
} elseif ($app_val==2) {
 $up_sql1 = 'update sale_do_chalan_return set status="REJECTED", reject_by="'.$checked_by.'", reject_at= "'.$checked_at.'" WHERE return_no = "'.$return_no.'" ';
  mysql_query($up_sql1);
  
echo 'Rejected';
} 

//echo 'Success!';

?>

