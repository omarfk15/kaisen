<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";



$title='Delivery Challan Create';

//do_calander('#so_date','-10','10');

do_calander('#so_date','-60','10');
create_combobox('vehicle_id');
create_combobox('driver_id');
create_combobox('delivery_man');
//do_calander('#so_date');



$table_master='sale_do_master';

$table_details='sale_do_details';

 $unique='do_no';

 $chalan_no=$_REQUEST['v_no'];

$get_do_no=find_a_field('sale_do_chalan','do_no','chalan_no="'.$chalan_no.'"');


if($get_do_no>0)

 $$unique=$get_do_no;



if($get_do_no>0){

$$unique=$get_do_no;

$_SESSION[$unique]=$get_do_no;}

else

 $$unique = $get_do_no;




if(isset($_POST['weight_cal'])){
	
	
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');	
		
	$chalan_no=$_POST['chalan_no'];
	$bridge_scale_weight=$_POST['bridge_scale_weight'];
	$hanging_weight=$_POST['net_hanging_weight'];
	
	$adj_qty=$bridge_scale_weight-$hanging_weight;
	
	//if($adj_qty>0){
	$cal_data=$adj_qty/$hanging_weight;
	//}else{
	//$cal_data=0;
	//}
	 
	 ?>

<!--<script language="javascript">
window.location.href = "delivery_challan_from_wo.php?do_no=<?=$do_no_ch?>&tr_no=<?=$ch_tr_no?>";
</script>-->

<? 
		
}






if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

		$status ='APPROVED';
		
		$group_for = $_POST['group_for'];
		$ch_date=$_POST['so_date'];
		
		$delivery_place=$_POST['delivery_place'];
		$dealer_address=$_POST['dealer_address'];
		$delivery_address=$_POST['delivery_address'];
		
		$vehicle_no=$_POST['vehicle_no'];
		
		$driver_name=$_POST['driver_name'];
		$driver_mobile=$_POST['driver_mobile'];

		$receiver_name=$_POST['receiver_name'];
		$receiver_mobile=$_POST['receiver_mobile'];
		
		$prepared_by=$_POST['prepared_by'];
		$authorized_by=$_POST['authorized_by'];
		
		$tr_no=$_POST['tr_no'];
		$year=$_POST['year'];
		$ch_id=$_POST['ch_id'];
		$chalan_no=$_POST['chalan_no'];
		$do_no=$_POST['do_no'];
		$chalan_no_view=$_POST['chalan_no_view'];
		$gatepass_no=$_POST['gatepass_no'];
		$invoice_no=$_POST['invoice_no'];
		$ch_entry_by=$_POST['ch_entry_by'];
		$ch_entry_at=$_POST['ch_entry_at'];

		$approve_by= $_SESSION['user']['id'];
		$approve_at = date('Y-m-d H:i:s');
		
		$bridge_scale_weight=$_POST['bridge_scale_weight'];
		
		
		
$del_ch_sql = "DELETE from sale_do_chalan where chalan_no='".$chalan_no."' and do_no='".$do_no."'";
db_query($del_ch_sql);

$del_ji_sql = "DELETE from journal_item where sr_no='".$chalan_no."' and tr_from='Sales' ";
db_query($del_ji_sql);

$del_sjv_sql = "DELETE from secondary_journal where tr_no='".$chalan_no."' and tr_from='Sales'";
db_query($del_sjv_sql);

$del_jv_sql = "DELETE from journal where tr_no='".$chalan_no."' and tr_from='Sales'";
db_query($del_jv_sql);
		
		$found_ch_no=find_a_field('sale_do_chalan','chalan_no','chalan_no="'.$chalan_no.'"');
		
		if($found_ch_no<1) {
		
		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);

		$sql = 'select * from sale_do_details where  do_no = '.$do_no;
		
		$query = db_query($sql);
		
		while($data=mysqli_fetch_object($query))
		
		{
			if($_POST['total_unit_'.$data->id]>0)
			{	
				$order_no=$data->id;
				$item_id=$_POST['item_id_'.$data->id];
				$rate=$_POST['rate_'.$data->id];
				$tr_id=$_POST['tr_id_'.$data->id];
				$total_unit_pcs=$_POST['total_unit_pcs_'.$data->id];
				$hanging_weight=$_POST['hanging_weight_'.$data->id];
				$adjusted_weight=$_POST['adjusted_weight_'.$data->id];
				$total_unit=$_POST['total_unit_'.$data->id];
				$per_pcs_weight=$total_unit/$total_unit_pcs;
				$chalan_amt=$total_unit*$rate;
				
				$vat_amt=($chalan_amt/115)*15;
				$amt_without_vat=$chalan_amt-$vat_amt;
				
 $so_invoice = 'INSERT INTO sale_do_chalan (tr_no, tr_id, year, ch_id, chalan_no, chalan_no_view, chalan_date, gatepass_no, invoice_no, order_no, do_no, job_no, do_date, size, mark, length, thickness, item_id, dealer_code, delivery_place, dealer_address, marketing_person, unit_price, total_unit_pcs, per_pcs_weight, total_unit, total_amt, depot_id, group_for, prepared_by, authorized_by, vehicle_no, driver_name, driver_mobile, receiver_name, receiver_mobile, delivery_man, delivery_man_mobile, entry_by, entry_at, status, vat_amt, amt_without_vat, hanging_weight, adjusted_weight, bridge_scale_weight, approve_by, approve_at)
  
  VALUES("'.$tr_no.'", "'.$tr_id.'", "'.$year.'", "'.$ch_id.'", "'.$chalan_no.'", "'.$chalan_no_view.'", "'.$ch_date.'", "'.$gatepass_no.'", "'.$invoice_no.'", "'.$order_no.'", "'.$do_no.'", "'.$ms_data->job_no.'", "'.$ms_data->do_date.'", "'.$data->size.'", "'.$data->mark.'", "'.$data->length.'", "'.$data->thickness.'", "'.$item_id.'", "'.$data->dealer_code.'", "'.$delivery_place.'", "'.$dealer_address.'", "'.$marketing_person.'", "'.$rate.'", "'.$total_unit_pcs.'", "'.$per_pcs_weight.'", "'.$total_unit.'", "'.$chalan_amt.'", "'.$data->depot_id.'", "'.$data->group_for.'", "'.$prepared_by.'", "'.$authorized_by.'", "'.$vehicle_no.'", "'.$driver_name.'", "'.$driver_mobile.'", "'.$receiver_name.'", "'.$receiver_mobile.'", "'.$delivery_man.'", "'.$delivery_man_mobile.'", "'.$ch_entry_by.'", "'.$ch_entry_at.'", "'.$status.'", "'.$vat_amt.'", "'.$amt_without_vat.'", "'.$hanging_weight.'", "'.$adjusted_weight.'", "'.$bridge_scale_weight.'", "'.$approve_by.'", "'.$approve_at.'")';

db_query($so_invoice);


}

}


}


$found_ch_jv_no=find_a_field('secondary_journal','jv_no','tr_no="'.$chalan_no.'" and tr_from="Sales"');



		if($found_ch_jv_no==0)
		{
auto_insert_sales_invoice_secoundary($chalan_no);
		}


?>
<script language="javascript">
window.location.href = "all_do_challan_approval.php";
</script>
<?

	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

//if($delivery_within>0)
//{
//	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);
//}







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
	
	
	


function calculation_1(id){

var unso_qty=((document.getElementById('unso_qty_'+id).value)*1);

var chalan=((document.getElementById('chalan_'+id).value)*1);
var pack_size=((document.getElementById('pack_size_'+id).value)*1);

if (chalan>=pack_size)  {

var pcs_1=(document.getElementById('pcs_1_'+id).value)=pack_size;
var bundle_1=(document.getElementById('bundle_1_'+id).value)=parseInt(chalan/pack_size);

var pcs_2=(document.getElementById('pcs_2_'+id).value)= chalan - (pcs_1*bundle_1);


var bundle_2_cal=pcs_2;

if (bundle_2_cal < 1) {
  bundle_2_qty = 0;
} else {
  bundle_2_qty = 1;
}

var bundle_2=(document.getElementById('bundle_2_'+id).value)=bundle_2_qty;

}


if (chalan<pack_size)  {
var pcs_1=(document.getElementById('pcs_1_'+id).value)=chalan;
var bundle_1=(document.getElementById('bundle_1_'+id).value)=1;

var pcs_2=(document.getElementById('pcs_2_'+id).value)=0;
var bundle_2=(document.getElementById('bundle_2_'+id).value)=0;


}

//alert(bundle_2);


 if(chalan>unso_qty)
  {
alert('Can not issue more than pending quantity.');
document.getElementById('chalan_'+id).value='';
document.getElementById('pcs_1_'+id).value='';
document.getElementById('bundle_1_'+id).value='';

document.getElementById('pcs_2_'+id).value='';
document.getElementById('bundle_2_'+id).value='';

document.getElementById('pcs_3_'+id).value='';
document.getElementById('bundle_3_'+id).value='';

document.getElementById('sum_chalan_'+id).value='';

  } 



}




function calculation(id){

var chalan=((document.getElementById('chalan_'+id).value)*1);

var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);




 if(chalan>pending_qty)
  {
alert('Can not issue more than produced quantity.');
document.getElementById('chalan_'+id).value='';


  } 



//if (pp_bag >0) {
//	var pp_qty= document.getElementById('pp_qty_'+id).value= (bag_size*pp_bag);
//	var hdpe_bag= document.getElementById('hdpe_bag_'+id).value= (pp_bag/3);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (pp_bag+hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (pp_qty+hdpe_qty);
//} else if((pp_bag ==0)) {
//	var hdpe_bag=((document.getElementById('hdpe_bag_'+id).value)*1);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (hdpe_qty);
//}
//
//var wastage_starting=((document.getElementById('wastage_starting_'+id).value)*1);
//var wastage_on_process=((document.getElementById('wastage_on_process_'+id).value)*1);
//var total_wastage= document.getElementById('total_wastage_'+id).value= (wastage_starting+wastage_on_process);
//var net_total_qty= document.getElementById('net_total_qty_'+id).value= (total_qty-total_wastage);


}





	function update_value(id)

	{

var order_no=id; // Rent

var tr_no=(document.getElementById('tr_no_'+order_no).value); 
var rate=(document.getElementById('rate_'+order_no).value); 
var item_id=(document.getElementById('item_id_'+order_no).value); 
var item_name=(document.getElementById('item_name_'+order_no).value); 
var chalan=(document.getElementById('chalan_'+order_no).value); 
var chalan_kg=(document.getElementById('chalan_kg_'+order_no).value); 

var strURL="delivery_chalan_ajax.php?order_no="+order_no+"&tr_no="+tr_no+"&rate="+rate+"&item_id="+item_id+"&item_name="+item_name+"&chalan="+chalan+"&chalan_kg="+chalan_kg;

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




	function update_value_delete(id)

	{

var order_no=id; // Rent

var tr_no=(document.getElementById('tr_no_'+order_no).value); 
var rate=(document.getElementById('rate_'+order_no).value); 
var item_id=(document.getElementById('item_id_'+order_no).value); 
var item_name=(document.getElementById('item_name_'+order_no).value); 
var chalan=(document.getElementById('chalan_'+order_no).value); 

var strURL="delivery_chalan_delete_ajax.php?order_no="+order_no+"&tr_no="+tr_no+"&rate="+rate+"&item_id="+item_id+"&item_name="+item_name+"&chalan="+chalan;

		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_del_'+order_no).style.display='inline';

						document.getElementById('divi_del_'+order_no).innerHTML=req.responseText;						

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

<script>

 

    function selectedAll(){

        $('input[type=checkbox]').prop('checked', true);
        
    }
	
	function RemoveAll(){

        $('input[type=checkbox]').prop('checked', false);
        
    }
    
    function select_all(perm){
       document.getElementById("point"+perm).checked = true;
      
    }
    
    function remove_all(perm){
       document.getElementById("point"+perm).checked = false;
       
    }
    
</script>



<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


/*div.form-container_large input {
    width: 150px;
    height: 38px;
    border-radius: 0px !important;
}
*/

div.form-container_large input {
    /*width: 160px;*/

/*	width: 85% !important; */
  width:220px;
    height: 38px;
	font-size:14px;
    border-radius: 0px !important;
}


</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="40%"  valign="middle"><fieldset style="width:100%;">

    <? $field='do_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">DO  No: </label>

        <input  name="do_no" type="hidden" id="do_no" value="<?=$do_no?>" readonly=""/>
		
		<input  name="job_no" type="text" id="job_no" value="<?=$job_no?>" readonly="" style="width:50%" />
		<input  name="sales_type" type="hidden" id="sales_type" value="<?=$sales_type?>" readonly="" style="width:50%" />

      </div>

    <? $field='do_date';?>

      <div>

        <label style="width:140px;" for="<?=$field?>"> Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly="" style="width:50%"/>

      </div>
	  
	  
	  
	 

      <div>

        <label style="width:140px;" for="<?=$field?>"> Marketing Person: </label>

       <select name="marketing_person" id="marketing_person"  style="width:50%; height:32px;" >
		<? foreign_relation('marketing_person','person_code','marketing_person_name',$marketing_person,'person_code="'.$marketing_person.'"');?>
      </select>

      </div>
	  
	  

      

    

  
	  
	  
	   


     

    </fieldset></td>

    <td width="9%">			</td>

    <td width="40%"><fieldset style="width:100%;">
	
	
	
	<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Company:</label>

        <input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" style="width:50%" readonly="" />

		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required="required"/>

      </div>
	  
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>"> Customer:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" required="required" style="width:50%"  readonly=""/>

		<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" required="required"/>

      </div>
	
	


      <div>

        <label style="width:120px;" for="<?=$field?>"> Address:</label>

         <input  name="buyer_info2" type="text" id="buyer_info2" value="<?=$dealer_address;?>" 
		 style="width:50%" required="required"  readonly=""/>

		<input  name="buyer_code" type="hidden" id="buyer_code" value="<?=$buyer_code?>" required="required"/>

      </div>

      <div></div>
 

      

              

      <div>


      

      </div>

		</fieldset></td>

    <td width="2%">&nbsp;</td>

  

  </tr>

  

  <tr>

    <td colspan="5" valign="top">

<style>

	.custom-combobox-input{
	  margin: 0px;
	  font-size: 12px;
	  height: 30px !important;
	}
	.custom-combobox-toggle{
	height: 30px;
	}
</style>
<!--12% 18% 14% 18% 12% 18%-->
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size: 14px;font-weight: bold;">
      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-top: 5px; margin-bottom: 15px; ">
            <tr>
              <td width="11%" align="left" bgcolor="#9966FF" style=" padding-left: 5px; "><strong>Challan Date:
			  <? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);
			     $dealer_data = find_all_field('dealer_info','','dealer_code='.$dealer_code);
			  ?>
			  </strong></td>
              <td width="21%" align="left" bgcolor="#9966FF"><strong>
			  <input type="hidden" name="tr_no" id="tr_no" value="<?=$ch_data->tr_no?>" />
			
			  <input type="hidden" name="year" id="year" value="<?=$ch_data->year?>" />
			  <input type="hidden" name="ch_id" id="ch_id" value="<?=$ch_data->ch_id?>" />
			  <input type="hidden" name="chalan_no" id="chalan_no" value="<?=$ch_data->chalan_no?>" />
			  <input type="hidden" name="do_no" id="do_no" value="<?=$ch_data->do_no?>" />
			  <input type="hidden" name="chalan_no_view" id="chalan_no_view" value="<?=$ch_data->chalan_no_view?>" />
			  <input type="hidden" name="gatepass_no" id="gatepass_no" value="<?=$ch_data->gatepass_no?>" />
			  <input type="hidden" name="invoice_no" id="invoice_no" value="<?=$ch_data->invoice_no?>" />
			  <input type="hidden" name="ch_entry_by" id="ch_entry_by" value="<?=$ch_data->entry_by?>" />
			  <input type="hidden" name="ch_entry_at" id="ch_entry_at" value="<?=$ch_data->entry_at?>" />
			  
			  <input style="width:100% !important; margin-left: 0px;"  name="so_date" type="text" id="so_date" required="required" value="<?=$ch_data->chalan_date;?>" readonly=""/>
              </strong></td>
              <td width="13%" align="right" bgcolor="#9966FF" style=" padding-left: 5px; "><strong>Prepared By:</strong></td>
              <td width="21%" align="left" bgcolor="#9966FF"><strong>
                <select name="prepared_by" required id="prepared_by"  tabindex="7" style="width:100% !important; margin-left: 0px;">
					
                      <? foreign_relation('prepared_by','id','prepared_by',$ch_data->prepared_by,'status="Active"');?>
                    </select>
              </strong></td>
              <td width="13%" align="right" bgcolor="#9966FF" style=" padding-left: 5px; "><strong>Authorized By:</strong></td>
              <td width="21%" bgcolor="#9966FF" style=" padding: 0px 5px 0px 0px; "><strong>
                <select name="authorized_by" required id="authorized_by"  tabindex="7" style="width:100% !important; margin-left: 0px;">
					
                      <? foreign_relation('authorized_by','id','authorized_by',$ch_data->authorized_by,'status="Active"');?>
                    </select>
              </strong></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Vehicale No:</strong></td>
              <td bgcolor="#b4b4ff"><strong>
               
				<input style="width:100% !important; margin-left: 4px;"  name="vehicle_no" type="text" id="vehicle_no" value="<?=$ch_data->vehicle_no?>" required/>
				
				
                </strong></td>
              <td align="right" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Driver Name: </strong></td>
              <td bgcolor="#b4b4ff"><strong>
                
				<input style="width:100% !important; margin-left: 4px;"  name="driver_name" type="text" id="driver_name" value="<?=$ch_data->driver_name?>" required/>
				
                </strong></td>
              <td align="right" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Driver Mobile: </strong></td>
              <td bgcolor="#b4b4ff"  style=" padding: 0px 5px 0px 0px; "><strong>
                <input style="width:100% !important; margin-left: 4px;"  name="driver_mobile" type="text" id="driver_mobile" value="<?=$ch_data->driver_mobile?>" required/>
              </strong></td>
            <!--<td width="1%">&nbsp;</td>-->
            </tr>
			 <tr>
              <td align="left" bgcolor="#9999FF" style=" padding-left: 5px; "><strong>Deli. Address: </strong></td>
              <td bgcolor="#9999FF"><strong>
				
 <input style="width:100% !important; margin-left: 4px;"  name="delivery_place" readonly="" type="hidden" id="delivery_place" value="<?=$ch_data->delivery_place?>"/>
				 
	 <input style="width:100% !important; margin-left: 4px;"  name="dealer_address" readonly="" type="hidden" id="dealer_address" value="<?=$ch_data->dealer_address;?>"/>
		
<input style="width: 100% !important; margin-left: 4px;"  name="delivery_address" type="text" id="delivery_address" readonly="" value="<?=$ch_data->dealer_address;?>"/>
				
                </strong></td>
             <td align="right" bgcolor="#9999FF" style=" padding-left: 5px; "><strong>Receiver Name:</strong></td>
			 <td align="left" bgcolor="#9999FF" style=" padding-left: 5px; ">
 <input style="width:100% !important; margin-left: 4px;"  name="receiver_name"  type="text" id="receiver_name" value="<?=$ch_data->receiver_name;?>" required />
		
			 </td>
			 <td align="right" bgcolor="#9999FF" style=" padding-left: 5px; "><strong>Receiver Mobile:</strong></td>
                           <td align="left" bgcolor="#9999FF" style=" padding-left: 5px; ">
<input style="width:100% !important; margin-left: 4px;"  name="receiver_mobile"  type="text" id="receiver_mobile" value="<?=$ch_data->receiver_mobile;?>" required />						   </td>
			 </tr>
           
          </table></td>
      </tr>
    </table></td>

    </tr>
	
	
	

</table>

<div class="box" style="width:100%; background-color: #c5f8f8;">

								<table width="64%" border="0" cellspacing="0" cellpadding="0">
								
								  <tr>
								    <td width="38%" align="right" ><strong>Bridge Scale Weight: </strong></td>
								    <td width="38%" >
		
<input style="width:100% !important; margin-left: 4px;" name="bridge_scale_weight" type="text" id="bridge_scale_weight" value="<?=$_POST['bridge_scale_weight']?>" /></td>
								    <td width="24%" align="center" ><strong>
								      <input type="submit" name="weight_cal" id="weight_cal" value="Weight Cal" style="width:120px; text-transform:uppercase; background: #52be80; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>
								    </strong></td>
							      </tr>
	  </table>

</div>

<? if($$unique>0){
		
		 $sql = "select order_no, tr_no, tr_id, sum(total_unit_pcs) as total_unit_pcs, sum(hanging_weight) as hanging_qty, sum(adjusted_weight) as adjusted_qty,  sum(total_unit) as total_unit from sale_do_chalan where chalan_no='".$chalan_no."' group by order_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
		  $tr_no[$info->order_no]=$info->tr_no;
		  $tr_id[$info->order_no]=$info->tr_id;
		   
  		 $total_unit_pcs[$info->order_no]=$info->total_unit_pcs;
		 $hanging_qty[$info->order_no]=$info->hanging_qty; 
		 $adjusted_qty[$info->order_no]=$info->adjusted_qty; 
		 $total_unit[$info->order_no]=$info->total_unit;
		}




    $sql='select a.*, b.item_name from sale_do_details a,item_info b, item_sub_group s 
   where b.item_id=a.item_id and b.sub_group_id=s.sub_group_id and  a.do_no="'.$do_no.'"  order by  b.sub_group_id, b.item_id';

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="3%">SL</th>

            <th width="14%">Product </th>

            <th width="12%"><strong>Size</strong></th>
            <th width="7%"><strong>Thickness</strong></th>
            <th width="7%"><strong>Mark</strong></th>
            <th bgcolor="#FFFFFF"><strong>Length</strong></th>

            <th bgcolor="#F57E22" style="white-space:nowrap;">Delivery/Pcs </th>
            <th bgcolor="#D78AF2" style="white-space:nowrap;">Delivery/KG</th>
            <th bgcolor="#D78AF2" style="white-space:nowrap;">Adjusted Weight</th>
            <th bgcolor="#D78AF2" style="white-space:nowrap;">Final Weight</th>
            <th bgcolor="#D78AF2" style="white-space:nowrap;">
<span onclick="selectedAll()" class="btn" style="color:#242020;background-color:#80c4c7;border-color:#408d99; width:20px; height:30px; padding:8px; font-size:12px">ALL</span>
<!--<span onclick="RemoveAll()" class="btn" style="color: #ffffff;background-color: #ec4848;border-color: #994040; width:20px; height:30px; padding:8px; font-size:12px">DEL ALL</span>-->
			</th>
          </tr>
          
          

          

    <? while($row=mysqli_fetch_object($res)){$bg++?>
		  
	<? if ($total_unit_pcs[$row->id]>0) {?>
          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td>
			<?=$row->item_name;?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	
			<input type="hidden" name="tr_id_<?=$row->id?>" id="tr_id_<?=$row->id?>" value="<?=$tr_id[$row->id];?>" />
			<input name="item_name_<?=$row->id?>" type="hidden" id="item_name_<?=$row->id?>"   value="<?=$row->item_name;?>"  style="width:150px; height:25px; float:none" />			</td>
          
              <td>
			  
		<?=$row->size?></td>
              <td><span style=" white-space: nowrap;">
                <?=$row->thickness?>
mm</span></td>
              <td><span style=" white-space: nowrap;">
                <?=$row->mark?>
              </span></td>
              <td width="5%" align="center"><span style=" white-space: nowrap;">
                <?=$row->length?>'</span></td>

     <td width="11%" align="center" bgcolor="#F57E22">
			  
          <input name="total_unit_pcs_<?=$row->id?>" type="text" id="total_unit_pcs_<?=$row->id?>" value="<?=$total_unit_pcs[$row->id];?>"  style="width:100px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />		    </td>
              <td width="11%" align="center" bgcolor="#D78AF2">
			  
  <input name="hanging_weight_<?=$row->id?>" type="text" id="hanging_weight_<?=$row->id?>" 
   value="<?=$hanging_qty[$row->id]; $tot_hanging_weight +=$hanging_qty[$row->id];?>"  style="width:100px; height:25px; float:none"  />               		  </td>
              <td width="11%" align="center" bgcolor="#D78AF2">
			  		  
          <input name="adjusted_weight_<?=$row->id?>" type="text" id="adjusted_weight_<?=$row->id?>" 
		  value="<?=$adjusted_weight_cal=round($hanging_qty[$row->id]*$cal_data,2);?>"  style="width:100px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />			  </td>
              <td width="12%" align="center" bgcolor="#D78AF2">
			    <input name="total_unit_<?=$row->id?>" type="text" id="total_unit_<?=$row->id?>"
				 value="<?=$final_weight=round($hanging_qty[$row->id]+$adjusted_weight_cal,2); $tot_final_weight +=$final_weight?>"  style="width:100px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />			  </td>
              <td width="7%" align="center" bgcolor="#D78AF2">
			  <center> 
			 <?php /*?><? if($unso_qty>0){$cow++;?> <? } else echo 'Done';?>	<?php */?>
			 <input type="checkbox" name="point[]" id="point" value="<?=$row->id?>" style="width:25px; text-align:center" />
			  </center>
			  </td>
          </tr>
          

          <? } }?>
		  
		  
		  <tr >
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center" bgcolor="#F57E22">&nbsp;</td>
            <td align="center" bgcolor="#D78AF2"><input name="net_hanging_weight" type="text" id="net_hanging_weight" value="<?=$tot_hanging_weight;?>"  style="width:100px; height:25px; float:none"  readonly="" />   </td>
            <td align="center" bgcolor="#D78AF2">&nbsp;</td>
            <td align="center" bgcolor="#D78AF2">
			<input name="net_final_weight" type="text" id="net_final_weight" value="<?=$tot_final_weight;?>"  style="width:100px; height:25px; float:none"  readonly="" />			</td>
            <td align="center" bgcolor="#D78AF2">&nbsp;</td>
		  </tr>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> <br />
  

  
  
  
  
	
	<br />
  

<table width="100%" border="0">



<tr>

<td align="center">&nbsp; </td>

<td align="center">
<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/>
<input name="confirm" type="submit" class="btn1" value="CONFIRM CHALLAN" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

</table>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");


?>