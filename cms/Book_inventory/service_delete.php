<? ob_start(); ?>
<?php
include("../includes/config.php");

$seid = $_GET['seid'];
 $delete="Delete from service where se_id='$seid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:service.php?msg=dsucc");
}
?>
<? ob_flush(); ?>