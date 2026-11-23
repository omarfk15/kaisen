<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

//session_start();
//====================== EOF ===================
//var_dump($_SESSION);
//$_SESSION['proj_id'];
//$cid = 'kmilive'; 
require_once "../../../assets/template/layout.top.print.php";
require_once ('../../../acc_mod/common/class.numbertoword.php');

$do_no=url_decode(str_replace(' ', '+', $_REQUEST['do_no']));

$master= find_all_field('sale_do_master','','do_no='.$do_no);

$marketing = find_all_field('marketing_person','','person_code='.$master->marketing_person);

  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

 $ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$title=$master->job_no;


		$sql = "select user_id, fname from user_activity_management where 1 group by user_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $fname[$info->user_id]=$info->fname;
		}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$master->job_no;?></title>
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
				  <img  src="report_head.png" width="100%"/>
				  
				  
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
  <p style="text-align:center; color:#FFF; font-size:18px; color:#687281; font-weight:bold; margin:0px; padding:10px 0px; text-transform:uppercase" >
  DEMAND ORDER</p>
 <!-- <hr  style="margin:0px; padding:0px;border:0.5px solid;" />-->
  
  </td></tr>
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="1" bordercolor="#687281" cellspacing="0" cellpadding="3"  style="font-size:14px; line-height:normal;">


		        <tr>
		          <td width="60%" align="left" valign="middle" style="font-size:20px;"><strong>Party Name :</strong> 
		            <?= $dealer->dealer_name_e;?></td>
		          <td width="40%" align="right"><strong><span style="font-size:20px;">Job No </span></strong><strong>: </strong><strong><span style="font-size:20px;"><?=$master->job_no;?></span></strong>
				  <? if($master->po_no!=""){?>
				  <br />
				 <span style="font-size:20px;"> <strong>PO No : <?= $master->po_no;?> </strong></span>
				  <? }?>
				  </td>
	              </tr>
		        <tr style="font-size:16px;">
		          <td align="left" valign="top" ><strong>Party Address :</strong>
		            <?= $master->dealer_address;?></td>
		          <td align="right"><strong>DO Date </strong><strong>: </strong><strong><?php echo date('d/m/Y',strtotime($master->do_date));?></strong></td>
	              </tr>
		        <tr style="font-size:16px;">
		          <td align="left" valign="middle"> <strong>Mobile No :</strong> 
		            <?= $dealer->contact_no;?></td>
		          <td align="right"><strong>Marketing Person :</strong>
                    <?= $marketing->marketing_person_name;?></td>
	              </tr>
		        <tr style="font-size:16px;">
		          <td align="left" valign="top" ><strong>Delivery Address :</strong>
                    <?= $master->delivery_address;?></td>
		          <td align="right"><strong>Mobile No :</strong>
                    <?= $marketing->mobile_no;?></td>
	              </tr>
		        <tr style="font-size:16px;">
		          <td align="left" valign="top" ><strong>Area :</strong>
                    <?=find_a_field('area','AREA_NAME','AREA_CODE='.$dealer->area_code);?></td>
		          <td align="right">Printing Date-Time:
                    <? $print_date=date('Y-m-d H:i:s');  ?>
                    <?=date("d/m/Y",strtotime($print_date)).' '.date("h:i A",strtotime($print_date));?></td>
	              </tr>
				
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
          <td width="3%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Code</strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Product </strong></td>
		 
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Length</strong></td>
          <td width="7%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty/Pcs</strong></td>
          
		
          <td width="9%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Pcs/Weight</strong></td>
          <td width="8%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty/Kg</strong></td>
          <td width="7%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Price/Kg</strong></td>
          <td width="12%"  align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Amount </strong></td>
          </thead>
        
        <?  
		
		 
		
		//$sql = "select id, ctn_type from sale_do_details where do_no='".$do_no."' group by id";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $ctn_type[$info->id]=$info->ctn_type;
//		}
		
		  $sqlc = 'select c.*, i.finish_goods_code, i.item_name from sale_do_details c, item_info i, item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' and c.total_unit>0 group by c.id order by  i.sub_group_id, i.item_id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			?>
        <tr style="font-size:13px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="center" valign="top"> <?=$datac->finish_goods_code?></td>
          <td align="left" valign="top" style=" white-space: nowrap;">
		  <?=$datac->item_name?> </td>
          <td align="left" valign="top" style=" white-space: nowrap;"><?=$datac->length?>'</td>
          <td align="right" valign="top"><?=number_format($datac->total_unit_pcs,2); $tot_total_unit_pcs += $datac->total_unit_pcs; ?></td>
          <td align="right" valign="top"><?=$datac->per_pcs_weight; ?></td>
          <td align="right" valign="top"><?=number_format($datac->total_unit,2); $tot_total_unit +=$datac->total_unit;?></td>
          <td align="right" valign="top"><?=number_format($datac->unit_price,2);?></td>
          <td align="right" valign="top"><?=number_format($datac->total_amt,2); $grand_total_amt +=$datac->total_amt; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:14px;">
        <td colspan="3" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_total_unit_pcs,2);?>
        </strong></td>
       
		
		
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong>
          <?=number_format($tot_total_unit,2);?>
        </strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong><?=number_format($grand_total_amt,2);?></strong></td>
        </tr>
        <tr style="font-size:14px; font-weight:700;">
          <td colspan="9" align="left" valign="middle">
		  
		  <?  
		$o=0;
		$itm_sql = 'select  s.sub_group_name, i.item_name, i.unit_name, sum(a.total_unit) as net_tot_unit from sale_do_details a, item_info i, item_sub_group s 
 		where i.item_id=a.item_id and i.sub_group_id=s.sub_group_id and a.do_no='.$do_no.' 
		 group by i.sub_group_id order by i.sub_group_id, i.item_id';
			$itm_query=db_query($itm_sql);
			while($itm_data= mysqli_fetch_object($itm_query)){
			$o++;
			if ($o>1) echo ', ';
			echo $itm_data->sub_group_name.'='.number_format($itm_data->net_tot_unit,2).' Kg';}?>		  </td>
          </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  <tr>
  
  	<td><strong>In Word:</strong> <? echo convertNumberMhafuz($grand_total_amt)?></td>
  
  </tr>
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  
	 <tr>
  
  	<td>
	<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
   <tr>
      <td colspan="4"><table width="100%" class="tabledesign" border="0" bordercolor="#000000" cellspacing="0" cellpadding="5" >
        
        
        <? 
		
		$sql = "select user_id, fname from user_activity_management where 1 group by user_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $fname[$info->user_id]=$info->fname;
		}
		 
		$sqlc = 'select approval_no, remarks, entry_by from sale_do_approval where do_no='.$do_no.' and remarks!="" group by id order by  entry_by';
		$queryc=db_query($sqlc);
		while($datac = mysqli_fetch_object($queryc)){	
		?>
        <tr style="font-size:14px;">
          <td align="left" valign="top"><strong>Remarks: </strong> <?=$datac->remarks;?><br />
		 <span style="font-style: italic;"><strong> Entry by:</strong> <?=$fname[$datac->entry_by]?></span> 		   </td>
           </tr>
        
        <? }?>
        
		
		
		
	
        
      </table></td>
		  <td colspan="3" width="30%">&nbsp;</td>
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
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="left" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center"><span style="font-size:14px;"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);?> </span></td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="left">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="left" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >-----------------------</td>
		  <td align="center">-----------------------</td>
		  <td align="center">-------------------------</td>
		  <td align="center">------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center" ><strong><span style="font-size:14px;">SUBMITTED BY </span></strong></td>
		  <td align="center"><strong><span style="font-size:14px;"> CHECKED BY </span></strong></td>
		  <td align="center"><strong><span style="font-size:14px;"> RECOMMENDED BY </span></strong></td>
		  <td align="center"><strong><span style="font-size:14px;"> AUTHORISED SIGNATURE </span></strong></td>
		  </tr>
		<tr>
		  <td align="center">(<?= $fname[$master->entry_by];?>)<br />
		  <span style="font-size:12px;"><?=date("d/m/Y",strtotime($master->entry_at)).' '.date("h:i A",strtotime($master->entry_at));?></span></td>
		  <td align="center"><? if($master->checked_by>0) {?> (<?= $fname[$master->checked_by];?>)<br />
		  <span style="font-size:12px;"><?=date("d/m/Y",strtotime($master->checked_at)).' '.date("h:i A",strtotime($master->checked_at));?></span> <? }?></td>
		  <td align="center"><? if($master->recommended_by>0) {?>(<?= $fname[$master->recommended_by];?>)<br />
		   <span style="font-size:12px;"><?=date("d/m/Y",strtotime($master->recommended_at)).' '.date("h:i A",strtotime($master->recommended_at));?></span> <? }?></td>
		  <td align="center"><? if($master->approve_by>0) {?> (<?= $fname[$master->approve_by];?>) <br />
		   <span style="font-size:12px;"><?=date("d/m/Y",strtotime($master->approve_at)).' '.date("h:i A",strtotime($master->approve_at));?></span><? }?></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    </tr>
		
		
		<tr>
            <td colspan="3" style="font-size:12px">&nbsp;</td>
		    <td>This is an ERP generated report </td>
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
