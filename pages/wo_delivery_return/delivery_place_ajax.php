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

  
 <div class="row">
	
	
	<div class="col-md-2"><strong>Delivery Address:</strong></div>
	<div class="col-md-4">
	<input style="width:200px; margin-left: 0px;"  readonly="" name="delivery_address" type="text" id="delivery_address" value="<?=$dealer_all->address_e;?>"/>
	</div>
 </div> 
 

 
		 