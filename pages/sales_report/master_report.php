<?
session_start();
require_once "../../../assets/support/inc.all.php";
date_default_timezone_set('Asia/Dhaka');
		function ssd($qty,$pk,$colour='')
		{
		if($colour!='') $c = 'bgcolor="'.$colour.'" ';
		echo '
		<td '.$c.'>'.(int)($qty/$pk).'</td>
		<td '.$c.'>'.($qty%$pk).'</td>
		<td '.$c.'>'.(int)$qty.'</td>
			';
		}
if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
		$t_date=$_POST['t_date'];
		$f_date=$_POST['f_date'];
		
		$to_date=$_POST['t_date'];
		$fr_date=$_POST['f_date'];
	}
	
	if($_POST['warehouse_id']>0) 				$warehouse_id=$_POST['warehouse_id'];
	if($_POST['item_id']>0) 					$item_id=$_POST['item_id'];
	if($_POST['receive_status']!='') 			$receive_status=$_POST['receive_status'];
	if($_POST['issue_status']!='') 				$issue_status=$_POST['issue_status'];
	if($_POST['sub_group_id']>0) 				$sub_group_id=$_POST['sub_group_id'];
	if($_POST['item_brand']>0) 				    $item_brand=$_POST['item_brand'];
	if($_POST['vendor_id']>0) 				    $vendor_id=$_POST['vendor_id'];
	
	if($_POST['watt_type']>0) 				$watt_type=$_POST['watt_type'];
	if($_POST['garden_id']>0) 				    $garden_id=$_POST['garden_id'];
	
	
switch ($_POST['report']) {
    case 1:
		$report="Warehouse Item Transection Report";
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		
		if(isset($receive_status)){	
			if($receive_status=='All_Purchase')
			{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}
			else
			{$status_con=' and a.tr_from="'.$receive_status.'"';}
		}
		
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		if($_SESSION['user']['level']==5 || $_SESSION['user']['level']==4 || $_SESSION['user']['level']==1){
		 $sql='select ji_date,i.item_id,i.sku_code as sku_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,sr_no,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and
		    a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.id';
		}else{
		 $sql='select ji_date,i.item_id,i.sku_code as sku_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,sr_no,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and
		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$item_con.$status_con.$item_sub_con.' order by a.id';}
			
			//echo $sql;
	break;
    case 1008:
		$report="Warehouse Advance Purchase Report";
		
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		

		$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';

		
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		 $sql='select 
	 a.item_id,
	 i.item_name,
	 s.sub_group_name as Category,
	 i.unit_name as unit,
	 sum(a.item_in) as `total_qty`,
	 (sum(a.item_in*a.item_price)/sum(a.item_in)) as rate,
	 sum(a.item_in*a.item_price) as amount
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and
		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by a.item_id order by a.id';
	break;
    case 2:
		$report="Warehouse Stock Position Report(Closing)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 			{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		
		
	break;
    case 22:
		$report="Warehouse Present Stock (Packing Materials)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 			{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		
		

	break;
	    case 3:
		$report="Warehouse Present Stock";
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 				{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 			{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.journal_item between \''.$fr_date.'\' and \''.$to_date.'\'';}
		

		break;
	
    	case 4:
		$report="Warehouse Present Stock (Finish Goods)";
				if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		break;
		
			case 99:
		$report="Warehouse Present Stock (Finish Goods)";
				if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		break;
		
		
		case 444:
		$report="Stock In vs Stock Out Comparison Report";
				if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}
		break;
		
		
	
		case 5:
		$report="Depot Transfer Report (Details)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and w.warehouse_id='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
//$sql='select 
//m.pi_no,
//a.ji_date,
//w.warehouse_name  as warehouse,
//i.item_brand as brand,
//a.sr_no,
//i.finish_goods_code as fg,
//i.item_name,
//
//i.unit_name as unit,
//a.item_in as qty,
//a.item_price as rate,
//(a.item_in*a.item_price) as amt
//from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where w.use_type="SD" and a.item_in>0 and a.relevant_warehouse='.$_SESSION['user']['depot'].' and 
//d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.id';
		
		$sql='select 
		m.pi_no,
		a.ji_date as date,
		w.warehouse_name  as warehouse,
		
		a.sr_no,
		i.finish_goods_code as fg,
		i.item_name,
		
		i.unit_name as unit,
		a.item_ex as qty,
		i.p_price as Cost_Price,
		(a.item_ex*i.p_price) as Cost_Amt,
		i.d_price as Distributor_Price,
		(a.item_ex*i.d_price) as Distributor_Amt
		from journal_item a, item_info i, user_activity_management c, warehouse w, production_issue_master m, production_issue_detail d  where 

		w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and 
		c.user_id=a.entry_by and a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.ji_date';
		
		break;
		
		case 6:
		$report="Depot Transfer Report (Brief)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;}  
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
		$sql='select 
		
		i.finish_goods_code as fg,
		i.item_name,
		i.unit_name as unit,
		
		sum(a.item_ex) as qty,
		
		i.p_price as Cost_Price,
		sum(a.item_ex*p_price) as cost_Amt,
		i.d_price as Distributor_Price,
		sum(a.item_ex*i.d_price) as Distributor_Amt
		from journal_item a, item_info i, user_activity_management c,warehouse w  where w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
		break;
		
		
		case 7:
		$report="Entry Wise Transfer Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}

		$sql='select 
m.pi_no, m.invoice_no, m.pi_date,  w.warehouse_name as Depot,  
		sum(a.item_in*i.p_price) as cost_amt,sum(a.item_in*i.d_price) as DP_amt,m.carried_by
		from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where w.use_type="SD" and a.item_in>0 and a.relevant_warehouse='.$_SESSION['user']['depot'].' and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$con.' group by d.pi_no order by m.pi_date';
				
		//$sql='select  	a.pi_no, a.pi_date,  b.warehouse_name as Depot, a.remarks as sl_no, a.carried_by,sum(total_amt) as total_amt from production_issue_master a,production_issue_detail c,warehouse b where   a.warehouse_from='.$_SESSION['user']['depot'].' and a.pi_no=c.pi_no and a.warehouse_to=b.warehouse_id and b.use_type!="PL" '.$con.' group by c.pi_no order by a.pi_no desc';
		
		break;
		
		
		 case 10:

		$report="Black Tea Purchased report";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

		

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}

		if(isset($item_id)) 	{$item_con=' and e.item_id='.$item_id;}
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		
		if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

		if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		$sql='select a.po_no as po_no, DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date, a.sale_no, DATE_FORMAT(a.sale_date, "%d-%m-%Y") as Sale_date, b.lot_no, g.garden_name, b.invoice_no as inv_no, e.item_name as item_grade, b.quality as mark, CONVERT(b.pkgs,  DECIMAL(20,2)) as pkgs, b.qty as total_kgs,b.rate,b.amount
		   

		   from purchase_master a, purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f, tea_garden g , tea_warehouse t

		   where a.po_no=b.po_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and b.garden_id=g.garden_id and b.shed_id=t.warehouse_id and f.user_id=a.entry_by  and (a.status="CHECKED" or a.status="COMPLETED") '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$ctg_warehouse_con.$garden_id_con.' order by a.po_no,b.id';

	break;
	
	
	 case 15:

		$report="Black Tea Purchased Report (Pkgs Wise)";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

		

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}

		if(isset($item_id)) 	{$item_con=' and e.item_id='.$item_id;}
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		
		if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

		if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		  $sql='select a.po_no as po_no,  DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date, a.sale_no, DATE_FORMAT(a.sale_date, "%d-%m-%Y") as Sale_date, (select sum(pkgs) from purchase_invoice where po_no=a.po_no group by po_no) as total_pkgs,  (select sum(qty) from purchase_invoice where po_no=a.po_no group by po_no) as total_qty,(select sum(amount) from purchase_invoice where po_no=a.po_no group by po_no) as amount, ((select sum(amount) from purchase_invoice where po_no=a.po_no group by po_no) / (select sum(qty) from purchase_invoice where po_no=a.po_no group by po_no)) as average, v.vendor_name as broker_name
		   

		   from purchase_master a, purchase_invoice b, item_sub_group d, item_info e, user_activity_management f, tea_garden g , tea_warehouse t, vendor v

		   where a.po_no=b.po_no and  d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and b.garden_id=g.garden_id and b.shed_id=t.warehouse_id and f.user_id=a.entry_by and a.vendor_id=v.vendor_id   and (a.status="CHECKED" or a.status="COMPLETED") '.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$ctg_warehouse_con.$garden_id_con.$date_con.' group by a.po_no order by a.po_no ';

	break;
		
		
		case 12:

		$report="Black Tea Purchase Received report (PO Wise)";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

	

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		
		if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

		if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}

		

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		echo $sql='select a.po_no as po_no, DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date, a.sale_no,  DATE_FORMAT(a.sale_date, "%d-%m-%Y") as Sale_date, r.pr_no, r.rec_date, b.lot_no, r.rec_date, g.garden_name, b.invoice_no as inv_no, e.item_name as item_grade, b.quality as mark, CONVERT(b.pkgs, DECIMAL(20,2)) as pkgs, b.qty as received_kgs,b.rate,b.amount
		
		 from purchase_master a, purchase_invoice b, purchase_receive r, vendor c, item_sub_group d, item_info e, user_activity_management f, tea_garden g 
		 
		 where a.po_no=b.po_no and b.id=r.order_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and b.garden_id=g.garden_id and f.user_id=a.entry_by and (a.status="CHECKED" or a.status="COMPLETED") '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$ctg_warehouse_con.$garden_id_con.' order by r.rec_date';

	break;
		
		
		
		
		case 13:

		$report="Black Tea Purchase Received report (Rec. Date Wise)";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

		

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		
		if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

		if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}

		

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and r.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		 $sql='select  r.pr_no,  DATE_FORMAT(r.rec_date, "%d-%m-%Y") as rec_date, r.po_no as po_no,  DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date, r.sale_no, DATE_FORMAT(a.sale_date, "%d-%m-%Y") as Sale_date, r.lot_no, g.garden_name, r.invoice_no as inv_no, e.item_name as item_grade, r.quality as mark, CONVERT(r.pkgs, DECIMAL(20,2)) as pkgs, r.qty as received_kgs,r.rate,r.amount
		
		 from purchase_master a, purchase_invoice b, purchase_receive r, vendor c, item_sub_group d, item_info e, user_activity_management f, tea_garden g 
		 
		 where a.po_no=b.po_no and b.id=r.order_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and b.garden_id=g.garden_id and f.user_id=a.entry_by and (a.status="CHECKED" or a.status="COMPLETED") '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$ctg_warehouse_con.$garden_id_con.' order by a.po_no,b.id';

	break;
	
	
	
	case 130000:

		$report="Black Tea Purchase Received report (Rec. Date Wise)";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

		

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		
		if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

		if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}

		

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and r.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		 $sql='select  r.pr_no,  DATE_FORMAT(r.rec_date, "%d-%m-%Y") as rec_date,  r.truck_no, r.po_no as po_no,  DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date, r.sale_no, DATE_FORMAT(a.sale_date, "%d-%m-%Y") as Sale_date, r.lot_no, g.garden_name, r.invoice_no as inv_no, e.item_name as item_grade, r.quality as mark, CONVERT(r.pkgs, DECIMAL(20,2)) as pkgs, r.qty as received_kgs,r.rate,r.amount
		
		 from purchase_master a, purchase_invoice b, purchase_receive r, vendor c, item_sub_group d, item_info e, user_activity_management f, tea_garden g 
		 
		 where a.po_no=b.po_no and b.id=r.order_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and b.garden_id=g.garden_id and f.user_id=a.entry_by and (a.status="CHECKED" or a.status="COMPLETED") '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$ctg_warehouse_con.$garden_id_con.' order by r.rec_date';

	break;
	
	
	
	
	 case 14:

		$report="Black Tea Issue Report (Blend Sheet)";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

		

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}

		if(isset($item_id)) 	{$item_con=' and e.item_id='.$item_id;}
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		
		if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

		if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.blend_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		echo $sql='select b.id, a.blend_id, DATE_FORMAT(a.blend_date, "%d-%m-%Y") as blend_date, w.warehouse_name as Blend_name, b.sale_no, b.lot_no, g.garden_name, b.invoice_no as inv_no, e.item_name as item_grade,  CONVERT(b.pkgs,  DECIMAL(20,2)) as pkgs, b.sam_pay, b.sam_qty, b.qty as total_kgs,b.rate,b.amount
		   

		   from blend_sheet_master a, blend_sheet_details b,  item_sub_group d, item_info e, user_activity_management f, tea_garden g , warehouse w

		   where a.blend_id=b.blend_id and  d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and b.garden_id=g.garden_id and a.line_id=w.warehouse_id and f.user_id=a.entry_by  and (a.status="CHECKED" or a.status="COMPLETED") '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$ctg_warehouse_con.$garden_id_con.' order by a.blend_id,b.id';

	break;
		
		
case 8:
		$report="Warehouse Item Transection Report(Entry Wise)";
		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 
		
		if(isset($receive_status)){	
			if($receive_status=='All_Purchase')
			{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}
			else
			{$status_con=' and a.tr_from="'.$receive_status.'"';}
		}
		
		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 
		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.entry_at between \''.$fr_date.'\' and \''.date('Y-m-d',strtotime($_POST['t_date'])+24*60*60).'\'';}
		

		
		 $sql='select a.entry_at,ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,sr_no,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,c.fname as User ," " as Line_Manager
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and
		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by warehouse';
	break;
		case 1001:
		$report="Chalan Wise Sales Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}

		
		if(isset($t_date)) 
		{$con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}


		break;
		
		case 10011:
		$report="Chalan Wise Sales Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}

		
		if(isset($t_date)) 
		{$con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}


		break;
		
		
		case 501:
		$report="Details Receive Report";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
		$sql='select 
		m.pi_no,
		a.ji_date as date,
		w.warehouse_name  as warehouse,
		
		a.sr_no,
		i.finish_goods_code as fg,
		i.item_name,
		
		i.unit_name as unit,
		a.item_in as qty,
		d.unit_price as Cost_Price,
		(a.item_in*d.unit_price) as Cost_Amt,
		i.d_price as DP_Price,
		(a.item_in*i.d_price) as DP_Amt
		from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.ji_date';
		
		break;
		
		case 502:
		$report="Receive Report(Brief)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
		$sql='select 
		
		i.finish_goods_code as fg,
		i.item_name,
		i.unit_name as unit,
		
		sum(a.item_in) as qty,
		
		
		i.p_price as Cost_Price,
		sum(a.item_in*p_price) as cost_Amt,
		i.d_price as DP_Price,
		sum(a.item_in*i.d_price) as DP_Amt
		
		from journal_item a, item_info i, user_activity_management c,warehouse w  where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
		break;
		
		
		case 503:
		$report="Entry Wise Receive Report";
		if(isset($warehouse_id)) 			{$con.=' and a.relevant_warehouse='.$warehouse_id;} 

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}

		$sql='select 
m.pi_no as TR_no, m.invoice_no, m.pi_date as TR_date,  w.warehouse_name as Depot,  sum(a.item_in) as quantity,
		sum(a.item_in*d.unit_price) as cost_amt, sum(a.item_in*i.d_price) as DP_amt, m.carried_by
		
	from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d 
	 
		where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$con.' group by d.pi_no order by m.pi_date';
				
		//$sql='select  	a.pi_no, a.pi_date,  b.warehouse_name as Depot, a.remarks as sl_no, a.carried_by,sum(total_amt) as total_amt from production_issue_master a,production_issue_detail c,warehouse b where   a.warehouse_from='.$_SESSION['user']['depot'].' and a.pi_no=c.pi_no and a.warehouse_to=b.warehouse_id and b.use_type!="PL" '.$con.' group by c.pi_no order by a.pi_no desc';
		break;
		

}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../assets/css/report.css" type="text/css" rel="stylesheet" />



<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>



<style type="text/css">
.vertical-text {
	transform: rotate(270deg);
	transform-origin: left top 1;
	float:left;
	width:2px;
	padding:1px;
	font-size:10px;
	font-family:Arial, Helvetica, sans-serif;
}
.style1 {font-weight: bold}
.style2 {font-weight: bold}
.style3 {font-weight: bold}

h3 { margin:0; padding:0; font-weight: 700;}
.style4 {font-weight: bold}
.style5 {font-weight: bold}
.style6 {font-weight: bold}
.style7 {font-weight: bold}
.style9 {font-weight: bold}
.style10 {font-weight: bold}
.style11 {font-weight: bold}
.style13 {font-weight: bold}

table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}

.head_line_fixed {
/ Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}
</style>
</head>
<body>
<div align="center" id="pr">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>
<div class="main">
<?
		$str 	.= '<div class="header">';
		$str 	.= '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		
		if(isset($vendor_id)) 
		$str 	.= '<h3>Broker Name: '.find_a_field('vendor','vendor_name','vendor_id='.$vendor_id).'</h3>';
		
		if(isset($ctg_warehouse)) 
		$str 	.= '<h3>Ctg Warehouse: '.find_a_field('tea_warehouse','warehouse_name','warehouse_id='.$ctg_warehouse).'</h3>';
		
		if(isset($garden_id)) 
		$str 	.= '<h3>Garden Name: '.find_a_field('tea_garden','garden_name','garden_id='.$garden_id).'</h3>';
		
		
		if(isset($to_date)) 
		$str 	.= '<h2>'.date("d-m-Y",strtotime($fr_date)).' To '.date("d-m-Y",strtotime($to_date)).'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(isset($warehouse_id))
		$str 	.= '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($item_id)) 
		$str 	.= '<p>Item Name: '.find_a_field('item_info','item_name','item_id='.$item_id).'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		
		
if($_POST['report']==2) 
{	if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;}

		$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.d_price
		   from item_info i, item_sub_group s where 
		   i.sub_group_id=s.sub_group_id'.$item_sub_con.' order by i.finish_goods_code,s.sub_group_name,i.item_name';
		   
		$query =db_query($sql);   
		
		if($_SESSION['user']['level']==5){  
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
		}else{
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
		}
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="9"><div class="header"><h1>M. Ahmed Tea &amp; Lands Co. Ltd</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date-<?=$to_date?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
<th>Warehouse Name</th>
<th>Item Code</th>
<th>Item Group</th>
<th>FG</th>
<th>Item Name</th>
<th>Unit</th>
<th>Final Stock</th>
<th>Rate</th>
<th>Stock Price</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
if($_SESSION['user']['level']==5){ 
$s='select FORMAT(sum(a.item_in-a.item_ex),2) as final_stock,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price  
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.$warehouse_con.' order by a.id desc limit 1';}
else{
$s='select FORMAT(sum(a.item_in-a.item_ex),2) as final_stock,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price  
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';
}
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
$amt = $i->final_stock*$data->d_price;
$total_amt = $total_amt + $amt;
		   ?>
<tr>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<td><?=$data->item_id?></td>
<td><?=$data->sub_group_name?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right"><?=$i->final_stock?></td>
<td style="text-align:right"><?=@number_format($data->d_price,2)?></td>
<td style="text-align:right"><?=number_format(($amt),2)?></td>
</tr>
<?
}
		
?>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td align="right"> <b>Total:</b></td>
<td></td>
<td></td>
<td></td>
<td style="text-align:right"><?=number_format(($total_amt),2)?></td>
</tr>
<?

}




	
if($_POST['report']==22) 
{	if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;}

		$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.cost_price
		   from item_info i, item_sub_group s where  s.sub_group_id="1096001000010000" and
		   i.sub_group_id=s.sub_group_id'.$item_sub_con.' order by i.finish_goods_code,s.sub_group_name,i.item_name';
		   
		$query =db_query($sql);   
		
		if($_SESSION['user']['level']==5){  
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
		}else{
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
		}
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="9"><div class="header"><h1>M. Ahmed Tea &amp; Lands Co. Ltd</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date -<b> <?=date("d-m-Y",strtotime($to_date));?></b></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
<th>Warehouse Name</th>
<!--<th>Item Code</th>-->
<th>Item Group</th>
<th>FG</th>
<th>Item Name</th>
<th>Unit</th>


<th>Final Stock</th>

<!--<th>Rate</th>
<th>Stock Price</th>-->
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
if($_SESSION['user']['level']==5){ 
$s='select FORMAT(sum(a.item_in-a.item_ex),2) as final_stock
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.$warehouse_con.' order by a.id desc limit 1';}
else{
$s='select FORMAT(sum(a.item_in-a.item_ex),2) as final_stock 
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';
}
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
$amt = $i->final_stock*$data->cost_price;
$total_amt = $total_amt + $amt;
		   ?>
<tr>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<!--<td><?=$data->item_id?></td>-->
<td><?=$data->sub_group_name?></td>
<td><?=$data->finish_goods_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>

<td style="text-align:right"><?=$i->final_stock?></td>

<!--<td style="text-align:right"><?=@number_format($data->cost_price,2)?></td>
<td style="text-align:right"><?=number_format(($amt),2)?></td>-->
</tr>
<?
}
		
?>
<tr>
<td></td>
<td></td>
<!--<td></td>-->
<td></td>
<td></td>
<td align="right"><!-- <b>Total:</b>--></td>
<td></td>
<td></td>
<!--<td></td>
<td style="text-align:right"><?=number_format(($total_amt),2)?></td>-->
</tr>
<?

}
elseif($_POST['report']==99)
{
if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;}
if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

if(isset($item_id)) 				{$item_cons=' and i.item_id='.$item_id;}
if($_SESSION['user']['depot']==5)
$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name, i.finish_goods_code, i.sku_code, i.pack_size,i.cost_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.$item_sub_con.' and 
		   i.sub_group_id=s.sub_group_id order by i.finish_goods_code,s.sub_group_name,i.item_name';
else
 $sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.sku_code, i.pack_size,i.cost_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.$item_sub_con.' and 
		   i.sub_group_id=s.sub_group_id order by i.finish_goods_code,s.sub_group_name,i.item_name';
		$query =db_query($sql); 
		if($_SESSION['user']['level']==4 or $_SESSION['user']['level']==5){  
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
		}else{
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
		}
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="10"><div class="header">
<h1>
 <?
if($_SESSION['user']['group']>1)
echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);
else
echo $_SESSION['proj_name'];
?>
</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date - <b><?=date("d-m-Y",strtotime($to_date));?></b></h2></div><div class="left"></div><div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Warehouse Name</th>
<th rowspan="2">Item Group</th>
<th rowspan="2">SKU Code</th>
<th rowspan="2">Item Name</th>

<th rowspan="2">Unit</th>
<th rowspan="2">Stock In Transit</th>
<th colspan="2">Stock In Warehouse</th>
<th rowspan="2">Total Stock</th>
<th rowspan="2">Total Pcs</th>



 
</tr>

</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
if($_SESSION['user']['level']==4 or $_SESSION['user']['level']==5){
  $s='select sum(a.item_in-a.item_ex) as final_stock
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.$warehouse_con.' order by a.id desc limit 1';
}else{
 $s='select sum(a.item_in-a.item_ex) as final_stock
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';
}
//echo $s;
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
$p='SELECT sum(p.qty) as pur_qty FROM purchase_invoice p,purchase_master pm WHERE p.po_no=pm.po_no AND pm.warehouse_id=1 and pm.status=="CHECKED" and p.item_id="'.$data->item_id.'" ';
$pt = db_query($p);
$pur_t=mysqli_fetch_object($pt);

		   ?>
<tr>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<td><?=$data->sub_group_name?></td>
<td><?=$data->sku_code?></td>
<td><?=$data->item_name?></td>

<td><?=$data->unit_name?></td>
<td><?=$pur_t->pur_qty?></td>
<td style="text-align:right; background-color:#CCFFFF;"><?=number_format(($i->final_stock),2)?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=$tttt=(($i->final_stock)+$pur_t->pur_qty);?></td>
<td style="text-align:right"><?=number_format($i->final_stock,2)?></td>

</tr>
<?
$transit_total=$transit_total+$pur_t->pur_qty;
$t_unit+=$i->final_stock;
$t_sum = $t_sum + $sum;
$pt_total=$pt_total+$tttt;
}
?>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>

<td align="right"> <b>Total :</b></td>
<td></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=number_format($transit_total,2)?></td>
<td style="text-align:right; background-color:#CCFFFF;"><?=number_format($t_unit,2)?></td>
<td style="text-align:right;background-color:#FFCCFF;"></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=number_format($pt_total,2)?></td>
<td style="text-align:right"><?= number_format($t_unit,2)?></td>

</tr>
<?
}
elseif($_POST['report']==4) 
{
if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;}
if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

if(isset($item_id)) 				{$item_cons=' and i.item_id='.$item_id;}
if($_SESSION['user']['depot']==5)
$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name, i.finish_goods_code, i.sku_code, i.pack_size, i.cost_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.$item_sub_con.' and 
		   i.sub_group_id=s.sub_group_id order by s.sub_group_sl,i.item_sl';
else
  $sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.sku_code, i.pack_size, i.cost_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.$item_sub_con.' and 
		   i.sub_group_id=s.sub_group_id order by s.sub_group_sl,i.item_sl';
		$query =db_query($sql); 
		if($_SESSION['user']['level']==4 or $_SESSION['user']['level']==5){  
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
		}else{
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
		}
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0"> <thead><tr><td style="border:0px;" colspan="10"><div class="header">
<h1>
 <?
if($_SESSION['user']['group']>1)
echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);
else
echo $_SESSION['proj_name'];
?>
</h1><h2><?=$report?></h2>
<h2>Closing Stock of Date - <b><?=date("d-m-Y",strtotime($to_date));?></b></h2></div><div class="left"></div><div class="right"></div>
<div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Warehouse Name</th>
<th rowspan="2">Item Group</th>
<th rowspan="2">SKU Code</th>
<th rowspan="2">Item Name</th>

<th rowspan="2">Unit</th>
<th rowspan="2">Stock In Transit</th>
<th colspan="2">Stock In Warehouse</th>
<th rowspan="2">Total Stock</th>
<th rowspan="2">Total Pcs</th>
<th rowspan="2">Rate</th>
<th rowspan="2">Stock Price</th>


 
</tr>

</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
if($_SESSION['user']['level']==4 or $_SESSION['user']['level']==5){
  $s='select sum(a.item_in-a.item_ex) as final_stock
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.$warehouse_con.' order by a.id desc limit 1';
}else{
 $s='select sum(a.item_in-a.item_ex) as final_stock
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';
}
//echo $s;
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
$p='SELECT sum(p.qty) as pur_qty FROM purchase_invoice p,purchase_master pm WHERE p.po_no=pm.po_no AND pm.warehouse_id=1 and pm.status=="CHECKED" and p.item_id="'.$data->item_id.'" ';
$pt = db_query($p);
$pur_t=mysqli_fetch_object($pt);

		   ?>
<tr>
<td><?=$j?></td>
<td><?=$warehouse_name?></td>
<td><?=$data->sub_group_name?></td>
<td><?=$data->sku_code?></td>
<td><?=$data->item_name?></td>

<td><?=$data->unit_name?></td>
<td><?=$pur_t->pur_qty?></td>
<td style="text-align:right; background-color:#CCFFFF;"><?=number_format(($i->final_stock),2)?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=$tttt=(($i->final_stock)+$pur_t->pur_qty);?></td>
<td style="text-align:right"><?=number_format($i->final_stock,2)?></td>
<td style="text-align:right"><?=@number_format($data->item_price+(($data->item_price*15)/100),3)?></td>
<td style="text-align:right"><? $sum =($data->item_price+(($data->item_price*15)/100))*$i->final_stock; echo number_format((($data->item_price+(($data->item_price*15)/100))*$i->final_stock),2);?></td>
</tr>
<?
$transit_total=$transit_total+$pur_t->pur_qty;
$t_unit+=$i->final_stock;
$t_sum = $t_sum + $sum;
$pt_total=$pt_total+$tttt;
}
?>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>

<td align="right"> <b>Total :</b></td>
<td></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=number_format($transit_total,2)?></td>
<td style="text-align:right; background-color:#CCFFFF;"><?=number_format($t_unit,2)?></td>
<td style="text-align:right;background-color:#FFCCFF;"></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=number_format($pt_total,2)?></td>
<td style="text-align:right"><?= number_format($t_unit,2)?></td>
<td style="text-align:right"></td>


<td style="text-align:right"><?=number_format($t_sum,2)?></td>
</tr>

</tbody>

</table>
<?
}








elseif($_POST['report']==444) 
{
if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;}
if(isset($item_id)) 				{$item_cons=' and i.item_id='.$item_id;}
if($_SESSION['user']['depot']==5)
 $sql='select distinct i.item_id, i.sku_code, i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size, i.cost_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.' and 
		   i.sub_group_id=s.sub_group_id'.$item_sub_con.' order by i.finish_goods_code,s.sub_group_name,i.item_name';
else
$sql='select distinct i.item_id, i.sku_code, i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.cost_price as item_price
		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.' and 
		   i.sub_group_id=s.sub_group_id'.$item_sub_con.' order by i.finish_goods_code,s.sub_group_name,i.item_name';
		$query =db_query($sql); 
		if($_SESSION['user']['level']==4 or $_SESSION['user']['level']==5){  
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);
		}else{
		$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
		}
?>

<table width="100%" height="244" border="0" cellpadding="2" cellspacing="0">
  <thead><tr><td style="border:0px;" colspan="12"><div class="header">
<h1> <?
if($_SESSION['user']['group']>1)
echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);
else
echo $_SESSION['proj_name'];
?></h1>
<h2><?=$report?></h2>
<h1><? if($warehouse_id>0) echo 'Depot: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id)?></h1>

<h2>Date Interval: <b><?=date("d-m-Y",strtotime($fr_date))?></b> <strong>to</strong> <b><?=date("d-m-Y",strtotime($to_date))?></b></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th width="2%" rowspan="2">S/L</th>
<th width="6%" rowspan="2">SKU Code </th>
<th width="14%" rowspan="2">Item Name 
</th>
<th width="9%" rowspan="2">Unit Name </th>
<th colspan="2"><div align="center">Stock Out Calculation </div></th>
<th colspan="4"><div align="center">Stock Movement Calculation </div></th>
<th width="9%" rowspan="2">Stock Days</th>
</tr>
<tr>
  <th width="9%">Stock Out </th>
  <th width="12%">Average </th>
  <th width="11%" bgcolor="#66CCFF">Opening</th>
  <th width="9%" bgcolor="#CCFFFF">Stock In </th>
  <th width="9%" bgcolor="#FFCCFF">Stock Out </th>
  <th width="10%" bgcolor="#CCCCFF">Closing</th>
</tr>

</thead><tbody>
<?

//sum((a.item_in-a.item_ex)*a.unit_price)
while($data=mysqli_fetch_object($query)){





$pre='select sum(item_in-item_ex) as pre_stock
from journal_item a where ji_date<"'.$_POST['f_date'].'" and  a.item_id="'.$data->item_id.'" '.$item_con.$status_con.' and a.warehouse_id="'.$warehouse_id.'" ';

$q_pre = db_query($pre);
$data_pre=mysqli_fetch_object($q_pre);

$pre_stock = $data_pre->pre_stock;


  $s='select sum(a.item_in-a.item_ex) as final_stock , item_price
from journal_item a where  a.item_id="'.$data->item_id.'" '.$date_con.$item_con.$status_con.' and a.warehouse_id="'.$warehouse_id.'" ';

$q = db_query($s);
$i=mysqli_fetch_object($q);

$t_stock = $i->final_stock+$ip->final_stock;



if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $sl_date_con=' and a.ji_date BETWEEN  "'.$fr_date.'" and "'.$to_date.'"';}

   $st_sql='select sum(item_in) as stock_in,  sum(item_ex) as stock_out 
from journal_item a, warehouse w where w.warehouse_id=a.warehouse_id and a.item_id="'.$data->item_id.'" '.$sl_date_con.$item_con.$status_con.' and w.warehouse_id="'.$warehouse_id.'" ';


$st_query = db_query($st_sql);
$st_data=mysqli_fetch_object($st_query);

	

$count_date = find_a_field('journal_item','count( DISTINCT `ji_date`)','ji_date BETWEEN "'.$_POST['f_date'].'" and   "'.$_POST['t_date'].'" ');

$stock_in = $st_data->stock_in;

$stock_out = $st_data->stock_out;

$average_stock_out = $stock_out/$count_date;

$stock_days = $t_stock/$average_stock_out;

$j++;

		   ?>
<tr>
<td><?=$j?></td>
<td><?=$data->sku_code?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td><?=number_format($stock_out,2);?></td>
<td><?=number_format($average_stock_out,2);?></td>
<td bgcolor="#66CCFF" style="text-align:right; background-color:#66CCFF;"><?=number_format($pre_stock,2)?></td>
<td style="text-align:right; background-color:#CCFFFF;"><?=number_format($stock_in,2)?></td>
<td style="text-align:right;background-color:#FFCCFF;"><?=number_format($stock_out,2);?></td>
<td bgcolor="#CCCCFF" style="text-align:right;background-color:#CCCCFF;"><?=number_format(($i->final_stock),2)?></td>
<td style="text-align:right"><?=number_format($stock_days,2)?></td>
</tr>
<?
$tot_stock_out +=$stock_out;
$tot_pre_stock +=$pre_stock;
$tot_stock_in += $stock_in;
$tot_final_stock +=$i->final_stock;
}
?>
<tr>
<td></td>
<td></td>
<td></td>
<td><strong>Total : </strong></td>
<td><span style="text-align:right; font-weight:700;">
  <?= number_format($tot_stock_out,2)?>
</span></td>
<td></td>
<td bgcolor="#66CCFF" ><span style="text-align:right; font-weight:700;">
  <?= number_format($tot_pre_stock,2)?>
</span></td>
<td style="text-align:right; background-color:#CCFFFF;">
<span style="text-align:right; font-weight:700;">
  <?= number_format($tot_stock_in,2)?>
</span></td>
<td style="text-align:right; background-color:#FFCCFF;">

<span style="text-align:right; font-weight:700;">
  <?= number_format($tot_stock_out,2)?>
</span></td>
<td bgcolor="#CCCCFF" style="text-align:right; background-color:#CCCCFF;">
<span style="text-align:right; font-weight:700;">
<?= number_format($tot_final_stock,2)?></span></td>
<td style="text-align:right"></td>
</tr></tbody></table>
<?
}










/*purchase unreceive report*/

elseif($_POST['report']==11)

{

$report="Chittagong Warehouse Stock (Black Tea)";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0">

		

		<thead>

		<tr><td colspan="24" style="border:0px;">

		<?

		echo $str;

		?>

		</td></tr>
<tbody>



	<tr>

		<th><div align="left">S/L</div></th>

		<th><div align="left">Po No</div></th>
		<th><div align="left">Po Date</div></th>

		<th><div align="left">Sale No </div></th>
		<th><div align="left">Sale Date </div></th>
		<th><div align="left">Lot No</div></th>

		<th><div align="left">Garden Name </div></th>
		<th><div align="left">Invoice No </div></th>
		<th><div align="left">Item Grade</div></th>

		<th><div align="left">Mark</div></th>

		<th><div align="left">Pkgs</div></th>

		<th><div align="left">Pending Kgs</div></th>

		<th><div align="left">Rate</div></th>

	    <th><div align="left">Amount</div></th>
	</tr>

    <div align="left">
      <? 





if($_POST['f_date']!=''&&$_POST['t_date']!='')

$con .= 'and a.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

if($_POST['vendor_id']>0)

$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';

if(isset($item_id)) 	{$item_con=' and e.item_id='.$item_id;}

if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}



$res='
select a.po_no as po_no, a.po_date, a.sale_no, a.sale_date, b.lot_no, g.garden_name, b.invoice_no as inv_no, e.item_name as item_grade, b.quality as mark, CONVERT(b.pkgs, DECIMAL(20,2)) as pkgs,b.qty, (select sum(r.qty) from purchase_receive r where r.order_no=b.id) as pending_kgs,b.rate,b.amount 
from
 purchase_master a, purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f, tea_garden g where a.po_no=b.po_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and b.garden_id=g.garden_id and f.user_id=a.entry_by and (a.status="CHECKED" or a.status="COMPLETED") '.$con.$item_con.$ctg_warehouse_con.$garden_id_con.' order by a.po_no,b.id';



$query = db_query($res);

while($data=mysqli_fetch_object($query))

{
if($data->qty>$data->pending_kgs){

$j++;


?>
      
      
      

    <tr>

      <td valign="top"><?=$j?></td>

	  <td valign="top"><div align="left">
	    <?=$data->po_no;?>
      </div></td>
	  
	  
	  <td valign="top"><div align="left">
	    <?=date("d-m-Y",strtotime($data->po_date));?>
      </div></td>

	  <td valign="top"><div align="left">
	    <?=$data->sale_no;?>
      </div></td>
	  
	  
	  <td valign="top"><div align="left">
	    <?=date("d-m-Y",strtotime($data->sale_date));?>
      </div></td>
	  <td valign="top"><div align="left">
	    <?=$data->lot_no;?>
      </div></td>

	  <td valign="top"><div align="left">
	    <?=$data->garden_name;?>
      </div></td>
	  <td valign="top"><div align="left">
	    <?=$data->inv_no;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->item_grade;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->mark;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->pkgs; $tot_pkgs+=$data->pkgs;?>
      </div></td>
	  <td><div align="left">
	    <?=number_format(($data->qty-$data->pending_kgs),3); $tot_pending_kg+=($data->qty-$data->pending_kgs);?>
      </div></td>
	  <td><div align="left">
	    <?=$data->rate;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->amount; $tot_amount+=$data->amount;?>
      </div></td>
	</tr>

          <? }}?>
      
    </div>
    <tr>

	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top"><div align="left"><strong>Total:</strong></div></td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top"><div align="left"><span class="style2">
	    <?=number_format(($tot_pkgs),2);?>
      </span></div></td>
	  <td valign="top"><div align="left"><span class="style1">
	    <?=number_format(($tot_pending_kg),3);?>
      </span></div></td>
	  <td valign="top">&nbsp;</td>
	  <td>

	    <div align="left"><span class="style3">
	      <?=number_format(($tot_amount),2);?>
        </span></div></td>
	</tr>
</tbody></table>

<?

}

/*/purchase unreceive report*/




/*Black tea factory stock report*/

elseif($_POST['report']==20190910)

{

$report="Factory Warehouse Stock (Black Tea)";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0">

		

		<thead>

		<tr><td colspan="26" style="border:0px;">

		<?

		echo $str;

		?>

		</td></tr>
<tbody>



	<tr>

		<th rowspan="2"><div align="left">S/L</div></th>

		<th rowspan="2">Sale No </th>
		<th rowspan="2"><div align="left">Pr No</div></th>
		<th rowspan="2"><div align="left">Pr Date</div></th>

		<th rowspan="2"><div align="left">Sale No </div></th>
		<th rowspan="2"><div align="left">Lot No</div></th>

		<th rowspan="2"><div align="left">Garden Name </div></th>
		<th rowspan="2"><div align="left">Invoice No </div></th>
		<th rowspan="2"><div align="left">Item Grade</div></th>

		<th rowspan="2"><div align="left">Mark</div></th>

		<th rowspan="2"><div align="left">Pkgs</div></th>

	  <th colspan="3" bordercolor="#99FFFF" bgcolor="#CCFFFF"><div align="center">Black Tea Consumption</div></th>

		<th rowspan="2"><div align="left">Rate</div></th>

	    <th rowspan="2"><div align="left">Amount</div></th>
	</tr>
	<tr>
	  <th bgcolor="#CCFFFF">Rec Qty </th>
      <th bgcolor="#CCFFFF">Blend Issue </th>
	  <th bgcolor="#CCFFFF">Stock Qty </th>
	</tr>
    <div align="left">
      <? 





if($_POST['f_date']!=''&&$_POST['t_date']!='')

$date_con .= 'and r.rec_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

if($_POST['vendor_id']>0)

$vendor_con .= 'and r.vendor_id="'.$_POST['vendor_id'].'"';

if(isset($item_id)) 	{$item_con=' and e.item_id='.$item_id;}

if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

if(isset($garden_id)) 	{$garden_id_con=' and r.garden_id='.$garden_id;}



 $res='
select  r.pr_no, r.id,  DATE_FORMAT(r.rec_date, "%d-%m-%Y") as rec_date, r.po_no as po_no,   r.sale_no,  r.lot_no, r.garden_id,  g.garden_name, r.invoice_no, e.item_name as item_grade, r.quality as mark, CONVERT(r.pkgs, DECIMAL(20,2)) as pkgs, r.qty as rec_qty,r.rate,r.amount
		
		 from  purchase_receive r, vendor c, item_sub_group d, item_info e, tea_garden g 
		 
		 where c.vendor_id=r.vendor_id and d.sub_group_id=e.sub_group_id and r.item_id=e.item_id and r.garden_id=g.garden_id  '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$ctg_warehouse_con.$garden_id_con.'  order by r.pr_no, r.id
		 ';



$query = db_query($res);

while($data=mysqli_fetch_object($query))

{


$lot_no= $data->lot_no;

 $invoice_no=$data->invoice_no;

 $garden_id=$data->garden_id;

$bland_qty = find_a_field('blend_sheet_details', 'sum(qty)', 'lot_no="'.$lot_no.'" and invoice_no="'.$invoice_no.'" and garden_id="'.$garden_id.'" ');

$stock_qty = $data->rec_qty-$bland_qty;

$stock_amt =  $data->rate*$stock_qty;



if($stock_qty>10){

$j++;


?>
      
      
      

    <tr>

      <td valign="top"><?=$j?></td>

	  <td valign="top"> <?=$data->sale_no;?></td>
	  <td valign="top"><div align="left">
	    <?=$data->pr_no;?>
      </div></td>
	  
	  
	  <td valign="top"><div align="left">
	    <?=date("d-m-Y",strtotime($data->rec_date));?>
      </div></td>

	  <td valign="top"><div align="left">
	    <?=$data->sale_no;?>
      </div></td>
	  
	  <td valign="top"><div align="left">
	    <?=$data->lot_no;?>
      </div></td>

	  <td valign="top"><div align="left">
	    <?=$data->garden_name;?>
      </div></td>
	  <td valign="top"><div align="left">
	    <?=$data->invoice_no;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->item_grade;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->mark;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->pkgs; $tot_pkgs+=$data->pkgs;?>
      </div></td>
	  <td bordercolor="#99FFFF" bgcolor="#CCFFFF"><div align="left">
	    <?=number_format(($data->rec_qty),3); $tot_received_kgs+=($data->rec_qty);?>
      </div></td>
	  <td bordercolor="#99FFFF" bgcolor="#CCFFFF"><?=number_format(($bland_qty),3); $tot_bland_qty+=$bland_qty; ?></td>
	  <td bordercolor="#99FFFF" bgcolor="#CCFFFF"><?=number_format(($stock_qty),3); $tot_stock_qty+=$stock_qty; ?></td>
	  <td><div align="left">
	    <?=$data->rate;?>
      </div></td>
	  <td><div align="left">
	    <?=number_format($stock_amt,3); $tot_amount+=$stock_amt;?>
      </div></td>
	</tr>

          <? } }?>
    </div>
    <tr>

	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top"><div align="left"><strong>Total:</strong></div></td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top"><div align="left"><span class="style2">
	    <?=number_format(($tot_pkgs),2);?>
      </span></div></td>
	  <td valign="top" bordercolor="#99FFFF" bgcolor="#CCFFFF"><div align="left"><span class="style1">
	    <?=number_format(($tot_received_kgs),3);?>
      </span></div></td>
	  <td valign="top" bordercolor="#99FFFF" bgcolor="#CCFFFF"><span class="style7">
	    <?=number_format(($tot_bland_qty),3);?>
	  </span></td>
	  <td valign="top" bordercolor="#99FFFF" bgcolor="#CCFFFF"><span class="style7">
	    <?=number_format(($tot_stock_qty),3);?>
	  </span></td>
	  <td valign="top">&nbsp;</td>
	  <td>

	    <div align="left"><span class="style3">
	      <?=number_format(($tot_amount),2);?>
        </span></div></td>
	</tr>
</tbody></table>

<?

}

/*/Black tea factory stock report*/






/*purchase unreceive report pkgs*/

elseif($_POST['report']==112)

{

$report="Chittagong Warehouse Stock (PKGS Wise)";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0">

		

		<thead>

		<tr><td colspan="24" style="border:0px;">

		<?

		echo $str;

		?>

		</td></tr>
<tbody>



	<tr>

		<th><div align="left">S/L PKGS</div></th>

		<th><div align="left">Po No</div></th>
		<th><div align="left">Po Date</div></th>

		<th><div align="left">Sale No </div></th>
		<th><div align="left">Sale Date </div></th>
		<th><div align="left">Lot No</div></th>

		<th><div align="left">Garden Name </div></th>
		<th><div align="left">Invoice No </div></th>
		<th><div align="left">Item Grade</div></th>

		<th><div align="left">Mark</div></th>

		<th><div align="left">Pkgs</div></th>

		<th><div align="left">Pending Kgs</div></th>

		<th><div align="left">Rate</div></th>

	    <th><div align="left">Amount</div></th>
	</tr>

    <div align="left">
      <? 





if($_POST['f_date']!=''&&$_POST['t_date']!='')

$con .= 'and a.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';

if($_POST['vendor_id']>0)

$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';

if(isset($item_id)) 	{$item_con=' and e.item_id='.$item_id;}

if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}

if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}



$res='
select a.po_no as po_no, a.po_date, a.sale_no, a.sale_date, b.lot_no, g.garden_name, b.invoice_no as inv_no, e.item_name as item_grade, b.quality as mark, CONVERT(b.pkgs, DECIMAL(20,2)) as pkgs,b.qty, (select sum(r.qty) from purchase_receive r where r.order_no=b.id) as pending_kgs,b.rate,b.amount 
from
 purchase_master a, purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f, tea_garden g where a.po_no=b.po_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and b.garden_id=g.garden_id and f.user_id=a.entry_by and (a.status="CHECKED" or a.status="COMPLETED") '.$con.$item_con.$ctg_warehouse_con.$garden_id_con.' order by a.po_no,b.id';



$query = db_query($res);

while($data=mysqli_fetch_object($query))

{
if($data->qty>$data->pending_kgs){

$j++;


?>
      
      
      

    <tr>

      <td valign="top"><?=$j?></td>

	  <td valign="top"><div align="left">
	    <?=$data->po_no;?>
      </div></td>
	  
	  
	  <td valign="top"><div align="left">
	    <?=date("d-m-Y",strtotime($data->po_date));?>
      </div></td>

	  <td valign="top"><div align="left">
	    <?=$data->sale_no;?>
      </div></td>
	  
	  
	  <td valign="top"><div align="left">
	    <?=date("d-m-Y",strtotime($data->sale_date));?>
      </div></td>
	  <td valign="top"><div align="left">
	    <?=$data->lot_no;?>
      </div></td>

	  <td valign="top"><div align="left">
	    <?=$data->garden_name;?>
      </div></td>
	  <td valign="top"><div align="left">
	    <?=$data->inv_no;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->item_grade;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->mark;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->pkgs; $tot_pkgs+=$data->pkgs;?>
      </div></td>
	  <td><div align="left">
	    <?=number_format(($data->qty-$data->pending_kgs),3); $tot_pending_kg+=($data->qty-$data->pending_kgs);?>
      </div></td>
	  <td><div align="left">
	    <?=$data->rate;?>
      </div></td>
	  <td><div align="left">
	    <?=$data->amount; $tot_amount+=$data->amount;?>
      </div></td>
	</tr>

          <? }}?>
      
    </div>
    <tr>

	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top"><div align="left"><strong>Total:</strong></div></td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top"><div align="left"><span class="style2">
	    <?=number_format(($tot_pkgs),2);?>
      </span></div></td>
	  <td valign="top"><div align="left"><span class="style1">
	    <?=number_format(($tot_pending_kg),3);?>
      </span></div></td>
	  <td valign="top">&nbsp;</td>
	  <td>

	    <div align="left"><span class="style3">
	      <?=number_format(($tot_amount),2);?>
        </span></div></td>
	</tr>
</tbody></table>

<?

}

/*/purchase unreceive report pkgs wise*/





elseif($_POST['report']==71) 
{
		$sql='select i.item_id,i.unit_name,i.item_name,i.sales_item_type,i.finish_goods_code,i.item_brand,i.pack_unit,i.pack_size,i.sales_item_type from item_info i where 
		   i.product_nature = "Salable"  order by i.finish_goods_code,i.item_name';
		   
		$query =db_query($sql);  
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="12"><div class="header"><h1>M. Ahmed Tea &amp; Lands Co. Ltd</h1><h2>Warehouse Present Stock</h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th>S/L</th>
<th>FG Code </th>
<th>Brand</th>
<th>Group</th>
<th>Item Name </th>
<th>Pack Size </th>
<th>Pcs Unit</th>
<th bgcolor="#FFCCFF">CRT</th>
<th bgcolor="#CCCCFF">PCS</th>
<th>Rate</th>
<th>Stock Price</th>
</tr>
</thead><tbody>
<?
while($data=mysqli_fetch_object($query)){
$s='select a.final_stock,a.final_price as rate,(a.final_stock*a.final_price) as Stock_price from journal_item a where  a.item_id="'.$data->item_id.'"  and a.warehouse_id='.$_SESSION['user']['depot'].' order by a.id desc limit 1';
$q = db_query($s);
$i=mysqli_fetch_object($q);$j++;
		   ?>
<tr><td><?=$j?></td>
  <td><?=$data->finish_goods_code?></td>
  <td><?=$data->item_brand?></td>
  <td><?=$data->sales_item_type?></td>
  <td><?=$data->item_name?></td>
  <td><?=$data->pack_size?></td>
  <td><?=$data->unit_name?></td>
	
<td bgcolor="#FFCCFF" style="text-align:right"><?=(int)($i->final_stock/$data->pack_size)?></td>
<td bgcolor="#CCCCFF" style="text-align:right"><?=(int)($i->final_stock%$data->pack_size)?></td>
<td style="text-align:right"><?=$i->rate?></td><td style="text-align:right"><?=$i->Stock_price?></td></tr>
		   <?
}
}

elseif($_POST['report']==1004)
{
		$report="RM Consumtion Report";
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		if(isset($sub_group_id)){$s_con.=' and i.sub_group_id="'.$sub_group_id.'"';} 
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
if(isset($warehouse_id))
		echo '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2">S/L</th>
		<th rowspan="2">Item Code </th>
		<th rowspan="2">Item Name </th>
		<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>
		<th bgcolor="#99CC99">Rate</th>		
		<th bgcolor="#99CC99">Taka</th>
		<th bgcolor="#339999">Qty</th>
		<th bgcolor="#339999">Rate</th>		
		<th bgcolor="#339999">Taka</th>
		<th bgcolor="#FFCC66">Qty</th>
		<th bgcolor="#FFCC66">Rate</th>
		<th bgcolor="#FFCC66">Taka</th>
		<th bgcolor="#FFFF99">Qty</th>
		<th bgcolor="#FFFF99">Rate</th>
		<th bgcolor="#FFFF99">Taka</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
$sql="select distinct j.item_id,i.item_name from item_info i,journal_item j where i.item_id=j.item_id and product_nature='Salable' ".$con." order by i.product_nature,i.item_name";
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date<"'.$f_date.'" and item_id='.$row->item_id.$con);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $pre->pre_amt;
		

		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $pre->pre_amt;
		

		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);
		if($pre_stock>0||$in_stock>0||$out_stock>0||$out_stock>0){
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_id?></td>
		<td><?=$row->item_name?></td>
		<td><?=$pre_stock?></td>
		<td><?=number_format($pre_price,2)?></td>
		<td><?=number_format(($pre_stock*$pre_price),2)?></td>

		<td><?=$in_stock?></td>
		<td><?=number_format($in_price,2)?></td>
		<td><?=number_format(($in_price*$in_stock),2)?></td>


		<td><?=$out_stock?></td>
		<td><?=number_format($out_price,2)?></td>
		<td><?=number_format(($out_price*$out_stock),2)?></td>
		<td><?=$final_stock?></td>
		<td><?=number_format($final_price,2)?></td>
		<td><?=number_format(($final_stock*$final_price),2)?></td>
</tr><? }}?>
		
		</tbody>
		</table>
		<?
}
elseif($_POST['report']==1005)
{
		$report="FG Production &amp; Transferred Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
if(isset($warehouse_id))
		echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2">S/L</th>
		<th rowspan="2">Item Code </th>
		<th rowspan="2">Item Name </th>
		<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT TRANSFERRED</th>
		<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>
		<th bgcolor="#99CC99">Rate</th>		
		<th bgcolor="#99CC99">Taka</th>
		<th bgcolor="#339999">Qty</th>
		<th bgcolor="#339999">Rate</th>		
		<th bgcolor="#339999">Taka</th>
		<th bgcolor="#FFCC66">Qty</th>
		<th bgcolor="#FFCC66">Rate</th>
		<th bgcolor="#FFCC66">Taka</th>
		<th bgcolor="#FFFF99">Qty</th>
		<th bgcolor="#FFFF99">Rate</th>
		<th bgcolor="#FFFF99">Taka</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		$sql="select distinct j.item_id,i.item_name from item_info i,journal_item j where i.item_id=j.item_id and product_nature='Salable' ".$con." order by i.item_id,i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date<"'.$f_date.'" and item_id='.$row->item_id.$con);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $pre->pre_amt;
		

		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $pre->pre_amt;
		

		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);
		if($pre_stock>0||$in_stock>0||$out_stock>0||$out_stock>0){
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_id?></td>
		<td><?=$row->item_name?></td>
		<td><?=$pre_stock; $t_pre_stock +=$pre_stock;?></td>
		<td><?=number_format($pre_price,2)?></td>
		<td><?=number_format(($pre_stock*$pre_price),2)?></td>

		<td><?=$in_stock; $t_in_stock+=$in_stock;?></td>
		<td><?=number_format($in_price,2)?></td>
		<td><?=number_format(($in_price*$in_stock),2)?></td>


		<td><?=$out_stock; $t_out_stock+=$out_stock;?></td>
		<td><?=number_format($out_price,2)?></td>
		<td><?=number_format(($out_price*$out_stock),2)?></td>
		<td><?=$final_stock; $t_final_stock+=$final_stock;?></td>
		<td><?=number_format($final_price,2)?></td>
		<td><?=number_format(($final_stock*$final_price),2)?></td>
</tr>
<? }}?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style4">
	      <?=number_format($t_pre_stock,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style5">
	      <?=number_format($t_in_stock,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style6">
	      <?=number_format($t_out_stock,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
	      <?=number_format($t_final_stock,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}



elseif($_POST['report']==2005)
{
		$report="Daily Production Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="8" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
if(isset($warehouse_id))
		echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="9%" rowspan="2" bgcolor="#8DB4E3">S/L</th>
		<th width="21%" rowspan="2" bgcolor="#8DB4E3">Item Code </th>
		<th width="34%" rowspan="2" bgcolor="#8DB4E3">Item Name </th>
		<th width="11%" rowspan="2" bgcolor="#8DB4E3">FG Code </th>
		<th colspan="2" bgcolor="#8DB4E3" style="text-align:center">PRODUCT RECEIVED</th>
		</tr>
		<tr>
		<th width="13%" bgcolor="#8DB4E3">Unit</th>
		<th width="13%" bgcolor="#8DB4E3">Qty</th>		
		</tr>
		</thead><tbody>
		<? $sl=1;
		$sql="select distinct j.item_id, i.unit_name,i.item_name, i.finish_goods_code from item_info i,journal_item j where  i.item_id=j.item_id and product_nature='Salable' ".$con." order by i.item_id,i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date<"'.$f_date.'" and item_id='.$row->item_id.$con);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$in_stock = $in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $pre->pre_amt;
		

		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $pre->pre_amt;
		

		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);
		if($pre_stock>0||$in_stock>0||$out_stock>0||$out_stock>0){
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_id?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->unit_name?></td>
		<td><?=number_format($in_stock,2); $t_in_stock+=$in_stock;?></td>
		</tr>
<? }}?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=number_format($t_in_stock,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}





/*Stock P0sition Report*/


elseif($_POST['report']==8888)

{

		if($warehouse_id>0) {

		$vendor_con = ' and  a.vendor_id= "'.$vendor_id.'" ';


		$wr = find_all_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);

		}
		
		if($t_date!="") {

		$con.= ' and  a.sale_date between "'.$f_date.'" and "'.$t_date.'" ';
		
		if($warehouse_id!='')
		$con .= ' and c.master_warehouse_id = "'.$warehouse_id.'" ';
		
		if($se_id!='')
		$con .= ' and a.se_id = "'.$se_id.'" ';
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
		
		}



		$report = 'Stock Position Status';

		?>
		
	
						<?

						  $sqlc = 'select a.sale_no, a.sale_no as sale_no,  DATE_FORMAT(a.sale_date, "%d-%m-%Y") as sale_date, c.warehouse_name as SE_Name, sum(a.today_close) as closing, a.status,  u.fname as entry_by,a.entry_at
from item_sale_issue a, warehouse c, user_activity_management u
where a.se_id=c.warehouse_id and a.entry_by=u.user_id  and c.master_warehouse_id=5  '.$con.' group by a.sale_no order by a.sale_date';
						
						$queryc = db_query($sqlc);

						$count = mysqli_num_rows($queryc);

						if($count>0){

						?>

						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

						<thead>
						
						<tr>

        <td  colspan="6"  style="text-align:center; color:#000; font-size:20px; font-weight:bold;border:0px;"> <strong style="font-size:22px"> <?

if($_SESSION['user']['group']>1)

echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);

else

echo $_SESSION['proj_name'];

				?></strong>
				<h2 style=" margin:0; padding:0; padding-top:8px;"><? if($warehouse_id>0) echo 'House: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id)?></h2>				</td>
      </tr>

            <tr>

              <td colspan="6" style="border:0px;">
			  
			 


			  
			  
			  <?

		echo '<div class="header">';

		

		if(isset($report)) 

echo '<h2>'.$report.'</h2>';



?>

<h2>

<? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?>
</h2>

		<?

		echo '<h2>Date Interval: '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';

		?>              </td>
            </tr>
          </thead>

						<tr>

						  <td width="5%" bgcolor="#FFCCCC"><strong>S/L</strong></td>

						  <td width="13%" bgcolor="#FFCCCC"><strong>View Report </strong></td>

						  <td width="13%" bgcolor="#FFCCCC"><strong>Tr Date</strong></td>

						  <td width="18%" bgcolor="#FFCCCC"><strong>Stock    Name</strong></td>

						  <td width="13%" bgcolor="#FF0000"><strong>Entry By </strong></td>
						<td width="11%" bgcolor="#FF0000"><strong>Entry At </strong></td>
						</tr>
						

<?

while($data = mysqli_fetch_object($queryc)){




$vat_packing=$data->tax;



$amount=$data->amount;

$vat_amount=($amount*$vat_packing)/100;

$tot_amount=($amount+$vat_amount);


?>



<tr>

  <td><span class="style5">
    <?=++$z?>
  </span></td>

  <td><a href="../raw_tea/stock_position_report.php?v_no=<?= $data->sale_no?>" target="_blank"><span class="style6">
    <?= $data->sale_no?>
  </span></a></td>

  <td><?= $data->sale_date?></td>

  <td width="18%" height="20"><?= $data->SE_Name?></td>

  <td><?= $data->entry_by?></td>
<td><?= $data->entry_at?></td>
</tr>

						<? }?>

						

<tr>

  <td>&nbsp;</td>

  <td>&nbsp;</td>

  <td>&nbsp;</td>

  <td height="20">&nbsp;</td>

  <td align="right"><span class="style7">
  
</span></td>
<td align="right"><span class="style7">
  
</span></td>
</tr>
</table>

						<br />

						<? }?>

		<?

}



/*Stock Ppsition Report*/



elseif($_POST['report']==2006)
{
		$report="Product Movement Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="9" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
if(isset($warehouse_id))
		echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2">S/Lll</th>
		<th rowspan="2">Item Code </th>
		<th rowspan="2">Item Name </th>
		<th bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th bgcolor="#FFCC66" style="text-align:center">PRODUCT SALE</th>
		<th bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>
		<th bgcolor="#339999">Qty</th>
		<th bgcolor="#FFCC66">Qty</th>
		<th bgcolor="#FFFF99">Qty</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		$sql="select distinct j.item_id,i.item_name from item_info i,journal_item j where i.item_id=j.item_id and product_nature='Salable' ".$con." order by i.item_id,i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date<"'.$f_date.'" and item_id='.$row->item_id.$con);
		$pre_stock = $pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$in_stock = $in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $pre->pre_amt;
		

		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);
		$out_stock = $out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $pre->pre_amt;
		

		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);
		if($pre_stock>0||$in_stock>0||$out_stock>0||$out_stock>0){
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_id?></td>
		<td><?=$row->item_name?></td>
		<td><?=number_format($pre_stock,2); $t_pre_stock +=$pre_stock;?></td>
		<td><?=number_format($in_stock,2); $t_in_stock+=$in_stock;?></td>
		<td><?=number_format($out_stock,2); $t_out_stock+=$out_stock;?></td>
		<td><?=number_format($final_stock,2); $t_final_stock+=$final_stock;?></td>
		</tr>
<? }}?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style4">
	      <?=number_format($t_pre_stock,2);?>
		  </span></td>
		  <td><span class="style5">
	      <?=number_format($t_in_stock,2);?>
		  </span></td>
		  <td><span class="style6">
	      <?=number_format($t_out_stock,2);?>
		  </span></td>
		  <td><span class="style7">
	      <?=number_format($t_final_stock,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}






















elseif($_POST['report']==20060202)
{
		$report="Inventory Analysis (All Transaction Type)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="19" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="2%" rowspan="2">S/L</th>
		<th width="4%" rowspan="2">SKU Code </th>
		<th width="19%" rowspan="2">Item Name </th>
		<th width="7%" rowspan="2">Sub Group </th>
		<th width="6%" bgcolor="#99CC99" style="text-align:center">OPENING  </th>
		<th colspan="6" bgcolor="#339999" style="text-align:center">PRODUCT PURCHESED </th>
		<th width="11%" bgcolor="#FFCC66" style="text-align:center">STOCK IN </th>
		<th colspan="4" bgcolor="#99FFFF" style="text-align:center"> WAREHOUSE DISPATCH </th>
		<th width="6%" rowspan="2" bgcolor="#FF3300" style="text-align:center">CLOSING STOCK</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>
		<th width="4%" bgcolor="#339999">PO</th>
		<th width="4%" bgcolor="#339999">PR</th>
		<th width="5%" bgcolor="#339999">Damage</th>
		<th width="3%" bgcolor="#339999">Short</th>
		<th width="6%" bgcolor="#339999">PR Extra</th>
		<th width="6%" bgcolor="#339999">Sales Return </th>
		<th bgcolor="#FFCC66">Qty (PR+SR+ PR Extra) </th>
		<th width="4%" bgcolor="#99FFFF">Sales</th>
		<th width="3%" bgcolor="#99FFFF">FOC</th>
		<th width="5%" bgcolor="#99FFFF">Scheme</th>
		<th width="6%" bgcolor="#99FFFF">Damage</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		  $sql = "select j.item_id, sum(item_in-item_ex) as pre_stock from journal_item j where  ji_date<'".$f_date."' ".$con." group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $opening_stock[$info->item_id]=$info->pre_stock;
  		 
		}
		
		
		  $sql = "select p.item_id, sum(qty) as invoice_qty from purchase_master m, purchase_invoice p where m.po_no=p.po_no  and p.po_date between '".$f_date."' and '".$t_date."'  and m.status in ('CHECKED','COMPLETED') group by p.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $invoice_qty[$info->item_id]=$info->invoice_qty;
  		 
		}
		
		
		  $sql = "select pr.item_id, sum(pr.qty) as pr_good, sum(pr.damage_qty) as pr_damage, sum(pr.short_qty) as pr_short from purchase_receive pr where  pr.rec_date between '".$f_date."' and '".$t_date."'  group by pr.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pr_good[$info->item_id]=$info->pr_good;
		 $pr_damage[$info->item_id]=$info->pr_damage;
		 $pr_short[$info->item_id]=$info->pr_short;
  		 
		}
		
		 $sql = "select j.item_id, sum(j.item_in) as pr_extra from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Extra'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pr_extra[$info->item_id]=$info->pr_extra;
  		 
		}
		
		
		$sql = "select j.item_id, sum(j.item_in) as sales_return from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Sales Return'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_return[$info->item_id]=$info->sales_return;
  		 
		}
		
		
		 $sql = "select j.item_id, sum(j.item_ex) as sales_qty from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Sales'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_qty[$info->item_id]=$info->sales_qty;
  		 
		}
		
		
		$sql = "select j.item_id, sum(j.item_ex) as foc_qty from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='FOC'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $foc_qty[$info->item_id]=$info->foc_qty;
  		 
		}
		
		$sql = "select j.item_id, sum(j.item_ex) as scheme_qty from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='SCHEME'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $scheme_qty[$info->item_id]=$info->scheme_qty;
  		 
		}
		
		$sql = "select j.item_id, sum(j.item_ex) as damage_qty from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='DAMAGE'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $damage_qty[$info->item_id]=$info->damage_qty;
  		 
		}
		
		
		$sql = "select j.item_id, sum(item_in-item_ex) as closing_stock from journal_item j where  ji_date<='".$t_date."' ".$con." group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $closing_stock[$info->item_id]=$info->closing_stock;
  		 
		}

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		 $sql="select distinct i.sku_code, i.item_id, i.item_name, s.sub_group_name from item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id  ".$item_sub_con." order by i.item_id, i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=number_format($opening_stock[$row->item_id],2);  $total_opening_stock +=$opening_stock[$row->item_id];?> </td>
		<td><?=number_format($invoice_qty[$row->item_id],2);  $total_invoice_qty +=$invoice_qty[$row->item_id];?> </td>
		<td><?=number_format($pr_good[$row->item_id],2); $total_pr_good +=$pr_good[$row->item_id];?></td>
		<td><?=number_format($pr_damage[$row->item_id],2); $total_pr_damage +=$pr_damage[$row->item_id];?></td>
		<td><?=number_format($pr_short[$row->item_id],2); $total_pr_short +=$pr_short[$row->item_id];?></td>
		<td><?=number_format($pr_extra[$row->item_id],2); $total_pr_extra +=$pr_extra[$row->item_id];?></td>
		<td><?=number_format($sales_return[$row->item_id],2); $total_sales_return +=$sales_return[$row->item_id];?></td>
		<td><?=number_format($stock_in_purchase=($pr_good[$row->item_id]+$pr_extra[$row->item_id]+$sales_return[$row->item_id]),2); 
							$total_stock_in_purchase +=($pr_good[$row->item_id]+$pr_extra[$row->item_id]+$sales_return[$row->item_id]);?></td>
		<td><?=number_format($sales_qty[$row->item_id],2); $total_sales_qty +=$sales_qty[$row->item_id]; ?></td>
		<td><?=number_format($foc_qty[$row->item_id],2); $total_foc_qty +=$foc_qty[$row->item_id];?></td>
		<td><?=number_format($scheme_qty[$row->item_id],2); $total_scheme_qty +=$scheme_qty[$row->item_id];?></td>
		<td><?=number_format($damage_qty[$row->item_id],2); $total_damage_qty +=$damage_qty[$row->item_id];?></td>
		<td><?=number_format($closing_stock[$row->item_id],2); $total_closing_stock +=$closing_stock[$row->item_id];?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style4">
	      <?=number_format($total_opening_stock,2);?>
		  </span></td>
		  <td><span class="style5">
	      <?=number_format($total_invoice_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_pr_good,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_pr_damage,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_pr_short,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_pr_extra,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_return,2);?>
		  </span></td>
		  <td><span class="style6">
	      <?=number_format($total_stock_in_purchase,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_foc_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_scheme_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_damage_qty,2);?>
		  </span></td>
		  <td><span class="style7">
	      <?=number_format($total_closing_stock,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}







elseif($_POST['report']==220803001)
{
		$report="Warehouse Present Stock (Finish Goods)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="15" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>For The Date of: '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="19%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">Brand</th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#00CC99" style="text-align:center">Stock In Warehouse</th>
		<th colspan="3" bgcolor="#FF6347" style="text-align:center">Total Stock</th>
		</tr>
		<tr>
		<th width="6%" bgcolor="#00CC99" style="text-align:center">Quantity</th>
		<th width="6%" bgcolor="#00CC99" style="text-align:center">Price</th>
		<th width="6%" bgcolor="#00CC99" style="text-align:center">Value</th>
		<th width="6%" bgcolor="#FF6347" style="text-align:center">Quantity</th>
		<th width="6%" bgcolor="#FF6347" style="text-align:center">Price</th>
		<th width="6%" bgcolor="#FF6347" style="text-align:center">Value</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		$chkoutdate = $to_date;
    	$PreviousDate =  date('Y-m-d', strtotime($chkoutdate.' - 3 month'));
    	$PreviousDate; 
		
		
		

		
		 $sql = "select pi.item_id, sum(pi.qty) as po_qty from purchase_master pm, purchase_invoice pi 
		 where pm.po_no=pi.po_no and  pm.po_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pi.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $po_qty[$info->item_id]=$info->po_qty;
		}
		
		
		 $sql = "select pr.item_id, sum(pr.qty) as pr_qty, sum(pr.damage_qty) as damage_qty, sum(pr.short_qty) as short_qty from purchase_master pm, purchase_receive pr 
		 where pm.po_no=pr.po_no and  pr.rec_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pr.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pr_qty[$info->item_id]=$info->pr_qty;
		 $damage_qty[$info->item_id]=$info->damage_qty;
		 $short_qty[$info->item_id]=$info->short_qty;
		}
		
		
	
		
		
		 $sql = "select j.item_id, sum(item_in-item_ex) as closing_stock from journal_item j where  ji_date<='".$t_date."' ".$con." group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $closing_stock[$info->item_id]=$info->closing_stock;
  		 
		}

		
		if($_POST['sub_group_id']!='')
		$sub_group_con .= ' and i.sub_group_id = "'.$_POST['sub_group_id'].'" ';
		
		if($_POST['item_brand']!='')
		$item_brand_con .= ' and i.item_brand = "'.$_POST['item_brand'].'" ';
		
		
		if($_POST['watt_type']!='')
		$watt_type_con .= ' and i.watt_type = "'.$_POST['watt_type'].'" ';
		
		
		$sql = "select id, brand_name from item_brand where  1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $brand_name[$info->id]=$info->brand_name;
		}
		
		
		 $sql="select distinct i.finish_goods_code, i.item_brand, i.item_id, i.item_name, i.a_price as cost_price, s.sub_group_name from item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id  ".$sub_group_con.$item_brand_con.$watt_type_con." and s.group_id=500000000
		 order by s.sub_group_id,i.item_id,i.watt_type";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<? if($closing_stock[$row->item_id]<>0) {?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->item_name?></td>
		<td><?= $brand_name[$row->item_brand]?></td>
		<td><?=$row->sub_group_name?> </td>
		<td><?=number_format($closing_stock[$row->item_id],0); $total_closing_stock +=$closing_stock[$row->item_id];?></td>
		<td><?=$purchase_price =$row->cost_price;?></td>
		<td><?=number_format($closing_stock_value = $closing_stock[$row->item_id]*$purchase_price,2); $total_closing_stock_value +=$closing_stock_value;?></td>
		<td><?=number_format($total_stock_qty = $closing_stock[$row->item_id]+$qty_in_transit,0); $total_total_stock_qty +=$total_stock_qty;?></td>
		<td><?=$purchase_price = $row->cost_price;?></td>
		<td><?=number_format($total_stock_value = $total_stock_qty*$purchase_price,2); $total_total_stock_value +=$total_stock_value;?></td>
		</tr>
<? }}?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="3"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
	      <?=number_format($total_closing_stock,0);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=number_format($total_closing_stock_value,2);?>
		  </span></td>
		  <td><span class="style7">
            <?=number_format($total_total_stock_qty,0);?>
          </span></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
            <?=number_format($total_total_stock_value,2);?>
          </span></td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}





elseif($_POST['report']==250130001)
{
		$report="Warehouse Present Stock (Finish Goods)";		
		if(isset($warehouse_id)){$con.=' and warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="15" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		<tr>
		<th width="2%" bgcolor="#33CCCC">SL</th>
		<th width="8%" bgcolor="#33CCCC">SKU  </th>
		<th width="21%" bgcolor="#33CCCC">Item Name </th>
		<th width="12%" bgcolor="#33CCCC">Watt</th>
		<th width="10%" bgcolor="#33CCCC">Brand</th>
		<th width="15%" bgcolor="#33CCCC">Sub Group </th>
		<th width="8%" bgcolor="#00CC99" style="text-align:center">Opening Qty </th>
		<th width="8%" bgcolor="#00CC99" style="text-align:center">Production Qty </th>
		<th width="8%" bgcolor="#00CC99" style="text-align:center">Sales Qty </th>
		<th width="8%" bgcolor="#FF6347" style="text-align:center">Closing Qty </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		$chkoutdate = $to_date;
    	$PreviousDate =  date('Y-m-d', strtotime($chkoutdate.' - 3 month'));
    	$PreviousDate; 

		
		$sql = "select item_id, sum(item_in-item_ex) as opening_qty
		 from journal_item where 1 and ji_date<'".$f_date."' ".$con."  group by item_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $opening_qty[$info->item_id]=$info->opening_qty;
		}
		
		$sql = "select item_id, sum(item_in) as in_qty, sum(item_ex) as ex_qty
		 from journal_item where 1 and ji_date BETWEEN '".$f_date."' AND '".$t_date."' ".$con."  group by item_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $in_qty[$info->item_id]=$info->in_qty;
		 $ex_qty[$info->item_id]=$info->ex_qty;
		}
		
		
		  $sql = "select item_id,  sum(item_in-item_ex) as closing_qty
		 from journal_item where 1 and ji_date <='".$t_date."' ".$con." group by item_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $closing_qty[$info->item_id]=$info->closing_qty;
		}
		

		
		if($_POST['sub_group_id']!='')
		$sub_group_con .= ' and i.sub_group_id = "'.$_POST['sub_group_id'].'" ';
		
		if($_POST['item_id']!='')
		$item_con .= ' and i.item_id = "'.$_POST['item_id'].'" ';
		
		if($_POST['item_brand']!='')
		$item_brand_con .= ' and i.item_brand = "'.$_POST['item_brand'].'" ';
		
		
		if($_POST['watt_type']!='')
		$watt_type_con .= ' and i.watt_type = "'.$_POST['watt_type'].'" ';
		
		
		$sql = "select id, brand_name from item_brand where  1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $brand_name[$info->id]=$info->brand_name;
		}
		
		$sql = "select id, watt_type from watt_type where  1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $watt_type[$info->id]=$info->watt_type;
		}
		
		 $sql="select  i.finish_goods_code, i.item_brand, i.watt_type, i.item_id, i.item_name, i.a_price as cost_price, s.sub_group_name from production_receive_detail p, item_info i, item_sub_group s where p.item_id=i.item_id and i.sub_group_id=s.sub_group_id  ".$item_con.$sub_group_con.$item_brand_con.$watt_type_con." 
		 group by p.item_id order by s.sub_group_id,i.item_id,i.watt_type";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<? if($opening_qty[$row->item_id]<>0 || $in_qty[$row->item_id]<>0 || $ex_qty[$row->item_id]<>0 || $closing_qty[$row->item_id]<>0) {?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->finish_goods_code?>  </td>
		<td><?=$row->item_name?> <? if($_SESSION['user']['id']==10001){ echo $row->item_id; }?></td>
		<td><?=$watt_type[$row->watt_type]?></td>
		<td><?= $brand_name[$row->item_brand]?></td>
		<td><?=$row->sub_group_name?> </td>
		<td><?=number_format($opening_qty[$row->item_id],0); $total_opening_qty +=$opening_qty[$row->item_id];?></td>
		<td><?=number_format($in_qty[$row->item_id],0); $total_in_qty +=$in_qty[$row->item_id];?></td>
		<td><?=number_format($ex_qty[$row->item_id],0); $total_ex_qty +=$ex_qty[$row->item_id];?></td>
		<td><?=number_format($closing_qty[$row->item_id],0); $total_closing_qty +=$closing_qty[$row->item_id];?></td>
		</tr>
<? }}?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="4"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
	      <?=number_format($total_opening_qty,0);?>
		  </span></td>
		  <td><span class="style7">
            <?=number_format($total_in_qty,0);?>
          </span></td>
		  <td><span class="style7">
            <?=number_format($total_ex_qty,0);?>
          </span></td>
		  <td><span class="style7">
            <?=number_format($total_closing_qty,0);?>
          </span></td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}







elseif($_POST['report']==2501050002)

{

		
		if($t_date!="") {

		$pr_date_con.= ' and  m.pr_date between "'.$f_date.'" and "'.$t_date.'" ';

		}
		
		if($sub_group_id>0) {

		$sub_group_id_con = ' and  i.sub_group_id= "'.$sub_group_id.'" ';

		}
		
		if($vendor_id>0) {

		$vendor_id_con = ' and  m.vendor_id= "'.$vendor_id.'" ';

		}
		
		
		if($item_brand>0) {

		$item_brand_con = ' and  i.item_brand= "'.$item_brand.'" ';

		}
		
		if($watt_type>0) {

		$watt_type_con = ' and  i.watt_type= "'.$watt_type.'" ';

		}
		
		if($item_id>0) {

		$item_id_con = ' and  i.item_id= "'.$item_id.'" ';

		}



		$report = 'Date Wise FG Production Report';

		?>



						<?
						
						 $sql = 'select m.pr_date from production_receive_master m, production_receive_detail c, item_info i
						 where m.pr_no=c.pr_no and c.item_id=i.item_id '.$vendor_id_con.$sub_group_id_con.$pr_date_con.$item_brand_con.$watt_type_con.$item_id_con.' group by m.pr_date order by m.pr_date';
						  $query = db_query($sql);
						  $cols = mysqli_num_rows($query);
						  while($data=mysqli_fetch_object($query)){++$i;
						  $pr_date[$i] = $data->pr_date;
		  				}
						
						
						
						 $sql  = 'select c.item_id, m.pr_date, sum(c.total_unit) as production_qty
						  from production_receive_master m, production_receive_detail c, item_info i
						 where m.pr_no=c.pr_no and c.item_id=i.item_id  '.$vendor_id_con.$sub_group_id_con.$pr_date_con.$item_brand_con.$watt_type_con.$item_id_con.' 
				 		group by c.item_id, m.pr_date';
						  $query = db_query($sql);
						  $col  = mysqli_num_rows($query);
						  while($data=mysqli_fetch_object($query)){++$i;
						  $vals[$data->item_id][$data->pr_date] = $data->production_qty;
						  $total_date[$data->pr_date] = $total_date[$data->pr_date] + $data->production_qty;
						  $total_item[$data->item_id] = $total_item[$data->item_id] + $data->production_qty;
		 				 }
						 
						 
						 $sql = "select vendor_id, vendor_name from  vendor where 1 group by vendor_id";
						 $query = db_query($sql);
						 while($info=mysqli_fetch_object($query)){
						 $vendor_name[$info->vendor_id]=$info->vendor_name;
						}
						
						
						$sql = "select id, watt_type as watt_type_view from  watt_type where 1 group by id";
						 $query = db_query($sql);
						 while($info=mysqli_fetch_object($query)){
						 $watt_type_view[$info->id]=$info->watt_type_view;
						}
						
						$sql = "select id, brand_name from  item_brand where 1 group by id";
						 $query = db_query($sql);
						 while($info=mysqli_fetch_object($query)){
						 $brand_name[$info->id]=$info->brand_name;
						}
						

						   $sqlc = 'select i.watt_type, i.item_brand, c.item_id, i.item_name, i.unit_name, i.sub_group_id, m.vendor_id
						   from production_receive_master m, production_receive_detail c, item_info i
						 where m.pr_no=c.pr_no and c.item_id=i.item_id
						 '.$vendor_id_con.$sub_group_id_con.$pr_date_con.$item_brand_con.$watt_type_con.$item_id_con.' 
						  group by c.item_id order by i.sub_group_id,i.item_id ';
						
						$queryc = db_query($sqlc);

						$count = mysqli_num_rows($queryc);

						//if($count>0){

						?>

						
		  
		  
		  <table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<!--<img src="../../../logo/fg-logo.png" style=" height:95px">-->
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		 <? if ($location_id>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Location: <?=find_a_field('factory_location','location_name','id='.$location_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		 
		
		 
		
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($f_date));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($t_date));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		  
		  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;"  id="ExportTable">
<thead>
						<tr>

						  <td width="7%" bgcolor="#66CCCC"><strong>SL </strong></td>

						  <td width="27%" bgcolor="#66CCCC"><strong>Vendor</strong></td>
						  <td width="27%" bgcolor="#66CCCC"><strong>Brand</strong></td>
						  <td width="11%" bgcolor="#66CCCC"><strong>Watt</strong></td>
						  <td width="36%" bgcolor="#66CCCC"><strong>Item Name</strong></td>
						  <?

for($i=1;$i<=$cols;$i++)
{
echo '<td  bgcolor="#66CCCC" rowspan="0" style="white-space:nowrap"><strong>'.date("d-M-y",strtotime($pr_date[$i])).'</strong></td>';
}

?>

 <td width="19%" bgcolor="#66CCCC"><strong>Total Qty </strong></td>
				</tr>
			</thead>

<?

while($data = mysqli_fetch_object($queryc)){

$si ++;

?>

<tbody>
<tr>

  <td height="20" ><?=$si; $tot_sl_count +=$si;?></td>
  <td><?= $vendor_name[$data->vendor_id]?></td>
  <td><?=$brand_name[$data->item_brand]?></td>
  <td><?=$watt_type_view[$data->watt_type];?></td>
  <td style="white-space:nowrap;"><?= $data->item_name;?></td>
  <?

for($i=1;$i<=$cols;$i++)
{
echo '<td >'.number_format($vals[$data->item_id][$pr_date[$i]],2).'</td>';

}

?>

<td><?= number_format($total_item[$data->item_id],2); $tot_total_item +=$total_item[$data->item_id];?></td>
 </tr>

						<? }?>

						

<tr>

  <td height="20">&nbsp;</td>

  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><strong>TOTAL</strong></td>
  <?
for($i=1;$i<=$cols;$i++)
{
echo '<td><strong>'.number_format($total_date[$pr_date[$i]],2).'</strong></td>';
}
?>

<td><strong><?=number_format($tot_total_item,2);?></strong></td>
</tr>
</tbody>
</table>

						<br />

						<? //}?>

		<?

}






elseif($_POST['report']==2501050003)

{

		
		if($t_date!="") {

		$pr_date_con.= ' and  c.chalan_date between "'.$f_date.'" and "'.$t_date.'" ';

		}
		
		if($sub_group_id>0) {

		$sub_group_id_con = ' and  i.sub_group_id= "'.$sub_group_id.'" ';

		}
		
		if($vendor_id>0) {

		$vendor_id_con = ' and  m.vendor_id= "'.$vendor_id.'" ';

		}
		
		
		if($item_brand>0) {

		$item_brand_con = ' and  i.item_brand= "'.$item_brand.'" ';

		}
		
		if($watt_type>0) {

		$watt_type_con = ' and  i.watt_type= "'.$watt_type.'" ';

		}
		
		if($item_id>0) {

		$item_id_con = ' and  i.item_id= "'.$item_id.'" ';

		}



		$report = 'Date Wise FG Sales Report';

		?>



						<?
						
						 $sql = 'select c.chalan_date as pr_date from sale_do_master m, sale_do_chalan c, item_info i
						 where m.do_no=c.do_no and c.item_id=i.item_id '.$vendor_id_con.$sub_group_id_con.$pr_date_con.$item_brand_con.$watt_type_con.$item_id_con.' group by c.chalan_date order by c.chalan_date';
						  $query = db_query($sql);
						  $cols = mysqli_num_rows($query);
						  while($data=mysqli_fetch_object($query)){++$i;
						  $pr_date[$i] = $data->pr_date;
		  				}
						
						
						
						 $sql  = 'select c.item_id, c.chalan_date as pr_date, sum(c.total_unit) as production_qty
						  from sale_do_master m, sale_do_chalan c,  item_info i
						 where m.do_no=c.do_no and c.item_id=i.item_id  '.$vendor_id_con.$sub_group_id_con.$pr_date_con.$item_brand_con.$watt_type_con.$item_id_con.' 
				 		group by c.item_id, c.chalan_date';
						  $query = db_query($sql);
						  $col  = mysqli_num_rows($query);
						  while($data=mysqli_fetch_object($query)){++$i;
						  $vals[$data->item_id][$data->pr_date] = $data->production_qty;
						  $total_date[$data->pr_date] = $total_date[$data->pr_date] + $data->production_qty;
						  $total_item[$data->item_id] = $total_item[$data->item_id] + $data->production_qty;
		 				 }
						 
						 
						 $sql = "select vendor_id, vendor_name from  vendor where 1 group by vendor_id";
						 $query = db_query($sql);
						 while($info=mysqli_fetch_object($query)){
						 $vendor_name[$info->vendor_id]=$info->vendor_name;
						}
						
						
						$sql = "select id, watt_type as watt_type_view from  watt_type where 1 group by id";
						 $query = db_query($sql);
						 while($info=mysqli_fetch_object($query)){
						 $watt_type_view[$info->id]=$info->watt_type_view;
						}
						
						$sql = "select id, brand_name from  item_brand where 1 group by id";
						 $query = db_query($sql);
						 while($info=mysqli_fetch_object($query)){
						 $brand_name[$info->id]=$info->brand_name;
						}
						

						   $sqlc = 'select i.watt_type, i.item_brand, c.item_id, i.item_name, i.unit_name, i.sub_group_id, i.finish_goods_code
						   from sale_do_master m, sale_do_chalan c, item_info i
						 where m.do_no=c.do_no and c.item_id=i.item_id
						 '.$vendor_id_con.$sub_group_id_con.$pr_date_con.$item_brand_con.$watt_type_con.$item_id_con.' 
						  group by c.item_id order by i.sub_group_id,i.item_id ';
						
						$queryc = db_query($sqlc);

						$count = mysqli_num_rows($queryc);

						//if($count>0){

						?>

						
		  
		  
		  <table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<!--<img src="../../../logo/fg-logo.png" style=" height:95px">-->
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		 <? if ($location_id>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Location: <?=find_a_field('factory_location','location_name','id='.$location_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		 
		
		 
		
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($f_date));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($t_date));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		  
		  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;"  id="ExportTable">
<thead>
						<tr>

						  <td width="7%" bgcolor="#66CCCC"><strong>SL </strong></td>

						  <td width="27%" bgcolor="#66CCCC"><strong>SKU</strong></td>
						  <td width="27%" bgcolor="#66CCCC"><strong>Brand</strong></td>
						  <td width="11%" bgcolor="#66CCCC"><strong>Watt</strong></td>
						  <td width="36%" bgcolor="#66CCCC"><strong>Item Name</strong></td>
						  <?

for($i=1;$i<=$cols;$i++)
{
echo '<td  bgcolor="#66CCCC" rowspan="0" style="white-space:nowrap"><strong>'.date("d-M-y",strtotime($pr_date[$i])).'</strong></td>';
}

?>

 <td width="19%" bgcolor="#66CCCC"><strong>Total Qty </strong></td>
				</tr>
			</thead>

<?

while($data = mysqli_fetch_object($queryc)){

$si ++;

?>

<tbody>
<tr>

  <td height="20" ><?=$si; $tot_sl_count +=$si;?></td>
  <td><?= $data->finish_goods_code?></td>
  <td><?=$brand_name[$data->item_brand]?></td>
  <td><?=$watt_type_view[$data->watt_type];?></td>
  <td style="white-space:nowrap;"><?= $data->item_name;?></td>
  <?

for($i=1;$i<=$cols;$i++)
{
echo '<td >'.number_format($vals[$data->item_id][$pr_date[$i]],2).'</td>';

}

?>

<td><?= number_format($total_item[$data->item_id],2); $tot_total_item +=$total_item[$data->item_id];?></td>
 </tr>

						<? }?>

						

<tr>

  <td height="20">&nbsp;</td>

  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><strong>TOTAL</strong></td>
  <?
for($i=1;$i<=$cols;$i++)
{
echo '<td><strong>'.number_format($total_date[$pr_date[$i]],2).'</strong></td>';
}
?>

<td><strong><?=number_format($tot_total_item,2);?></strong></td>
</tr>
</tbody>
</table>

						<br />

						<? //}?>

		<?

}








elseif($_POST['report']==2502040001)

{

		
		if($t_date!="") {

		$ch_date_con.= ' and  c.chalan_date between "'.$f_date.'" and "'.$t_date.'" ';

		}
		
		if($sub_group_id>0) {

		$sub_group_id_con = ' and  i.sub_group_id= "'.$sub_group_id.'" ';

		}
		
		if($vendor_id>0) {

		$vendor_id_con = ' and  m.vendor_id= "'.$vendor_id.'" ';

		}
		
		
		if($item_brand>0) {

		$item_brand_con = ' and  i.item_brand= "'.$item_brand.'" ';

		}
		
		if($watt_type>0) {

		$watt_type_con = ' and  i.watt_type= "'.$watt_type.'" ';

		}
		
		if($item_id>0) {

		$item_id_con = ' and  i.item_id= "'.$item_id.'" ';

		}



		$report = 'Finished Goods National Sales Report';

		?>



						<?
						
						 $sql = 'select i.item_id, i.item_name from  sale_do_chalan c, item_info i
						 where c.item_id=i.item_id '.$ch_date_con.' group by c.item_id order by i.item_id';
						  $query = db_query($sql);
						  $cols = mysqli_num_rows($query);
						  while($data=mysqli_fetch_object($query)){++$i;
						  $item_id[$i] = $data->item_id;
						  $item_name[$i] = $data->item_name;
		  				 }
						
						 $sql  = 'select c.dealer_code, c.item_id, sum(c.total_unit) as sales_qty
						  from sale_do_chalan c, item_info i
						 where c.item_id=i.item_id '.$ch_date_con.' group by c.dealer_code, c.item_id';
						  $query = db_query($sql);
						  $col  = mysqli_num_rows($query);
						  while($data=mysqli_fetch_object($query)){++$i;
						  $vals[$data->dealer_code][$data->item_id] = $data->sales_qty;
						  $total_item[$data->item_id] = $total_item[$data->item_id] + $data->sales_qty;
						  $total_dealer[$data->dealer_code] = $total_item[$data->dealer_code] + $data->sales_qty;
		 				 }
						 
						 
						  $sqlc = 'select d.dealer_code, d.dealer_name_e
						   from  sale_do_master m, sale_do_chalan c, dealer_info d, item_info i
						 where m.dealer_code=d.dealer_code and m.do_no=c.do_no and c.item_id=i.item_id
						 '.$ch_date_con.'   group by m.dealer_code order by d.dealer_code';
						
						$queryc = db_query($sqlc);

						$count = mysqli_num_rows($queryc);

						//if($count>0){

						?>

						
		  
		  
		  <table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<!--<img src="../../../logo/fg-logo.png" style=" height:95px">-->
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		 <? if ($location_id>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Location: <?=find_a_field('factory_location','location_name','id='.$location_id)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 
		 
		
		 
		
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($f_date));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($t_date));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="../../../logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		  
		  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;"  id="ExportTable">
<thead>
						<tr>

						  <td width="5%" bgcolor="#66CCCC"><strong>SL </strong></td>

						  <td width="63%" bgcolor="#66CCCC"><strong>Dealer Name</strong></td>
						  <?

for($i=1;$i<=$cols;$i++)
{
echo '<td  bgcolor="#66CCCC" rowspan="0" style="white-space:nowrap"><strong>'.$item_name[$i].'</strong></td>';
}

?>

 <td width="32%" bgcolor="#66CCCC"><strong>Total Qty </strong></td>
				</tr>
			</thead>

<?

while($data = mysqli_fetch_object($queryc)){

$si ++;

?>

<tbody>
<tr>

  <td height="20"><?=$si; $tot_sl_count +=$si;?></td>
  <td style="white-space:nowrap;"><?= $data->dealer_name_e;?></td>
  <?

for($i=1;$i<=$cols;$i++)
{
echo '<td >'.number_format($vals[$data->dealer_code][$item_id[$i]],2).'</td>';

}

?>

<td><?= number_format($total_dealer[$data->dealer_code],2); $tot_total_dealer +=$total_dealer[$data->dealer_code];?></td>
 </tr>

						<? }?>

						

<tr>

  <td height="20">&nbsp;</td>

  <td><strong>TOTAL</strong></td>
  <?
for($i=1;$i<=$cols;$i++)
{
echo '<td><strong>'.number_format($total_item[$item_id[$i]],2).'</strong></td>';
}
?>

<td><strong><?=number_format($tot_total_dealer,2);?></strong></td>
</tr>
</tbody>
</table>

						<br />

						<? //}?>

		<?

}












elseif($_POST['report']==20060202002)
{
		$report="Purchase Requisition Analysis Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="21" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>For The Date of: '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="14%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="4" bgcolor="#99FFFF" style="text-align:center"> WAREHOUSE DISPATCH </th>
		<th width="5%" rowspan="2" bgcolor="#FF3300" style="text-align:center">Month Average</th>
		<th colspan="3" bgcolor="#87CEEB" style="text-align:center">Stock In Transit</th>
		<th colspan="3" bgcolor="#00CC99" style="text-align:center">Stock In Warehouse</th>
		<th colspan="3" bgcolor="#6495ED" style="text-align:center">Total Stock</th>
		<th width="7%" rowspan="2" bgcolor="#FF3300" style="text-align:center">Floor Stock  Month </th>
		<th width="6%" rowspan="2" bgcolor="#FF3300" style="text-align:center">Total Stock  Month </th>
		</tr>
		<tr>
		<th width="3%" bgcolor="#99FFFF">Sales</th>
		<th width="3%" bgcolor="#99FFFF">FOC</th>
		<th width="4%" bgcolor="#99FFFF">Scheme</th>
		<th width="7%" bgcolor="#99FFFF">Total</th>
		<th width="4%" bgcolor="#87CEEB"><span style="text-align:center">Quantity</span></th>
		<th width="3%" bgcolor="#87CEEB"><span style="text-align:center">Price</span></th>
		<th width="5%" bgcolor="#87CEEB"><span style="text-align:center">Value</span></th>
		<th width="5%" bgcolor="#00CC99" style="text-align:center">Quantity</th>
		<th width="4%" bgcolor="#00CC99" style="text-align:center">Price</th>
		<th width="6%" bgcolor="#00CC99" style="text-align:center">Value</th>
		<th width="5%" bgcolor="#6495ED" style="text-align:center">Quantity</th>
		<th width="5%" bgcolor="#6495ED" style="text-align:center">Price</th>
		<th width="6%" bgcolor="#6495ED" style="text-align:center">Value</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		$chkoutdate = $to_date;
    	$PreviousDate =  date('Y-m-d', strtotime($chkoutdate.' - 3 month'));
    	$PreviousDate;
		
		
		
		
		 $sql = "select pi.item_id, sum(pi.qty) as po_qty from purchase_master pm, purchase_invoice pi 
		 where pm.po_no=pi.po_no and  pm.po_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pi.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $po_qty[$info->item_id]=$info->po_qty;
		}
		
		
		 $sql = "select pr.item_id, sum(pr.qty) as pr_qty, sum(pr.damage_qty) as damage_qty, sum(pr.short_qty) as short_qty from purchase_master pm, purchase_receive pr 
		 where pm.po_no=pr.po_no and  pr.rec_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pr.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pr_qty[$info->item_id]=$info->pr_qty;
		 $damage_qty[$info->item_id]=$info->damage_qty;
		 $short_qty[$info->item_id]=$info->short_qty;
		} 
		
		
		

		
		 $sql = "select j.item_id, sum(j.item_ex) as sales_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='Sales'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_qty[$info->item_id]=$info->sales_qty;
  		 
		}
		
		
		$sql = "select j.item_id, sum(j.item_ex) as foc_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='FOC'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $foc_qty[$info->item_id]=$info->foc_qty;
  		 
		}
		
		$sql = "select j.item_id, sum(j.item_ex) as scheme_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='SCHEME'  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $scheme_qty[$info->item_id]=$info->scheme_qty;
  		 
		}
		
	
		
		
		$sql = "select j.item_id, sum(item_in-item_ex) as closing_stock from journal_item j where  ji_date<='".$t_date."' ".$con." group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $closing_stock[$info->item_id]=$info->closing_stock;
  		 
		}

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		 $sql="select distinct i.sku_code, i.item_id, i.item_name, i.cost_price, s.sub_group_name from item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id  ".$item_sub_con." 
		 order by s.sub_group_sl,i.item_sl";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=number_format($sales_qty[$row->item_id],0); $total_sales_qty +=$sales_qty[$row->item_id]; ?></td>
		<td><?=number_format($foc_qty[$row->item_id],0); $total_foc_qty +=$foc_qty[$row->item_id];?></td>
		<td><?=number_format($scheme_qty[$row->item_id],0); $total_scheme_qty +=$scheme_qty[$row->item_id];?></td>
		<td><?=number_format($total_item_sales = $sales_qty[$row->item_id]+$foc_qty[$row->item_id]+$scheme_qty[$row->item_id],0); 
		$total_total_item_sales +=$total_item_sales;?></td>
		<td><?= number_format($month_average = $total_item_sales/3,2); ?></td>
		<td><?= number_format($qty_in_transit=($po_qty[$row->item_id]-($pr_qty[$row->item_id]+$damage_qty[$row->item_id]+$short_qty[$row->item_id])),0); $total_qty_in_transit +=$qty_in_transit;?></td>
		<td><?= number_format($purchase_price = (($row->cost_price*15)/100)+$row->cost_price,4);?></td>
		<td><?=number_format($transit_stock_value = $qty_in_transit*$purchase_price,2); $total_transit_stock_value +=$transit_stock_value;?></td>
		<td><?=number_format($closing_stock[$row->item_id],0); $total_closing_stock +=$closing_stock[$row->item_id];?></td>
		<td><?= number_format($purchase_price = (($row->cost_price*15)/100)+$row->cost_price,4);?></td>
		<td><?=number_format($closing_stock_value = $closing_stock[$row->item_id]*$purchase_price,2); $total_closing_stock_value +=$closing_stock_value;?></td>
		<td><?=number_format($total_stock_qty = $closing_stock[$row->item_id]+$qty_in_transit,0); $total_total_stock_qty +=$total_stock_qty;?></td>
		<td><?= number_format($purchase_price = (($row->cost_price*15)/100)+$row->cost_price,4);?></td>
		<td><?=number_format($total_stock_value = $total_stock_qty*$purchase_price,2); $total_total_stock_value +=$total_stock_value;?></td>
		<td><?=number_format($stock_month_floor = $closing_stock[$row->item_id]/$month_average,2);?></td>
		<td><?=number_format($stock_month_total = $total_stock_qty/$month_average,2);?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_sales_qty,0);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_foc_qty,0);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_scheme_qty,0);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_total_item_sales,0);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
            <?=number_format($total_qty_in_transit,0);?>
          </span></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
            <?=number_format($total_transit_stock_value,2);?>
          </span></td>
		  <td><span class="style7">
            <?=number_format($total_closing_stock,0);?>
          </span></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
            <?=number_format($total_closing_stock_value,2);?>
          </span></td>
		  <td><span class="style7">
            <?=number_format($total_total_stock_qty,0);?>
          </span></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
            <?=number_format($total_total_stock_value,2);?>
          </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==2302040001)
{
		$report="Raw Material Requisition Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="21" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		//echo '<h2>For The Date of: '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '<h2>Date Interval : '.date('d-m-Y',strtotime($f_date)).' To '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		
		<tr>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="20%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Order No </th>
		<th width="8%" rowspan="2" bgcolor="#33CCCC">Order Date </th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Lot No </th>
		<th colspan="3" bgcolor="#99FFFF" style="text-align:center">RM Requisition </th>
		</tr>
		<tr>
		<th width="10%" bgcolor="#99FFFF">Quantity</th>
		<th width="9%" bgcolor="#99FFFF">Price</th>
		<th width="11%" bgcolor="#99FFFF">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		//$chkoutdate = $to_date;
    	//$PreviousDate =  date('Y-m-d', strtotime($chkoutdate.' - 3 month'));
    	//$PreviousDate;
		
		
		
	//	
//		 $sql = "select pi.item_id, sum(pi.qty) as po_qty from purchase_master pm, purchase_invoice pi 
//		 where pm.po_no=pi.po_no and  pm.po_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pi.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $po_qty[$info->item_id]=$info->po_qty;
//		}
//		
//		
//		 $sql = "select pr.item_id, sum(pr.qty) as pr_qty, sum(pr.damage_qty) as damage_qty, sum(pr.short_qty) as short_qty from purchase_master pm, purchase_receive pr 
//		 where pm.po_no=pr.po_no and  pr.rec_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pr.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $pr_qty[$info->item_id]=$info->pr_qty;
//		 $damage_qty[$info->item_id]=$info->damage_qty;
//		 $short_qty[$info->item_id]=$info->short_qty;
//		} 
//		
//		
//		
//
//		
//		 $sql = "select j.item_id, sum(j.item_ex) as sales_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='Sales'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sales_qty[$info->item_id]=$info->sales_qty;
//  		 
//		}
//		
//		
//		$sql = "select j.item_id, sum(j.item_ex) as foc_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='FOC'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $foc_qty[$info->item_id]=$info->foc_qty;
//  		 
//		}
//		
//		$sql = "select j.item_id, sum(j.item_ex) as scheme_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='SCHEME'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $scheme_qty[$info->item_id]=$info->scheme_qty;
//  		 
//		}
//		
//	
//		
//		
//		$sql = "select j.item_id, sum(item_in-item_ex) as closing_stock from journal_item j where  ji_date<='".$t_date."' ".$con." group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $closing_stock[$info->item_id]=$info->closing_stock;
//  		 
//		}

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		 $sql="select  i.finish_goods_code, i.item_id, i.item_name, i.cost_price, s.sub_group_name, m.do_no, m.do_date, d.lot_no, d.unit_name, d.unit_price, d.total_unit, d.total_amt
		from rm_do_master m, rm_do_details d, item_info i, item_sub_group s 
		 where m.do_no=d.do_no and d.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  m.do_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con." 
		 order by m.do_date,d.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->item_name?></td>
		<td><a href="../RM_REQ/invoice_print_view.php?do_no=<?=$row->do_no?>" target="_blank"><?=$row->do_no?></a></td>
		<td><?=date('d-M-Y',strtotime($row->do_date))?></td>
		<td><?=$row->lot_no?></td>
		<td><?=number_format($row->total_unit,0); $total_qty +=$row->total_unit; ?></td>
		<td><?=number_format($row->unit_price,3);?></td>
		<td><?=number_format($row->total_amt,0); $total_amt +=$row->total_amt; ?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="4"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,0);?>
		  </span></td>
		  <td><span class="style7">
		   
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_amt,0);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==2302040002)
{
		$report="Raw Material Issue Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="21" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		//echo '<h2>For The Date of: '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '<h2>Date Interval : '.date('d-m-Y',strtotime($f_date)).' To '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		
		<tr>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="20%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Issue No </th>
		<th width="8%" rowspan="2" bgcolor="#33CCCC">Issue Date </th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Lot No </th>
		<th colspan="3" bgcolor="#99FFFF" style="text-align:center">RM Issue </th>
		</tr>
		<tr>
		<th width="10%" bgcolor="#99FFFF">Quantity</th>
		<th width="9%" bgcolor="#99FFFF">Price</th>
		<th width="11%" bgcolor="#99FFFF">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		//$chkoutdate = $to_date;
    	//$PreviousDate =  date('Y-m-d', strtotime($chkoutdate.' - 3 month'));
    	//$PreviousDate;
		
		
		
	//	
//		 $sql = "select pi.item_id, sum(pi.qty) as po_qty from purchase_master pm, purchase_invoice pi 
//		 where pm.po_no=pi.po_no and  pm.po_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pi.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $po_qty[$info->item_id]=$info->po_qty;
//		}
//		
//		
//		 $sql = "select pr.item_id, sum(pr.qty) as pr_qty, sum(pr.damage_qty) as damage_qty, sum(pr.short_qty) as short_qty from purchase_master pm, purchase_receive pr 
//		 where pm.po_no=pr.po_no and  pr.rec_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pr.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $pr_qty[$info->item_id]=$info->pr_qty;
//		 $damage_qty[$info->item_id]=$info->damage_qty;
//		 $short_qty[$info->item_id]=$info->short_qty;
//		} 
//		
//		
//		
//
//		
//		 $sql = "select j.item_id, sum(j.item_ex) as sales_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='Sales'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sales_qty[$info->item_id]=$info->sales_qty;
//  		 
//		}
//		
//		
//		$sql = "select j.item_id, sum(j.item_ex) as foc_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='FOC'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $foc_qty[$info->item_id]=$info->foc_qty;
//  		 
//		}
//		
//		$sql = "select j.item_id, sum(j.item_ex) as scheme_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='SCHEME'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $scheme_qty[$info->item_id]=$info->scheme_qty;
//  		 
//		}
//		
//	
//		
//		
//		$sql = "select j.item_id, sum(item_in-item_ex) as closing_stock from journal_item j where  ji_date<='".$t_date."' ".$con." group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $closing_stock[$info->item_id]=$info->closing_stock;
//  		 
//		}

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.finish_goods_code, i.item_id, i.item_name, i.cost_price, s.sub_group_name, m.do_no, m.do_date, d.chalan_no,  d.chalan_date,  d.lot_no, d.unit_price, d.total_unit, d.total_amt
		from rm_do_master m, rm_do_chalan d, item_info i, item_sub_group s 
		 where m.do_no=d.do_no and d.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  d.chalan_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con." 
		 order by d.chalan_date,d.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->item_name?></td>
		<td><a href="../RM_REQ/chalan_invoice_print_view.php?ch_no=<?=$row->chalan_no?>" target="_blank"><?=$row->chalan_no?></a></td>
		<td><?=date('d-M-Y',strtotime($row->chalan_date))?></td>
		<td><?=$row->lot_no?></td>
		<td><?=number_format($row->total_unit,0); $total_qty +=$row->total_unit; ?></td>
		<td><?=number_format($row->unit_price,3);?></td>
		<td><?=number_format($row->total_amt,0); $total_amt +=$row->total_amt; ?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="4"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,0);?>
		  </span></td>
		  <td><span class="style7">
		   
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_amt,0);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==2302040005)
{
		$report="Raw Material Issue Summary";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="21" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		//echo '<h2>For The Date of: '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '<h2>Date Interval : '.date('d-m-Y',strtotime($f_date)).' To '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		
		<tr>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="20%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th colspan="3" bgcolor="#99FFFF" style="text-align:center">RM Issue </th>
		</tr>
		<tr>
		<th width="10%" bgcolor="#99FFFF">Quantity</th>
		<th width="9%" bgcolor="#99FFFF">Price</th>
		<th width="11%" bgcolor="#99FFFF">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		//$chkoutdate = $to_date;
    	//$PreviousDate =  date('Y-m-d', strtotime($chkoutdate.' - 3 month'));
    	//$PreviousDate;
		
		
		
	//	
//		 $sql = "select pi.item_id, sum(pi.qty) as po_qty from purchase_master pm, purchase_invoice pi 
//		 where pm.po_no=pi.po_no and  pm.po_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pi.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $po_qty[$info->item_id]=$info->po_qty;
//		}
//		
//		
//		 $sql = "select pr.item_id, sum(pr.qty) as pr_qty, sum(pr.damage_qty) as damage_qty, sum(pr.short_qty) as short_qty from purchase_master pm, purchase_receive pr 
//		 where pm.po_no=pr.po_no and  pr.rec_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pr.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $pr_qty[$info->item_id]=$info->pr_qty;
//		 $damage_qty[$info->item_id]=$info->damage_qty;
//		 $short_qty[$info->item_id]=$info->short_qty;
//		} 
//		
//		
//		
//
//		
//		 $sql = "select j.item_id, sum(j.item_ex) as sales_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='Sales'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sales_qty[$info->item_id]=$info->sales_qty;
//  		 
//		}
//		
//		
//		$sql = "select j.item_id, sum(j.item_ex) as foc_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='FOC'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $foc_qty[$info->item_id]=$info->foc_qty;
//  		 
//		}
//		
//		$sql = "select j.item_id, sum(j.item_ex) as scheme_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='SCHEME'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $scheme_qty[$info->item_id]=$info->scheme_qty;
//  		 
//		}
//		
//	
//		
//		
//		$sql = "select j.item_id, sum(item_in-item_ex) as closing_stock from journal_item j where  ji_date<='".$t_date."' ".$con." group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $closing_stock[$info->item_id]=$info->closing_stock;
//  		 
//		}

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.finish_goods_code, i.item_id, i.item_name, i.cost_price, s.sub_group_name, m.do_no, m.do_date, d.chalan_no,  d.chalan_date,  d.lot_no, d.unit_price, sum(d.total_unit) as total_unit, sum(d.total_amt) as total_amt
		from rm_do_master m, rm_do_chalan d, item_info i, item_sub_group s 
		 where m.do_no=d.do_no and d.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  d.chalan_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con." group by  d.item_id
		 order by s.sub_group_id,i.item_id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=number_format($row->total_unit,0); $total_qty +=$row->total_unit; ?></td>
		<td><?=number_format($row->unit_price,3);?></td>
		<td><?=number_format($row->total_amt,0); $total_amt +=$row->total_amt; ?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,0);?>
		  </span></td>
		  <td><span class="style7">
		   
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_amt,0);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}









elseif($_POST['report']==2302040003)
{
		$report="Finished Goods Production Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="21" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		//echo '<h2>For The Date of: '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '<h2>Date Interval : '.date('d-m-Y',strtotime($f_date)).' To '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		
		<tr>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="20%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Brand</th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">PR No </th>
		<th width="8%" rowspan="2" bgcolor="#33CCCC">PR Date </th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">Batch No </th>
		<th bgcolor="#99FFFF" style="text-align:center">FG Production </th>
		</tr>
		<tr>
		<th width="10%" bgcolor="#99FFFF">Quantity</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		//$chkoutdate = $to_date;
    	//$PreviousDate =  date('Y-m-d', strtotime($chkoutdate.' - 3 month'));
    	//$PreviousDate;
		
		
		
	//	
//		 $sql = "select pi.item_id, sum(pi.qty) as po_qty from purchase_master pm, purchase_invoice pi 
//		 where pm.po_no=pi.po_no and  pm.po_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pi.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $po_qty[$info->item_id]=$info->po_qty;
//		}
//		
//		
//		 $sql = "select pr.item_id, sum(pr.qty) as pr_qty, sum(pr.damage_qty) as damage_qty, sum(pr.short_qty) as short_qty from purchase_master pm, purchase_receive pr 
//		 where pm.po_no=pr.po_no and  pr.rec_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pr.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $pr_qty[$info->item_id]=$info->pr_qty;
//		 $damage_qty[$info->item_id]=$info->damage_qty;
//		 $short_qty[$info->item_id]=$info->short_qty;
//		} 
//		
//		
//		
//
//		
//		 $sql = "select j.item_id, sum(j.item_ex) as sales_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='Sales'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sales_qty[$info->item_id]=$info->sales_qty;
//  		 
//		}
//		
//		
//		$sql = "select j.item_id, sum(j.item_ex) as foc_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='FOC'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $foc_qty[$info->item_id]=$info->foc_qty;
//  		 
//		}
//		
//		$sql = "select j.item_id, sum(j.item_ex) as scheme_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='SCHEME'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $scheme_qty[$info->item_id]=$info->scheme_qty;
//  		 
//		}
//		
//	
//		
//		
//		$sql = "select j.item_id, sum(item_in-item_ex) as closing_stock from journal_item j where  ji_date<='".$t_date."' ".$con." group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $closing_stock[$info->item_id]=$info->closing_stock;
//  		 
//		}

		
		if($_POST['sub_group_id']!='')
		$sub_group_con .= ' and i.sub_group_id = "'.$_POST['sub_group_id'].'" ';
		
		if($_POST['item_id']!='')
		$item_con .= ' and i.item_id = "'.$_POST['item_id'].'" ';
		
		if($_POST['item_brand']!='')
		$item_brand_con .= ' and i.item_brand = "'.$_POST['item_brand'].'" ';
		
		
		if($_POST['watt_type']!='')
		$watt_type_con .= ' and i.watt_type = "'.$_POST['watt_type'].'" ';
		
		if($_POST['vendor_id']!='')
		$vendor_id_con .= ' and m.vendor_id = "'.$_POST['vendor_id'].'" ';
		
		
		
		
		$sql = "select id, brand_name from item_brand where  1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $brand_name[$info->id]=$info->brand_name;
		}
		
		
		   $sql="select  i.finish_goods_code, i.item_id, i.item_brand, i.item_name, s.sub_group_name, m.pr_no, m.pr_date, m.batch_no, d.unit_price, d.total_unit, d.total_amt
		from production_receive_master m, production_receive_detail d, item_info i, item_sub_group s 
		 where m.pr_no=d.pr_no and d.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  m.pr_date between '".$f_date."' and '".$t_date."' 
		  ".$item_con.$sub_group_con.$item_brand_con.$watt_type_con.$vendor_id_con." 
		 order by m.pr_date,i.sub_group_id,i.watt_type";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->item_name?></td>
		<td><?= $brand_name[$row->item_brand]?></td>
		<td><a href="../BATCH_FG/invoice_print_view.php?pr_no=<?=$row->pr_no?>" target="_blank"><?=$row->pr_no?></a></td>
		<td><?=date('d-M-Y',strtotime($row->pr_date))?></td>
		<td><?=$row->batch_no?></td>
		<td><?=number_format($row->total_unit,0); $total_qty +=$row->total_unit; ?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="5"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,0);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}




elseif($_POST['report']==2302040004)
{
		$report="Finished Goods Production Summary";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="21" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		//echo '<h2>For The Date of: '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '<h2>Date Interval : '.date('d-m-Y',strtotime($f_date)).' To '.date('d-m-Y',strtotime($t_date)).'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		
		<tr>
		<th width="8%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="15%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th width="14%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="30%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th width="18%" rowspan="2" bgcolor="#33CCCC">Brand</th>
		<th bgcolor="#99FFFF" style="text-align:center">FG Production </th>
		</tr>
		<tr>
		<th width="15%" bgcolor="#99FFFF">Quantity</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		//$chkoutdate = $to_date;
    	//$PreviousDate =  date('Y-m-d', strtotime($chkoutdate.' - 3 month'));
    	//$PreviousDate;
		
		
		
	//	
//		 $sql = "select pi.item_id, sum(pi.qty) as po_qty from purchase_master pm, purchase_invoice pi 
//		 where pm.po_no=pi.po_no and  pm.po_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pi.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $po_qty[$info->item_id]=$info->po_qty;
//		}
//		
//		
//		 $sql = "select pr.item_id, sum(pr.qty) as pr_qty, sum(pr.damage_qty) as damage_qty, sum(pr.short_qty) as short_qty from purchase_master pm, purchase_receive pr 
//		 where pm.po_no=pr.po_no and  pr.rec_date<='".$t_date."' and pm.po_no!=20 and pm.status not in ('MANUAL', 'UNCHECKED') group by pr.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $pr_qty[$info->item_id]=$info->pr_qty;
//		 $damage_qty[$info->item_id]=$info->damage_qty;
//		 $short_qty[$info->item_id]=$info->short_qty;
//		} 
//		
//		
//		
//
//		
//		 $sql = "select j.item_id, sum(j.item_ex) as sales_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='Sales'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $sales_qty[$info->item_id]=$info->sales_qty;
//  		 
//		}
//		
//		
//		$sql = "select j.item_id, sum(j.item_ex) as foc_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='FOC'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $foc_qty[$info->item_id]=$info->foc_qty;
//  		 
//		}
//		
//		$sql = "select j.item_id, sum(j.item_ex) as scheme_qty from journal_item j where  j.ji_date between '".$PreviousDate."' and '".$t_date."' and j.tr_from='SCHEME'  group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $scheme_qty[$info->item_id]=$info->scheme_qty;
//  		 
//		}
//		
//	
//		
//	


	
		if($_POST['sub_group_id']!='')
		$sub_group_con .= ' and i.sub_group_id = "'.$_POST['sub_group_id'].'" ';
		
		if($_POST['item_id']!='')
		$item_con .= ' and i.item_id = "'.$_POST['item_id'].'" ';
		
		if($_POST['item_brand']!='')
		$item_brand_con .= ' and i.item_brand = "'.$_POST['item_brand'].'" ';
		
		
		if($_POST['watt_type']!='')
		$watt_type_con .= ' and i.watt_type = "'.$_POST['watt_type'].'" ';
		
		if($_POST['vendor_id']!='')
		$vendor_id_con .= ' and m.vendor_id = "'.$_POST['vendor_id'].'" ';
		
		
		
		$sql = "select id, brand_name from item_brand where  1 group by id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $brand_name[$info->id]=$info->brand_name;
		}
		
		
		   $sql="select  i.finish_goods_code, i.item_id, i.item_name, i.item_brand, i.cost_price, s.sub_group_name, m.pr_no, m.pr_date,  d.unit_price, sum(d.total_unit) as total_unit, sum(d.total_amt) as total_amt
		from production_receive_master m, production_receive_detail d, item_info i, item_sub_group s 
		 where m.pr_no=d.pr_no and d.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  m.pr_date between '".$f_date."' and '".$t_date."' 
		  ".$item_con.$sub_group_con.$item_brand_con.$watt_type_con.$vendor_id_con."  group by d.item_id
		 order by i.sub_group_id,i.item_id, i.watt_type";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->item_name?></td>
		<td><?= $brand_name[$row->item_brand]?></td>
		<td><?=number_format($row->total_unit,0); $total_qty +=$row->total_unit; ?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#F5F5F5"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong>Total=</strong></div></td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=number_format($total_qty,0);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}










elseif($_POST['report']==20060203)
{
		$report="Damage Inventory Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="9" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="11%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="28%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th width="13%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DAMAGE REPORT</th>
		</tr>
		<tr>
		<th width="14%" bgcolor="#33CCCC">Invoice Damage </th>
		<th width="14%" bgcolor="#33CCCC">Inventory Damage </th>
		<th width="16%" bgcolor="#33CCCC">Total Damage </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
		 $sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
		 group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
		
  		 
		}
		
		
		$sql = "select j.item_id, sum(j.item_in) as inventory_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='DAMAGE' 
		 and j.warehouse_id=2  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $inventory_damage[$info->item_id]=$info->inventory_damage;
		 
  		 
		}
		
		
		
		


		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		 $sql="select distinct i.sku_code, i.item_id, i.item_name, s.sub_group_name from item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id  ".$item_sub_con." order by i.item_id, i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		<? if ($total_damage=($purchase_damage[$row->item_id]+$inventory_damage[$row->item_id])>0) {?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=number_format($purchase_damage[$row->item_id],2); $total_purchase_damage +=$purchase_damage[$row->item_id];?></td>
		<td><?=number_format($inventory_damage[$row->item_id],2); $total_inventory_damage +=$inventory_damage[$row->item_id];?></td>
		<td><?=number_format($total_damage=($purchase_damage[$row->item_id]+$inventory_damage[$row->item_id]),2); $grand_total_damage +=$total_damage;?></td>
		</tr>
		<? }?>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_purchase_damage,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_inventory_damage,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($grand_total_damage,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}





elseif($_POST['report']==2006020301)
{
		$report="Cumulative Damage Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="9" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<b><h2>Damage Stock of Date : '.date("d-m-Y",strtotime($t_date)).'</h2></b>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">S/L</th>
		<th width="11%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="28%" rowspan="2" bgcolor="#33CCCC">Item Name </th>
		<th width="13%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DAMAGE REPORT</th>
		</tr>
		<tr>
		<th width="14%" bgcolor="#33CCCC">Invoice Damage </th>
		<th width="14%" bgcolor="#33CCCC">Inventory Damage </th>
		<th width="16%" bgcolor="#33CCCC">Total Damage </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
		 $sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where   j.ji_date<='".$t_date."' and j.tr_from='Purchase Damage'
		 group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
		
  		 
		}
		
		
		$sql = "select j.item_id, sum(j.item_in) as inventory_damage from journal_item j where  j.ji_date<='".$t_date."' and j.tr_from='DAMAGE' 
		 and j.warehouse_id=2  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $inventory_damage[$info->item_id]=$info->inventory_damage;
		 
  		 
		}
		
		
		
		


		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		 $sql="select distinct i.sku_code, i.item_id, i.item_name, s.sub_group_name from item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id  ".$item_sub_con." order by i.item_id, i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<? if ($total_damage=($purchase_damage[$row->item_id]+$inventory_damage[$row->item_id])>0) {?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=number_format($purchase_damage[$row->item_id],2); $total_purchase_damage +=$purchase_damage[$row->item_id];?></td>
		<td><?=number_format($inventory_damage[$row->item_id],2); $total_inventory_damage +=$inventory_damage[$row->item_id];?></td>
		<td><?=number_format($total_damage=($purchase_damage[$row->item_id]+$inventory_damage[$row->item_id]),2); $grand_total_damage +=$total_damage;?></td>
		</tr>
		
		<? }?>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_purchase_damage,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_inventory_damage,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($grand_total_damage,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}







elseif($_POST['report']==20060204)
{
		$report="Invoice Wise Product Damage Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="10" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">Invoice No </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="24%" rowspan="2" bgcolor="#33CCCC">Product Name </th>
		<th width="11%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DAMAGE</th>
		</tr>
		<tr>
		<th width="12%" bgcolor="#33CCCC"> Damage Qty </th>
		<th width="12%" bgcolor="#33CCCC">Rate</th>
		<th width="20%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
		 $sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
		 group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
		
  		 
		}
		
		
		$sql = "select j.item_id, sum(j.item_in) as inventory_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='DAMAGE' 
		 and j.warehouse_id=2  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $inventory_damage[$info->item_id]=$info->inventory_damage;
		 
  		 
		}
		
		
		
		


		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.sku_code, i.item_id, i.item_name, s.sub_group_name, m.invoice_no, r.damage_qty, r.rate, r.damage_amt from item_info i, item_sub_group s, purchase_master m, purchase_receive r 
		 where i.item_id=r.item_id and m.po_no=r.po_no and i.sub_group_id=s.sub_group_id and r.damage_qty>0 and r.rec_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con."  order by m.invoice_no, i.item_id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->invoice_no?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->damage_qty; $total_damage +=$row->damage_qty;?></td>
		<td><?=$row->rate?></td>
		<td><?=number_format($row->damage_amt,2); $total_damage_amt +=$row->damage_amt;?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_damage,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_damage_amt,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}




elseif($_POST['report']==20060205)
{
		$report="Invoice Wise Product Short Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="10" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">Invoice No </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="24%" rowspan="2" bgcolor="#33CCCC">Product Name </th>
		<th width="11%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center"> PRODUCT SHORT</th>
		</tr>
		<tr>
		<th width="12%" bgcolor="#33CCCC"> Short Qty </th>
		<th width="12%" bgcolor="#33CCCC">Rate</th>
		<th width="20%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
		 $sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
		 group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
		
  		 
		}
		
		
		$sql = "select j.item_id, sum(j.item_in) as inventory_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='DAMAGE' 
		 and j.warehouse_id=2  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $inventory_damage[$info->item_id]=$info->inventory_damage;
		 
  		 
		}
		
		
		
		


		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.sku_code, i.item_id, i.item_name, s.sub_group_name, m.invoice_no, r.short_qty, r.rate, r.short_amt from item_info i, item_sub_group s, purchase_master m, purchase_receive r 
		 where i.item_id=r.item_id and m.po_no=r.po_no and i.sub_group_id=s.sub_group_id and r.short_qty>0 and r.rec_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con."  order by m.invoice_no, i.item_id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->invoice_no?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->short_qty; $total_short_qty +=$row->short_qty;?></td>
		<td><?=$row->rate?></td>
		<td><?=number_format($row->short_amt,2); $total_short_amt +=$row->short_amt;?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_short_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_short_amt,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==210606001)
{
		$report="Invoice Wise Provision Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="13" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">Invoice No </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">Date</th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="24%" rowspan="2" bgcolor="#33CCCC">Product Name </th>
		<th width="11%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center">Purchase Provision </th>
		<th width="20%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Provision Return </th>
		<th width="20%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Net Provision  </th>
		</tr>
		<tr>
		  <th width="12%" bgcolor="#33CCCC" style="text-align:center"> Provision Qty </th>
		  <th width="12%" bgcolor="#33CCCC" style="text-align:center">Rate</th>
		  <th width="20%" bgcolor="#33CCCC" style="text-align:center">Provision Amt </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
		 //$sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
//		 group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
//		}
		
		
		$sql = "select order_no, sum(provision_amt) as provision_return_amt from purchase_return_details where 1 group by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $provision_return_amt[$info->order_no]=$info->provision_return_amt;
  		 
		}
		
		

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		   $sql="select m.po_date,  i.sku_code, i.item_id, i.item_name, s.sub_group_name, m.invoice_no, r.id, r.qty, r.provision_rate, r.provision_amt from item_info i, item_sub_group s, purchase_master m, purchase_invoice r 
		 where i.item_id=r.item_id and m.po_no=r.po_no and i.sub_group_id=s.sub_group_id and r.provision_amt>0  and m.po_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con."  order by m.po_date, m.invoice_no, i.item_id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->invoice_no?></td>
		<td><?php echo date('d-m-Y',strtotime($row->po_date));?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->qty; $total_qty +=$row->qty;?></td>
		<td><?=$row->provision_rate?></td>
		<td><?=number_format($row->provision_amt,2); $total_provision_amt +=$row->provision_amt;?></td>
		<td><?=number_format($provision_return_amt[$row->id],2); $total_provision_return_amt +=$provision_return_amt[$row->id];?></td>
		<td><?=number_format($net_provision_amt = $row->provision_amt-$provision_return_amt[$row->id],2); $total_net_provision_amt += $net_provision_amt;?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_provision_amt,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_provision_return_amt,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_net_provision_amt,2);?>
		  </span></td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==210606002)
{
		$report="Product Rate Change Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="11" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="3%" bgcolor="#33CCCC">SL</th>
		<th width="9%" bgcolor="#33CCCC">PO No </th>
		<th width="9%" bgcolor="#33CCCC">Invoice No </th>
		<th width="9%" bgcolor="#33CCCC">Date</th>
		<th width="9%" bgcolor="#33CCCC">SKU Code </th>
		<th width="24%" bgcolor="#33CCCC">Product Name </th>
		<th width="11%" bgcolor="#33CCCC">Sub Group </th>
		<th width="12%" bgcolor="#33CCCC" style="text-align:center">Rate</th>
		<th width="12%" bgcolor="#33CCCC" style="text-align:center">PO Qty </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
		 //$sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
//		 group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
//		}
		
		
		$sql = "select item_id, rate, sum(qty) as po_qty from purchase_invoice where 1 GROUP by item_id,rate ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $po_qty[$info->item_id][$info->rate]=$info->po_qty;
  		 
		}
		
		

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		if(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;}
		
		
		   $sql="SELECT i.item_id, i.item_name, i.sku_code, s.sub_group_name, p.po_date, p.rate, p.qty, p.po_no FROM purchase_invoice p, item_info i, item_sub_group s WHERE i.sub_group_id=s.sub_group_id and p.item_id=i.item_id ".$item_sub_con.$item_con." GROUP by p.item_id,p.rate ORDER by p.item_id, p.po_date ";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a href="../../../purchase_mod/pages/po/po_print_view.php?po_no=<?=$row->po_no?>" target="_blank"><?=$row->po_no?></a></td>
		<td><?=find_a_field('purchase_master','invoice_no','po_no='.$row->po_no);?></td>
		<td><?php echo date('d-m-Y',strtotime($row->po_date));?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->rate?></td>
		<td><?=number_format($po_qty[$row->item_id][$row->rate],2);?></td>
		</tr>
<? }?>
		
		
		</tbody>
		</table>
		<?
}





elseif($_POST['report']==210606003)
{
		$report="Product Rate Wise Purchased Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="11" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="3%" bgcolor="#009999">SL</th>
		<th width="9%" bgcolor="#009999">PO No </th>
		<th width="9%" bgcolor="#009999">Invoice No </th>
		<th width="9%" bgcolor="#009999">Date</th>
		<th width="9%" bgcolor="#009999">SKU Code </th>
		<th width="24%" bgcolor="#009999">Product Name </th>
		<th width="11%" bgcolor="#009999">Sub Group </th>
		<th width="12%" bgcolor="#009999" style="text-align:center">Rate</th>
		<th width="12%" bgcolor="#009999" style="text-align:center">PO Qty </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
		 //$sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
//		 group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
//		}
		
		
		$sql = "select item_id, rate, sum(qty) as po_qty from purchase_invoice where 1 GROUP by item_id,rate ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $po_qty[$info->item_id][$info->rate]=$info->po_qty;
  		 
		}
		
		

		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		if(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;}
		
		
		   $sql="SELECT i.item_id, i.item_name, i.sku_code, s.sub_group_name, p.po_date, p.rate, p.qty, p.po_no FROM purchase_invoice p, item_info i, item_sub_group s WHERE i.sub_group_id=s.sub_group_id and p.item_id=i.item_id ".$item_sub_con.$item_con." GROUP by p.item_id,p.rate ORDER by p.item_id, p.po_date ";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr height="30" bgcolor="#009999" >
		<td bgcolor="#33CCCC">&nbsp;</td>
		<td bgcolor="#33CCCC"><a href="../../../purchase_mod/pages/po/po_print_view.php?po_no=<?=$row->po_no?>" target="_blank"></a></td>
		<td bgcolor="#33CCCC">&nbsp;</td>
		<td bgcolor="#33CCCC">&nbsp;</td>
		<td bgcolor="#33CCCC"><span class="style9">
	    <?=$row->sku_code?>
		</span></td>
		<td bgcolor="#33CCCC"><span class="style10">
	    <?=$row->item_name?>
		</span></td>
		<td bgcolor="#33CCCC"><span class="style11">
	    <?=$row->sub_group_name?>
		</span></td>
		<td bgcolor="#33CCCC">&nbsp;</td>
		<td bgcolor="#33CCCC">&nbsp;</td>
		</tr>
		
		<?
		    $sql_n="SELECT i.item_id, i.item_name, i.sku_code, s.sub_group_name, p.po_date, p.rate, p.qty, p.po_no FROM purchase_invoice p, item_info i, item_sub_group s WHERE i.sub_group_id=s.sub_group_id and p.item_id=i.item_id and p.item_id='".$row->item_id."'  and p.rate='".$row->rate."' ".$item_sub_con.$item_con." GROUP by p.id ORDER by p.item_id, p.po_date ";
		
		$res_n	 = db_query($sql_n);
		while($row_n=mysqli_fetch_object($res_n))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a href="../../../purchase_mod/pages/po/po_print_view.php?po_no=<?=$row_n->po_no?>" target="_blank"><?=$row_n->po_no?></a></td>
		<td><?=find_a_field('purchase_master','invoice_no','po_no='.$row_n->po_no);?></td>
		<td><?php echo date('d-m-Y',strtotime($row_n->po_date));?></td>
		<td><?=$row_n->sku_code?></td>
		<td><?=$row_n->item_name?></td>
		<td><?=$row_n->sub_group_name?></td>
		<td><?=$row_n->rate?></td>
		<td><?=number_format($row_n->qty,2); $tot_qty +=$row_n->qty;?></td>
		</tr>
		
		<?  }
		
	
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="center"><strong>Sub Total</strong></div></td>
		  <td>&nbsp;</td>
		  <td><span class="style13">
	      <?=number_format($tot_qty,2); $grand_total +=$tot_qty;?>
		  </span></td>
		  </tr>

<?  	$tot_qty = 0; } ?>


<tr >
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="center"><strong>Grand Total</strong></div></td>
		  <td>&nbsp;</td>
		  <td><span class="style13">
	      <?=number_format($grand_total,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
</table>
		<?
}






elseif($_POST['report']==210428001)
{
		$report="Short &amp; Damage Outstanding Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="14" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>For the Date of: '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">SL </th>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">PO No </th>
		<th width="10%" rowspan="2" bgcolor="#33CCCC">GRN Date </th>
		<th width="8%" rowspan="2" bgcolor="#33CCCC">Invoice No </th>
		<th width="8%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="28%" rowspan="2" bgcolor="#33CCCC">Product Name </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th width="5%" rowspan="2" bgcolor="#33CCCC">Rate</th>
		<th colspan="2" bgcolor="#33CCCC" style="text-align:center"> PRODUCT SHORT</th>
		<th colspan="2" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DAMAGE </th>
		</tr>
		<tr>
		<th width="5%" bgcolor="#33CCCC">Quantity</th>
		<th width="7%" bgcolor="#33CCCC">Amount</th>
		<th width="7%" bgcolor="#33CCCC">Quantity</th>
		<th width="7%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
	//	 $sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
//		 group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
//		
//  		 
//		}
//		
		
		$sql = "select order_no, sum(claim_amt) as claim_amt from purchase_claim where 1 group by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $claim_amt[$info->order_no]=$info->claim_amt;
		 
  		 
		}
		
		
		
		
			//if($_POST['f_date']!=''&&$_POST['t_date']!='')

			//$date_wo .= ' and sm.do_date <="'.$_POST['t_date'].'"';
		
		
		
		


		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.sku_code, i.item_id, i.item_name, s.sub_group_name, m.invoice_no, r.id, r.short_qty, r.rec_date, r.po_no, r.rate, r.short_amt, r.damage_qty,
		 r.damage_amt, r.claim_amt from item_info i, item_sub_group s, purchase_master m, purchase_receive r 
		 where i.item_id=r.item_id and m.po_no=r.po_no and i.sub_group_id=s.sub_group_id and r.claim_amt>0 and r.rec_date <='".$t_date."'  ".$item_sub_con."  order by m.invoice_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		
		
		
		
		?>
		
		<? if($row->claim_amt > $claim_amt[$row->id]){ ?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->po_no?></td>
		<td><?php echo date('d-M-Y',strtotime($row->rec_date));?></td>
		<td><?=$row->invoice_no?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->rate?></td>
		<td><?=$row->short_qty; $total_short_qty +=$row->short_qty;?></td>
		<td><?=number_format($row->short_amt,2); $total_short_amt +=$row->short_amt;?></td>
		<td><?=$row->damage_qty; $total_damage_qty +=$row->damage_qty;?></td>
		<td><?=number_format($row->damage_amt,2); $total_damage_amt +=$row->damage_amt;?></td>
		</tr>
<? }}?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="3"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_short_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_short_amt,2);?>
		  </span></td>
		  <td><span class="style7">
            <?=number_format($total_damage_qty,2);?>
          </span></td>
		  <td><span class="style7">
            <?=number_format($total_damage_amt,2);?>
          </span></td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==210428002)
{
		$report="Purchase Claim Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="15" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">SL </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">Claim Date </th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">PO No </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">Invoice No </th>
		<th width="5%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="29%" rowspan="2" bgcolor="#33CCCC">Product Name </th>
		<th width="8%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">Rate</th>
		<th colspan="2" bgcolor="#33CCCC" style="text-align:center"> PRODUCT SHORT</th>
		<th colspan="2" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DAMAGE </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Claim Amt </th>
		</tr>
		<tr>
		<th width="5%" bgcolor="#33CCCC">Quantity</th>
		<th width="8%" bgcolor="#33CCCC">Amount</th>
		<th width="7%" bgcolor="#33CCCC">Quantity</th>
		<th width="6%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
	//	 $sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
//		 group by j.item_id ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
//		
//  		 
//		}
//		
		
		//$sql = "select order_no, sum(claim_amt) as claim_amt from purchase_claim where 1 group by order_no ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $claim_amt[$info->order_no]=$info->claim_amt;
// 
//		}
		
		
		
		
			//if($_POST['f_date']!=''&&$_POST['t_date']!='')

			//$date_wo .= ' and sm.do_date <="'.$_POST['t_date'].'"';
		
		
		
		


		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.sku_code, i.item_id, i.item_name, s.sub_group_name, m.invoice_no, r.id, r.short_qty, r.claim_date, r.po_no, r.rate, r.short_amt, r.damage_qty,
		 r.damage_amt, r.claim_amt from item_info i, item_sub_group s, purchase_master m, purchase_claim r 
		 where i.item_id=r.item_id and m.po_no=r.po_no and i.sub_group_id=s.sub_group_id and r.claim_amt>0 and r.claim_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con."  order by m.invoice_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		
		
		
		
		?>
		
		<?php /*?><? if($row->claim_amt > $claim_amt[$row->id]){ }?><?php */?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?php echo date('d-M-Y',strtotime($row->claim_date));?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->invoice_no?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->rate?></td>
		<td><?=$row->short_qty; $total_short_qty +=$row->short_qty;?></td>
		<td><?=number_format($row->short_amt,2); $total_short_amt +=$row->short_amt;?></td>
		<td><?=$row->damage_qty; $total_damage_qty +=$row->damage_qty;?></td>
		<td><?=number_format($row->damage_amt,2); $total_damage_amt +=$row->damage_amt;?></td>
		<td><?=number_format($row->claim_amt,2); $total_claim_amt +=$row->claim_amt;?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="3"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_short_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_short_amt,2);?>
		  </span></td>
		  <td><span class="style7">
            <?=number_format($total_damage_qty,2);?>
          </span></td>
		  <td><span class="style7">
            <?=number_format($total_damage_amt,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_claim_amt,2);?>
		  </span></td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}








elseif($_POST['report']==20060206)
{
		$report="Invoice Wise Product Excess Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="10" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">Invoice No </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="24%" rowspan="2" bgcolor="#33CCCC">Product Name </th>
		<th width="11%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center"> PRODUCT EXCESS</th>
		</tr>
		<tr>
		<th width="12%" bgcolor="#33CCCC"> Excess Qty </th>
		<th width="12%" bgcolor="#33CCCC">Rate</th>
		<th width="20%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 
		
		
		 $sql = "select j.item_id, sum(j.item_in) as purchase_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='Purchase Damage'
		 group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $purchase_damage[$info->item_id]=$info->purchase_damage;
		
  		 
		}
		
		
		$sql = "select j.item_id, sum(j.item_in) as inventory_damage from journal_item j where  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from='DAMAGE' 
		 and j.warehouse_id=2  group by j.item_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $inventory_damage[$info->item_id]=$info->inventory_damage;
		 
  		 
		}
		
		
		
		


		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.sku_code, i.item_id, i.item_name, s.sub_group_name, r.invoice_no, r.qty as excess_qty, r.rate, r.amount as excess_amt from item_info i, item_sub_group s,  purchase_receive_extra_detail r 
		 where i.item_id=r.item_id  and i.sub_group_id=s.sub_group_id  and r.or_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con."  order by r.invoice_no, i.item_id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->invoice_no?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->excess_qty; $total_excess_qty +=$row->excess_qty;?></td>
		<td><?=$row->rate?></td>
		<td><?=number_format($row->excess_amt,2); $total_excess_amt +=$row->excess_amt;?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_excess_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_excess_amt,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==20060207)
{
		$report="Product Delivery Report (Sales)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="15" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<h2><? if($_POST['marketing_person']>0) echo 'Marketing Person: '.find_a_field('marketing_person','marketing_person_name','person_code='.$_POST['marketing_person'])?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		
	
		</table>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="3%" rowspan="2" bgcolor="#33CCCC">DO No </th>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">Inv No </th>
		<th width="5%" rowspan="2" bgcolor="#33CCCC">Invoice Date </th>
		<th width="5%" rowspan="2" bgcolor="#33CCCC">Challan No </th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">Cust Code </th>
		<th width="12%" rowspan="2" bgcolor="#33CCCC">Customer Name </th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">Product Name </th>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">Size</th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">Thickness</th>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">Mark</th>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">Length</th>
		<th colspan="4" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DELIVERY </th>
		</tr>
		<tr>
		  <th width="8%" bgcolor="#33CCCC"> Delivery/Pcs </th>
		<th width="8%" bgcolor="#33CCCC">  Delivery/KG </th>
		<th width="5%" bgcolor="#33CCCC"> Price/KG</th>
		<th width="11%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 	if($_POST['item_id']!='')

			$item_con .= ' and c.item_id = "'.$_POST['item_id'].'" ';



		
		if($_POST['sub_group_id']!='')
		$sub_group_con .= ' and i.sub_group_id = "'.$_POST['sub_group_id'].'" ';
		
		if($_POST['item_id']!='')
		$item_con .= ' and i.item_id = "'.$_POST['item_id'].'" ';
		
		if($_POST['dealer_code']!='')
		$dealer_code_con .= ' and c.dealer_code = "'.$_POST['dealer_code'].'" ';
		
		if($_POST['team_code']!='')
		$team_code_con .= ' and p.team_code = "'.$_POST['team_code'].'" ';
		
		
		if($_POST['marketing_person']!='')
		$marketing_person_con .= ' and m.marketing_person = "'.$_POST['marketing_person'].'" ';
		
		
		   $sql="select  i.finish_goods_code as sku_code,  i.item_id, i.item_name, s.sub_group_name, c.do_no, c.job_no, c.invoice_no, c.chalan_no_view, c.chalan_no, c.chalan_date,  c.total_unit_pcs, c.total_unit as qty, c.unit_price, c.total_amt as amount, c.size,c.thickness,c.mark,c.length,
		 d.dealer_code,  d.dealer_name_e as dealer_name  from item_info i, item_sub_group s,  sale_do_master m, sale_do_chalan c, dealer_info d, marketing_person p
		 where m.do_no=c.do_no and  i.item_id=c.item_id  and i.sub_group_id=s.sub_group_id and m.dealer_code=d.dealer_code and m.marketing_person=p.person_code
		  and c.chalan_date between '".$f_date."' and '".$t_date."' 
		  ".$item_con.$sub_group_con.$item_con.$dealer_code_con.$team_code_con.$marketing_person_con."  order by c.chalan_date ";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td style="white-space:nowrap"><a href="../sales_order/sales_order_print_view.php?do_no=<?=$row->do_no?>" target="_blank"><?=$row->job_no?></a></td>
		<td style="white-space:nowrap"><a href="../do_delivery/delivery_challan_invoice_print_view.php?v_no=<?=$row->chalan_no?>" target="_blank"><?=$row->invoice_no?></a></td>
		<td><?php echo date('d-M-y',strtotime($row->chalan_date));?></td>
		<td style="white-space:nowrap"><a href="../do_delivery/delivery_challan_print_view.php?v_no=<?=$row->chalan_no?>" target="_blank"><?=$row->chalan_no_view?></a></td>
		<td><?=$row->dealer_code?></td>
		<td><?=$row->dealer_name?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->size?></td>
		<td><?=$row->thickness?></td>
		<td><?=$row->mark?></td>
		<td><?=$row->length?>'</td>
		<td><?=$row->total_unit_pcs; $total_total_unit_pcs +=$row->total_unit_pcs;?></td>
		<td><?=$row->qty; $total_qty +=$row->qty;?></td>
		<td><?=$row->unit_price?></td>
		<td><?=number_format($row->amount,2); $total_amt +=$row->amount;?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="5"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
            <?=number_format($total_total_unit_pcs,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_amt,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==20060201)
{
		$report="Product Delivery Report Summary";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="15" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<h2><? if($_POST['marketing_person']>0) echo 'Marketing Person: '.find_a_field('marketing_person','marketing_person_name','person_code='.$_POST['marketing_person'])?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		
	
		</table>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="9%" rowspan="2" bgcolor="#33CCCC">Product Name </th>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">Size</th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">Thickness</th>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">Mark</th>
		<th width="4%" rowspan="2" bgcolor="#33CCCC">Length</th>
		<th colspan="4" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DELIVERY </th>
		</tr>
		<tr>
		  <th width="8%" bgcolor="#33CCCC"> Delivery/Pcs </th>
		<th width="8%" bgcolor="#33CCCC">  Delivery/KG </th>
		<th width="5%" bgcolor="#33CCCC"> Price/KG</th>
		<th width="11%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 	if($_POST['item_id']!='')

			$item_con .= ' and c.item_id = "'.$_POST['item_id'].'" ';



		
		if($_POST['sub_group_id']!='')
		$sub_group_con .= ' and i.sub_group_id = "'.$_POST['sub_group_id'].'" ';
		
		if($_POST['item_id']!='')
		$item_con .= ' and i.item_id = "'.$_POST['item_id'].'" ';
		
		if($_POST['dealer_code']!='')
		$dealer_code_con .= ' and c.dealer_code = "'.$_POST['dealer_code'].'" ';
		
		if($_POST['team_code']!='')
		$team_code_con .= ' and p.team_code = "'.$_POST['team_code'].'" ';
		
		
		if($_POST['marketing_person']!='')
		$marketing_person_con .= ' and m.marketing_person = "'.$_POST['marketing_person'].'" ';
		
		
		  $sql="select  i.finish_goods_code as sku_code,  i.item_id, i.item_name, s.sub_group_name, c.do_no, c.job_no, c.invoice_no, c.chalan_no_view, c.chalan_no, c.chalan_date,  sum(c.total_unit_pcs) as total_unit_pcs, sum(c.total_unit) as qty, c.unit_price, sum(c.total_amt) as amount, c.size,c.thickness,c.mark,c.length,
		 d.dealer_code,  d.dealer_name_e as dealer_name  
		 from item_info i, item_sub_group s, sale_do_master m, sale_do_chalan c, dealer_info d , marketing_person p
		 where m.do_no=c.do_no and i.item_id=c.item_id  and i.sub_group_id=s.sub_group_id and c.dealer_code=d.dealer_code and m.marketing_person=p.person_code
		  and c.chalan_date between '".$f_date."' and '".$t_date."' 
		  ".$item_con.$sub_group_con.$item_con.$dealer_code_con.$team_code_con.$marketing_person_con." group by c.item_id  order by i.sub_group_id, i.finish_goods_code  ";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->size?></td>
		<td><?=$row->thickness?></td>
		<td><?=$row->mark?></td>
		<td><?=$row->length?>'</td>
		<td><?=$row->total_unit_pcs; $total_total_unit_pcs +=$row->total_unit_pcs;?></td>
		<td><?=$row->qty; $total_qty +=$row->qty;?></td>
		<td><?=$row->unit_price?></td>
		<td><?=number_format($row->amount,2); $total_amt +=$row->amount;?></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="5"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
            <?=number_format($total_total_unit_pcs,2);?>
          </span></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_amt,2);?>
		  </span></td>
		  </tr>
		
		
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==220622001)
{
		$report="Date Wise Sales &amp; Purchase Report (Without FOC)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		
		<tr><td colspan="15" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		</table>
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead class="head_line_fixed">
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC"> Date </th>
		<th width="15%" rowspan="2" bgcolor="#33CCCC">Customer/Supplier Name </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">Invoice No </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="27%" rowspan="2" bgcolor="#33CCCC">Product Description </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">TR From </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center">Sales (Rate With Vat)</th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center">Purchase (Rate With Vat)</th>
		</tr>
		<tr>
		<th width="6%" bgcolor="#33CCCC">  Qty </th>
		<th width="5%" bgcolor="#33CCCC">Rate</th>
		<th width="8%" bgcolor="#33CCCC">Amount</th>
		<th width="6%" bgcolor="#33CCCC"> Qty </th>
		<th width="5%" bgcolor="#33CCCC">Rate</th>
		<th width="8%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 	if($_POST['item_id']!='')

			$item_con .= ' and j.item_id = "'.$_POST['item_id'].'" ';
			
			if($_POST['issue_status']!='')

			$issue_status_con .= ' and j.tr_from = "'.$_POST['issue_status'].'" ';
			
			if($_POST['receive_status']!='')

			$receive_status_con .= ' and j.tr_from = "'.$_POST['receive_status'].'" ';



		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		
		
		
		 $sql = "select b.id, b.id as order_no, j.tr_from from purchase_master a, purchase_receive b, journal_item j where a.po_no=b.po_no and b.id=j.tr_no and j.ji_date between '".$f_date."' and '".$t_date."'  and a.po_type!=1 and j.tr_from='Purchase' group by j.tr_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $order_no[$info->id][$info->tr_from]=$info->order_no;
  		 
		}
		
		
		
		
		 $sql="select  i.sku_code, i.item_id, i.item_name, s.sub_group_name,j.ji_date, j.item_in as item_in, j.item_ex, j.item_price as item_price, j.tr_from, j.tr_no
		from item_info i, item_sub_group s,  journal_item j
		 where i.item_id=j.item_id  and i.sub_group_id=s.sub_group_id and  j.ji_date between '".$f_date."' and '".$t_date."' and j.tr_from in ('Sales','Purchase') 
		  ".$item_sub_con.$item_con.$issue_status_con.$receive_status_con."  order by j.ji_date,j.tr_from,i.sku_code ";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<? if ($order_no[$row->tr_no][$row->tr_from]==0) {?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->ji_date));?></td>
		<td>
		<? if($row->tr_from=="Purchase"){
		$po_data = find_all_field('purchase_receive','','id="'.$row->tr_no.'"');
		
		echo $vendor_name = find_a_field('vendor','vendor_name','vendor_id="'.$po_data->vendor_id.'"');
		} elseif ($row->tr_from=="Sales") {
		$dealer_code = find_a_field('sale_do_chalan','dealer_code','id="'.$row->tr_no.'"');
		
		echo $dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code="'.$dealer_code.'"');
		}?></td>
		<td>
		<? if($row->tr_from=="Purchase"){
		echo find_a_field('purchase_master','invoice_no','po_no="'.$po_data->po_no.'"');}
		?>
		</td>
		<td><?=$row->sku_code?>  <? $row->tr_no?></td>
		<td><?=$row->item_name?> <? $order_no[$row->tr_no][$row->tr_from]?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->tr_from?></td>
		<td><?=(int)$row->item_ex; $total_item_ex +=$row->item_ex;?></td>
		<td><? if($row->item_ex>0) {?><?=number_format($row->item_price,3);?><? }?></td>
		<td><?=number_format($item_ex_amt = $row->item_ex*$row->item_price,2); $total_item_ex_amt +=$item_ex_amt;?></td>
		<td><?=(int)$row->item_in; $total_item_in +=$row->item_in;?></td>
		<td><? if($row->item_in>0) {?><?=number_format($price_with_vat=(($row->item_price*15)/100)+$row->item_price,3);?><? }?></td>
		<td><?=number_format($item_in_amt = $row->item_in*$price_with_vat,2); $total_item_in_amt +=$item_in_amt;?></td>
		</tr>
<? } }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="3"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_item_ex,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_item_ex_amt,2);?>
		  </span></td>
		  <td><span class="style7">
            <?=number_format($total_item_in,2);?>
          </span></td>
		  <td><span class="style7"> </span></td>
		  <td><span class="style7">
            <?=number_format($total_item_in_amt,2);?>
          </span></td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}





elseif($_POST['report']==20060208)
{
		$report="GDN Wise Product Delivery Report (FOC)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="14" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">GDN Date </th>
		<th width="5%" rowspan="2" bgcolor="#33CCCC">GDN No </th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">Cust Code </th>
		<th width="15%" rowspan="2" bgcolor="#33CCCC">Customer Name </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="27%" rowspan="2" bgcolor="#33CCCC">Product Description </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DELIVERY </th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Status</th>
		</tr>
		<tr>
		<th width="6%" bgcolor="#33CCCC">  Qty </th>
		<th width="5%" bgcolor="#33CCCC">Rate</th>
		<th width="8%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
			if($_POST['item_id']!='')

			$item_con .= ' and c.item_id = "'.$_POST['item_id'].'" ';	 



		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.sku_code, i.item_id, i.item_name, s.sub_group_name,c.chalan_date, c.driver_name as gdn_no, c.total_unit as qty, c.unit_price, c.total_amt as amount,
		 d.dealer_code,  d.dealer_name_e as dealer_name, c.issue_type  from item_info i, item_sub_group s,  sale_other_chalan c, dealer_info d 
		 where i.item_id=c.item_id  and i.sub_group_id=s.sub_group_id and c.dealer_code=d.dealer_code  and c.issue_type='FOC' and  c.chalan_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con.$item_con."  order by c.driver_name,c.chalan_date ";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->chalan_date));?></td>
		<td><?=$row->gdn_no?></td>
		<td><?=$row->dealer_code?></td>
		<td><?=$row->dealer_name?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->qty; $total_qty +=$row->qty;?></td>
		<td><?=$row->unit_price?></td>
		<td><?=number_format($row->amount,2); $total_amt +=$row->amount;?></td>
		<td><strong><?=$row->issue_type?></strong></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}





elseif($_POST['report']==20060209)
{
		$report="GDN Wise Product Delivery Report (SCHEME)";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		
		
		if(isset($item_sub_group)){$sub_group_con.=' and i.sub_group_id="'.$item_sub_group.'"';}
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="14" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
//if(isset($warehouse_id))
		//echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th width="2%" rowspan="2" bgcolor="#33CCCC">SL</th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">GDN Date </th>
		<th width="5%" rowspan="2" bgcolor="#33CCCC">GDN No </th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC">Cust Code </th>
		<th width="15%" rowspan="2" bgcolor="#33CCCC">Customer Name </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">SKU Code </th>
		<th width="27%" rowspan="2" bgcolor="#33CCCC">Product Description </th>
		<th width="7%" rowspan="2" bgcolor="#33CCCC">Sub Group </th>
		<th colspan="3" bgcolor="#33CCCC" style="text-align:center"> PRODUCT DELIVERY </th>
		<th width="6%" rowspan="2" bgcolor="#33CCCC" style="text-align:center">Status</th>
		</tr>
		<tr>
		<th width="6%" bgcolor="#33CCCC">  Qty </th>
		<th width="5%" bgcolor="#33CCCC">Rate</th>
		<th width="8%" bgcolor="#33CCCC">Amount</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		 	if($_POST['item_id']!='')

			$item_con .= ' and c.item_id = "'.$_POST['item_id'].'" ';



		
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;}
		
		
		  $sql="select  i.sku_code, i.item_id, i.item_name, s.sub_group_name,c.chalan_date, c.driver_name as gdn_no, c.total_unit as qty, c.unit_price, c.total_amt as amount,
		 d.dealer_code,  d.dealer_name_e as dealer_name, c.issue_type  from item_info i, item_sub_group s,  sale_other_chalan c, dealer_info d 
		 where i.item_id=c.item_id  and i.sub_group_id=s.sub_group_id and c.dealer_code=d.dealer_code  and c.issue_type='SCHEME' and  c.chalan_date between '".$f_date."' and '".$t_date."'  ".$item_sub_con.$item_con."  order by c.driver_name,c.chalan_date ";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->chalan_date));?></td>
		<td><?=$row->gdn_no?></td>
		<td><?=$row->dealer_code?></td>
		<td><?=$row->dealer_name?></td>
		<td><?=$row->sku_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sub_group_name?></td>
		<td><?=$row->qty; $total_qty +=$row->qty;?></td>
		<td><?=$row->unit_price?></td>
		<td><?=number_format($row->amount,2); $total_amt +=$row->amount;?></td>
		<td><strong><?=$row->issue_type?></strong></td>
		</tr>
<? }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2"><div align="right"><strong>Total=</strong></div></td>
		  <td><span class="style7">
		    <?=number_format($total_qty,2);?>
		  </span></td>
		  <td><span class="style7">
		    
		  </span></td>
		  <td><span class="style7">
		    <?=number_format($total_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		</tr>
		
		
		</tbody>
		</table>
		<?
}








elseif($_POST['report']==1001) 
{

?>
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="9" style="border:0px;">
		
			<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2>
		</td></tr>
		<tr>
		<th rowspan="2">S/Lll</th>
		<th rowspan="2">Item Code </th>
		<th rowspan="2">Item Name </th>
		<th colspan="2" bgcolor="#99CC99" style="text-align:center">Damage</th>
		
		</tr>
		<tr>
		<th bgcolor="#99CC99">When Dispatch </th>
		<th bgcolor="#99CC99">When Purchase</th>
	
		</tr>
		</thead><tbody>
		
		<?php
		 $dm_sql="select i.item_name,i.sku_code,i.item_id,pr.item_id,sum(pr.damage_qty)as DAMAGE from purchase_receive pr,item_info i where  i.item_id=pr.item_id group by pr.item_id";
		$dm_query=db_query($dm_sql);
		while($data=mysqli_fetch_assoc($dm_query)){
	
		$item_name=$data['item_name'];
		$sku_code=$data['sku_code'];
	
	$wa_damage=$data['wa_damage'];
				
		$pur_da=$data['DAMAGE'];
		
		
		 ?>
		
		<tr >
		  <td><?php echo ++$i; ?></td>
		  <td><?php echo $sku_code; ?></td>
		  <td><?php echo $item_name; ?></td>
		  <td><?php echo $wa_damage; ?></td>
		  <td><?php echo $pur_da; ?>
	      </td>
		  
		  </tr>
		  <?php
		  $total_pur=$total_pur+$pur_da;
		   } ?>

		<tr >
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  
		  <td><div align="right"><strong>Total=</strong></div></td>
		  <td>&nbsp;</td>
		  <td><span class="style4"><?php echo $total_pur; ?>
	      </td>
		  
		  </tr>
		
		
		</tbody>
</table>
<?




}
elseif($_POST['report']==1002&&$sub_group_id>0) 
{
$sql='select i.item_id,i.unit_name,i.item_name  from item_info i where i.sub_group_id='.$sub_group_id.' order by i.finish_goods_code,i.item_name';
		   
		$query =db_query($sql);  
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead><tr><td style="border:0px;" colspan="31"><div class="header"><h1>M. Ahmed Tea &amp; Lands Co. Ltd</h1>
<h2>Stock Valuation Report<br />
  <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
  <? if(isset($t_date)) 
	echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';?>
</div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Item Name </th>
<th rowspan="2">Unit</th>
<th colspan="3" bgcolor="#CC99FF"><div align="center">Opening </div></th>
<th colspan="3" bgcolor="#99FFFF"><div align="center">Purchase</div></th>
<th colspan="3" bgcolor="#FFCCFF"><div align="center">Other Receive </div></th>
<th colspan="3" bgcolor="#FFCC66"><div align="center">Total Receive </div></th>
<th colspan="3"><div align="center">Sales</div></th>
<th colspan="3"><div align="center">Consumption</div></th>
<th colspan="3"><div align="center">Other Issue </div></th>
<th colspan="3"><div align="center">Total Issue </div></th>
<th colspan="3"><div align="center">Closing</div></th>
</tr><tr>
<th bgcolor="#CC99FF">Qty</th>
<th bgcolor="#CC99FF">AVR</th>
<th bgcolor="#CC99FF">Amt </th>
<th bgcolor="#99FFFF">Qty</th>
<th bgcolor="#99FFFF">AVR</th>
<th bgcolor="#99FFFF">Amt </th>
<th bgcolor="#FFCCFF">Qty</th>
<th bgcolor="#FFCCFF">AVR</th>
<th bgcolor="#FFCCFF">Amt </th>
<th bgcolor="#FFCC66">Qty</th>
<th bgcolor="#FFCC66">AVR</th>
<th bgcolor="#FFCC66">Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
<th>Qty</th>
<th>AVR</th>
<th>Amt </th>
</tr>
</thead><tbody>
<?
while($row=mysqli_fetch_object($query)){
$pre_stock = $pre_price = $pre_amt   = $in_stock = $in_price = $in_amt   = $pur_stock = $pur_price = $pur_amt   = $or_stock = $or_amt   = $or_price = $out_stock = $out_price = $out_amt   = $sale_stock = $sale_price = $sale_amt   = $pro_stock = $pro_price = $pro_amt   = $oi_stock = $oi_amt   = $oi_price = $final_stock = $final_amt   = $final_price = 0;

$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $in->pre_amt;
		
		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Purchase" and item_id='.$row->item_id);
		$pur_stock = (int)$pur->pre_stock;
		$pur_price = @($pur->pre_amt/$pur->pre_stock);
		$pur_amt   = $pur->pre_amt;
		
		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Purchase" and item_id='.$row->item_id);
		$or_stock = (int)$or->pre_stock;
		$or_amt   = @($or->pre_amt/$or->pre_stock);
		$or_price = $or->pre_amt;
		
		
		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $out->pre_amt;
		
		$sale = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales" and item_id='.$row->item_id);
		$sale_stock = (int)$sale->pre_stock;
		$sale_price = @($sale->pre_amt/$sale->pre_stock);
		$sale_amt   = $sale->pre_amt;
		
		$pro = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Issue" and item_id='.$row->item_id);
		$pro_stock = (int)$pro->pre_stock;
		$pro_price = @($pro->pre_amt/$pro->pre_stock);
		$pro_amt   = $pro->pre_amt;
		

		
		
		$oi = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Sales" and tr_from!="Issue" and item_id='.$row->item_id);
		$oi_stock = (int)$oi->pre_stock;
		$oi_amt   = @($oi->pre_amt/$oi->pre_stock);
		$oi_price = $oi->pre_amt;
		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_amt   = @($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price);
		$final_price = @(($final_amt)/$final_stock);
		
		
		?>
<tr><td><?=++$j?></td>
  <td><?=$row->item_name?></td>
  <td><nobr><?=$row->unit_name?></nobr></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=$pre_stock?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($pre_price,2)?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($pre_amt,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=$pur_stock?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($pur_price,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($pur_amt,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=$or_stock?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($or_price,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($or_amt,2)?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=$in_stock?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=number_format($in_price,2)?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=number_format($in_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$sale_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($sale_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($sale_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$pro_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($pro_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($pro_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$oi_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($oi_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($oi_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$out_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($out_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($out_amt,2)?>
  </div></td>
  <td><div align="right">
    <?=$final_stock?>
  </div></td>
  <td><div align="right">
    <?=number_format($final_price,2)?>
  </div></td>
  <td><div align="right">
    <?=number_format($final_amt,2)?>
  </div></td>
</tr>
<?
}
?></tbody></table>
<?
}
elseif($_POST['report']==10011) 
{
if($item_id>0) 		{$item_con = ' and i.item_id='.$item_id;}
if($sub_group_id>0) {$sub_item_con = ' and i.sub_group_id='.$sub_group_id;}

$sql='select i.item_id,i.unit_name,i.item_name  from item_info i where 1 '.$sub_item_con.$item_con.'  order by i.finish_goods_code,i.item_name';
$query =db_query($sql);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead><tr><td style="border:0px;" colspan="35"><div class="header"><h1>M. Ahmed Tea &amp; Lands Co. Ltd</h1>
<h2>Stock Valuation Report(HFL)<br />
  <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
  <? if(isset($t_date)) 
	echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';?>
</div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>
<th rowspan="2">S/L</th>
<th rowspan="2">Item Name </th>
<th rowspan="2">Unit</th>
<th colspan="5" bgcolor="#CC99FF"><div align="center">Opening </div></th>
<th colspan="3" bgcolor="#99FFFF"><div align="center">Purchase</div></th>
<th colspan="3" bgcolor="#FFCCFF"><div align="center">Other Receive </div></th>
<th colspan="3" bgcolor="#FFFF00"><div align="center">Total IN </div></th>
<th colspan="3" bgcolor="#99FFFF"><div align="center">Material Sales</div></th>
<th colspan="3" bgcolor="#FFCCFF"><div align="center">Consumption </div></th>
<th colspan="3" bgcolor="#FFCC66"><div align="center">Other Issue </div></th>
<th colspan="3" bgcolor="#FF3366"><div align="center">Total OUT </div></th>
<th colspan="5" bgcolor="#CC99FF"><div align="center">Closing</div></th>
</tr><tr>
<th bgcolor="#CC99FF">WHQty</th>
<th bgcolor="#CC99FF">PLQty</th>
<th bgcolor="#CC99FF">TQty</th>
<th bgcolor="#CC99FF">AVR</th>
<th bgcolor="#CC99FF">Amt </th>
<th bgcolor="#99FFFF">Qty</th>
<th bgcolor="#99FFFF">AVR</th>
<th bgcolor="#99FFFF">Amt </th>
<th bgcolor="#FFCCFF">Qty</th>
<th bgcolor="#FFCCFF">AVR</th>
<th bgcolor="#FFCCFF">Amt </th>
<th bgcolor="#FFFF00">Qty</th>
<th bgcolor="#FFFF00">AVR</th>
<th bgcolor="#FFFF00">Amt </th>
<th bgcolor="#99FFFF">Qty</th>
<th bgcolor="#99FFFF">AVR</th>
<th bgcolor="#99FFFF">Amt </th>
<th bgcolor="#FFCCFF">Qty</th>
<th bgcolor="#FFCCFF">AVR</th>
<th bgcolor="#FFCCFF">Amt </th>
<th bgcolor="#FFCC66">Qty</th>
<th bgcolor="#FFCC66">AVR</th>
<th bgcolor="#FFCC66">Amt </th>
<th bgcolor="#FF3366">Qty</th>
<th bgcolor="#FF3366">AVR</th>
<th bgcolor="#FF3366">Amt </th>
<th bgcolor="#CC99FF">WHQty</th>
<th bgcolor="#CC99FF">PLQty</th>
<th bgcolor="#CC99FF">TQty</th>
<th bgcolor="#CC99FF">AVR</th>
<th bgcolor="#CC99FF">Amt </th>
</tr>
</thead><tbody>
<?
while($row=mysqli_fetch_object($query)){
$pre_stock = $pre_price = $pre_amt   = $in_stock = $in_price = $in_amt   = $pur_stock = $pur_price = $pur_amt   = $or_stock = $or_amt   = $or_price = $out_stock = $out_price = $out_amt   = $sale_stock = $sale_price = $sale_amt   = $pro_stock = $pro_price = $pro_amt   = $oi_stock = $oi_amt   = $oi_price = $final_stock = $final_amt   = $final_price = 0;


		$pr = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date < "'.$f_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);
		$pr_price = @($pr->pre_amt/$pr->pre_stock);
		
		$pr_end = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date <= "'.$t_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);
		$pr_end_price = @($pr->pre_amt/$pr->pre_stock);

		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);
		$pur_stock = (int)$pur->pre_stock;
		$pur_price = @($pur->pre_amt/$pur->pre_stock);
		$pur_amt   = $pur->pre_amt;



$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and (w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" or  w.warehouse_id = "'.$_SESSION['user']['depot'].'") and j.ji_date<"'.$f_date.'" and j.item_id='.$row->item_id);
		$pret_stock = (int)$pre->pre_stock;
		$pret_price = $pr_price;
		$pret_amt   = $pre->pre_stock*$pr_price;

//echo 'select sum(item_in-item_ex) as pre_stock from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id;
		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);
		$pre_stock = (int)$pre->pre_stock;
		$lpre_stock = $pret_stock - $pre_stock;
		
		
		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $in->pre_amt;
		

		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Purchase" and tr_from!="Local Purchase" and tr_from!="Import" and item_id='.$row->item_id);
		$or_stock = (int)$or->pre_stock;
		$or_amt   = @($or->pre_amt/$or->pre_stock);
		$or_price = $or->pre_amt;
		
		
		$sale = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Other Sales" and item_id='.$row->item_id);
		$sale_stock = (int)$sale->pre_stock;
		$sale_price = $pr_price;
		$sale_amt   = $sale_stock*$pr_price;
		
		
		$pro = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Consumption" and item_id='.$row->item_id);
		$pro_stock = (int)$pro->pre_stock;
		$pro_price = $pr_price;
		$pro_amt   = $pr_price*$pro_stock;
		
		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="issue" and item_id='.$row->item_id);
		$out_stock = (int)($out->pre_stock + $pro_stock);
		$out_price = $pr_price;
		$out_amt   = $pr_price*$out_stock;
		
		$oi = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Other Sales" and tr_from!="Issue" and item_id='.$row->item_id);
		$oi_stock = (int)$oi->pre_stock;
		$oi_amt   = @($oi->pre_amt/$oi->pre_stock);
		$oi_price = $oi->pre_amt;
		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_amt   = @($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price);
		$final_price = @(($final_amt)/$final_stock);

$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock,sum((j.item_in-j.item_ex)*j.item_price) as pre_amt from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and (w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" or  w.warehouse_id = "'.$_SESSION['user']['depot'].'") and j.ji_date<="'.$t_date.'" and j.item_id='.$row->item_id);
		$final_stock = (int)$pre->pre_stock;
		$final_amt = $pr_end_price;
		$final_price   = $pre->pre_stock*$pr_end_price;

$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" and j.ji_date<="'.$t_date.'" and j.item_id='.$row->item_id);
		$lfinal_stock = (int)$pre->pre_stock;
		$prefinal_stock = (int)($final_stock -$pre->pre_stock);
		?>
<tr><td><?=++$j?></td>
  <td><?=$row->item_name?></td>
  <td><nobr><?=$row->unit_name?></nobr></td>
  <td bgcolor="#CC99FF"><?=$pre_stock?></td>
  <td bgcolor="#CC99FF"><?=$lpre_stock?></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=$pret_stock?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($pr_price,2)?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format(($pr_price*$pret_stock),2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=$pur_stock?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($pur_price,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($pur_amt,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=$or_stock?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($or_price,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($or_amt,2)?>
  </div></td>
  <td bgcolor="#FFFF00"><div align="right">
    <?=$in_stock?>
  </div></td>
  <td bgcolor="#FFFF00"><div align="right">
    <?=number_format($in_price,2)?>
  </div></td>
  <td bgcolor="#FFFF00"><div align="right">
    <?=number_format($in_amt,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=$sale_stock?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($sale_price,2)?>
  </div></td>
  <td bgcolor="#99FFFF"><div align="right">
    <?=number_format($sale_amt,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=$pro_stock?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($pro_price,2)?>
  </div></td>
  <td bgcolor="#FFCCFF"><div align="right">
    <?=number_format($pro_amt,2)?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=$oi_stock?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=number_format($oi_price,2)?>
  </div></td>
  <td bgcolor="#FFCC66"><div align="right">
    <?=number_format($oi_amt,2)?>
  </div></td>
  <td bgcolor="#FF3366"><div align="right">
    <?=$out_stock?>
  </div></td>
  <td bgcolor="#FF3366"><div align="right">
    <?=number_format($out_price,2)?>
  </div></td>
  <td bgcolor="#FF3366"><div align="right">
    <?=number_format($out_amt,2)?>
  </div></td>
  <td bgcolor="#CC99FF"><?=$prefinal_stock?></td>
  <td bgcolor="#CC99FF"><?=$lfinal_stock?></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=$final_stock?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($final_price,2)?>
  </div></td>
  <td bgcolor="#CC99FF"><div align="right">
    <?=number_format($final_amt,2)?>
  </div></td>
</tr>
<?
}
?></tbody></table>
<?
}
elseif($_POST['report']==1003)
{
		$report="Material Consumption  Report";
		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}
		
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
		
?>
<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>
<?
if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		<th rowspan="2">S/L</th>
		<th rowspan="2">Item Code </th>
		<th rowspan="2">Item Name </th>
		<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>
		</tr>
		<tr>
		<th bgcolor="#99CC99">Qty</th>
		<th bgcolor="#99CC99">Rate</th>		
		<th bgcolor="#99CC99">Taka</th>
		<th bgcolor="#339999">Qty</th>
		<th bgcolor="#339999">Rate</th>		
		<th bgcolor="#339999">Taka</th>
		<th bgcolor="#FFCC66">Qty</th>
		<th bgcolor="#FFCC66">Rate</th>
		<th bgcolor="#FFCC66">Taka</th>
		<th bgcolor="#FFFF99">Qty</th>
		<th bgcolor="#FFFF99">Rate</th>
		<th bgcolor="#FFFF99">Taka</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		$sql="select i.item_id,i.item_name from item_info i where i.sub_group_id='".$sub_group_id."'	order by i.product_nature,i.item_name";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);
		$pre_stock = (int)$pre->pre_stock;
		$pre_price = @($pre->pre_amt/$pre->pre_stock);
		$pre_amt   = $pre->pre_amt;

		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$in_stock = (int)$in->pre_stock;
		$in_price = @($in->pre_amt/$in->pre_stock);
		$in_amt   = $pre->pre_amt;
		

		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);
		$out_stock = (int)$out->pre_stock;
		$out_price = @($out->pre_amt/$out->pre_stock);
		$out_amt   = $pre->pre_amt;
		

		
		$final_stock = $pre_stock+($in_stock-$out_stock);
		$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a target="_blank" href="../ws/product_transection_report_master.php?item_id=<?=$row->item_id?>&f_date=<?=$f_date?>&t_date=<?=$t_date?>&submit=3&report=3"><?=$row->item_id?></a></td>
		<td><?=$row->item_name?></td>
		<td><?=$pre_stock?></td>
		<td><?=number_format($pre_price,2)?></td>
		<td><?=number_format(($pre_stock*$pre_price),2)?></td>

		<td><?=$in_stock?></td>
		<td><?=number_format($in_price,2)?></td>
		<td><?=number_format(($in_price*$in_stock),2)?></td>


		<td><?=$out_stock?></td>
		<td><?=number_format($out_price,2)?></td>
		<td><?=number_format(($out_price*$out_stock),2)?></td>
		<td><?=$final_stock?></td>
		<td><?=number_format($final_price,2)?></td>
		<td><?=number_format(($final_stock*$final_price),2)?></td>
</tr><? }?>
		
		</tbody>
		</table>
		<?
}
elseif($_POST['report']==1009)
{
		$report="Daily Stock Issue Report";
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="8" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'-'.$_POST['sales_item_type'].'</h2>';

if(isset($t_date)) 
		echo '<h2>Reporting Date : '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		
		

		if($_POST['sales_item_type']!='')
		$dg = ' and i.sales_item_type like "%'.$_POST['sales_item_type'].'%"';
		$sql="select distinct i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i, journal_item c where  i.finish_goods_code>0 and c.item_ex>0 and c.item_id=i.item_id and c.ji_date='".$_POST['t_date']."' and i.finish_goods_code!=2000 and i.finish_goods_code!=2001 ".$dg." and c.warehouse_id='".$_SESSION['user']['depot']."' order by i.item_id";
		$res	 = db_query($sql);
		$rows = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{
		$item_code[] = $row->item_id;
		$item_name[] = $row->item_name;
		$sales_item_type[] = $row->sales_item_type;
		$pack_size[] = $row->pack_size;
		$finish_goods_code[] = $row->finish_goods_code;
		}
		
		$sql="select distinct c.chalan_no,c.driver_name from item_info i,sale_do_chalan c where c.chalan_type='Delivery' and i.item_id=c.item_id  and c.chalan_date='".$_POST['t_date']."' and c.depot_id='".$_SESSION['user']['depot']."'  ".$dg." order by c.chalan_no ";
		$res	 = db_query($sql);
		$chalan = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$rsr_no[] = $row->chalan_no; $dsr_no[] = $row->driver_name;}
		
		$sql="select distinct c.sr_no from item_info i,journal_item c where i.item_id=c.item_id  and c.ji_date='".$_POST['t_date']."' and c.warehouse_id='".$_SESSION['user']['depot']."'  ".$dg." and (c.tr_from = 'Issue'||c.tr_from = 'Transit'||c.tr_from = 'Transfered') and c.item_ex>0 order by c.sr_no ";
		$res	 = db_query($sql);
		$store = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$srsr_no[] = $row->sr_no; $sdsr_no[] = $row->sr_no;}
		
		$sql="select distinct m.oi_no from item_info i,warehouse_other_issue m, warehouse_other_issue_detail d where m.oi_no=d.oi_no and i.item_id=d.item_id  and m.oi_date='".$_POST['t_date']."' and m.warehouse_id='".$_SESSION['user']['depot']."'  ".$dg." order by m.oi_no ";
		$res	 = db_query($sql);
		$other = mysqli_num_rows($res);
		while($row=mysqli_fetch_object($res))
		{$orsr_no[] = $row->oi_no; $odsr_no[] = $row->oi_no;}
		
		$sql="select sum(item_ex-item_in) as item_ex,item_id,tr_no,sr_no,tr_from from journal_item where ji_date='".$_POST['t_date']."' and warehouse_id='".$_SESSION['user']['depot']."' group by item_id,sr_no";
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
			if($row->tr_from=='Sales'||$row->tr_from=='SalesReturn')
			$citem_ex[$row->sr_no][$row->item_id] = $citem_ex[$row->sr_no][$row->item_id] + $row->item_ex;
			
elseif(($row->tr_from=='Issue')||($row->tr_from=='Transfered')||($row->tr_from=='Transit'))
$sitem_ex[$row->sr_no][$row->item_id] = $row->item_ex;
			
			else
			$oitem_ex[$row->sr_no][$row->item_id] = $row->item_ex;
		}
		?>
		</td></tr>
		<tr>
		  <th rowspan="2">S/L</th>
		  <th rowspan="2">Item Name </th>
		  <th colspan="<?=$chalan?>"><div align="center">Party Chalan</div></th>
		  <th bgcolor="#99CC99" style="text-align:center">Total</th>
		  <th colspan="<?=$store?>"><div align="center">Store Chalan</div></th>
		  <th bgcolor="#99CC99" style="text-align:center">Total</th>
		  <th colspan="<?=$other?>"><div align="center">Other Issue</div></th>
		  <th bgcolor="#99CC99" style="text-align:center">Total</th>
		  <!--<th bgcolor="#99CC99" style="text-align:center">ALL-TOTAL</th>-->
		  </tr>
		
			<tr>
				<? for($j=0;$j<$chalan;$j++){?>
				<th height="100" bgcolor="#339999" style="width:5px;"><font class="vertical-text"><?=$dsr_no[$j]?>
			  </font></th>
				<? }?>                      
				<th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
				<? for($j=0;$j<$store;$j++){?>
			  <th height="100" bgcolor="#339999" style="width:5px;"><p><font class="vertical-text"><?=$srsr_no[$j]?></font></p></th>
				<? }?>                      
				<th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
				<? for($j=0;$j<$other;$j++){?>
				<th height="100" bgcolor="#339999" style="width:5px;"><p><font class="vertical-text"><?=$odsr_no[$j]?></font></p></th>
				<? }?>                      
				<th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
				<th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>
			</tr>
		</thead><tbody>
		<? for($x=0;$x<$rows;$x++){?>
				<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
				<td><?=++$sl;?></td>
				<td><?=$item_name[$x]?>(<?=$finish_goods_code[$x]?>)</td>
<!--1-->
		<? for($j=0;$j<$chalan;$j++){?>
				<td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;">
					<? if($citem_ex[$rsr_no[$j]][$item_code[$x]]>0)
					{
						$total[$item_code[$x]] = $total[$item_code[$x]] + $citem_ex[$rsr_no[$j]][$item_code[$x]];
						$ctotal[$item_code[$x]] = $ctotal[$item_code[$x]] + $citem_ex[$rsr_no[$j]][$item_code[$x]];
						echo (int)(($citem_ex[$rsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 
						if((($citem_ex[$rsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($citem_ex[$rsr_no[$j]][$item_code[$x]])%$pack_size[$x]);
					}?>
				</td>
		<? }?>
				<td>
					<?
					if($total[$item_code[$x]]>0)
					{
						echo (int)(($total[$item_code[$x]])/$pack_size[$x]); 
						if((($total[$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($total[$item_code[$x]])%$pack_size[$x]);
					}
					?>
				</td>
				
				
<!--2-->		
		<? for($j=0;$j<$store;$j++){?>
				<td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;">
					<? if($sitem_ex[$srsr_no[$j]][$item_code[$x]]>0)
					{
						$total[$item_code[$x]] = $total[$item_code[$x]] + $sitem_ex[$srsr_no[$j]][$item_code[$x]];
						$stotal[$item_code[$x]] = $stotal[$item_code[$x]] + $sitem_ex[$srsr_no[$j]][$item_code[$x]];
						echo (int)(($sitem_ex[$srsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 
						if((($sitem_ex[$srsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($sitem_ex[$srsr_no[$j]][$item_code[$x]])%$pack_size[$x]);
					}?>
				</td>
		<? }?>
				<td>
					<?
					if($total[$item_code[$x]]>0)
					{
						echo (int)(($stotal[$item_code[$x]])/$pack_size[$x]); 
						if((($stotal[$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($stotal[$item_code[$x]])%$pack_size[$x]);
					}
					?>
				</td>
				
				
<!--3-->				
		<? for($j=0;$j<$other;$j++){?>
				<td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;">
					<? if($oitem_ex[$orsr_no[$j]][$item_code[$x]]>0)
					{
						$total[$item_code[$x]] = $total[$item_code[$x]] + $oitem_ex[$orsr_no[$j]][$item_code[$x]];
						$ototal[$item_code[$x]] = $ototal[$item_code[$x]] + $oitem_ex[$orsr_no[$j]][$item_code[$x]];
						echo (int)(($oitem_ex[$orsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 
						if((($oitem_ex[$orsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($oitem_ex[$orsr_no[$j]][$item_code[$x]])%$pack_size[$x]);
					}?>
				</td>
		<? }?>
				<td>
					<?
					if($total[$item_code[$x]]>0)
					{
						echo (int)(($ototal[$item_code[$x]])/$pack_size[$x]); 
						if((($ototal[$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($ototal[$item_code[$x]])%$pack_size[$x]);
					}
					?>
				</td>
								<td>
					<?
					if($total[$item_code[$x]]>0)
					{
						echo (int)(($total[$item_code[$x]])/$pack_size[$x]); 
						if((($total[$item_code[$x]])%$pack_size[$x])>0) 
						echo '-'.(($total[$item_code[$x]])%$pack_size[$x]);
					}
					?>
				</td>
				</tr>
		<? }?>
		</tbody>
		</table>
		<?
}






elseif($_POST['report']==1006)
{
		$report="Product Movement Detail Report (Depot)";
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="36" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';

if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		  <th rowspan="3">S/L</th>
		  <th rowspan="3">FG</th>
		  <th rowspan="3">Item Name </th>
		  <th rowspan="3">Grp</th>
		  <th colspan="3" rowspan="2"><div align="center">Opening</div></th>
		  <th colspan="12" bgcolor="#339999" style="text-align:center">Item Out </th>
		  <th colspan="12" bgcolor="#99CC99" style="text-align:center">Item In </th>
		  <th colspan="3" rowspan="2"><div align="center">Closing</div></th>
		</tr>
		<tr>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Party Chalan </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Store Chalan </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Other Issue </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Total Issue </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Sales Return </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Store Chalan </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Transfer Receive </th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Total Receive </th>
		  </tr>
		<tr>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 
		$sql="select i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i where i.sub_group_id=1096000900010000  ".$item_con." order by i.item_id";
		$table = 'journal_item';
		$show_in = 'sum(item_in-item_ex)';
		$show_ex = 'sum(item_ex-item_in)';

		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		echo '';
		$pre_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date < "'.$f_date.'"';
		$pro_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date <= "'.$t_date.'"';
		$con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date between "'.$f_date.'" and "'.$t_date.'"';
		$open = find_a_field($table,$show_in,$pre_con);
		$issue_in = find_a_field($table,'sum(item_in)',$con.' and tr_from = "Issue"');
		$return = find_a_field($table,'sum(item_in)',$con.' and tr_from = "Return"');
		$total_in = find_a_field($table,'sum(item_in)',$con);
		$otr_in = $total_in - ($issue_in + $return);

		$sales = find_a_field($table,'sum(item_ex)',$con.' and tr_from = "Sales"');
		$issue_ex = find_a_field($table,'sum(item_ex)',$con.' and tr_from = "Issue"');
		$total_ex = find_a_field($table,'sum(item_ex)',$con);
		$otr_ex = $total_ex - ($issue_ex + $sales);
		$closing = find_a_field($table,$show_in,$pro_con);

		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->finish_goods_code?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sales_item_type?></td>
		
		<? ssd($open,$row->pack_size);?>
		<? ssd($sales,$row->pack_size);?>
		<? ssd($issue_ex,$row->pack_size);?>
		<? ssd($otr_ex,$row->pack_size);?>
		<? ssd($total_ex,$row->pack_size);?>
		<? ssd($return,$row->pack_size);?>
		<? ssd($issue_in,$row->pack_size);?>
		<? ssd($otr_in,$row->pack_size);?>
		<? ssd($total_in,$row->pack_size);?>
		<? ssd($closing,$row->pack_size);?>
		</tr><? }?>
		
		</tbody>
		</table>
		<?
}

elseif($_POST['report']==1007)
{		if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 
		$report="Product Movement Summary Report (Depot)";
		?>
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';

if(isset($t_date)) 
		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';
		echo '</div>';

		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		?>
		</td></tr>
		<tr>
		  <th rowspan="2">S/L</th>
		  <th rowspan="2">Item Name </th>
		  <th rowspan="2">Grp</th>
		  <th colspan="3"><div align="center">Opening</div></th>
		  <th colspan="3" bgcolor="#339999" style="text-align:center">Item Out/Total Issue </th>
		  <th colspan="3" bgcolor="#99CC99" style="text-align:center">Item In/Total Receive </th>
		  <th colspan="3"><div align="center">Closing</div></th>
		</tr>
		
		<tr>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		  <th bgcolor="#339999">Crt</th>
		  <th bgcolor="#339999">Pcs</th>
		  <th bgcolor="#339999">TPcs</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 
		$sql="select i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i where i.sub_group_id=1096000300010000 ".$item_con." order by i.item_id";
		$table = 'journal_item';
		$show_in = 'sum(item_in-item_ex)';
		$show_ex = 'sum(item_ex-item_in)';

		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		echo '';
		$pre_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date < "'.$f_date.'"';
		$pro_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date <= "'.$t_date.'"';
		$con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date between "'.$f_date.'" and "'.$t_date.'"';
		$open = find_a_field($table,$show_in,$pre_con);
		$total_in = find_a_field($table,'sum(item_in)',$con);
		$total_ex = find_a_field($table,'sum(item_ex)',$con);
		$closing = find_a_field($table,$show_in,$pro_con);

		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->sales_item_type?></td>
		
		<? ssd($open,$row->pack_size);?>
		<? ssd($total_ex,$row->pack_size,'#99FFFF');?>
		<? ssd($total_in,$row->pack_size,'#FFCCFF');?>
		<? ssd($closing,$row->pack_size);?>
		</tr><? }?>
		
		</tbody>
		</table>
		<?
}

elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
?>
</div>
</body>
</html>