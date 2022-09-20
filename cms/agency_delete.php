<? ob_start(); ?>
<?php
include("includes/config.php");

$aid = $_GET['aid'];
 $delete="Delete from agency where a_id='$aid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:agency.php?msg=dsucc");
}
?>
<? ob_flush(); ?>