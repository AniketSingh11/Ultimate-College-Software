<? ob_start(); ?>
<?php
include("../includes/config.php");

$bid = $_GET['bid'];
 $delete="Delete from book where b_id='$bid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:notebook_alert.php?msg=dsucc");
}
?><? ob_flush(); ?>