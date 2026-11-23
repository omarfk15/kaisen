<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";



$title='Delivery Challan Create';

//do_calander('#so_date','-10','10');

do_calander('#so_date','0','10');
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



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['status']='CHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);



		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Order Returned.';

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
mysql_query($sql_del_dt);

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

		$query = mysql_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysql_fetch_object($query))

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
				
				
				
				 $ins_sql = 'INSERT INTO delivery_chalan_details (tr_no, sales_type, order_no, item_name, poly_category, do_no, do_date, job_no, delivery_date, cbm_no, group_for, dealer_code, buyer_code, merchandizer_code, destination, delivery_place, delivery_place_name, delivery_address, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, flap, gusset, micron, yds, item_id, formula_id, formula_cal, sqm_rate, sqm, additional_info, additional_charge, final_price, unit_price, total_unit, total_amt, dzn_unit_price, dzn_total_unit, dzn_total_amt, pack_size, pack_unit, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_by, entry_at, others_info, count_id)
  
  VALUES("'.$get_tr_no.'", "'.$data->sales_type.'", "'.$order_no.'", "'.$item_name.'", "'.$data->poly_category.'", "'.$data->do_no.'", "'.$data->do_date.'", "'.$data->job_no.'", "'.$data->delivery_date.'", "'.$data->cbm_no.'", "'.$data->group_for.'", "'.$data->dealer_code.'", "'.$data->buyer_code.'", "'.$data->merchandizer_code.'", "'.$data->destination.'", "'.$data->delivery_place.'", "'.$data->delivery_place_name.'", "'.$data->delivery_address.'", "'.$data->unit_name.'", "'.$data->measurement_unit.'", "'.$data->ply.'", "'.$data->paper_combination_id.'", "'.$data->paper_combination.'", "'.$data->L_cm.'", "'.$data->W_cm.'", "'.$data->H_cm.'", "'.$data->WL.'", "'.$data->WW.'", "'.$data->flap.'", "'.$data->gusset.'", "'.$data->micron.'", "'.$data->yds.'", "'.$data->item_id.'", "'.$data->formula_id.'", "'.$data->formula_cal.'", "'.$data->sqm_rate.'", "'.$data->sqm.'", "'.$data->additional_info.'", "'.$data->additional_charge.'", "'.$data->final_price.'", "'.$rate.'", "'.$qty.'", "'.$amount.'", "'.$data->dzn_unit_price.'", "'.$data->dzn_total_unit.'", "'.$data->dzn_total_amt.'", "'.$data->pack_size.'", "'.$pack_unit.'", "'.$data->style_no.'", "'.$data->po_no.'", "'.$data->referance.'", "'.$data->sku_no.'", "'.$data->printing_info.'", "'.$data->color.'", "'.$data->pack_type.'", "'.$data->size.'", "'.$data->depot_id.'", "'.$status.'", "'.$entry_by.'", "'.$entry_at.'", "'.$others_info.'", "'.$data->count_id.'")';

mysql_query($ins_sql);



}

}


//$del_iou = 'delete from journal_iou_cash_receive where  id="'.$del_iou_id.'"';
//mysqli_query($conn,$del_iou);

header("location:".$page."");


?>

<?php /*?><script language="javascript">
window.location.href = "21_voucher.php?request_no=<?=$jv_no?>";
</script><?php */?>

<?php

}







if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

	
		
		$group_for = $_POST['group_for'];

		$ch_date=$_POST['so_date'];
		$customer_po_no=$_POST['customer_po_no'];
		$buyer_referance=$_POST['buyer_referance'];
		
		$delivery_place=$_POST['delivery_place'];
		$delivery_place_name=$_POST['delivery_place_name'];
		$delivery_address=$_POST['delivery_address'];
		
		$vehicle_type=$_POST['vehicle_type'];
		$vehicle_id=$_POST['vehicle_id'];
		$vehicle_no=find_a_field('vehicle_registration','registration_no','vehicle_id="'.$vehicle_id.'"');
		
		$driver_id=$_POST['driver_id'];
		$driver_mobile=$_POST['driver_mobile'];


		$delivery_man=$_POST['delivery_man'];
		$delivery_man_mobile=$_POST['delivery_man_mobile'];
		
		$prepared_by=$_POST['prepared_by'];
		$authorized_by=$_POST['authorized_by'];
		$manual_chalan=$_POST['manual_chalan'];

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		
		$YR = date('Y',strtotime($ch_date));
  		$yer = date('y',strtotime($ch_date));
  		$month = date('m',strtotime($ch_date));

  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
   		$cy_id = sprintf("%07d", $ch_cy_id);
   		$chalan_no=''.$yer.''.$cy_id;
		
		$chalan_no_view='CN-'.$ch_cy_id.'/'.$YR;

		
		$get_tr_no=$_POST['get_tr_no'];
		
		$found_tr_no=find_a_field('sale_do_chalan','tr_no','tr_no="'.$get_tr_no.'"');
		
		
		if($found_tr_no<1) {
		
		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);

		 $sql = 'select * from delivery_chalan_details where  tr_no = '.$get_tr_no;

		$query = mysql_query($sql);
		
		while($data=mysql_fetch_object($query))

		{
			
			//if(in_array($data->id, $_POST['point']))

			//{
			
				//$qty=$_POST['chalan_'.$data->id];
//				
//				$pack_unit=$_POST['pack_unit_'.$data->id];
//
//				$rate=$_POST['rate_'.$data->id];
//
//				$item_id =$_POST['item_id_'.$data->id];
//				
//				$item_name =$_POST['item_name_'.$data->id];
				////$pack_size =$_POST['pack_size_'.$data->id];
				////$pack_unit=$qty/$pack_size;
				
				//$pack_unit =$_POST['pack_size_'.$data->id];
//				$pack_size=$qty/$pack_unit;
//				
//
//				$amount = ($qty*$rate); 
//				
//				$usd_amt=$qty*$data->usd_price;
//				
//				$others_info =$_POST['others_info_'.$data->id];
 


   $so_invoice = 'INSERT INTO sale_do_chalan (year, ch_id,  chalan_no,  chalan_no_view, gate_pass,  chalan_date, order_no, item_name, bundle_issue, do_no, do_date, job_no,
  delivery_date, cbm_no, group_for, dealer_code, buyer_code, merchandizer_code, destination, delivery_place, customer_po_no, unit_name, measurement_unit,
   ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, item_id, formula_id, formula_cal, sqm_rate, sqm, additional_info, 
   additional_charge, final_price, unit_price, total_unit, total_amt, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_by, entry_at, remarks, 
   vehicle_type,vehicle_id,vehicle_no,driver_name,driver_mobile,delivery_man,delivery_man_mobile,prepared_by,authorized_by, delivery_address, pack_unit,  pack_size, others_info, driver_id, delivery_place_name, buyer_referance, manual_chalan, tr_no, tr_id, count_id)
  
  VALUES("'.$YR.'", "'.$ch_cy_id.'", "'.$chalan_no.'",  "'.$chalan_no_view.'",  "'.$chalan_no.'",  "'.$ch_date.'", "'.$data->order_no.'", "'.$data->item_name.'", "'.$data->bundle_issue.'", "'.$data->do_no.'", "'.$data->do_date.'", "'.$data->job_no.'", 
   "'.$data->delivery_date.'", "'.$data->cbm_no.'", "'.$data->group_for.'" , "'.$data->dealer_code.'",  "'.$data->buyer_code.'",  "'.$data->merchandizer_code.'",
    "'.$data->destination.'", "'.$delivery_place.'", "'.$customer_po_no.'",  "'.$data->unit_name.'",
    "'.$data->measurement_unit.'", "'.$data->ply.'", "'.$data->paper_combination_id.'", "'.$data->paper_combination.'", 
  "'.$data->L_cm.'","'.$data->W_cm.'","'.$data->H_cm.'","'.$data->WL.'",  "'.$data->WW.'", 
   "'.$data->item_id.'", "'.$data->formula_id.'", "'.$data->formula_cal.'", "'.$data->sqm_rate.'", "'.$data->sqm.'", "'.$data->additional_info.'", 
   "'.$data->additional_charge.'",   "'.$data->final_price.'", "'.$data->unit_price.'",  "'.$data->total_unit.'", "'.$data->total_amt.'", 
   "'.$data->style_no.'", "'.$data->po_no.'", "'.$data->referance.'", "'.$data->sku_no.'", "'.$data->printing_info.'", "'.$data->color.'", "'.$data->pack_type.'", 
   "'.$data->size.'",  "'.$data->depot_id.'", "UNCHECKED","'.$entry_by.'", "'.$entry_at.'", "'.$remarks.'" ,   "'.$vehicle_type.'", "'.$vehicle_id.'", "'.$vehicle_no.'", "'.$driver_name.'","'.$driver_mobile.'", "'.$delivery_man.'", "'.$delivery_man_mobile.'", "'.$prepared_by.'", "'.$authorized_by.'" , "'.$delivery_address.'"  , "'.$data->pack_unit.'" , "'.$data->pack_size.'" , "'.$data->others_info.'", "'.$driver_id.'", "'.$delivery_place_name.'", "'.$buyer_referance.'", "'.$manual_chalan.'", "'.$data->tr_no.'", "'.$data->id.'", "'.$data->count_id.'")';

mysql_query($so_invoice);

//}

}


}








		//if($chalan_no>0)
//		{
//		auto_insert_sales_chalan_secoundary($chalan_no);
//		}


?>
<script language="javascript">
window.location.href = "all_wo_challan.php";
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
var pack_size=(document.getElementById('pack_size_'+order_no).value); 
var others_info=(document.getElementById('others_info_'+order_no).value); 

var strURL="delivery_chalan_ajax.php?order_no="+order_no+"&tr_no="+tr_no+"&rate="+rate+"&item_id="+item_id+"&item_name="+item_name+"&chalan="+chalan+"&pack_size="+pack_size+"&others_info="+others_info;

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

    <td width="40%" valign="top"><fieldset style="width:100%;">

    <? $field='do_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">Job  No: </label>

        <input  name="do_no" type="hidden" id="do_no" value="<?=$do_no?>" readonly=""/>
		
		<input  name="job_no" type="text" id="job_no" value="<?=$job_no?>" readonly="" style="width:50%" />

      </div>

    <? $field='do_date';?>

      <div>

        <label style="width:140px;" for="<?=$field?>"> Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly="" style="width:50%"/>

      </div>
	  
	  
	  
	 

      <div>

        <label style="width:140px;" for="<?=$field?>">Buyer Referance:</label>

        <input  name="buyer_referance" type="text" id="buyer_referance" value="<?=$buyer_referance?>" style="width:50%" />

      </div>
	  
	  

      <div>

        <label style="width:140px;" for="<?=$field?>">Customer's PI/ SPO/ ERP/ Job No :</label>

        <input  name="customer_po_no" type="text" id="customer_po_no" value="<?=$customer_po_no?>" style="width:50%" />

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

        <label style="width:120px;" for="<?=$field?>"> Buyer:</label>

         <input  name="buyer_info2" type="text" id="buyer_info2" value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer_code);?>" 
		 style="width:50%" required="required"  readonly=""/>

		<input  name="buyer_code" type="hidden" id="buyer_code" value="<?=$buyer_code?>" required="required"/>

      </div>

      <div></div>
 

      <div>

        <label style="width:120px;" for="<?=$field?>">Merchandiser:</label>

        <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer_code);?>" style="width:50%" required="required"  readonly=""/>

		<input  name="merchandizer_code" type="hidden" id="merchandizer_code" value="<?=$merchandizer_code?>" required="required"/>

      </div>

              

      <div>


      

      </div>

		</fieldset></td>

    <td width="2%">&nbsp;</td>

    <?php /*?><td width="16%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">

	          

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>PR</strong></td>

        </tr>

<?

$sql='select distinct pr_no,rec_date from purchase_receive where po_no='.$po_no.' order by id desc';

$qqq=mysql_query($sql);

while($aaa=mysql_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99"><?=$aaa->rec_date?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="../pr_fg/chalan_view.php?v_no=<?=$aaa->pr_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>

        </tr>

<?

}

?>



      </table></td><?php */?>

  </tr>

  

  <tr>

    <td colspan="5" valign="top">

<?php /*?>	<? if($ex<time()){?>

	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">

      <tr>

        <td align="right" bgcolor="#FF0000"><div align="center" style="text-decoration:blink"><strong>THIS PURCHASE ORDER IS EXPIRED</strong></div></td>

        </tr>

    </table>

    <? }?><?php */?>
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
			  <? $ch_data = find_all_field('sale_do_chalan','','chalan_no='.$_SESSION['chalan_no']);?>
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
              <td width="13%" align="right" bgcolor="#9966FF" style=" padding-left: 5px;  "><strong>Authorized By:</strong></td>
              <td width="21%" bgcolor="#9966FF" style=" padding: 0px 5px 0px 0px; "><strong>
                <select name="authorized_by" required id="authorized_by"  tabindex="7" style="width:100% !important; margin-left: 0px;">
					
                      <? foreign_relation('authorized_by','id','authorized_by',$authorized_by,'status="Active"');?>
                    </select>
              </strong></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Vehicale No:</strong></td>
              <td bgcolor="#b4b4ff"><strong>
               
				
				<select name="vehicle_id" required id="vehicle_id"   style="width:100%!important; margin-left: 0px;">
				<option></option>
					
                      <? foreign_relation('vehicle_registration','vehicle_id','registration_no',$_REQUEST['vehicle_id'],'status="Active"');?>
                    </select>
				
                </strong></td>
              <td align="right" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Driver Name: </strong></td>
              <td bgcolor="#b4b4ff"><strong>
                
				
				<select name="driver_id" required id="driver_id"  tabindex="7" style="width:90%; margin-left: 0px;">
				<option></option>
					
                      <? foreign_relation('driver_registration','driver_id','driver_name',$_REQUEST['driver_id'],'status="Active"');?>
                    </select>
                </strong></td>
              <td align="right" bgcolor="#b4b4ff" style=" padding-left: 5px; "><strong>Delivery Man: </strong></td>
              <td bgcolor="#b4b4ff"  style=" padding: 0px 5px 0px 0px; "><strong>
                <select name="delivery_man"  id="delivery_man"  tabindex="7" style="width:90%; margin-left: 0px;">
				<option></option>
					
                      <? foreign_relation('delivery_man','id','delivery_man',$_REQUEST['delivery_man'],'status="Active"');?>
                    </select>
              </strong></td>
            <!--<td width="1%">&nbsp;</td>-->
            </tr>
			 <tr>
              <td align="left" bgcolor="#9999FF" style=" padding-left: 5px; "><strong>Delivery Place:</strong></td>
              <td bgcolor="#9999FF"><strong>
			  
			  <?   $dealer_data=find_all_field('dealer_info','','dealer_code='.$dealer_code);
			  		$del_place_id=find_a_field('sale_do_details','delivery_place','do_no="'.$$unique.'" and delivery_place>0');
			  ?>
               
			 
					<select name="delivery_place" required id="delivery_place"  tabindex="7" style="width:100%; margin-left: 0px;"
					onchange="getData2('delivery_place_ajax.php', 'delivery_place_filter', this.value, document.getElementById('delivery_place').value);" >
					
                      <? foreign_relation('delivery_place_info','id','delivery_place',$del_place_id,'dealer_group="'.$dealer_data->dealer_group.'"');?>
                    </select>
				
				
                </strong></td>
             <td colspan="2" align="left" bgcolor="#9999FF" style=" padding-left: 5px; "><span id="delivery_place_filter"> 
			 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size: 14px;font-weight: bold;">
			 	<tr align="right"><td width="36%"><strong>Delivery Address:</strong></td>
				<td width="64%"> 
			
		<input style="width:100% !important; margin-left: 4px;"   name="delivery_place_name" type="hidden" id="delivery_place_name" value="<?=$dealer_data->dealer_name_e;?>" readonly=""/>
		<input style="width: 100% !important; margin-left: 4px;"  name="delivery_address" type="text" id="delivery_address" readonly="" value="<?=$dealer_data->address_e;?>"/>
		</td></tr>
			 </table>
			 
			 
			 
			 </span></td>
			 <td align="right" bgcolor="#9999FF" style=" padding-left: 5px; "><strong>Manual Challan: </strong></td>
                           <td align="left" bgcolor="#9999FF" style=" padding-left: 5px; ">
						   <input style="width: 100% !important; margin-left: 4px;"  name="manual_chalan" type="text" id="manual_chalan"  value=""/>
						   </td>
			 </tr>
           
          </table></td>
      </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){


		 $sql = "select order_no,  sum(total_unit) as ch_sum_qty from sale_do_chalan where do_no='".$$unique."' group by order_no";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $ch_sum_qty[$info->order_no]=$info->ch_sum_qty;
		}
		
		$sql = "select order_no,  sum(total_unit) as pr_sum_qty from production_receive_detail where do_no='".$$unique."' group by order_no";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $pr_sum_qty[$info->order_no]=$info->pr_sum_qty;
		}
		
		
		$sql = "select order_no,  sum(total_unit) as dl_sum_qty, pack_unit, others_info from delivery_chalan_details where tr_no='".$ch_tr_no."' group by order_no";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $dl_sum_qty[$info->order_no]=$info->dl_sum_qty;
		 $pack_unit[$info->order_no]=$info->pack_unit;
		 $others_info[$info->order_no]=$info->others_info;
		}
		
		
		$sql = "select id, count as count_type from count_type where 1 group by id";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $count_type[$info->id]=$info->count_type;
		}
		
		$sql = "select id, poly_type_name from poly_category where 1 group by id";
		 $query = mysql_query($sql);
		 while($info=mysql_fetch_object($query)){
  		 $poly_type_name[$info->id]=$info->poly_type_name;
		}
		
		

   $sql='select a.id,  a.item_id,  a.unit_price,   b.item_name,  a.unit_name, a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit, a.count_id,
     a.total_unit as qty , a.delivery_place, a.delivery_date, a.style_no, a.po_no, a.destination, a.referance, a.sku_no, a.pack_type, a.item_color, a.color, a.size,a.shade,
	  b.pack_size, a.poly_category from sale_do_details a,item_info b, item_sub_group s
	   where b.item_id=a.item_id and b.sub_group_id=s.sub_group_id and  a.do_no="'.$$unique.'" 
	  order by a.item_id, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit';

$res=mysql_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="1%">SL</th>

            <th width="10%">Item_Name </th>

            <th width="5%">Poly Category </th>
            <th width="6%"><strong>Style No</strong></th>
            <th width="3%"><strong>PO No</strong></th>
            <th width="5%">Destination</th>
            <th width="2%"><strong>SKU</strong></th>
            <th width="2%">Item Color </th>
            <th width="3%"><strong>Color</strong></th>
            <th width="2%"><strong>Size</strong></th>
            <th bgcolor="#FFFFFF">Shade</th>
            <th bgcolor="#FFFFFF">Count</th>

            <th bgcolor="#FFFFFF">Measurement</th>
            <th bgcolor="#FFFFFF">UOM</th>
            <th bgcolor="#FF99FF">WO Qty </th>

            <th bgcolor="#009900">Production Qty </th>
            <th bgcolor="#009900">Challan Qty  </th>

            <th bgcolor="#FFFF00">Pending </th>

            <th bgcolor="#F57E22">Challan Issue </th>
            <th bgcolor="#D78AF2">Bundle</th>
            <th bgcolor="#D78AF2">Others Info </th>
            <th bgcolor="#D78AF2">
			
			<button type="submit" class="btn btn-light btn-sm" name="add_all_data" id="add_all_data" style="background:#00FF00; color:#000000; width:60px;" >ADD ALL</button>					</th>
            <th bgcolor="#D78AF2">
			<button type="submit" class="btn btn-light btn-sm" name="del_all_data" id="del_all_data" style="background: #FF0000; color: #000000; width:60px;" >DEL ALL</button>			</th>
          </tr>
          
          

          

          <? while($row=mysql_fetch_object($res)){$bg++?>
		  
	<? if ($row->qty-$ch_sum_qty[$row->id]>0) {?>
          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="tr_no_<?=$row->id?>" id="tr_no_<?=$row->id?>" value="<?=$ch_tr_no?>" />	
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>
            <td><?=$poly_type_name[$row->poly_category]?></td>
            <input name="item_name_<?=$row->id?>" type="hidden" id="item_name_<?=$row->id?>"   value="<?=$row->item_name;?>"  style="width:150px; height:25px; float:none" />
              <td>
			  
		<? 
		  if ($row->style_no!="") {
		  echo $row->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  <? 
		  if ($row->po_no!="") {
		  echo $row->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td><? 
		  if ($row->destination!="") {
		  echo $row->destination;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td>
			  <? 
		  if ($row->sku_no!="") {
		  echo $row->sku_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td><? 
		  if ($row->item_color!="") {
		  echo $row->item_color;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td>
			  
			  <? 
		  if ($row->color!="") {
		  echo $row->color;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  
			   <? 
		  if ($row->size!="") {
		  echo $row->size;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td width="3%" align="center"><?   echo $row->shade; ?></td>
              <td width="3%" align="center"><?=$count_type[$row->count_id];?>                </td>

              <td width="6%" align="center">
			  
			  <?php 
            $get_length=explode(".",$row->L_cm);
            $get_width=explode(".",$row->W_cm);
            $get_height=explode(".",$row->H_cm);
         
            if($get_length[1]>0){
                $fraction_length=".".$get_length[1];
            }
            else{
               $fraction_length='';  
                
            }
              if($get_width[1]>0){
                $fraction_width=".".$get_width[1];
            }
              else{
               $fraction_width='';  
                
            }
               if($get_height[1]>0){
                $fraction_height=".".$get_height[1];
            }
             else{
               $fraction_height='';  
                
            }
            
            
            if($row->L_cm>0){echo $get_length[0].$fraction_length;}
			if($row->L_cm>0 && $row->W_cm>0){echo "X";}
            if($row->W_cm>0){echo "".$get_width[0].$fraction_width;}
            if($row->H_cm>0){echo "X".$get_height[0].$fraction_height;}
            echo " ".$row->measurement_unit;
            ?>			  		  </td>
              <td width="5%" align="center"><?=$row->unit_name?></td>
              <td width="2%" align="center"><?=number_format($row->qty,2);?></td>

              <td width="5%" align="center"><? echo number_format($production_qty = $pr_sum_qty[$row->id],2);?></td>
              <td width="4%" align="center"><? echo number_format($ch_qty = ($ch_sum_qty[$row->id]),2);?> </td>

              <td width="4%" align="center"><? 
			  
			   $pr_ch_pending = $production_qty-$ch_qty;
			  
			  echo number_format($unso_qty=($row->qty-$ch_qty),2);?>

                <input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$pr_ch_pending?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>

              <td width="7%" align="center" bgcolor="#F57E22">
			   <? if($unso_qty>0){$cow++;?>

          <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" 
	  value="<? if($dl_sum_qty[$row->id]>0) {echo $dl_sum_qty[$row->id]; }else{ echo $pr_ch_pending; }?>" style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />
		 
		  
                <? } else echo 'Done';?>			  </td>
              <td width="7%" align="center" bgcolor="#D78AF2">
			  <? if($unso_qty>0){$cow++;?>

                <input name="pack_size_<?=$row->id?>" type="text" id="pack_size_<?=$row->id?>" value="<?=$pack_unit[$row->id]?>"  style="width:80px; height:25px; float:none"  />

                <? } else echo 'Done';?>			  </td>
              <td width="7%" align="center" bgcolor="#D78AF2">
			  <? if($unso_qty>0){$cow++;?>

                <input name="others_info_<?=$row->id?>" type="text" id="others_info_<?=$row->id?>" value="<?=$others_info[$row->id]?>"  style="width:80px; height:25px; float:none"  />

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
        <td width="5%" align="center" bgcolor="#D78AF2"> <div align="center"><span id="divi_del_<?=$row->id?>">
		<? if($dl_sum_qty[$row->id]>0) {?>
	    <input type="button" name="Button" value="Del"  onclick="update_value_delete(<?=$row->id?>)" style="width:60px; font-size:12px; height:30px; 
		background-color: #FF0000; font-weight:700;"/>
		<? }?></span></div>			  </td>
          </tr>

          <? } }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> <br />
  

  
  
  
  
	
	<br />
  

<table width="100%" border="0">

<? if($cow<1){

$vars['status']='COMPLETED';

db_update($table_master, $do_no, $vars, 'do_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="submit" class="btn1" value="CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1" value="CONFIRM CHALLAN" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

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