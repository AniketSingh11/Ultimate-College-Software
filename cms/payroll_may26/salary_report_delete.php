<?php 
include("header.php");
$id=$_GET['id'];
$query="delete from staff_salary_report where id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:salary_report.php?msg=dsucc");
}
else
{
	header("location:salary_report.php?msg=err");
}
?>

