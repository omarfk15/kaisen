<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Delivery Challan Return';

 $super_id = find_a_field('super_permissions','user_id','user_id="'.$_SESSION['user']['id'].'" and status="Active"');

//do_calander('#fdate');
//do_calander('#tdate');
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


if(isset($_POST['do_ch'])){
	
	
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');	
		
	$chalan_no_src=$_POST['chalan_no_src'];
	 
	 ?>

<script language="javascript">
window.location.href = "delivery_challan_edit.php?v_no=<?=$chalan_no_src?>";
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


											    <td width="5%" align="right" ><strong>Challan No: </strong></td>
								    <td  width="20%">
		<select name="chalan_no" id="chalan_no"  style="width:100%; height:32px;" class="js-example-basic-single" >

        <option value=""></option>

		<? foreign_relation('sale_do_chalan','chalan_no','chalan_no_view',$_POST['chalan_no'],'year>0 group by chalan_no');?>
      </select></td>
    
	
	 <td width="7%" align="right" ><strong>Customer: </strong></td>
	 <td width="20%" >
	<select name="dealer_code" id="dealer_code"  style="width:100%; height:32px;" class="js-example-basic-single" >

        <option value=""></option>

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
      </select></td>
	 <td  width="5%" align="right" ><strong> Return Date: </strong></td>
	 <td  width="45%" colspan="3" align="right" >
	 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="50%"><input name="fddate" type="date" id="fddate" style="width:98%!important;  height:25px!important;" value="<?=$_POST['fddate'];?>"    /></td>
				<td width="50%"><input name="tddate" type="date" id="tddate" style="width:98%!important; height:25px!important;" value="<?=$_POST['tddate'];?>"    /></td>
			</tr>
		</table>	 </td>
	 </tr>
								  <tr>

	  <td width="9%" align="right" ><strong> DO No: </strong></td>



      <td width="16%" >
	
	<select name="do_no" id="do_no"  style="width:100%; height:32px;" class="js-example-basic-single" >

        <option value=""></option>

		<? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'year>0');?>
      </select>	</td>
								    <td align="right" >&nbsp;</td>
								    <td >&nbsp;</td>
								    <td width="10%" align="right" ><strong> Return No: </strong></td>
								    <td width="25%" align="left" >
	<select name="return_no" id="return_no"  style="width:100%; height:32px;" class="js-example-basic-single" >

        <option value=""></option>

		<? foreign_relation('sale_do_chalan_return','return_no','return_no_view',$_POST['return_no'],'year>0 group by return_no');?>
      </select>
									</td>
								    <td width="22%" colspan="2" align="right" ><strong>

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

								<table width="62%" border="0" cellspacing="0" cellpadding="0">
								
								  <tr>
								    <td width="27%" align="right" ><strong>Challan No: </strong></td>
								    <td width="37%" >
	
	  
	  <select name="chalan_no_src" id="chalan_no_src"  style="width:100%; height:32px;" class="js-example-basic-single" >

        <option value=""></option>

		<? foreign_relation('sale_do_chalan','chalan_no','chalan_no_view',$_POST['chalan_no_src'],'year>0 group by chalan_no');?>
      </select>
	  </td>
								    <td width="36%" align="center" ><strong>
								      <input type="submit" name="do_ch" id="do_ch" value="View Challan" style="width:120px; text-transform:uppercase; background: #52be80; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>
								    </strong></td>
							      </tr>
	  </table>

</div>




<? //if($data_found>0){ ?>



<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px;">

  <tr>
    <th width="1%">SL</th>
    <th width="7%">Return No</th>
    <th width="7%">Challan No</th>
    <th width="10%">Job No </th>

    <th width="14%">Customer</th>
    <th width="11%">Buyer </th>
    <th width="5%"> Quantity </th>
    <th width="7%">Return Date</th>
    <th width="7%">Status</th>
    </tr>
  
  

  <?
  
  
  //if($_POST['fdate']!=''&&$_POST['tdate']!='') $so_date_con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  //if($_POST['fddate']!=''&&$_POST['tddate']!='') $del_date_con .= ' and s.chalan_date between "'.$_POST['fddate'].'" and "'.$_POST['tddate'].'"';
  
  
  
  
  
  
  if($_POST['chalan_no']==0 && $_POST['do_no']==0){ 
  
   if($_POST['fddate']!=''){
  	$fdate=$_POST['fddate'];
  }else{
  	//$fdate=date('Y-m-d');
	$fdate = date("Y-m-d", strtotime("-10 day"));
  }
 
 
 if($_POST['tddate']!=''){
  	$tdate=$_POST['tddate'];
  }else{
  	//$tdate=date('Y-m-d');
	$tdate = date("Y-m-d", strtotime("+5 day"));
  }
  
  $del_date_con .= ' and s.return_date between "'.$fdate.'" and "'.$tdate.'"';
  
 }
  

  
  
  
		



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
	
	if($_POST['return_no']!='')
	$return_no_con=" and s.return_no='".$_POST['return_no']."'";
	
	if($_POST['revise_status']!='')
	$revise_status_con=" and s.revise_count>0";
	
	
	
		
		$sql = "select buyer_code, buyer_name from buyer_info where 1 group by buyer_code";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $buyer_name[$info->buyer_code]=$info->buyer_name;
		}
		
	
		
		$sql = "select vehicle_id, registration_no from vehicle_registration where 1 group by vehicle_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $registration_no[$info->vehicle_id]=$info->registration_no;
		}
		
		
		$sql = "select chalan_no, sum(total_unit) as ch_tot_qty from sale_do_chalan where 1 group by chalan_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $ch_tot_qty[$info->chalan_no]=$info->ch_tot_qty;
		}


       $sql = "select m.*, s.vehicle_id, s.chalan_date, s.entry_at, s.checked_at, s.status, s.return_no, s.return_no_view, s.chalan_no, s.chalan_no_view, s.vehicle_no, sum(s.total_unit) as return_qty, s.entry_at, d.dealer_name_e
	   from sale_do_master m, sale_do_chalan_return s,  dealer_info d 
	 where m.do_no=s.do_no and m.dealer_code=d.dealer_code 
	 ".$so_date_con.$del_date_con.$dealer_con.$do_no_con.$buyer_con.$vehicle_con.$chalan_con.$revise_status_con.$return_no_con." group by s.return_no order by  s.return_no desc";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>





  <tr style="font-size:12px;">
    <td><?=$i;?></td>
    <td><a class="hover_none" href="../../../sales_mod/pages/wo/delivery_challan_return_print_view.php?v_no=<?=$data->return_no;?>" target="_blank"><strong><?=$data->return_no_view?></strong></a></td>
    <td><a class="hover_none" href="../../../sales_mod/pages/wo/delivery_challan_print_view.php?v_no=<?=$data->chalan_no;?>" target="_blank"><strong><?=$data->chalan_no_view?></strong></a> </td>
    <td style="white-space:nowrap"><? if($_SESSION['user']['id']==10001 || $_SESSION['user']['id']==10004 || $_SESSION['user']['id']==10005) {?>
		<a class="hover_none" title="WO Preview" target="_blank" href="../wo/work_order_print_view.php?v_no=<?=$data->do_no?>"><strong><?=$data->job_no?></strong></a>
		<? }else{?>
		<a class="hover_none"title="WO Preview" target="_blank" href="../wo/work_order_without_value_print_view.php?v_no=<?=$data->do_no?>"><strong><?=$data->job_no?></strong></a>
		<? }?></td>

    <td><?=$data->dealer_name_e?></td>
    <td><?=$buyer_name[$data->buyer_code]?></td>
    <td align="right"><div align="right">
      <?=number_format($data->return_qty,2);?>
    </div>      </td>
    <td ><?= date('d-M-y',strtotime($data->chalan_date));?></td>
    <td >
	<? if($data->status=='CHECKED'){ ?>
	<b>Verified</b><br />
	<?=date("d/m/y",strtotime($data->checked_at)).' '.date("h:i A",strtotime($data->checked_at));?>
	<? }elseif($data->status=='REJECTED'){?>
	<b><span style="color:#FF0000; font-weight:700; ">Rejected</span></b><br />
	<? }elseif($data->status=='Store Approved'){?>
	  <span style="margin: 0; white-space: nowrap; color: #008000;font-weight: 700;">Store Approved</span>
	<? } else{?>
	  <span style="margin: 0; white-space: nowrap; color: #008000;font-weight: 700;">Unverified</span>
	<? } ?>	</td>
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
selected_two("#return_no");
selected_two("#do_no_ch");
selected_two("#chalan_no_src");

?>