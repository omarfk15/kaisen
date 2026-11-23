<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Advanced Sales Reports';

$user_data = find_all_field('user_activity_management','','user_id="'.$_SESSION['user']['id'].'"');

$marketing_team_id = find_a_field('marketing_person','team_code','person_code="'.$user_data->marketing_person.'"');
 
$get_team_id = find_a_field('marketing_team','team_code','marketing_person="'.$user_data->marketing_person.'"');


create_combobox('dealer_code');
//create_combobox('marketing_person');
do_calander("#f_date");

do_calander("#t_date");

auto_complete_from_db('item_info','concat(finish_goods_code, "-", item_name)','item_id','1','item_id');

?>



<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><div class="box4">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                              <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                              
							  
							
							
							  
							<?php /*?>  <? if($_SESSION['user']['id']==10001){?> <? }?><?php */?>
							
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="20060207" checked="checked" /></td>

							    <td><div align="left">Product Delivery Report (Sales)</div></td>
						      </tr>
							  
							   <tr>

							    <td><input name="report" type="radio" class="radio" value="20060201" /></td>

							    <td><div align="left">Product Delivery Report Summary</div></td>
						      </tr>
							  
							   <? if($_SESSION['user']['id']==10001) { ?>
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="2501050003" /></td>

							    <td><div align="left">Date Wise FG Sales Report</div></td>
						      </tr>
							  
							 
							  
							  <tr>

							    <td><input name="report" type="radio" class="radio" value="2502040001" /></td>

							    <td><div align="left">Finished Goods National Sales Report</div></td>
						      </tr>
							<? }?>

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                  </tr>

               
                   <tr>
				    <td>Marketing Team:</td>
				    <td>
		<? if($user_data->master_user==1) {?>	
		<select name="team_code" id="team_code"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('marketing_team','team_code','team_name',$_POST['team_code'],'1');?>
    	</select>
		 <? } elseif($user_data->master_user==0 && $get_team_id>0) {?>
		 <select name="team_code" id="team_code"  style="width:90%; height:32px;" >

		<? foreign_relation('marketing_team','team_code','team_name',$_POST['team_code'],'team_code="'.$get_team_id.'"');?>
    	</select>
		 <? } else{?> 
		  <select name="team_code" id="team_code"  style="width:90%; height:32px;" >

		<? foreign_relation('marketing_team','team_code','team_name',$_POST['team_code'],'team_code="'.$marketing_team_id.'"');?>
    	</select>
		  <? }?>	
					</td>
			      </tr>
				  <tr>

                    <td width="36%">Marketing Person:</td>

                    <td width="64%">
			
					
	<? if($user_data->master_user==1) {?>	
	<select name="marketing_person" id="marketing_person"  style="width:90%; height:32px;" >

        <option value=""></option>

		<? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'1');?>
    </select>
	  <? } elseif($user_data->master_user==0 && $get_team_id>0) {?>
	  
	<select name="marketing_person" id="marketing_person"   style="width:90%; height:32px;" >
		 <option value=""></option>
	<? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'team_code="'.$get_team_id.'"');?>
    </select>
	 <? } else{?> 
	<select name="marketing_person" id="marketing_person"  style="width:90%; height:32px;" >

	<? foreign_relation('marketing_person','person_code','marketing_person_name',$_POST['marketing_person'],'person_code="'.$user_data->marketing_person.'"');?>
    </select>
	  <? }?>					</td>
                  </tr>
				  

                 
				  
				  
				 <tr>

                    <td>Customer: </td>

                    <td>
					
					
	<? if($user_data->master_user==1) {?>	
		<select name="dealer_code" id="dealer_code"  style="width:250px; height:32px;"  >

        <option></option>

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?>
      </select>
	  
	   <? } elseif($user_data->master_user==0 && $get_team_id>0) {?>
	   
	    <select name="dealer_code" id="dealer_code"  style="width:250px; height:32px;"  >

        <option></option>

		<? foreign_relation('dealer_info d, marketing_person m','d.dealer_code','d.dealer_name_e',$_POST['dealer_code'],'m.person_code=d.marketing_person and 
		m.team_code="'.$get_team_id.'" ');?>
      </select>
	  
	  <? }else{?>
	  <select name="dealer_code" id="dealer_code"  style="width:250px; height:32px;"   >

        <option></option>

		<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code_src'],'marketing_person="'.$user_data->marketing_person.'"');?>
      </select>
	  <? }?>
					
					
					
					</td>
                  </tr>
				  
				  <tr>

                    <td>Item Sub Group: </td>

                    <td><select name="sub_group_id" id="sub_group_id">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$sub_group_id, "group_id='100000000'");?>

                    </select></td>
                  </tr>
				  
				  
				  <?php /*?><tr>

                    <td>Item Name: </td>

                    <td><select name="item_id" id="item_id">

                      <option></option>

                      <? foreign_relation('item_info i, item_sub_group s','i.item_id','i.item_name',$item_id, "i.sub_group_id=s.sub_group_id and s.group_id=100000000 order by i.sub_group_id,i.item_name");?>

                    </select></td>
                  </tr><?php */?>

               

                  <tr>

                    <td>From:</td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>"/></td>
                  </tr>

                  <tr>

                    <td>To:</td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"/></td>
                  </tr>

				  

					

				  

                  <tr>

                    <td>Inventory Name: </td>

                    <td><select name="warehouse_id" id="warehouse_id">

					  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1');?>

                    </select></td>
                  </tr>

              </table></td>

            </tr>

          </table>

      </div></td>

    </tr>

    <tr>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td><div class="box">

        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><input name="submit" type="submit" class="btn" value="Report" /></td>

            </tr>

          </table>

      </div></td>

    </tr>

  </table>

</form>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");


?>