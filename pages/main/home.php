<?php
session_start();
ob_start();
require_once "../../../assets/support/inc.all.php";
$title='Deshboard';

		$f_date=date('Y-m-01');
		$t_date=date('Y-m-31');

		// $sql = "select sum(c.total_unit) as total_weight, sum(c.total_amt) as total_amt, sum(c.vat_amt) as vat_amt,  sum(c.amt_without_vat) as amt_without_vat
//		  from sale_do_chalan c, item_info i 
//		where c.item_id=i.item_id and c.chalan_date BETWEEN '".$f_date."' AND '".$t_date."'";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $total_weight_kg=$info->total_weight;
//		 $total_amt=$info->total_amt;
//		 $vat_amt=$info->vat_amt;
//		 $amt_without_vat=$info->amt_without_vat;
//		}
//		
//		
//		
//		$sql = "select sum(j.cr_amt) as collection_amt from journal j, accounts_ledger a 
//		where j.ledger_id=a.ledger_id and j.jv_date BETWEEN '".$f_date."' AND '".$t_date."' and j.tr_from='Receipt' and j.note='Collection' ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $collection_amt=$info->collection_amt;
//		}
//		
//		
//		
//		
//		$sql = "select m.meal_id, sum(m.meal_unit) as meal_count, sum(m.type_a+m.type_b+m.type_c+m.type_d) as meal_amt 
//		from meal_issue_detail m, personnel_basic_info p 
//		where m.pbi_id=p.PBI_ID and m.pi_date='".$today_date."' group by m.meal_id";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $meal_count[$info->meal_id]=$info->meal_count;
//		 $meal_amt[$info->meal_id]=$info->meal_amt;
//		}


?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<title><?=$title?></title>
<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
<script src="assets/js/loader.js"></script>

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<script>
window.onload = function () {

var options = {
	animationEnabled: false,
	data: [{
		type: "pie",
		startAngle: 40,
		toolTipContent: "<b>{label}</b>: {y}%",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 12,
		indexLabel: "{label} - {y}%",
		dataPoints: [
			{ y: <?=number_format($first_percentage, 2)?>, label: "Regular Sale" },
			{ y: <?=number_format($second_percentage, 2)?>, label: "POS Sale" },
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);
$(".canvasjs-chart-credit").remove();
}
</script>
</head>
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
}
.style2 {font-size: 24px}
-->
</style>
<div class="main-container" id="container"> 
  
  <!--  BEGIN SIDEBAR  --> 
  
  <!--  END SIDEBAR  -->
  
  <div id="content" class="main-content">
    <div class="layout-px-spacing">
	<!--<h5 style="padding:0px 0px 10px 0px; margin:0px;">Meal Register</h5>-->
	<?php /*?><div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-primary">
              <div class="inner">
			  
                <h3><span class="info-box-icon"><i class="fa fa-users" aria-hidden="true"></i></span> 
				<? if($emp_count[1]>0){
				echo $emp_count[1];
				}else{
				echo 0;
				}?></h3>

                <p>Total <?=$meal_name[1];?></p>
              </div>
              <div class="icon1">
                
              </div>
              <a href="../setup/meal_register_status.php?meal_type=1" target="_blank" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><span class="info-box-icon"><i class="fa fa-users" aria-hidden="true"></i></span> 
				<? if($emp_count[2]>0){
				echo $emp_count[2];
				}else{
				echo 0;
				}?>
				</h3><!--<sup style="font-size: 20px">%</sup></h3>-->

                <p>Total <?=$meal_name[2];?></p>
              </div>
              <div class="icon1">
                
              </div>
              <a href="../setup/meal_register_status.php?meal_type=2" target="_blank" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><span class="info-box-icon"><i class="fa fa-users" aria-hidden="true"></i></span> 
				<? if($emp_count[3]>0){
				echo $emp_count[3];
				}else{
				echo 0;
				}?>
				</h3>

                <p>Total <?=$meal_name[3];?></p>
              </div>
              <div class="icon1">
                
              </div>
              <a href="../setup/meal_register_status.php?meal_type=3" target="_blank" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><span class="info-box-icon"><i class="fa fa-users" aria-hidden="true"></i></span>  
				<? if($emp_count[4]>0){
				echo $emp_count[4];
				}else{
				echo 0;
				}?>
				</h3>

                <p>Total <?=$meal_name[4];?></p>
              </div>
              <div class="icon1">
                
              </div>
              <a href="../setup/meal_register_status.php?meal_type=4" target="_blank" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
        </div><?php */?>
		
		
		<!--Deshbook Block-->
		
		
		<h5 style="padding:0px 0px 10px 0px; margin:0px;">Sales Deshboard</h5>
	<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-primary">
              <div class="inner">
			  <p style="font-size:16px;"><strong>Gross Sales</strong></p>
                <h3 style="font-size:24px; margin:0px;"><span class="info-box-icon"><i class="fa fa-cubes" aria-hidden="true"></i></span> 
				<?=number_format($total_weight_kg,2);?> KG</h3>
				
				<h3 style="font-size:20px; margin:0px;" ><span class="info-box-icon"><img src="taka-sign.svg" width="15px;"></span> 
				<?=number_format($total_amt,2); ?></h3>
                
              </div>
              <div class="icon1">
                
              </div>
              <a href="<?php /*?>../setup/meal_statement.php?meal_type=1&fdate=<?=$today_date;?>&tdate=<?=$today_date;?><?php */?>" target="_blank" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
			  <p style="font-size:16px;"><strong>VAT</strong></p>
                <h3 style="font-size:24px; margin:0px;"><span class="info-box-icon"><img src="taka-sign.svg" width="15px;"></span> 
				<?=number_format($vat_amt,2);?> VAT</h3>
				
				<h3 style="font-size:20px; margin:0px;" ><span class="info-box-icon"><img src="taka-sign.svg" width="15px;"></span> 
				<?=number_format($amt_without_vat,2); ?> Net  </h3>

                
              </div>
              <div class="icon1">
                
              </div>
              <a href="" target="_blank" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
			   <p style="font-size:16px;"><strong>Collection</strong></p>
                <h3 style="font-size:24px; margin:0px;"><span class="info-box-icon"><img src="taka-sign.svg" width="15px;"></span> 
				<?=number_format($collection_amt,2);?> </h3>
				
				<h3 style="font-size:20px; margin:0px;" ><br></h3>

               
              </div>
              <div class="icon1">
                
              </div>
              <a href="" target="_blank" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
			  <p style="font-size:16px;"><strong>Receivable</strong></p>
                 <h3 style="font-size:24px; margin:0px;"><span class="info-box-icon"><img src="taka-sign.svg" width="15px;"></span>  
				<?=number_format($receivable_amt,2);?> </h3>
				</h3>

                <h3 style="font-size:20px; margin:0px;" ><br></h3>
              </div>
              <div class="icon1">
                
              </div>
              <a href="" target="_blank" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
		  </div>
		  
		  
		    <!--Deshbook Block-->
		  
          <!-- ./col -->
        </div>
		
    </div>
  </div>
  
  

  
  <!--  BEGIN CONTENT AREA  --> 
  
  <!--  END CONTENT AREA  --> 
  
</div>

<!-- BEGIN GLOBAL MANDATORY SCRIPTS --> 
<script src="assets/js/libs/jquery-3.1.1.min.js"></script> 
<script src="bootstrap/js/popper.min.js"></script> 
<script src="bootstrap/js/bootstrap.min.js"></script> 
<script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script> 
<script src="assets/js/app.js"></script> 
<script>
        $(document).ready(function() {
            App.init();
        });
    </script> 
<script src="assets/js/custom.js"></script> 
<!-- END GLOBAL MANDATORY SCRIPTS --> 

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 
<script src="plugins/apex/apexcharts.min.js"></script> 
<script src="assets/js/dashboard/dash_1.js"></script> 
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 
<script src="plugins/apex/apexcharts.min.js"></script> 
<script src="assets/js/dashboard/dash_2.js"></script> 
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 

<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script> 
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>
