<? ob_start(); ?>
<?php
include("../includes/config.php");

$parentid = $_GET['parentid'];

//item delete
$result_material = mysql_query("select * from inv_material
        inner join inv_material_parent on (inv_material_parent.mat_parent_id=inv_material.mat_parent_id) where inv_material_parent.mat_parent_id=$parentid");

$pur_parent_id = $row_purchase['pur_parent_id'];

$exbilllist = mysql_query("SELECT * FROM inv_material_payment WHERE mat_parent_id=$parentid");
$exbill = mysql_fetch_array($exbilllist);
$matpay_id = $exbill['mat_pay_id'];
$oldamount = $exbill['payamount'];
$oldptype = $exbill['p_type'];
$oldcstatus = $exbill['c_status'];
$ba_id = $exbill['ba_id'];

while ($row_mat_del = mysql_fetch_assoc($result_material)) {

    $result_select2 = mysql_query("select * from inv_items where item_id=" . $row_mat_del['item_id']);
    $row_items_select2 = mysql_fetch_assoc($result_select2);
    echo 'Child I delete Loop' . $row_items_select2['item_qty'] . ' + ' . $row_mat_del['qty'] . '<br>';

    //get original qty
    $orig_qty11 = $row_items_select2['item_qty'] + $row_mat_del['qty'];
    $orig_qty1 = ($orig_qty11 < 0) ? "0" : $orig_qty11;
    //update total qty
    echo $sql_item2 = "UPDATE inv_items SET item_qty='$orig_qty1' where item_id=" . $row_mat_del['item_id'];
    echo '<br>';
    $result2 = mysql_query($sql_item2) or die("Could not update data into DB: " . mysql_error());

    //udpate brand qty
    $qry_brand = "select * from inv_brand_items where item_id=" . $row_mat_del['item_id'] . " and brand_id = " . $row_mat_del['brand_id'];
    $result_brand = mysql_query($qry_brand);
    $row_brand = mysql_fetch_assoc($result_brand);

    if (!empty($row_brand)) {
        echo 'brand items';
        $brand_qty = $row_brand['qty'] + $row_mat_del['qty'];
        $brand_qty_i = ($brand_qty < 0) ? "0" : $brand_qty;
        $sql_item_brand = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty_i' where item_id=" . $row_mat_del['item_id'] . " and brand_id = " . $row_mat_del['brand_id']);
    }
}


if ($result2 || empty($row_mat_del)) {
    //delete material
    $qry_del_child = mysql_query("delete from inv_material where mat_parent_id='$parentid'") or die("Could not delete data from DB: " . mysql_error());
    $qry_del_pa = mysql_query("delete from inv_material_parent where mat_parent_id='$parentid'") or die("Could not delete data from DB: " . mysql_error());

    /*     * ********************************Hand cash pay Update **************************************** */
    if ($oldptype == 'cash') {
        $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
        $cash = mysql_fetch_array($cashlist);
        $currentcash = $cash['amount'];

        $updatecash = $currentcash - ($oldamount);
        $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
    } else if ($oldptype == 'cheque') {

        if ($oldcstatus == '2') {
            $delete1 = "Delete from bank_deposit where mat_pay_id='$matpay_id' AND ba_id='$ba_id'";
            $result2 = mysql_query($delete1);
            $classlist1 = mysql_query("SELECT * FROM bank_account WHERE ba_id=$ba_id");
            $class1 = mysql_fetch_array($classlist1);
            $amount = $oldamount;
            $accountamount = $class1['amount'];
            $accountcash = $accountamount - $amount;
            $cashqry = mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$ba_id");
        }
    }
}

//combo delete
$result_matcombo_del = mysql_query("SELECT * from inv_material_combo_parent left join inv_material_combo_child 
	on (inv_material_combo_child.mat_com_id = inv_material_combo_parent.mat_com_id) 
	inner join inv_combo on (inv_combo.com_parent_id=inv_material_combo_parent.com_parent_id and package_items=item_id) where mat_parent_id='$parentid' ") or die("Could not fetch inv_material_combo_parent data into DB: " . mysql_error());
echo '<br>';
while ($row_matcomb_del = mysql_fetch_assoc($result_matcombo_del)) {

    $result_items_1 = mysql_query("SELECT * FROM inv_purchase
 WHERE item_id = " . $row_matcomb_del['item_id'] . " order by inv_purchase.created desc limit 1");

    $row_items_1 = mysql_fetch_assoc($result_items_1);

    $result_select1 = mysql_query("select * from inv_items where item_id=" . $row_matcomb_del['item_id']);
    $row_items_select1 = mysql_fetch_assoc($result_select1);

    echo 'Child II delete Loop' . $row_items_select1['item_qty'] . ' + ' . $row_matcomb_del['qty'] . '<br>';

    //get original qty
    $orig_qty2 = $row_items_select1['item_qty'] + $row_matcomb_del['qty'];
    $orig_qty = ($orig_qty2 < 0) ? "0" : $orig_qty2;
    //update total qty
    echo $sql_item1 = "UPDATE inv_items SET item_qty='$orig_qty' where item_id=" . $row_matcomb_del['item_id'];
    echo '<br>';
    $result11 = mysql_query($sql_item1) or die("Could not update data into DB: " . mysql_error());

    //udpate brand qty
    $qry_brand = "select * from inv_brand_items where item_id=" . $row_matcomb_del['item_id'] . " and brand_id = " . $row_matcomb_del['brand_id'];
    $result_brand = mysql_query($qry_brand);
    $row_brand = mysql_fetch_assoc($result_brand);

    if (!empty($row_brand)) {
        echo 'brand items';
        $brand_qty = $row_brand['qty'] + $row_matcomb_del['qty'];
        $brand_qty_c = ($brand_qty < 0) ? "0" : $brand_qty;
        $sql_item_brand = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty_c' where item_id=" . $row_matcomb_del['item_id'] . " and brand_id = " . $row_matcomb_del['brand_id']);
    }
}

$result_two_delete = mysql_query("DELETE inv_material_combo_parent,inv_material_combo_child FROM inv_material_combo_parent 
	INNER JOIN inv_material_combo_child on (inv_material_combo_child.mat_com_id= inv_material_combo_parent.mat_com_id) 
	where inv_material_combo_parent.mat_parent_id = '$parentid'");




if (!$result_two_delete) {
    die("Query Failed: " . mysql_error());
} else {

    header("Location:inv_material_issue.php?msg=dsucc");
}
?>
<? ob_flush(); ?>