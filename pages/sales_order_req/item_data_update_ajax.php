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
										  <th width="56%">Description</th>
											<th width="6%">Size</th>
											<th width="12%">Model</th>
											<th width="6%">Part</th>
											<th width="6%">Brand</th>
											<th width="10%"><strong>Section</strong></th>
											<th width="4%">Unit</th>
										</tr>
											<tr>
<td><input name="item_name" type="text" class="input3" autocomplete="off"  value="<?=$item_all->item_name;?>" id="item_name" style="width:100%; height:30px;" /></td>										
<td><input name="size" type="text" class="input3" autocomplete="off"  value="<?=$item_all->size;?>" id="size" style="width:80px; height:30px;"  /></td>
<td><input name="model" type="text" class="input3" autocomplete="off"  value="<?=$item_all->model;?>" id="model" style="width:80px; height:30px;"  /></td>
<td><input name="part_no" type="text" class="input3" autocomplete="off"  value="<?=$item_all->part_no;?>" id="part_no" style="width:80px; height:30px;"  /></td>
<td><input name="brand" type="text" class="input3"   autocomplete="off"  value="" id="brand" style="width:80px; height:30px;"  /></td>
<td><select name="section_id" id="section_id"  style="width:120px; height:32px;" >
                                      <option></option>
                                      <? foreign_relation('wh_section','id','section_name',$_POST['section_id'],'1');?>
                                    </select></td>
<td><input name="unit_name" type="text" class="input3" autocomplete="off"  value="<?=$item_all->unit_name;?>" id="unit_name" style="width:50px; height:30px;"  readonly=""/></td>
										</tr>
									</table>



