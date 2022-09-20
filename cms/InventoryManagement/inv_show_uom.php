<?php
	include("../includes/config.php");
	
	$i = $_GET['id'];
	$itemid = $_GET['itemid'];
        $brandid = $_GET['brandid'];
	if($itemid!=0){
	$purchase = "SELECT * FROM inv_purchase left join inv_uom on (inv_uom.uom_id = inv_purchase.uom_id) 
	left join inv_purchase_mode on (inv_purchase_mode.pur_id=inv_purchase.pur_id) where inv_purchase.item_id= $itemid and inv_purchase.brand_id=$brandid
	order by inv_purchase.created desc limit 1";
	
    $result_purchase = mysql_query($purchase) or die(mysql_error());
    $row_purchase = mysql_fetch_assoc($result_purchase);

	if($row_purchase['uom_mode']==0){ 
		//echo 'Fixed';
		echo '<label id="uom'. $i.'" > '.$row_purchase['uom_name'].' </label>
              <input type="hidden" name="uomname[]" id="uom_name'.$i.'" value="'.$row_purchase['uom_id'].'" />
			  <input type="hidden" name="uomname_new[]" id="uom_name'.$i.'" value="" />
			  ';
		
	}
	else {
		
		echo '
		<input type="hidden" name="uomname[]" id="uom_name'.$i.'" value="'.$row_purchase['uom_id'].'" />
		<select name="uomname_new[]" id="uomname_new'.$i.'" class="uommode_change" onchange="getSubSellingPrice('.$i.')">
		<option value="'.$row_purchase['uom_id'].'">'.$row_purchase['uom_name'].'</option>
		<option value="'.$row_purchase['uom_id'].',0">'.$row_purchase['uomname_sub'].'</option>
		</select>';
		
		
	}
        }
?>  
