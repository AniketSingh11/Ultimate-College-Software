<?php 
include("header.php");
$ltid=$_GET['id'];
$query="delete from staff_loan_type where lt_id='$ltid'";
$result=mysql_query($query);
if($result)
{
	header("location:loan_type.php?msg=dsucc");
}
else
{
	header("location:loan_type.php?msg=err");
}

?>

