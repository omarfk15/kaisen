<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Gate Pass';

do_calander('#fdate');
do_calander('#tdate');
create_combobox('do_no');
create_combobox('dealer_code_gp');
create_combobox('dealer_code');
create_combobox('gate_pass_no');
create_combobox('chalan_no');
create_combobox('vehicle_id');
create_combobox('do_no_ch');
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
	
	mysql_query($ins_sql);
	}

	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}






//if(isset($_POST['confirm'])){

if(isset($_POST['do_gpn'])){
	
	
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');	
		
	$dealer_code_gp=$_POST['dealer_code_gp'];

	//$new_sql="UPDATE po_bill_master SET status='".$status."' WHERE bill_id = '".$bill_id."' ";
	// mysql_query($new_sql);
	  	 
	 ?>

<script language="javascript">
window.location.href = "../wo_gp/invoice_entry.php?dealer_code=<?=$dealer_code_gp?>";
</script>

<? 
		
}






if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$invoice_no = $_POST['invoice_no'];
	

	
	$new_sql="UPDATE warehouse_opening_master SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE invoice_no = '".$invoice_no."' ";
	 mysql_query($new_sql);
	 
	 
	 
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
	mysql_query($sql_del_ms);
	
	
	$sql_del_dt = 'delete from purchase_receive where invoice_no="'.$invoice_no.'"';
	mysql_query($sql_del_dt);
	
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
$query = mysql_query($sql);
while($data=mysql_fetch_object($query)){
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
    width: 180px;
    height: 38px;
    border-radius: 0px !important;
}


.hover_none:hover{
color:#000000 !important; 
font-weight:700;
}
a.hover_none:active,
a.hover_none:focus {
  color: #9c27b0 !important;
  text-decoration: none !important; 
  background-color: transparent !important; 
  
}



</style>

<div class="form-container_large">



<form action="" method="post" name="codz" id="codz">

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td width="9%" align="right" ><strong> Job No: </strong></td>



    <td width="16%" >
	
	<select name="do_no" id="do_no"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'1');?>
      </select>	</td>
	
	 <td width="12%" align="right" ><strong style="
    margin-left: 40px;
">Customer: </strong></td>
	 <td width="15%" >
	<select name="dealer_code" id="dealer_code"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
      </select></td>
	 <td align="right" ><strong> GPN Date: </strong></td>
	 <td colspan="3" align="right" >
	 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="50%"><input name="fddate" type="text" id="fddate" style="width:90%; height:32px;" value="<?=$_POST['fddate'];?>" readonly=""  tabindex="1" /></td>
				<td width="50%"><input name="tddate" type="text" id="tddate" style="width:90%; height:32px;" value="<?=$_POST['tddate'];?>" readonly=""  tabindex="1" /></td>
			</tr>
		</table>
	 </td>
	 </tr>
								  <tr>
								    <td align="right" ><strong>Challan No: </strong></td>
								    <td >
		<select name="chalan_no" id="chalan_no"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('sale_do_chalan','chalan_no','chalan_no_view',$_POST['chalan_no'],'1 group by chalan_no');?>
      </select></td>
								    <td align="right" ><strong> Gate Pass: </strong></td>
								    <td >
									<select name="gate_pass_no" id="gate_pass_no"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('gate_pass_master','gate_pass_no','view_gate_pass',$_POST['gate_pass_no'],'1');?>
      </select></td>
								    <td width="20%" align="right" ><strong> Vehicle: </strong></td>
								    <td width="6%" align="left" >
		<select name="vehicle_id" id="vehicle_id"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('vehicle_registration','vehicle_id','registration_no',$_POST['vehicle_id'],'1');?>
      </select>								</td>
								    <td width="22%" colspan="2" align="right" ><strong>

      <input type="submit" name="find_data" id="find_data" value="Search Data" style="width:120px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
							      </tr>
								</table>

</div>


<? }?>





<div class="box" style="width:100%;">

								<table width="50%" border="0" cellspacing="0" cellpadding="0">
								
								  <tr>
								    <td width="9%" align="right" ><strong>Customer: </strong></td>
								    <td width="16%" >
		
		<select name="dealer_code_gp" id="dealer_code_gp"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code_gp'],'1');?>
      </select>
	  
	  
	  
	  </td>
								    <td width="22%" align="center" ><strong>
<input type="submit" name="do_gpn" id="do_gpn" value="New Gate Pass" style="width:120px; text-transform:uppercase; background: #FF7F50; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
							      </tr>
								</table>

</div>





<? //if($data_found>0){ ?>



<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px;">

  <tr>
    <th width="1%">SL</th>
    <th width="9%"><strong>Gate Pass</strong> No</th>
    <th width="17%">Customer</th>
    <th width="15%">Vehicle </th>
    <th width="13%">Create Date-Time</th>
    <th width="11%"><strong>Gate Pass </strong> Date</th>
    </tr>
  
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $so_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  if($_POST['fddate']!=''&&$_POST['tddate']!='') $del_date_con .= ' and m.gp_date between "'.$_POST['fddate'].'" and "'.$_POST['tddate'].'"';
  
  
		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


    if($_POST['dealer_code']!='')
	$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
	
	if($_POST['buyer_code']!='')
	$buyer_con=" and m.buyer_code='".$_POST['buyer_code']."'";
	
	if($_POST['vehicle_id']!='')
	$vehicle_con=" and m.vehicle_id='".$_POST['vehicle_id']."'";
	
	if($_POST['do_no']!='')
	$do_no_con=" and m.do_no='".$_POST['do_no']."'";
	
	if($_POST['gate_pass_no']!='')
	$gpn_con=" and m.gate_pass_no='".$_POST['gate_pass_no']."'";
	
	
	
		
		$sql = "select vehicle_id, registration_no from vehicle_registration where 1 group by vehicle_id";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $registration_no[$info->vehicle_id]=$info->registration_no;
		}
		
		
		$sql = "select do_no, sum(total_unit) as accept_qty from production_accept where 1 group by do_no";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $accept_qty[$info->do_no]=$info->accept_qty;
		}



      $sql = "select m.*,  d.dealer_name_e from gate_pass_master m, gate_pass_details s,  dealer_info d 
where m.gate_pass_no=s.gate_pass_no and m.dealer_code=d.dealer_code ".$so_date_con.$del_date_con.$dealer_con.$do_no_con.$buyer_con.$vehicle_con.$gpn_con." group by s.gate_pass_no order by  s.gate_pass_no desc";

  $query = mysql_query($sql);

  while($data=mysql_fetch_object($query)){$i++;

  ?>





  <tr style="font-size:12px;">
    <td><?=$i;?></td>
    <td><a class="hover_none" href="../wo_gp/invoice_print_view.php?invoice_no=<?=$data->gate_pass_no;?>" target="_blank"><strong><?=$data->view_gate_pass?></strong></a></td>
    <td><?=$data->dealer_name_e?></td>
    <td><?=$registration_no[$data->vehicle_id]?></td>
    <td align="right"><?=date("d/m/Y",strtotime($data->checked_at)).' '.date("h:i A",strtotime($data->checked_at));?></td>
    <td ><?= date('d-M-y',strtotime($data->gp_date));?></td>
    </tr>
  

  <? }  ?>
</table>
</div>

<br />



<br /><br />






<? //}?>








<p>&nbsp;</p>

</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>