<?php 
include("header.php");
$id=$_GET['id'];
$did=$_GET['did'];
$query="delete from staff_salary where id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:driver_salary_list.php?id=$did&msg=dsucc");
}
else
{
	header("location:driver_salary_list.php?id=$did&msg=err");
}
?>

