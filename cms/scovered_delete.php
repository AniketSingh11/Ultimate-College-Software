<? ob_start(); ?>
<?php
include("includes/config.php");

$id = $_GET['id'];
$cid = $_GET['cid'];
$sid = $_GET['sid'];
$subid = $_GET['subid'];
$bid = $_GET['bid'];
 $delete="Delete from syllabus_covered where id='$id' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:scovered_mng.php?cid=$cid&sid=$sid&subid=$subid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>