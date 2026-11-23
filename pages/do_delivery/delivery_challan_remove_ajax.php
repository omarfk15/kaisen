<?

session_start();

require_once "../../../assets/template/layout.top.php";

$chalan_no = $_REQUEST['chalan_no'];
$do_no = $_REQUEST['do_no'];

$ch_data= find_all_field('sale_do_chalan','','chalan_no="'.$chalan_no.'"');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');

$remove_date=date('Y-m-d');

 $ins_sql = 'INSERT INTO sale_do_chalan_backup (remove_date, chalan_no, chalan_no_view, chalan_date, gatepass_no, invoice_no, do_no, job_no, do_date, dealer_code, marketing_person, depot_id, group_for, entry_by, entry_at)
  
  VALUES("'.$remove_date.'", "'.$ch_data->chalan_no.'", "'.$ch_data->chalan_no_view.'", "'.$ch_data->chalan_date.'", "'.$ch_data->gatepass_no.'", "'.$ch_data->invoice_no.'", "'.$ch_data->do_no.'", "'.$ch_data->job_no.'", "'.$ch_data->do_date.'", "'.$ch_data->dealer_code.'", "'.$ch_data->marketing_person.'", "'.$ch_data->depot_id.'", "'.$ch_data->group_for.'", "'.$entry_by.'", "'.$entry_at.'")';

db_query($ins_sql);


$sql_del_ch = 'delete from sale_do_chalan where chalan_no="'.$chalan_no.'" and do_no="'.$do_no.'" ';
db_query($sql_del_ch);

$sql_del_weight = 'delete from sale_do_hanging_weight where chalan_no="'.$chalan_no.'" and do_no="'.$do_no.'" ';
db_query($sql_del_weight);

$sql_del_ji = 'delete from journal_item where sr_no="'.$chalan_no.'" and tr_from="Sales" ';
db_query($sql_del_ji);

$sql_del_sjv = 'delete from secondary_journal where tr_no="'.$chalan_no.'" and tr_from="Sales" ';
db_query($sql_del_sjv);

$sql_del_jv = 'delete from journal where tr_no="'.$chalan_no.'" and tr_from="Sales" ';
db_query($sql_del_jv);


echo 'Removed!';


?>
