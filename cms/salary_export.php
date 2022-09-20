<?php
require("includes/config.php");

$mid=mysql_real_escape_string($_GET['mid']);
	  $ayid=mysql_real_escape_string($_GET['ayid']);
	  $month=mysql_real_escape_string($_GET['month']);
	  
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$month-salary-report.csv");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM salary where `m_id`='$mid' AND `ay_id`='$ayid'";
$query = mysql_query($sql);
//die();
$content = '';
$title = '';
$count=1;
while($rs = mysql_fetch_array($query)) { 
	
	$stid=$rs['st_id'];
								   $studentlist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								   $staff=mysql_fetch_array($studentlist);	
								   
	$content .= stripslashes($count). ',';
	$content .= stripslashes($staff['staff_id']). ',';
	$content .= stripslashes($staff['fname']." ".$staff['mname']." ".$staff['lname']). ',';
	$content .= stripslashes($staff['s_type']). ',';
	$content .= stripslashes($rs["amount"]). ',';
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Staff Id,Staff Name,Staff Type,Salary"."\n";
echo $title;
echo $content;
?>
