<? ob_start(); ?>
<?php
include("../includes/config.php");

$cid = $_GET['cid'];
$sid = $_GET['sid'];
$bid = $_GET['bid'];
 $delete="Delete from book where b_id='$bid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:notebook_list.php?sid=$sid&cid=$cid&msg=dsucc");
}
?>
<? ob_flush(); ?>