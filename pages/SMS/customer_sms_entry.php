<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Send SMS';

//do_calander('#tdate');

/////////////////SMS Function//////////////////

/////////////////SMS Function//////////////////

function sendSMS($mobile, $message, $type = 'text')
{
    $apiKey   = "f9ff7ffeb72941f39886f4d052917561";
    $senderId = "KAIZEN KMI";

    // Convert 01XXXXXXXXX -> 8801XXXXXXXXX
    $mobile = preg_replace('/^0/', '880', $mobile);

    // New API URL
    $url = "https://sms.maestro.com.bd/api/smsapi2";

    // Parameters
    $params = [
        'api_key'  => $apiKey,
        'type'     => $type,
        'contacts' => $mobile,
        'senderid' => $senderId,
        'msg'      => $message
    ];

    // Full URL
    $requestUrl = $url . '?' . http_build_query($params);

    // cURL Initialize
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $requestUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    // Execute
    $response = curl_exec($ch);

    // Error Handle
    if (curl_errno($ch)) {

        $error = curl_error($ch);

        curl_close($ch);

        return [
            'status' => false,
            'error'  => $error
        ];
    }

    curl_close($ch);

    // Return API Response
    return json_decode($response, true);
}





$dealer_code=$_REQUEST['dealer_code'];

$data_found = $dealer_code;

if ($data_found==0) {
do_calander('#invoice_date');
do_calander('#need_by');
//create_combobox('fg_item_id');
  }


if(prevent_multi_submit()){






if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$invoice_date = $_POST['invoice_date'];
	$dealer_code = $_POST['dealer_code'];
	$party_name = $_POST['party_name'];
	$marketing_person = $_POST['marketing_person'];
	$mobile_no = $_POST['mobile_no'];
	$balance_amt = $_POST['balance_amt'];
	$total_amt = $_POST['total_amt'];
	$remarks = $_POST['remarks'];
	$group_for=$_SESSION['user']['group'];
	
		$YR = date('Y',strtotime($invoice_date));
  		$year = date('y',strtotime($invoice_date));
  		$month = date('m',strtotime($invoice_date));
		$month_name = date('M',strtotime($invoice_date));

  		$ch_cy_id = find_a_field('customer_sms','max(cy_id)','year="'.$YR.'" ')+1;
   		$cy_id = sprintf("%06d", $ch_cy_id);
   		$sms_no=''.$YR.''.$cy_id;
		$sms_no_view='KMI/SMS-'.$year.'/'.$ch_cy_id;
		
		
	$mobile   = $mobile_no;
	
	$message = "Dear ".$party_name.",\nThis is a reminder that your due balance is Tk. ".$balance_amt.". Date: ".date('d-M-Y',strtotime($invoice_date)).".\nKindly clear the dues as soon as possible.\nThank you.\nKaizen Metal Industries BD Limited";

sendSMS($mobile, $message);
	
	
				
	 $ins_sql = 'INSERT INTO  customer_sms (sms_no, sms_date, sms_no_view, year, cy_id, group_for, marketing_person, dealer_code, party_name, mobile_no, total_amt, remarks, entry_by, entry_at, sms_message)
  
  VALUES("'.$sms_no.'", "'.$invoice_date.'", "'.$sms_no_view.'", "'.$YR.'", "'.$cy_id.'", "'.$group_for.'", "'.$marketing_person.'", "'.$dealer_code.'", "'.$party_name.'", "'.$mobile_no.'", "'.$total_amt.'", "'.$remarks.'", "'.$entry_by.'", "'.$entry_at.'", "'.$message.'")';

db_query($ins_sql);


	

	 
	 ?>

<script language="javascript">
window.location.href = "customer_sms_list.php";
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

<? if ($data_found>0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
								    <td colspan="4" align="left" >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										
										<? $dealer_data = find_all_field('dealer_info','','dealer_code="'.$_REQUEST['dealer_code'].'"'); ?>
											<tr>
												<td width="50%"><strong>TR  Date: </strong></td>
												<td width="50%"><strong> Party Name: </strong></td>
												
											</tr>
											<tr>
												<td width="50%">
<input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?php echo date('Y-m-d');?>" required  readonly=""  tabindex="1" /></td>
												<td width="50%">
		<select name="dealer_code" id="dealer_code"  style="width:90%; height:32px;"  class="js-example-basic-single" >

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'dealer_code="'.$_REQUEST['dealer_code'].'"');?>
      </select>
	  
	  <input name="party_name" type="hidden" id="party_name" style="width:90%; height:32px;" value="<?=$dealer_data->dealer_name_e;?>" readonly=""  autocomplete="off"  tabindex="1" />
												</td>
											</tr>
											
											
											
											<tr>
												<td width="50%"><strong> Marketing Person: </strong></td>
												<td width="50%"><strong>Party Mobile No: </strong></td>
												
											</tr>
											<tr>
												<td width="50%">

	  <select name="marketing_person" id="marketing_person"  style="width:90%; height:32px;" class="js-example-basic-single" required>

	<? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'person_code="'.$dealer_data->marketing_person.'"');?>
      </select>
	  </td>
												<td width="50%">
		<input name="mobile_no" type="text" id="mobile_no" style="width:90%; height:32px;" value="<?=$dealer_data->contact_no;?>"  required   autocomplete="off"  tabindex="1" />
												</td>
											</tr>
											
											
											<tr>
												<td width="50%"><strong> Remarks: </strong></td>
												<td width="50%">&nbsp;</td>
												
											</tr>
											<tr>
												<td width="50%">
<input name="remarks" type="text" id="remarks" style="width:90%; height:32px;" value=""    tabindex="1"  autocomplete="off" /></td>
												<td width="50%" align="center"><input type="submit" name="submitit" id="submitit" value="View Data" style="width:180px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/></td>
											</tr>
											
											<tr>
												<td width="50%">&nbsp;</td>
												<td width="50%">&nbsp;</td>
												
								  </tr>
								  
								  
								  
											
										</table>
									</td>
							      </tr>
	
								</table>

</div>


<? }?>




<? if ($data_found>0) { ?>


<br />




<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="9%">Code</th>

    <th width="68%">Party Name <span style="height:30px"></span></th>
    <th width="23%">Due Balance </th>
    </tr>
  
  

  <?
  
  $date_today=date('Y-m-d');
  
  		 $sql = "select ledger_id, sub_ledger, sum(dr_amt-cr_amt) as closing_amt from journal where jv_date <='".$date_today."' group by ledger_id, sub_ledger";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $closing_amt[$info->ledger_id][$info->sub_ledger]=$info->closing_amt;
		}
  
    $sqlfg = "select d.dealer_code, s.sub_ledger_id, s.ledger_id, s.sub_ledger_name from dealer_info d, general_sub_ledger s
	 where d.dealer_code=s.referance_no and d.dealer_code='".$_REQUEST['dealer_code']."' order by s.sub_ledger_name";

  $queryfg = db_query($sqlfg);

  while($data=mysqli_fetch_object($queryfg)){$i++;
  ?>

  <tr  bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td width="9%"><?=$data->dealer_code?></td>
    <td  width="68%" style="white-space:normal"> <?=$data->sub_ledger_name?></td>
    <td  width="23%" bgcolor="#99CCFF">
	
		  <? if($closing_amt[$data->ledger_id][$data->sub_ledger_id]>0) {
			 $closing_amt_dr = number_format($closing_amt[$data->ledger_id][$data->sub_ledger_id],2); 
			 $total_amt_dr = $closing_amt[$data->ledger_id][$data->sub_ledger_id]; 
		  }?>
	
	<input name="balance_amt" type="text" id="balance_amt" value="<?=$closing_amt_dr?>"  readonly="" required style="width:95%; height:30px; " />
	<input name="total_amt" type="hidden" id="total_amt" value="<?=$total_amt_dr?>"  readonly="" required style="width:95%; height:30px; " />
	</td>
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