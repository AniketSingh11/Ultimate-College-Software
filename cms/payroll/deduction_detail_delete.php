<? ob_start(); ?>
<?php 
include("header.php");
$sdid=$_GET['sdid'];
$id=$_GET['id'];
$query="delete from staff_ded_detail where id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:deduction_detail.php?id=$sdid&msg=dsucc");
}
else
{
	header("location:deduction_detail.php?id=$sdid&msg=err");
}

?>
<? ob_flush(); ?>