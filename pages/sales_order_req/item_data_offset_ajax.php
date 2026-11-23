<?php


// $tst = 'omar';

session_start();


require_once "../../../assets/template/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


$data=explode('##',$str);


    $item_id=$data[0];
 //  $invoice_no=$data[1];
  
  
 $item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
 
 

?>


	 
	 
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px;">
										<tr>
										  <th width="67%">Description</th>
											<th colspan="3"><div align="center">Size</div></th>
											<th width="4%">M.Unit</th>
											<th width="4%">GSM</th>
											<th width="8%">Brand</th>
											<th width="5%">Unit</th>
										</tr>
											<tr>
											  <td><input name="item_name" type="text" class="input3"   autocomplete="off"  value="<?=$item_all->item_name;?>" id="item_name" style="width:94%; height:30px;"  /></td>
											
											<td width="4%"><input name="L" type="text" class="input3"   autocomplete="off"  value="" id="L" style="width:50px; height:30px;"  /></td>
										    <td width="4%"><input name="W" type="text" class="input3"   autocomplete="off"  value="" id="W" style="width:50px; height:30px;"  /></td>
										    <td width="4%">
<input name="thickness" type="text" class="input3"   autocomplete="off"  value="" id="thickness" style="width:50px; height:30px;" /></td>
										    <td>
											
<select name="measurement_unit" id="measurement_unit"  style="width:60px; height:32px;" >
<option></option>
		<? foreign_relation('measurement_unit','unit_name','unit_name',$_POST['measurement_unit'],'1 ');?>
      </select>	
											</td>
										    <td>
											<input name="gsm" type="text" class="input3"   autocomplete="off"  value="" id="gsm" style="width:50px; height:30px;"  /></td>
										    <td>
											<select name="brand" id="brand"  style="width:100px; height:32px;" >

<option></option>
		<? foreign_relation('wh_brand','id','brand_name',$_POST['brand'],'1 ');?>
      </select>											</td>
										    <td>					
	<select name="unit_name" id="unit_name"  style="width:60px; height:32px;"  required>

<option></option>
		<? foreign_relation('unit_management','unit_name','unit_name',$item_all->unit_name,'1 ');?>
      </select>	
											
											</td>
										</tr>
									</table>



