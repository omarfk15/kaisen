<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Delivery Challan Edit ';

//do_calander('#tdate');

$chalan_no=$_REQUEST['v_no'];


do_calander('#chalan_date','0','10');

create_combobox('vehicle_id');
create_combobox('driver_id');

do_calander('#gp_date','0','10');



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
	
	mysql_query($ins_sql);
	}

	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$gate_pass_no?>";
</script>

<? 
		
}



if(isset($_POST['confirm'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	
	$do_no=$_POST['do_no'];
	$chalan_no=$_POST['chalan_no'];
	
	$chalan_date=$_POST['chalan_date'];
	$vehicle_id=$_POST['vehicle_id'];
	$driver_id=$_POST['driver_id'];
	$delivery_place=$_POST['delivery_place'];
	$delivery_address=$_POST['delivery_address'];
	
	$customer_po_no=$_POST['customer_po_no'];
	$buyer_referance=$_POST['buyer_referance'];
	$vehicle_no=find_a_field('vehicle_registration','registration_no','vehicle_id="'.$vehicle_id.'"');
	
	
	
		//$YR = date('Y',strtotime($gp_date));
// 		$year = date('y',strtotime($gp_date));
//  		$month = date('m',strtotime($gp_date));
// 		$inv_cy_id = find_a_field('gate_pass_master','max(inv_id)','year="'.$YR.'"')+1;
//  		$cy_id = sprintf("%06d", $inv_cy_id);
//   		$gate_pass_no=''.$YR.''.$cy_id;
//		$view_gate_pass='GPN-'.$inv_cy_id.'/'.$YR;
	

	//$new_sql="UPDATE gate_pass_master SET gate_pass_no='".$gate_pass_no."', year='".$YR."', inv_id='".$cy_id."', view_gate_pass='".$view_gate_pass."', gp_date='".$gp_date."', 
//	vehicle_id='".$vehicle_id."', driver_id='".$driver_id."', lock_no='".$lock_no."', delivery_address='".$delivery_address."', status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE tr_no = '".$tr_no."' ";
//	mysql_query($new_sql);
	
	$up_sql='UPDATE sale_do_chalan SET chalan_date="'.$chalan_date.'", vehicle_id="'.$vehicle_id.'", vehicle_no="'.$vehicle_no.'", 
	driver_id="'.$driver_id.'", delivery_place="'.$delivery_place.'", delivery_address="'.$delivery_address.'", customer_po_no="'.$customer_po_no.'", buyer_referance="'.$buyer_referance.'" WHERE chalan_no = "'.$chalan_no.'" and do_no = "'.$do_no.'" ';
	mysql_query($up_sql);
	 

	 ?>

<script language="javascript">
window.location.href = "all_wo_challan.php";
</script>

<? 
		
}





//if(isset($_POST['confirm'])){

if(isset($_POST['item_add'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');	
		
	$group_for=$_POST['group_for'];
	$warehouse_id=$_POST['warehouse_id'];
	$rm_issue_type = $_POST['rm_issue_type'];
	
	
	$invoice_no = $_POST['invoice_no'];
	$invoice_date = $_POST['invoice_date'];
	
	$item_id = $_POST['item_id'];
	$unit_name = $_POST['unit_name'];
	$total_unit = $_POST['total_unit'];

	 if($item_id>0) {
	   $ins_sql = 'INSERT INTO rm_receive_details (invoice_no, invoice_date, rm_issue_type, group_for, warehouse_id, item_id, unit_name, total_unit, status, entry_at, entry_by) VALUES

("'.$invoice_no.'", "'.$invoice_date.'", "'.$rm_issue_type.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$item_id.'", "'.$unit_name.'", "'.$total_unit.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';
	
	mysql_query($ins_sql);
	
	$tr_no = mysql_insert_id();

	journal_item_control($item_id, $warehouse_id, $invoice_date,  $total_unit, 0, 'Receive', $tr_no, $unit_price, $warehouse_id, $invoice_no, '', '', '','','', $group_for, $unit_price);
	
	}

	//$new_sql="UPDATE po_bill_master SET status='".$status."' WHERE bill_id = '".$bill_id."' ";
	// mysql_query($new_sql);
	 
	 
	
	 
	 
	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}






if(isset($_POST['delete'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
		
	$do_no = $_POST['do_no'];
	$chalan_no = $_POST['chalan_no'];
	

	$sql_del_dt = 'delete from sale_do_chalan where do_no="'.$do_no.'" and chalan_no="'.$chalan_no.'"';
	mysql_query($sql_del_dt);
	
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



	function update_value(order_no)



	{

var order_no=order_no; // Rent

var item_id=(document.getElementById('item_id_'+order_no).value);

//var rate=(document.getElementById('rate_'+order_no).value);
var total_unit=(document.getElementById('total_unit_'+order_no).value);
//var amount=(document.getElementById('amount_'+order_no).value);
var flag=(document.getElementById('flag_'+order_no).value); 

var strURL="item_revise_ajax.php?order_no="+order_no+"&item_id="+item_id+"&total_unit="+total_unit+"&flag="+flag;

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
$query = mysql_query($sql);
while($data=mysql_fetch_object($query)){
?>
foe_amt = foe_amt + document.getElementById('foe_amt_<?=$data->ledger_id?>').value*1;;
<?
}

?>

document.getElementById('foe_amt').value = foe_amt;

}



function calculation(id){

var chalan=((document.getElementById('chalan_'+id).value)*1);

var pending_qty=((document.getElementById('ch_pending_'+id).value)*1);




 if(chalan>pending_qty)
  {
alert('Can not issue more than order quantity.');
document.getElementById('chalan_'+id).value='';


  } 



}




	function update_value(id)

	{

var order_no=id; // Rent
 
var item_id=(document.getElementById('item_id_'+id).value); 
var unit_price=(document.getElementById('unit_price_'+id).value); 
var chalan=(document.getElementById('chalan_'+id).value); 
var pack_unit=(document.getElementById('pack_unit_'+id).value); 
var others_info=(document.getElementById('others_info_'+id).value); 
var flag=(document.getElementById('flag_'+id).value); 

var strURL="delivery_challan_edit_ajax.php?order_no="+order_no+"&item_id="+item_id+"&unit_price="+unit_price+"&chalan="+chalan+"&pack_unit="+pack_unit+"&others_info="+others_info+"&flag="+flag;

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

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td width="10%" align="right" ><strong>Date: </strong></td>

<? $dealer_data=find_all_field('dealer_info','','dealer_code='.$dealer_code);?>

 <td width="18%" ><input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>" required tabindex="1" readonly="" /></td>
	
	 <td width="12%" align="right" ><strong>  Vehicle: </strong></td>
	 <td width="18%" >
	 
	 <select name="vehicle_id" required id="vehicle_id"  style="width:90%;">
					
					<option></option>
				
                      <? foreign_relation('vehicle_registration','vehicle_id','registration_no',$vehicle_id,'status="Active"');?>
            </select></td>
	 <td width="11%" align="right" ><strong>Driver: </strong></td>
	 <td width="16%" ><select name="driver_id" required id="driver_id"  tabindex="7" style="width:90%;">
				<option></option>
					
                      <? foreign_relation('driver_registration','driver_id','driver_name',$driver_id,'status="Active"');?>
                    </select></td>
	 <td width="15%" rowspan="8" align="center" ><strong>

      <input type="submit" name="master_data" id="master_data" value="Initiate Entry" style="width:90%; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
    </tr>
								  <tr>
								    <td align="right" ><strong> Customer: </strong></td>
								    <td >
		<select name="dealer_code" id="dealer_code"  style="width:90%; height:32px;" required  >

      

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'dealer_code="'.$_REQUEST['dealer_code'].'"');?>
      </select>									</td>
								    <td align="right"><strong>Address: </strong></td>
								    <td >
		
		<input style="width:90%;  height:32px;"  name="delivery_address" type="text" id="delivery_address" value="<?=$dealer_data->shipping_address;?>"  />
		</td>
								    <td align="right" ><strong>Lock No: </strong></td>
								    <td >
		<input name="lock_no" type="text" id="lock_no" style="width:90%; height:32px;" value="<?=$lock_no;?>"  tabindex="1" />									</td>
							      </tr>
								  
								 
								  
								</table>

</div>


<? }?>



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
	
	 <td width="11%" align="right"><strong>Driver: </strong></td>
	 <td width="18%"><select name="driver_id"  id="driver_id"  tabindex="7" style="width:90%;" required>
	 <option></option>
      
       <? foreign_relation('driver_registration','driver_id','driver_name',$ms_data->driver_id,'1');?>
     </select>	  </td>
	 <td width="5%" align="right"><strong> Vehicle: </strong></td>
	 <td width="16%" >
	
	  
	  <select name="vehicle_id"  id="vehicle_id"  style="width:90%;" required>
	  <option></option>
					
				
                      <? foreign_relation('vehicle_registration','vehicle_id','registration_no',$ms_data->vehicle_id,'1');?>
            </select>	  </td>
	 </tr>
								  <tr>
								    <td align="right" width="8%" ><strong>Challan No: </strong></td>
								    <td align="right" width="14%" >
									<input name="chalan_no_view" type="text" id="chalan_no_view" style="width:90%; height:32px;" value="<?=$ms_data->chalan_no_view;?>"  readonly="" required tabindex="1" /></td>
								    <td align="right" width="10%" ><strong>  Delivery Date: </strong></td>
								    <td width="18%" >
							<input name="chalan_date" type="text" id="chalan_date" style="width:90%; height:32px;" value="<?=$ms_data->chalan_date;?>"  readonly="" required tabindex="1" />									</td>
								    <td align="right" width="11%"><strong>Delivery Place: </strong></td>
								    <td width="18%" >
									 <? $dealer_data=find_all_field('dealer_info','','dealer_code='.$ms_data->dealer_code);?>
	 
	  <select name="delivery_place"  id="delivery_place"  tabindex="7" style="width:90%;" required onchange="getData2('delivery_place_edit_ajax.php', 'delivery_place_filter', this.value, document.getElementById('delivery_place').value);" >
				<option></option>
					
                      <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$ms_data->delivery_place,'dealer_group="'.$dealer_data->dealer_group.'"');?>
					  
					  <option value="5">Other Delivery Place</option>
            </select>
			
												</td>
								    <td align="right" width="5%">&nbsp;</td>
								    <td width="16%">&nbsp;</td>
						          </tr>
								  <tr>
								    <td align="right" ><strong>Customer's PI/ SPO/ ERP/ Job No:</strong></td>
								    <td align="right" ><input name="customer_po_no" type="text" id="customer_po_no" style="width:90%; height:32px;" value="<?=$ms_data->customer_po_no;?>"    tabindex="1" /></td>
								    <td align="right" ><strong>Buyer Referance:</strong></td>
								    <td ><input name="buyer_referance" type="text" id="buyer_referance" style="width:90%; height:32px;" value="<?=$ms_data->buyer_referance;?>"    tabindex="1" /></td>
								    <td align="right"><strong>Deli. Address:</strong></td>
								    <td colspan="2" >
									<span id="delivery_place_filter"> 
									<input name="delivery_address" type="text" id="delivery_address" style="width:90%; height:32px;" value="<?=$ms_data->delivery_address;?>"  tabindex="1" /></span></td>
								    <td>&nbsp;</td>
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

            <th width="9%"><strong>Style No</strong></th>
            <th width="7%"><strong>PO No</strong></th>
            <th width="7%">Destination</th>
            <th width="4%"><strong>SKU</strong></th>
            <th width="5%"><strong>Color</strong></th>
            <th width="2%"><strong>Size</strong></th>
            <th bgcolor="#FFFFFF">UOM</th>

            <th bgcolor="#FFFFFF">Measurement</th>
            <th bgcolor="#F57E22">Order Qty </th>
            <th bgcolor="#F57E22">Challan Qty </th>
            <th bgcolor="#F57E22">Bundle</th>
            <th bgcolor="#F57E22">Others Info </th>
            <th bgcolor="#D78AF2">Action</th>
          </tr>
          
          

          

          <? 
		  
		  $sql = "select  id, sum(total_unit) as so_qty from sale_do_details where do_no='".$ms_data->do_no."' group by id";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $so_qty[$info->id]=$info->so_qty;
		}
		
		$sql = "select  wo_order_no, sum(total_unit) as pr_qty from production_job_card_receive where do_no='".$ms_data->do_no."' group by wo_order_no";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $pr_qty[$info->wo_order_no]=$info->pr_qty;
		}
		
		$sql = "select  order_no, sum(total_unit) as pre_ch_qty from sale_do_chalan where do_no='".$ms_data->do_no."' and chalan_no!='".$chalan_no."' group by order_no";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $pre_ch_qty[$info->order_no]=$info->pre_ch_qty;
		}
		
		  
	  $sql='select a.id, a.order_no, a.item_id, a.pack_unit, a.others_info, a.unit_price,   b.item_name,  b.unit_name, a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit,
	    a.total_unit as qty , a.delivery_place, a.delivery_date, a.style_no, a.po_no, a.destination, a.referance, a.sku_no, a.pack_type, a.color, a.size, b.pack_size from sale_do_chalan a,item_info b, item_sub_group s where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and  a.chalan_no='.$chalan_no;

$res=mysql_query($sql);
		  
		  while($row=mysql_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="unit_price_<?=$row->id?>" id="unit_price_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>
           
              <td>
			  
		<? 
		  if ($row->style_no!="") {
		  echo $row->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  <? 
		  if ($row->po_no!="") {
		  echo $row->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td><? 
		  if ($row->destination!="") {
		  echo $row->destination;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td>
			  <? 
		  if ($row->sku_no!="") {
		  echo $row->sku_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  
			  <? 
		  if ($row->color!="") {
		  echo $row->color;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  
			   <? 
		  if ($row->size!="") {
		  echo $row->size;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td width="3%" align="center"><?=$row->unit_name?>                </td>

              <td width="15%" align="center">
			  
			  <? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?>			  </td>
              <td width="7%" align="center" bgcolor="#F57E22">
			  <input name="so_qty_<?=$row->id?>" type="text" id="so_qty_<?=$row->id?>" value="<?=$so_qty[$row->order_no];?>"  readonly="" style="width:80px; height:25px; float:none"  />  
			  <input name="pr_qty_<?=$row->id?>" type="hidden" id="pr_qty_<?=$row->id?>" value="<?=$pr_qty[$row->order_no];?>"  style="width:80px; height:25px; float:none"   />
			  <input name="pre_ch_qty_<?=$row->id?>" type="hidden" id="pre_ch_qty_<?=$row->id?>" value="<?=$pre_ch_qty[$row->order_no];?>"  style="width:80px; height:25px; float:none" />  
			  <input name="ch_pending_<?=$row->id?>" type="hidden" id="ch_pending_<?=$row->id?>" value="<?=$ch_pending_qty=($pr_qty[$row->order_no]-$pre_ch_qty[$row->order_no]);?>"  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />			  </td> 
              <td width="7%" align="center" bgcolor="#F57E22">
			   
  <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value="<?=$row->qty?>"  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />              		  </td>
              <td width="6%" align="center" bgcolor="#F57E22">
			  <input name="pack_unit_<?=$row->id?>" type="text" id="pack_unit_<?=$row->id?>" value="<?=$row->pack_unit?>"  style="width:50px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" /></td>
              <td width="7%" align="center" bgcolor="#F57E22">
			  <input name="others_info_<?=$row->id?>" type="text" id="others_info_<?=$row->id?>" value="<?=$row->others_info?>"  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />
			  
			  </td>
              <td width="6%" align="center" >
			 <div align="center"><span id="divi_<?=$row->id?>">
	    
	    
	    <input name="flag_<?=$row->id?>" type="hidden" id="flag_<?=$row->id?>" value="0" />
	    
	    <input type="button" name="Button" value="EDIT"  onclick="update_value(<?=$row->id?>)" style="width:70px; font-size:12px; height:28px; background-color:  #e74c3c ; font-weight:700;"/>
	    
	      </span>	      </div>         	  </td>
          </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table>

<br />

<? if($rmc_data_found==0){?>
<table width="100%" border="0">

<tr>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
</tr>
<tr>

<td align="center">&nbsp;
<input name="delete" type="submit" class="btn1" value="DELETE" style="width:200px; font-weight:bold; float:left; font-size:12px; height:30px; background:#FF0000;color: #000000; border-radius:50px 20px;" /></td>

<td align="center">
<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>
</tr>
</table>
<? }?>


<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>