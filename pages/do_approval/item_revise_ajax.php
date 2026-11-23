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




if($total_unit==0)
{
$del_sql = "DELETE from sale_do_details where id='".$order_no."'";
db_query($del_sql);
echo 'Removed!';
}else{
$up_sql='update sale_do_details set  total_unit_pcs="'.$total_unit_pcs.'", per_pcs_weight="'.$per_pcs_weight.'", total_unit="'.$total_unit.'", 
 unit_price="'.$unit_price.'",  total_amt="'.$total_amt.'",  edit_by="'.$entry_by.'", edit_at="'.$entry_at.'" where id='.$order_no;
db_query($up_sql);
echo 'Success!';
}




// $po_bill = 'INSERT INTO po_bill_details (bill_id, bill_no, bill_date, purchase_manager, po_no, jv_no, vendor_id, ledger_id, entry_at, entry_by)
//  
//  VALUES("'.$bill_id.'", "'.$bill_no.'", "'.$bill_date.'", "'.$purchase_manager.'", "'.$po_no.'", "'.$jv_no.'", "'.$vendor_id.'", "'.$ledger_id.'", "'.$entry_at.'", "'.$entry_by.'")';
//
//db_query($po_bill);





?>