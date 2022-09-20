<? ob_start(); ?>
<?php
include("includes/config.php");

$epid = $_GET['epid'];
 $delete="Delete from extraperoid where ep_id='$epid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:peroid.php?msg=dsucc");
}
?>
<? ob_flush(); ?>