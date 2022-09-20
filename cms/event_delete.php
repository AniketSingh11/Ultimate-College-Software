<? ob_start(); ?>
<?php
include("includes/config.php");

$evid = $_GET['evid'];
 $delete="Delete from event where ev_id='$evid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:event.php?msg=dsucc");
}
?>
<? ob_flush(); ?>