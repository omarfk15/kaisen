<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);



require_once "../../../assets/template/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no 		= $_REQUEST['v_no'];

$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$pack_unit_count= find_a_field('sale_do_chalan','COUNT(pack_unit)','chalan_no="'.$chalan_no.'" and pack_unit!=""');
$sku_no_count= find_a_field('sale_do_chalan','COUNT(sku_no)','chalan_no="'.$chalan_no.'" and sku_no!=""');
$pack_type_count= find_a_field('sale_do_chalan','COUNT(pack_type)','chalan_no="'.$chalan_no.'" and pack_type!=""');
$color_count= find_a_field('sale_do_chalan','COUNT(color)','chalan_no="'.$chalan_no.'" and color!=""');
$size_count= find_a_field('sale_do_chalan','COUNT(size)','chalan_no="'.$chalan_no.'" and size!=""');
$poly_category= find_a_field('sale_do_chalan','COUNT(poly_category)','chalan_no="'.$chalan_no.'" and poly_category!=""');


$do_no= find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);

$pi_no=find_a_field('pi_details','pi_id','do_no='.$do_no);
$pi_no_view=find_a_field('pi_master','view_pi_no','id='.$pi_no);




$ch_data= find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);

$vehicle_data= find_all_field('vehicle_registration','','vehicle_id='.$ch_data->vehicle_id);
$driver_data= find_all_field('driver_registration','','driver_id='.$ch_data->driver_id);
$delivery_man_data= find_all_field('delivery_man','','id='.$ch_data->delivery_man);


  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.*,b.do_date, b.group_for, b.fsc_claim from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;



$dealer = find_all_field_sql($ssql);
$entry_time=$dealer->do_date;


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;



$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$master->job_no;?> - CH<?=$chalan_no;?></title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";

window.print();
 document.getElementById("pr").style.display="block";

}



</script>
<style type="text/css">

#pr p input{
    width: 60px;
    height: 30px;
    font-size: 15px;
    font-weight: 600;
}

<!--
.header table tr td table tr td table tr td table tr td {
	color: #000;
}




@font-face {
  font-family: 'Andina Demo';
  src: url('Andina Demo.otf'); /* IE9 Compat Modes */

}





/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   color: white;
   text-align: center;
}
}*/
-->
div.page_brack
{
    page-break-after:always;
}

.tabledesign, .tabledesign th, .tabledesign td {
  border: 1px solid black;
  border-collapse: collapse;
}

body {
  font-family: "Metropolis", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #687281;
  text-align: left;
}

</style>
</head>
<body>


	  
<div class="page_brack" >

	  
	  
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">

  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
				  <div id="pr">
					<div align="right"  >
					  <p>
						<input name="button" type="button" onclick="hide();" value="Print" />
					  </p>
					  <nobr>
					  <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
					  </nobr>
					  <nobr>
					  
					  <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
					  </nobr>	    </div>
				  </div>
				  
				  <?php /*?><img  src="../../../images/ypl_report_head.png" width="100%"/><?php */?>
				  <img  src="ypl_report_head.png" width="100%"/>
				  
				  
				  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td>
  
   <hr style="margin:0px; padding:0px;border:0.5px solid;"/>
  <p style="text-align:center; color:#FFF; font-size:18px; color:#687281; font-weight:bold; margin:0px; padding:0px; text-transform:uppercase" >
  <? if($master->sales_type==1){?>
  DELIVERY CHALLAN - Carton
  <? }elseif($master->sales_type==2) {?>
  DELIVERY CHALLAN - Poly
  <? }elseif($master->sales_type==3) {?>
  DELIVERY CHALLAN - Gumtape
  <? }elseif($master->sales_type==4) {?>
   DELIVERY CHALLAN - Offset
   <? }?></p>
  <hr  style="margin:0px; padding:0px;border:0.5px solid;" />
  
  </td></tr>
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:14px; line-height:normal;">


		        <tr>
		          <td width="60%" align="left" valign="middle" style="font-size:20px;"><strong>Customer Name :</strong> 
		            <?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
		          <td width="40%" align="right"><strong><span style="font-size:20px;">Challan No </span> </strong><strong><span style="font-size:20px;">: </span></strong><strong> <span style="font-size:20px;">
				  
				  <?
				  $get_ch_no=explode("CN-",$ch_data->chalan_no_view);
				  echo $get_ch_no[1];
				  ?></span></strong></td>
	              </tr>
		        <tr>
		          <td align="left" valign="top" style="font-size:14px;"><strong>Address :</strong>
		            <?= find_a_field('dealer_info','address_e','dealer_code="'.$master->dealer_code.'"');?></td>
		          <td align="right">
				 <? if($ch_data->manual_chalan!="") {?> <strong><span style="font-size:17px;">Delivery By Manuel Challan </span></strong><strong>: </strong><strong><span style="font-size:17px;"><?=$ch_data->manual_chalan;?></span></strong><br /><? }?>
				  <strong><span style="font-size:20px;">Job No </span></strong><strong>: </strong><strong><span style="font-size:20px;"><?=$master->job_no;?></span></strong></td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle"> <strong>Telephone :</strong> 
		            <?= find_a_field('dealer_info','mobile_no','dealer_code="'.$master->dealer_code.'"');?></td>
		          <td align="right"><strong>Delivery Date </strong><strong>: </strong><strong><?php echo date('d/m/Y',strtotime($ch_data->chalan_date));?></strong></td>
	              </tr>
		        <tr style="font-size:17px;">
		          <td align="left" valign="top" ><strong>Delivery Place :</strong> 
		            <?= $ch_data->delivery_place_name;?></td>
		          <td align="right"><strong>Vehicle No : </strong> 
	                <?=$ch_data->vehicle_no;?></td>
	              </tr>
		        <tr style="font-size:16px;">
		          <td align="left" valign="top" ><strong>Delivery Address :</strong> 
		            <?= $ch_data->delivery_address;?></td>
		          <td align="right"><strong>Driver : </strong>
	                <?=$driver_data->driver_name;?></td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle" ><strong>Buyer </strong>:
		            <?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
		          <td align="right"><strong>Driver Contact :</strong>
		            <?=$driver_data->driver_mobile;?></td>
		          </tr>
		        <tr>
		          <td align="left" valign="middle" ><strong>Buyer Referance :</strong>&nbsp;
				  
				  
				    <? //$ch_data->buyer_referance?>
					<?php
							$text_buyer_referance = $ch_data->buyer_referance;
							// Replace semicolons and commas with spaces
							$text_buyer = str_replace(',', ', ', $text_buyer_referance);
							$text_buyer = str_replace(';', '; ', $text_buyer);
							$text_buyer = str_replace('+', '+ ', $text_buyer);
							$text_buyer = str_replace('&', '& ', $text_buyer);
							$text_buyer = str_replace('/', '/ ', $text_buyer);
							
							// Output the result
							echo $text_buyer;
						?>				  </td>
		          <td align="right"><strong>Delivery Man :</strong>
		            <?=$delivery_man_data->delivery_man;?></td>
		          </tr>
		        <tr>
		          <td align="left" valign="middle" ><strong>Merchandiser :</strong> 
		            <?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
		          <td align="right"><strong>Contact  No :</strong> 
		            <?=$delivery_man_data->mobile;?></td>
		          </tr>
		        <tr>
		          <td align="left" valign="top" ><strong> Customer's PI/ SPO/ ERP/ Job No :</strong>
				  		<? //$ch_data->customer_po_no?>
			  		<?php
							$text_customer_po_no = $ch_data->customer_po_no;
							// Replace semicolons and commas with spaces
							$text_po_no = str_replace(',', ', ', $text_customer_po_no);
							$text_po_no = str_replace(';', '; ', $text_po_no);
							$text_po_no = str_replace('+', '+ ', $text_po_no);
							$text_po_no = str_replace('&', '& ', $text_po_no);
							$text_po_no = str_replace('/', '/ ', $text_po_no);
							
							// Output the result
							echo $text_po_no;
						?>				  </td>
		          <td align="right">Printing Date-Time:
		            <? $print_date=date('Y-m-d H:i:s');  ?>
				    <?=date("d/m/Y",strtotime($print_date)).' '.date("h:i A",strtotime($print_date));?></td>
		          </tr>
				<? if($pi_no>0) {?>
		        <tr style="font-size:14px; color:#0000FF;">
		          <td align="left" valign="top" ><strong> PI No : <?php echo $pi_no_view;?></strong></td>
		          <td align="right">&nbsp;</td>
		          </tr>
				  <? }?>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
		
		
    <tr> <td>&nbsp; </td> </tr>
  
 
  <tr>
    <td>      
      <table width="99%" class="tabledesign" border="1" bordercolor="#687281" cellspacing="0" cellpadding="5"  style="font-size:14px">
        <thead>
        <tr>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Product</strong></td>
		  <? if ($master->sales_type==1) {?>
		   <td align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Type </strong></td>
		   <? }?>
		   <? if ($poly_category>0) {?>
          <td align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Category</strong></td><? }?>
		  <? if ($master->sales_type==3) {?>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Micron</strong></td>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>YDS</strong></td>
          <? }?>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Measurement</strong></td>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO/OD </strong></td>
		  <? if ($color_count>0) {?>
		  <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Gmt Color</strong></td>
		  <? }?>
		   <? if ($size_count>0) {?>
		  <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Gmt Size</strong></td><? }?>
		  <? if ($destination_count>0) {?>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Gmt Country </strong></td>
          <? }?>
		   
		  <? if ($sku_no_count>0) {?>
          <td align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Sku/Set No/CP ID </strong></td>
          <? }?>
		
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Qty </strong></td>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Unit</strong></td>
		  
		  <? if ($pack_unit_count>0) {?>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>
		  <? if($master->sales_type==1) {?>
		  Bundle <? }else{?>
		  Pack
		  <? }?>
		  </strong></td>
		   <? }?>
          <td  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Others Info</strong></td>
        </tr>
		</thead>
        
        <?  
		
		 $sql = "select id, poly_type_name as poly_categ from poly_category where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $poly_categ[$info->id]=$info->poly_categ;
		}
		
		$sql = "select id, ctn_type as ctn_type_view from ctn_type where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $ctn_type_view[$info->id]=$info->ctn_type_view;
		}
		
		$sql = "select id, ctn_type from sale_do_details where do_no='".$do_no."' group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $ctn_type[$info->id]=$info->ctn_type;
		}
		
		  $sqlc = 'select c.order_no, c.item_name as ch_item_name, c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.poly_category, c.micron, c.yds,
		 c.total_unit as bundle_size, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.referance, c.style_no, c.po_no, c.destination,
		 c.sku_no,c.color,c.pack_type,c.size, c.paper_combination, c.L_cm, c.W_cm, c.H_cm, c.flap, c.gusset,
		 (c.pcs_1*c.bundle_1) as qty_1, c.pcs_1, c.bundle_1,  (c.pcs_2*c.bundle_2) as qty_2, c.pcs_2, c.bundle_2,  (c.pcs_3*c.bundle_3) as qty_3, c.pcs_3, c.bundle_3, c.pack_unit, c.others_info
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' and c.total_unit>0 group by c.id, c.total_unit order by  c.item_id,c.L_cm, c.W_cm, c.H_cm, c.measurement_unit, c.style_no  ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:13px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top" style=" white-space: nowrap;">
		  <?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
		  <? if ($master->sales_type==1) {?>
		   <td align="left" valign="top" style=" white-space: nowrap;"><?= $ctn_type_view[$ctn_type[$datac->order_no]];?></td><? }?>
		   <? if ($poly_category>0) {?>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$poly_categ[$datac->poly_category];?></td> <? }?>
		    <? if ($master->sales_type==3) {?>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->micron;?></td>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->yds;?></td>
          <? }?>
          <td align="left" valign="top" style=" white-space: nowrap;">
			
			<?php 
			if($master->sales_type==2){
			
            $get_length=explode(".",$datac->L_cm);
            $get_width=explode(".",$datac->W_cm);
            $get_height=explode(".",$datac->H_cm);
			$get_flap=explode(".",$datac->flap);
			$get_gusset=explode(".",$datac->gusset);
         
            if($get_length[1]>0){
                $fraction_length=".".$get_length[1];
            }
            else{
               $fraction_length='';  
                
            }
              if($get_width[1]>0){
                $fraction_width=".".$get_width[1];
            }
              else{
               $fraction_width='';  
                
            }
               if($get_height[1]>0){
                $fraction_height=".".$get_height[1];
            }
             else{
               $fraction_height='';     
            }
			 if($get_flap[1]>0){
                $fraction_flap=".".$get_flap[1];
            }
             else{
               $fraction_flap='';     
            }
			if($get_gusset[1]>0){
                $fraction_gusset=".".$get_gusset[1];
            }
             else{
               $fraction_gusset='';     
            }
            
            if($datac->L_cm>0){echo "L".$get_length[0].$fraction_length;}
			if($datac->flap>0){echo " + (F-".$get_flap[0].$fraction_flap.")";}
            if($datac->W_cm>0){echo " X W".$get_width[0].$fraction_width;}
			if($datac->gusset>0){echo " (G-".$get_gusset[0].$fraction_gusset." + ".$get_gusset[0].$fraction_gusset.")";}
            echo "".$datac->measurement_unit."<br>".$datac->addi_measurement;
			
			
			}else{
			
			$get_length=explode(".",$datac->L_cm);
            $get_width=explode(".",$datac->W_cm);
            $get_height=explode(".",$datac->H_cm);
			$get_flap=explode(".",$datac->flap);
         
            if($get_length[1]>0){
                $fraction_length=".".$get_length[1];
            }
            else{
               $fraction_length='';  
                
            }
              if($get_width[1]>0){
                $fraction_width=".".$get_width[1];
            }
              else{
               $fraction_width='';  
                
            }
               if($get_height[1]>0){
                $fraction_height=".".$get_height[1];
            }
             else{
               $fraction_height='';  
                
            }
			
          if($get_flap[1]>0){
                $fraction_flap=".".$get_flap[1];
            }
             else{
               $fraction_flap='';  
                
            }  
            
            if($datac->L_cm>0){echo $get_length[0].$fraction_length."X";}
            if($datac->W_cm>0){echo "".$get_width[0].$fraction_width;}
            if($datac->flap>0){echo "X F-".$get_flap[0].$fraction_flap;}
            if($datac->H_cm>0){echo "X".$get_height[0].$fraction_height;}
            echo "".$datac->measurement_unit;
			
			}
            ?>			</td>
          <td align="left" valign="top">
		  <? 
		  if ($datac->style_no!="") {
		  	$text_style = $datac->style_no;
			// Replace semicolons and commas with spaces
			$text_style_no = str_replace(',', ', ', $text_style);
			$text_style_no = str_replace(';', '; ', $text_style_no);
			$text_style_no = str_replace('+', '+ ', $text_style_no);
			$text_style_no = str_replace('&', '& ', $text_style_no);
			$text_style_no = str_replace('/', '/ ', $text_style_no);
			// Output the result
			echo $text_style_no;
			
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
          
		  <td align="left" valign="top">
		   <? 
		  if ($datac->po_no!="") {
			$text_po_no = $datac->po_no;
			// Replace semicolons and commas with spaces
			$text_with_po = str_replace(',', ', ', $text_po_no);
			$text_with_po = str_replace(';', '; ', $text_with_po);
			$text_with_po = str_replace('+', '+ ', $text_with_po);
			$text_with_po = str_replace('&', '& ', $text_with_po);
			$text_with_po = str_replace('/', '/ ', $text_with_po);
			// Output the result
			echo $text_with_po;

		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
		   <? if ($color_count>0) {?>
		   <td align="left" valign="top"><?=$datac->color;?></td><? }?>
		   <? if ($size_count>0) {?>
		   <td align="left" valign="top"><?=$datac->size;?></td><? }?>
		   <? if ($destination_count>0) {?>
          <td align="left" valign="top"><?=$datac->destination;?></td><? }?>
		  
		  <? if ($sku_no_count>0) {?>
          <td align="left" valign="top"><?=$datac->sku_no;?></td><? }?>
		  
		 
		
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit1 +=$datac->total_unit; ?></td>
          <td align="center" valign="top">
		  <? if($master->sales_type==2) {
		  echo 'Pcs';
		  }else{
		  echo $datac->unit_name;
		  }?>		  </td>
		   <? if ($pack_unit_count>0) {?>
          <td align="center" valign="top"><?=$datac->pack_unit; $grand_pack_unit +=$datac->pack_unit; ?></td>
		  <? }?>
          <td align="center" valign="top"><?=$datac->others_info;?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:14px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
		 <? if ($master->sales_type==1) {?><td align="right" valign="middle">&nbsp;</td><? }?>
		 <? if ($poly_category>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		 <? if ($master->sales_type==3) {?>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
        <? }?>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		<? if ($color_count>0) {?>
		 <td align="right" valign="middle">&nbsp;</td><? }?>
		 <? if ($size_count>0) {?>
		 <td align="right" valign="middle">&nbsp;</td><? }?>
		 <? if ($destination_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		
		<? if ($sku_no_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		
		
		
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit1,0) ;?></strong></td>
        <td align="center" valign="middle">&nbsp;</td>
		 <? if ($pack_unit_count>0) {?>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_pack_unit,0) ;?>
        </strong></td><? }?>
        <td align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr style="font-size:14px; font-weight:700;">
          <td colspan="17" align="left" valign="middle">
		  
		  <?  
		$o=0;
		$itm_sql = 'select  s.sub_group_name, i.item_name, i.unit_name, sum(a.total_unit) as net_tot_unit from sale_do_chalan a, item_info i, item_sub_group s 
 		where i.item_id=a.item_id and i.sub_group_id=s.sub_group_id and a.chalan_no='.$chalan_no.' 
		 group by i.item_id order by i.sub_group_id, i.item_id';
			$itm_query=db_query($itm_sql);
			while($itm_data= mysqli_fetch_object($itm_query)){
			$o++;
			if ($o>1) echo ', ';
			echo $itm_data->item_name.'='.$itm_data->net_tot_unit.' Pcs';}?>		  </td>
          </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
   <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:14px">
        
        
        <tr>
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#f2f3f4"><strong>SL</strong></td>
          <td width="38%" align="center" bordercolor="#000000" bgcolor="#f2f3f4"><strong>Product</strong></td>
          <td width="43%" align="center" bordercolor="#000000" bgcolor="#f2f3f4"><strong>Measurement Summary </strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#f2f3f4"><strong>Quantity</strong></td>
          </tr>
        
        <?   $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm, c.flap, c.gusset from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' and c.total_unit>0 group by c.item_id, c.L_cm, c.W_cm, c.H_cm, c.flap, c.gusset, c.measurement_unit 
		order by c.item_id,c.L_cm, c.W_cm,c.H_cm,c.flap, c.gusset, c.measurement_unit  ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:14px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="left" valign="top"><?=$datac->item_name?></td>
          <td align="center" valign="top">
		  
		  <?php 
		  
		  if($master->sales_type==2){
            
			$get_length=explode(".",$datac->L_cm);
            $get_width=explode(".",$datac->W_cm);
            $get_height=explode(".",$datac->H_cm);
			$get_flap=explode(".",$datac->flap);
			$get_gusset=explode(".",$datac->gusset);
         
            if($get_length[1]>0){
                $fraction_length=".".$get_length[1];
            }
            else{
               $fraction_length='';  
                
            }
              if($get_width[1]>0){
                $fraction_width=".".$get_width[1];
            }
              else{
               $fraction_width='';  
                
            }
               if($get_height[1]>0){
                $fraction_height=".".$get_height[1];
            }
             else{
               $fraction_height='';     
            }
			if($get_flap[1]>0){
                $fraction_flap=".".$get_flap[1];
            }
             else{
               $fraction_flap='';     
            }
			if($get_gusset[1]>0){
                $fraction_gusset=".".$get_gusset[1];
            }
             else{
               $fraction_gusset='';     
            }
            
         
			
			if($datac->L_cm>0){echo "L".$get_length[0].$fraction_length;}
			if($datac->flap>0){echo " + (F-".$get_flap[0].$fraction_flap.")";}
            if($datac->W_cm>0){echo " X W".$get_width[0].$fraction_width;}
			if($datac->gusset>0){echo " (G-".$get_gusset[0].$fraction_gusset." + ".$get_gusset[0].$fraction_gusset.")";}
            echo "".$datac->measurement_unit."<br>".$datac->addi_measurement;
			
			}else{
			
			$get_length=explode(".",$datac->L_cm);
            $get_width=explode(".",$datac->W_cm);
            $get_height=explode(".",$datac->H_cm);
			$get_flap=explode(".",$datac->flap);
         
            if($get_length[1]>0){
                $fraction_length=".".$get_length[1];
            }
            else{
               $fraction_length='';  
                
            }
              if($get_width[1]>0){
                $fraction_width=".".$get_width[1];
            }
              else{
               $fraction_width='';  
                
            }
               if($get_height[1]>0){
                $fraction_height=".".$get_height[1];
            }
             else{
               $fraction_height='';  
                
            }
			if($get_flap[1]>0){
                $fraction_flap=".".$get_flap[1];
            }
             else{
               $fraction_flap='';  
                
            }
            
            
            if($datac->L_cm>0){echo $get_length[0].$fraction_length."X";}
            if($datac->W_cm>0){echo "".$get_width[0].$fraction_width;}
            if($datac->flap>0){echo "X F-".$get_flap[0].$fraction_flap;}
            if($datac->H_cm>0){echo "X".$get_height[0].$fraction_height;}
            echo "".$datac->measurement_unit."<br>".$datac->addi_measurement;
			
			}
            ?>
		  </td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $tot_unit_sum +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:14px;">
        <td colspan="3" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum,0) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">&nbsp;</td>
        </tr>
		
		</table>
		
		</td>
</tr>
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  style="line-height:normal;" >
	
	
		
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="left" ><span style="font-size:14px;">Received the above goods in good condition</span></td>
		  <td align="center">&nbsp;</td>
		  <td align="center"><span style="font-size:14px;"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);?> </span></td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="left" ><span style="font-size:14px;">RECEIVER'S NAME</span></td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="left" ><span style="font-size:14px;">SIGNATURE:</span></td>
		  <td align="center">-----------------------</td>
		  <td align="center">--------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center" >&nbsp;</td>
		  <td align="center"><strong><span style="font-size:14px;"> PREPARED BY </span></strong></td>
		  <td align="center"><strong><span style="font-size:14px;"> AUTHORISED SIGNATURE </span></strong></td>
		  </tr>
		<tr>
		  <td align="Left"><span style="font-size:14px;">DATE &amp; TIME:</span></td>
		  <td align="center">(
		    <?= find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?>
		    )</td>
		  <td align="center">(
		    <?= find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?>
		    )</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="30%">&nbsp;</td>
		    <td  align="center" width="40%">&nbsp;</td>
		    <td  align="center" width="30%">&nbsp;</td>
		    </tr>
		<tr >
		  <td colspan="2" align="left">YPL Marketing Concern: <?= find_a_field('marketing_person','marketing_person_name','person_code='.$master->marketing_person);?></td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="2" style="font-size:12px">
                Note: No claims for shortage will be entertained after one days from the delivered date.  </td>
		    <td>This is an ERP generated report </td>
		    </tr>
			
	<? if($dealer->fsc_claim==4) {?>
		<tr>
		  <td colspan="3" align="center">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3" align="center" style="line-height:20px; font-weight:700;"> FSC CLAIM: MIX CREDIT  </td>
		</tr>
			
		<tr>
            <td colspan="3" align="center" style="line-height:20px; font-weight:700;">FSC CERTIFICATE: SCS-COC-007177  </td>
		</tr>
	<? }?>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>


</div>





</body>
</html>
