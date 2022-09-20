<?php 
include("header.php");
$id=$_GET['id'];
$stid=$_GET['stid'];
$query="delete from staff_salary where id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:emp_salary_list.php?id=$stid&msg=dsucc");
}
else
{
	header("location:emp_salary_list.php?id=$stid&msg=err");
}
?>

