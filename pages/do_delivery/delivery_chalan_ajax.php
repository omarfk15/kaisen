<?

session_start();

require_once "../../../assets/template/layout.top.php";

$order_no = $_REQUEST['order_no'];
$tr_no = $_REQUEST['tr_no'];
$unit_price = $_REQUEST['rate'];
$item_id = $_REQUEST['item_id'];
$item_name = $_REQUEST['item_name'];
$chalan = $_REQUEST['chalan'];
$chalan_kg = $_REQUEST['chalan_kg'];

$do_data= find_all_field('sale_do_details','','id="'.$order_no.'"');


if($do_data->total_unit_rft>0){
$total_unit_rft=$chalan*$do_data->length;
$rft_unit_price=$do_data->unit_price_rft;
$total_amt_cal = ($total_unit_rft*$rft_unit_price);
$unit_price_cal=$total_amt_cal/$chalan_kg;
}else{
$unit_price_cal=$unit_price;
$total_amt_cal = ($chalan_kg*$unit_price); 
}



$per_pcs_weight=$chalan_kg/$chalan;



$vat_amt=($total_amt_cal/115)*15;
$amt_without_vat=$total_amt_cal-$vat_amt;


$ms_data= find_all_field('delivery_chalan_master','','tr_no="'.$tr_no.'"');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');


$sql_del_dt = 'delete from delivery_chalan_details where order_no="'.$order_no.'" and tr_no="'.$tr_no.'" ';
db_query($sql_del_dt);

if($chalan>0) {
 $ins_sql = 'INSERT INTO delivery_chalan_details (tr_no, chalan_no, order_no, do_no, job_no, do_date, size, mark, length, thickness, item_id, dealer_code, marketing_person, unit_price, total_unit_pcs, per_pcs_weight, total_unit, total_amt, vat_amt, amt_without_vat, depot_id, group_for, entry_by, entry_at, status, total_unit_rft, unit_price_rft)
  
  VALUES("'.$tr_no.'", "'.$chalan_no.'", "'.$order_no.'", "'.$do_data->do_no.'", "'.$ms_data->job_no.'", "'.$do_data->do_date.'", "'.$do_data->size.'", "'.$do_data->mark.'", "'.$do_data->length.'", "'.$do_data->thickness.'", "'.$item_id.'", "'.$ms_data->dealer_code.'", "'.$ms_data->marketing_person.'", "'.$unit_price_cal.'", "'.$chalan.'", "'.$per_pcs_weight.'", "'.$chalan_kg.'", "'.$total_amt_cal.'", "'.$vat_amt.'", "'.$amt_without_vat.'", "'.$do_data->depot_id.'", "'.$ms_data->group_for.'", "'.$entry_by.'", "'.$entry_at.'", "'.$status.'", "'.$total_unit_rft.'", "'.$rft_unit_price.'")';

db_query($ins_sql);
}

 //$job_id = mysqli_insert_id() ;



echo 'Success!';


?>
