<?php

session_start();

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Delivery Challan';

 //$super_id = find_a_field('super_permissions','user_id','user_id="'.$_SESSION['user']['id'].'" and status="Active"');

do_calander('#fddate');
do_calander('#tddate');
//create_combobox('do_no');
//create_combobox('dealer_code');
//create_combobox('buyer_code');
//create_combobox('chalan_no');
//create_combobox('vehicle_id');
//create_combobox('do_no_ch');
//do_calander('#fddate');
//do_calander('#tddate');






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

if(isset($_POST['do_ch'])){
	
	
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');	
		
	$do_no_ch=$_POST['do_no_ch'];
	
	$ms_data=find_all_field('sale_do_master','','do_no='.$do_no_ch);
	
	
	$running_date=date('Y-m-d');
	
	$ch_tr_no = next_transection_no($ms_data->sales_type,$running_date,'delivery_chalan_master','tr_no');

	
	if($do_no_ch>0) {
$ins_sql = 'INSERT INTO delivery_chalan_master (tr_no, tr_date, chalan_no, do_no, do_date, job_no, group_for, dealer_code, marketing_person,  status, entry_by, entry_at) VALUES

("'.$ch_tr_no.'", "'.$running_date.'", "'.$ms_data->chalan_no.'", "'.$do_no_ch.'", "'.$ms_data->do_date.'", "'.$ms_data->job_no.'", "'.$ms_data->group_for.'", 
"'.$ms_data->dealer_code.'", "'.$ms_data->marketing_person.'", "'.$status.'", "'.$entry_by.'", "'.$entry_at.'")';
	
	db_query($ins_sql);
	}
	
	 
	 
	 ?>

<script language="javascript">
window.location.href = "delivery_challan_from_wo.php?do_no=<?=$do_no_ch?>&tr_no=<?=$ch_tr_no?>";
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
    width: 180px;
    height: 38px;
    border-radius: 0px !important;
}


.hover_none:hover{
color:#000000 !important; 
font-weight:700;
}

div.form-container_large input {
    width: 147px !important;
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


											    <td width="10%" align="right" ><strong>Challan No: </strong></td>
								    <td  width="17%">
		<select name="chalan_no" id="chalan_no"  style="width:100%; height:32px;" class="js-example-basic-single" >

        <option value=""></option>

		<? foreign_relation('sale_do_chalan','chalan_no','chalan_no_view',$_POST['chalan_no'],'1 group by chalan_no');?>
      </select></td>
    
	
	 <td width="7%" align="right" ><strong>Customer: </strong></td>
	 <td width="18%" >
	<select name="dealer_code" id="dealer_code"  style="width:100%; height:32px;" class="js-example-basic-single">

        <option value=""></option>

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
      </select></td>
	 <td  width="19%" align="right" ><strong> Delivery Date: </strong></td>
	 <td colspan="3" align="right" >
	 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="57%"><input name="fddate" type="text" id="fddate" style="width:120px; height:30px!important;" value="<?=$_POST['fddate'];?>"    /></td>
				<td width="43%"><input name="tddate" type="text" id="tddate" style="width:120px; height:30px!important;" value="<?=$_POST['tddate'];?>"    /></td>
			</tr>
		</table>	 </td>
	 </tr>
								  <tr>

	  <td width="10%" align="right" ><strong> DO No: </strong></td>



      <td width="17%" >
	
	<select name="do_no" id="do_no"  style="width:100%; height:32px;" class="js-example-basic-single">

        <option value=""></option>

		<? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'1');?>
      </select>	</td>
								    <td align="right" ><strong>RFT Type:</strong></td>
								    <td >
		<select name="rft_type" id="rft_type"  style="width:100%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('rft_type','id','rft_type',$_POST['rft_type'],'1');?>
       </select>
									</td>
								    <td width="19%" align="right" ><strong>Order Type:</strong></td>
								    <td width="10%" align="left" >
									
									<select name="order_type" id="order_type"  style="width:100%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('order_type','order_type','order_type',$_POST['order_type'],'1');?>
       </select>
									</td>
								    <td width="19%" colspan="2" align="right" ><strong>

      <input type="submit" name="find_data" id="find_data" value="Search Data" style="width:120px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; margin: 3px 5px;  "/>

    </strong></td>
							      </tr>
								  <tr>
								    <td align="right" >&nbsp;</td>
								    <td >&nbsp;</td>
								    <td align="right" >&nbsp;</td>
								    <td >&nbsp;</td>
								    <td align="right" >&nbsp;</td>
								    <td align="left" >&nbsp;</td>
								    <td colspan="2" align="right" >&nbsp;</td>
							      </tr>
								</table>

</div>


<? }?>





<div class="box" style="width:100%; background-color: #c5f8f8;">

								<table width="73%" border="0" cellspacing="0" cellpadding="0">
								
								  <tr>
								    <td width="34%" align="right" ><strong> DO No: </strong></td>
								    <td width="41%" >
		
		<select name="do_no_ch" id="do_no_ch"  style="width:250px; height:32px;" class="js-example-basic-single" >
        <option value=""></option>
		<? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no_ch'],'status in ("APPROVED") ');?>
      	</select></td>
								    <td width="25%" align="center" ><strong>
								      <input type="submit" name="do_ch" id="do_ch" value="New Challan" style="width:120px; text-transform:uppercase; background: #52be80; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>
								    </strong></td>
							      </tr>
	  </table>

</div>





<? //if($data_found>0){ ?>



<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px;">

  <tr>
    <th width="1%">SL</th>
    <th width="7%">Challan No</th>
    <th width="8%">Gate Pass </th>
    <th width="9%">Inv No </th>
    <th width="9%">VAT Challan </th>
    <th width="9%">DO No </th>

    <th width="14%">Party</th>
    <th width="4%" style="white-space:nowrap"> Deli./Pcs </th>
    <th width="4%" style="white-space:nowrap"> Deli./KG</th>
    <th width="4%">Amount</th>
    <th width="8%" style="white-space:nowrap">Delivery Date</th>
    </tr>
  
  

  <?
  
  
  //if($_POST['fdate']!=''&&$_POST['tdate']!='') $so_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  //if($_POST['fddate']!=''&&$_POST['tddate']!='') $del_date_con .= ' and s.chalan_date between "'.$_POST['fddate'].'" and "'.$_POST['tddate'].'"';
  
  
  
  
  
  
 // if($_POST['chalan_no']==0 && $_POST['do_no']==0){ } 
  
   if($_POST['fddate']!=''){
  	$fdate=$_POST['fddate'];
  }else{
	 $fdate = date("Y-m-d", strtotime("-60 day"));
  }
 
 
 if($_POST['tddate']!=''){
  	$tdate=$_POST['tddate'];
  }else{
	$tdate = date("Y-m-d", strtotime("+30 day"));
  }
  
  $del_date_con .= ' and s.chalan_date between "'.$fdate.'" and "'.$tdate.'"';
  

  

  
  
  
		



    if($_POST['dealer_code']!='')
	$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
	
	if($_POST['buyer_code']!='')
	$buyer_con=" and m.buyer_code='".$_POST['buyer_code']."'";
	
	if($_POST['vehicle_id']!='')
	$vehicle_con=" and s.vehicle_id='".$_POST['vehicle_id']."'";
	
	if($_POST['do_no']!='')
	$do_no_con=" and m.do_no='".$_POST['do_no']."'";
	
	if($_POST['chalan_no']!='')
	$chalan_con=" and s.chalan_no='".$_POST['chalan_no']."'";
	
	if($_POST['revise_status']!='')
	$revise_status_con=" and s.revise_count>0";
	
	
	if($_POST['order_type']!='')
	$order_type_con=" and m.order_type='".$_POST['order_type']."'";
	
	
		
		//$sql = "select buyer_code, buyer_name from buyer_info where 1 group by buyer_code";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $buyer_name[$info->buyer_code]=$info->buyer_name;
		}
		
		
		//$sql = "select chalan_no, view_gate_pass, tr_no as gp_tr_no from gate_pass_details where 1 group by chalan_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
		 $gp_tr_no[$info->chalan_no]=$info->gp_tr_no;
		}
		
		// $sql = "select tr_no, view_gate_pass from gate_pass_master where 1 group by tr_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
		 $view_gate_pass[$info->tr_no]=$info->view_gate_pass;
		}
		
		//$sql = "select vehicle_id, registration_no from vehicle_registration where 1 group by vehicle_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $registration_no[$info->vehicle_id]=$info->registration_no;
		}
		
		
		//$sql = "select chalan_no, sum(revise_in) as revise_in, sum(revise_ex) as revise_ex, revise_date from sale_do_chalan_revise where 1 group by chalan_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $revise_in[$info->chalan_no]=$info->revise_in;
		 $revise_ex[$info->chalan_no]=$info->revise_ex;
		 $revise_date[$info->chalan_no]=$info->revise_date;
		}
		
		$sql = "select chalan_no, sum(total_unit_pcs) as ch_tot_qty, sum(total_unit) as ch_tot_kg, sum(total_amt) as ch_total_amt from sale_do_chalan where 1 group by chalan_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $ch_tot_qty[$info->chalan_no]=$info->ch_tot_qty;
		 $ch_tot_kg[$info->chalan_no]=$info->ch_tot_kg;
		 $ch_total_amt[$info->chalan_no]=$info->ch_total_amt;
		}


        $sql = "select m.*,  s.chalan_date, s.entry_at, s.chalan_no, s.chalan_no_view, s.gatepass_no, s.invoice_no,  s.vehicle_no, sum(s.total_unit) as ch_qty, s.entry_at, d.dealer_name_e from sale_do_master m, sale_do_chalan s,  dealer_info d 
	 where m.do_no=s.do_no and m.dealer_code=d.dealer_code  and s.status='APPROVED'
	 ".$so_date_con.$del_date_con.$dealer_con.$do_no_con.$vehicle_con.$chalan_con.$revise_status_con.$order_type_con." group by s.chalan_no order by  s.chalan_no desc";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>





  <tr style="font-size:12px;">
    <td><?=$i;?></td>
    <td style="white-space:nowrap;"><a class="hover_none" href="../../../sales_mod/pages/do_delivery/delivery_challan_print_view.php?v_no=<?=$data->chalan_no;?>&rft_type=<?=$_POST['rft_type'];?>" target="_blank"><strong><?=$data->chalan_no_view?></strong></a> </td>
    <td style="white-space:nowrap;" ><a class="hover_none" href="../../../sales_mod/pages/do_delivery/delivery_gatepass_print_view.php?v_no=<?=$data->chalan_no;?>&rft_type=<?=$_POST['rft_type'];?>" target="_blank"><strong><?=$data->gatepass_no?></strong></a> </td>
    <td style="white-space:nowrap;"><a class="hover_none" href="../../../sales_mod/pages/do_delivery/delivery_challan_invoice_print_view.php?v_no=<?=$data->chalan_no;?>&rft_type=<?=$_POST['rft_type'];?>" target="_blank"><strong><?=$data->invoice_no?></strong></a> </td>
    <td style="white-space:nowrap;">
	<a class="hover_none" href="../../../sales_mod/pages/do_delivery/delivery_vat_challan_print_view.php?v_no=<?=$data->chalan_no;?>&rft_type=<?=$_POST['rft_type'];?>" target="_blank"><strong><?=$data->chalan_no_view?></strong></a>	</td>
    <td style="white-space:nowrap;"><a class="hover_none" href="../../../sales_mod/pages/sales_order/sales_order_print_view.php?do_no=<?=$data->do_no;?>&rft_type=<?=$_POST['rft_type'];?>" target="_blank"><strong><?=$data->job_no?></strong></a></td>

    <td><?=$data->dealer_name_e?></td>
    <td align="right"><div align="right">
      <?=number_format($ch_tot_qty[$data->chalan_no],0); $tot_ch_tot_qty +=$ch_tot_qty[$data->chalan_no];?>
    </div>      </td>
    <td align="right"><div align="right">
      <?=number_format($ch_tot_kg[$data->chalan_no],2); $tot_ch_tot_kg +=$ch_tot_kg[$data->chalan_no];?>
    </div></td>
    <td align="right"><?=number_format($ch_total_amt[$data->chalan_no],2); $tot_ch_total_amt +=$ch_total_amt[$data->chalan_no];?></td>
    <td ><?= date('d-M-y',strtotime($data->chalan_date));?></td>
    </tr>
  
  

  <? }  ?>
  <tr style="font-size:12px;">
    <td>&nbsp;</td>
    <td style="white-space:nowrap;">&nbsp;</td>
    <td style="white-space:nowrap;" >&nbsp;</td>
    <td style="white-space:nowrap;">&nbsp;</td>
    <td style="white-space:nowrap;">&nbsp;</td>
    <td style="white-space:nowrap;">&nbsp;</td>
    <td><strong>TOTAL</strong></td>
    <td align="right"><strong>
      <?=number_format($tot_ch_tot_qty,0);?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($tot_ch_tot_kg,2);?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($tot_ch_total_amt,2);?>
    </strong></td>
    <td >&nbsp;</td>
  </tr>
</table>
</div>

<br />



<br /><br />






<? //}?>








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
selected_two("#do_no");
selected_two("#chalan_no");
selected_two("#dealer_code");
selected_two("#buyer_code");
selected_two("#vehicle_id");
selected_two("#do_no_ch");

?>