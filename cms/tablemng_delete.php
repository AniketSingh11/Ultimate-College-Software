<? ob_start(); ?>
<?php
include("includes/config.php");

$cid = $_GET['cid'];
$bid = $_GET['bid'];
$ttid = $_GET['ttid'];
$sid = $_GET['sid'];
 $delete="Delete from timetable where tt_id='$ttid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:timetable_mng.php?cid=$cid&sid=$sid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>