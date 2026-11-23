<?

session_start();

require_once "../../../assets/template/layout.top.php";

$order_no = $_REQUEST['order_no'];
$tr_no = $_REQUEST['tr_no'];
$rate = $_REQUEST['rate'];
$item_id = $_REQUEST['item_id'];
$item_name = $_REQUEST['item_name'];
$chalan = $_REQUEST['chalan'];
$pack_unit = $_REQUEST['pack_size'];
$others_info = $_REQUEST['others_info'];

$amount = ($chalan*$rate); 

$do_data= find_all_field('sale_do_details','','id="'.$order_no.'"');
$ms_data= find_all_field('delivery_chalan_master','','tr_no="'.$tr_no.'"');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');


$sql_del_dt = 'delete from delivery_chalan_details where order_no="'.$order_no.'" and tr_no="'.$tr_no.'" ';
mysql_query($sql_del_dt);

if($chalan>0) {
 $ins_sql = 'INSERT INTO delivery_chalan_details (tr_no, sales_type, order_no, item_name, poly_category, do_no, do_date, job_no, delivery_date, cbm_no, group_for, dealer_code, buyer_code, merchandizer_code, destination, delivery_place, delivery_place_name, delivery_address, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, flap, gusset, micron, yds, item_id, formula_id, formula_cal, sqm_rate, sqm, additional_info, additional_charge, final_price, unit_price, total_unit, total_amt, dzn_unit_price, dzn_total_unit, dzn_total_amt, pack_size, pack_unit, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_by, entry_at, others_info, count_id)
  
  VALUES("'.$tr_no.'", "'.$ms_data->sales_type.'", "'.$order_no.'", "'.$item_name.'", "'.$do_data->poly_category.'", "'.$do_data->do_no.'", "'.$do_data->do_date.'", "'.$do_data->job_no.'", "'.$do_data->delivery_date.'", "'.$do_data->cbm_no.'", "'.$ms_data->group_for.'", "'.$ms_data->dealer_code.'", "'.$ms_data->buyer_code.'", "'.$ms_data->merchandizer_code.'", "'.$do_data->destination.'", "'.$do_data->delivery_place.'", "'.$do_data->delivery_place_name.'", "'.$do_data->delivery_address.'", "'.$do_data->unit_name.'", "'.$do_data->measurement_unit.'", "'.$do_data->ply.'", "'.$do_data->paper_combination_id.'", "'.$do_data->paper_combination.'", "'.$do_data->L_cm.'", "'.$do_data->W_cm.'", "'.$do_data->H_cm.'", "'.$do_data->WL.'", "'.$do_data->WW.'", "'.$do_data->flap.'", "'.$do_data->gusset.'", "'.$do_data->micron.'", "'.$do_data->yds.'", "'.$do_data->item_id.'", "'.$do_data->formula_id.'", "'.$do_data->formula_cal.'", "'.$do_data->sqm_rate.'", "'.$do_data->sqm.'", "'.$do_data->additional_info.'", "'.$do_data->additional_charge.'", "'.$do_data->final_price.'", "'.$rate.'", "'.$chalan.'", "'.$amount.'", "'.$do_data->dzn_unit_price.'", "'.$do_data->dzn_total_unit.'", "'.$do_data->dzn_total_amt.'", "'.$do_data->pack_size.'", "'.$pack_unit.'", "'.$do_data->style_no.'", "'.$do_data->po_no.'", "'.$do_data->referance.'", "'.$do_data->sku_no.'", "'.$do_data->printing_info.'", "'.$do_data->color.'", "'.$do_data->pack_type.'", "'.$do_data->size.'", "'.$do_data->depot_id.'", "'.$do_data->status.'", "'.$entry_by.'", "'.$entry_at.'", "'.$others_info.'", "'.$do_data->count_id.'")';

mysql_query($ins_sql);
}

// $job_id = mysql_insert_id() ;



echo 'Success!';


?>
