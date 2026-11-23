<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='All Sample Order';

//do_calander('#fdate');
//do_calander('#tdate');
//create_combobox('do_no');
//create_combobox('dealer_code');
//create_combobox('buyer_code');
//create_combobox('marketing_person');

 $ms_user = find_a_field('user_activity_management','master_user','user_id="'.$_SESSION['user']['id'].'"');

do_calander('#fddate');
do_calander('#tddate');

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
	
	$invoice_date = $_POST['invoice_date'];
		
	//$pr_date = $_POST['so_date'];
	//$fg_item_id = $_POST['fg_item_id'];
	//$item_watt = find_a_field('item_info','item_watt','item_id="'.$_POST['fg_item_id'].'"');
	//$group_for=$_SESSION['user']['group'];
	//$warehouse_id=$_SESSION['user']['depot'];
	
	
		$YR = date('Y',strtotime($invoice_date));
 		$year = date('y',strtotime($invoice_date));
  		$month = date('m',strtotime($invoice_date));
		$day = date('d',strtotime($invoice_date));
 		$inv_cy_id = find_a_field('warehouse_opening_master','max(inv_id)','year="'.$YR.'"')+1;
  		$cy_id = sprintf("%06d", $inv_cy_id);
   		$invoice_no=''.$year.''.$month.''.$cy_id;
		$day_invoice_no=$YR.''.$month.''.$day.'0'.$warehouse_id;
	
	
	

	//$tr_no = date('ymd',strtotime($tr_date));
//	
//	$lot_cy_id = find_a_field('import_purchase_details','max(lot_id)','tr_no="'.$tr_no.'"')+1;
//		
//   	$cy_id = sprintf("%04d", $lot_cy_id);
//	
//   	 $lot_no_generate='LOT'.$tr_no.''.$cy_id;
	 
	 
	 if($invoice_no>0) {
	  $ins_sql = 'INSERT INTO warehouse_opening_master (invoice_no, year, inv_id, day_invoice_no, inv_type, group_for, warehouse_id, invoice_date, need_by, status, entry_at, entry_by, remarks) VALUES

("'.$invoice_no.'", "'.$YR.'", "'.$cy_id.'", "'.$day_invoice_no.'", "'.$inv_type.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$invoice_date.'", "'.$need_by.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$remarks.'")';
	
	db_query($ins_sql);
	}

	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}






//if(isset($_POST['confirm'])){

if(isset($_POST['item_add'])){
	
	$status = 'Opening';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');	
		
	$warehouse_id=$_POST['warehouse_id'];
	$group_for=$_POST['group_for'];
	
	$invoice_no = $_POST['invoice_no'];
	
	$day_invoice_no = $_POST['day_invoice_no'];
	$invoice_date = $_POST['invoice_date'];
	
	$item_id = $_POST['item_id'];
	$unit_name = $_POST['unit_name'];
	$currency_type = $_POST['currency_type'];
	$unit_price = $_POST['unit_price'];
	$total_unit = $_POST['total_unit'];
	$amount=$total_unit*$unit_price;
	$item_type = $_POST['item_type'];
	$count_type = $_POST['count_type'];
	
	$country_origin = $_POST['country_origin'];
	$ch_no = $_POST['ch_no'];
	$vendor_id = $_POST['vendor_id'];
	$lc_no = $_POST['lc_no'];
	$manufacture_date = $_POST['manufacture_date'];
	$expiry_date = $_POST['expiry_date'];
	

	 if($item_id>0) {
  $ins_sql = 'INSERT INTO purchase_receive (pr_no, group_for, rec_no, rec_date, vendor_id, item_id, warehouse_id, rate, qty, unit_name, amount, item_type, count_type, ch_no, lc_no, status, country_origin, manufacture_date, expiry_date,  entry_by, entry_at, currency_type)
 VALUES
("'.$invoice_no.'", "'.$group_for.'", "'.$day_invoice_no.'", "'.$invoice_date.'", "'.$vendor_id.'", "'.$item_id.'", "'.$warehouse_id.'", "'.$unit_price.'", "'.$total_unit.'", "'.$unit_name.'", "'.$amount.'", "'.$item_type.'", "'.$count_type.'", "'.$ch_no.'", "'.$lc_no.'", "'.$status.'", "'.$country_origin.'",  "'.$manufacture_date.'", "'.$expiry_date.'",  "'.$entry_by.'", "'.$entry_at.'", "'.$currency_type.'")';
	
	db_query($ins_sql);
		
$xid = mysqli_insert_id();

journal_item_control($item_id, $warehouse_id, $invoice_date, $total_unit, 0, 'Opening', $xid, $unit_price, '', $day_invoice_no, '', '',$group_for, $unit_price, '' );

	}

	//$new_sql="UPDATE po_bill_master SET status='".$status."' WHERE bill_id = '".$bill_id."' ";
	// db_query($new_sql);
	 

	 
	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}






if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$invoice_no = $_POST['invoice_no'];
	

	
	$new_sql="UPDATE warehouse_opening_master SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE invoice_no = '".$invoice_no."' ";
	 db_query($new_sql);
	 
	 
	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php";
</script>

<? 
		
}






if(isset($_POST['delete'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
		
	$invoice_no = $_POST['invoice_no'];
	
	$sql_del_ms = 'delete from warehouse_opening_master where  invoice_no="'.$invoice_no.'"';
	db_query($sql_del_ms);
	
	
	$sql_del_dt = 'delete from purchase_receive where invoice_no="'.$invoice_no.'"';
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



	function update_value(do_no)



	{

var do_no=do_no; // Rent

//var do_no=(document.getElementById('do_no_'+do_no).value);

var flag=(document.getElementById('flag_'+do_no).value); 

var strURL="accept_sales_order_ajax.php?do_no="+do_no+"&flag="+flag;

		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+do_no).style.display='inline';

						document.getElementById('divi_'+do_no).innerHTML=req.responseText;						

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
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}


.hover_none:hover{
color:#000000 !important; 
font-weight:700;
}


</style>

<div class="form-container_large">


<form action="" method="post" name="codz" id="codz">



<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td width="7%" align="right" ><strong>Job No:  </strong></td>
								    <td width="15%"><select name="do_no" id="do_no"  style="width:100%; height:32px;" >
													<option value=""></option>
													<? foreign_relation('sale_sample_master','do_no','job_no',$_POST['do_no'],'1');?>
												  </select>
									</td>
									
	
	 <td width="7%" align="right" ><strong>  Order Date: </strong></td>
	 <td width="12%" >
	 
	 <input name="fdate" type="date" id="fdate" style="width:90%; height:32px;" value="<?=$_POST['fdate'];?>" tabindex="1" /></td>
	 <td width="12%" ><input name="tdate" type="date" id="tdate" style="width:90%; height:32px;" value="<?=$_POST['tdate'];?>"  tabindex="1" /></td>
	 <td width="6%" align="right" ><strong> Deli. Date: </strong></td>
	 <td width="8%" ><input name="fddate" type="date" id="fddate" style="width:100px; height:32px;" value="<?=$_POST['fddate'];?>"  tabindex="1" /></td>
	 <td width="9%" ><input name="tddate" type="date" id="tddate" style="width:100px; height:32px;" value="<?=$_POST['tddate'];?>"  tabindex="1" /></td>
	 <td width="4%" align="Right" > <strong> Type:</strong> </td>
	 <td width="20%" align="left" >
	 <select name="sales_type" id="sales_type"  style="width: 90%; height:32px;" >
		
       <? foreign_relation('sales_type','id','sales_type',$_POST['sales_type'],'1');?>
    </select>	 </td>
								  </tr>
								  <tr>
								  
								  
    <td align="right" ><strong>Customer: </strong></td>
    <td ><select name="dealer_code" id="dealer_code"  style="width:100%; height:32px;" >
      <option value=""></option>
      <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
    </select></td>
									
									
								    <td align="right" ><strong> Buyer: </strong></td>
								    <td colspan="2" >
									<select name="buyer_code" id="buyer_code"  style="width:100%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('buyer_info','buyer_code','buyer_name',$_POST['buyer_code'],'1');?>
      </select></td>
								    <td colspan="5" align="right" >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="24%" align="right" >Verifying Status:</td>
												<td width="24%">
		<select name="verifying_status" id="verifying_status"  style="width:90%; height:32px;" >

        <option>-- All --</option>

		<? foreign_relation('verifying_status','id','verifying_status',$_POST['verifying_status'],'1');?>
      </select></td>
												<td width="18%" align="right" >Order Status:</td>
												<td width="17%">
		<select name="order_status" id="order_status"  style="width:90%; height:32px;" >

        <option>-- All --</option>

		<? foreign_relation('order_status','id','order_status',$_POST['order_status'],'1');?>
      </select>											  </td>
												<td width="17%">
												<input type="submit" name="find_data" id="find_data" value="Search " style="width:90%; text-transform:uppercase; background:#00FF00; color:#000000; text-align:center; font-weight:bold; font-size:10px; height:30px; "/>	
												
												<input name="find_src" type="hidden" id="find_src" style="width:100px; height:32px;" value="1"  tabindex="1" />										  </td>
											</tr>
										</table>									</td>
							      </tr>
								  <tr>
								  
								    <td align="right" ><strong>Marketing: </strong></td>
								    <td ><select name="marketing_person" id="marketing_person"  style="width:100%; height:32px;" >
                                      <option value=""></option>
                                      <? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'1');?>
                                    </select></td>
								    <td align="right" >&nbsp;</td>
								    <td colspan="2" >&nbsp;</td>
								    <td colspan="5" align="right" >&nbsp;</td>
							      </tr>
								</table>

</div>








</form>





<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px;">

  <tr>
    <th width="1%">SL</th>
    <th width="8%">Job No </th>

    <th width="7%">Order Date </th>
    <th width="8%">Delivery Dt </th>
    <th width="18%">Customer</th>
    <th width="13%">Buyer </th>
    <th width="13%">Marketing Concern </th>
    <th width="6%">Order Qty </th>
    <th width="13%">Verifying Status</th>
    <th width="9%">Order Status </th>
    <th width="4%">Action</th>
  </tr>
  
  

  <?
  
  
  
//  if($_POST['find_src']==0){
//  
//   if($_POST['fdate']!=''){
//  	$fdate=$_POST['fdate'];
//  }else{
//  	//$fdate=date('Y-m-d');
//	$fdate = date("Y-m-d", strtotime("-2 day"));
//  }
// 
// 
// if($_POST['tdate']!=''){
//  	$tdate=$_POST['tdate'];
//  }else{
//  	$tdate=date('Y-m-d');
//  }
//  
//  $so_date_con .= ' and m.do_date between "'.$fdate.'" and "'.$tdate.'"';
//    }

  
  
  if($_POST['do_no']==0){ 
  
   if($_POST['fdate']!=''){
  	$fdate=$_POST['fdate'];
  }else{
  	//$fdate=date('Y-m-d');
	$fdate = date("Y-m-d", strtotime("-2 month"));
  }
 
 
 if($_POST['tdate']!=''){
  	$tdate=$_POST['tdate'];
  }else{
  	//$tdate=date('Y-m-d');
	$tdate = date("Y-m-d", strtotime("+1 day"));
  }
  
  $so_date_con .= ' and m.do_date between "'.$fdate.'" and "'.$tdate.'"';
  
 }
  
  //if($_POST['fdate']!=''&&$_POST['tdate']!='') $so_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  if($_POST['fddate']!=''&&$_POST['tddate']!='') $del_date_con .= ' and m.delivery_date between "'.$_POST['fddate'].'" and "'.$_POST['tddate'].'"';

    if($_POST['dealer_code']!='')
	$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
	
	if($_POST['buyer_code']!='')
	$buyer_con=" and m.buyer_code='".$_POST['buyer_code']."'";
	
	if($_POST['do_no']!='')
	$do_no_con=" and m.do_no='".$_POST['do_no']."'";
	
	if($_POST['marketing_person']!='')
	$marketing_person_con=" and m.marketing_person='".$_POST['marketing_person']."'";
	
	if($_POST['sales_type']==""){
	$sales_type_con=" and m.sales_type=1 ";
	}else{
	$sales_type_con=" and m.sales_type='".$_POST['sales_type']."'";
	}
	
	if($_POST['verifying_status']==1){
	$status_con=" and m.status in ('CHECKED','COMPLETED')";
	}elseif($_POST['verifying_status']==2){
	$status_con=" and m.status in ('UNCHECKED')";
	}elseif($_POST['verifying_status']==3){
	$status_con=" and m.hold_status=1";
	}elseif($_POST['verifying_status']==4){
	$status_con=" and m.cancel_status=1";
	}
	
	
	
	
	

		
		$sql = "select buyer_code, buyer_name from buyer_info where 1 group by buyer_code";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $buyer_name[$info->buyer_code]=$info->buyer_name;
		}
		
		$sql = "select person_code, marketing_person_name from marketing_person where 1 group by person_code";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $marketing_person_name[$info->person_code]=$info->marketing_person_name;
		}
	
		$sql = "select do_no, sum(total_unit) as accept_qty from production_sample where 1 group by do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $accept_qty[$info->do_no]=$info->accept_qty;
		}
		
		$sql = "select do_no, sum(total_unit) as production_qty from production_sample where 1 group by do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $production_qty[$info->do_no]=$info->production_qty;
		}
		
		$sql = "select do_no, sum(total_unit) as delivey_qty from sale_sample_chalan where 1 group by do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $delivey_qty[$info->do_no]=$info->delivey_qty;
		}
		
		$sql = "select user_id, fname from user_activity_management where 1 group by user_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $fname[$info->user_id]=$info->fname;
		}
		
		
		$sql = "select do_no, sum(total_unit) as order_qty, sum(hold_qty) as hold_qty, sum(cancel_qty) as cancel_qty, hold_entry_at, cancel_at from sale_sample_details where 1 group by do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $order_qty[$info->do_no]=$info->order_qty;
		 $hold_qty[$info->do_no]=$info->hold_qty;
		 $cancel_qty[$info->do_no]=$info->cancel_qty;
		 $hold_entry_at[$info->do_no]=$info->hold_entry_at;
		 $cancel_at[$info->do_no]=$info->cancel_at;
		}
		
		
		
	

?>
<? if($_POST['order_status']==1) {?>
<?
   $sql = "select m.*,  d.dealer_name_e from sale_sample_master m,   dealer_info d 
 where  m.dealer_code=d.dealer_code  ".$so_date_con.$del_date_con.$dealer_con.$do_no_con.$buyer_con.$status_con.$sales_type_con.$marketing_person_con." group by m.do_no order by  m.do_no desc";

  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){

  ?>
  <? if($accept_qty[$data->do_no]>0) { $i++;?>
  <tr style="font-size:12px;">
    <td><?=$i;?> </td>
    <td style="white-space: nowrap;">
	
<a class="hover_none" href="../../../sales_mod/pages/wo_sample/work_order_print_view.php?v_no=<?=$data->do_no;?>" target="_blank"><strong><?=$data->job_no?></strong></a>
	
	
	<input name="do_no_<?=$data->do_no?>" type="hidden" id="do_no_<?=$data->do_no?>" value="<?=$data->do_no;?>" />	</td>

    <td><?= date('d-M-y',strtotime($data->do_date));?></td>
    <td><?= date('d-M-y',strtotime($data->delivery_date));?></td>
    <td><?=$data->dealer_name_e?></td>
    <td><?=$buyer_name[$data->buyer_code]?></td>
    <td><?=$marketing_person_name[$data->marketing_person]?></td>
    <td align="right"><div align="right">
      <?=number_format($order_qty[$data->do_no],0);?>
    </div>      </td>
    <td align="left">
	<? if($data->status=='CHECKED' || $data->status=='COMPLETED' ){ ?>
	<b>Verified</b><br />
	<?=date("d/m/y",strtotime($data->checked_at)).' '.date("h:i A",strtotime($data->checked_at));?>
	<? }elseif($data->status=='HOLD'){?>
	<b>Hold</b><br />
	<?=date("d/m/y",strtotime($data->hold_app_at)).' '.date("h:i A",strtotime($data->hold_app_at));?>
	<? }elseif($data->status=='CANCELED'){?>
	<b>Canceled</b><br />
	<?=date("d/m/y",strtotime($data->cancel_app_at)).' '.date("h:i A",strtotime($data->cancel_app_at));?>
	<? }else{?>
	<span style="font-weight:700; color:  #d35400;">Unverified</span>
	<? } ?></td>
    <td >
	  <div align="center" style=" line-height: 2; ">
	    <? if($accept_qty[$data->do_no]>0){?> 
	     
		  <span style="margin: 0; white-space: nowrap; color: #0fb922;font-weight: 700;"><i class="fa fa-check"></i> Accept</span><br />
	      <? }else{?>
	      <span style="color:#955602; font-weight:700;"><i class="fa fa-check"></i> Unlock</span><br />
	      <? }?>
		  
		  <? if($production_qty[$data->do_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #600fc4;font-weight: 700;"><i class="fa fa-check"></i> Production</span><br />
		  <? }?>
		  
		  <? if($delivey_qty[$data->do_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #1097d3;font-weight: 700;"><i class="fa fa-check"></i> Delivery</span><br />
		  <? }?>
	      </div></td>
    <td >
	<? if($accept_qty[$data->do_no]==0) {?>
	<? if($data->sales_type==1) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_inhouse.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==2) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_poly.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==3) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_gumtape.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==4) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_offset.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }?>
	<? }?>
	</td>
  </tr>
 
  <? } } ?>
  
  <? }elseif($_POST['order_status']==2){?>
  <?
  $sql = "select m.*, d.dealer_name_e from sale_sample_master m,  dealer_info d 
 where m.dealer_code=d.dealer_code   ".$so_date_con.$del_date_con.$dealer_con.$do_no_con.$buyer_con.$status_con.$sales_type_con.$marketing_person_con." group by m.do_no order by  m.do_no desc";

  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){

  ?>
  <? if($accept_qty[$data->do_no]==0) { $i++;?>
  <tr style="font-size:12px;">
    <td><?=$i;?> </td>
    <td style="white-space: nowrap;">
	<a class="hover_none" href="../../../sales_mod/pages/wo_sample/work_order_print_view.php?v_no=<?=$data->do_no;?>" target="_blank"><strong><?=$data->job_no?></strong></a>
	<input name="do_no_<?=$data->do_no?>" type="hidden" id="do_no_<?=$data->do_no?>" value="<?=$data->do_no;?>" />	</td>

    <td><?= date('d-M-y',strtotime($data->do_date));?></td>
    <td><?= date('d-M-y',strtotime($data->delivery_date));?></td>
    <td><?=$data->dealer_name_e?></td>
    <td><?=$buyer_name[$data->buyer_code]?></td>
    <td><?=$marketing_person_name[$data->marketing_person]?></td>
    <td align="right"><div align="right">
      <?=number_format($order_qty[$data->do_no],0);?>
    </div>      </td>
     <td align="left">
	<? if($data->status=='CHECKED' || $data->status=='COMPLETED' ){ ?>
	<b>Verified</b><br />
	<?=date("d/m/y",strtotime($data->checked_at)).' '.date("h:i A",strtotime($data->checked_at));?>
	<? }elseif($data->status=='HOLD'){?>
	<b>Hold</b><br />
	<?=date("d/m/y",strtotime($data->hold_app_at)).' '.date("h:i A",strtotime($data->hold_app_at));?>
	<? }elseif($data->status=='CANCELED'){?>
	<b>Canceled</b><br />
	<?=date("d/m/y",strtotime($data->cancel_app_at)).' '.date("h:i A",strtotime($data->cancel_app_at));?>
	<? }else{?>
	<span style="font-weight:700; color:  #d35400;">Unverified</span>
	<? } ?></td>
    <td >
	  <div align="center" style=" line-height: 2; ">
	    <? if($accept_qty[$data->do_no]>0){?> 
	     
		  <span style="margin: 0; white-space: nowrap; color: #0fb922;font-weight: 700;"><i class="fa fa-check"></i> Accept</span><br />
	      <? }else{?>
	      <span style="color:#955602; font-weight:700;"><i class="fa fa-check"></i> Unlock</span><br />
	      <? }?>
		  
		  <? if($production_qty[$data->do_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #600fc4;font-weight: 700;"><i class="fa fa-check"></i> Production</span><br />
		  <? }?>
		  
		  <? if($delivey_qty[$data->do_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #1097d3;font-weight: 700;"><i class="fa fa-check"></i> Delivery</span><br />
		  <? }?>
	      </div></td>
    <td ><? if($accept_qty[$data->do_no]==0) {?>
	<? if($data->sales_type==1) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_inhouse.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==2) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_poly.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==3) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_gumtape.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==4) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_offset.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }?>
	<? }?></td>
  </tr>
 
  <? } } ?>
  
  <? }else{?>
  
  <?
    $sql = "select m.*, d.dealer_name_e from sale_sample_master m, dealer_info d 
 where m.dealer_code=d.dealer_code  ".$so_date_con.$del_date_con.$dealer_con.$do_no_con.$buyer_con.$status_con.$sales_type_con.$marketing_person_con." group by m.do_no order by  m.do_no desc";

  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$j++;

  ?>
  <tr style="font-size:12px;">
    <td><?=$j;?> </td>
    <td style="white-space: nowrap;">
	<a class="hover_none" href="../../../sales_mod/pages/wo_sample/work_order_print_view.php?v_no=<?=$data->do_no;?>" target="_blank"><strong><?=$data->job_no?></strong></a>
	<input name="do_no_<?=$data->do_no?>" type="hidden" id="do_no_<?=$data->do_no?>" value="<?=$data->do_no;?>" />	</td>

    <td><?= date('d-M-y',strtotime($data->do_date));?></td>
    <td><?= date('d-M-y',strtotime($data->delivery_date));?></td>
    <td><?=$data->dealer_name_e?></td>
    <td><?=$buyer_name[$data->buyer_code]?></td>
    <td><?=$marketing_person_name[$data->marketing_person]?></td>
    <td align="right"><div align="right">
      <?=number_format($order_qty[$data->do_no],0);?>
    </div>      </td>
     <td align="left">
	<? if($data->status=='CHECKED' || $data->status=='COMPLETED' ){ ?>
	<b>Verified</b><br />
	<?=date("d/m/y",strtotime($data->checked_at)).' '.date("h:i A",strtotime($data->checked_at));?>
	<? }elseif($data->status=='HOLD'){?>
	<b>Hold</b><br />
	<?=date("d/m/y",strtotime($data->hold_app_at)).' '.date("h:i A",strtotime($data->hold_app_at));?>
	<? }elseif($data->status=='CANCELED'){?>
	<b>Canceled</b><br />
	<?=date("d/m/y",strtotime($data->cancel_app_at)).' '.date("h:i A",strtotime($data->cancel_app_at));?>
	<? }else{?>
	<span style="font-weight:700; color:  #d35400;">Unverified</span>
	<? } ?></td>
    <td >
	  <div align="center" style=" line-height: 2; ">
	    <? if($accept_qty[$data->do_no]>0){?> 
	     
		  <span style="margin: 0; white-space: nowrap; color: #0fb922;font-weight: 700;"><i class="fa fa-check"></i> Accept</span><br />
	      <? }else{?>
	      <span style="color:#955602; font-weight:700;"><i class="fa fa-check"></i> Unlock</span><br />
	      <? }?>
		  
		  <? if($production_qty[$data->do_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #600fc4;font-weight: 700;"><i class="fa fa-check"></i> Production</span><br />
		  <? }?>
		  
		  <? if($delivey_qty[$data->do_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #1097d3;font-weight: 700;"><i class="fa fa-check"></i> Delivery</span><br />
		  <? }?>
	      </div></td>
    <td ><? if($accept_qty[$data->do_no]==0) {?>
	<? if($data->sales_type==1) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_inhouse.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==2) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_poly.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==3) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_gumtape.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }elseif($data->sales_type==4) {?>
	<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" href="../wo_sample/do_for_offset.php?do_no=<?=$data->do_no;?>" >EDIT</a>
	<? }?>
	<? }?></td>
  </tr>
 
  <? }  ?>
  <? }  ?>
</table>
</div>

<br />



<br /><br />







<p>&nbsp;</p>


</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");
//selected_two("#do_no");
//selected_two("#dealer_code");
//selected_two("#marketing_person");
//selected_two("#buyer_code");

?>