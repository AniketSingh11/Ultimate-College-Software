<? ob_start(); ?>
<?php
include("includes/config.php");

$btimeid = $_GET['btimeid'];
 $delete="Delete from bustiming where btime_id='$btimeid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:bus_timing.php?msg=dsucc");
}
?>
<? ob_flush(); ?>