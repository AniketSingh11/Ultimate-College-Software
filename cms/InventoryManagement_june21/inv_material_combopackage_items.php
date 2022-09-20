<?php

error_reporting(E_ALL ^ E_NOTICE);
// Make Database Connection
include("../includes/config.php");
//include("header_top.php");
session_start();



$bid = $_POST['comboid'];
$id = $_POST['id'];
?>
<?php
if($bid!=0){
$comboparent = "SELECT * FROM inv_combo_parent left join inv_combo on(inv_combo.com_parent_id = inv_combo_parent.com_parent_id) 
			left join inv_items on (item_id = package_items) left join inv_uom on (inv_uom.uom_id = inv_combo.uom_id)
						where inv_combo_parent.com_parent_id = $bid and inv_items.active=1 and inv_items.item_status=1";
$result_combo = mysql_query($comboparent) or die(mysql_error());

$item_price = array();
$i = 0;

while ($row_combo = mysql_fetch_assoc($result_combo)) {


    $purchasechild = "SELECT * FROM inv_purchase left join inv_purchase_mode on 
					(inv_purchase_mode.pur_id=inv_purchase.pur_id) 
                                        left join inv_brand on (inv_brand.brand_id=inv_purchase.brand_id) where inv_purchase.item_id = " . $row_combo['package_items'] . " "
            . "and inv_purchase.brand_id = " . $row_combo['brand_id'] . " order by inv_purchase.created desc";
    $result_purchase = mysql_query($purchasechild) or die(mysql_error());

    $row_purchase = mysql_fetch_assoc($result_purchase);



    if ($row_purchase['uomname_sub'] != "") {
        $uomname_last = $row_purchase['uomname_sub'];
        $sellprice = $row_purchase['selling_price_sub'];
        $total_price = $row_purchase['selling_price_sub'] * $row_combo['qty'];
    } else {
        $uomname_last = $row_combo['uom_name'];
        $sellprice = $row_purchase['sell_price'];
        $total_price = $row_purchase['sell_price'] * $row_combo['qty'];
    }


    echo '<div class="field-group div_check grid-8">		
								<div class="field">
								<input name="combo_item_list[]" type="checkbox"  checked id="combo_item_list' . $id . '_' . $i . '" onchange="changeCheckedItem(' . $id . ',' . $i . ');">
								' . $row_combo['item_name'] . '
								<input name="combo_item_listst[]" type="hidden" value="1" id="combo_item_listst' . $id . '_' . $i . '">
								<input name="combo_item_listid[]" type="hidden" value="' . $row_combo['package_items'] . '" id="combo_item_listid' . $id . '_' . $i . '">
					</div></div> 
                                        
                                        <div class="field-group div_check grid-4">		
								<label>' . $row_purchase['brand_name'] . '</label>
								<input name="combo_item_listbrand[]" type="hidden" value="' . $row_combo['brand_id'] . '" id="combo_item_listbrand' . $id . '_' . $i . '">
					</div>

					<div class="field-group div_check grid-4">		
								<label></label>
								<input name="combo_item_listqty[]" type="text" value="' . $row_combo['qty'] . '" 
								id="combo_item_listqty' . $id . '_' . $i . '" class="comboqty_class" style="width:100%;" onkeyup="getSell_byQty(' . $id . ',' . $i . ');">
								<span class="error" id="comboqty_error' . $id . '_' . $i . '">  </span>
                                                                    <input name="combo_item_listsell[]" type="hidden" class="comb_sell" value="' . $sellprice . '" id="combo_item_listsell' . $id . '_' . $i . '">
					</div>
					
					<div class="field-group div_check grid-4">		
								<label style="text-align:center;">' . $uomname_last . '</label>
								<input name="combo_item_listuom[]" type="hidden" value="' . $row_combo['uom_id'] . '" id="combo_item_listuom' . $id . '_' . $i . '">
					</div>
					<div class="field-group div_check grid-4">		
								<label id="combo_item_listtotal_label' . $id . '_' . $i . '">' . $total_price . '</label>
								<input name="combo_item_listtotal[]" type="hidden" class="comb_total_sell" value="' . $total_price . '" id="combo_item_listtotal' . $id . '_' . $i . '">
					</div>
					<div class="clear"></div>
					';
    $i++;
}
}
else{
    echo '<div class="field-group div_check grid-4">		
								<input name="combo_item_listtotal[]" type="hidden" class="comb_total_sell" value="' . 0 . '" id="combo_item_listtotal' . $id . '_' . $i . '">
					</div>';
}
?>