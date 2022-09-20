<? ob_start(); ?>
<?php
include("../includes/config.php");

$cid = $_GET['cid'];
$sid = $_GET['sid'];
$ssid = $_GET['ssid'];
 $delete="Delete from student where ss_id='$ssid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:student.php?sid=$sid&cid=$cid&msg=dsucc");
}
?>
<? ob_flush(); ?>