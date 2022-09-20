<?php 
include("header.php");
$id=$_GET['id'];
$m=$_GET['m'];
$syear=$_GET['syear'];
$eyear=$_GET['eyear'];
if($m>5){
	$y_value=$syear;
}else if($m<=5){
	$y_value=$eyear;
}

$query="delete from staff_daily_salary where st_ms_id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:daily_salary.php?m=$m&syear=$syear&eyear=$eyear&msg=dsucc");
}
else
{
	header("location:daily_salary.php?m=$m&syear=$syear&eyear=$eyear&msg=err");
}
?>

