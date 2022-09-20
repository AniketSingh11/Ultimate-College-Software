<? ob_start(); ?>
<?php
include("../includes/config.php");

$bid = $_GET['brandid'];
 $delete="Delete from inv_brand where brand_id='$bid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:inv_brand.php?msg=dsucc");
}
?><? ob_flush(); ?>