<?php 
include("../includes/config.php");
include("header.php");
include("includes/log_permission_delete_header.php");

if($_SESSION['admin_type']=="0" || in_array("salary_inhand_report.php", $permissions_record_delete) ){ 
include("log_delete_header.php");
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
}
else
{
	header("location:salary_inhand_report.php");
}
?>

