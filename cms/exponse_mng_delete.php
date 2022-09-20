<? ob_start(); ?>
<?php
include("includes/config.php");

$excid = $_GET['excid'];
$exid = $_GET['exid'];

$classlist1 = mysql_query("SELECT * FROM exponses WHERE ex_id=$exid");
$row = mysql_fetch_array($classlist1);
$exsid = $row["exs_id"];
$excid = $row["exc_id"];
$amount = $row["amount"];

$type = $row["type"];
$delete12 = mysql_query("Delete from advance_payment where ep_id='$exid' ");
if ($type == 0) {
    $result = mysql_query("Delete from exponses where ex_id='$exid' ");
    if (!$result) {
        die("Query Failed: " . mysql_error());
    } else {
        $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
        $cash = mysql_fetch_array($cashlist);
        $currentcash = $cash['amount'];
        $updatecash = $currentcash + $amount;
        $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
        header("Location:exponse_mng.php?excid=$excid&msg=dsucc");
    }
} else if ($type == 1) {
    $result = mysql_query("Delete from exponses where ex_id='$exid' ");
    $result1 = mysql_query("Delete from expense_po_amount where ex_id='$exid' ");
    if (!$result && !$result1) {
        die("Query Failed: " . mysql_error());
    } else {
        header("Location:exponse_mng.php?excid=$excid&msg=dsucc");
    }
}
?>
<? ob_flush(); ?>