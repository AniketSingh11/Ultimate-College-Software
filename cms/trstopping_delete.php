<? ob_start(); ?>
<?php
include("includes/config.php");

$spid = $_GET['spid'];
 $delete="Delete from trstopping where stop_id='$spid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:trstopping.php?msg=dsucc");
}
?>
<? ob_flush(); ?>