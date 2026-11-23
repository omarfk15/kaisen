<?php
ini_set('display_errors', 0);
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

session_start();
ob_start();

require_once('configuration/server_connect.php');
require_once('configuration/all_function.php');

$active_id=$_REQUEST['active_id'];
$menu_id=$_REQUEST['menu_id'];

 // Common Information

$page_title="GL Account";
$page="04_acc_ledger.php?active_id=".$active_id."&menu_id=".$menu_id."";
$table='accounts_ledger';	
$unique='ledger_id';

$request_id=$_REQUEST['ledger_id'];

$ms_data=mysqli_fetch_object(mysqli_query($conn,'select * from '.$table.' where ledger_id="'.$request_id.'"'));

// End Common Information

if(isset($_POST['insert']))

{		

$_POST['entry_by'] = $_SESSION['user']['id'];
		 
$_POST['entry_at'] = $now=date('Y-m-d H:i:s');

$ledger_name = $_POST['ledger_name'];
$ledger_group_id = $_POST['ledger_group_id'];

$grp_sql="SELECT * FROM ledger_group  WHERE group_id='".$ledger_group_id."'";
$grp_data = find_all_field_sql($conn,$grp_sql);

$cy_id=mysqli_fetch_object(mysqli_query($conn,'select max(ledger_sl) as ledger_sl from '.$table.' where ledger_group_id="'.$ledger_group_id.'"'));
$ledger_sl_id=$cy_id->ledger_sl+1;
$ledger_sl_no = sprintf("%05d", $ledger_sl_id);

$ledger_id = $ledger_group_id.''.$ledger_sl_no;

  $ins_sql = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, entry_by, entry_at) VALUES

("'.$ledger_id.'", "'.$ledger_sl_no.'", "'.$ledger_name.'", "'.$ledger_group_id.'", "'.$grp_data->acc_class.'", "'.$grp_data->acc_sub_class.'", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';
	
mysqli_query($conn,$ins_sql);

?>

<script language="javascript">
window.location.href = "<?php echo $page;?>";
</script>

<?php

}



if(isset($_POST['update']))

{		

$_POST['entry_by'] = $_SESSION['user']['id'];
		 
$_POST['entry_at'] = $now=date('Y-m-d H:i:s');

$ledger_name = $_POST['ledger_name'];

$ledger_id=$request_id;

$up_sql = 'update accounts_ledger set ledger_name="'.$ledger_name.'", edit_by="'.$_POST['entry_by'].'", edit_at="'.$_POST['entry_at'].'" 
 where ledger_id='.$ledger_id;
mysqli_query($conn,$up_sql);


?>

<script language="javascript">
window.location.href = "<?php echo $page;?>";
</script>

<?php

}

?>


<!DOCTYPE html>
<html lang="en">

<!-- ======= <head> ======= -->
 <?php require_once('inc_files/inc_head.php'); ?>
<!-- ======= </head> ======= -->

<body>

  <!-- ======= Header ======= -->
  <?php require_once('inc_files/inc_header.php'); ?><!-- End Header -->

  <!-- ======= Sidebar ======= -->
   <?php  require_once('inc_files/inc_menu.php'); ?>
   <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?php echo $page_title;?></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item">General Ledger</li>
          <li class="breadcrumb-item active"><?php echo $page_title;?></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-8"> 

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo $page_title;?> </h5>
              

              <!-- Table with stripped rows -->
              <table class="table" id="data_table" style="font-size:14px;">
                <thead>
                  <tr>
                    <th scope="col"><span class="card-title">GL Code</span></th>
                    <th scope="col"><span class="card-title">GL Account</span></th>
                    <th scope="col"><span class="card-title">Account Group</span></th>
                  </tr>
                </thead>
                <tbody>
		<?php
		
		 $sql = "select group_id, group_name from ledger_group where 1 group by group_id";
		 $query = mysqli_query($conn,$sql);
		 while($info=mysqli_fetch_object($query)){
  		 $group_name[$info->group_id]=$info->group_name;
	
		}	
					
						$sql = 'select * from '.$table.' where 1';
						$query = mysqli_query($conn,$sql);
						
						//while ($data = mysqli_fetch_object($query)) {

					?>
					
					<?php $i = 1; ?>
				<?php foreach($query as $row) : ?>
    <tr>
       <td><a href="<?php echo $page;?>&<?php echo $unique;?>=<?php echo $row["ledger_id"];?>" style="color:#000000"><?php echo $row["ledger_id"]; ?> </a></td>
      <td><a href="<?php echo $page;?>&<?php echo $unique;?>=<?php echo $row["ledger_id"];?>" style="color:#000000"><?php echo $row["ledger_name"]; ?></a></td>
 <td><a href="<?php echo $page;?>&<?php echo $unique;?>=<?php echo $row["ledger_id"];?>" style="color:#000000"><?php echo $group_name[$row["ledger_group_id"]];?></a></td>
                  </tr>
				 <?php endforeach; ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>

        <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo $page_title;?></h5>

              <!-- Multi Columns Form -->
              <form class="row g-3" action="" method="post" name="form1" id="form1" onSubmit="return check()">
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">GL Account </label>
                   <input type="text" class="form-control" id="ledger_name" name="ledger_name" value="<?php if($request_id>0){ echo $ms_data->ledger_name; } ?>" required>
                </div>
				
				
				
				<div class="col-12">
                  <label for="inputAddress2" class="form-label">Account Group </label>
				  
 <script>
 function func_recycle(){
 var get_poly_type=document.getElementById("ledger_group_id").value;
 if(get_poly_type==11002){
 document.getElementById("rec_perc").style.display="block";
  document.getElementById("rec_perc").style.display=" ";
 }
 else{
  document.getElementById("rec_perc").style.display="none";
 }
 }
 </script>
        
			<?php if($request_id>0){?>
			<select id="ledger_group_id" name="ledger_group_id" required class="form-select" >
			
				<?php foreign_relation($conn,'ledger_group','group_id','group_name',$_POST['ledger_group_id'],'group_id="'.$ms_data->ledger_group_id.'"');?>
		
		
        	</select>
			<?php } else {?>
		
		<select id="ledger_group_id" name="ledger_group_id" required class="form-select" onChange="func_recycle()" >
			<option></option>
	
			<?php foreign_relation($conn,'ledger_group g, acc_sub_class c','g.group_id','concat(g.group_name," >>> [",c.sub_class_name,"]")',$_POST['ledger_group_id'],'g.acc_sub_class=c.id order by g.acc_class, g.acc_sub_class, g.group_id');?>
		
        	</select>
		
		
			<?php }?>
			
			<span id="rec_perc" style="display:none;">
<input  type="text" name="recycle_percentage" id="recycle_percentage" class="input3" style="width:80px;  height:30px;" 
    value="<?=$do_data->recycle_percentage;?>"  autocomplete="off"   tabindex="0"> 
	</span>
                </div>
				
				
				
				
			<div class="col-12">
                  <label for="inputAddress2" class="form-label">Account Sub Class </label>
				  
			<select id="acc_sub_class" name="acc_sub_class" required class="form-select"  onChange="showuser(this.value)">
			<option></option>
				<?php foreign_relation($conn,'acc_sub_class','id','sub_class_name',$ms_data->acc_sub_class,'1 order by id');?>
		
		
        	</select>
			
                </div>	
				
				
				<div class="col-12">
                  <label for="inputAddress2" class="form-label">Account Class </label>
			
				<div id="filter_data"></div>
			
                </div>
				
				<script>
					function showuser(str){
						if(str == ''){
							document.getElementById('filter_data').innerHTML = '';
							return
						}
						const xhttp = new XMLHttpRequest();
						xhttp.onload = function(){
							document.getElementById('filter_data').innerHTML = this.responseText;
						}
						
						xhttp.open('GET', 'gettext.php?id='+str);
						xhttp.send();
					
					}
				</script>
				
	
                
                
                 <div class="text-center">
				<?php if($request_id>0) {?>
                 <button type="submit" class="btn btn-success btn-sm" name="update" id="update" ><i class="bi bi-check-all"></i> Update &nbsp;</button>
				 <?php }else {?>
				 <button type="submit" class="btn btn-primary btn-sm" name="insert" id="insert" ><i class="bi bi-plus"></i> Save &amp; New &nbsp;</button>
				 <?php }?>
                  <button type="reset" class="btn btn-secondary btn-sm" onClick="parent.location='<?php echo $page?>'" >Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

          

          

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
 <?php require_once('inc_files/inc_footer.php'); ?>
<!-- ======= Footer ======= -->
<script>
var printCounter = 0;
 
new DataTable('#data_table', {
    caption: "&copy; Copyright <?php echo $grp_data->group_name?> All Rights Reserved",
    layout: {
        topStart: {
            buttons: [
                'copy',
                {
                    extend: 'excel',
messageTop: 'For the period from <?php echo date('d-M-Y',strtotime($_REQUEST['fdate']));?> To <?php echo date('d-M-Y',strtotime($_REQUEST['tdate']));?>',
                },
                {
                    extend: 'pdf',
					
messageTop: 'For the period from <?php echo date('d-M-Y',strtotime($_REQUEST['fdate']));?> To <?php echo date('d-M-Y',strtotime($_REQUEST['tdate']));?>',			                    
                    //messageBottom: null
					messageBottom: "Copyright <?php echo $grp_data->group_name?> All Rights Reserved"
                },
                {
                    extend: 'print',
									
messageTop: 'For the period from <?php echo "<strong>" ?><?php echo date('d-M-Y',strtotime($_REQUEST['fdate']));?> To <?php echo date('d-M-Y',strtotime($_REQUEST['tdate']));?><?php echo "</strong>" ?>',
                    //messageTop: function () {
//                        printCounter++;
// 
//                        if (printCounter === 1) {
//					
//                            return 'This is the first time you have printed this document. ttt';
//                        }
//                        else {
//                            return (
//                                'You have printed this document ' + printCounter + ' times'
//                            );
//                        }
//                    },
                    messageBottom: "&copy; Copyright <?php echo $grp_data->group_name?> All Rights Reserved"
                }
            ]
        }
    }
});
</script>



<script type="text/javascript">
$(document).ready(function() {
    // Check if DataTable is already initialized
    if ($.fn.DataTable.isDataTable('#data_table')) {
        // If DataTable is already initialized, destroy it
        $('#data_table').DataTable().destroy();
    }
    
    // Reinitialize DataTable with new options
    $('#data_table').dataTable({
        'iDisplayLength': 25
    });
});
</script>

</body>

</html>