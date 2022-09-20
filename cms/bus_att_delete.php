<? ob_start(); ?>
<?php
include("head_top.php"); 
//include("includes/config.php");

$rid = $_GET['rid'];
$mid = $_GET['mid'];
$eday = $_GET['eday'];
$bid = $_GET['bid'];
//echo $acyear;
//die();

    $result=mysql_query("Delete from battendance where day='$eday' AND m_id='$mid' AND b_id='$bid' AND r_id='$rid'");
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:bus_att_mng.php?rid=$rid&mid=$mid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>