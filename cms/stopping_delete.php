<? ob_start(); ?>
<?php
include("includes/config.php");

$rid = $_GET['rid'];
$spid = $_GET['spid'];
 $delete="UPDATE trstopping SET r_id=0,ListingID =0 WHERE stop_id ='$spid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:stopping.php?rid=$rid&msg=dsucc");
}
?>
<? ob_flush(); ?>