<?php

require_once "../../../assets/template/layout.top.php";


$title='Select Dealer for Demand Order';



$table_master='sale_return_master';

$unique_master='do_no';



$table_detail='sale_return_details';

$unique_detail='id';

if($_GET['mhafuz']){
unset($_SESSION['do_no']);
}

$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_POST[$unique_master];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		$crud   = new crud($table_chalan);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

?>
<script language="javascript">
window.location.href = "do.php";
</script>
<?
}

if(isset($_POST['confirm']))

{

 $or_no = $_REQUEST['do_no'];
 
$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d h:i:s');


//$chalan_no = date('ym').sprintf('%06d', $or_no);

$do_master = find_all_field('sale_return_master','do_no','do_no='.$or_no);

$chalan_no = next_transection_no($do_master->group_for,$do_master->do_date,'sale_return_master','invoice_no');

if($do_master->sales_type==1) {
	$warehouse_id = $do_master->depot_id;
} else {
	$warehouse_id = 50;;
}
$sales_return_type = find_a_field('sales_return_type','sales_return_type','id='.$do_master->sales_type);

$prevent_multi=find_a_field('journal_item','sr_no','sr_no="'.$or_no.'" and tr_from="'.$sales_return_type.'"');

if ($prevent_multi<1) {



$do_sql = "select a.*, m.do_no, m.do_date from sale_return_master m, sale_return_details a, item_info b where m.do_no=a.do_no and  b.item_id=a.item_id  and a.do_no='".$or_no."' order by a.id ";

$do_query = db_query($do_sql);	

		while($do_data=mysqli_fetch_object($do_query))

		{
		
	journal_item_control($do_data->item_id, $warehouse_id, $do_data->do_date, $do_data->total_unit, 0,  $sales_return_type, $do_data->id, $do_data->unit_price, $do_master->depot_id, $do_data->do_no, '', '',$do_master->group_for, $do_data->unit_price, '' );

		}




		
		
//Company Transport



		// $sql = 'update sale_do_chalan set status="INVOICE" where do_no = '.$or_no;
//		db_query($sql);

		$sql2 = 'update sale_return_details set status="INVOICE" where do_no = '.$or_no;
		db_query($sql2);
		
		  $sql3 = 'update sale_return_master set status="INVOICE", invoice_no="'.$chalan_no.'" where do_no = '.$or_no;
		db_query($sql3);

	auto_insert_sales_return_secoundary($chalan_no)

?>

<?
	}	
?>
<script language="javascript">
window.location.href = "sales_invoice_print_view.php?v_no=<?=$or_no;?>";
</script>
<?



}


auto_complete_from_db('dealer_info','concat(dealer_name_e)','dealer_code','depot="'.$_SESSION['user']['depot'].'"','dealer');

?>

<script language="javascript">

window.onload = function() {document.getElementById("dealer").focus();}

</script>

<div class="form-container_large">

<form action="do.php" method="post" name="codz" id="codz">

<table width="70%" border="0" align="center">

  <tr>

    <td></td>

    <td>&nbsp;</td>

    <td></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Active Dealer List: </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input name="dealer" type="text" id="dealer" style="background-color:white;" class="form-control"/>

    </strong></td>

    <td bgcolor="#FF9966" style="text-align:center"><strong>

      <input type="submit" name="submitit" id="submitit" value="Create DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:DodgerBlue"/>

    </strong></td>

  </tr>

</table>



</form>

</div>



<?

require_once "../../../assets/template/layout.bottom.php";

?>