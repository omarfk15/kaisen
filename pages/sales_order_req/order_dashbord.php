<?php
session_start();
ob_start();
require_once "../../../assets/support/inc.all.php";
$title = "Dashboard";
?>




<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>  </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
	
	
	
	
	 <script src="../../../assets/js/loader.js"></script>
	
	
	<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../../../assets/css/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../../../assets/css/dash_2.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
   
 
 
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../../assets/css/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
	
	
 <style type="text/css">
 	.card-title{
		text-align:left;
		font-size: 14px;
		color:#004085;
		margin: 0px;
	}
	
	.card-title span{
		font-weight: normal;
		color:#605d5d;
	}
	
	.bold{
		font-weight:bold;
	}
	
	.button-cs{
		padding:0px !important;
		font-size: 12px !important;
	}
	
	.new{
	    padding-left: 8px;
    	padding-right: 8px;
	}
	.new-icon{
	    width: 50px;
		height: 50px;
		background: #dfe9f3;
		border-radius: 50%;
		color: #007bff;
		text-align: center;
		padding: 8px;
		font-size: 25px;
	}
	
	.primary{
	    background-color: whitesmoke !important;
    	color: #007bff !important;
	}
	
		
	.success{
	    background-color: #cfffcf !important;
    	color: #3cb514 !important;
	}
	
		
	.danger{
	    background-color: #ffe9eb !important;
    	color: #dc3545 !important;
	}
	
		
	.info{
	    background-color: #dbfaff !important;
    	color: #17a2b8 !important;
	}
	
	.new-icon-text{
		padding-left: 10px;
		color: #333;
		font-size: 16px;
		padding-top: 3px;
	}
	
	.p-sub, .p-sub1{
	    margin: 0px;
	}
	
	.p-sub{
		color:#1a1972;
	}
	
	.p-sub1{
		font-size: 12px;
	}
	
	.p-sub1 span{
		font-weight:bold;
		color:#28a745;
	}
	
	.btn:hover, .a{
	color:#fff !important;
	}
	
 </style>
</head>


<?php   

  $date_today=date('Y-12-d');
  
   		 $sql = "select sum(j.dr_amt-j.cr_amt) as cash_balance  from accounts_ledger a, journal j
		where  a.ledger_id=j.ledger_id and a.ledger_group_id=1009 and j.jv_date <='".$date_today."' ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cash_balance=$info->cash_balance;
		 }
		 
		 $sql = "select  sum(j.dr_amt-j.cr_amt) as cd_closing_amt from bank_ledger b, journal j where b.ledger_id=j.ledger_id
		and b.account_type!=2 and j.jv_date <='".$date_today."'  ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cd_closing_amt=$info->cd_closing_amt;
		}
		
		$sql = "select  sum(j.dr_amt-j.cr_amt) as cc_closing_amt from bank_ledger b, journal j where b.ledger_id=j.ledger_id
		and b.account_type=2 and j.jv_date <='".$date_today."'  ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cc_closing_amt=$info->cc_closing_amt;
		}
 
 ?>


<div class="main-container" id="container">

     

        <!--  BEGIN SIDEBAR  -->
        
        <!--  END SIDEBAR  -->
		
		<div class="main-content pt-3 pb-3">
			<div class="row m-0 p-0">
			
			<?php   

 if($_REQUEST['sales_year']==''){
 $fdate=date('Y-01-01');
 $tdate=date('Y-12-31');
 $year=date('Y');
 $yr=date('y');
 }else{
 $fdate=$_REQUEST['sales_year'].'-01-01';
 $tdate=$_REQUEST['sales_year'].'-12-31';
 $year = date('Y',strtotime($fdate));
 $yr = date('y',strtotime($fdate));
 }
 
 ?>
			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Catroon<span> || Year <?php echo $year;?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary"><i class="fas fa-dollar-sign"></i></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold"> 928,050.00</p>
							<p class="p-sub1"> Currency <span>USD</span></p>
						 </div>
						
						</div>
						<a href="do_master.php?sales_type=1" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-primary button-cs"> <i class="fas fa-check-circle"></i> New Order</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Poly<span> || Year <?php echo $year;?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon success"><i class="fas fa-dollar-sign"></i></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">
							 <?php if($cash_balance>0) echo number_format($cash_balance,2).' (Dr)'; elseif($cash_balance<0) echo number_format(((-1)*$cash_balance),2).' (Cr)';else echo "0.00"; ?></p>
							<p class="p-sub1"> Currency <span>USD</span></p>
						 </div>
						
						</div>
						
						<a href="#" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-success button-cs"> <i class="fas fa-check-circle"></i> View Details</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Gumtape <span> || Year <?php echo $year;?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><i class="fas fa-dollar-sign"></i></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold"> 
							 <?php if($cd_closing_amt>0) echo number_format($cd_closing_amt,2).' (Dr)'; elseif($cd_closing_amt<0) echo number_format(((-1)*$cd_closing_amt),2).' (Cr)';else echo "0.00"; ?>
							</p>
							<p class="p-sub1"> Currency <span>USD</span></p>
						 </div>
						
						</div>
						
						<a href="#" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-danger button-cs"> <i class="fas fa-check-circle"></i> View Details</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Ofset<span> || Year <?php echo $year;?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon info"><i class="fas fa-dollar-sign"></i></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">
							<?php if($cc_closing_amt>0) echo number_format($cc_closing_amt,2).' (Dr)'; elseif($cc_closing_amt<0) echo number_format(((-1)*$cc_closing_amt),2).'(Cr)';else echo "0.00"; ?>
							</p>
							<p class="p-sub1"> Currency <span>USD</span></p>
						 </div>
						
						</div>
						
						<a href="#" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-info button-cs"> <i class="fas fa-check-circle"></i> View Details</button>
						</a>
					  </div>
					</div>
				</div>




			</div>
		</div>
		
		
		
		<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">

			<div class="col-8">
              <div class="card">
			  
			  <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
					
					<?php
						 $sql = 'select * from year where 1';
						$query = db_query($conn,$sql);
						while ($data = mysqli_fetch_object($query)) {

					?>
					<li><a class="dropdown-item" href="home.php?sales_year=<?php echo $data->year;?>"><?php echo $data->year;?></a></li>
					 <?php }?>

                   
                  </ul>
                </div>
			  
            <div class="card-body">
<?php   

 if($_REQUEST['sales_year']==''){
 $fdate=date('Y-01-01');
 $tdate=date('Y-12-31');
 $year=date('Y');
 $yr=date('y');
 }else{
 $fdate=$_REQUEST['sales_year'].'-01-01';
 $tdate=$_REQUEST['sales_year'].'-12-31';
 $year = date('Y',strtotime($fdate));
 $yr = date('y',strtotime($fdate));
 }
 
 ?>
              <h5 class="card-title bold">Monthly Sales Bar Chart <span>| Year <?php echo $year;?></span></h5>
	  <?php   

 		 $sql = "select year(m.do_date) as year, month(m.do_date) as mon, sum(s.total_amt) as sales_amt from sale_do_master m, sale_do_chalan s, item_info i 
		where m.do_no=s.do_no and s.item_id=i.item_id and m.do_date between '".$fdate."' and '".$tdate."'  group by  month(m.do_date), year(m.do_date)";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->year][$info->mon]=$info->sales_amt;
		 }	  
	 
	  ?>

              <!-- Bar Chart -->
              <canvas id="barChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#barChart'), {
                    type: 'bar',
                    data: {
                      labels: ['Jan <?php echo $yr?>', 'Feb <?php echo $yr?>', 'Mar <?php echo $yr?>', 'Apr <?php echo $yr?>', 'May <?php echo $yr?>', 'Jun <?php echo $yr?>', 'Jul <?php echo $yr?>', 'Aug <?php echo $yr?>', 'Sep <?php echo $yr?>', 'Oct <?php echo $yr?>', 'Nov <?php echo $yr?>', 'Dec <?php echo $yr?>'],
                      datasets: [{
                        label: 'Sales Chart',
                        data: [<?php echo $sales_amt[$year][1]; ?>, <?php echo $sales_amt[$year][2]; ?>, <?php echo $sales_amt[$year][3]; ?>, <?php echo $sales_amt[$year][4]; ?>, <?php echo $sales_amt[$year][5]; ?>, <?php echo $sales_amt[$year][6]; ?>, <?php echo $sales_amt[$year][7]; ?>, <?php echo $sales_amt[$year][8]; ?>, <?php echo $sales_amt[$year][9]; ?>, <?php echo $sales_amt[$year][10]; ?>, <?php echo $sales_amt[$year][11]; ?>, <?php echo $sales_amt[$year][12]; ?>],
                        backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'rgba(255, 205, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                          'rgb(255, 99, 132)',
                          'rgb(255, 159, 64)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)',
                          'rgb(54, 162, 235)',
                          'rgb(153, 102, 255)',
                          'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }

                    }
                  });
                });
              </script>
              <!-- End Bar CHart -->

            </div>
          </div>
            </div>


        <div class="col-lg-4">

        <div class="card">
		
		<div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
					
					<?php
						 $sql = 'select * from year where 1';
						$query = db_query($conn,$sql);
						while ($data = mysqli_fetch_object($query)) {

					?>
					<li><a class="dropdown-item" href="home.php?sales_year=<?php echo $data->year;?>"><?php echo $data->year;?></a></li>
					 <?php }?>

                   
                  </ul>
                </div>
		
            <div class="card-body">
			
<?php   

if($_REQUEST['sales_year']==''){
$fdate=date('Y-01-01');
$tdate=date('Y-12-31');


$fdate_q1=date('Y-01-01');
$tdate_q1=date('Y-03-31');

$fdate_q2=date('Y-04-01');
$tdate_q2=date('Y-06-30');

$fdate_q3=date('Y-07-01');
$tdate_q3=date('Y-09-30');

$fdate_q4=date('Y-10-01');
$tdate_q4=date('Y-12-31');

$year=date('Y');
$current_yr=date('y');
}else{
$fdate_q1=$_REQUEST['sales_year'].'-01-01';
$tdate_q1=$_REQUEST['sales_year'].'-03-31';

$fdate_q2=$_REQUEST['sales_year'].'-04-01';
$tdate_q2=$_REQUEST['sales_year'].'-06-30';

$fdate_q3=$_REQUEST['sales_year'].'-07-01';
$tdate_q3=$_REQUEST['sales_year'].'-09-30';

$fdate_q4=$_REQUEST['sales_year'].'-10-01';
$tdate_q4=$_REQUEST['sales_year'].'-12-31';

$year = date('Y',strtotime($fdate_q1));
$current_yr = date('y',strtotime($fdate_q1));
}
  
?>
			
			
              <h5 class="card-title bold">Sales Chart <span>| Year <?php echo $year;?></span></h5>
			  
			  
<?php 

		 $sql = "select sum(s.total_amt) as adv_sales_amt  from sale_do_master m, sale_do_chalan s, item_info i 
		where  m.do_no=s.do_no and s.item_id=i.item_id and m.do_date between '".$fdate."' and '".$tdate."' and m.do_type='ADVANCE'";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $adv_sales_amt=$info->adv_sales_amt;
		 }
		 
		 $sql = "select sum(s.total_amt) as reg_sales_amt  from sale_do_master m, sale_do_chalan s, item_info i 
		where  m.do_no=s.do_no and s.item_id=i.item_id and m.do_date between '".$fdate."' and '".$tdate."' and m.do_type='REGULAR'";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $reg_sales_amt=$info->reg_sales_amt;
		 }
		 
		 $sql = "select sum(s.total_amt) as oth_sales_amt  from sale_do_master m, sale_do_chalan s, item_info i 
		where  m.do_no=s.do_no and s.item_id=i.item_id and m.do_date between '".$fdate."' and '".$tdate."' and m.do_type NOT IN ('ADVANCE','REGULAR')";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $oth_sales_amt=$info->oth_sales_amt;
		 }
		 
		 $sql = "select sum(s.total_amt) as tot_sales_amt  from sale_do_master m, sale_do_chalan s, item_info i 
		where  m.do_no=s.do_no and s.item_id=i.item_id and m.do_date between '".$fdate."' and '".$tdate."' ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $tot_sales_amt=$info->tot_sales_amt;
		 }
		 
		 
		 $q1_percent=round(($adv_sales_amt/$tot_sales_amt)*100);
		 $q2_percent=round(($reg_sales_amt/$tot_sales_amt)*100);
		 $q3_percent=round(($oth_sales_amt/$tot_sales_amt)*100);
		 $q4_percent=0;


?>

              <!-- Pie Chart -->
              <div id="pieChart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#pieChart"), {
                    series: [<?php echo $q1_percent;?>, <?php echo $q2_percent;?>, <?php echo $q3_percent;?>],
                    chart: {
                      height: 350,
                      type: 'pie',
                      toolbar: {
                        show: true
                      }
                    },
                    labels: ['ADVANCE, <?php echo $current_yr;?>', 'REGULAR, <?php echo $current_yr;?>', 'OTHER, <?php echo $current_yr;?>']
                  }).render();
                });
              </script>
              <!-- End Pie Chart -->
			  
	<div class="list-group" >
 
  <a href="#" class="list-group-item list-group-item-action list-group-item-primary"><strong>ADVANCE SALES: <?=number_format($adv_sales_amt,2);?></strong></a>
 
  <a href="#" class="list-group-item list-group-item-action list-group-item-success"><strong>REGULAR SALES: <?=number_format($reg_sales_amt,2);?></strong></a>
  
  <a href="#" class="list-group-item list-group-item-action list-group-item-warning"><strong>OTHER SALES: <?=number_format($oth_sales_amt,2);?></strong></a>
  <a href="#" class="list-group-item list-group-item-action list-group-item-secondary"><strong>TOTAL SALES: <?=number_format($tot_sales_amt,2);?></strong></a>
</div>

            </div>
			
			 
			
			
          </div>
		  
	
		  
		
		  

        </div>
					
					
					
					
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
	<script src="chart.js/chart.umd.js"></script>
	<script src="apexcharts/apexcharts.min.js"></script>

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>