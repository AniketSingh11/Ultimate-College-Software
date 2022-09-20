<? ob_start(); ?>
<?php
include("includes/config.php");

$hid = $_GET['hid'];
$cid = $_GET['cid'];
$sid = $_GET['sid'];
$mid = $_GET['mid'];
$subid = $_GET['subid'];
$bid = $_GET['bid'];
 $delete="Delete from homework where h_id='$hid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:shomework_mng.php?cid=$cid&sid=$sid&mid=$mid&subid=$subid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>