<?php 
include("header.php");
$aid=$_GET['id'];
$query="delete from staff_advance where a_id='$aid'";
$result=mysql_query($query);
if($result)
{
	header("location:advance_list.php?msg=dsucc");
}
else
{
	header("location:advance_list.php?msg=err");
}
?>

