<?php 
include("header.php");
$id=$_GET['id'];
$query="delete from salary_inhand where id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:salary_inhand_report.php?msg=dsucc");
}
else
{
	header("location:salary_inhand_report.php?msg=err");
}
?>

