<?php


session_start();


require_once "../../../assets/template/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


  $str = $_POST['data'];


 $data=explode('##',$str);
 

   $delivery_place=$data[0];
   

   
   $dealer_all = find_all_field('dealer_info','',"dealer_code=".$delivery_place);

?>

 
	<input style="width:90%; margin-left: 0px;"  name="delivery_address" type="text" id="delivery_address" value="<?=$dealer_all->shipping_address;?>"/>
	
 

 
		 