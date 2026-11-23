<?php


// $tst = 'omar';

session_start();


require_once "../../../assets/template/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


 $str = $_POST['data'];


$data=explode('##',$str);


   $item_id=$data[0];
   $do_no=$data[1];
  
  
 $item_all= find_all_field('item_info','','item_id="'.$item_id.'"');

 $do_sql='SELECT  * FROM sale_do_master WHERE do_no="'.$do_no.'" ';
 $do_data = find_all_field_sql($do_sql);
 
 $stock_in_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ');
  $stock_in_ctn = $stock_in_pcs/$item_all->pack_size;
 
//$price_sql='SELECT  * FROM sales_price_warehouse WHERE item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ';
//$price_data = find_all_field_sql($price_sql);

?>


<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
<tr bgcolor="#CCCCCC">
	 
	 <td width="15%">
	 <input name="unit_name" type="hidden" class="input3"  value="<?=$item_all->unit_name;?>" id="unit_name" style="width:90%; height:30px;" />
	 </td>
</tr>
</table>






