<? ob_start(); ?>
<?php
include("includes/config.php");

$etid = $_GET['etid'];
 $delete="Delete from event_type where et_id='$etid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:full_event_type.php?msg=dsucc");
}
?>
<? ob_flush(); ?>