<?

session_start();

require_once "../../../assets/template/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];
$total_unit_pcs = $_REQUEST['total_unit_pcs'];
$per_pcs_weight = $_REQUEST['per_pcs_weight'];
$total_unit = $_REQUEST['total_unit'];
$unit_price = $_REQUEST['unit_price'];
$total_amt = $_REQUEST['total_amt'];


$flag = $_REQUEST['flag'];



$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');




$del_sql = "DELETE from sale_do_details where id='".$order_no."'";
db_query($del_sql);
echo 'Removed!';




?>