<? ob_start(); ?>
<?php
include("includes/config.php");

$ftyid = $_GET['ftyid'];
 $delete="Delete from ftype where fty_id='$ftyid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:ftype.php?msg=dsucc");
}
?>
<? ob_flush(); ?>