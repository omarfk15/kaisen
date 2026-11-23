<?

session_start();

require_once "../../../assets/template/layout.top.php";

$chalan_no = $_REQUEST['chalan_no'];

$flag = $_REQUEST['flag'];

$ch_data= find_all_field('sale_do_chalan','','chalan_no="'.$chalan_no.'"');

$acknowledgement_date=date('Y-m-d');
$acknowledgement_no = next_transection_no($ch_data->group_for,$acknowledgement_date,'sale_do_chalan_acknowledgement','acknowledgement_no');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');



 $ins_sql = 'INSERT INTO sale_do_chalan_acknowledgement (acknowledgement_no, acknowledgement_date, chalan_no, chalan_no_view, chalan_date, do_no, do_date, job_no, group_for, dealer_code, buyer_code, merchandizer_code, entry_by, entry_at)
  
  VALUES("'.$acknowledgement_no.'", "'.$acknowledgement_date.'", "'.$chalan_no.'", "'.$ch_data->chalan_no_view.'", "'.$ch_data->chalan_date.'", "'.$ch_data->do_no.'", "'.$ch_data->do_date.'", "'.$ch_data->job_no.'", "'.$ch_data->group_for.'", "'.$ch_data->dealer_code.'", "'.$ch_data->buyer_code.'", "'.$ch_data->merchandizer_code.'", "'.$entry_by.'", "'.$entry_at.'")';

mysql_query($ins_sql);

// $job_id = mysql_insert_id() ;


 $up_sql='update sale_do_chalan set  total_unit="'.$chalan.'", total_amt="'.$total_amt.'", pack_unit="'.$pack_unit.'", pack_size="'.$pack_size.'",
  others_info="'.$others_info.'", revise_count=1, revise_by="'.$entry_by.'", revise_at="'.$entry_at.'", edit_by="'.$entry_by.'", edit_at="'.$entry_at.'" where id='.$order_no;
mysql_query($up_sql);


echo 'Success!';


?>
