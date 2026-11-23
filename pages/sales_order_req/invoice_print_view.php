<?php

session_start();

//====================== EOF ===================


require_once "../../../assets/template/layout.top.php";

//require "../../../engine/tools/class.numbertoword.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$invoice_no		= $_REQUEST['invoice_no'];


 $count_sum=find_a_field('purchase_requisition_details','sum(count_type)','invoice_no='.$invoice_no);


if(isset($_POST['cash_discount']))



{



	$po_no = $_POST['po_no'];



	$cash_discount = $_POST['cash_discount'];



	$ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';



	db_query($ssql);



}







$sql_ms="select * from purchase_requisition_master where invoice_no='$invoice_no'";

$ms_data=mysqli_fetch_object(db_query($sql_ms));

$company=find_all_field('user_group','','id='.$ms_data->group_for);

$whouse=find_all_field('warehouse','','warehouse_id='.$ms_data->warehouse_id);


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: Purchase Requisition :.</title>



<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>



<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>

<style type="text/css">




<!--
.header table tr td table tr td table tr td table tr td {
	color: #000;
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


@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}



.number {
    width: 8em;
    display: block;
    word-wrap: break-word;
    columns: 6;
    column-gap: 0.2em;
}
@media print{  
    @page:first {
        margin-top: 35px; /* No margin on the first page */
    }
	    @page table {
        margin-top: 50px; /* Margin for the second and subsequent pages */
    }  
    .ps
    {
        display: none !important;
    }
	
/*	.sr{
    position: fixed;
    top: 0;
    width: 100%;
	}
	.sr-new{
		margin-top:80px;
	}*/
}



#pr input{
    width: 60px;
    height: 30px;
    font-size: 15px;
    font-weight: 600;
}
</style>
</head>



<body>



<form action="" method="post">



<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td align="center"><div class="header" style="margin-top:0;">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0; text-align:center; " >
								
									
									<tr>
									  <td style="padding-bottom:3px; "><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$company->group_name?></span></td>
							  </tr>
							  
							  
									<tr><td style="font-size:16px; line-height:20px;"><?=$company->address?></td>
									</tr>
									
									
									
									<tr>
   <td colspan="2" align="center"><h4 style="font-size:18px; width: 40%; padding:5px 0; margin:0; border:2px solid #000000; margin: 8px 0; background:#F5F5F5; border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-transform:uppercase;">Purchase Requisition</h4></td>
  </tr>
									
									
							
									
							  
							  
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
       </div></td>
  </tr>



  <tr>
    <td colspan="0" align="center"><hr /></td>
  </tr>
  
 
  
  
  <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">


		      <table width="96%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">
		        <tr style=" line-height:20px;" >
		          <td width="25%" align="left" valign="middle"  style="font-size:14px;" ><strong>REQ. From  </strong></td>
		          <td width="3%" align="left" valign="middle"  style="font-size:14px;" ><strong>: </strong></td>
		          <td width="72%" style="font-size:14px; "><?= $whouse->warehouse_name;?></td>
	            </tr>
		        <tr style=" line-height:20px;">
		          <td align="left" valign="middle"  style="font-size:14px;"><strong>REQ. Type</strong></td>
		          <td align="left" valign="middle" style="font-size:14px;" ><strong>:</strong></td>
		          <td style="font-size:14px;">
		            <?= find_a_field('requisition_type','requisition_type','id="'.$ms_data->inv_type.'"');?>		          </td>
	            </tr>
				
				<tr style=" line-height:20px;">
		          <td align="left" valign="middle"  style="font-size:14px;"><strong>Requisition By </strong></td>
		          <td align="left" valign="middle" style="font-size:14px;" ><strong>:</strong></td>
		          <td style="font-size:14px;">   <?= $ms_data->requisition_by;?>		          </td>
	            </tr>
				<tr style=" line-height:20px;">
				  <td align="left" valign="middle"  style="font-size:14px;"><strong>Department </strong></td>
				  <td align="left" valign="middle" style="font-size:14px;" ><strong>:</strong></td>
				  <td style="font-size:14px;"><?= find_a_field('wh_department','department_name','id="'.$ms_data->department.'"');?></td>
			    </tr>
		        </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="58%" align="right" valign="middle"><strong> REQ. No: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">


                      <td>&nbsp;<?=$ms_data->view_invoice_no;?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="58%" align="right" valign="middle"><strong> REQ. Date: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?= date("d-m-Y",strtotime($ms_data->invoice_date));?></td>
                  </tr>
                </table></td> </tr>
				
			
			  


		    </table></td>
		  </tr>


		</table>		</td></tr>



    



  <tr>



    <td><div id="pr">



      <div align="left">



        



          <table width="60%" border="0" cellspacing="0" cellpadding="0">



        <tr>



          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>



          <!--<td><span class="style3">Special Cash Discount: </span></td>



          <td><label>



            <input name="cash_discount" type="text" id="cash_discount" value="<?=$cash_discount?>" />



            </label>



            <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" /></td>



          <td><label>



            <input type="submit" name="Update" value="Update" />



          </label></td>-->
        </tr>
      </table>
      </div>



    </div></td>
</tr>


	
	
	
	<tr>

<td>&nbsp;

</td></tr>
	
<tr>

<td>


<? if($ms_data->inv_type==1) {?>

<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:100%; font-size:12px">

       
       <tr>

        <td width="2%" rowspan="2" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong> Category </strong></td>
           <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>  Code </strong></td>
        <td width="16%" rowspan="2" bgcolor="#F5F5F5" ><strong> Item Description </strong></td>

        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Size</strong></td>
        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Model</strong></td>
        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong>Part.No</strong></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Brand</strong></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Section</strong></td>
        <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Stock</strong></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Unit</strong></td>
		<td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Qty </strong></td>
        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Lead Time</strong></td>
		<td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Note</strong></td>
        <td colspan="5" bgcolor="#F5F5F5" ><div align="center"><strong>Last Purchase info </strong></div></td>
        </tr>
       <tr>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO No </strong></td>
         <td width="7%" bgcolor="#F5F5F5" ><strong>PO Date </strong></td>
         <td width="6%" bgcolor="#F5F5F5" ><strong>PO Rate </strong></td>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO Qty </strong></td>
         <td width="8%" bgcolor="#F5F5F5" ><strong>Vendor</strong></td>
       </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;

 		$sql = "select id, item_type from item_type where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $item_type[$info->id]=$info->item_type;
		}
		
	$sql = "select id, section_name from wh_section where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $section_name[$info->id]=$info->section_name;
		}
		
		$sql = "select id, view_invoice_no, invoice_date, unit_price, total_unit, vendor_id from purchase_foreign_details where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $view_invoice_no[$info->id]=$info->view_invoice_no;
		 $invoice_date[$info->id]=$info->invoice_date;
		 $unit_price[$info->id]=$info->unit_price;
		 $total_unit[$info->id]=$info->total_unit;
		 $vendor_id[$info->id]=$info->vendor_id;
		}
		
		$sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $vendor_name[$info->vendor_id]=$info->vendor_name;
		}



$sql3="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from purchase_requisition_details a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.invoice_no='".$invoice_no."' order by i.sub_group_id, i.item_name";



$data3=db_query($sql3);



//echo $sql2;



while($info2=mysqli_fetch_object($data3)){ 



$pi++;


$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$info2->sub_group_name;?></td>
                   <td align="left" valign="top"><?=$info2->finish_goods_code;?></td>
        <td align="left" valign="top"><?=$info2->item_name;?></td>
        <td align="left" valign="top"><?=$info2->size;?></td>
        <td align="left" valign="top"><?=$info2->model;?></td>
        <td align="left" valign="top"><?=$info2->part_no;?></td>
        <td align="left" valign="top"><?=$info2->brand;?></td>
        <td align="left" valign="top"><?=$section_name[$info2->section_id]?></td>
        <td valign="top"><?=$info2->in_stock;?></td>
        <td valign="top"><?=$info2->unit_name;?></td>
		 <td valign="top"><?=number_format($info2->total_unit,2);?></td>
        <td valign="top"><? if(($info2->exp_date)!='0000-00-00'){ echo "".date('d.m.y',strtotime($info2->exp_date)); }?>		</td>
		  <td valign="top"><?=$info2->other_ins;?></td>
        <td valign="top"><?= $view_invoice_no[$info2->last_po_id];?></td>
        <td valign="top"><? if ($info2->last_po_id>0) {
	echo date("d-M-y",strtotime($invoice_date[$info2->last_po_id])); } ?></td>
        <td valign="top"><?= $unit_price[$info2->last_po_id];?></td>
        <td valign="top"><?= $total_unit[$info2->last_po_id];?></td>
        <td valign="top" align="left"><?= $vendor_name[$vendor_id[$info2->last_po_id]]?></td>
</tr>



<? }?>
    </table>	
	
	<? }?>
	
	
	
	
	
<? if($ms_data->inv_type==3) {?>

<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:100%; font-size:12px">

       
       <tr>

        <td width="2%" rowspan="2" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong> Category </strong></td>
           <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>  Code </strong></td>
        <td width="16%" rowspan="2" bgcolor="#F5F5F5" ><strong> Item Description </strong></td>

        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Size</strong></td>
        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>GSM</strong></td>
        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong>Brand</strong></td>
        <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Stock</strong></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Unit</strong></td>
		<td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Qty </strong></td>
        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Lead Time</strong></td>
		<td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Note</strong></td>
        <td colspan="5" bgcolor="#F5F5F5" ><div align="center"><strong>Last Purchase info </strong></div></td>
        </tr>
       <tr>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO No </strong></td>
         <td width="7%" bgcolor="#F5F5F5" ><strong>PO Date </strong></td>
         <td width="6%" bgcolor="#F5F5F5" ><strong>PO Rate </strong></td>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO Qty </strong></td>
         <td width="8%" bgcolor="#F5F5F5" ><strong>Vendor</strong></td>
       </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;

 		
		
	$sql = "select id, section_name from wh_section where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $section_name[$info->id]=$info->section_name;
		}
		
		$sql = "select id, view_invoice_no, invoice_date, unit_price, total_unit, vendor_id from purchase_foreign_details where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $view_invoice_no[$info->id]=$info->view_invoice_no;
		 $invoice_date[$info->id]=$info->invoice_date;
		 $unit_price[$info->id]=$info->unit_price;
		 $total_unit[$info->id]=$info->total_unit;
		 $vendor_id[$info->id]=$info->vendor_id;
		}
		
		$sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $vendor_name[$info->vendor_id]=$info->vendor_name;
		}
		
		$sql = "select id, brand_name from wh_brand where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $brand_name[$info->id]=$info->brand_name;
		}



$sql="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from purchase_requisition_details a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.invoice_no='".$invoice_no."' order by i.sub_group_id, i.item_name";
$query=db_query($sql);
//echo $sql2;

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$data->sub_group_name;?></td>
                   <td align="left" valign="top"><?=$data->finish_goods_code;?></td>
        <td align="left" valign="top"><?=$data->item_name;?></td>
        <td align="left" valign="top" style="white-space:nowrap;">
		<?php 
            $get_length=explode(".",$data->L);
            $get_width=explode(".",$data->W);
            $get_thickness=explode(".",$data->thickness);
         
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
               if($get_thickness[1]>0){
                $fraction_thickness=".".$get_thickness[1];
            }
             else{
               $fraction_thickness='';     
            }
            
            if($data->L>0){echo "".$get_length[0].$fraction_length;}
            if($data->W>0){echo " X ".$get_width[0].$fraction_width;}
            if($data->thickness>0){echo " X ".$get_thickness[0].$fraction_thickness;}
            echo " ".$data->measurement_unit;
            ?>	
		</td>
        <td align="left" valign="top"><?=$data->gsm;?></td>
        <td align="left" valign="top"><?=$brand_name[$data->brand]?></td>
        <td valign="top"><?=$data->in_stock;?></td>
        <td valign="top"><?=$data->unit_name;?></td>
		 <td valign="top"><?=number_format($data->total_unit,2);?></td>
        <td valign="top"><? if(($data->exp_date)!='0000-00-00'){ echo "".date('d.m.y',strtotime($data->exp_date)); }?>		</td>
		  <td valign="top"><?=$data->other_ins;?></td>
        <td valign="top"><?= $view_invoice_no[$info2->last_po_id];?></td>
        <td valign="top"><? if ($data->last_po_id>0) {
	echo date("d-M-y",strtotime($invoice_date[$data->last_po_id])); } ?></td>
        <td valign="top"><?= $unit_price[$data->last_po_id];?></td>
        <td valign="top"><?= $total_unit[$data->last_po_id];?></td>
        <td valign="top" align="left"><?= $vendor_name[$vendor_id[$data->last_po_id]]?></td>
</tr>



<? }?>
    </table>	
	
	<? }?>
	
	
	
	
<? if($ms_data->inv_type==4) {?>

<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:100%; font-size:12px">

       
       <tr>

        <td width="2%" rowspan="2" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong> Category </strong></td>
           <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>  Code </strong></td>
        <td width="12%" rowspan="2" bgcolor="#F5F5F5" ><strong> Item Description </strong></td>

        <td width="7%" rowspan="2" bgcolor="#F5F5F5" ><strong>Size</strong></td>
        <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Grade</strong></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><span id="item_data_found"><strong>Micron</strong></span></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><span id="item_data_found"><strong>Color</strong></span></td>
        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><span id="item_data_found"><strong>Country</strong></span></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Brand</strong></td>
        <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Stock</strong></td>
        <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Unit</strong></td>
		<td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Qty </strong></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Lead Time</strong></td>
		<td width="8%" rowspan="2" bgcolor="#F5F5F5" ><strong>Note</strong></td>
        <td colspan="5" bgcolor="#F5F5F5" ><div align="center"><strong>Last Purchase info </strong></div></td>
        </tr>
       <tr>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO No </strong></td>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO Date </strong></td>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO Rate </strong></td>
         <td width="4%" bgcolor="#F5F5F5" ><strong>PO Qty </strong></td>
         <td width="11%" bgcolor="#F5F5F5" ><strong>Vendor</strong></td>
       </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;

 		
		
	$sql = "select id, section_name from wh_section where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $section_name[$info->id]=$info->section_name;
		}
		
		$sql = "select id, view_invoice_no, invoice_date, unit_price, total_unit, vendor_id from purchase_foreign_details where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $view_invoice_no[$info->id]=$info->view_invoice_no;
		 $invoice_date[$info->id]=$info->invoice_date;
		 $unit_price[$info->id]=$info->unit_price;
		 $total_unit[$info->id]=$info->total_unit;
		 $vendor_id[$info->id]=$info->vendor_id;
		}
		
		$sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $vendor_name[$info->vendor_id]=$info->vendor_name;
		}
		
		$sql = "select id, brand_name from wh_brand where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $brand_name[$info->id]=$info->brand_name;
		}



$sql="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from purchase_requisition_details a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.invoice_no='".$invoice_no."' order by i.sub_group_id, i.item_name";
$query=db_query($sql);
//echo $sql2;

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$data->sub_group_name;?></td>
                   <td align="left" valign="top"><?=$data->finish_goods_code;?></td>
        <td align="left" valign="top"><?=$data->item_name;?></td>
        <td align="left" valign="top" style="white-space:nowrap;">
		<?php 
            $get_length=explode(".",$data->L);
            $get_width=explode(".",$data->W);
            $get_thickness=explode(".",$data->thickness);
         
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
               if($get_thickness[1]>0){
                $fraction_thickness=".".$get_thickness[1];
            }
             else{
               $fraction_thickness='';     
            }
            
            if($data->L>0){echo "".$get_length[0].$fraction_length;}
            if($data->W>0){echo " X ".$get_width[0].$fraction_width;}
            if($data->thickness>0){echo " X ".$get_thickness[0].$fraction_thickness;}
            echo " ".$data->measurement_unit;
            ?>		</td>
        <td align="left" valign="top"><?=$data->grade;?></td>
        <td align="left" valign="top"><?=$data->micron;?></td>
        <td align="left" valign="top"><?=$data->color;?></td>
        <td align="left" valign="top"><?=$data->country_origin;?></td>
        <td align="left" valign="top"><?=$data->brand;?></td>
        <td valign="top"><?=$data->in_stock;?></td>
        <td valign="top"><?=$data->unit_name;?></td>
		 <td valign="top"><?=number_format($data->total_unit,2);?></td>
        <td valign="top"><? if(($data->exp_date)!='0000-00-00'){ echo "".date('d.m.y',strtotime($data->exp_date)); }?>		</td>
		  <td valign="top"><?=$data->other_ins;?></td>
        <td valign="top"><?= $view_invoice_no[$info2->last_po_id];?></td>
        <td valign="top"><? if ($data->last_po_id>0) {
	echo date("d-M-y",strtotime($invoice_date[$data->last_po_id])); } ?></td>
        <td valign="top"><?= $unit_price[$data->last_po_id];?></td>
        <td valign="top"><?= $total_unit[$data->last_po_id];?></td>
        <td valign="top" align="left"><?= $vendor_name[$vendor_id[$data->last_po_id]]?></td>
</tr>



<? }?>
    </table>	
	
	<? }?>
	
	<? if($ms_data->inv_type==5) {?>
	
	<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:100%; font-size:12px">

       
       <tr>

        <td width="2%" rowspan="2" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong> Category </strong></td>
           <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>  Code </strong></td>
        <td width="16%" rowspan="2" bgcolor="#F5F5F5" ><strong> Item Description </strong></td>

        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Reel Size</strong></td>
        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>GSM</strong></td>
        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong>Brand</strong></td>
        <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Stock</strong></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Unit</strong></td>
		<td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Qty </strong></td>
        <td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Lead Time</strong></td>
		<td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Note</strong></td>
        <td colspan="5" bgcolor="#F5F5F5" ><div align="center"><strong>Last Purchase info </strong></div></td>
        </tr>
       <tr>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO No </strong></td>
         <td width="7%" bgcolor="#F5F5F5" ><strong>PO Date </strong></td>
         <td width="6%" bgcolor="#F5F5F5" ><strong>PO Rate </strong></td>
         <td width="5%" bgcolor="#F5F5F5" ><strong>PO Qty </strong></td>
         <td width="8%" bgcolor="#F5F5F5" ><strong>Vendor</strong></td>
       </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;

 		
		
	$sql = "select id, section_name from wh_section where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $section_name[$info->id]=$info->section_name;
		}
		
		$sql = "select id, view_invoice_no, invoice_date, unit_price, total_unit, vendor_id from purchase_foreign_details where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $view_invoice_no[$info->id]=$info->view_invoice_no;
		 $invoice_date[$info->id]=$info->invoice_date;
		 $unit_price[$info->id]=$info->unit_price;
		 $total_unit[$info->id]=$info->total_unit;
		 $vendor_id[$info->id]=$info->vendor_id;
		}
		
		$sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $vendor_name[$info->vendor_id]=$info->vendor_name;
		}
		
		$sql = "select id, brand_name from wh_brand where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $brand_name[$info->id]=$info->brand_name;
		}



$sql="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from purchase_requisition_details a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.invoice_no='".$invoice_no."' order by i.sub_group_id, i.item_name";
$query=db_query($sql);
//echo $sql2;

while($data=mysqli_fetch_object($query)){ 
$pi++;
$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$data->sub_group_name;?></td>
                   <td align="left" valign="top"><?=$data->finish_goods_code;?></td>
        <td align="left" valign="top"><?=$data->item_name;?></td>
        <td align="left" valign="top" style="white-space:nowrap;">
		<?=$data->reel_size;
            ?>	
		</td>
        <td align="left" valign="top"><?=$data->gsm;?></td>
        <td align="left" valign="top"><?=$brand_name[$data->brand]?></td>
        <td valign="top"><?=$data->in_stock;?></td>
        <td valign="top"><?=$data->unit_name;?></td>
		 <td valign="top"><?=number_format($data->total_unit,2);?></td>
        <td valign="top"><? if(($data->exp_date)!='0000-00-00'){ echo "".date('d.m.y',strtotime($data->exp_date)); }?>		</td>
		  <td valign="top"><?=$data->other_ins;?></td>
        <td valign="top"><?= $view_invoice_no[$info2->last_po_id];?></td>
        <td valign="top"><? if ($data->last_po_id>0) {
	echo date("d-M-y",strtotime($invoice_date[$data->last_po_id])); } ?></td>
        <td valign="top"><?= $unit_price[$data->last_po_id];?></td>
        <td valign="top"><?= $total_unit[$data->last_po_id];?></td>
        <td valign="top" align="left"><?= $vendor_name[$vendor_id[$data->last_po_id]]?></td>
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
        <?php /*?><tr style="font-size:16px; font-weight:500; letter-spacing:.3px;">



		<td colspan="4">
		
		In Word: <?

		

		$scs =  $tot_total_amt;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa. ';}

	 echo ' Only';

		?>.		</td>
          </tr><?php */?>




		<? if($ms_data->remarks!=""){?>
         <tr>
          <td colspan="4" align="left">
		  <b>Remarks:</b> <?=$ms_data->remarks;?>
		  </td>
          </tr>
		  <? }?>
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

          <td colspan="4" align="right">&nbsp;</td>
          </tr>

		



		



        <tr>
          <td width="25%" align="center"><?=find_a_field('user_activity_management','fname','user_id='.$ms_data->entry_by);?></td>
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
          <td align="center"><strong>Production Manager</strong></td>
          <td align="center"><strong>Account's Officer </strong></td>
          <td align="center"><strong>Executive Director</strong></td>
        </tr>
      </table></td>
  </tr>
</table>



</form>



</body>



</html>



