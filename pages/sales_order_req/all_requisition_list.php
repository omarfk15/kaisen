<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Purchase Requisition';

 $super_id = find_a_field('super_permissions','user_id','user_id="'.$_SESSION['user']['id'].'" and status="Active"');

do_calander('#fdate');
do_calander('#tdate');
//create_combobox('do_no');
create_combobox('dealer_code_bill');
//create_combobox('dealer_code');
//create_combobox('pi_no');
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
	
	db_query($ins_sql);
	}

	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}






//if(isset($_POST['confirm'])){

if(isset($_POST['do_bill'])){
	
	
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$status=MANUAL;	
	
	$running_date=date('Y-m-d');	
		
	$inv_type=$_POST['inv_type'];
	
	//$delivery_address=find_a_field('dealer_info','address_e','dealer_code='.$dealer_code_gp);
//	
//	$tr_no = next_transection_no('0',$running_date,'gate_pass_master','tr_no');
//
//	if($dealer_code_gp>0) {
//	  $ins_sql = 'INSERT INTO gate_pass_master (tr_no, tr_date, dealer_code, delivery_place, delivery_address, status, entry_at, entry_by) VALUES
//
//("'.$tr_no.'", "'.$running_date.'", "'.$dealer_code_gp.'", "'.$dealer_code_gp.'", "'.$delivery_address.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';
//	
//	db_query($ins_sql);
//	}
	
	 ?>
	 
	 
<? if($inv_type==1 || $inv_type==3 || $inv_type==4 || $inv_type==5){?>
<script language="javascript">
window.location.href = "invoice_entry.php?inv_type=<?=$inv_type;?>";
</script>
<? }elseif($inv_type==2) {?>
<script language="javascript">
window.location.href = "../IMPORT_REQUISITION/import_requisition.php?inv_type=<?=$inv_type;?>";
</script>
<? }?>

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



    <td width="9%" align="right" ><strong> Req No: </strong></td>



    <td width="16%" >
	
	<select name="invoice_no" id="invoice_no"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('purchase_requisition_master','invoice_no','view_invoice_no',$_POST['invoice_no'],'1');?>
      </select>	</td>
	
	 <td width="16%" align="right" ><strong> Booking No: </strong></td>
	 <td width="17%" >
	<select name="booking_no" id="booking_no"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('purchase_requisition_master','invoice_no','booking_no',$_POST['booking_no'],'booking_no!=""');?>
      </select></td>
	 <td align="right" ><strong> Req Date: </strong></td>
	 <td colspan="2" align="right" >
	 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="50%"><input name="fddate" type="text" id="fddate" style="width:90%; height:32px;" value="<?=$_POST['fddate'];?>" tabindex="1" /></td>
				<td width="50%"><input name="tddate" type="text" id="tddate" style="width:90%; height:32px;" value="<?=$_POST['tddate'];?>" tabindex="1" /></td>
			</tr>
		</table>	 </td>
	 </tr>
								  <tr>
								    <td align="right" ><strong>Req. Tytpe: </strong></td>
								    <td >
									
		<select name="inv_type_src" id="inv_type_src"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('requisition_type','id','requisition_type',$_POST['inv_type_src'],'1');?>
      </select>
		</td>
								    <td align="right" >&nbsp;</td>
								    <td >&nbsp;</td>
								    <td width="14%" align="right" >&nbsp;</td>
								    <td width="22%" colspan="2" align="right" ><strong>

      <input type="submit" name="find_data" id="find_data" value="Search Data" style="width:120px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
							      </tr>
								</table>

</div>


<? }?>


<?php 
$page_id=738;
  $check_permission=find_a_field('user_roll_activity','count(id)','page_id="'.$page_id.'" and user_id="'.$_SESSION['user']['id'].'" and edit=1');

if($check_permission>0){
?>


<?php } ?>
<div class="box" style="width:100%; background-color: #c5f8f8;">

								<table width="50%" border="0" cellspacing="0" cellpadding="0">
								
								  <tr>
								    <td width="21%" align="right" ><strong>Req. Type:</strong></td>
								    <td width="46%" align="left" >
		<select name="inv_type" id="inv_type"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('requisition_type','id','requisition_type',$_POST['inv_type'],'1');?>
      </select>
									</td>
								    <td width="33%" align="left" ><strong>
<input type="submit" name="do_bill" id="do_bill" value="New Req Entry" style="width:120px; text-transform:uppercase; background: #FF7F50; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
							      </tr>
								</table>

</div>




<? //if($data_found>0){ ?>



<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px;">

  <tr>
    <th width="3%">SL</th>
    <th width="13%"><strong>Req No</strong></th>
    <th width="11%"><strong>Date</strong> </th>
    <th width="16%">Req. Type </th>
    <th width="16%">Create Date-Time</th>
    <th width="18%">Status</th>
    <th width="8%">Action</th>
  </tr>
  
  

  <?
  
  
  
  //if($_POST['fddate']!=''&&$_POST['tddate']!='') $bill_date_con .= ' and m.pi_date between "'.$_POST['fddate'].'" and "'.$_POST['tddate'].'"';
  
  
  
  if($_POST['do_no']==0 && $_POST['pi_no']==0){ 
  
   if($_POST['fddate']!=''){
  	$fdate=$_POST['fddate'];
  }else{
  	//$fdate=date('Y-m-d');
	$fdate = date("Y-m-d", strtotime("-30 day"));
  }
 
 
 if($_POST['tddate']!=''){
  	$tdate=$_POST['tddate'];
  }else{
  	//$tdate=date('Y-m-d');
	$tdate = date("Y-m-d", strtotime("+1 day"));
  }
  
  $req_date_con .= ' and m.invoice_date between "'.$fdate.'" and "'.$tdate.'"';
  
 }
  

  
  
  
		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


    if($_POST['inv_type_src']!='')
	$inv_type_con=" and m.inv_type='".$_POST['inv_type_src']."'";
	
	if($_POST['invoice_no']!='')
	$invoice_no_con=" and m.invoice_no='".$_POST['invoice_no']."'";

	if($_POST['booking_no']!='')
	$booking_no_con=" and m.invoice_no='".$_POST['booking_no']."'";
	
	
		
		
		
		$sql = "select po_no, po_no as found_pi from import_pi_master where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $found_pi[$info->po_no]=$info->found_pi;
		}
		
		$sql = "select po_no, po_no as appl_lc from import_lc_application where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $appl_lc[$info->po_no]=$info->appl_lc;
		}
		
		$sql = "select po_no, po_no as lc_entry from import_lc_info where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $lc_entry[$info->po_no]=$info->lc_entry;
		}
		
		$sql = "select po_no, po_no as lc_entry from import_lc_info where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $lc_entry[$info->po_no]=$info->lc_entry;
		}
		
		$sql = "select po_no, po_no as etd_eta from import_etd_eta where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $etd_eta[$info->po_no]=$info->etd_eta;
		}
		
		$sql = "select po_no, po_no as document_rec from import_commercial_invoice where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $document_rec[$info->po_no]=$info->document_rec;
		}
		
		$sql = "select po_no, po_no as lc_loan from import_lc_info where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $lc_loan[$info->po_no]=$info->lc_loan;
		}
		
		$sql = "select po_no, po_no as lc_pay from import_lc_payment where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $lc_pay[$info->po_no]=$info->lc_pay;
		}
		
		$sql = "select po_no, po_no as grn_entry from import_goods_receive where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $grn_entry[$info->po_no]=$info->grn_entry;
		}
		
		$sql = "select po_no, po_no as cnf_entry from import_cnf_bill where 1 group by po_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cnf_entry[$info->po_no]=$info->cnf_entry;
		}
		
		
		
		$sql = "select id, requisition_type from requisition_type where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $requisition_type[$info->id]=$info->requisition_type;
		}
		
		$sql = "select id, item_type from import_item_type where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $item_type[$info->id]=$info->item_type;
		}



      $sql = "select m.* from purchase_requisition_master m, purchase_requisition_details p 
where m.invoice_no=p.invoice_no and m.inv_type!=2 ".$req_date_con.$inv_type_con.$invoice_no_con.$booking_no_con." group by m.invoice_no order by  m.invoice_no desc";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>


  <tr style="font-size:12px;">
    <td><?=$i;?></td>
    <td>
	<a class="hover_none" href="invoice_print_view.php?invoice_no=<?=$data->invoice_no;?>" target="_blank"><strong><?=$data->view_invoice_no?></strong></a>
	</td>
    <td><?= date('d-M-y',strtotime($data->invoice_date));?></td>
    <td align="left"><?= $requisition_type[$data->inv_type];?></td>
    <td align="right"><?=date("d/m/Y",strtotime($data->entry_at)).' '.date("h:i A",strtotime($data->entry_at));?></td>
    <td align="left">
	<div align="center" style=" line-height: 2; ">
	    <? if($found_pi[$data->po_no]>0){?> 
		  <span style="margin: 0; white-space: nowrap; color: #0fb922;font-weight: 700;"><i class="fa fa-check"></i> PI Entry</span><br />
	      <? }?>
		  
		  <? if($appl_lc[$data->po_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #1097d3;font-weight: 700;"><i class="fa fa-check"></i> Application for LC </span><br />
		  <? }?>
		  
		  <? if($lc_entry[$data->po_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #600fc4;font-weight: 700;"><i class="fa fa-check"></i> LC Entry</span><br />
		  <? }?>
		  
		  <? if($etd_eta[$data->po_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #0000FF;font-weight: 700;"><i class="fa fa-check"></i> ETD ETA</span><br />
		  <? }?>
		  
		  <? if($document_rec[$data->po_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #FF7F50;font-weight: 700;"><i class="fa fa-check"></i> Documents Received</span><br />
		  <? }?>
		  
		  <? if($lc_loan[$data->po_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color: #DE3163;font-weight: 700;"><i class="fa fa-check"></i> Loan Create</span><br />
		  <? }?>
		  
		  <? if($lc_pay[$data->po_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color:  #21618c ;font-weight: 700;"><i class="fa fa-check"></i> LC Payment</span><br />
		  <? }?>
		  
		  <? if($grn_entry[$data->po_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color:  #78281f;  font-weight: 700;"><i class="fa fa-check"></i> Goods In-House</span><br />
		  <? }?>
		  
		  <? if($cnf_entry[$data->po_no]>0){?>
		    <span style="margin: 0; white-space: nowrap; color:  #145a32 ;  font-weight: 700;"><i class="fa fa-check"></i> C&F Bill Entry</span><br />
		  <? }?>
	      </div></td>
    <td >

<? if($data->inv_type==1) {?>
<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" 
href="../REQUISITION/invoice_entry_req_update.php?request_no=<?=$data->invoice_no;?>">EDIT</a>
<? }elseif($data->inv_type==3){?>
<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" 
href="../REQUISITION/invoice_entry_req_update_offset.php?request_no=<?=$data->invoice_no;?>">EDIT</a>
<? }elseif($data->inv_type==4){?>
<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" 
href="../REQUISITION/invoice_entry_req_update_poly.php?request_no=<?=$data->invoice_no;?>">EDIT</a>
<? }elseif($data->inv_type==5){?>
<a class="hover_none" style="padding: 5px 10px; background:#FF0000; text-align:center; color:#000000; font-weight:700; font-size:12px;" 
href="../REQUISITION/invoice_entry_req_update_carton.php?request_no=<?=$data->invoice_no;?>">EDIT</a>
<? }?>
</td>
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

selected_two("#invoice_no");
selected_two("#booking_no");

?>