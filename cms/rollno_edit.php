<?php 
include ("includes/config.php");

$ss_id=$_GET['ss_id'];
$ay_id=$_GET['ay_id'];
$roll_no=$_GET['roll'];
	$sql=mysql_query("UPDATE student SET roll_no='$roll_no' WHERE ss_id='$ss_id' AND ay_id='$ay_id'") or die(mysql_error());
echo "Success....!";
?>