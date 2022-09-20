<? ob_start(); ?>
<?php
include("includes/config.php");

$mpdid = $_GET['mpdid'];
 $delete="Delete from mpaydiscount where mpd_id='$mpdid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:mpaydiscount.php?msg=dsucc");
}
?>
<? ob_flush(); ?>