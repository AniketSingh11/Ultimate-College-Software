<? ob_start(); ?>
<?php
include("../includes/config.php");

$bid = $_GET['catid'];
 $delete="Delete from inv_category where cat_id='$bid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:inv_category.php?msg=dsucc");
}
?><? ob_flush(); ?>