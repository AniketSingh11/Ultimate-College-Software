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
$emp_result=mysql_query("select * from staff_month_salary where month=$m AND year=$y_value AND st_ms_id=$id");
$emp_display=mysql_fetch_array($emp_result);
  $lpid=$emp_display["lp_id"];	
			$stid=$emp_display["st_id"];
			$oid=$emp_display["o_id"];
			$did=$emp_display["d_id"];
			$aid=$emp_display["a_id"];
	if($lpid){
		$loanlist=mysql_query("SELECT * FROM staff_loan_pay WHERE lp_id=$lpid"); 
								  $loan=mysql_fetch_array($loanlist);
		$lid=$loan['l_id'];
		$query=mysql_query("update staff_loan set status='0' where l_id='$lid'");			  
		
		$query=mysql_query("delete from staff_loan_pay where lp_id='$lpid'");
	}
	if($aid){
		$reportlist=explode(",",$aid);
		
				foreach($reportlist as $val)
				{
					$query=mysql_query("update staff_advance set status='0',st_ms_id='0' where a_id='$val'");
				}
	}
$query=mysql_query("delete from staff_month_salary_summary where st_ms_id='$id'");

$query="delete from staff_month_salary where st_ms_id='$id'";
$result=mysql_query($query);
if($result)
{
	header("location:monthly_salary.php?m=$m&syear=$syear&eyear=$eyear&msg=dsucc");
}
else
{
	header("location:monthly_salary.php?m=$m&syear=$syear&eyear=$eyear&msg=err");
}
?>

