<? ob_start(); ?>
<?php
include("head_top.php"); 
//include("includes/config.php");

$cid = $_GET['cid'];
$sid = $_GET['sid'];
$mid = $_GET['mid'];
$eday = $_GET['eday'];
$bid = $_GET['bid'];
echo $acyear;
//die();

$select_record=mysql_query("SELECT * FROM attendance where ay_id=$acyear");
					while($queryfetch=mysql_fetch_array($select_record))
					{ 
 $delete="Delete from attendance where day='$eday' AND m_id='$mid' AND b_id='$bid' AND c_id='$cid' AND s_id='$sid'";
    $result=mysql_query($delete);
	
					}
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:att_mng.php?cid=$cid&sid=$sid&mid=$mid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>