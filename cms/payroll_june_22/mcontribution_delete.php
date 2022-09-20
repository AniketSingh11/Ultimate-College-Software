<? ob_start(); ?>
<?php 
include("header.php");
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

?>
<? ob_flush(); ?>