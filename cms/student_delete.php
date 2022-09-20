<? ob_start(); ?>
<?php
include("includes/config.php");

$cid = $_GET['cid'];
$ssid = $_GET['ssid'];
$sid = $_GET['sid'];
 $delete="Delete from student where ss_id='$ssid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
	$delete1=mysql_query("Delete from parent where ss_id='$ssid'");
header("Location:student.php?cid=$cid&sid=$sid&msg=dsucc");
}
?>
<? ob_flush(); ?>