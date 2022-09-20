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

    $result=mysql_query("UPDATE battendance SET eresult='' WHERE r_id='$rid' AND m_id='$mid' AND day=$eday AND b_id=$bid");
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