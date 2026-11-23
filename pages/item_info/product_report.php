<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

session_start();


ob_start();


require_once "../../../assets/template/layout.top.php";


$title='Product Information';





do_calander("#f_date");


do_calander("#t_date");


// auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');


?>

<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="87%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="3" class="title1"><div align="left">Select Report </div></td>
                              </tr>
                            
							  
							  
							  <tr>
							    <td colspan="2">Sub Group:</td>
							    <td width="86%"><span class="oe_form_group_cell">
						          <select name="item_sub_group" id="item_sub_group" tabindex="4"  style="width:150px">
                                    <option></option>
                                    <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, '1');?>
                                  </select>
						        </span></td>
							  </tr>
							  <tr>
                                <td width="7%"><input name="report" type="radio" class="radio" value="8888" checked="checked" tabindex="2"/></td>
                                <td colspan="2"><div align="left">Product Information</div></td>
                              </tr>
							  
						
                            </table></td>
                        </tr>
                      </table></td>
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
              <td><input name="submit" type="submit" class="btn" value="Report" tabindex="6" /></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
<?


$main_content=ob_get_contents();


ob_end_clean();


include ("../../template/main_layout.php");


?>
