<? ob_start(); ?>
<?php
include("../includes/config.php");

$bid = $_GET['uomid'];
 $delete="Delete from inv_uom where uom_id='$bid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:inv_uom.php?msg=dsucc");
}
?><? ob_flush(); ?>