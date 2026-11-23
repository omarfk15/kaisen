<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Demand Order';

//do_calander('#tdate');



$do_no=$_REQUEST['do_no'];

$data_found = $do_no;

if ($data_found==0) {
//do_calander('#invoice_date');
do_calander('#need_by');
//create_combobox('fg_item_id');
  }


if(prevent_multi_submit()){


if(isset($_POST['master_data'])){
	
	$status = 'MANUAL';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	
	$depot_id=$_SESSION['user']['depot'];
	$group_for=$_SESSION['user']['group'];
	
	$do_date = $_POST['invoice_date'];
	$dealer_code = $_POST['dealer_code'];
	$dealer_contact_no = $_POST['dealer_contact_no'];
	$dealer_address = $_POST['dealer_address'];
	$marketing_person = $_POST['marketing_person'];
	$delivery_address = $_POST['delivery_address'];
	$remarks = $_POST['remarks'];
	$po_no = $_POST['po_no'];
	$order_type = $_POST['order_type'];
	
	
	
		$YR = date('Y',strtotime($do_date));
 		$year = date('y',strtotime($do_date));
  		$month = date('M',strtotime($do_date));
 		$inv_cy_id = find_a_field(' sale_do_master','max(job_id)','year="'.$YR.'"')+1;
  		$cy_id = sprintf("%06d", $inv_cy_id);
   		$invoice_no=''.$YR.''.$cy_id;
		$view_invoice_no='KMI/DO-'.$month.' '.$year.'/'.$inv_cy_id;
	 
	 
	 if($invoice_no>0) {
	  $ins_sql = 'INSERT INTO sale_do_master (do_no, do_date, year, job_id, job_no, group_for, sales_type, dealer_code, dealer_contact_no, dealer_address, delivery_address, marketing_person, marketing_contact_no, remarks, status, depot_id, discount, cash_discount, entry_at, entry_by, po_no, order_type) VALUES

("'.$invoice_no.'", "'.$do_date.'", "'.$YR.'", "'.$inv_cy_id.'", "'.$view_invoice_no.'", "'.$group_for.'", "'.$sales_type.'", "'.$dealer_code.'", "'.$dealer_contact_no.'", "'.$dealer_address.'", "'.$delivery_address.'", "'.$marketing_person.'", "'.$marketing_contact_no.'", "'.$remarks.'", "'.$status.'", "'.$depot_id.'", "'.$discount.'", "'.$cash_discount.'", "'.$entry_at.'", "'.$entry_by.'", "'.$po_no.'", "'.$order_type.'")';
	
	db_query($ins_sql);
	}
	 
	 ?>
	 
<? if($order_type=='RFT') {?>
<script language="javascript">
window.location.href = "../sales_order_rft/do_entry.php?do_no=<?=$invoice_no?>";
</script>
<? }else{?>
<script language="javascript">
window.location.href = "do_entry.php?do_no=<?=$invoice_no?>";
</script>
<? }?>

<? 
		
}






//if(isset($_POST['confirm'])){

if(isset($_POST['item_add'])){
	
	$status = 'MANUAL';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');	
		
	$depot_id=$_SESSION['user']['depot'];
	$group_for=$_SESSION['user']['group'];
	
	$do_no = $_POST['do_no'];
	$job_no = $_POST['job_no'];
	$do_date = $_POST['do_date'];
	$dealer_code = $_POST['dealer_code'];
	$marketing_person = $_POST['marketing_person'];
	
	$item_id = $_POST['item_id'];
	$unit_name = $_POST['unit_name'];
	$size = $_POST['size'];
	$thickness = $_POST['thickness'];
	$mark = $_POST['mark'];
	$length = $_POST['length'];
	$min_price = $_POST['min_price'];
	$unit_price = $_POST['unit_price'];
	$total_unit_pcs = $_POST['total_unit_pcs'];
	$per_pcs_weight = $_POST['per_pcs_weight'];
	$total_unit = $_POST['total_unit'];
	$total_amt = $_POST['total_amt'];
			
			
	 if($item_id>0 && $total_unit>0) {
 $ins_sql = 'INSERT INTO sale_do_details (do_no, job_no, group_for, dealer_code, item_id, unit_name, unit_price, length, thickness, total_unit_pcs, per_pcs_weight, total_unit, total_amt, depot_id, status, do_date, entry_by, entry_at, size, mark, min_price)
 VALUES
("'.$do_no.'", "'.$job_no.'", "'.$group_for.'", "'.$dealer_code.'", "'.$item_id.'", "'.$unit_name.'", "'.$unit_price.'", "'.$length.'", "'.$thickness.'", "'.$total_unit_pcs.'", "'.$per_pcs_weight.'", "'.$total_unit.'", "'.$total_amt.'", "'.$depot_id.'", "'.$status.'", "'.$do_date.'", "'.$entry_by.'", "'.$entry_at.'", "'.$size.'", "'.$mark.'", "'.$min_price.'")';
	
	db_query($ins_sql);
	}

	 
	 
	 
	 ?>

<script language="javascript">
window.location.href = "do_entry.php?do_no=<?=$do_no?>";
</script>

<? 
		
}






if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$do_no = $_POST['do_no'];
	
	$new_sql="UPDATE sale_do_master SET status='".$status."', entry_by='".$entry_by."', entry_at='".$entry_at."' WHERE do_no = '".$do_no."' ";
	db_query($new_sql);
	 
	 ?>

<script language="javascript">
window.location.href = "sales_order_list.php";
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


var min_price = ((document.getElementById('min_price').value)*1);
var unit_price = ((document.getElementById('unit_price').value)*1);




}



function count_min_cal(){


var min_price=(document.getElementById('min_price').value)*1; 
var unit_price=(document.getElementById('unit_price').value)*1; 

var total_unit_pcs = ((document.getElementById('total_unit_pcs').value)*1);
var per_pcs_weight = ((document.getElementById('per_pcs_weight').value)*1);
var total_unit = (document.getElementById('total_unit').value) = total_unit_pcs*per_pcs_weight;

var total_amt = (document.getElementById('total_amt').value) = unit_price*total_unit;

//alert(sqm_rate);

//alert(sqm);

 if(unit_price<min_price)
  {
alert('You can`t reduce the price');
document.getElementById('unit_price').value=(min_price);
  }

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

var min_price = document.getElementById('min_price_'+order_no).value*1;

var unit_price = document.getElementById('unit_price_'+order_no).value*1;

var total_amt = document.getElementById('total_amt_'+order_no).value= (total_unit*unit_price);

 if(unit_price<min_price)
  {
alert('You can`t reduce the qty');
document.getElementById('unit_price_'+order_no).value='';
document.getElementById('total_amt_'+order_no).value='';
  } 

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

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
								    <td colspan="4" align="left" >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										
										<? $dealer_data = find_all_field('dealer_info','','dealer_code="'.$_REQUEST['dealer_code'].'"'); ?>
											<tr>
												<td width="50%"><strong> DO Date: </strong></td>
												<td width="50%"><strong> Party Name: </strong></td>
											</tr>
											<tr>
												<td width="50%">
<input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?php echo date('Y-m-d');?>" required  readonly=""  tabindex="1" /></td>
												<td width="50%">
		<select name="dealer_code" id="dealer_code"  style="width:90%; height:32px;" required>


		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 and dealer_code="'.$_REQUEST['dealer_code'].'"');?>
      </select>												</td>
											</tr>
											
											
											
											<tr>
												<td width="50%"><strong> Party Mobile No: </strong></td>
												<td width="50%"><strong> Party Address: </strong></td>
											</tr>
											<tr>
												<td width="50%">
<input name="dealer_contact_no" type="text" id="dealer_contact_no" style="width:90%; height:32px;" value="<?=$dealer_data->contact_no;?>"  autocomplete="off" tabindex="1" /></td>
												<td width="50%">
		<input name="dealer_address" type="text" id="dealer_address" style="width:90%; height:32px;" value="<?=$dealer_data->address_e;?>"    autocomplete="off"  tabindex="1" />												</td>
											</tr>
											
											
											<tr>
												<td width="50%"><strong> Marketing Person: </strong></td>
												<td width="50%"><strong> Delivery Address: </strong></td>
											</tr>
											<tr>
												<td width="50%">
<select name="marketing_person" id="marketing_person"  style="width:90%; height:32px;" required>

<? foreign_relation('marketing_person','person_code','marketing_person_name',$dealer_data->marketing_person,'person_code="'.$dealer_data->marketing_person.'"');?>
      </select></td>
												<td width="50%">
		<input name="delivery_address" type="text" id="delivery_address" style="width:90%; height:32px;" value="<?=$dealer_data->address_e;?>" autocomplete="off"    tabindex="1" />												</td>
											</tr>
											
											<tr>
												<td width="50%"><strong> Order Type: <span style="color:#FF0000; font-weight:700;">*</span> </strong></td>
												<td width="50%"><strong> PO No: </strong></td>
								  </tr>
								  
								  
								  <tr>
												<td width="50%">
<select name="order_type" id="order_type"  style="width:90%; height:32px;" required>
<option></option>
<? foreign_relation('order_type','order_type','order_type',$order_type,'1');?>
</select></td>
												<td width="50%" ><input name="po_no" type="text" id="po_no" style="width:90%; height:32px;" value=""    tabindex="1"  autocomplete="off" /></td>
										  </tr>
								  <tr>
								    <td><strong> Remarks: </strong></td>
								    <td align="center">&nbsp;</td>
								    </tr>
								  <tr>
								    <td><input name="remarks" type="text" id="remarks" style="width:90%; height:32px;" value=""    tabindex="1"  autocomplete="off" /></td>
								    <td width="50%" align="center">
<input type="submit" name="master_data" id="master_data" value="Initiate Entry" style="width:180px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>												</td>
								    </tr>
										</table>
									</td>
							      </tr>
	
								</table>

</div>


<? }?>



<? if ($data_found>0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
								    <td colspan="4" align="left" >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										
										<? $ms_data = find_all_field('sale_do_master','','do_no="'.$_REQUEST['do_no'].'"'); ?>
											<tr>
												<td width="50%"><strong> DO No: </strong></td>
												<td width="50%"><strong> DO Date: </strong></td>
												
											</tr>
											<tr>
												<td width="50%">
												<input name="do_no" type="hidden" id="do_no" style="width:90%; height:32px;" value="<?php echo $ms_data->do_no;?>" required  readonly=""  tabindex="1" />
<input name="job_no" type="text" id="job_no" style="width:90%; height:32px;" value="<?php echo $ms_data->job_no;?>" required  readonly=""  tabindex="1" /></td>
												<td width="50%">
												
												<input name="do_date" type="text" id="do_date" style="width:90%; height:32px;" value="<?php echo $ms_data->do_date;?>" required  readonly=""  tabindex="1" />
		
												</td>
											</tr>
											
											
											
											<tr>
												<td width="50%"><strong> Party Name: </strong></td>
												<td width="50%"><strong> Party Address: </strong></td>
												
											</tr>
											<tr>
												<td width="50%">
												<select name="dealer_code" id="dealer_code"  style="width:90%; height:32px;" required>
		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 and dealer_code="'.$ms_data->dealer_code.'"');?>
      </select>
</td>
												<td width="50%">
		<input name="dealer_address" type="text" id="dealer_address" style="width:90%; height:32px;" value="<?=$ms_data->dealer_address;?>"    autocomplete="off"  tabindex="1" />
												</td>
											</tr>
											
											
											<tr>
												<td width="50%"><strong> Party Mobile No: </strong></td>
												<td width="50%"><strong> Delivery Address: </strong></td>
												
											</tr>
											<tr>
												<td width="50%">
	<input name="dealer_contact_no" type="text" id="dealer_contact_no" style="width:90%; height:32px;" value="<?=$ms_data->dealer_contact_no;?>"  autocomplete="off" tabindex="1" />
</td>
												<td width="50%">
		<input name="delivery_address" type="text" id="delivery_address" style="width:90%; height:32px;" value="<?=$ms_data->delivery_address;?>" autocomplete="off"    tabindex="1" />
												</td>
											</tr>
											
											<tr>
												<td width="50%"><strong> Marketing Person: </strong></td>
												<td width="50%"><strong> Remarks: </strong></td>
												
								  </tr>
								  
								  
								  <tr>
												<td width="50%">
<select name="marketing_person" id="marketing_person"  style="width:90%; height:32px;" required>

		<? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'person_code="'.$ms_data->marketing_person.'" ');?>
      </select>
</td>
												<td width="50%">
<input name="remarks" type="text" id="remarks" style="width:90%; height:32px;" value="<?=$ms_data->remarks?>"    tabindex="1"  autocomplete="off" /></td>
										  </tr>
											
										</table>
									</td>
							      </tr>
	
								</table>

</div>





<?php /*?><div class="box" style="width:100%;">						
								<table width="100%">
                            
                             <tr>
							 <td> &nbsp;</td>

								    
								  <tr>
                            
                          </table>

    </div><?php */?>


<? }?>



<? if($data_found>0){ ?>


<div class="tabledesign2" style="width:100%">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
								    <th style="height:30px">Code</th>
								    <th width="67%" rowspan="2"  style="text-align:center; background:#FFFFFF; margin:0px; padding:0px;   border:none; "  >
									<span id="item_data_found">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px;">
										<tr>
											<th style="height:30px">Description</th></tr>
											<tr >
											<td><input name="description" type="text" class="input3"   autocomplete="off"  value="" id="description" style="width:94%; height:30px;"  readonly=""/></td>
										</tr>
									</table>
								</span>								</th>
							      </tr>
								  <tr>

								 <td width="33%">
									
		 
						 
	<select id="item_id" name="item_id"  style="width:100%;" class="js-example-basic-single"
	 onchange="getData2('item_data_ajax.php', 'item_data_found', this.value, document.getElementById('item_id').value);"  >
	  <option></option>
	 	
		<? foreign_relation('item_info i, item_sub_group s','i.item_id','concat(i.finish_goods_code," : ",i.item_name)',$item_id, 
		'i.sub_group_id=s.sub_group_id and i.finish_goods_code>0 and s.group_id=100000000 order by  i.sub_group_id, i.finish_goods_code');?>
    </select> 									</td>
								  </tr>
								</table>
								
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="20%"><input name="total_unit_pcs" type="text" class="input3"   autocomplete="off"  value="" id="total_unit_pcs" style="width:90%; height:30px;" onkeyup="count_min_cal()" placeholder="Qty in Pcs" /></td>
										<td width="20%"><input name="per_pcs_weight" type="text" class="input3"   autocomplete="off"  value="" id="per_pcs_weight" style="width:90%; height:30px;" onkeyup="count_min_cal()"  placeholder="Per Pcs Weight"/></td>
										<td width="20%"><input name="total_unit" type="text" class="input3"   autocomplete="off"  value="" id="total_unit" style="width:90%; height:30px;" readonly="" placeholder="Total Qty" /></td>
										<td width="20%"><input name="total_amt" type="text" class="input3"   autocomplete="off"  value="" id="total_amt" style="width:90%; height:30px;"  readonly=""  placeholder="Total Amt"/></td>
										<td width="20%">
		<input name="item_add" type="submit" id="item_add" value="ADD" style="width:91%; height:40px; background:#FF0000; color:#000000; font-weight:700;" /></td>
									</tr>
								
								</table>
								
								
								
								
	</div>
	
	
	
	
								
		
	
<? }?>


<? if($data_found>0){ ?>


<br />




<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="5%">Code</th>

    <th width="27%"> <span style="height:30px">Item Description</span></th>
    <th width="12%">Qty/Pcs</th>
    <th width="12%">Pcs/weight</th>
    <th width="12%">qty/Kg</th>
    <th width="12%">U.Price</th>
    <th width="12%">Amount</th>
    <th width="8%"><div align="center">Action</div></th>
  </tr>
  
  

  <?
  

    $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from sale_do_details a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.do_no='".$do_no."' order by a.id desc";

  $queryfg = db_query($sqlfg);

  while($datafg=mysqli_fetch_object($queryfg)){$i++;
  ?>

  <tr  bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td width="5%"><?=$datafg->finish_goods_code?></td>

    <td  width="27%" style="white-space:normal"> <?=$datafg->item_name?>
	
    <input name="item_id_<?=$datafg->id?>" type="hidden" id="item_id_<?=$datafg->id?>" value="<?=$datafg->item_id?>" />	</td>
    <td  width="12%" bgcolor="#99CCFF"><input name="total_unit_pcs_<?=$datafg->id?>" type="text" id="total_unit_pcs_<?=$datafg->id?>" value="<?=$datafg->total_unit_pcs; ?>" onkeyup="TRcalculation(<?=$datafg->id?>)" style="width:95%; height:30px; " /></td>
    <td  width="12%" bgcolor="#99CCFF"><input name="per_pcs_weight_<?=$datafg->id?>" type="text" id="per_pcs_weight_<?=$datafg->id?>" value="<?=$datafg->per_pcs_weight;?>" onkeyup="TRcalculation(<?=$datafg->id?>)" style="width:95%; height:30px; " /></td>
    <td  width="12%" bgcolor="#99CCFF"><input name="total_unit_<?=$datafg->id?>" type="text" id="total_unit_<?=$datafg->id?>" value="<?=$datafg->total_unit; ?>" readonly="" style="width:95%; height:30px; " /></td>
    <td  width="12%" bgcolor="#99CCFF">
	<input name="min_price_<?=$datafg->id?>" type="hidden" id="min_price_<?=$datafg->id?>" value="<?=$datafg->min_price;?>" onkeyup="TRcalculation_cal(<?=$datafg->id?>)" style="width:95%; height:30px; " />
	<input name="unit_price_<?=$datafg->id?>" type="text" id="unit_price_<?=$datafg->id?>" value="<?=$datafg->unit_price;?>"  onchange="TRcalculation_cal(<?=$datafg->id?>)" style="width:95%; height:30px; " /></td>
    <td  width="12%" bgcolor="#99CCFF">
	<input name="total_amt_<?=$datafg->id?>" type="text" id="total_amt_<?=$datafg->id?>" value="<?=$datafg->total_amt; $tot_total_amt+=$datafg->total_amt;?>"  readonly="" style="width:95%; height:30px; " /></td>
    <td width="8%">
	
	<span id="divi_<?=$datafg->id?>">
	<input name="flag_<?=$datafg->id?>" type="hidden" id="flag_<?=$datafg->id?>" value="0" />

	<input type="button" name="Button" value="EDIT"  onclick="update_value(<?=$datafg->id?>)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>
    </span></td>
  </tr>
  
  

  <? } ?>
  
  <tr style="font-size:14px;">
    <td>&nbsp;</td>
    <td ><strong>Total</strong></td>
    <td bgcolor="#99CCFF">&nbsp;</td>
    <td bgcolor="#99CCFF">&nbsp;</td>
    <td bgcolor="#99CCFF">&nbsp;</td>
    <td bgcolor="#99CCFF">&nbsp;</td>
    <td bgcolor="#99CCFF"><strong><?=number_format($tot_total_amt,2)?></strong></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<br />



<br /><br />




<table width="100%" border="0">





<? if($bill_data->status!="COMPLETED") {?>
<tr>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>
</tr>
<? }?>
</table>


<?php /*?><table width="100%" border="0">

<? 

 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


if($pi_status!="MANUAL"){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table><?php */?>




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