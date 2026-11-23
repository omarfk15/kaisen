<?php

session_start();

ob_start();


require_once "../../../assets/template/layout.top.php";

$title='Sales Order Entry';

do_calander('#do_date');
do_calander('#delivery_date');

do_calander('#customer_po_date');

create_combobox('dealer_code_combo');

$now = date('Y-m-d H:s:i');

if($_GET['cbm_no']>0)
$cbm_no =$_SESSION['cbm_no'] = $_GET['cbm_no'];

$cdm_data = find_all_field('raw_input_sheet','','cbm_no='.$cbm_no);

do_calander('#est_date');

$page = 'do.php';

$table_master='sale_do_master';

$unique_master='do_no';

$table_detail='sale_do_details';

$unique_detail='id';


$table_chalan='sale_do_chalan';

$unique_chalan='id';


if($_REQUEST['old_do_no']>0)

$$unique_master=$_REQUEST['old_do_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field('sale_do_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){





if(isset($_POST['new']))



{

		
		
		
		
		if($_POST['dealer_code_combo']>0) {
		$_POST['dealer_code'] = $_POST['dealer_code_combo'];
		}
	
		$job_date = $_POST['do_date'];
		
		$YR = date('Y',strtotime($job_date));
  
  		$yer = date('y',strtotime($job_date));
  		$month = date('m',strtotime($job_date));

  		$job_cy_id = find_a_field('sale_do_master','max(job_id)','year="'.$YR.'"')+1;
		
   		$cy_id = sprintf("%06d", $job_cy_id);
	
   		$job_no_generate='SO'.$yer.''.$month.''.$cy_id;

		$_POST['job_no'] = $job_no_generate;
		$_POST['job_id'] = $job_cy_id;
		$_POST['year'] = $YR;

		

		$crud   = new crud($table_master);



		$_POST['entry_at']=date('Y-m-d H:i:s');



		$_POST['entry_by']=$_SESSION['user']['id'];
		
		//$merchandizer_exp=explode('->',$_POST['merchandizer']);
		
		//$_POST['merchandizer_code']=$merchandizer_exp[0];


		if($_POST['flag']<1){



		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;



		$$unique_master=$crud->insert();



		



		$type=1;



		$msg='Sales Return Initialized. (Sales Return No-'.$$unique_master.')';



		}



		else {
		
		
		unset($_POST['job_no']);
		unset($_POST['job_id']);
		unset($_POST['year']);



		$crud->update($unique_master);



		$type=1;



		$msg='Successfully Updated.';



		}



}




if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{
    
    
     


//$crud   = new crud($table_master);
//
//$_POST['edit_at']=date('Y-m-d H:i:s');
//$_POST['edit_at']=$_SESSION['user']['id'];
//$dealer = explode('-',$_POST['dealer_code']);
//$dealer_code = $_POST['dealer_code'] = $dealer[0];
//
//
// $dealer_ledger =  find_a_field('dealer_info','account_code','dealer_code="'.$dealer_code.'"');
// $dealer_balance = find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$dealer_ledger.'"');
//
//
// if($dealer_balance<0) {
//  $closing_balance =  $dealer_balance*(-1); 
// }else {
//  $closing_balance = $dealer_balance;
// }
// 
// $dealer_total_sale = find_a_field('journal','sum(dr_amt)','ledger_id="'.$dealer_ledger.'"');
// 
//  $sales_percentage = ($closing_balance/$dealer_total_sale)*100;
// 		
	
 
 
// if($sales_percentage<20){
// 	$_POST['order_create'] = 'Yes';
// }else {
//  $_POST['order_create'] = 'No';
// }
 
 //
//  if($dealer_balance<0 ) {
//  	$_POST['order_create'] = 'Yes';
//	} elseif($dealer_balance==0) {
//	$_POST['order_create'] = 'Yes';
//	}elseif ($dealer_balance>0 & $sales_percentage<20 ) {
//	$_POST['sales_percentage'] = $sales_percentage;
//	$_POST['order_create'] = 'Yes';
//	}else {
//	$_POST['sales_percentage'] = $sales_percentage;
// 	$_POST['order_create'] = 'No';
// 	}
//	
//	


//
//$customer = explode('-',$_POST['via_customer']);
//$via_customer = $_POST['via_customer'] = $customer[0];
//
//if($_POST['flag']<1){
//$_POST['entry_at']=date('Y-m-d H:i:s');
//$_POST['entry_by']=$_SESSION['user']['id'];
//$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;
//$$unique_master=$crud->insert();
//unset($$unique);
//$type=1;
//$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
//}

$table		=$table_detail;

if($_POST['sub_group_id']!=0){
$_SESSION['sub_group'] = $_POST['sub_group_id'];
$_SESSION['dealer_code'] = $_POST['dealer_code'];
$_SESSION['group_for'] = $_POST['group_for'];



}

$crud      	=new crud($table);

 $_POST['remarks']=$_POST['remarks11'];
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];


if($_REQUEST['init_bag_unit']<1){

$_POST['init_bag_unit'] = $_REQUEST['bag_unit'];
$_POST['init_dist_unit'] = $_REQUEST['total_unit'];
$_POST['init_total_unit'] = $_REQUEST['total_unit'];
$_POST['init_total_amt'] = $_REQUEST['total_amt'];

}




$xid = $crud->insert();
if($_REQUEST['bag_unit']>0){
$item_id = $_POST['item_id'];
 $r_sql = "select i.item_id,g.gunny_bag as gunny,g.poly_bag as poly from item_info i,item_sub_group g where  i.sub_group_id=g.sub_group_id and i.item_id=".$item_id;
$r1=db_query($r_sql);
while($rs1=mysqli_fetch_object($r1))
{
			$item_id = $rs1->item_id;
			$item_gunny=$rs1->gunny;
			$item_poly=$rs1->poly;
if($item_gunny>0){
$gunny_price =find_a_field('item_info','d_price',' item_id='.$item_gunny);
$_REQUEST['total_amt'] = $gunny_price*$_REQUEST['bag_unit']; 

 $gunny_sql = "INSERT INTO `sale_do_details` 
(`do_no`,  `do_date`, dealer_code,  via_customer, `item_id`, depot_id,`unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`,   entry_by, entry_at, remarks) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$_POST['dealer_code']."',  '".$_POST['via_customer']."',  '".$item_gunny."', 
 '".$_POST['depot_id']."', '".$gunny_price."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."',
  '".$_REQUEST['total_amt']."', '".$_SESSION['user']['id']."', '".$now."', '".$_POST['remarks']."')";

db_query($gunny_sql);

			}
			
			
if($item_poly>0){
$poly_price=find_a_field('item_info','d_price',' item_id='.$item_poly);

$_REQUEST['total_amt'] = $poly_price*$_REQUEST['bag_unit'];

 $gunny_sql = "INSERT INTO `sale_do_details` 
(`do_no`,  `do_date`, dealer_code,  via_customer,  `item_id`, depot_id, `unit_price`, `bag_unit`, dist_unit, total_unit, `total_amt`,   entry_by, entry_at, remarks) VALUES
('".$do_no."',  '".$_POST['do_date']."', '".$_POST['dealer_code']."',  '".$_POST['via_customer']."',  '".$item_poly."',  
 '".$_POST['depot_id']."',  '".$poly_price."', '".$_REQUEST['bag_unit']."',  '".$_REQUEST['bag_unit']."', '".$_REQUEST['bag_unit']."', 
 '".$_REQUEST['total_amt']."',   '".$_SESSION['user']['id']."', '".$now."', '".$_POST['remarks']."')";

db_query($gunny_sql);



}
}

//if($_POST['group_for']==5){
//
//$gunny =find_all_field('item_info','',' item_id="900120001" ');
//
//$_REQUEST['init_total_amt'] = $gunny->d_price*$_REQUEST['init_bag_unit'];
//
//  $gunny_sql = "INSERT INTO `sale_do_details` 
//(`do_no`, `do_date`, dealer_code, `item_id`, `unit_price`, `init_bag_unit`,`init_total_amt`) VALUES
//('".$do_no."', '".$do_date."', '".$dealer_code."', '".$gunny->item_id."',  '".$gunny->d_price."', '".$_REQUEST['init_bag_unit']."',  '".$_REQUEST['init_total_amt']."')";
//
//db_query($gunny_sql);
//
//}



}



//$table_ch		=$table_chalan;


//$crud      	=new crud($table_ch);


//$cid = $crud->insert();

  //$challan_sql = "INSERT INTO `sale_do_chalan` 
// (`chalan_no`, `order_no`, do_no, `item_id`, `dealer_code`, `unit_price`,`pkt_unit`, bag_unit, dist_unit, total_unit, total_amt, chalan_date, depot_id, group_for, entry_by, entry_at) VALUES
//('".$_POST['chalan_no']."', '".$xid."', '".$_POST['do_no']."', '".$_POST['item_id']."',  '".$_POST['dealer_code']."', '".$_POST['unit_price']."',  '".$_POST['pkt_unit']."', '".$_POST['bag_unit']."', '".$_POST['dist_unit']."' , '".$_POST['total_unit']."' , '".$_POST['total_amt']."' , '".$_POST['do_date']."' ,'4', '".$_POST['group_for']."', '".$_SESSION['user']['id']."', '".$now."' )";
//
//db_query($challan_sql);


   










//$_POST['init_total_unit'] = $_POST['init_dist_unit'];

//$_POST['in_stock_kg']=$_POST['in_stock'];

//$_POST['init_total_amt'] = ($_POST['init_total_unit'] * $_POST['unit_price']);

//$_POST['t_price'] = 0;

//$_POST['gift_on_order'] = $crud->insert();

}

}

else

{

$type=0;

$msg='Data Re-Submit Error!';

}

if($del>0)

{	

$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);

$crud   = new crud($table_detail);

if($del>0)

{

$condition=$unique_detail."=".$del;		

$crud->delete_all($condition);

$condition="gift_on_order=".$del;		

$crud->delete_all($condition);

if($main_del>0){

$condition=$unique_detail."=".$main_del;		

$crud->delete_all($condition);

$condition="gift_on_order=".$main_del;		

$crud->delete_all($condition);}

}


 $sql1 = "delete from journal_item where tr_from = 'Sales' and tr_no = '".$del."'";


		db_query($sql1);




$type=1;

$msg='Successfully Deleted.';

}

if($$unique_master>0)

{

$condition=$unique_master."=".$$unique_master;

$data=db_fetch_object($table_master,$condition);

while (list($key, $value)=@each($data))

{ $$key=$value;}

}

$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);

auto_complete_from_db('dealer_info','item_name','concat(item_name,"#>",finish_goods_code)','','vai_cutomer');

auto_complete_from_db('area','area_name','area_code','','district');

auto_complete_from_db('customer_info','customer_name_e ','customer_code',' dealer_code='.$dealer_code,'via_customer1');

?>

<script language="javascript">
function count()
{


//if(document.getElementById('unit_price').value!=''){}

var total_unit_pcs = ((document.getElementById('total_unit_pcs').value)*1);



var per_pcs_weight = ((document.getElementById('per_pcs_weight').value)*1);

var total_unit = (document.getElementById('total_unit').value)=(total_unit_pcs*per_pcs_weight);
var unit_price = ((document.getElementById('unit_price').value)*1);

var total_amt = (document.getElementById('total_amt').value) = total_unit*unit_price;

}



</script>



<script language="javascript">




//function TRcalculation(){
//    
//var unit_name = document.getElementById('unit_name').value;
//var unit_price = document.getElementById('unit_price').value*1;
//var total_unit = document.getElementById('total_unit').value*1;
//var qty_kg = document.getElementById('qty_kg').value*1;
//
//
//if(unit_name=="Pcs"){
//var total_amt = document.getElementById('total_amt').value= (unit_price*total_unit);}
//
//else {
//    var total_amt = document.getElementById('total_amt').value= (unit_price*qty_kg);
//}
//
//
// if(unit_price<final_price)
//  {
//alert('You can`t reduce the price');
//document.getElementById('unit_price').value='';
//  } 
//  
//  
//}






</script>
<style type="text/css">



/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 250px;
    height: 37px;
    border-radius: 0px !important;
}




.onhover:focus{
background-color:#66CBEA;

}


<!--
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>


<div class="form-container_large">

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #f0f0f0;">


<tr>
<td>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

	<tr>
		<td width="50%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>

<td>

<div>

<label style="width:220px;">Order No: </label>

<input style="width:250px;"  name="do_no" type="text" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

<input name="group_for" type="hidden" id="group_for" required readonly="" style="width:250px;" value="<?=$_SESSION['user']['group']?>" tabindex="105" />

</div>

</td>



</tr>



<tr>

<td>
<? if($do_date=="") {?>
<div>

<label style="width:220px;">Order Date: </label>

<input style="width:250px;"  name="do_date" type="text" id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>"  required />
</div>
<? }?>


<? if($do_date!="") {?>
<div>
<label style="width:220px;">Order Date: </label>
<input style="width:250px;"  name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"  required/>

<input style="width:250px;"  name="do_date2" type="text" id="do_date2" value="<?=$do_date;?>" readonly="" required/>
</div>
<? }?>

</td>



</tr>




<tr>

<td>

<div>

<label style="width:220px;">Warehouse: </label>

<select  id="depot_id" name="depot_id" class="form-control"  style="width:250px;" >
      
           
			  
			   <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
			  
          
            </select>
</div>

</td>



</tr>


<tr>

<td>

<div>

<label style="width:220px;">Remarks: </label>

<input style="width:250px;"  name="remarks" type="text" id="remarks" value="<?=$remarks;?>"   />
</div>


</td>

</tr>
			
			</table>
		
		</td>
		<td width="50%">
		
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			
			
	<tr>

<td>



<? if($job_no!="") {?>
<div>
<label style="width:220px;">Job No: </label>
<input name="job_no_duplicate" type="text" id="job_no_duplicate" style="width:250px;" value="<?=$job_no?>" readonly="" tabindex="105" />

</div>

<? }?>



</td>

</tr>		


<tr>

<td>
<div>

<label style="width:220px;">Customer: </label>
<? if ($dealer_code<1) {?>
<select  name="dealer_code_combo" id="dealer_code_combo"  style="width:250px;" required>

<option></option>

	
      <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code_combo,'1');?>
		 </select>
		 
<? }?>


<? if ($dealer_code>0) {?>
<select  id="dealer_code" name="dealer_code" class="form-control"  required style="width:250px;" >
	  
	 <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'dealer_code="'.$dealer_code.'"');?>

</select>

<? }?>

</div>
</td>



</tr>




<tr>

<td>

<div>

<label style="width:220px;">VAT (%): </label>

<input style="width:250px;"  name="vat" type="text" id="vat" value="<?=$vat;?>"  required />
</div>


</td>

</tr>


<tr>

<td>

<div>

<label style="width:220px;">Discount (%): </label>

<input style="width:250px;"  name="discount" type="text" id="discount" value="<?=$discount;?>"  required />
</div>


</td>

</tr>
				
			</table>
		</td>
	
	</tr>

</table>

</td>

</tr>



<tr>
<td align="center">

<div class="buttonrow">



		<? if($$unique_master>0) {?>



		<input name="new" type="submit" class="btn1" value="Update Sales Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="1" />



		<? }else{?>



		<input name="new" type="submit" class="btn1" value="Initiate Sales Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="0" />



		<? }?>



		</div>


</td>

</tr>
</table>


</form>

<? if($$unique_master>0) {?>

<form action="<?=$page?>" method="post" name="codz2" id="codz2">





<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">







<tr>
<td colspan="10">&nbsp;       </td>
  <td width="21%"><div class="button">
		    
  <input name="add" type="submit" id="add" value="ADD" class="update" style="background: #339933; font-size:14px; font-weight:700;"/>
		    
        </div></td>
  </tr>

<tr>

<td width="15%" align="center" bgcolor="#0073AA"><span class="style2">Item Code </span></td>

<td colspan="2" align="center" bgcolor="#0073AA"><span class="style2">Size</span><span class="style2"></span></td>
<td width="7%" align="center" bgcolor="#0073AA"><span class="style2">Length (FT) </span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">M-Unit</span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">Thickness (mm) </span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">Qty/Pcs</span></td>
<td width="6%" align="center" bgcolor="#0073AA"><span class="style2">Per Pcs (KG) </span></td>
<td width="12%" align="center" bgcolor="#0073AA"><span class="style2">Qty/KG</span></td>
<td width="12%" align="center" bgcolor="#0073AA"><span class="style2">Price In KG </span></td>
<td width="21%" align="center" bgcolor="#0073AA"><span class="style2">Value</span></td>
</tr>


<tr bgcolor="#CCCCCC">


<td align="center"><span class="style2">




<span id="sub">
<?

auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id',' product_nature="Salable"','item_id');

//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and do_no=".$do_no." order by id desc limit 1";
//$do_data = find_all_field_sql($do_details);

?>


<!--<input name="item_id" type="text" class="input3"  value="" id="item_id" style="width:90%; height:30px;" onblur="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);"/>-->

<select  name="item_id" id="item_id"  style="width:90%;" required >

		<option></option>

      <? foreign_relation('item_info','item_id','item_name',$item_id,'sub_group_id=100040000');?>
 </select>

		 

<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />
<input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"  />
<input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"  />
<input name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"/>
<input name="job_no" type="hidden" id="job_no" value="<?=$job_no;?>"/>
</span>




 </span></td>
 <td width="8%" align="center">
 <span id="so_data_found">
 <input name="unit_name" type="hidden" class="input3"  value="<?=$item_all->unit_name;?>" id="unit_name" style="width:90%; height:30px;" />
</span>
 <input  name="width" type="text" class="input3" id="width"value="" style="width:70px; height:30px;"   onkeyup="count()"   /></td>
 <td width="7%" align="center"><input  name="height" type="text" class="input3" id="height"value="" style="width:70px; height:30px;"   onkeyup="count()"   /></td>
 <td width="7%" align="center"><input  name="length" type="text" class="input3" id="length"value="20" style="width:70px; height:30px;"   onkeyup="count()"   /></td>
 <td width="6%" align="center">
 <select  name="measurement_unit" id="measurement_unit"  style="width:70px; height:30px; font-size:14px;" required>
  
      <? foreign_relation('measurement_unit','unit_name','unit_name',$do_data->measurement_unit,'1 order by order_by');?>
	    </select></td>
 <td width="6%" align="center"><input  name="thickness" type="text" class="input3" id="thickness"value="" style="width:70px; height:30px;"   onkeyup="count()" /></td>
 <td width="6%" align="center">
 <input  name="total_unit_pcs" type="text" class="input3" id="total_unit_pcs"value="" style="width:70px; height:30px;"   onkeyup="count()"   /> </td>
 <td width="6%" align="center"><input  name="per_pcs_weight" type="text" class="input3" id="per_pcs_weight"value="" style="width:70px; height:30px;"   onkeyup="count()"   /></td>
 <td width="12%" align="center">

<span class="style2">

<input  name="total_unit" type="text" class="input3" id="total_unit"value="" style="width:90%; height:30px;"  readonly=""  onkeyup="count()"   />
 </span></td>
 <td width="12%" align="center">
 <input name="unit_price" type="text" class="input3" id="unit_price"  style="width:70px; height:30px;" required="required"  value="<?=$item_all->d_price;?>"   /> </td>
 <td width="21%" align="center">

<span class="style2">

		<input name="total_amt" type="text" class="form-control" id="total_amt"  style="width:90%; height:30px;"   readonly/>
 </span></td>
</tr>
</table>








<? if($$unique_master>0){?>

<br /><br /><br /><br />

<? 
  $res='select b.item_name, a.* from  sale_do_details a, item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';

?>

<div  class="tabledesign2">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

<tr>

<th width="1%">SL</th>

<th width="23%">Item Description</th>

<th>Size</th>
<th width="17%"><strong>Length</strong></th>
<th width="11%"><strong>Unit Price </strong></th>
<th width="11%">Quantity</th>
<th width="11%">Value</th>
<th width="10%">X</th>
</tr>


<?

$i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){ ?>

<tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>

<td>
<?php 
            $get_length=explode(".",$data->width);
            $get_width=explode(".",$data->height);
            $get_height=explode(".",$data->length);
         
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
            
            
            if($data->width>0){echo $get_length[0].$fraction_length;}
            if($data->height>0){echo "X".$get_width[0].$fraction_width;}
            echo "".$data->measurement_unit;
            ?></td>

<td><?  if($data->length>0){echo "".$get_width[0].$fraction_width;} ?></td>
<td><?=$data->unit_name?></td>
<td>

<?=$data->unit_price; ?></td>
<td><?=$data->total_unit; $tot_pcs +=$data->total_unit;?></td>
<td><?=$data->Net_sale; $tot_Net_sale +=$data->Net_sale;?>

<? $data->vat_amt; $tot_vat_amt +=$data->vat_amt;?>
<? $data->total_amt_with_vat; $tot_total_amt_with_vat +=$data->total_amt_with_vat;?></td>
<td><a href="?del=<?=$data->id?>">X</a></td>
</tr>

<? } ?>

<tr>

<td colspan="4"><div align="right"><strong>  Total:</strong></div></td>

<td>&nbsp;</td>
<td><?=number_format($tot_pcs,2);?></td>
<td><?=number_format($tot_Net_sale,2);?></td>
<td>&nbsp;</td>
</tr>







<? }?>
</table>

</div>

</form>

<br />


<form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="100%" border="0">
<?php /*?>
<?php if($order_create=='Yes') {?>

<? } ?><?php */?>

<tr>

<td align="center" width="50%">

<input name="delete"  type="submit" class="btn1" value="DELETE SO" style="width:60%; font-weight:bold; background:#0073AA; font-size:12px;color:#F00; height:30px" />

<input  name="do_no" type="hidden" id="do_no" value="<?=$$unique_master?>"/>
<input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/></td>
<td align="right" style="text-align:right" width="50%">

<input name="confirm" type="submit" class="btn1" value="CONFIRM SO" style="width:60%; background:#0073AA; font-weight:bold; font-size:12px; height:30px; color: #FFFFFF; float:right" />

</td>

</tr>




</table>

<? }?>

</form>

</div>

<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");




?>