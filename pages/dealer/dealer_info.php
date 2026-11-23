<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$user_data = find_all_field('user_activity_management','','user_id="'.$_SESSION['user']['id'].'"');

// ::::: Edit This Section ::::: 



$title='Customer Information';			// Page Name and Page Title

do_datatable('vendor_table');

$page="dealer_info.php";		// PHP File Name



$table='dealer_info';		// Database Table Name Mainly related to this page

$unique='dealer_code';			// Primary Key of this Database table

$shown='dealer_name_e';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];

//for Insert..................................

if(isset($_POST['insert']))

{	

//if ($_POST['dealer_found']==0) {}
	

$proj_id			= $_SESSION['proj_id'];

$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');


$crud->insert();

 $config_id = mysqli_insert_id($link);


   $acc_ins_led = 'INSERT INTO general_sub_ledger ( sub_ledger_name, type, referance_no, ledger_id, group_for, entry_by, entry_at)
  
  VALUES("'.$_POST['dealer_name_e'].'", "Customer", "'.$config_id.'",  "1220101",  "'.$_SESSION['user']['group'].'", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';


db_query($acc_ins_led);

		
		
	
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);




}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

		
		 $dealer_code =$_POST['dealer_code'];
		 $account_code = $_POST['account_code'];

	  $sql1 = 'update general_sub_ledger set sub_ledger_name="'.$_POST['dealer_name_e'].'" 
	  where referance_no ="'.$dealer_code.'"  and type="Customer"';
		db_query($sql1);




		$type=1;

		$msg='Successfully Updated.';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

// while (list($key, $value)=each($data))

// { $$key=$value;}
foreach ($data as $key => $value) {
    $$key = $value;
}
}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<script type="text/javascript">

$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'yy-mm-dd'

		});

});

function Do_Nav()

{

	var URL = 'pop_ledger_selecting_list.php';

	popUp(URL);

}




function DoNav(theUrl)

{

	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

	day = new Date();

	id = day.getTime();

	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {color: #FFFFFF}
.style4 {color: #FF0000; font-weight: bold; }

-->

</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td><div class="box"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box style2" style="width:100%;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF; text-transform:uppercase;" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>
								
						
                                  <td width="100%" colspan="2"><div class="box" style="width:100%; font-size:12px;">
								  
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  		<tr>
								  		  <td colspan="6">
										  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="33%"><span class="style1" style="padding-top:5px;"><strong>*</strong></span><strong>Party Name:</strong></td>
												<td width="34%"><strong>Propritor Name:</strong></td>
												<td width="33%"><span class="style4" style="padding-top:5px;">*</span><strong>Marketing Persone:</strong></td>
											</tr>
											<tr>
												<td width="33%">
	<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden"  readonly=""/>
  <input name="group_for" required="required" type="hidden" id="group_for" tabindex="1" value="<?=$_SESSION['user']['group'];?>" style="width: 95%;" />
												  
				
				<? if($dealer_name_e!="") {?>							  
         <input name="dealer_name_e" required="required" type="text" id="dealer_name_e" tabindex="1" value="<?=$dealer_name_e?>" style="width: 95%; font-size:12px;" />
		 <? }else{?>
		 <input name="dealer_name_e" required="required" type="text" id="dealer_name_e" tabindex="1" value="<?=$dealer_name_e?>" style="width: 95%; font-size:12px;"
		 onchange="getData2('dealer_name_view_ajax.php', 'dealer_name_view', this.value, document.getElementById('dealer_name_e').value);" />
		 <? }?>
		 <span id="dealer_name_view"></span>
		 </td>
												<td width="34%"><input name="propritor_name_e" type="text" id="propritor_name_e" tabindex="2" value="<?=$propritor_name_e?>"  style="width:95%; font-size:12px;"/></td>
												<td width="33%">
												
												
		<? if($user_data->master_user==1) {?>	
		<select name="marketing_person" id="marketing_person"  style="width:95%; height:32px;" class="js-example-basic-single">

        <option value=""></option>

		<? foreign_relation('marketing_person','person_code','marketing_person_name',$marketing_person,'1');?>
      </select>
	  <? }else{?> 
	  <select name="marketing_person" id="marketing_person"  style="width:95%; height:32px;" class="js-example-basic-single">

	<? foreign_relation('marketing_person','person_code','marketing_person_name',$marketing_person,'person_code="'.$user_data->marketing_person.'"');?>
      </select>
	  <? }?>
												
												
												</td>
											</tr>
											<tr>
												<td width="33%">Mobile No :</td>
												<td width="34%"><span class="style1" style="padding-top:5px;">*</span>Address:</td>
												<td width="33%"><span class="style1" style="padding-top:5px;">*</span>Area:</td>
											</tr>
											<tr>
												<td width="33%"><input name="contact_no" type="text" id="contact_no" tabindex="4" value="<?=$contact_no?>"  style="width:95%; font-size:12px;"/></td>
												<td width="34%"><input name="address_e" type="text" id="address_e" tabindex="14" value="<?=$address_e?>"  style="width:95%; font-size:12px;"/></td>
												<td width="33%"><select name="area_code" required="required" id="area_code" style="width:95%; font-size:12px;" tabindex="9">
                                                  <option></option>
                                                  <? foreign_relation('area','AREA_CODE','AREA_NAME',$area_code,'ZONE_ID="'.$zone_code.'"');?>
                                                </select></td>
											</tr>
											<tr>
												<td width="33%"> Email:</td>
												<td width="34%"><span class="style1" style="padding-top:5px;">*</span>TIN No :</td>
												<td width="33%"><span class="style1" style="padding-top:5px;">*</span>BIN No :</td>
											</tr>
											<tr>
												<td width="33%"><input name="email" type="text" id="email" tabindex="7" value="<?=$email?>" style="width:95%; font-size:12px;" /></td>
												<td width="34%"><input name="tin_no"  type="text" id="tin_no" tabindex="1" value="<?=$tin_no?>" style="width: 95%; font-size:12px;" /></td>
												<td width="33%"><input name="bin_no"  type="text" id="bin_no" tabindex="1" value="<?=$bin_no?>" style="width: 95%; font-size:12px;" /></td>
											</tr>
											<tr>
												<td width="33%">Contact Person:</td>
												<td width="34%">Job Title:</td>
												<td width="33%">Contact Person Phone:</td>
											</tr>
											<tr>
												<td width="33%"><input name="contact_person_name" type="text" id="contact_person_name" tabindex="16" value="<?=$contact_person_name?>" style="width:95%; font-size:12px;" /></td>
												<td width="34%"><input name="contact_person_designation" type="text" id="contact_person_designation" tabindex="17" value="<?=$contact_person_designation?>" style="width:95%; font-size:12px;" /></td>
												<td width="33%"><input name="contact_person_mobile" type="text" id="contact_person_mobile" tabindex="18" value="<?=$contact_person_mobile?>" style="width:95%; font-size:12px;" /></td>
											</tr>
											</table>										  </td>
						  		    </tr>
										
										<tr>
											<td width="6%">&nbsp;</td>
											<td width="10%">&nbsp;</td>
											<td width="6%">&nbsp;</td>
											
											<td width="10%">&nbsp;</td>
											
											<td width="6%">&nbsp;</td>
											<td width="10%">&nbsp;</td>
										</tr>
								  </table>
								  
								  
								  
								  

                                    

                                  </div></td>
                                </tr>

                                

                                

                                <tr>

                                  <td colspan="2">

								  <div class="box1">

								    <table width="60%" border="0" cellspacing="0" align="right" cellpadding="0">

								      <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE &amp; NEW" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                  <td>
                  <!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->                    </td>
                </tr>
							        </table>
								  </div>								  </td>
                                </tr>
                              </table>

    </form></div></td>
						      </tr>

								   <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="vendor_table" class="table table-bordered" cellspacing="0" style="font-size:12px;">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">ID</span></th>

<th bgcolor="#45777B"><span class="style3">Customer Name </span></th>

<th bgcolor="#45777B"><span class="style3">Marketing Person</span></th>
<th bgcolor="#45777B"><span class="style3">Territory</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['depot']!="")

$con .= 'and a.depot="'.$_POST['depot'].'"';


		 $sql = "select person_code, marketing_person_name from marketing_person where 1 group by person_code";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $marketing_person_name[$info->person_code]=$info->marketing_person_name;
		}



		 $sql = "select AREA_CODE, AREA_NAME from area where 1 group by AREA_CODE";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $AREA_NAME[$info->AREA_CODE]=$info->AREA_NAME;
		}


if($user_data->master_user==1){
  $td='select a.'.$unique.',  a.'.$shown.',   a.address_e, a.marketing_person, a.area_code from '.$table.' a	where  1  '.$con.' order by a.dealer_code ';
  }else{
  $td='select a.'.$unique.',  a.'.$shown.',   a.address_e, a.marketing_person, a.area_code from '.$table.' a	where  1  '.$con.' 
  and a.marketing_person="'.$user_data->marketing_person.'" order by a.dealer_code ';
}
$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');" bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
<td><?=$rp[0];?></td>
<td><?=$rp[1];?></td>
<td><?=$marketing_person_name[$rp[3]];?></td>
<td><?=$AREA_NAME[$rp[4]];?></td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>

									<div id="pageNavPosition"></div>									</td>

								  </tr>
		</table>



	</div></td>
  </tr>
</table>

<script type="text/javascript"><!--

    var pager = new Pager('grp', 10000);

    pager.init();

    pager.showPageNav('pager', 'pageNavPosition');

    pager.showPage(1);

//-->

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>




<script>


function duplicate(){

var dealer_code_2 = ((document.getElementById('dealer_code_2').value)*1);

var customer_id = ((document.getElementById('customer_id').value)*1);



   if(dealer_code_2>0)
  {
  
alert('This customer code already exists.');
document.getElementById('customer_id').value='';


document.getElementById('customer_id').focus();

  } 



}

</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>