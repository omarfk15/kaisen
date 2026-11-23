<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Delivery Challan Edit ';

do_calander('#return_date');

$chalan_no=$_REQUEST['v_no'];


//do_calander('#chalan_date','0','10');

//create_combobox('vehicle_id');
//create_combobox('driver_id');

//do_calander('#gp_date','0','10');




$data_found = $chalan_no;

if ($data_found==0) {

do_calander('#invoice_date','0','10');
do_calander('#need_by');
create_combobox('dealer_code');


  }


if(prevent_multi_submit()){


if(isset($_POST['master_data'])){
	
	$status = 'MANUAL';
	$entry_by = $_SESSION['user']['id'];
	$group_for = $_SESSION['user']['group'];
	$entry_at=date('Y-m-d H:i:s');
	$dealer_code=$_POST['dealer_code'];
	$vehicle_id=$_POST['vehicle_id'];
	$driver_id=$_POST['driver_id'];
	$lock_no=$_POST['lock_no'];
	$delivery_address=$_POST['delivery_address'];
	$remarks = $_POST['remarks'];


	$invoice_date = $_POST['invoice_date'];
		
	//$pr_date = $_POST['so_date'];
	//$fg_item_id = $_POST['fg_item_id'];
	//$item_watt = find_a_field('item_info','item_watt','item_id="'.$_POST['fg_item_id'].'"');
	//$group_for=$_SESSION['user']['group'];
	//$warehouse_id=$_SESSION['user']['depot'];
	
	
		$YR = date('Y',strtotime($invoice_date));
 		$year = date('y',strtotime($invoice_date));
  		$month = date('m',strtotime($invoice_date));
 		$inv_cy_id = find_a_field('gate_pass_master','max(inv_id)','year="'.$YR.'"')+1;
  		$cy_id = sprintf("%06d", $inv_cy_id);
   		$gate_pass_no=''.$YR.''.$cy_id;
		$view_gate_pass='GPN-'.$inv_cy_id.'/'.$YR;

	 
	 
	 if($gate_pass_no>0) {
	  $ins_sql = 'INSERT INTO gate_pass_master (gate_pass_no, gp_date, year, inv_id, view_gate_pass, group_for, vehicle_id, driver_id, lock_no, dealer_code, delivery_address, status, entry_at, entry_by, remarks) VALUES

("'.$gate_pass_no.'",  "'.$invoice_date.'", "'.$YR.'", "'.$cy_id.'", "'.$view_gate_pass.'", "'.$group_for.'", "'.$vehicle_id.'",  "'.$driver_id.'", "'.$lock_no.'", "'.$dealer_code.'", "'.$delivery_address.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$remarks.'")';
	
	db_query($ins_sql);
	}

	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$gate_pass_no?>";
</script>

<? 
		
}



if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	
	$do_no=$_POST['do_no'];
	$chalan_no=$_POST['chalan_no'];
	$manual_chalan=$_POST['manual_chalan'];
	$chalan_date=$_POST['chalan_date'];
	$vehicle_id=$_POST['vehicle_id'];
	$driver_id=$_POST['driver_id'];
	$delivery_place=$_POST['delivery_place'];
	$delivery_place_name=$_POST['delivery_place_name'];
	$delivery_address=$_POST['delivery_address'];
	
	$customer_po_no=$_POST['customer_po_no'];
	$buyer_referance=$_POST['buyer_referance'];
	
	$return_date=$_POST['return_date'];
	$remarks=$_POST['remarks'];
	
	$return_tr=77;
	
	
		$YR = date('Y',strtotime($return_date));
 		$year = date('y',strtotime($return_date));
  		$month = date('m',strtotime($return_date));
 		$inv_cy_id = find_a_field('sale_do_chalan_return','max(return_id)','year="'.$YR.'"')+1;
  		$cy_id = sprintf("%06d", $inv_cy_id);
   		$return_no=''.$YR.''.$return_tr.''.$cy_id;
		$return_no_view='SR-'.$inv_cy_id.'/'.$YR;



  $sql='select  a.* from sale_do_chalan a, item_info b, item_sub_group s where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and  a.chalan_no="'.$chalan_no.'" 
		order by a.item_id, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit, a.style_no';

		$query = db_query($sql);

		
		while($data=mysqli_fetch_object($query))

		{

			if($_POST['return_qty_'.$data->id]>0)

			{
				
				$order_no=$data->id;
				
				$item_id=$_POST['item_id_'.$data->id]; 
				
				$return_qty=$_POST['return_qty_'.$data->id]; 
				
				$unit_price=$_POST['rate_'.$data->id];
				
				$return_amt = ($return_qty*$unit_price); 
				
				$return_note =$_POST['return_note_'.$data->id];
				
				
				 $ins_sql = 'INSERT INTO sale_do_chalan_return (return_no, return_id, year, return_no_view, return_date, chalan_no, chalan_no_view, chalan_date, wo_order_no, order_no, item_name, poly_category, do_no, job_no, group_for, dealer_code, buyer_code, merchandizer_code, delivery_place, delivery_place_name, delivery_address, customer_po_no, buyer_referance, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, count_id, L_cm, W_cm, H_cm, WL, WW, flap, gusset, micron, yds, item_id, sqm_rate, sqm, additional_info, additional_charge, final_price, unit_price, total_unit, total_amt, pack_size, pack_unit, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_by, entry_at,  remarks, return_note, vehicle_type, vehicle_id, vehicle_no, driver_id, driver_name, driver_mobile, delivery_man, delivery_man_mobile)
  
  VALUES("'.$return_no.'", "'.$inv_cy_id.'", "'.$YR.'", "'.$return_no_view.'", "'.$return_date.'", "'.$data->chalan_no.'", "'.$data->chalan_no_view.'", "'.$data->chalan_date.'", "'.$data->order_no.'", "'.$order_no.'", "'.$data->item_name.'", "'.$data->poly_category.'", "'.$data->do_no.'", "'.$data->job_no.'", "'.$data->group_for.'", "'.$data->dealer_code.'", "'.$data->buyer_code.'", "'.$data->merchandizer_code.'", "'.$data->delivery_place.'", "'.$data->delivery_place_name.'", "'.$data->delivery_address.'", "'.$data->customer_po_no.'", "'.$data->buyer_referance.'", "'.$data->unit_name.'", "'.$data->measurement_unit.'", "'.$data->ply.'", "'.$data->paper_combination_id.'", "'.$data->paper_combination.'", "'.$data->count_id.'", "'.$data->L_cm.'", "'.$data->W_cm.'", "'.$data->H_cm.'", "'.$data->WL.'", "'.$data->WW.'", "'.$data->flap.'", "'.$data->gusset.'", "'.$data->micron.'", "'.$data->yds.'", "'.$data->item_id.'", "'.$data->sqm_rate.'", "'.$data->sqm.'", "'.$data->additional_info.'", "'.$data->additional_charge.'", "'.$data->final_price.'", "'.$unit_price.'", "'.$return_qty.'", "'.$return_amt.'", "'.$data->pack_size.'", "'.$data->pack_unit.'", "'.$data->style_no.'", "'.$data->po_no.'", "'.$data->referance.'", "'.$data->sku_no.'", "'.$data->printing_info.'", "'.$data->color.'", "'.$data->pack_type.'", "'.$data->size.'", "'.$data->depot_id.'", "'.$status.'",  "'.$entry_by.'", "'.$entry_at.'", "'.$remarks.'", "'.$return_note.'", "'.$data->vehicle_type.'", "'.$data->vehicle_id.'", "'.$data->vehicle_no.'", "'.$data->driver_id.'", "'.$data->driver_name.'", "'.$data->driver_mobile.'", "'.$data->delivery_man.'", "'.$data->delivery_man_mobile.'")';

db_query($ins_sql);

}

}


	

	
//	$up_sql='UPDATE sale_do_chalan SET manual_chalan="'.$manual_chalan.'", chalan_date="'.$chalan_date.'", vehicle_id="'.$vehicle_id.'", vehicle_no="'.$vehicle_no.'", 
//	driver_id="'.$driver_id.'", delivery_place="'.$delivery_place.'", delivery_place_name="'.$delivery_place_name.'", delivery_address="'.$delivery_address.'", customer_po_no="'.$customer_po_no.'", buyer_referance="'.$buyer_referance.'" WHERE chalan_no = "'.$chalan_no.'" and do_no = "'.$do_no.'" ';
//	db_query($up_sql);
	 

	 ?>

<script language="javascript">
window.location.href = "all_wo_challan.php";
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


//if(document.getElementById('unit_price').value!=''){}


//var rate = ((document.getElementById('rate').value)*1);

//var total_unit = (document.getElementById('total_unit').value) = pkt_unit*pkt_size;

var rmc_qty = ((document.getElementById('rmc_qty').value)*1);
var total_unit = ((document.getElementById('total_unit').value)*1);

//var amount = (document.getElementById('amount').value) = rate*total_unit;


if(rmc_qty<total_unit)
  {
alert('Can not issue more than stock.');
document.getElementById('total_unit').value='';

  } 

}


	
	

function TRcalculation(item_id){

var rm_stock = document.getElementById('rm_stock_'+item_id).value*1;

var total_unit = document.getElementById('total_unit_'+item_id).value*1;

 if(rm_stock<total_unit)
  {
alert('Can not issue more than stock.');
document.getElementById('total_unit_'+item_id).value='';

  } 

}




function TRcalculationpo(order_no){

var rate = document.getElementById('rate_'+order_no).value*1;

var qty = document.getElementById('qty_'+order_no).value*1;


var amount = document.getElementById('amount_'+order_no).value= (rate*qty);

// if(po_qty<adj_qty)
//  {
//alert('You can`t reduce the qty');
//document.getElementById('adj_qty_'+order_no).value='';
//document.getElementById('adj_amt_'+order_no).value='';
//  } 

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



function calculation(id){

var chalan=((document.getElementById('chalan_'+id).value)*1);

var return_qty=((document.getElementById('return_qty_'+id).value)*1);


 if(return_qty>chalan)
  {
alert('Can not issue more than chalan quantity.');
document.getElementById('return_qty_'+id).value='';
  } 


}




	function update_value(id)

	{

var order_no=id; // Rent
 
var item_id=(document.getElementById('item_id_'+id).value); 
var unit_price=(document.getElementById('unit_price_'+id).value); 
var chalan=(document.getElementById('chalan_'+id).value); 
var old_ch_qty=(document.getElementById('old_ch_qty_'+id).value); 
var pack_unit=(document.getElementById('pack_unit_'+id).value); 
var others_info=(document.getElementById('others_info_'+id).value); 
var flag=(document.getElementById('flag_'+id).value); 

var strURL="delivery_challan_edit_ajax.php?order_no="+order_no+"&item_id="+item_id+"&unit_price="+unit_price+"&chalan="+chalan+"&old_ch_qty="+old_ch_qty+"&pack_unit="+pack_unit+"&others_info="+others_info+"&flag="+flag;

		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



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
    width: 160px;
    height: 38px;
    border-radius: 0px !important;
}



/*table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}
*/

.hover_none:hover{
color:#000000 !important; 
font-weight:700;
}

</style>

<div class="form-container_large">


<form action="" method="post" name="codz" id="codz">


<? if ($data_found>0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>
								    <td width="8%" align="right" ><strong>JOB No: </strong></td>
								    <td width="14%" align="right" >
	<? $ms_data = find_all_field('sale_do_chalan','','chalan_no="'.$chalan_no.'"'); ?>
	
	<input name="chalan_no" type="hidden" id="chalan_no" style="width:90%; height:32px;" value="<?=$ms_data->chalan_no;?>" readonly="" required tabindex="1" />

	<input name="do_no" type="hidden" id="do_no" style="width:90%; height:32px;" value="<?=$ms_data->do_no;?>" readonly="" required tabindex="1" />
	<input name="job_no" type="text" id="job_no" style="width:90%; height:32px;" value="<?=$ms_data->job_no;?>"  readonly="" required tabindex="1" /></td>
								    <td width="10%" align="right" ><strong>Customer: </strong></td>



    <td width="18%" >
	
	
	<select name="dealer_code" id="dealer_code"  style="width:90%; height:32px;" required  >

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'dealer_code="'.$ms_data->dealer_code.'"');?>
      </select>	</td>
	
	 <td width="10%" align="right"><strong>Marketing Person : </strong></td>
	 <td width="15%"> <select name="marketing_person"  id="marketing_person"  tabindex="7" style="width:90%;"  >
				
    <? foreign_relation('marketing_person','person_code','marketing_person_name',$ms_data->marketing_person,  'person_code="'.$ms_data->marketing_person.'"');?>	  
    </select>		  </td>
	 </tr>
								  <tr>
								    <td align="right" width="8%" ><strong>Challan No: </strong></td>
								    <td align="right" width="14%" >
									<input name="chalan_no_view" type="text" id="chalan_no_view" style="width:90%; height:32px;" value="<?=$ms_data->chalan_no_view;?>"  readonly="" required tabindex="1" /></td>
								    <td align="right" width="10%" ><strong>  Delivery Date: </strong></td>
								    <td width="18%" >
							<input name="chalan_date" type="text" id="chalan_date" style="width:90%; height:32px;" value="<?=$ms_data->chalan_date;?>"  readonly="" required tabindex="1" />									</td>
								    <td align="right" width="10%"><strong>Delivery Address: </strong></td>
								    <td width="15%" >
									
								<input name="dealer_address" type="text" id="dealer_address" style="width:90%; height:32px;" value="<?=$ms_data->dealer_address;?>"  readonly="" required tabindex="1" />
	 
	 								</td>
							      </tr>
								</table>

</div>




<div class="box" style="width:100%; background:#EEF2FF;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>
								    <td width="18%" align="right" bgcolor="#EEF2FF" ><strong>Return Date: </strong></td>
								    <td width="14%" align="right" bgcolor="#EEF2FF" >
	
	<input name="return_date" type="text" id="return_date" style="width:90%; height:32px;" value=""  required tabindex="1" /></td>
								    <td width="16%" align="right" bgcolor="#EEF2FF" ><strong>Remarks: </strong></td>



    <td width="52%" bgcolor="#EEF2FF" >
	
	
	<input name="remarks" type="text" id="remarks" style="width:90%; height:32px;" value=""   tabindex="1" />	</td>
	 </tr>
								</table>

</div>


<? }?>




<? if($data_found>0){ ?>

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="1%">SL</th>

            <th width="14%">Product Name </th>

            <th bgcolor="#FFFFFF">UOM</th>

            <th bgcolor="#F57E22">Challan Qty </th>
            <th bgcolor="#F57E22">Return Qty </th>
            <th bgcolor="#F57E22">Return Note </th>
            </tr>
          
          

          

          <? 
		  
		  $sql = "select  id, sum(total_unit) as so_qty from sale_do_details where do_no='".$ms_data->do_no."' group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $so_qty[$info->id]=$info->so_qty;
		}
		
		
		
	$sql = "select  order_no, sum(total_unit) as pre_ch_qty from sale_do_chalan where do_no='".$ms_data->do_no."' and chalan_no!='".$chalan_no."' group by order_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pre_ch_qty[$info->order_no]=$info->pre_ch_qty;
		}	
		  
	  $sql='select a.*, b.item_name,  b.unit_name, b.pack_size from sale_do_chalan a,item_info b, item_sub_group s where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and  a.chalan_no="'.$chalan_no.'" 
		order by a.id';

$res=db_query($sql);
		  
		  while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="unit_price_<?=$row->id?>" id="unit_price_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>
           
              <td width="3%" align="center"><?=$row->unit_name?>                </td>

              <td width="7%" align="center" bgcolor="#F57E22">
			   
 <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value="<?=$row->qty?>"  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" readonly=""/>       </td>
              <td width="6%" align="center" bgcolor="#F57E22">
			  <input name="return_qty_<?=$row->id?>" type="text" id="return_qty_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" /></td>
              <td width="7%" align="center" bgcolor="#F57E22">
			  <input name="return_note_<?=$row->id?>" type="text" id="return_note_<?=$row->id?>" value=""  style="width:150px; height:25px; float:none"   />			  </td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table>

<br />

<table width="100%" border="0">




<tr>
  <td width="49%" align="center">&nbsp;</td>
  <td width="51%" align="center">&nbsp;</td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
</tr>
<tr>

<td align="center">&nbsp;</td>

<td align="center">
<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>
</tr>
</table>



<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");
//selected_two("#vehicle_id");
//selected_two("#driver_id");


?>