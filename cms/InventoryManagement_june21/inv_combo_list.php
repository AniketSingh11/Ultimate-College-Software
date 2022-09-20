<? ob_start(); ?>
<?php
include("../includes/config.php");
echo " <option value=''>Select Combo</option> " ;
if(isset( $_GET['classid']) ) 
{
    $catParent = $_GET['classid'];
}
  
                                            $itemsql = "SELECT com_parent_id,package_name FROM inv_combo_parent where class_id='$catParent' or class_id=0";
                                            $result = mysql_query($itemsql) or die(mysql_error());
											while ($row = mysql_fetch_assoc($result)):
                                                echo "<option value='{$row['com_parent_id']}'>{$row['package_name']}</option>\n";
                                            endwhile;
                                           
                                            ?>
<? ob_flush(); ?>