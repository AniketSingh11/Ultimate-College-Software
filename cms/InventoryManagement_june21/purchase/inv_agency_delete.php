<? ob_start(); ?>
<?php
include("../includes/config.php");

$aid = $_GET['aid'];
 $delete="Delete from inv_agency where agency_id='$aid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:inv_agency.php?msg=dsucc");
}
?><? ob_flush(); ?>