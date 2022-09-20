<?php 
include("header.php");
$id=$_GET['id'];
$oid=$_GET['oid'];
$query="delete from staff_salary where id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:ow_salary_list.php?id=$oid&msg=dsucc");
}
else
{
	header("location:ow_salary_list.php?id=$oid&msg=err");
}
?>

