<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";



$title='Delivery Challan Create';

//do_calander('#so_date','-10','10');

do_calander('#so_date','-100','10');
create_combobox('vehicle_id');
create_combobox('driver_id');
create_combobox('delivery_man');
//do_calander('#so_date');



$table_master='sale_do_master';

$table_details='sale_do_details';

 $unique='do_no';

$ch_tr_no=$_REQUEST['tr_no'];




if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];



if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

 $$unique = $_SESSION[$unique];







if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:i:s');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';
		
		echo '<script>window.location.replace("select_unfinished_do.php")</script>';

}







if(isset($_POST['del_all_data']))

{

 $get_do_no=$_REQUEST['do_no'];
 $get_tr_no=$_REQUEST['tr_no'];
 
 $vehicle_id=$_REQUEST['vehicle_id'];
 $driver_id=$_REQUEST['driver_id'];
 $delivery_man=$_REQUEST['delivery_man'];

$page='delivery_challan_from_wo.php?do_no='.$get_do_no.'&tr_no='.$get_tr_no.'&vehicle_id='.$vehicle_id.'&driver_id='.$driver_id.'&delivery_man='.$delivery_man;

$status='MANUAL';
$entry_by = $_SESSION['user']['id'];
$entry_at = $now=date('Y-m-d H:i:s');


 $sql_del_dt = 'delete from delivery_chalan_details where tr_no="'.$get_tr_no.'" ';
db_query($sql_del_dt);

header("location:".$page."");


?>

<!--<script language="javascript">
window.location.href = "delivery_challan_from_wo.php?do_no=<?=$get_do_no?>&tr_no=<?=$get_tr_no?>";
</script>-->

<?php

}




if(isset($_POST['add_all_data']))

{

 $get_do_no=$_REQUEST['do_no'];
 $get_tr_no=$_REQUEST['tr_no'];
 
 $vehicle_id=$_REQUEST['vehicle_id'];
 $driver_id=$_REQUEST['driver_id'];
 $delivery_man=$_REQUEST['delivery_man'];

//$ms_sql="SELECT * FROM journal_master  WHERE jv_no='".$request_no."'";
//$ms_data = find_all_field($ms_sql);


$page='delivery_challan_from_wo.php?do_no='.$get_do_no.'&tr_no='.$get_tr_no.'&vehicle_id='.$vehicle_id.'&driver_id='.$driver_id.'&delivery_man='.$delivery_man;

$status='MANUAL';
$entry_by = $_SESSION['user']['id'];
$entry_at = $now=date('Y-m-d H:i:s');

  $sql = 'select * from sale_do_details where  do_no = '.$get_do_no;

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{
	
	

			if($_POST['chalan_'.$data->id]>0)
			//if(in_array($data->id, $_POST['point']))

			{
				
				$order_no=$data->id;
				
				$qty=$_POST['chalan_'.$data->id];
				
				$pack_unit=$_POST['pack_unit_'.$data->id];

				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];
				
				$item_name =$_POST['item_name_'.$data->id];
				//$pack_size =$_POST['pack_size_'.$data->id];
				//$pack_unit=$qty/$pack_size;
				
				$pack_unit =$_POST['pack_size_'.$data->id];
				$pack_size=$qty/$pack_unit;
				

				$amount = ($qty*$rate); 
				
				$usd_amt=$qty*$data->usd_price;
				
				$others_info =$_POST['others_info_'.$data->id];
				
				
				
				 $ins_sql = 'INSERT INTO delivery_chalan_details (tr_no, sales_type, order_no, item_name, poly_category, do_no, do_date, job_no, delivery_date, cbm_no, group_for, dealer_code, buyer_code, merchandizer_code, destination, delivery_place, delivery_place_name, delivery_address, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, flap, gusset, micron, yds, item_id, formula_id, formula_cal, sqm_rate, sqm, additional_info, additional_charge, final_price, unit_price, total_unit, total_amt, dzn_unit_price, dzn_total_unit, dzn_total_amt, pack_size, pack_unit, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_by, entry_at, others_info)
  
  VALUES("'.$get_tr_no.'", "'.$data->sales_type.'", "'.$order_no.'", "'.$item_name.'", "'.$data->poly_category.'", "'.$data->do_no.'", "'.$data->do_date.'", "'.$data->job_no.'", "'.$data->delivery_date.'", "'.$data->cbm_no.'", "'.$data->group_for.'", "'.$data->dealer_code.'", "'.$data->buyer_code.'", "'.$data->merchandizer_code.'", "'.$data->destination.'", "'.$data->delivery_place.'", "'.$data->delivery_place_name.'", "'.$data->delivery_address.'", "'.$data->unit_name.'", "'.$data->measurement_unit.'", "'.$data->ply.'", "'.$data->paper_combination_id.'", "'.$data->paper_combination.'", "'.$data->L_cm.'", "'.$data->W_cm.'", "'.$data->H_cm.'", "'.$data->WL.'", "'.$data->WW.'", "'.$data->flap.'", "'.$data->gusset.'", "'.$data->micron.'", "'.$data->yds.'", "'.$data->item_id.'", "'.$data->formula_id.'", "'.$data->formula_cal.'", "'.$data->sqm_rate.'", "'.$data->sqm.'", "'.$data->additional_info.'", "'.$data->additional_charge.'", "'.$data->final_price.'", "'.$rate.'", "'.$qty.'", "'.$amount.'", "'.$data->dzn_unit_price.'", "'.$data->dzn_total_unit.'", "'.$data->dzn_total_amt.'", "'.$data->pack_size.'", "'.$pack_unit.'", "'.$data->style_no.'", "'.$data->po_no.'", "'.$data->referance.'", "'.$data->sku_no.'", "'.$data->printing_info.'", "'.$data->color.'", "'.$data->pack_type.'", "'.$data->size.'", "'.$data->depot_id.'", "'.$status.'", "'.$entry_by.'", "'.$entry_at.'", "'.$others_info.'")';

db_query($ins_sql);



}

}


//$del_iou = 'delete from journal_iou_cash_receive where  id="'.$del_iou_id.'"';
//db_query($conn,$del_iou);

header("location:".$page."");


?>

<?php /*?><script language="javascript">
window.location.href = "21_voucher.php?request_no=<?=$jv_no?>";
</script><?php */?>

<?php

}







if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

		$status ='CHECKED';
		
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

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		$YR = date('Y',strtotime($ch_date));
  		$year = date('y',strtotime($ch_date));
  		$month = date('m',strtotime($ch_date));
		$month_name = date('M',strtotime($ch_date));

  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'" ')+1;
   		$cy_id = sprintf("%06d", $ch_cy_id);
   		$chalan_no=''.$YR.''.$cy_id;
		$chalan_no_view='KMI/CH-'.$month_name.' '.$year.'/'.$ch_cy_id;
		$gatepass_no='KMI/GPN-'.$month_name.' '.$year.'/'.$ch_cy_id;
		$invoice_no='KMI/INV-'.$month_name.' '.$year.'/'.$ch_cy_id;
		
		$get_tr_no=$_POST['get_tr_no'];
		
		$found_tr_no=find_a_field('sale_do_chalan','tr_no','tr_no="'.$get_tr_no.'"');

		

		if($found_tr_no<1) {
		
		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);

		$sql = 'select * from delivery_chalan_details where  tr_no = '.$get_tr_no;

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{

   $so_invoice = 'INSERT INTO sale_do_chalan (tr_no, tr_id, year, ch_id, chalan_no, chalan_no_view, chalan_date, gatepass_no, invoice_no, order_no, do_no, job_no, do_date, size, mark, length, thickness, item_id, dealer_code, delivery_place, dealer_address, marketing_person, unit_price, total_unit_pcs, per_pcs_weight, total_unit, total_amt, depot_id, group_for, prepared_by, authorized_by, vehicle_no, driver_name, driver_mobile, receiver_name, receiver_mobile, delivery_man, delivery_man_mobile, entry_by, entry_at, status, hanging_weight)
  
  VALUES("'.$get_tr_no.'", "'.$data->id.'", "'.$YR.'", "'.$ch_cy_id.'", "'.$chalan_no.'", "'.$chalan_no_view.'", "'.$ch_date.'", "'.$gatepass_no.'", "'.$invoice_no.'", "'.$data->order_no.'", "'.$data->do_no.'", "'.$data->job_no.'", "'.$data->do_date.'", "'.$data->size.'", "'.$data->mark.'", "'.$data->length.'", "'.$data->thickness.'", "'.$data->item_id.'", "'.$data->dealer_code.'", "'.$delivery_place.'", "'.$dealer_address.'", "'.$data->marketing_person.'", "'.$data->unit_price.'", "'.$data->total_unit_pcs.'", "'.$data->per_pcs_weight.'", "'.$data->total_unit.'", "'.$data->total_amt.'", "'.$data->depot_id.'", "'.$data->group_for.'", "'.$prepared_by.'", "'.$authorized_by.'", "'.$vehicle_no.'", "'.$driver_name.'", "'.$driver_mobile.'", "'.$receiver_name.'", "'.$receiver_mobile.'", "'.$delivery_man.'", "'.$delivery_man_mobile.'", "'.$entry_by.'", "'.$entry_at.'", "'.$status.'", "'.$data->total_unit.'")';

db_query($so_invoice);





//}
}

}



		//if($chalan_no>0)
//		{
//		auto_insert_sales_chalan_secoundary($chalan_no);
//		}


?>
<script language="javascript">
window.location.href = "all_do_challan.php";
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
// 		while (list($key, $value)=each($data))
// 		{ $$key=$value;}
foreach ($data as $key => $value) {
    $$key = $value;
}
		

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
              <td width="11%" align="left" bgcolor="#9966FF" style=" padding-left: 5px; "><strong>Delivery Date:
			  <? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$_SESSION['chalan_no']);
			   $dealer_data = find_all_field('dealer_info','','dealer_code='.$dealer_code);
			  ?>
			  </strong></td>
              <td width="21%" align="left" bgcolor="#9966FF"><strong>
			  <input type="hidden" name="get_tr_no" id="get_tr_no" value="<?=$ch_tr_no?>" />
			  <input style="width:100% !important; margin-left: 0px;"  name="so_date" type="text" id="so_date" required="required" value="<?=($ch_data->chalan_date!='')?$ch_data->chalan_date:date('Y-m-d')?>" readonly=""/>
              </strong></td>
              <td width="13%" align="right" bgcolor="#9966FF" style=" padding-left: 5px; "><strong>Prepared By:</strong></td>
              <td width="21%" align="left" bgcolor="#9966FF"><strong>
                <select name="prepared_by" required id="prepared_by"  tabindex="7" style="width:100% !important; margin-left: 0px;">
					
                      <? foreign_relation('prepared_by','id','prepared_by',$prepared_by,'status="Active"');?>
                    </select>
              </strong></td>
              <td width="13%" align="right" bgcolor="#9966FF" style=" padding-left: 5px; "><strong>Authorized By:</strong></td>
              <td width="21%" bgcolor="#9966FF" style=" padding: 0px 5px 0px 0px; "><strong>
                <select name="authorized_by" required id="authorized_by"  tabindex="7" style="width:100% !important; margin-left: 0px;">
					
                      <? foreign_relation('authorized_by','id','authorized_by',$authorized_by,'status="Active"');?>
                    </select>
              </strong></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Vehicale No:</strong></td>
              <td bgcolor="#b4b4ff"><strong>
               
				<input style="width:100% !important; margin-left: 4px;"  name="vehicle_no" type="text" id="vehicle_no" value="" required/>
				
				
                </strong></td>
              <td align="right" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Driver Name: </strong></td>
              <td bgcolor="#b4b4ff"><strong>
                
				<input style="width:100% !important; margin-left: 4px;"  name="driver_name" type="text" id="driver_name" value="" required/>
				
                </strong></td>
              <td align="right" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Driver Mobile: </strong></td>
              <td bgcolor="#b4b4ff"  style=" padding: 0px 5px 0px 0px; "><strong>
                <input style="width:100% !important; margin-left: 4px;"  name="driver_mobile" type="text" id="driver_mobile" value="" required/>
              </strong></td>
            <!--<td width="1%">&nbsp;</td>-->
            </tr>
			 <tr>
              <td align="left" bgcolor="#9999FF" style=" padding-left: 5px; "><strong>Deli. Address: </strong></td>
              <td bgcolor="#9999FF"><strong>
				
	 <input style="width:100% !important; margin-left: 4px;"  name="delivery_place" readonly="" type="hidden" id="delivery_place" value="<?=$dealer_code;?>"/>
				 
	 <input style="width:100% !important; margin-left: 4px;"  name="dealer_address" readonly="" type="hidden" id="dealer_address" value="<?=$dealer_address;?>"/>
		
<input style="width: 100% !important; margin-left: 4px;"  name="delivery_address" type="text" id="delivery_address" readonly="" value="<?=$delivery_address;?>"/>
				
                </strong></td>
             <td align="right" bgcolor="#9999FF" style=" padding-left: 5px; "><strong>Receiver Name:</strong></td>
			 <td align="left" bgcolor="#9999FF" style=" padding-left: 5px; ">
 <input style="width:100% !important; margin-left: 4px;"  name="receiver_name"  type="text" id="receiver_name" value="<?=$dealer_data->contact_person_name;?>" required />
		
			 </td>
			 <td align="right" bgcolor="#9999FF" style=" padding-left: 5px; "><strong>Receiver Mobile:</strong></td>
                           <td align="left" bgcolor="#9999FF" style=" padding-left: 5px; ">
<input style="width:100% !important; margin-left: 4px;"  name="receiver_mobile"  type="text" id="receiver_mobile" value="<?=$dealer_data->contact_person_mobile;?>" required />						   </td>
			 </tr>
           
          </table></td>
      </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){


		 $sql = "select order_no,  sum(total_unit_pcs) as total_unit_pcs from sale_do_chalan where do_no='".$$unique."' group by order_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $total_unit_pcs[$info->order_no]=$info->total_unit_pcs;
		}
		
		$sql = "select order_no, item_id as dl_item_id, sum(total_unit_pcs) as dl_sum_qty, sum(total_unit) as total_unit from delivery_chalan_details 
		where tr_no='".$ch_tr_no."' group by order_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
		 $dl_item_id[$info->order_no]=$info->dl_item_id;
  		 $dl_sum_qty[$info->order_no]=$info->dl_sum_qty;
		 $total_unit[$info->order_no]=$info->total_unit;
		 
		}
		

   $sql='select a.*, b.item_name, b.finish_goods_code from sale_do_details a,item_info b, item_sub_group s 
   where b.item_id=a.item_id and b.sub_group_id=s.sub_group_id and  a.do_no="'.$$unique.'"  order by  b.sub_group_id, b.item_id';

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="1%">SL</th>

            <th width="12%">Product </th>

            <th width="10%"><strong>Size</strong></th>
            <th width="5%"><strong>Thickness</strong></th>
            <th width="5%"><strong>Mark</strong></th>
            <th bgcolor="#FFFFFF"><strong>Length</strong></th>

            <th bgcolor="#FF99FF" style="white-space:nowrap;"><strong>Qty/Pcs</strong></th>

            <th bgcolor="#FF99FF" style="white-space:nowrap;"><strong>Qty/Kg</strong></th>
            <th bgcolor="#009900" style="white-space:nowrap;">Challan/Pcs  </th>

            <th bgcolor="#FFFF00" style="white-space:nowrap;">Pending/Pcs</th>

            <th bgcolor="#F57E22" style="white-space:nowrap;">Delivery/Pcs </th>
            <th bgcolor="#D78AF2" style="white-space:nowrap;">Delivery/KG</th>
            <th colspan="2" bgcolor="#D78AF2">Action</th>
            </tr>
          
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>
		  
	<? //if ($row->qty-$ch_sum_qty[$row->id]>0) {?>
          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td>
			<?=$row->finish_goods_code.' : '.$row->item_name?>
			<?php /*?><input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	<?php */?>
			
			<? if($dl_item_id[$row->id]>0) {
			$del_item=$dl_item_id[$row->id];
			}else{
			$del_item=$row->item_id;
			}?>
		<select name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>"  style="width:350px; height:32px;" class="js-example-basic-single" >
        <option value=""></option>
		
		<? foreign_relation('item_info i, item_sub_group s','i.item_id','concat(i.finish_goods_code," : ",i.item_name)',$del_item, 
		'i.sub_group_id=s.sub_group_id and i.finish_goods_code>0 and s.group_id=100000000 order by  i.sub_group_id, i.finish_goods_code');?>
      	</select>
			
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	
			<input type="hidden" name="tr_no_<?=$row->id?>" id="tr_no_<?=$row->id?>" value="<?=$ch_tr_no?>" />
			<input name="item_name_<?=$row->id?>" type="hidden" id="item_name_<?=$row->id?>"   value="<?=$row->item_name;?>"  style="width:150px; height:25px; float:none" />			</td>
          
              <td style="white-space: nowrap">
			  
		<?=$row->size?></td>
              <td><span style=" white-space: nowrap;">
                <?=$row->thickness?>
mm</span></td>
              <td><span style=" white-space: nowrap;">
                <?=$row->mark?>
              </span></td>
              <td width="3%" align="center"><span style=" white-space: nowrap;">
                <?=$row->length?>'</span></td>

              <td width="9%" align="center"><?=number_format($row->total_unit_pcs,2);?></td>

              <td width="8%" align="center"><?=number_format($row->total_unit,2); ?></td>
              <td width="8%" align="center"><? echo number_format($ch_qty = ($total_unit_pcs[$row->id]),2);?> </td>

              <td width="10%" align="center">
		<?  echo number_format($unso_qty=($row->total_unit_pcs-$ch_qty),2);?>
        <input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$unso_qty?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>

              <td width="9%" align="center" bgcolor="#F57E22">
			   <? if($unso_qty>0){$cow++;?>

          <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value="<?=$dl_sum_qty[$row->id];?>"  style="width:70px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />
		 
		  
                <? } else echo 'Done';?>			  </td>
              <td width="9%" align="center" bgcolor="#D78AF2">
			  <? if($unso_qty>0){$cow++;?>

                <input name="chalan_kg_<?=$row->id?>" type="text" id="chalan_kg_<?=$row->id?>" value="<?=$total_unit[$row->id]?>"  style="width:70px; height:25px; float:none"  />

                <? } else echo 'Done';?>			  </td>
              <td width="5%" align="center" bgcolor="#D78AF2">
			 <div align="center"><span id="divi_<?=$row->id?>">
	    <? if($dl_sum_qty[$row->id]>0) {?>
	    <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$row->id?>)" style="width:60px; font-size:12px; height:30px; background-color:   
		 #f39c12 ; font-weight:700;"/>
		<? }else {?>
		<input type="button" name="Button" value="ADD"  onclick="update_value(<?=$row->id?>)" style="width:60px; font-size:12px; height:30px; background-color:  #58d68d; font-weight:700;"/>
		<? }?>
	    
	      </span>	      </div>			  </td>
              <td width="6%" align="center" bgcolor="#D78AF2">
			  <div align="center"><span id="divi_del_<?=$row->id?>">
		<? if($dl_sum_qty[$row->id]>0) {?>
	    <input type="button" name="Button" value="Del"  onclick="update_value_delete(<?=$row->id?>)" style="width:60px; font-size:12px; height:30px; 
		background-color: #FF0000; font-weight:700;"/>
		<? }?></span></div>			  </td>
          </tr>

          <? } //}?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> <br />
  

  
  
  
  
	
	<br />
  

<table width="100%" border="0">

<? if($cow<1){

//$vars['status']='COMPLETED';

//db_update($table_master, $do_no, $vars, 'do_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp; </td>

<td align="center">
<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/>
<input name="confirm" type="submit" class="btn1" value="CONFIRM CHALLAN" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");


?>