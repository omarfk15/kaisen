<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);



require_once "../../../assets/template/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no 		= $_REQUEST['v_no'];

$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$pack_unit_count= find_a_field('sale_do_chalan','COUNT(pack_unit)','chalan_no="'.$chalan_no.'" and pack_unit!=""');



$do_no= find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);

$dealer= find_all_field('dealer_info','','dealer_code="'.$master->dealer_code.'"');


$ch_data= find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);

$marketing= find_all_field('marketing_person','','person_code='.$master->marketing_person);



  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}


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
					  
					  	    </div>
				  </div>
				  
				 
				  <img  src="../sales_order/report_head.png" width="100%"/>
				  
				  
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
 
  DELIVERY CHALLAN
 </p>
  <hr  style="margin:0px; padding:0px;border:0.5px solid;" />
  
  </td></tr>
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:14px; line-height:normal;">


		        <tr>
		          <td width="60%" align="left" valign="middle" style="font-size:20px;"><strong>Party Name :</strong> 
		            <?= $dealer->dealer_name_e?></td>
		          <td width="40%" align="right"><strong><span style="font-size:20px;">Challan No </span> </strong><strong><span style="font-size:20px;">: </span></strong><strong> <span style="font-size:20px;">
				  
				  <?=$ch_data->chalan_no_view ?></span></strong></td>
	              </tr>
		        <tr>
		          <td align="left" valign="top" style="font-size:14px;"><strong>Address :</strong>
		            <?= $dealer->address_e?></td>
		          <td align="right">
				 
				  <strong><span style="font-size:20px;">DO No </span></strong><strong>: </strong><strong><span style="font-size:20px;"><?=$master->job_no;?></span></strong>
				  <? if($master->po_no!=""){?>
				  <br />
				 <span style="font-size:20px;"> <strong>PO No : <?= $master->po_no;?> </strong></span>
				  <? }?>
				  </td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle"> <strong>Mobile No:</strong><span style="font-size:14px;">
		            <?= $dealer->contact_no?>
		          </span></td>
		          <td align="right"><strong>Delivery Date </strong><strong>: </strong><strong><?php echo date('d/m/Y',strtotime($ch_data->chalan_date));?></strong></td>
	              </tr>
		        <tr style="font-size:17px;">
		          <td align="left" valign="top" ><strong>Delivery Address :</strong>
                    <?= $master->delivery_address;?></td>
		          <td align="right"><strong>Vehicle No : </strong> 
	                <?=$ch_data->vehicle_no;?></td>
	              </tr>
		        <tr style="font-size:16px;">
		          <td align="left" valign="top" ><strong>Marketing Person :</strong> 
		            <?= $marketing->marketing_person_name;?></td>
		          <td align="right"><strong>Driver : </strong>
	                <?=$ch_data->driver_name;?></td>
	              </tr>
		        <tr>
		          <td align="left" valign="middle" ><strong>Mobile No : </strong>
		            <?= $marketing->mobile_no;?></td>
		          <td align="right"><strong>Driver Contact :</strong>
		            <?=$ch_data->driver_mobile;?></td>
		          </tr>
		       <tr style="font-size:16px;">
		          <td align="left" valign="middle" ><strong>Receiver Name :</strong> <?=$ch_data->receiver_name;?> </td>
		          <td align="right">Printing Date-Time:
                    <? $print_date=date('Y-m-d H:i:s');  ?>
                    <?=date("d/m/Y",strtotime($print_date)).' '.date("h:i A",strtotime($print_date));?></td>
		          </tr>
		        <tr>
		          <td align="left" valign="middle" ><strong>Mobile No :</strong>
                    <?= $ch_data->receiver_mobile;?></td>
		          <td align="right">&nbsp;</td>
		          </tr>
		        <tr>
		          <td align="left" valign="top" >&nbsp;</td>
		          <td align="right">&nbsp;</td>
		          </tr>
				<? if($pi_no>0) {?>
		        <tr style="font-size:14px; color:#0000FF;">
		          <td align="left" valign="top" >&nbsp;</td>
		          <td align="right">&nbsp;</td>
		          </tr>
				  <? }?>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
		
		
    <tr> <td>&nbsp; </td> </tr>
  
 
  <tr>
    <td>      
      <table width="100%" class="tabledesign" border="1" bordercolor="#687281" cellspacing="0" cellpadding="5"  style="font-size:14px">
        <thead>
        <tr>
          <td width="3%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="10%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Code</strong></td>
          <td width="27%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Product</strong></td>
		
          <td width="12%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Length</strong></td>
         
         <? if($master->order_type=='RFT') {?>  <td width="14%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><span style="white-space:nowrap;"><strong>Delivery/RFT </strong></span></td> <? }?>
          <td width="12%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><span style="white-space:nowrap;"><strong>Delivery/Pcs </strong></span></td>
        
		
          <td width="22%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Remarks</strong></td>
          </tr>
		</thead>
        
        <?  
		
		
		
		
		
		
	$sqlc = 'select c.*, i.finish_goods_code, i.item_name from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' and c.total_unit>0 group by c.id order by  c.id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:13px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="center" valign="top"><?=$datac->finish_goods_code?></td>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->item_name?>		 </td>
		  
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->length?>'</td>
			
		<? if($master->order_type=='RFT') {?> 
		  
          <td align="center" valign="top"><?=number_format($datac->total_unit_rft,0); $grand_total_unit_rft +=$datac->total_unit_rft?></td><? }?>
          <td align="center" valign="top"><?=number_format($datac->total_unit_pcs,0); $grand_total_unit_pcs +=$datac->total_unit_pcs?></td>
		  
		 
		
          <td align="center" valign="top"><? number_format($datac->total_unit,2); $grand_tot_unit1 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }?>
        <tr style="font-size:14px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
		
        <td align="right" valign="middle">&nbsp;</td>
       <? if($master->order_type=='RFT') {?> 
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_total_unit_rft,0) ;?>
        </strong></td><? }?>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_total_unit_pcs,0) ;?>
        </strong></td>
		
        <td align="center" valign="middle"><strong><? number_format($grand_tot_unit1,2) ;?></strong></td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <?php /*?><tr>
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
</tr><?php */?>
	
	
	

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
		  <td align="center">
		  <? find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?></td>
		  <td align="center">
		  <? find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="30%">&nbsp;</td>
		    <td  align="center" width="40%">&nbsp;</td>
		    <td  align="center" width="30%">&nbsp;</td>
		    </tr>
		<tr >
		  <td colspan="2" align="left">Marketing Concern:		    <?= find_a_field('marketing_person','marketing_person_name','person_code='.$master->marketing_person);?></td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="2" style="font-size:12px">
                Note: No claims for shortage will be entertained after one days from the delivered date.  </td>
		    <td>This is an ERP generated report </td>
		    </tr>
		<tr>
		  <td colspan="2" style="font-size:12px">&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="2" style="font-size:12px">&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  
		<?
		$sql = "select d.do_no, sum(d.total_unit_pcs) as do_total_qty from sale_do_details  d, item_info i 
		where d.item_id=i.item_id and d.do_no='".$do_no."' group by d.do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $do_total_qty[$info->do_no]=$info->do_total_qty;
		}
		
		$sql = "select c.do_no, sum(c.total_unit_pcs) as ch_total_qty from sale_do_chalan  c, item_info i 
		where c.item_id=i.item_id and c.do_no='".$do_no."' group by c.do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $ch_total_qty[$info->do_no]=$info->ch_total_qty;
		}
		  ?>
		  
		  <? if($grand_tot_pend=$do_total_qty[$do_no]-$ch_total_qty[$do_no]>0) {?>
		<tr>
		  <td colspan="3" style="font-size:12px">
		  <table width="100%" class="tabledesign" border="1" bordercolor="#687281" cellspacing="0" cellpadding="5"  style="font-size:14px">
        <thead>
        <tr>
          <td colspan="8"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Delivery Pending Quantity</strong></td>
          <tr>
          <td width="3%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="3%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Code</strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Product </strong></td>
		 
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Size</strong></td>
          <td width="8%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Thickness</strong></td>
          <td width="14%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Mark</strong></td>
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Length</strong></td>
          <td width="7%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pending/Pcs</strong></td>
        </thead>
        
        <?  
		
		 $sql = "select order_no, sum(total_unit_pcs) as ch_total_unit_pcs from sale_do_chalan where do_no='".$do_no."' group by order_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $ch_total_unit_pcs[$info->order_no]=$info->ch_total_unit_pcs;
		}
		
		
		  $sqlc = 'select c.*, i.finish_goods_code, i.item_name from sale_do_details c, item_info i, item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' and c.total_unit>0 group by c.id order by  i.sub_group_id, i.item_id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			?>
			<? if($pending_del_pcs=$datac->total_unit_pcs-$ch_total_unit_pcs[$datac->id]>0) { $dp++;?>
        <tr style="font-size:13px;">
          <td align="center" valign="top"><?=$dp;?></td>
          <td align="center" valign="top"> <?=$datac->finish_goods_code?></td>
          <td align="left" valign="top" style=" white-space: nowrap;">
		  <?=$datac->item_name?> </td>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->size?>            </td>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->thickness?> mm</td>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->mark?></td>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->length?>'</td>
          <td align="right" valign="top">
		  <? 
		  $datac->total_unit_pcs;
		  $ch_total_unit_pcs[$datac->id]; 
		 echo  $pending_del_pcs=$datac->total_unit_pcs-$ch_total_unit_pcs[$datac->id]; $tot_pending_del_pcs +=$datac->total_unit_pcs-$ch_total_unit_pcs[$datac->id];
		  ?></td>
        </tr>
        
        <? } }?>
        <tr style="font-size:14px;">
        <td colspan="6" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_pending_del_pcs,0);?>
        </strong></td>
        </tr>
      </table>
		  </td>
		  </tr>
		 
		 <? }?> 
		  
		<tr>
		  <td colspan="2" style="font-size:12px">&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>


</div>





</body>
</html>
