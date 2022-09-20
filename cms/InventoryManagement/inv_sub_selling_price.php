<?php

error_reporting(E_ALL ^ E_NOTICE);
// Make Database Connection
include("../includes/config.php");
//include("header_top.php");
session_start();


	$itemid = $_GET['itemid'];
 	/* 
	$agencyl = "SELECT uom_id,uom_name,uom_mode FROM inv_uom where uom_id=$uomid";
	$result = mysql_query($agencyl) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
*/	
	$purchase = "SELECT * FROM inv_purchase left join inv_uom on (inv_uom.uom_id = inv_purchase.uom_id) 
	left join inv_purchase_mode on (inv_purchase_mode.pur_id=inv_purchase.pur_id) where inv_purchase.item_id= $itemid
	order by inv_purchase.created desc limit 1";
	
    $result_purchase = mysql_query($purchase) or die(mysql_error());
    $row_purchase = mysql_fetch_assoc($result_purchase);
	if($row_purchase['uom_mode']==0){ 
	echo '0';
	}else{
	echo $row_purchase['selling_price_sub']; 
	}
?>