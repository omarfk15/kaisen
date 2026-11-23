<?

session_start();

require_once "../../../assets/template/layout.top.php";

$order_no = $_REQUEST['order_no'];
$tr_no = $_REQUEST['tr_no'];
$rate = $_REQUEST['rate'];
$item_id = $_REQUEST['item_id'];
$item_name = $_REQUEST['item_name'];
$chalan = $_REQUEST['chalan'];

$amount = ($chalan*$rate); 

$do_data= find_all_field('sale_do_details','','id="'.$order_no.'"');
$ms_data= find_all_field('delivery_chalan_master','','tr_no="'.$tr_no.'"');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');


 $sql_del_dt = 'delete from delivery_chalan_details where order_no="'.$order_no.'" and tr_no="'.$tr_no.'" ';
db_query($sql_del_dt);

// $job_id = mysqli_insert_id() ;



echo 'Removed!';


?>
