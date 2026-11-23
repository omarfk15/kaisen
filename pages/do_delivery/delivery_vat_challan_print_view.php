<?php

session_start();

//====================== EOF ===================

require_once "../../../assets/template/layout.top.php";
require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no          = $_REQUEST['v_no'];
$rft_type          = $_REQUEST['rft_type'];

$destination_count = find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$pack_unit_count   = find_a_field('sale_do_chalan','COUNT(pack_unit)','chalan_no="'.$chalan_no.'" and pack_unit!=""');

$do_no     = find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);
$master    = find_all_field('sale_do_master','','do_no='.$do_no);
$dealer    = find_all_field('dealer_info','','dealer_code="'.$master->dealer_code.'"');
$ch_data   = find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);
$marketing = find_all_field('marketing_person','','person_code='.$master->marketing_person);

$barcode_content = $chalan_no;
$barcodeText     = $barcode_content;
$barcodeType     = 'code128';
$barcodeDisplay  = 'horizontal';
$barcodeSize     = 40;
$printText       = '';

foreach($challan as $key=>$value){
    $$key=$value;
}

$com_data = find_all_field('user_group','','id='.$_SESSION['user']['group']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="bn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$master->job_no;?> - CH<?=$chalan_no;?></title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide() {
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

.header table tr td table tr td table tr td table tr td {
    color: #000;
}

@font-face {
    font-family: 'Andina Demo';
    src: url('Andina Demo.otf');
}

@font-face {
    font-family: 'SolaimanLipi';
    src: url('SolaimanLipi.ttf');
}

@font-face {
    font-family: 'adarshalipinormal';
    src: url('adarshalipinormal.TTF');
}

div.page_brack {
    page-break-after:always;
}

.tabledesign, .tabledesign th, .tabledesign td {
    border: 1px solid black;
    border-collapse: collapse;
}

body {
    font-family: "Metropolis", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #687281;
    text-align: left;
}
</style>
</head>
<body>

<div class="page_brack">
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
            <div id="pr">
                <div align="right">
                  <p>
                    <input name="button" type="button" onclick="hide();" value="Print" />
                  </p>
                </div>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="20%" align="left">
                     <img src="bangladesh-govt.png" height="50" />
                  </td>
                   <td width="60%" align="center">
                     <span style="font-size:20px;">“গণপ্রজাতন্ত্রী বাংলাদেশ সরকার”</span>
                  </td>
                   <td width="20%" align="right">
                      <span style="padding:5px 10px; border:1px solid #000000; font-weight:700;">মূসক-৬.৩</span>    
                  </td>
                </tr>
              </table></td>
          </tr>
          
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                   <td colspan="2" align="center">
                     <span style="font-size:18px; padding:0; margin:0;">জাতীয় রাজস্ব বোর্ড</span>                  </td>
                </tr>
                <tr>
                   <td colspan="2" align="center">
                     <span style="font-size:18px; font-weight:700; padding:0; margin:0;">কর চালান</span>                  </td>
                </tr>
                <tr>
                   <td colspan="2" align="center">
                     <span style="font-size:16px; padding:5px 0; margin:0;">[বিধি ৪০ এর উপ-বিধি (১) এর দফা (গ) ও দফা (চ) দ্রষ্টব্য]</span>                  </td>
                </tr>
                
                <tr>
                   <td width="40%" align="right">
                     <span style="font-size:16px; padding:5px 0; margin:0;">নিবন্ধিত ব্যক্তির নামঃ    </span>                  </td>
                   <td width="60%" align="left"><span style="font-size:16px; padding:0; margin:0; font-weight:700;">&nbsp;&nbsp;<?=$com_data->group_name?></span>    </td>
                </tr>
                
                <tr>
                   <td width="40%" align="right">
                     <span style="font-size:16px; padding:5px 0; margin:0;">নিবন্ধিত ব্যক্তির বিআইএনঃ </span>                  </td>
                   <td width="60%" align="left"><span style="font-size:16px; padding:0; margin:0; font-weight:700;">&nbsp;&nbsp;<?=$com_data->vat_reg?></span>    </td>
                </tr>
                
                <tr>
                   <td width="40%" align="right">
                     <span style="font-size:16px; padding:5px 0; margin:0;">চালানপত্র ইস্যুর ঠিকানাঃ </span>                  </td>
                   <td width="60%" align="left"><span style="font-size:16px; padding:0; margin:0; font-weight:700;">&nbsp;&nbsp;<?=$com_data->address?></span>    </td>
                </tr>
                
                <tr>
                  <td align="right">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>

  <br /><br />
  
  <tr> 
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100%" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td colspan="2" align="left" valign="middle" style="font-size:16px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr>
                      <td width="70%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size:16px;">
                            <tr>
                                <td width="28%">ক্রেতার নামঃ</td>
                                <td width="72%" align="left"><strong><?= $dealer->dealer_name_e?></strong></td>
                            </tr>
                            <tr>
                                <td width="28%">ক্রেতার বিআইএনঃ</td>
                                <td width="72%" align="left"><strong><?= $dealer->bin_no?></strong></td>
                            </tr>
                            <tr>
                                <td width="28%">ক্রেতার ঠিকানাঃ</td>
                                <td width="72%" align="left"><strong><?= $dealer->address_e?></strong></td>
                            </tr>
                            <tr>
                                <td width="28%">সরবরাহের গন্তব্যস্থলঃ</td>
                                <td width="72%" align="left"><strong><?= $master->delivery_address;?></strong></td>
                            </tr>
                            <tr>
                                <td width="28%" style="white-space:nowrap">যানবাহনের প্রকৃতি ও নম্বরঃ</td>
                                <td width="72%" align="left"><strong><?= $ch_data->vehicle_no?></strong></td>
                            </tr>
                        </table>
                      </td>
                      <td width="30%" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size:16px;">
                            <tr>
                                <td width="40%" style="white-space:nowrap">চালানপত্র নম্বরঃ</td>
                                <td width="60%" align="left"><strong><?=$ch_data->chalan_no_view ?></strong></td>
                            </tr>
                            <tr>
                                <td width="40%" style="white-space:nowrap">ইস্যুর তারিখঃ</td>
                                <td width="60%" align="left"><strong><?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></strong></td>
                            </tr>
                            <tr>
                                <td width="40%" style="white-space:nowrap">ইস্যুর সময়ঃ</td>
                                <td width="60%" align="left"><strong><?=date("h:i A",strtotime($ch_data->entry_at));?></strong></td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table> 
          </td>
        </tr>
      </table> 
    </td>
  </tr>
        
  <tr> <td>&nbsp; </td> </tr>
  
  <tr>
    <td>      
      <table width="100%" class="tabledesign" border="1" bordercolor="#687281" cellspacing="0" cellpadding="5" style="font-size:14px">
        <thead>
        <tr>
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>ক্রমিক</strong></td>
          <td width="27%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>পণ্য বা সেবার বর্ণনা (প্রযোজ্য ক্ষেত্রে ব্রান্ড নামসহ)</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>সরবরাহের একক</strong></td>
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>পরিমাণ</strong></td>
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>একক মূল্য<sup>১</sup> (টাকায়)</strong></td>
          <td width="7%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>মোট মূল্য<sup>১</sup> (টাকায়)</strong></td>
          <td width="7%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>সম্পুরক শুল্কের পরিমাণ (টাকায়)</strong></td>
          <td width="8%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>মূল্য সংযোজন করের হার / সুনির্দিষ্ট কর</strong></td>
          <td width="11%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>মূল্য সংযোজন কর / সুনির্দিষ্ট করের পরিমাণ (টাকায়)</strong></td>
          <td width="13%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>সকল প্রকার শুল্ক ও করসহ মূল্য</strong></td>
        </tr>
        </thead>
        
        <?php  
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
        
        $tot_total_unit = 0; 
        $sqlc = 'select c.*, i.item_name from sale_do_chalan c, item_info i, item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and c.chalan_no='.$chalan_no.' and c.total_unit>0 group by c.id order by c.id';
        $queryc=db_query($sqlc);
        while($datac = mysqli_fetch_object($queryc)){
        ?>
        <tr style="font-size:13px;">
          <td align="center" valign="top"><?=++$kk;?></td>
          <td align="left" valign="top" style="white-space: nowrap;"><?=$datac->item_name?> <?=$datac->length?>' = <?=$datac->total_unit_pcs;?> Pcs</td>
          
          <!-- সরবরাহের একক -->
          <td align="center" valign="top" style="white-space: nowrap;">
            <?php if ($master->order_type == 'RFT' && $rft_type == 1) { ?>
                RFT
            <?php } else { ?>
                Kg
            <?php } ?>
          </td> 
         
          <!-- পরিমাণ -->
          <td valign="top" style="white-space: nowrap;" align="right">
            <?php if ($master->order_type == 'RFT' && $rft_type == 1) { ?>
                <?=number_format($datac->total_unit_rft,2); $tot_total_unit += $datac->total_unit_rft; ?>
            <?php } else { ?>
                <?=number_format($datac->total_unit,2); $tot_total_unit += $datac->total_unit; ?>
            <?php } ?>
          </td>

          <!-- একক মূল্য (শর্তানুসারে কাস্টমাইজড) -->
          <td align="center" valign="top" style="white-space: nowrap;">
            <?php 
              if ($master->order_type == 'RFT' && $rft_type == 1) {
                  $unit_qty = $datac->total_unit_rft;
              } else {
                  $unit_qty = $datac->total_unit;
              }
              
              $price_without_vat = ($unit_qty > 0) ? ($datac->amt_without_vat / $unit_qty) : 0;
              echo number_format($price_without_vat, 2);
            ?>
          </td>

          <td align="right" valign="top" style="white-space: nowrap;"><?=number_format($datac->amt_without_vat,2); $tot_amt_without_vat +=$datac->amt_without_vat?></td>
          <td align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">15.00</td>
          <td align="right" valign="top"><?=number_format($datac->vat_amt,2); $grand_vat_amt +=$datac->vat_amt; ?></td>
          <td align="right" valign="top"><?=number_format($datac->total_amt,2); $grand_total_amt +=$datac->total_amt; ?></td>
        </tr>
        <?php } ?>

        <tr style="font-size:14px;">
          <td align="right" valign="middle">&nbsp;</td>
          <td align="center" valign="middle"><strong>মোট=</strong></td>
          
          <td align="center" valign="middle">
            <span style="white-space: nowrap;"><strong>
            <?php if ($master->order_type == 'RFT' && $rft_type == 1) { ?>
                RFT
            <?php } else { ?>
                Kg
            <?php } ?>
            </strong></span>
          </td>
          
          <td align="right" valign="middle">
            <strong><?=number_format($tot_total_unit,2);?></strong>
          </td>

          <td align="right" valign="middle">&nbsp;</td>
          <td align="right" valign="middle"><strong><?=number_format($tot_amt_without_vat,2);?></strong></td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="right" valign="middle"><strong><?=number_format($grand_vat_amt,2);?></strong></td>
          <td align="right" valign="middle"><strong><?=number_format($grand_total_amt,2);?></strong></td>
        </tr>
      </table>
    </td>
  </tr>

  <tr><td>&nbsp;</td></tr>

  <tr>
    <td>
      <div class="footer"> 
        <table width="100%" cellspacing="0" cellpadding="0" style="line-height:normal;">
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td align="left"><span style="font-size:16px;">প্রতিষ্ঠান কতৃপক্ষের দায়িত্বপ্রাপ্ত ব্যক্তির নামঃ &nbsp;<strong>Muhammad Anas</strong></span></td>
            </tr>
            <tr><td align="center">&nbsp;</td></tr>
            <tr>
              <td align="left"><span style="font-size:16px;">পদবীঃ &nbsp;<strong>Sr. Executive (F & A)</strong></span></td>
            </tr>
            <tr><td align="center">&nbsp;</td></tr>
            <tr>
              <td align="left"><span style="font-size:16px;">স্বাক্ষরঃ</span></td>
            </tr>
            <tr style="font-size:12px"><td align="center">&nbsp;</td></tr>
            <tr>
              <td align="Left"><span style="font-size:16px;">সীলঃ</span></td>
            </tr>
            <tr style="font-size:12px"><td align="center">&nbsp;</td></tr>
            <tr>
              <td align="left"><span style="font-size:16px;">*উৎস্য কর্তনযোগ্য সরবরাহের ক্ষেত্রে ফরমটি সমন্বিত কর চালানপত্র ও উৎসে কর কর্তন সনদপত্র হিসেবে বিবেচিত এবং উৎসে কর কর্তনযোগ্য সরবরাহের ক্ষেত্রে প্রযোজ্য হবে।</span></td>
            </tr>
            <tr><td align="left">&nbsp;</td></tr>
            <tr>
              <td align="left">
                <span style="font-size:16px; white-space:nowrap; border-top:1px solid #000000;">১ সকল প্রকার কর ব্যতীত মূল্যঃ”</span>
                <span style="font-size:16px; white-space:nowrap; border-top:1px solid #000000; border-bottom:2px double #000000; font-weight:700; padding-left:50px; padding-right:20px;">
                    <?=number_format($tot_amt_without_vat,2);?>
                </span>
              </td>
            </tr>
            <tr><td align="left">&nbsp;</td></tr>
        </table>
      </div>
    </td>
  </tr>
  </tbody>
</table>
</div>

</body>
</html>