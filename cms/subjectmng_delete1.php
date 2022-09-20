<? ob_start(); ?>
<?php
include("includes/config.php");

$cid = $_GET['cid'];
$subid = $_GET['subid'];
$sid = $_GET['sid'];
$bid = $_GET['bid'];
 $delete="Delete from subject where sub_id='$subid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:subject_mng.php?cid=$cid&sid=$sid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>