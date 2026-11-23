<?

session_start();

require_once "../../../assets/template/layout.top.php";

  $do_no = $_REQUEST['do_no'];
  $app_val = $_REQUEST['val'];

	$checked_by = $_SESSION['user']['id'];
	$checked_at=date('Y-m-d H:i:s');


 if ($app_val==1) {
 $up_1='UPDATE sale_do_master SET  status = "CHECKED", checked_by="'.$checked_by.'", checked_at= "'.$checked_at.'"  WHERE do_no = "'.$do_no.'" ';
db_query($up_1);
} elseif ($app_val==2) {
 $up_sql1 = 'update sale_do_master set status="REJECTED", reject_by="'.$checked_by.'", reject_at= "'.$checked_at.'" WHERE do_no = "'.$do_no.'" ';
  db_query($up_sql1);
} 

echo 'Success!';

?>