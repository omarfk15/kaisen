<?php
session_start();
ob_start();
require_once "../../../assets/template/layout.top.php";
$title='Purchase Requisition Status';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

//create_combobox('batch_no');
//create_combobox('dealer_code');




if(isset($_POST['approved'])){

		 $_POST['checked_at']=date('Y-m-d H:s:i');

		 $_POST['checked_by']=$_SESSION['user']['id'];
		

	 $sql = "update purchase_requisition_master set status='UNCHECKED', checked_by='".$_POST['checked_by']."', checked_at='".$_POST['checked_at']."' 
	 where invoice_no=".$_POST['invoice_no']."";
	db_query($sql);

	$type=1;

	$msg='Work Order Is Been Approved.';

}



$table_details='sale_do_details';
//$unique_chalan='id';

$$unique=$_POST[$unique];

//if(isset($_POST['delete']))
//{
//		$crud   = new crud($table_master);
//		$condition=$unique_master."=".$$unique_master;		
//		$crud->delete($condition);
//		$crud   = new crud($table_detail);
//		$crud->delete_all($condition);
//		$crud   = new crud($table_chalan);
//		$crud->delete_all($condition);
//		unset($$unique_master);
//		unset($_SESSION[$unique_master]);
//		$type=1;
//		$msg='Successfully Deleted.';
//}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='COMPLETED';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
		
		
		
		
		
		
		
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='lc_number_setup';
$lc_no='id';
$text_field_id='id';

$target_url = 'invoice_print_view.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?invoice_no='+theUrl);
}
</script><div class="form-container_large">




<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 250px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
        <tr>
          <td width="320" align="right" bgcolor="#FF9966"><strong> Date </strong></td>
          <td width="203" bgcolor="#FF9966"><input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td width="58" bgcolor="#FF9966" align="center"><strong> TO </strong></td>
          <td width="242" bgcolor="#FF9966"><input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td width="345" rowspan="4" bgcolor="#FF9966" align="center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
          </strong></td>
        </tr>
      <?php /*?><tr>
        <td width="266" align="right" bgcolor="#FF9966"><strong>Challan No:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		
	
	<input type="text" name="invoice_no" id="invoice_no" value="<?=$_POST['invoice_no']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/>		</td>
      </tr><?php */?>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="10%">REQ. No </th>
  <th width="14%">REQ. Date </th>
  <th width="20%"><strong>REQ. From </strong></th>
  <th width="19%">Status</th>
  <th width="19%">Entry By </th>
  <th width="18%">Action</th>
</tr>


<? 

if(isset($_POST['submitit'])){}





if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.invoice_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


 		//$sql = "select lc_no, lc_no as lc_number  from lc_bank_entry where 1 group by lc_no ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $lc_number[$info->lc_no]=$info->lc_number;
//		}



   $res="select  m.* from  purchase_requisition_master m, purchase_requisition_details d where m.invoice_no=d.invoice_no and  m.status='PROCESSING'  ".$con." 
   group by m.invoice_no order by m.invoice_date, m.invoice_no";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
$i++;
?>

<? //if($lc_number[$data->id]==0) { } ?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td  ><?=$data->view_invoice_no;?></td>
<td  >&nbsp;<?= date("d-m-Y",strtotime($data->invoice_date));?></td>
<td  ><?= find_a_field('warehouse','warehouse_name','warehouse_id="'.$data->warehouse_id.'"');?></td>
<td  ><?=$data->status;?></td>
<td  ><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
<td>
<a href="invoice_print_view_work.php?invoice_no=<?=$data->invoice_no;?>" target="_blank"><input type="button" name="view"  id="view" value="View" style="background-color:green;color:white;" /></a>
</td>
</tr>


<? }  ?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
$_SESSION['notify'][859]=$i;
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>