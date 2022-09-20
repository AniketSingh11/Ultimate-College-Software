<?php 
include("header.php");
$lid=$_GET['id'];
$query="delete from staff_loan where l_id='$lid'";
$result=mysql_query($query);
if($result)
{
	header("location:loan_list.php?msg=dsucc");
}
else
{
	header("location:loan_list.php?msg=err");
}
?>

