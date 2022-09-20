<? ob_start(); ?>
<?php
include("includes/config.php");

$oid = $_GET['o_id'];
 
 $delete="Delete from others where o_id='$oid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:others_list.php?msg=dsucc");
}
?>
<? ob_flush(); ?>