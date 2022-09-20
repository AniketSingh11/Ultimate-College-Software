<?php 
include("../includes/config.php");
include("header.php");
include("includes/log_permission_delete_header.php");

if($_SESSION['admin_type']=="0" || in_array("leave_type.php", $permissions_record_delete) ){
include("log_delete_header.php");
$ltid=$_GET['id'];
$query="delete from leavetype where lt_id='$ltid'";
$result=mysql_query($query);
if($result)
{
	header("location:leave_type.php?msg=dsucc");
}
else
{
	header("location:leave_type.php?msg=err");
}
}
else
{
	header("location:leave_type.php");
}

?>

