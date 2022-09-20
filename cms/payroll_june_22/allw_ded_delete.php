<?php 
include("header.php");
$nid=$_GET['id'];
		$emp_query=mysql_query("select * from staff_allw_ded where id='$nid'");	
		$emp_display=mysql_fetch_array($emp_query);
		$type=$emp_display["type"];	
		$per_cent=$emp_display["per_cent"];	
		if($type=="Allowance"){
			$basiclist=mysql_query("select * from staff_allw_ded where basic='1' ");
			$basic=mysql_fetch_array($basiclist);
			$basic_percent=$basic['per_cent'];
			echo $total_percent=$basic_percent+$per_cent;
			$query=mysql_query("update staff_allw_ded set per_cent='$total_percent' where basic='1'");
		}	
						 
$query="delete from staff_allw_ded where id='$nid'";
$result=mysql_query($query);
if($result)
{
	header("location:allw_ded_list.php?msg=dsucc");
}
else
{
	header("location:allw_ded_list.php?msg=err");
}

?>

