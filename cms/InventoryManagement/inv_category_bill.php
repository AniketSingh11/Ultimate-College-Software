<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("../includes/config.php");

$catid = $_GET['catid'];
?>
<?php
 $itemsql = "SELECT inv_items.item_id,item_name FROM inv_items inner join inv_purchase on (inv_purchase.item_id =inv_items.item_id)
             where item_status=1 and active=1 and inv_items.cat_id=$catid group by inv_items.item_id ";
$result = mysql_query($itemsql) or die(mysql_error());
echo '<option value="">Select Items </option>';
while ($row = mysql_fetch_assoc($result)):
    echo "<option value='{$row['item_id']}'>{$row['item_name']}</option>\n";
endwhile;

?>
<? ob_flush(); ?>