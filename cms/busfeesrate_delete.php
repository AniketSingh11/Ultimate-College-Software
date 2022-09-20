<? ob_start(); ?>
<?php
include("includes/config.php");

$rid = $_GET['rid'];
$bfid = $_GET['bfid'];
 $delete="Delete from trbusfees where bf_id='$bfid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:bus_feesrate.php?rid=$rid&msg=dsucc");
}
?>
<? ob_flush(); ?>