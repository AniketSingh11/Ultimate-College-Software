<? ob_start(); ?>
<?php
include("includes/config.php");

$fgid = $_GET['fgid'];
 $delete="Delete from fgroup where fg_id='$fgid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:fgroup.php?msg=dsucc");
}
?>
<? ob_flush(); ?>