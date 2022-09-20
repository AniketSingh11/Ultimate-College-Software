<? ob_start(); ?>
<?php
include("includes/config.php");
$bfid = $_GET['bfid'];
 $delete="Delete from trbusfees where bf_id='$bfid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:trbus_feesrate.php?msg=dsucc");
}
?>
<? ob_flush(); ?>