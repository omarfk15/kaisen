<?php

session_start();

require_once "../../../assets/template/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

   $str = $_POST['data'];

   $data=explode('##',$str);
 
   $delivery_place=$data[0];

   $dealer_all = find_all_field('delivery_place_info','',"id=".$delivery_place);

?>

  
									 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">
											<tr>
												<td width="20%" height="15" align="right"><strong>Delivery Place: </strong></td>
												<td width="30%">
												<input name="delivery_place" type="hidden" id="delivery_place" style="width:90%; height:32px;" value="<?=$dealer_all->id;?>" readonly=""  tabindex="1" />
												<input name="delivery_place_name" type="text" id="delivery_place_name" style="width:90%; height:32px;" value="<?=$dealer_all->delivery_place;?>" readonly="" required tabindex="1" /></td>
												<td width="20%" align="right"><strong> Address: </strong></td>
												<td width="30%"><input name="delivery_address" type="text" id="delivery_address" style="width:90%; height:32px;" value="<?=$dealer_all->address_e;?>" required    tabindex="1" /></td>
											</tr>
										</table>
