<?php

session_start();

//====================== EOF ===================


require_once "../../../assets/template/layout.top.php";

//require "../../../engine/tools/class.numbertoword.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$invoice_no		= $_REQUEST['invoice_no'];


 $count_sum=find_a_field('purchase_requisition_details','sum(count_type)','invoice_no='.$invoice_no);


if(isset($_POST['approve'])){

		 $_POST['checked_at']=date('Y-m-d H:s:i');

		 $_POST['checked_by']=$_SESSION['user']['id'];
		

	 $sql = "update purchase_requisition_master set status='CHECKED', approve_by='".$_POST['checked_by']."', approve_at='".$_POST['checked_at']."' 
	 where invoice_no=".$_POST['invoice_no']."";
	db_query($sql);

	$type=1;

	header("Location: invoice_pending_status.php");

}

if(isset($_POST['rej2'])){

		 $_POST['reject_at']=date('Y-m-d H:s:i');

		 $_POST['reject_by']=$_SESSION['user']['id'];
		

	   $sql = "update purchase_requisition_master set status='REJECTED',rej_approval_note='".$_POST['rej_note']."', reject_approve_by='".$_POST['reject_by']."', reject_approve_at='".$_POST['reject_at']."' 
	 where invoice_no=".$_POST['invoice_no']."";
	db_query($sql);

	$type=1;

	$msg='Purchase Requistion Is Been Rejected.';
	header("Location: invoice_pending_status.php");

}
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

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>



<style type="text/css">



<!--



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




.style4 {



	font-size: 12px;



	font-weight: bold;



}

.style5 {font-weight: bold}

.style6 {font-weight: bold}

.style7 {font-weight: bold}

.style9 {font-weight: bold}

.style10 {font-weight: bold}



-->



</style>


</head>



<body>



<form action="" method="post">

<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $_GET['invoice_no'];?>" />

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
				
				
				<tr>


                <td width="58%" align="right" valign="middle"><strong> Need By Date: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?= date("d-m-Y",strtotime($ms_data->need_by));?></td>
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


<table  class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:100%; font-size:12px">

       
       <tr>

        <td width="2%" rowspan="2" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="7%" rowspan="2" bgcolor="#F5F5F5" ><strong> Category </strong></td>
        <td width="26%" rowspan="2" bgcolor="#F5F5F5" ><strong> Item Description </strong></td>

        <td width="13%" rowspan="2" bgcolor="#F5F5F5" ><strong>Type</strong></td>
        <? if($count_sum>0) {?><td width="6%" rowspan="2" bgcolor="#F5F5F5" ><strong>Count</strong></td>
        <? }?>
        <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Unit</strong></td>
		<td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Stock</strong></td>
        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong>Quantity </strong></td>
        <td width="7%" rowspan="2" bgcolor="#F5F5F5" ><strong>Country of Origin</strong></td>
			<td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Lead Time</strong></td>
		<td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>Note</strong></td>
        <td colspan="5" bgcolor="#F5F5F5" ><div align="center"><strong>Last Purchase info </strong></div></td>
        </tr>
       <tr>
         <td width="6%" bgcolor="#F5F5F5" ><strong>PO No </strong></td>
         <td width="8%" bgcolor="#F5F5F5" ><strong>PO Date </strong></td>
         <td width="4%" bgcolor="#F5F5F5" ><strong>PO Rate </strong></td>
         <td width="4%" bgcolor="#F5F5F5" ><strong>PO Qty </strong></td>
         <td width="9%" bgcolor="#F5F5F5" ><strong>Vendor</strong></td>
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
		
		$sql = "select id, count from count_type where 1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $count_type[$info->id]=$info->count;
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
        <td align="left" valign="top"><?=$info2->item_name;?></td>
        <td align="left" valign="top"><?=$item_type[$info2->item_type]?></td>
        <? if($count_sum>0) {?><td align="left" valign="top"><?=$count_type[$info2->count_type]?></td><? }?>
        <td valign="top"><?=$info2->unit_name;?></td>
		 <td valign="top"><?=$info2->in_stock;?></td>
        <td valign="top"><?=number_format($info2->total_unit,2);?></td>
        <td valign="top"><?=$info2->country_origin	;?></td>
		 <td valign="top"><?=$info2->lead_time	;?></td>
		  <td valign="top"><?=$info2->note;?></td>
        <td valign="top"><?= $view_invoice_no[$info2->last_po_id];?></td>
        <td valign="top"><? if ($info2->last_po_id>0) {
	echo date("d-M-y",strtotime($invoice_date[$info2->last_po_id])); } ?></td>
        <td valign="top"><?= $unit_price[$info2->last_po_id];?></td>
        <td valign="top"><?= $total_unit[$info2->last_po_id];?></td>
        <td valign="top" align="left"><?= $vendor_name[$vendor_id[$info2->last_po_id]]?></td>
</tr>



<? }?>
    </table>	</td>
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
 
 

	</td>
  </tr>
</table>	
<table style="width:100%;">
  	<tr>
		<td>
		<button  class="btn btn-danger" id="rej" style="background-color: red;color: white;font-weight: bold;padding: 5px  47px; " onClick="rejj_note()" type="button" >Rejected</button> 
		<textarea id="rej_note" name="rej_note" rows="4" cols="50" style="display:none;"></textarea><br>
		<button  class="btn btn-danger" id="rej2" name="rej2" style="background-color: red;color: white;font-weight: bold;padding: 5px  47px;display:none; " type="submit" >Confirm Rejected</button>
		</td>
		<td style="text-align:right;">
		 <button type="submit" name="approve" id="approve" class="btn btn-success" style="background-color: green;color: white;font-weight: bold;padding: 5px  47px; " >Approve</button>
		</td>
	</tr>
  </table>
<br />
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
		
<tr>

<td>

      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >


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

<script>
  	function rejj_note(){
document.getElementById('rej').style.display="none";
document.getElementById('rej2').style.display="block";
document.getElementById('rej_note').style.display="block";
	}
	
	 
		 
  </script>

</body>



</html>



