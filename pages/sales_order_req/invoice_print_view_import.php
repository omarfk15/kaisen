<?php
session_start();

//====================== EOF ===================

require_once "../../../assets/template/layout.top.php";

//require "../../../engine/tools/class.numbertoword.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$invoice_no		= $_REQUEST['invoice_no'];


$ms_data= find_all_field('purchase_requisition_master','','invoice_no='.$invoice_no);

$title = 'Purchase Requisition';



if(isset($_POST['cash_discount']))


{



	$po_no = $_POST['po_no'];



	$cash_discount = $_POST['cash_discount'];



	$ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';



	db_query($ssql);



}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: <?=$title;?> :.</title>



<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>



<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";

window.print();
document.getElementById("pr").style.display="block";
}



</script>
<style type="text/css">

#pr input{
    width: 60px;
    height: 30px;
    font-size: 15px;
    font-weight: 600;
}
<!--
-->

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



<form action="" method="post">



<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td align="center"><div class="header">
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
				  
				  <img  src="ypl_report_head.png" width="100%"/></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>



<!--  <tr>
    <td colspan="0" align="center"><hr /></td>
  </tr>-->
  
 
  <tr>
   <td colspan="2" align="center">

    <hr style="margin:0px; padding:0px;border:0.5px solid;"/>
  <p style="text-align:center; color:#FFF; font-size:18px; color:#687281; font-weight:bold; margin:0px; padding:0px; text-transform:uppercase" >
  Purchase Requisition
  </p>
  <hr  style="margin:0px; padding:0px;border:0.5px solid;" />
  
  <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:14px; line-height:normal;">
              <tr >
                <td width="61%" align="left" valign="middle"  style="font-size:18px;" ><strong>Booking No </strong><strong>:
                  <?=$ms_data->booking_no;?>
                </strong></td>
                <td width="39%" align="right" valign="middle"  style="font-size:18px;" ><strong>Date </strong><strong>: </strong>
                    <?= date('d-M-y',strtotime($ms_data->invoice_date));?></td>
              </tr>
			  
			  
			  <? if($ms_data->item_type==1) {?>
              <tr >
                <td align="left" valign="middle"  style="font-size:16px;"><strong>Paper Grade </strong><strong>:</strong> 
		<?
		$o=0;
		 $itm_sql = "select i.item_id, i.item_name from purchase_requisition_details po, item_info i, item_sub_group s 
 		where i.item_id=po.item_id and i.sub_group_id=s.sub_group_id and po.invoice_no='".$invoice_no."'
		 group by po.item_id order by po.item_id";
			$itm_query=db_query($itm_sql);
			while($itm_data= mysqli_fetch_object($itm_query)){
			$o++;
			if ($o>1) echo ', ';
			echo $itm_data->item_name;}?>					</td>
                <td align="right" valign="top"  style="font-size:14px;">&nbsp;</td>
              </tr>
			  <? }elseif($ms_data->item_type==2) {?>
			  <tr >
                <td align="left" valign="middle"  style="font-size:16px;"><strong>Description </strong><strong>:</strong> 
		<?
		$o=0;
		 $itm_sql = "select i.item_id, i.item_name from purchase_requisition_details po, item_info i, item_sub_group s 
 		where i.item_id=po.item_id and i.sub_group_id=s.sub_group_id and po.invoice_no='".$invoice_no."'
		 group by po.item_id order by po.item_id";
			$itm_query=db_query($itm_sql);
			while($itm_data= mysqli_fetch_object($itm_query)){
			$o++;
			if ($o>1) echo ', ';
			echo $itm_data->item_name;}?> <?=$ms_data->grade;?>					</td>
                <td align="right" valign="top"  style="font-size:14px;">&nbsp;</td>
              </tr>
			  <? }elseif($ms_data->item_type==3 || $ms_data->item_type==4 || $ms_data->item_type==5) {?>
			  
			  <tr >
                <td align="left" valign="middle"  style="font-size:16px;"><strong>Description </strong><strong>:</strong> 
		<?
		$o=0;
		 $itm_sql = "select i.item_id, i.item_name from purchase_requisition_details po, item_info i, item_sub_group s 
 		where i.item_id=po.item_id and i.sub_group_id=s.sub_group_id and po.invoice_no='".$invoice_no."'
		 group by po.item_id order by po.item_id";
			$itm_query=db_query($itm_sql);
			while($itm_data= mysqli_fetch_object($itm_query)){
			$o++;
			if ($o>1) echo ', ';
			echo $itm_data->item_name;}?>				</td>
                <td align="right" valign="top"  style="font-size:14px;">&nbsp;</td>
              </tr>
			  
			  <? }elseif($ms_data->item_type==6) {?>
			  
			  <tr >
                <td align="left" valign="middle"  style="font-size:16px;"><strong>Item </strong><strong>:</strong> 
		<?
		$o=0;
		 $itm_sql = "select i.sub_group_id, s.sub_group_name from purchase_requisition_details po, item_info i, item_sub_group s 
 		where i.item_id=po.item_id and i.sub_group_id=s.sub_group_id and po.invoice_no='".$invoice_no."'
		 group by i.sub_group_id order by i.sub_group_id";
			$itm_query=db_query($itm_sql);
			while($itm_data= mysqli_fetch_object($itm_query)){
			$o++;
			if ($o>1) echo ', ';
			echo $itm_data->sub_group_name;}?>				</td>
                <td align="right" valign="top"  style="font-size:14px;">&nbsp;</td>
              </tr>
			  
			  <? }?>
              <tr >
                <td align="left" valign="middle"  style="font-size:16px;"><strong>Brand </strong><strong>:</strong>
                    <?= $ms_data->brand;?></td>
                <td align="right" valign="middle"  style="font-size:14px;">&nbsp;</td>
              </tr>
			  <? if($ms_data->item_type==3 || $ms_data->item_type==4 || $ms_data->item_type==5) {?>
              <tr >
                <td align="left" valign="middle"  style="font-size:16px;"><strong>Grade </strong><strong>:</strong>
                  <?= $ms_data->grade;?></td>
                <td align="right" valign="middle"  style="font-size:14px;">&nbsp;</td>
              </tr>
			    <? }?>
              <tr >
                <td align="left" valign="middle"  style="font-size:16px;"><strong>Origin </strong><strong>:</strong>
                    <?=$ms_data->country_of_origin;?></td>
                <td align="right" valign="top"  style="font-size:14px;">&nbsp;</td>
              </tr>
            </table></td>
		  </tr>


		</table>		</td></tr>



   


	
	
	
	<tr>

<td>&nbsp;

</td></tr>
	
<tr>

<td >
<? if($ms_data->item_type==1) {?>

<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:797px; border: 1px solid #000;">
       <tr>

        <td width="7%" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="26%" bgcolor="#F5F5F5" ><strong>Roll Size </strong></td>
        <td width="25%" bgcolor="#F5F5F5" ><strong>GSM</strong></td>
        <td width="18%" bgcolor="#F5F5F5" align="right" ><strong>Weight (KG)  </strong></td>
        </tr>

	  <?php
$final_amt=0;
$pi=0;

$total=0;

		


 $sql="select d.* from purchase_requisition_master m, purchase_requisition_details d where  m.invoice_no=d.invoice_no and m.invoice_no='".$invoice_no."' order by d.item_id, d.size, d.total_unit";



$query=db_query($sql);


//echo $sql2;



while($data=mysqli_fetch_object($query)){ 



$pi++;


$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$data->size;?> <?=$data->measurement_unit;?></td>
        <td valign="top"><?=$data->gsm;?></td>
        <td valign="top" align="right"><?=number_format($data->total_unit,2); $tot_qty +=$data->total_unit?> </td>
        </tr>
		
		<? }?>
<tr>

  <td align="right" valign="top" colspan="3"><strong>Total:</strong></td>

  <td valign="top" align="right"><strong><?=number_format($tot_qty,2);?> </strong></td>
  </tr>

    </table>
	<? }elseif($ms_data->item_type==2){?>
	<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:797px; border: 1px solid #000;">
       <tr>

        <td width="4%" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="41%" bgcolor="#F5F5F5" ><strong>Types Of Resin </strong></td>
        <td width="19%" bgcolor="#F5F5F5" align="center" ><strong>Weight (KG)  </strong></td>
        <td width="36%" bgcolor="#F5F5F5" align="center" ><strong>Remarks </strong></td>
       </tr>

	  <?php
$final_amt=0;
$pi=0;

$total=0;

		 $sql = "select item_id, item_name from item_info where 1 group by item_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $item_name[$info->item_id]=$info->item_name;
	
		}


 $sql="select d.* from purchase_requisition_master m, purchase_requisition_details d where  m.invoice_no=d.invoice_no and m.invoice_no='".$invoice_no."' order by d.item_id, d.size, d.total_unit";



$query=db_query($sql);


//echo $sql2;



while($data=mysqli_fetch_object($query)){ 



$pi++;


$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$item_name[$data->item_id]?></td>
        <td valign="top" align="right"><?=number_format($data->total_unit,2); $tot_qty +=$data->total_unit?> </td>
        <td valign="top" align="right">&nbsp;</td>
</tr>
		
		<? }?>
<tr>

  <td align="right" valign="top" colspan="2"><strong>Total:</strong></td>

  <td valign="top" align="right"><strong><?=number_format($tot_qty,2);?> </strong></td>
  <td valign="top" align="right">&nbsp;</td>
</tr>
    </table>
	<? }elseif($ms_data->item_type==3){?>
	
	<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:797px; border: 1px solid #000;">
       <tr>

        <td width="4%" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="50%" bgcolor="#F5F5F5" align="center" ><strong>Description</strong></td>
        <td width="19%" bgcolor="#F5F5F5" align="center" ><strong>Weight (KG)  </strong></td>
        <td width="27%" bgcolor="#F5F5F5" align="center" ><strong>Remarks </strong></td>
       </tr>

	  <?php
$final_amt=0;
$pi=0;

$total=0;

		 $sql = "select item_id, item_name from item_info where 1 group by item_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $item_name[$info->item_id]=$info->item_name;
	
		}
		
		$sql = "select id, gumtape_color from gumtape_color where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $gumtape_color[$info->id]=$info->gumtape_color;
	
		}


 $sql="select d.* from purchase_requisition_master m, purchase_requisition_details d where  m.invoice_no=d.invoice_no and m.invoice_no='".$invoice_no."' order by d.item_id, d.size, d.total_unit";



$query=db_query($sql);


//echo $sql2;



while($data=mysqli_fetch_object($query)){ 



$pi++;


$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="center"><?=$item_name[$data->item_id]?> <br /><?=$data->micron;?>Mic X <?=$data->size;?><?=$data->measurement_unit;?> X <?=$data->meter;?> Meter (<?=$gumtape_color[$data->color];?>)</td>
        <td valign="top" align="right"><?=number_format($data->total_unit,2); $tot_qty +=$data->total_unit?> </td>
        <td valign="top" align="right">&nbsp;</td>
</tr>
		
		<? }?>
<tr>

  <td align="right" valign="top" colspan="2"><strong>Total:</strong></td>

  <td valign="top" align="right"><strong><?=number_format($tot_qty,2);?> </strong></td>
  <td valign="top" align="right">&nbsp;</td>
</tr>
    </table>
	
	<? }elseif($ms_data->item_type==4){?>
	
	<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:797px; border: 1px solid #000;">
       <tr>

        <td width="4%" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="41%" bgcolor="#F5F5F5" ><strong>Description</strong></td>
        <td width="19%" bgcolor="#F5F5F5" align="center" ><strong>Weight (KG)  </strong></td>
        <td width="36%" bgcolor="#F5F5F5" align="center" ><strong>Remarks </strong></td>
       </tr>

	  <?php
$final_amt=0;
$pi=0;

$total=0;

		 $sql = "select item_id, item_name from item_info where 1 group by item_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $item_name[$info->item_id]=$info->item_name;
	
		}


 $sql="select d.* from purchase_requisition_master m, purchase_requisition_details d where  m.invoice_no=d.invoice_no and m.invoice_no='".$invoice_no."' order by d.item_id, d.size, d.total_unit";



$query=db_query($sql);


//echo $sql2;



while($data=mysqli_fetch_object($query)){ 



$pi++;


$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$item_name[$data->item_id]?> - <?=$data->size?></td>
        <td valign="top" align="right"><?=number_format($data->total_unit,2); $tot_qty +=$data->total_unit?> </td>
        <td valign="top" align="right">&nbsp;</td>
</tr>
		
		<? }?>
<tr>

  <td align="right" valign="top" colspan="2"><strong>Total:</strong></td>

  <td valign="top" align="right"><strong><?=number_format($tot_qty,2);?> </strong></td>
  <td valign="top" align="right">&nbsp;</td>
</tr>
    </table>
	
	<? }elseif($ms_data->item_type==5){?>
	
	<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:797px; border: 1px solid #000;">
       <tr>

        <td width="4%" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="41%" bgcolor="#F5F5F5" ><strong>Description</strong></td>
        <td width="19%" bgcolor="#F5F5F5" align="center" ><strong>Weight (KG)  </strong></td>
        <td width="36%" bgcolor="#F5F5F5" align="center" ><strong>Remarks </strong></td>
       </tr>

	  <?php
$final_amt=0;
$pi=0;

$total=0;

		 $sql = "select item_id, item_name from item_info where 1 group by item_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $item_name[$info->item_id]=$info->item_name;
	
		}


 $sql="select d.* from purchase_requisition_master m, purchase_requisition_details d where  m.invoice_no=d.invoice_no and m.invoice_no='".$invoice_no."' order by d.item_id, d.size, d.total_unit";



$query=db_query($sql);


//echo $sql2;



while($data=mysqli_fetch_object($query)){ 



$pi++;


$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$item_name[$data->item_id]?></td>
        <td valign="top" align="right"><?=number_format($data->total_unit,2); $tot_qty +=$data->total_unit?> </td>
        <td valign="top" align="right">&nbsp;</td>
</tr>
		
		<? }?>
<tr>

  <td align="right" valign="top" colspan="2"><strong>Total:</strong></td>

  <td valign="top" align="right"><strong><?=number_format($tot_qty,2);?> </strong></td>
  <td valign="top" align="right">&nbsp;</td>
</tr>
    </table>
	
	<? }elseif($ms_data->item_type==6){?>
	
	<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:797px; border: 1px solid #000;">
       <tr>

        <td width="2%" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="20%" bgcolor="#F5F5F5" ><strong>Particular</strong></td>
        <td width="17%" bgcolor="#F5F5F5" ><strong>Size</strong></td>
        <td width="14%" bgcolor="#F5F5F5" ><strong>Model</strong></td>
        <td width="17%" bgcolor="#F5F5F5" ><strong>Part No </strong></td>
        <td width="6%" bgcolor="#F5F5F5" ><strong>Unit</strong></td>
        <td width="8%" bgcolor="#F5F5F5" align="center" ><strong>Quantity</strong></td>
        <td width="16%" bgcolor="#F5F5F5" align="center" ><strong>Machine No  </strong></td>
       </tr>

	  <?php
$final_amt=0;
$pi=0;

$total=0;

		 $sql = "select item_id, item_name from item_info where 1 group by item_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $item_name[$info->item_id]=$info->item_name;
	
		}
		
		 $sql = "select id, machine_name from machine_info where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $machine_name[$info->id]=$info->machine_name;
	
		}


 $sql="select d.* from purchase_requisition_master m, purchase_requisition_details d where  m.invoice_no=d.invoice_no and m.invoice_no='".$invoice_no."' order by d.id";



$query=db_query($sql);


//echo $sql2;



while($data=mysqli_fetch_object($query)){ 



$pi++;


$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$item_name[$data->item_id]?></td>
        <td valign="top"  align="left">
		<?php 
            $get_length=explode(".",$data->L);
            $get_width=explode(".",$data->W);
            $get_height=explode(".",$data->H);
         
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
            
            
            if($data->L>0){echo $get_length[0].$fraction_length;}
            if($data->W>0){echo "X".$get_width[0].$fraction_width;}
            if($data->H>0){echo "X".$get_height[0].$fraction_height;}
            echo "".$data->measurement_unit;
            ?>
		</td>
        <td valign="top"  align="left"><?=$data->model?></td>
        <td valign="top"  align="left"><?=$data->part_no?></td>
        <td valign="top"  align="left"><?=$data->unit_name?></td>
        <td valign="top" align="right"><?=number_format($data->total_unit,2); $tot_qty +=$data->total_unit?> </td>
        <td valign="top" align="left"><?=$machine_name[$data->machine_no];?></td>
</tr>
		
		<? }?>

    </table>
	
	<? }?>
	  </td>
	</tr>
	
	
	
	
	

<tr>

<td>

      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >



        <tr style=" font-weight:500; letter-spacing:.3px;">
          <td colspan="4" width="100%">&nbsp;</td>
        </tr>
        



        <tr>
          <td colspan="4" align="right">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
        </tr>
        
        
        
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
          </tr>
        <tr>

          <td colspan="4" align="right">&nbsp;</td>
          </tr>

		



		



        <tr>
          <td width="25%" align="center">&nbsp;</td>
          <td  width="25%" align="center">&nbsp;</td>
          <td width="25%" align="center">&nbsp;</td>
          <td width="25%" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
        </tr>
        <tr>
          <td align="center"><strong>Prepared By</strong></td>
          <td align="center"><strong>Store In-Charge </strong></td>
          <td align="center"><strong>Checked By </strong></td>
          <td align="center"><strong>Authourised Signature </strong></td>
        </tr>
        <tr style="font-size:12px">
          <td align="center">(<?= find_a_field('user_activity_management','fname','user_id='.$ms_data->entry_by);?>)</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  
  
  
  <tr>

<td>&nbsp;</td>
  </tr>
  
  
  
</table>



</form>



</body>



</html>



