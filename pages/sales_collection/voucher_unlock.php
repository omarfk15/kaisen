<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Voucher Unlock';

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
	
	

$del_sjv_sql = "DELETE from secondary_journal where jv_date='0000-00-00' ";
db_query($del_sjv_sql);

$del_jv_sql = "DELETE from journal where jv_date='0000-00-00' ";
db_query($del_jv_sql);
	

	 ?>

<script language="javascript">
window.location.href = "voucher_unlock.php";
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









<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="10%">JV No </th>

    <th width="16%">Ledger ID </th>
    <th width="23%">narration</th>
    <th width="17%">JV Type <span style="height:30px"></span></th>
    <th width="18%">DR AMt </th>
    <th width="16%">CR Amt </th>
  </tr>
  
  

  <?
  
  		$sql = "select ledger_id, ledger_name from accounts_ledger where 1  group by ledger_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $ledger_name[$info->ledger_id]=$info->ledger_name;
		}
  
  $sql = "select * from secondary_journal where jv_date='0000-00-00'";

  $query= db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;
  ?>

  <tr  bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td width="10%"><?=$data->jv_no?></td>

    <td width="16%"><?=$ledger_name[$data->ledger_id]?></td>
    <td width="23%"><?=$data->narration?></td>
    <td  width="17%" style="white-space:normal"><?=$data->tr_from?></td>
    <td  width="18%" bgcolor="#99CCFF"><?=$data->dr_amt?></td>
    <td  width="16%" bgcolor="#99CCFF"><?=$data->cr_amt?></td>
  </tr>
  


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