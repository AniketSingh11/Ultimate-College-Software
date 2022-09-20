<? ob_start(); ?>
<?php
include("includes/config.php");

$comid = $_GET['comid'];
 $delete="Delete from community where com_id='$comid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:community.php?msg=dsucc");
}
?>
<? ob_flush(); ?>