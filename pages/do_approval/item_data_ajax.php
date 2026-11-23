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
										    <th style="height:30px" width="67%">Description</th>
											<th style="height:30px">Size</th>
											<th style="height:30px" width="4%">Thickness</th>
											<th style="height:30px" width="8%">Mark</th>
											<th style="height:30px" width="5%">Length</th>
										    <th style="height:30px" width="5%">U.Price</th>
										</tr>
											<tr>
											  <td><input name="item_name" type="text" class="input3"   autocomplete="off"  value="<?=$item_all->item_name;?>" id="item_name" style="width:94%; height:30px;" readonly="" />
											  <input name="unit_name" type="hidden" class="input3"   autocomplete="off"  value="<?=$item_all->unit_name;?>" id="unit_name" style="width:80px; height:30px;"  readonly=""  />											  </td>
											
											<td width="4%"><input name="size" type="text" class="input3"   autocomplete="off"  value="<?=$item_all->size;?>" id="size" style="width:100px; height:30px;" readonly=""  /></td>
										    <td>
											<input name="thickness" type="text" class="input3"   autocomplete="off"  value="<?=$item_all->thickness;?>" id="thickness" style="width:50px; height:30px;"  readonly=""  /></td>
										    <td>
											<input name="mark" type="text" class="input3"   autocomplete="off"  value="<?=$item_all->mark;?>" id="mark" style="width:60px; height:30px;"  readonly=""  />											</td>
										    <td><input name="length" type="text" class="input3"   autocomplete="off"  value="<?=$item_all->length;?>" id="length" style="width:50px; height:30px;"  readonly=""  /></td>
									        <td><input name="unit_price" type="text" class="input3"   autocomplete="off"  value="<?=$item_all->d_price;?>" id="unit_price" style="width:60px; height:30px;" onkeyup="count()" /></td>
										</tr>
									</table>



