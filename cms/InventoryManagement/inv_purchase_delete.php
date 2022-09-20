<? ob_start(); ?>
<?php
include("../includes/config.php");


$ag_pur = $_GET['from'];
if ($ag_pur == 'purchase') {

    $nid = $_GET['purid'];

    $result_purchase = mysql_query("select * from inv_purchase inner join inv_purchase_parent on (inv_purchase_parent.pur_parent_id=inv_purchase.pur_parent_id) where pur_id=$nid");
    $row_purchase = mysql_fetch_assoc($result_purchase);

    $pur_parent_id = $row_purchase['pur_parent_id'];


    /*     * * Update Item qty ** */
    $itemname = $row_purchase['item_id'];
    $result_select = mysql_query("select * from inv_items where item_id=$itemname");
    $row_items_select = mysql_fetch_assoc($result_select);
    //get original qty
    $orig_qty = $row_items_select['item_qty'] - $row_purchase['qty'];
    //set total qty
    $tot_qty = ($orig_qty < 0) ? "0" : $orig_qty;
    $orig_amt = $row_purchase['overeall_total'] - $row_purchase['total'];
    $tot_amt = ($orig_amt < 0) ? "0" : $orig_amt;
    //update total qty
    $sql_item = "UPDATE inv_items SET item_qty='$tot_qty' where item_id=$itemname";
    $result1 = mysql_query($sql_item) or die("Could not update data in DB: " . mysql_error());

    //update over all total amount 
    $sql_par = "UPDATE inv_purchase_parent SET overeall_total='$tot_amt' where pur_parent_id=$pur_parent_id";
    $result1 = mysql_query($sql_par) or die("Could not update data in DB: " . mysql_error());

    //update brand items
    $qry_brand = "select * from inv_brand_items where item_id=" . $itemname . " and brand_id = " . $row_purchase['brand_id'];
    $result_brand = mysql_query($qry_brand);
    $row_brand = mysql_fetch_assoc($result_brand);

    if (!empty($row_brand)) {
        echo 'brand items';
        $brand_qty = $row_brand['qty'] - $row_purchase['qty'];
        $brand_qty = ($brand_qty < 0) ? "0" : $brand_qty;
        $sql_item_brand = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty' where item_id=" . $itemname . " and brand_id = " . $row_purchase['brand_id']);
    }

    $delete = "Delete from inv_purchase where pur_id='$nid' ";
    $result = mysql_query($delete) or die("Could not delete data from DB: " . mysql_error());
} else {

    $parentid = $_GET['purid'];

    //$result_parent = mysql_query("select * from inv_purchase_parent where pur_parent_id='$parentid'");
    //$row_parent = mysql_fetch_assoc($result_purchase);

    $result_purchase = mysql_query("select * from inv_purchase_parent inner join inv_purchase on (inv_purchase_parent.pur_parent_id=inv_purchase.pur_parent_id) where inv_purchase_parent.pur_parent_id=$parentid");

    while ($row_purchase = mysql_fetch_assoc($result_purchase)) {

        $purid = $row_purchase['pur_id'];

        /*         * * Update Item qty ** */
        $itemnname = $row_purchase['item_id'];
        $result_select = mysql_query("select * from inv_items where item_id=$itemname");
        $row_items_select = mysql_fetch_assoc($result_select);
        //get original qty
        $orig_qty = $row_items_select['item_qty'] - $row_purchase['qty'];
        //set total qty
        $tot_qty = ($orig_qty < 0) ? "0" : $orig_qty;
        $orig_amt = $row_purchase['overeall_total'] - $row_purchase['total'];
        $tot_amt = ($orig_amt < 0) ? "0" : $orig_amt;
        //update total qty
        $sql_item = "UPDATE inv_items SET item_qty='$tot_qty' where item_id=$itemname";

        $result1 = mysql_query($sql_item) or die("Could not insert data into DB: " . mysql_error());

        //update over all total amount 
        $sql_par = "UPDATE inv_purchase_parent SET overeall_total='$tot_amt' where pur_parent_id=$parentid";
        $result1 = mysql_query($sql_par) or die("Could not update data in DB: " . mysql_error());

        //update brand items
        $qry_brand = "select * from inv_brand_items where item_id=" . $itemname . " and brand_id = " . $row_purchase['brand_id'];
        $result_brand = mysql_query($qry_brand);
        $row_brand = mysql_fetch_assoc($result_brand);

        if (!empty($row_brand)) {
            echo 'brand items';
            $brand_qty = $row_brand['qty'] - $row_purchase['qty'];
            $brand_qty = ($brand_qty < 0) ? "0" : $brand_qty;
            $sql_item_brand = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty' where item_id=" . $itemname . " and brand_id = " . $row_purchase['brand_id']);
        }

        $delete = "Delete from inv_purchase where pur_id='$purid' ";
        $result1 = mysql_query($delete);
    }

    $result = mysql_query("Delete from inv_purchase_parent where pur_parent_id='$parentid' ");
}


if (!$result) {
    die("Query Failed: " . mysql_error());
} else {
    if ($ag_pur == 'purchase')
        header("Location:inv_purchase.php?msg=dsucc");
    else
        header("Location:inv_agency.php?msg=dsucc");
}
?>
<? ob_flush(); ?>