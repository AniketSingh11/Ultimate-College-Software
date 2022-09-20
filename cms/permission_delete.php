<? ob_start(); ?>
<?php
include("includes/config.php");

$pid = $_GET['pid'];
 $delete="Delete from permission where p_id='$pid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:permission.php?msg=dsucc");
}
?>
<? ob_flush(); ?>