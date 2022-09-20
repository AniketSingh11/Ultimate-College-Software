<? ob_start(); ?>
<?php
include("includes/config.php");

$vid = $_GET['vid'];
 $delete="Delete from vehicle where v_id='$vid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:vehicle.php?msg=dsucc");
}
?>
<? ob_flush(); ?>