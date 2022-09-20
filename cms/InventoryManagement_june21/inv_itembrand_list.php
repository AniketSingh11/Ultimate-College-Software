<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

$bid = $_GET['itemid'];
?>
<?php
if($bid!=0){
 $agencyl = "SELECT *,inv_purchase.brand_id as bran_id FROM inv_purchase left join inv_uom on (inv_uom.uom_id = inv_purchase.uom_id) 
	left join inv_items on (inv_items.item_id = inv_purchase.item_id) left join inv_brand on (inv_brand.brand_id=inv_purchase.brand_id) 
        where inv_purchase.item_id= $bid group by inv_purchase.brand_id
	order by inv_purchase.created desc";
$result = mysql_query($agencyl) or die(mysql_error());
//$row = mysql_fetch_assoc($result);

//echo '<option value="0">N/A</option>';
while ($row = mysql_fetch_assoc($result)):
    if($row['bran_id']==0){
       echo "<option value='0'>N/A</option>\n"; 
    }else{
        echo "<option value='{$row['bran_id']}'>{$row['brand_name']}</option>\n";
    }
endwhile;
}
?>
<? ob_flush(); ?>