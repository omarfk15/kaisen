<?php


// $tst = 'omar';

session_start();


require_once "../../../assets/template/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


$data=explode('##',$str);


   $fg_code=$data[0];
   $invoice_no=$data[1];
  
   $invoice_all= find_all_field('purchase_requisition_master','','invoice_no="'.$invoice_no.'"');
 $item_all= find_all_field('item_info','','item_id="'.$fg_code.'"');
 
 $group_id = find_a_field('item_sub_group','group_id','sub_group_id="'.$item_all->sub_group_id.'" ');
 


 $po_sql='SELECT  * FROM purchase_foreign_details WHERE item_id="'.$item_all->item_id.'"  order by id desc';
 $po_data = find_all_field_sql($po_sql);
 
 $in_stock = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$invoice_all->warehouse_id.'" ');
  //$stock_in_ctn = $stock_in_pcs/$item_all->pack_size;
 
//$price_sql='SELECT  * FROM sales_price_warehouse WHERE item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ';
//$price_data = find_all_field_sql($price_sql);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>

	<th>Item Name</th>
	<th>Unit</th>
	<th>Stock</th>
	<th>Item Type</th>
	 <? if($group_id==200000000) {?>
	<th>Count</th>
	  <? }?>
</tr>
	  <tr>
	  
	   <td width="40%">
	   <input name="last_po_no" type="hidden" class="input3"  value="<?=$po_data->invoice_no;?>" id="last_po_no" style="width:90%; height:30px;"  readonly="" />
	   <input name="last_po_id" type="hidden" class="input3"  value="<?=$po_data->id;?>" id="last_po_id" style="width:90%; height:30px;"  readonly="" />
	 
	 <input name="item_id" type="hidden" class="input3"  value="<?=$item_all->item_id;?>" id="item_id" style="width:90%; height:30px;"  readonly="" />
	 
	 <input name="item_name" type="text" class="input3"  value="<?=$item_all->item_name;?>" id="item_name" style="width:80%; height:30px;"  readonly="" />
	 
	 </td>
	 
	 <td width="10%">
	 <input name="unit_name" type="text" class="input3"  value="<?=$item_all->unit_name;?>" id="unit_name" style="width:90%; height:30px;"  readonly=""/>
	 </td>
	 <td width="10%">
	 <input name="in_stock" type="text" class="input3"  value="<?=$in_stock;?>" id="in_stock" style="width:90%; height:30px;"  readonly=""/>
	 </td>
	 <td width="30%">
	  <select name="item_type" id="item_type"  style="width:90%; height:32px;" >
        <option value=""></option>

		<? foreign_relation('item_type','id','item_type',$_POST['item_type'],'group_id="'.$group_id.'"');?>
      </select>
	 </td>
	 
	 <td width="20%">
	 <? if($group_id==200000000) {?>
	  <select name="count_type" id="count_type"  style="width:90%; height:32px;" >
        <option value=""></option>

		<? foreign_relation('count_type','id','count',$_POST['count_type'],'1');?>
      </select>
	  <? }?>
	 </td>
	 
	 </tr>
	 
	 </table>



