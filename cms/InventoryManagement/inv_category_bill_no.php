<?php
error_reporting(E_ALL ^ E_NOTICE);
include("../includes/config.php");

$catid = $_GET['catid'];
?>
<?php
$bill_result = mysql_query("select * from inv_category where cat_id=$catid") or die(mysql_error());
$bill_row = mysql_fetch_assoc($bill_result);
$bill_auto = $bill_row['Cat_billno'];
$billno = $bill_row['cat_prefix'] . str_pad($bill_auto, 5, '0', STR_PAD_LEFT);
echo $billno;
?>