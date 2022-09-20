<?php 
include("../includes/config.php");
include("header.php");
include("includes/log_permission_delete_header.php"); 

if($_SESSION['admin_type']=="0" || in_array("advance_list.php", $permissions_record_delete) ){
include("log_delete_header.php");
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
}
else
{
	header("location:advance_list.php");
}
?>

