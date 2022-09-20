<? ob_start(); ?>
<?php
include("head_top.php"); 
//include("includes/config.php");


$mid = $_GET['mid'];
$eday = $_GET['eday'];
echo $acyear;
//die();

$select_record=mysql_query("SELECT * FROM sattendance where ay_id=$acyear");
					while($queryfetch=mysql_fetch_array($select_record))
					{ 
 $delete="Delete from sattendance where day='$eday' AND m_id='$mid'";
    $result=mysql_query($delete);
	
					}
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:satt_mng.php?mid=$mid&msg=dsucc");
}
?>
<? ob_flush(); ?>