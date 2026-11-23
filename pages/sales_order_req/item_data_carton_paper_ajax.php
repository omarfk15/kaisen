<?php


// $tst = 'omar';

session_start();


require_once "../../../assets/template/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


$data=explode('##',$str);


    $item_id=$data[0];
  $invoice_no=$data[1];
  
  
 $item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
 
 
$po_details="SELECT a.*, i.item_name FROM purchase_requisition_details a, item_info i WHERE  a.item_id=i.item_id and a.invoice_no=".$invoice_no."
	 order by id desc limit 1";
	$po_data = find_all_field_sql($po_details);
?>


	 
	 
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px;">
										<tr>
										  <th width="67%">Description</th>
											<th><div align="center">Reel Size</div></th>
											<th width="4%">GSM</th>
											<th width="8%">Brand</th>
											<th width="5%">Unit</th>
										</tr>
											<tr>
											  <td><input name="item_name" type="text" class="input3"   autocomplete="off"  value="<?=$item_all->item_name;?>" id="item_name" style="width:94%; height:30px;"  /></td>
											
											<td width="4%">
											<select name="reel_size" id="reel_size"  style="width:80px; height:32px;" >
<option></option>
		<? foreign_relation('reel_size','reel_size','reel_size',$po_data->reel_size,'1 ');?>
      </select></td>
										    <td>
											<select name="gsm" id="gsm"  style="width:80px; height:32px;" >
<option></option>
		<? foreign_relation('gsm','gsm','gsm',$po_data->gsm,'1 ');?>
      </select></td>
										    <td>
											<select name="brand" id="brand"  style="width:100px; height:32px;" >

<option></option>
		<? foreign_relation('wh_brand','id','brand_name',$po_data->brand,'item_type=1');?>
      </select>											</td>
										    <td>	
														
	<select name="unit_name" id="unit_name"  style="width:60px; height:32px;"  required>

<option></option>
		<? foreign_relation('unit_management','unit_name','unit_name',$po_data->unit_name,'1 ');?>
      </select>											</td>
										</tr>
									</table>



