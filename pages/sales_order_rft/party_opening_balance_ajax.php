<?

session_start();

require_once "../../../assets/template/layout.top.php";

  $obdate = $_REQUEST['obdate'];
  $sub_ledger = $_REQUEST['sub_ledger_id'];
  $ledger_id = $_REQUEST['ledger_id'];
  $dr_amt = $_REQUEST['dr_amt'];
  $cr_amt = $_REQUEST['cr_amt'];
  
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	
	
	
$sjv_del = "DELETE from secondary_journal where tr_from='Opening' and sub_ledger='".$sub_ledger."' ";
db_query($sjv_del);

$jv_del = "DELETE from journal where tr_from='Opening' and sub_ledger='".$sub_ledger."' ";
db_query($jv_del);
	
			$group_for = $_SESSION['user']['group'];
			$cc_code = 0;
			$tr_from = Opening;
			$proj_id=Star;
			$config = find_all_field('config_group_class','',"group_for=".$group_for);
			$jv_no=next_journal_sec_voucher_id('','Opening',$group_for);
			$jv_date = $obdate;	
			$narration = "Closing Balance of '".date('d-M-y',strtotime($obdate))."'";


if($dr_amt>0) {
  $ins_dr_sql = 'INSERT INTO secondary_journal (jv_no, jv_date, ledger_id, narration, dr_amt, cr_amt, tr_from, tr_no, received_from, sub_ledger, group_for, entry_by, entry_at, checked, note, type)
 VALUES
("'.$jv_no.'", "'.$jv_date.'", "'.$ledger_id.'", "'.$narration.'", "'.$dr_amt.'", "'.$cr_amt.'", "'.$tr_from.'", "'.$tr_no.'", "'.$received_from.'", "'.$sub_ledger.'", "'.$group_for.'", "'.$entry_by.'", "'.$entry_at.'", "'.$checked.'", "'.$note.'", "'.$type.'")';
	
	db_query($ins_dr_sql);
	}
	
	if($cr_amt>0) {
  $ins_cr_sql = 'INSERT INTO secondary_journal (jv_no, jv_date, ledger_id, narration, dr_amt, cr_amt, tr_from, tr_no, received_from, sub_ledger, group_for, entry_by, entry_at, checked, note, type)
 VALUES
("'.$jv_no.'", "'.$jv_date.'", "'.$ledger_id.'", "'.$narration.'", "'.$dr_amt.'", "'.$cr_amt.'", "'.$tr_from.'", "'.$tr_no.'", "'.$received_from.'", "'.$sub_ledger.'", "'.$group_for.'", "'.$entry_by.'", "'.$entry_at.'", "'.$checked.'", "'.$note.'", "'.$type.'")';
	
	db_query($ins_cr_sql);
	}
	
	
	
		
			
$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');

$time_now = date('Y-m-d H:i:s');

if($sa_config=="Yes"){

$sa_up='update secondary_journal set secondary_approval="Yes", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');


if($jv_config=="Yes"){

sec_journal_journal($jv_no,$jv_no,$tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);

$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", checked_at="'.$time_now.'" ,checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up2);


}


} else {

$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

}

echo 'Success!';
		
	

?>