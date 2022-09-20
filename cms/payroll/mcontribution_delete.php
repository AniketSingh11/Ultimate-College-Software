<? ob_start(); ?>
<?php 
include("../includes/config.php");
include("header.php");
include("includes/log_permission_delete_header.php"); 

if($_SESSION['admin_type']=="0" || in_array("leave_detail2.php", $permissions_record_delete) ){
include("log_delete_header.php");
$syear=$_GET['syear'];
$eyear=$_GET['eyear'];
$id=$_GET['id'];
$query="delete from staff_mcontribution where id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:mcontribution.php?syear=$syear&eyear=$eyear&msg=dsucc");
}
else
{
	header("location:mcontribution.php?syear=$syear&eyear=$eyear&msg=err");
}
}
else
{
	header("location:mcontribution.php?syear=$syear&eyear=$eyear");
}

?>
<? ob_flush(); ?>