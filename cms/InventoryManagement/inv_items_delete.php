<? ob_start(); ?>
<?php
include("../includes/config.php");

$bid = $_GET['itemid'];
 $delete="UPDATE inv_items SET active=0 where item_id='$bid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:inv_items.php?msg=dsucc");
}
?><? ob_flush(); ?>