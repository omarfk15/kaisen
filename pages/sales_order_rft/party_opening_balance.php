<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Party Opening Balance';

$user_data = find_all_field('user_activity_management','','user_id="'.$_SESSION['user']['id'].'"');

//do_calander('#obdate');
//do_calander('#tddate');



if(prevent_multi_submit()){



if(isset($_POST['ms_data'])){
	
	
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	$status=MANUAL;	
	
	$running_date=date('Y-m-d');	
		
	$dealer_code_src=$_POST['dealer_code_src'];
	
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
	 
<? if($dealer_code_src>0) {?>
<script language="javascript">
window.location.href = "do_entry.php?dealer_code=<?=$dealer_code_src;?>";
</script>
<? }?>

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
	




	function update_value(sub_ledger_id,val)
	
	{


var obdate=(document.getElementById('obdate').value); 

var sub_ledger_id=sub_ledger_id; // Rent

var val;

var ledger_id=(document.getElementById('ledger_id_'+sub_ledger_id).value);
var dr_amt=(document.getElementById('dr_amt_'+sub_ledger_id).value);
var cr_amt=(document.getElementById('cr_amt_'+sub_ledger_id).value);

var strURL="party_opening_balance_ajax.php?sub_ledger_id="+sub_ledger_id+"&val="+val+"&ledger_id="+ledger_id+"&dr_amt="+dr_amt+"&cr_amt="+cr_amt+"&obdate="+obdate;

		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+sub_ledger_id).style.display='inline';

						document.getElementById('divi_'+sub_ledger_id).innerHTML=req.responseText;						

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


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" >

								  <tr>
								    <td colspan="7" align="left" >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="33%"><strong> Party No: </strong></td>
												<td width="34%"><strong> Opening Date: </strong></td>
												<td width="33%">&nbsp;</td>
											</tr>
											
											<tr>
												<td width="33%">
												<select name="dealer_code" id="dealer_code"  style="width:90%; height:32px;"  class="js-example-basic-single" >
                                                  <option></option>
                                                  <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
                                                </select>	  </td>
											  <td width="34%">
											  <input name="obdate" type="text" id="obdate" style="width:90%; height:32px;" value="2024-12-31" tabindex="1" readonly="" /></td>
												<td width="33%">&nbsp;</td>
											</tr>
											
											
											
											
											<tr>
												<td width="33%"><strong>Marketing: </strong></td>
												<td width="34%"><strong> Area: </strong></td>
												<td width="33%">&nbsp;</td>
											</tr>
											
											<tr>
												<td width="33%">
		
		<select name="marketing_person" id="marketing_person"  style="width:90%; height:32px;" class="js-example-basic-single">

        <option value=""></option>

		<? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'1');?>
      </select>
	
												</td>
												<td width="34%">
		<select name="area_code" id="area_code"  style="width:90%; height:32px;"  class="js-example-basic-single" >

        <option></option>

		<? foreign_relation('area','AREA_CODE','AREA_NAME',$_POST['area_code'],'1');?>
      </select>												</td>
												<td width="33%" align="center">
		<strong>

      <input type="submit" name="find_data" id="find_data" value="Search Data" style="width:120px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong>												</td>
											</tr>
											
											
											
											
										</table>									</td>
							      </tr>
								  
								  
								  
								</table>

</div>



<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px;">

  <tr>
    <th width="1%">SL</th>
    <th width="9%">Code</th>
    <th width="27%">Party Name </th>
    <th width="23%">Marketing Person</th>
    <th width="15%">DR Amt </th>
    <th width="15%">CR Amt </th>
    <th width="10%">Action</th>
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
  
  $do_date_con .= ' and m.do_date between "'.$fdate.'" and "'.$tdate.'"';
  
 }
 
  

 	if($_POST['area_code']!='')
	$area_code_con=" and d.area_code='".$_POST['area_code']."'";
	
	if($_POST['dealer_code']!='')
	$dealer_code_con=" and d.dealer_code='".$_POST['dealer_code']."'";

	if($_POST['marketing_person']!='')
	$marketing_person_con=" and d.marketing_person='".$_POST['marketing_person']."'";
		
		
		$sql = "select sub_ledger, dr_amt, cr_amt from secondary_journal where 1 group by sub_ledger";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $dr_amt[$info->sub_ledger]=$info->dr_amt;
		 $cr_amt[$info->sub_ledger]=$info->cr_amt;
		}
		
		
		
		$sql = "select person_code, marketing_person_name from marketing_person where 1 group by person_code";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $marketing_person_name[$info->person_code]=$info->marketing_person_name;
		}
		

  $sql = "select a.sub_ledger_id,  a.sub_ledger_name, a.ledger_id, d.marketing_person from  general_sub_ledger a, dealer_info d
where a.referance_no=d.dealer_code ".$marketing_person_con.$area_code_con.$dealer_code_con." order by d.dealer_code";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>


  <tr style="font-size:12px;">
    <td><?=$i;?></td>
    <td><?= $data->sub_ledger_id;?></td>
    <td align="left"><?= $data->sub_ledger_name;?>
	<input name="ledger_id_<?=$data->sub_ledger_id?>" type="hidden" id="ledger_id_<?=$data->sub_ledger_id?>" style="width:90px;" value="<?=$data->ledger_id?>" /></td>
    <td align="left"><?= $marketing_person_name[$data->marketing_person];?></td>
    <td align="right"><input name="dr_amt_<?=$data->sub_ledger_id?>" type="text" id="dr_amt_<?=$data->sub_ledger_id?>" style="width:90%; height:32px;" 
	value="<?=$dr_amt[$data->sub_ledger_id]?>" /></td>
    <td align="right"><input name="cr_amt_<?=$data->sub_ledger_id?>" type="text" id="cr_amt_<?=$data->sub_ledger_id?>" style="width:90%; height:32px;"
	 value="<?=$cr_amt[$data->sub_ledger_id]?>" /></td>
    <td >
<span id="divi_<?=$data->sub_ledger_id?>">
	<table border="0" width="100%">
	<tr>
		<td width="100%">
	
		<? if($ob_amt=$dr_amt[$data->sub_ledger_id]+$cr_amt[$data->sub_ledger_id]>0) {?>
	 <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->sub_ledger_id?>,1)" style="width:70px; font-size:12px; height:30px; background-color: #FF0000; font-weight:700;"/>
	 <? }else{?>
	  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->sub_ledger_id?>,1)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>
	  <? }?>	 </td>
	</tr>
</table>
	</span></td>
  </tr>
  

  <? }  ?>
</table>
</div>

<br />



<br /><br />










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

selected_two("#invoice_no");
selected_two("#booking_no");

?>