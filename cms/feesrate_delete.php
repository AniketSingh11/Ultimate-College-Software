<? ob_start(); ?>
<?php
include("head_top.php");   

$cid = $_GET['cid'];
$sid = $_GET['s_id'];
$bid = $_GET['bid'];
$frid = $_GET['frid'];
$fgdid = $_GET['fgd_id'];
if($fgdid){
$delete1=mysql_query("Delete from frate where ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid AND fgd_id=$fgdid");
  if(!$delete1)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:feesrate.php?cid=$cid&bid=$bid&msg=dsucc");
}
}
?>
<? ob_flush(); ?>