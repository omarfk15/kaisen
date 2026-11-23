<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Local Purchase Requisition (Offset)';

//do_calander('#tdate');

do_calander('#exp_date');

$invoice_no=$_REQUEST['request_no'];

$data_found = $invoice_no;

if ($data_found==0) {
do_calander('#invoice_date');
do_calander('#need_by');
//create_combobox('fg_item_id');
  }


if(prevent_multi_submit()){


if(isset($_POST['master_data'])){
	
	$status = 'MANUAL';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$warehouse_id=$_POST['warehouse_id'];
	$group_for=$_POST['group_for'];
	$need_by = $_POST['need_by'];
	$inv_type = $_POST['inv_type'];
	$remarks = $_POST['remarks'];
	$department = $_POST['department'];
	$section = $_POST['section'];
	  $requisition_by = $_POST['requisition_by'];
	  $cr_date=date('Y-m-d');
	$invoice_date = $_POST['invoice_date']=$cr_date;
		
	//$pr_date = $_POST['so_date'];
	//$fg_item_id = $_POST['fg_item_id'];
	//$item_watt = find_a_field('item_info','item_watt','item_id="'.$_POST['fg_item_id'].'"');
	//$group_for=$_SESSION['user']['group'];
	//$warehouse_id=$_SESSION['user']['depot'];
	
	
		$YR = date('Y',strtotime($invoice_date));
 		$year = date('y',strtotime($invoice_date));
  		$month = date('m',strtotime($invoice_date));
 		$inv_cy_id = find_a_field('purchase_requisition_master','max(inv_id)','year="'.$YR.'"')+1;
  		$cy_id = sprintf("%06d", $inv_cy_id);
   		$invoice_no=''.$year.''.$month.''.$cy_id;
		$view_invoice_no='REQ-'.$year.''.$month.''.$cy_id;
	
	
	

	//$tr_no = date('ymd',strtotime($tr_date));
//	
//	$lot_cy_id = find_a_field('import_purchase_details','max(lot_id)','tr_no="'.$tr_no.'"')+1;
//		
//   	$cy_id = sprintf("%04d", $lot_cy_id);
//	
//   	 $lot_no_generate='LOT'.$tr_no.''.$cy_id;
	 
	 
	 if($invoice_no>0) {
	  $ins_sql = 'INSERT INTO purchase_requisition_master (invoice_no, year, inv_id, view_invoice_no, inv_type, group_for, warehouse_id, invoice_date, need_by, status, entry_at, entry_by, remarks,department,section,requisition_by) VALUES

("'.$invoice_no.'", "'.$YR.'", "'.$cy_id.'", "'.$view_invoice_no.'", "'.$inv_type.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$invoice_date.'", "'.$need_by.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$remarks.'", "'.$department.'", "'.$section.'", "'.$requisition_by.'")';
	
	db_query($ins_sql);
	}

	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}



if(isset($_POST['foe_amt'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$bom_no = $_POST['bom_no'];
	$bom_date = $_POST['bom_date'];
	$bom_no = $_POST['bom_no'];
	$fg_item_id = $_POST['fg_item_id'];
	$group_for = $_POST['group_for'];
	
	$sql_del_foe = 'delete from bom_factory_overhead where  bom_no="'.$bom_no.'"';
	db_query($sql_del_foe);
	
		
	 $sql = 'select l.group_name, a.ledger_id, a.ledger_name from ledger_group l, accounts_ledger a 
	 where l.group_id=a.ledger_group_id and a.ledger_group_id=411010 order by l.group_id, a.ledger_id';

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{

			if($_POST['foe_amt_'.$data->ledger_id]>0)

			{
			
				$ledger_id=$_POST['ledger_id_'.$data->ledger_id];
			
				$foe_amt=$_POST['foe_amt_'.$data->ledger_id];
				

  $foe_invoice = 'INSERT INTO bom_factory_overhead (bom_no, group_for, bom_date, fg_item_id, ledger_id, amount, status, entry_at, entry_by)
  
  VALUES("'.$bom_no.'", "'.$group_for.'", "'.$bom_date.'", "'.$fg_item_id.'", "'.$ledger_id.'", "'.$foe_amt.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';

db_query($foe_invoice);


	 //$inv_sql="UPDATE purchase_sp_invoice SET adj_qty='".$adj_qty."', adj_amt='".$adj_amt."' WHERE id = '".$order_no."' ";
	 //db_query($inv_sql);

	

}

}


	//$new_sql="UPDATE purchase_sp_master SET adjustment_po_amt='".$tot_adj_amt."' WHERE po_no = '".$po_no."' ";
	// db_query($new_sql);

	 
	 ?>

<!--<script language="javascript">
window.location.href = "invoice_entry.php?request_po=<?=$po_no?>";
</script>-->

<? 
		
}





//if(isset($_POST['confirm'])){

if(isset($_POST['item_add'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');	
		
	$warehouse_id=$_POST['warehouse_id'];
	$group_for=$_POST['group_for'];
	$need_by = $_POST['need_by'];
	$inv_type = $_POST['inv_type'];
	
	
	$invoice_no = $_POST['invoice_no'];
	$invoice_date = $_POST['invoice_date'];
	
	$item_id = $_POST['item_id'];
	$unit_name = $_POST['unit_name'];
	$total_unit = $_POST['total_unit'];
	$item_type = $_POST['item_type'];
	$count_type = $_POST['count_type'];
	
	$last_po_no = $_POST['last_po_no'];
	$last_po_id = $_POST['last_po_id'];
	$country_origin = $_POST['country_origin'];
	$in_stock = $_POST['in_stock'];
			$note = $_POST['note'];
			$lead_time = $_POST['lead_time'];
			$gsm = $_POST['gsm'];
			$model = $_POST['model'];
			$L = $_POST['L'];
			$W = $_POST['W'];
			$thickness = $_POST['thickness'];
			$measurement_unit = $_POST['measurement_unit'];
			
			$brand = $_POST['brand'];
			$part_no= $_POST['part_no'];
			$section= $_POST['section'];
			$exp_date= $_POST['exp_date'];
			$other_ins= $_POST['other_ins'];
	 if($item_id>0) {
 $ins_sql = 'INSERT INTO purchase_requisition_details (invoice_no, invoice_date, inv_type, group_for, warehouse_id, item_id, unit_name, total_unit, status, 
 entry_at, entry_by, item_type, count_type, last_po_no, last_po_id, country_origin,in_stock,note,lead_time, model, size, brand, part_no, section, exp_date, other_ins, gsm, L, W, thickness, measurement_unit)
 VALUES
("'.$invoice_no.'", "'.$invoice_date.'", "'.$inv_type.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$item_id.'", "'.$unit_name.'", "'.$total_unit.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$item_type.'", "'.$count_type.'", "'.$last_po_no.'", "'.$last_po_id.'", "'.$country_origin.'", "'.$in_stock.'", "'.$note.'", "'.$lead_time.'", "'.$model.'", "'.$size.'", "'.$brand.'", "'.$part_no.'", "'.$section.'", "'.$exp_date.'", "'.$other_ins.'",  "'.$gsm.'",  "'.$L.'",  "'.$W.'",  "'.$thickness.'",  "'.$measurement_unit.'")';
	
	db_query($ins_sql);
	}

	//$new_sql="UPDATE po_bill_master SET status='".$status."' WHERE bill_id = '".$bill_id."' ";
	// db_query($new_sql);
	 
	 
	 
//if ($pi_data->pi_type==3) {
//	
//		
////Text Sms
//
//$sms_rec = find_all_field('sms_receiver','','id=1');
//
//function sms($dest_addr,$sms_text){
//
//$url = "https://vas.banglalink.net/sendSMS/sendSMS?userID=NASSA@123&passwd=LizAPI@019014&sender=NASSA_GROUP";
//
//
//$fields = array(
//    'userID'      => "NASSA@123",
//    'passwd'      => "LizAPI@019014",
//    'sender'      => "NASSA GROUP",
//    'msisdn'      => $dest_addr,
//    'message'     => $sms_text
//);
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_POST, count($fields));
//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
//$result = curl_exec($ch);
//curl_close($ch);
//}
//
//$recipients =$sms_rec->receiver_3;
//$recipients2 =$sms_rec->receiver_2;
//$massage  = "Dear Sir,\r\nRequest for PI Approval. \r\n";
//$massage  .= "PI No : ".$pi_no_generate." \r\n";
//$massage  .= "Login : https://boxes.com.bd/NATIVE/lc_mod/pages/main/index.php?module_id=13 \r\n";
//$sms_result=sms($recipients, $massage);
//if($recipients2>0) {
//$sms_result=sms($recipients2, $massage);
//}
	
//Text Sms

		//}
	 
	 
	 
	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry_req_update_offset.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}






if(isset($_POST['confirm'])){
	
	$status = 'PROCESSING';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$invoice_no = $_POST['invoice_no'];
	

	
	$new_sql="UPDATE purchase_requisition_master SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE invoice_no = '".$invoice_no."' ";
	 db_query($new_sql);
	 
	 
	 
	 ?>

<script language="javascript">
window.location.href = "all_requisition_list.php";
</script>

<? 
		
}






if(isset($_POST['delete'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
		
	$invoice_no = $_POST['invoice_no'];
	
	$sql_del_ms = 'delete from purchase_requisition_master where  invoice_no="'.$invoice_no.'"';
	db_query($sql_del_ms);
	
	
	$sql_del_dt = 'delete from purchase_requisition_details where invoice_no="'.$invoice_no.'"';
	db_query($sql_del_dt);
	
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php";
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


var rate = ((document.getElementById('rate').value)*1);

//var total_unit = (document.getElementById('total_unit').value) = pkt_unit*pkt_size;

var qty = ((document.getElementById('qty').value)*1);

var amount = (document.getElementById('amount').value) = rate*qty;

}


	
	

function TRcalculation(order_no){

var po_qty = document.getElementById('po_qty_'+order_no).value*1;

var unit_price = document.getElementById('unit_price_'+order_no).value*1;

var adj_qty = document.getElementById('adj_qty_'+order_no).value*1;

var adj_amt = document.getElementById('adj_amt_'+order_no).value= (unit_price*adj_qty);

 if(po_qty<adj_qty)
  {
alert('You can`t reduce the qty');
document.getElementById('adj_qty_'+order_no).value='';
document.getElementById('adj_amt_'+order_no).value='';
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



    <td width="14%" align="right" ><strong> Req. Date: </strong></td>



    <td width="14%" ><input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?php echo date('Y-m-d');?>" required disabled  tabindex="1" /></td>
	
	 <td width="11%" align="right" ><strong>  Req. From: </strong></td>
	 <td width="19%" >
	 
	 <select name="warehouse_id" id="warehouse_id"  style="width:90%; height:32px;" required>

        <option value=""></option>

		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1 and use_type="WH"');?>
      </select></td>
	 <td width="12%" align="right" ><strong>Company: </strong></td>
	 <td width="15%" ><select name="group_for" id="group_for"  style="width:90%; height:32px;" required>

      

		<? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1');?>

      </select></td>
	 <td width="15%" rowspan="9" align="center" ><strong>

      <input type="submit" name="master_data" id="master_data" value="Initiate Entry" style="width:180px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
    </tr>
	
	<tr>
								    <td align="right" ><strong> Requisition By: </strong></td>
								    <td ><input name="requisition_by" type="text" id="requisition_by" style="width:90%; height:32px;" value="<?=$_POST['requisition_by']?>" required tabindex="1" /></td>
									<td align="right" ><strong> Need By: </strong></td>
								    <td ><input name="need_by" type="text" id="need_by" style="width:90%; height:32px;" value="<?=$_POST['need_by']?>" required tabindex="1" /></td>
									 <td align="right"><strong> Req. Type: </strong></td>
								    <td >
		<select name="inv_type" id="inv_type"  style="width:90%; height:32px;" required>


		<? foreign_relation('requisition_type','id','requisition_type',$_POST['inv_type'],'id="'.$_REQUEST['inv_type'].'"');?>
      </select></td>
							      </tr>
	<tr>
	  <td align="right" ><strong> Remarks:  </strong></td>
	  <td ><input name="remarks" type="text" id="remarks" style="width:90%; height:32px;" value="<?=$_POST['remarks']?>" required tabindex="1" /></td>
	  <td align="right" ><strong> Department: </strong></td>
	  <td ><select name="department" id="department"  style="width:90%; height:32px;" required>

        <option value=""></option>

		<? foreign_relation('wh_department','id','department_name',$_POST['department'],'1');?>
      </select></td>
	  <td align="right"><strong>Section:</strong></td>
	  <td ><select name="section" id="section"  style="width:90%; height:32px;" required>

        <option value=""></option>

		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['section'],'1 and use_type="SC"');?>
      </select></td>
	  </tr>
								</table>

</div>


<? }?>



<? if ($data_found>0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
								    <td align="right" style="background:#fae5d3 ;" ><strong>Item Search:</strong></td>
								    <td colspan="5" style="background:#fae5d3;">
	<select id="item_id_src" name="item_id_src"  style="width:80%; height:35px;" class="js-example-basic-single"  >
	  <option></option>
		<? foreign_relation('item_info i, item_sub_group s','i.item_id','concat(i.finish_goods_code, " - ",i.item_name )',$item_id, 
		'i.sub_group_id=s.sub_group_id and i.finish_goods_code>0 and s.group_id=700000000 order by  i.sub_group_id, i.finish_goods_code');?>
    </select>
									</td>
							      </tr>
								  
								  
								  
								  <tr>

    <td width="12%" align="right" ><strong> Req. No: </strong></td>



    <td width="16%" >
	<? $ms_data = find_all_field('purchase_requisition_master','','invoice_no="'.$_REQUEST['request_no'].'"'); ?>
	
	<input name="invoice_no" type="hidden" id="invoice_no" style="width:90%; height:32px;" value="<?=$ms_data->invoice_no;?>" readonly="" required tabindex="1" />
	
	<input name="view_invoice_no" type="text" id="view_invoice_no" style="width:90%; height:32px;" value="<?=$ms_data->view_invoice_no;?>" readonly="" required tabindex="1" /></td>
	
	 <td width="17%" align="right"><strong> Req. From: </strong></td>
	 <td width="21%" align="left">
	 <select name="warehouse_id" id="warehouse_id"  style="width:90%; height:32px;" required>
		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$ms_data->warehouse_id.'"');?>
      </select></td>
	 <td width="13%" align="right"><strong>Company: </strong></td>
	 <td width="21%" >
	<select name="group_for" id="group_for"  style="width:90%; height:32px;" required>

		<? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$ms_data->group_for.'"');?>
      </select> </td>
	 </tr>
	 
	 <tr>
								    <td align="right" ><strong> Requisition By: </strong></td>
								    <td ><input name="requisition_by" type="text" id="requisition_by" style="width:90%; height:32px;" value="<?=$ms_data->requisition_by;?>"   tabindex="1" /></td>
								    <td align="right"><strong> Req. Date: </strong></td>
								    <td ><input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?=$ms_data->invoice_date;?>" readonly="" required="required" tabindex="1" /></td>
								    <td align="right"><strong> Req. Type: </strong></td>
								    <td ><select name="select" id="select"  style="width:90%; height:32px;" required="required">
                                      <? foreign_relation('requisition_type','id','requisition_type',$_POST['inv_type'],'id="'.$ms_data->inv_type.'"');?>
                                    </select></td>
	  </tr>
	 <tr>
	   <td align="right" ><strong> Remarks: </strong></td>
	   <td ><input name="remarks" type="text" id="remarks" style="width:90%; height:32px;" value="<?=$ms_data->remarks;?>" readonly="" required tabindex="1" /></td>
	   <td align="right"><strong> Department: </strong></td>
	   <td ><select name="department" id="department"  style="width:90%; height:32px;" required>

      
		<? foreign_relation('wh_department','id','department_name',$_POST['department'],'id="'.$ms_data->department.'"');?>
      </select></td>
	   <td align="right">&nbsp;</td>
	   <td >&nbsp;</td>
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
								    <th>Code</th>
								    <th width="59%" rowspan="2"  style="text-align:center; background:#FFFFFF; margin:0px; padding:0px;   border:none; "  >
									<span id="item_data_found">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px;">
										<tr>
											<th>Description</th></tr>
											<tr>
											<td><input name="description" type="text" class="input3"   autocomplete="off"  value="" id="description" style="width:94%; height:30px;"  readonly=""/></td>
										</tr>
									</table>
								</span>								</th>
									
								    <th>Quantity</th>
								    <th>Exp. Dt </th>
								    <th>Other  </th>
								    <th width="8%" rowspan="2"><input name="item_add" type="submit" id="item_add" value="ADD" style="width:91%; height:40px; background:#FF0000; color:#000000; font-weight:700;" /></th>
								  </tr>
								  <tr>

								 <td width="8%">
									
		 
						 
	<select id="item_id" name="item_id"  style="width:100%;" class="js-example-basic-single"
	 onchange="getData2('item_data_offset_ajax.php', 'item_data_found', this.value, document.getElementById('item_id').value);"  >
	  <option></option>
	 	
		<? foreign_relation('item_info i, item_sub_group s','i.item_id','i.finish_goods_code',$item_id, 
		'i.sub_group_id=s.sub_group_id and i.finish_goods_code>0 and s.group_id=700000000 order by  i.sub_group_id, i.finish_goods_code');?>
    </select> 									</td>
									<td width="6%"><input name="total_unit" type="text" class="input3"   autocomplete="off"  value="" id="total_unit" style="width:70px; height:30px;" onkeyup="count()" /></td>
                                    <td width="7%">
									<input name="exp_date" type="text" class="input3"   autocomplete="off"  value="" id="exp_date" style="width:80px; height:30px;" onkeyup="count()" />									</td>
                                    <td width="6%">
									<input name="other_ins" type="text" class="input3"   autocomplete="off"  value="" id="other_ins" style="width:70px; height:30px;" onkeyup="count()" />									</td>
								  </tr>
								</table>
								
	</div>
								
		
	
<? }?>


<? if($data_found>0){ ?>


<br />




<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; ">

  <tr>
    <th width="5%">Code</th>

    <th width="25%">Product</th>
    <th width="14%">Size</th>
    <th width="5%">GSM</th>
    <th width="7%">Brand</th>
    <th width="6%"> Stock  </th>
     <th width="7%">Unit</th>
     <th width="7%">Quantity</th>
    <th width="8%">Exp. Dt </th>
	<th width="10%">Note</th>
    <th width="6%"><div align="center">Action</div></th>
  </tr>
  
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		//if($_POST['dealer_code']!='')
// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


    if($_POST['po_date']!='')
	$po_dt_con=" and m.po_date='".$_POST['po_date']."'";
	
	
	
	 	 $sql = "select id, item_type from item_type where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $item_type[$info->id]=$info->item_type;
		}
		
		
		
		$sql = "select id, brand_name from wh_brand where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $brand_name[$info->id]=$info->brand_name;
		}



     $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name from purchase_requisition_details a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.invoice_no='".$invoice_no."' order by a.id desc";

  $queryfg = db_query($sqlfg);

  while($datafg=mysqli_fetch_object($queryfg)){$i++;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');

  ?>



<? //if($po_no[$data->po_no]==0) { } ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$datafg->finish_goods_code?></td>

    <td> <?=$datafg->item_name?> </td>
    <td bgcolor="#99CCFF" style="white-space: nowrap;">
	<?php 
            $get_length=explode(".",$datafg->L);
            $get_width=explode(".",$datafg->W);
            $get_thickness=explode(".",$datafg->thickness);
         
            if($get_length[1]>0){
                $fraction_length=".".$get_length[1];
            }
            else{
               $fraction_length='';  
                
            }
              if($get_width[1]>0){
                $fraction_width=".".$get_width[1];
            }
              else{
               $fraction_width='';  
                
            }
               if($get_thickness[1]>0){
                $fraction_thickness=".".$get_thickness[1];
            }
             else{
               $fraction_thickness='';     
            }
            
            if($datafg->L>0){echo "".$get_length[0].$fraction_length;}
            if($datafg->W>0){echo " X ".$get_width[0].$fraction_width;}
            if($datafg->thickness>0){echo " X ".$get_thickness[0].$fraction_thickness;}
            echo " ".$datafg->measurement_unit;
            ?>	</td>
    <td bgcolor="#99CCFF"><?=$datafg->gsm	?></td>
    <td bgcolor="#99CCFF"><?=$brand_name[$datafg->brand]?></td>
    <td bgcolor="#99CCFF"><?=$datafg->in_stock?></td>
    <td bgcolor="#99CCFF"><?=$datafg->unit_name?></td>
    <td bgcolor="#99CCFF">
	<input name="order_no_<?=$datafg->id?>" type="hidden" id="order_no_<?=$datafg->id?>" value="<?=$datafg->id?>" />
      <input name="item_id_<?=$datafg->id?>" type="hidden" id="item_id_<?=$datafg->id?>" value="<?=$datafg->item_id?>" />
	<input name="total_unit_<?=$datafg->id?>" type="text" id="total_unit_<?=$datafg->id?>" value="<?=$datafg->total_unit; $tot_total_unit +=$datafg->total_unit;?>" onkeyup="TRcalculationpo(<?=$data->id?>)" style="width:70px; height:30px; " /></td>
    <td bgcolor="#99CCFF"><?= date("d-M-y",strtotime($datafg->exp_date));?></td>
	  <td bgcolor="#99CCFF"><?=$datafg->other_ins	?></td>
    <td>
	<? if($reg_revise[$datafg->id]>0) {?>
	<center><b>Done!</b></center>
	<? }else {?>
	<span id="divi_<?=$datafg->id?>">
	<input name="flag_<?=$datafg->id?>" type="hidden" id="flag_<?=$datafg->id?>" value="0" />

	<input type="button" name="Button" value="EDIT"  onclick="update_value(<?=$datafg->id?>)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>
    </span><? }?></td>
  </tr>
  

  <? } ?>
</table>
</div>

<br />



<br /><br />




<table width="100%" border="0">





<? if($bill_data->status!="COMPLETED") {?>
<tr>

<td align="center">&nbsp;
<input name="delete" type="submit" class="btn1" value="DELETE" style="width:200px; font-weight:bold; float:left; font-size:12px; height:30px; background:#FF0000;color: #000000; border-radius:50px 20px;" />
</td>

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