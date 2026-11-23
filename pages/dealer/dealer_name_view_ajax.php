<?php
session_start();
require_once "../../../assets/template/layout.top.php";

@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);

     $dealer_name_e=$data[0];
	// $year=$data[1];
	 $find_dealer_code=find_a_field('dealer_info','dealer_code','dealer_name_e="'.$dealer_name_e.'" ');
?>


<? if($find_dealer_code>0) {?>
<span style="font-size:12px; color:#FF0000; font-weight:700;">Duplicate</span>
<? }?> 
					

