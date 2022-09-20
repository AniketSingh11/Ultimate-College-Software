<?php 
include("../includes/config.php");

include("header.php");
include("includes/log_permission_delete_header.php");
if($_SESSION['admin_type']=="0" || in_array("loan_list.php", $permissions_record_delete) ){
include("log_delete_header.php");
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
}
else
{
	header("location:loan_list.php");
}
?>

