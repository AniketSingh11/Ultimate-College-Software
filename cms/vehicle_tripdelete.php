<? ob_start(); ?>
<?php

include("includes/config.php");

$vtid = $_GET['vid'];
 $delete="Delete from  vehicle_trip where vt_id='$vtid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:vehicle_trip.php?msg=dsucc");
}
?>
<? ob_flush(); ?>