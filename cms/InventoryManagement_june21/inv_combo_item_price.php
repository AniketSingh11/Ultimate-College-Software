<?php

error_reporting(E_ALL ^ E_NOTICE);
// Make Database Connection
include("../includes/config.php");
//include("header_top.php");
session_start();



$bid = $_GET['combid'];

?>
<?php
            $comboparent = "SELECT * FROM inv_combo_parent left join inv_combo on(inv_combo.com_parent_id = inv_combo_parent.com_parent_id) 
						where inv_combo_parent.com_parent_id = $bid";
            $result_combo = mysql_query($comboparent) or die(mysql_error());
			
			$item_price = array();
            while($row_combo = mysql_fetch_assoc($result_combo)){
					
					$purchasechild = "SELECT * FROM inv_purchase where inv_purchase.item_id = ".$row_combo['package_items'] ." order by created desc";
            		$result_purchase = mysql_query($purchasechild) or die(mysql_error());
					
					$row_purchase = mysql_fetch_assoc($result_purchase);
					
					$total_price = $row_purchase['sell_price'] * $row_combo['qty'];
					
					array_push($item_price,$total_price);
					//echo $sellprice = ($row['sell_price']=="") ? "0" : $row['sell_price'];
					
			}
			
			echo array_sum($item_price);
			
			
?>