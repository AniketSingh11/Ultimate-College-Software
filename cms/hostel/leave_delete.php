<?php 
include("header.php");
$lid=$_GET['id'];
$query="delete from staff_leave where id='$lid'";
$result=mysql_query($query);
if($result)
{
	header("location:leave_list.php?syear=$syear&eyear=$eyear&msg=dsucc");
}
else
{
	header("location:leave_list.php?syear=$syear&eyear=$eyear&msg=err");
}
?>

