<? ob_start(); ?>
<?php
include("includes/config.php");

$cid = $_GET['cid'];
$sid = $_GET['sid'];
$eid = $_GET['eid'];
$subid = $_GET['subid'];
$bid = $_GET['bid'];
$rid = $_GET['rid'];
 $delete="Delete from result where r_id='$rid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:sresult_mng.php?cid=$cid&sid=$sid&eid=$eid&subid=$subid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>