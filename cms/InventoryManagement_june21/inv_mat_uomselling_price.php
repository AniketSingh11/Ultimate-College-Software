<?php

error_reporting(E_ALL ^ E_NOTICE);
// Make Database Connection
include("../includes/config.php");
//include("header_top.php");
session_start();



$bid = $_GET['itemid'];

?>
<?php
    $agencyl = "SELECT * FROM inv_purchase left join inv_uom on (inv_uom.uom_id = inv_purchase.uom_id) 
	left join inv_items on (inv_items.item_id = inv_purchase.item_id) where inv_purchase.item_id= $bid 
	order by inv_purchase.created desc limit 1";
    $result = mysql_query($agencyl) or die(mysql_error());
    $row = mysql_fetch_assoc($result);
	//echo $sellprice = ($row['sell_price']=="") ? "0" : $row['sell_price'];
	
	echo json_encode($row);
?>