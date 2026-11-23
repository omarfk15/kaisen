<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Sales Collection';

//do_calander('#tdate');

$user_data = find_all_field('user_activity_management','','user_id="'.$_SESSION['user']['id'].'"');

$collection_no=$_REQUEST['collection_no'];

$data_found = $collection_no;
do_calander('#invoice_date');
if ($data_found==0) {
do_calander('#invoice_date');
do_calander('#need_by');
//create_combobox('fg_item_id');
  }


if(prevent_multi_submit()){






if(isset($_POST['confirm'])){
	
	$status = 'APPROVED';
	$approve_by = $_SESSION['user']['id'];
	$approve_at=date('Y-m-d H:i:s');
	$invoice_date = $_POST['invoice_date'];
	$master_ledger_id = $_POST['master_ledger_id'];
	$marketing_person = $_POST['marketing_person'];
	$remarks = $_POST['remarks'];
	$branch_name = $_POST['branch_name'];
	$group_for=$_SESSION['user']['group'];
	
	$collection_no=$_POST['collection_no'];
	$collection_no_view=$_POST['collection_no_view'];
	
	$year=$_POST['year'];
	$cy_id=$_POST['cy_id'];
	
	$entry_by=$_POST['entry_by'];
	$entry_at=$_POST['entry_at'];
	
	
			$cc_code = 0;
			$tr_from = 'Receipt';
			$proj_id='KMI';
			$config = find_all_field('config_group_class','',"group_for=".$group_for);
			$jv_no=next_journal_sec_voucher_id('','Receipt',$group_for);
			$jv_date = $invoice_date;
			
			if($remarks!=""){
					$remarks_comma=", ";
				}
				
			$narration_master =$collection_no_view."".$remarks_comma."".$remarks;
	
		//$YR = date('Y',strtotime($invoice_date));
//  		$year = date('y',strtotime($invoice_date));
//  		$month = date('m',strtotime($invoice_date));
//		$month_name = date('M',strtotime($invoice_date));
//
//  		$ch_cy_id = find_a_field('sales_collection','max(cy_id)','year="'.$YR.'" ')+1;
//   		$cy_id = sprintf("%06d", $ch_cy_id);
//   		$collection_no=''.$YR.''.$cy_id;
//		$collection_no_view='KMI/RC-'.$year.'/'.$ch_cy_id;

$del_sql = "DELETE from sales_collection where collection_no='".$collection_no."'";
db_query($del_sql);
	
	
	 $sql = 'select d.dealer_code, s.sub_ledger_id, s.ledger_id, s.sub_ledger_name from dealer_info d, general_sub_ledger s
	 where d.dealer_code=s.referance_no and d.marketing_person="'.$marketing_person.'" group by s.sub_ledger_id order by s.sub_ledger_name';

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{

			if($_POST['total_amt_'.$data->sub_ledger_id]>0)

			{
				
				$narration=$_POST['narration_'.$data->sub_ledger_id];
				
				if($narration!=""){
					$narration_comma=", ";
				}
				
				$total_amt=$_POST['total_amt_'.$data->sub_ledger_id];
				$bank_charge=$_POST['bank_charge_'.$data->sub_ledger_id];
				$discount_amt=$_POST['discount_amt_'.$data->sub_ledger_id];
				$tds_amt=$_POST['tds_amt_'.$data->sub_ledger_id];
				
				$net_total_amt +=$total_amt;

				$dealer_code=$_POST['dealer_code_'.$data->sub_ledger_id];

				$sub_ledger_id =$_POST['sub_ledger_id_'.$data->sub_ledger_id];
				
				$ledger_id =$_POST['ledger_id_'.$data->sub_ledger_id];
				
				$narration_ledger="".$collection_no_view."".$narration_comma."".$narration;
				
 $ins_sql = 'INSERT INTO  sales_collection (collection_no, collection_date, collection_no_view,  year, cy_id, group_for, master_ledger_id, marketing_person, dealer_code, sub_ledger_id, ledger_id, branch_name, narration, total_amt, remarks, status, entry_time, entry_by, entry_at, approve_by, approve_at, bank_charge, discount_amt, tds_amt)
  
  VALUES("'.$collection_no.'", "'.$invoice_date.'",  "'.$collection_no_view.'", "'.$year.'", "'.$cy_id.'", "'.$group_for.'", "'.$master_ledger_id.'", "'.$marketing_person.'", "'.$dealer_code.'", "'.$sub_ledger_id.'", "'.$ledger_id.'", "'.$branch_name.'", "'.$narration.'", "'.$total_amt.'", "'.$remarks.'", "'.$status.'", "'.$entry_time.'", "'.$entry_by.'", "'.$entry_at.'", "'.$approve_by.'", "'.$approve_at.'", "'.$bank_charge.'", "'.$discount_amt.'", "'.$tds_amt.'")';

db_query($ins_sql);


 $ins_cr_sql = 'INSERT INTO secondary_journal (jv_no, jv_date, ledger_id, narration, dr_amt, cr_amt, tr_from, tr_no, tr_id, received_from, sub_ledger, group_for, entry_by, entry_at, checked, note, type, remarks)
 VALUES
("'.$jv_no.'", "'.$jv_date.'", "'.$ledger_id.'", "'.$narration_ledger.'", "'.$dr_amt.'", "'.$total_amt.'", "'.$tr_from.'", "'.$collection_no.'", "'.$data->id.'", "'.$received_from.'", "'.$sub_ledger_id.'", "'.$group_for.'", "'.$entry_by.'", "'.$entry_at.'", "'.$checked.'", "Collection", "'.$type.'", "'.$remarks.'")';
	
	db_query($ins_cr_sql);

}

}

 $ins_dr_sql = 'INSERT INTO secondary_journal (jv_no, jv_date, ledger_id, narration, dr_amt, cr_amt, tr_from, tr_no, tr_id, received_from, sub_ledger, group_for, entry_by, entry_at, checked, note, type, remarks)
 VALUES
("'.$jv_no.'", "'.$jv_date.'", "'.$master_ledger_id.'", "'.$narration_master.'", "'.$net_total_amt.'", "'.$cr_amt.'", "'.$tr_from.'", "'.$collection_no.'", "'.$tr_id.'", "'.$received_from.'", "'.$sub_ledger_id.'", "'.$group_for.'", "'.$entry_by.'", "'.$entry_at.'", "'.$checked.'", "Collection", "'.$type.'", "'.$remarks.'")';
	
	db_query($ins_dr_sql);



 $collection_sql="SELECT sum(bank_charge) as bank_charge, sum(discount_amt) as discount_amt, sum(tds_amt) as tds_amt
  FROM sales_collection WHERE collection_no='".$collection_no."' ";
$coll_data = find_all_field_sql($collection_sql);


		if($coll_data->bank_charge>0)
		{
		auto_insert_collection_bank_charge_secoundary($collection_no);
		}
		
		if($coll_data->discount_amt>0)
		{
		auto_insert_collection_discount_amt_secoundary($collection_no);
		}
		
		if($coll_data->tds_amt>0)
		{
		auto_insert_collection_tds_amt_secoundary($collection_no);
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

$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", checked_at="'.$time_now.'" , checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
db_query($sa_up2);


}


} else {

$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

}


	 
	 ?>

<script language="javascript">
window.location.href = "collection_approved_by.php";
</script>

<? 
		
}



}









?>

<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }
	
	
	function count()
{



var unit_price = ((document.getElementById('unit_price').value)*1);
var total_unit_pcs = ((document.getElementById('total_unit_pcs').value)*1);
var per_pcs_weight = ((document.getElementById('per_pcs_weight').value)*1);
var total_unit = (document.getElementById('total_unit').value) = total_unit_pcs*per_pcs_weight;

var total_amt = (document.getElementById('total_amt').value) = unit_price*total_unit;

}


	
	

function TRcalculation(id){

order_no=id;

var unit_price = document.getElementById('unit_price_'+order_no).value*1;

var total_unit_pcs = document.getElementById('total_unit_pcs_'+order_no).value*1;

var per_pcs_weight = document.getElementById('per_pcs_weight_'+order_no).value*1;

var total_unit = document.getElementById('total_unit_'+order_no).value= (total_unit_pcs*per_pcs_weight);

var total_amt = document.getElementById('total_amt_'+order_no).value= (total_unit*unit_price);


}




function TRcalculation_cal(id){

order_no=id;

var total_unit = document.getElementById('total_unit_'+order_no).value*1;

var unit_price = document.getElementById('unit_price_'+order_no).value*1;

var total_amt = document.getElementById('total_amt_'+order_no).value= (total_unit*unit_price);

// if(po_qty<adj_qty)
//  {
//alert('You can`t reduce the qty');
//document.getElementById('adj_qty_'+order_no).value='';
//document.getElementById('adj_amt_'+order_no).value='';
//  } 

}



	function update_value(id)
	
	{

var order_no=id; // Rent

var item_id=(document.getElementById('item_id_'+order_no).value);
var total_unit_pcs=(document.getElementById('total_unit_pcs_'+order_no).value);
var per_pcs_weight=(document.getElementById('per_pcs_weight_'+order_no).value);
var total_unit=(document.getElementById('total_unit_'+order_no).value);
var unit_price=(document.getElementById('unit_price_'+order_no).value);
var total_amt=(document.getElementById('total_amt_'+order_no).value);

var flag=(document.getElementById('flag_'+order_no).value); 

var strURL="item_revise_ajax.php?order_no="+order_no+"&item_id="+item_id+"&total_unit_pcs="+total_unit_pcs+"&per_pcs_weight="+per_pcs_weight+"&total_unit="+total_unit+"&unit_price="+unit_price+"&total_amt="+total_amt+"&flag="+flag;

		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+order_no).style.display='inline';

						document.getElementById('divi_'+order_no).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}






function SUMcalculation(ledger_id){
//var unit_price = (document.getElementById('unit_price_'+item_id).value)*1;
var foe_amt = (document.getElementById('foe_amt_'+ledger_id).value)*1;
//document.getElementById('foe_amt_'+item_id).value = unit_price*qty;

var foe_amt = 0;

<?

	$sql = "select l.group_name, a.ledger_id, a.ledger_name
	from ledger_group l, accounts_ledger a where l.group_id=a.ledger_group_id and a.ledger_group_id=411010
	order by l.group_id, a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
?>
foe_amt = foe_amt + document.getElementById('foe_amt_<?=$data->ledger_id?>').value*1;;
<?
}

?>

document.getElementById('foe_amt').value = foe_amt;

}








</script>






<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 220px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">


<form action="" method="post" name="codz" id="codz">

<? if ($data_found>0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
								    <td colspan="4" align="left" >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										
										<? $collection_data = find_all_field('sales_collection','','collection_no="'.$_REQUEST['collection_no'].'"'); ?>
											<tr>
												<td width="50%"><strong>Collection No: </strong></td>
												<td width="50%"><strong> Bank/Cash: </strong></td>
												
											</tr>
											<tr>
												<td width="50%">
<input name="collection_no" type="hidden" id="collection_no" style="width:90%; height:32px;" value="<?php echo $collection_data->collection_no;?>" required   tabindex="1" />
<input name="collection_no_view" type="text" id="collection_no_view" style="width:90%; height:32px;" value="<?php echo $collection_data->collection_no_view;?>" required   tabindex="1" readonly="" />

<input name="entry_by" type="hidden" id="entry_by" style="width:90%; height:32px;" value="<?php echo $collection_data->entry_by;?>" required   tabindex="1" />
<input name="entry_at" type="hidden" id="entry_at" style="width:90%; height:32px;" value="<?php echo $collection_data->entry_at;?>" required   tabindex="1" />

<input name="year" type="hidden" id="year" style="width:90%; height:32px;" value="<?php echo $collection_data->year;?>" required   tabindex="1" />
<input name="cy_id" type="hidden" id="cy_id" style="width:90%; height:32px;" value="<?php echo $collection_data->cy_id;?>" required   tabindex="1" />
</td>
												<td width="50%">
		<select name="master_ledger_id" id="master_ledger_id"  style="width:90%; height:32px;" required>
		<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['master_ledger_id'],'ledger_id="'.$collection_data->master_ledger_id.'" ');?>
      </select>
												</td>
											</tr>
											
											
											
											<tr>
												<td width="50%"><strong>TR  Date: </strong></td>
												<td width="50%"><strong>Branch Name </strong></td>
												
											</tr>
											<tr>
											  <td width="50%"><input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?php echo $collection_data->collection_date;?>" required   tabindex="1" /></td>
												<td width="50%">
		<input name="branch_name" type="text" id="branch_name" style="width:90%; height:32px;" value="<?=$collection_data->branch_name;?>"    autocomplete="off"  tabindex="1" />
												</td>
											</tr>
											
											
											<tr>
												<td width="50%"><strong> Marketing Person: </strong></td>
												<td width="50%"><strong> Remarks: </strong></td>
												
											</tr>
											<tr>
											  <td width="50%"><select name="marketing_person" id="marketing_person"  style="width:90%; height:32px;" class="js-example-basic-single" required="required">
                                                <? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'person_code="'.$collection_data->marketing_person.'"');?>
                                              </select></td>
												<td width="50%" align="left"><input name="remarks" type="text" id="remarks" style="width:90%; height:32px;" value="<?=$collection_data->remarks?>"    tabindex="1"  autocomplete="off" /></td>
											</tr>
											
											<tr>
												<td width="50%">&nbsp;</td>
												<td width="50%">&nbsp;</td>
												
								  </tr>
								  
								  
								  
											
										</table>
									</td>
							      </tr>
	
								</table>

</div>


<? }?>




<? if($data_found>0){ ?>





<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="6%">Code</th>

    <th width="23%">Party Name <span style="height:30px"></span></th>
    <th width="20%">Narration</th>
    <th width="13%">Amount</th>
    <th width="12%">Bank Charge </th>
    <th width="13%">Discount</th>
    <th width="13%">TDS</th>
  </tr>
  
  

  <?
  
  		$sql = "select sub_ledger_id, total_amt, bank_charge, discount_amt, tds_amt, narration from sales_collection where collection_no='".$collection_no."'  group by sub_ledger_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $total_amt[$info->sub_ledger_id]=$info->total_amt;
		 $bank_charge[$info->sub_ledger_id]=$info->bank_charge;
		 $discount_amt[$info->sub_ledger_id]=$info->discount_amt;
		 $tds_amt[$info->sub_ledger_id]=$info->tds_amt;
		 $narration[$info->sub_ledger_id]=$info->narration;
		}
  
    $sqlfg = "select d.dealer_code, s.sub_ledger_id, s.ledger_id, s.sub_ledger_name from dealer_info d, general_sub_ledger s
	 where d.dealer_code=s.referance_no and d.marketing_person='".$collection_data->marketing_person."' order by s.sub_ledger_name";

  $queryfg = db_query($sqlfg);

  while($data=mysqli_fetch_object($queryfg)){$i++;
  ?>
<? if($total_amt[$data->sub_ledger_id]>0) {?>
  <tr  bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td width="6%"><?=$data->dealer_code?>
<input name="dealer_code_<?=$data->sub_ledger_id?>" type="hidden" id="dealer_code_<?=$data->sub_ledger_id?>" value="<?=$data->dealer_code?>" style="width:95%;" />
<input name="sub_ledger_id_<?=$data->sub_ledger_id?>" type="hidden" id="sub_ledger_id_<?=$data->sub_ledger_id?>" value="<?=$data->sub_ledger_id?>" style="width:95%;" />
<input name="ledger_id_<?=$data->sub_ledger_id?>" type="hidden" id="ledger_id_<?=$data->sub_ledger_id?>" value="<?=$data->ledger_id?>" style="width:95%;" />	</td>

    <td  width="23%" style="white-space:normal"> <?=$data->sub_ledger_name?></td>
    <td  width="20%" bgcolor="#99CCFF">
	<input name="narration_<?=$data->sub_ledger_id?>" type="text" id="narration_<?=$data->sub_ledger_id?>" value="<?=$narration[$data->sub_ledger_id]?>" style="width:95%; height:30px; " /></td>
    <td  width="13%" bgcolor="#99CCFF">
	<input name="total_amt_<?=$data->sub_ledger_id?>" type="text" id="total_amt_<?=$data->sub_ledger_id?>" value="<?=$total_amt[$data->sub_ledger_id]?>"   style="width:95%; height:30px; " /></td>
    <td  width="12%" bgcolor="#99CCFF">
	<input name="bank_charge_<?=$data->sub_ledger_id?>" type="text" id="bank_charge_<?=$data->sub_ledger_id?>" value="<?=$bank_charge[$data->sub_ledger_id]?>"   style="width:95%; height:30px; " /></td>
    <td  width="13%" bgcolor="#99CCFF">
	<input name="discount_amt_<?=$data->sub_ledger_id?>" type="text" id="discount_amt_<?=$data->sub_ledger_id?>" value="<?=$discount_amt[$data->sub_ledger_id]?>"   style="width:95%; height:30px; " /></td>
    <td  width="13%" bgcolor="#99CCFF">
	<input name="tds_amt_<?=$data->sub_ledger_id?>" type="text" id="tds_amt_<?=$data->sub_ledger_id?>" value="<?=$tds_amt[$data->sub_ledger_id]?>"   style="width:95%; height:30px; " /></td>
  </tr>
  
  <? } ?>

  <? } ?>
</table>
</div>

<br />



<br /><br />




<table width="100%" border="0">



<tr>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>
</tr>

</table>



<? }?>





<p>&nbsp;</p>

</form>

</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>