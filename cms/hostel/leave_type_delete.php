<?php 
include("header.php");
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

?>

