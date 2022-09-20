<? ob_start(); ?>
<?php 
include("header.php");
$id=$_GET['id'];
$syear=$ay['s_year'];
$eyear=$ay['e_year'];
$query="delete from staff_deduction where sd_id='$id'";
$result=mysql_query($query);
$result1=mysql_query("delete from staff_ded_detail where sd_id='$id'");
if($result && $result1)
{
	header("location:common_deduction.php?syear=$syear&eyear=$eyear&msg=dsucc");
}
else
{
	header("location:deduction_detail.php?syear=$syear&eyear=$eyear&msg=err");
}
?>
<? ob_flush(); ?>