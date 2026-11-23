<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Head of Sales/COO Approval';

$user_data = find_all_field('user_activity_management','','user_id="'.$_SESSION['user']['id'].'"');

do_calander('#fddate');
do_calander('#tddate');



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
	




	function update_value(do_no,val)
	
	{

var do_no=do_no; // Rent

var val;

var strURL="so_final_approval_ajax.php?do_no="+do_no+"&val="+val;

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
												<td width="33%"><strong> DO No: </strong></td>
												<td width="34%"><strong> Party No: </strong></td>
												<td width="33%"><strong> DO Date: </strong></td>
											</tr>
											
											<tr>
												<td width="33%">
										
	<select name="do_no" id="do_no"  style="width:90%; height:32px;" class="js-example-basic-single">

        <option value=""></option>

		<? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'1 order by do_no desc');?>
      </select>
	
	  </td>
												<td width="34%">
											
		<select name="dealer_code" id="dealer_code"  style="width:90%; height:32px;"  class="js-example-basic-single" >

        <option></option>

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
      </select>		
	  						</td>
												<td width="33%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="50%"><input name="fddate" type="text" id="fddate" style="width:90%; height:32px;" value="<?=$_POST['fddate'];?>" tabindex="1" /></td>
				<td width="50%"><input name="tddate" type="text" id="tddate" style="width:90%; height:32px;" value="<?=$_POST['tddate'];?>" tabindex="1" /></td>
			</tr>
		</table>												</td>
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
    <th width="2%">SL</th>
    <th width="11%"><strong>DO No</strong></th>
    <th width="13%"><strong>Date</strong> </th>
    <th width="22%">Party Name </th>
    <th width="19%">Marketing Person</th>
    <th width="10%">Amount</th>
    <th width="13%">Create Date-Time</th>
    <th width="3%">Action</th>
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

    if($_POST['do_no']!='')
	$do_no_con=" and m.do_no='".$_POST['do_no']."'";
	
	if($_POST['dealer_code']!='')
	$dealer_code_con=" and m.dealer_code='".$_POST['dealer_code']."'";

	if($_POST['marketing_person']!='')
	$marketing_person_con=" and m.marketing_person='".$_POST['marketing_person']."'";
	
	
		
		
		
		$sql = "select d.do_no, sum(d.total_amt) as do_amt from sale_do_details d, item_info i where d.item_id=i.item_id group by d.do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $do_amt[$info->do_no]=$info->do_amt;
		}
		
		
		
		$sql = "select person_code, marketing_person_name from marketing_person where 1 group by person_code";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $marketing_person_name[$info->person_code]=$info->marketing_person_name;
		}
		

 $sql = "select m.*, d.dealer_name_e from  sale_do_master m, dealer_info d
where m.dealer_code=d.dealer_code ".$do_date_con.$do_no_con.$dealer_code_con.$marketing_person_con.$area_code_con." and status='CHECKED' group by m.do_no order by  m.do_no desc";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  ?>


  <tr style="font-size:12px;">
    <td><?=$i;?></td>
    <td style="white-space:nowrap;">
	<a class="hover_none" href="sales_order_print_view.php?do_no=<?=$data->do_no;?>" target="_blank"><strong><?=$data->job_no?></strong></a>	</td>
    <td><?= date('d-M-y',strtotime($data->do_date));?></td>
    <td align="left"><?= $data->dealer_name_e;?></td>
    <td align="left"><?= $marketing_person_name[$data->marketing_person];?></td>
    <td align="right"><?= number_format($do_amt[$data->do_no],2);?></td>
    <td align="right"><?=date("d/m/Y",strtotime($data->entry_at)).' '.date("h:i A",strtotime($data->entry_at));?></td>
    <td >
<span id="divi_<?=$data->do_no?>">
	<table border="0" width="100%">
	<tr>
		<td width="50%">
	
		
	 <input type="button" name="Button" value="Approve"  onclick="update_value(<?=$data->do_no?>,1)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>
	 </td>
		<td  width="50%">
			
	      <input type="button" name="Button" value="Reject"  onclick="update_value(<?=$data->do_no?>,2)" style="width:70px; font-size:12px; height:30px;background-color:#F25B3C; font-weight:700;"/>	
		  
 	  	</td>
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