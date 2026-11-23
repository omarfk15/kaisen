<?

session_start();

require_once "../../../assets/template/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];
$unit_price = $_REQUEST['unit_price'];
$chalan = $_REQUEST['chalan'];
$old_ch_qty = $_REQUEST['old_ch_qty'];
$pack_unit = $_REQUEST['pack_unit'];
$others_info = $_REQUEST['others_info'];
$flag = $_REQUEST['flag'];

$pack_size=$chalan/$pack_unit;

$status=CHECKED;

$difrent_qty=$chalan-$old_ch_qty;

$revise_date=date('Y-m-d');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');

$total_amt=$chalan*$unit_price;

$ch_data = find_all_field('sale_do_chalan','','id="'.$order_no.'"');

if($difrent_qty>0){
$revise_in=$difrent_qty;
$revise_ex=0;
}elseif($difrent_qty<0){
$revise_in=0;
$revise_ex=$difrent_qty;
}


//if($total_unit==0)
//{
//$del_sql = "DELETE from purchase_receive where id='".$order_no."'";
//mysql_query($del_sql);
//$delji_sql = "DELETE from journal_item where tr_no='".$order_no."' and tr_from='Opening'";
//mysql_query($delji_sql);
//}else{
//$up_sql='update purchase_receive set  qty="'.$total_unit.'", amount="'.$amount.'", edit_by="'.$entry_by.'", edit_at="'.$entry_at.'" where id='.$order_no;
//mysql_query($up_sql);
//$upji_sql='update journal_item set  item_in="'.$total_unit.'", entry_by="'.$entry_by.'", entry_at="'.$entry_at.'" where tr_from="Opening" and tr_no='.$order_no;
//mysql_query($upji_sql);
//}




 $ins_sql = 'INSERT INTO sale_do_chalan_revise (revise_date, chalan_no, chalan_no_view, chalan_date, order_no, wo_order_no, item_name, do_no, job_no, group_for, dealer_code, buyer_code, merchandizer_code, destination, delivery_place, delivery_place_name, delivery_address, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, flap, item_id, sqm_rate, sqm, additional_info, additional_charge, final_price, unit_price, total_unit, total_amt, pack_size, pack_unit, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_by, entry_at, remarks, vehicle_type, vehicle_id, vehicle_no, driver_id, driver_name, driver_mobile, delivery_man, delivery_man_mobile, prepared_by, authorized_by, revise_by, revise_at, others_info, revise_in, revise_ex)
  
  VALUES("'.$revise_date.'", "'.$ch_data->chalan_no.'", "'.$ch_data->chalan_no_view.'", "'.$ch_data->chalan_date.'", "'.$order_no.'", "'.$ch_data->order_no.'", "'.$ch_data->item_name.'", "'.$ch_data->do_no.'", "'.$ch_data->job_no.'", "'.$ch_data->group_for.'", "'.$ch_data->dealer_code.'", "'.$ch_data->buyer_code.'", "'.$ch_data->merchandizer_code.'", "'.$ch_data->destination.'", "'.$ch_data->delivery_place.'", "'.$ch_data->delivery_place_name.'", "'.$ch_data->delivery_address.'", "'.$ch_data->unit_name.'", "'.$ch_data->measurement_unit.'", "'.$ch_data->ply.'", "'.$ch_data->paper_combination_id.'", "'.$ch_data->paper_combination.'", "'.$ch_data->L_cm.'", "'.$ch_data->W_cm.'", "'.$ch_data->H_cm.'", "'.$ch_data->WL.'", "'.$ch_data->WW.'", "'.$ch_data->flap.'", "'.$ch_data->item_id.'", "'.$ch_data->sqm_rate.'", "'.$ch_data->sqm.'", "'.$ch_data->additional_info.'", "'.$ch_data->additional_charge.'", "'.$ch_data->final_price.'", "'.$ch_data->unit_price.'", "'.$ch_data->total_unit.'", "'.$ch_data->total_amt.'", "'.$ch_data->pack_size.'", "'.$ch_data->pack_unit.'", "'.$ch_data->style_no.'", "'.$ch_data->po_no.'", "'.$ch_data->referance.'", "'.$ch_data->sku_no.'", "'.$ch_data->printing_info.'", "'.$ch_data->color.'", "'.$ch_data->pack_type.'", "'.$ch_data->size.'", "'.$ch_data->depot_id.'", "'.$ch_data->status.'", "'.$entry_by.'", "'.$entry_at.'", "'.$ch_data->remarks.'", "'.$ch_data->vehicle_type.'", "'.$ch_data->vehicle_id.'", "'.$ch_data->vehicle_no.'", "'.$ch_data->driver_id.'", "'.$ch_data->driver_name.'", "'.$ch_data->driver_mobile.'", "'.$ch_data->delivery_man.'", "'.$ch_data->delivery_man_mobile.'", "'.$ch_data->prepared_by.'", "'.$ch_data->authorized_by.'", "'.$entry_by.'", "'.$entry_at.'", "'.$ch_data->others_info.'", "'.$revise_in.'", "'.$revise_ex.'")';

mysql_query($ins_sql);

// $job_id = mysql_insert_id() ;


 $up_sql='update sale_do_chalan set  total_unit="'.$chalan.'", total_amt="'.$total_amt.'", pack_unit="'.$pack_unit.'", pack_size="'.$pack_size.'",
  others_info="'.$others_info.'", revise_count=1, revise_by="'.$entry_by.'", revise_at="'.$entry_at.'", edit_by="'.$entry_by.'", edit_at="'.$entry_at.'" where id='.$order_no;
mysql_query($up_sql);


echo 'Success!';


?>
