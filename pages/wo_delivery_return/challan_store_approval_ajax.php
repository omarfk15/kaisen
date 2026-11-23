<?

session_start();

require_once "../../../assets/template/layout.top.php";

   $return_no = $_REQUEST['return_no'];
   $app_val = $_REQUEST['val'];
   $status = 'Store Approved';

	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');


 if ($app_val==1) {
 $up_1='UPDATE sale_do_chalan_return SET status="'.$status.'", store_approve_by="'.$checked_by.'", store_approve_at= "'.$checked_at.'"
   WHERE return_no = "'.$return_no.'" ';
mysql_query($up_1);

echo 'Approved';
} elseif ($app_val==2) {
 $up_sql1 = 'update sale_do_chalan_return set status="REJECTED", reject_by="'.$checked_by.'", reject_at= "'.$checked_at.'" WHERE return_no = "'.$return_no.'" ';
  mysql_query($up_sql1);
  
echo 'Rejected';
} 

//echo 'Success!';

?>