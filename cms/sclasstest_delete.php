<? ob_start(); ?>
<?php
include("includes/config.php");

$ctid = $_GET['ctid'];
$cid = $_GET['cid'];
$sid = $_GET['sid'];
$mid = $_GET['mid'];
$subid = $_GET['subid'];
$bid = $_GET['bid'];
 $delete="Delete from classtest where ct_id='$ctid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:sclasstest_mng.php?cid=$cid&sid=$sid&mid=$mid&subid=$subid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>