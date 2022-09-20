<?php
require("includes/config.php");
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=student-result.csv");
header("Pragma: no-cache");
header("Expires: 0");

	 $cid=mysql_real_escape_string($_GET['cid']);
	 $sid=mysql_real_escape_string($_GET['sid']);
	  $bid=mysql_real_escape_string($_GET['bid']);
	  $ayid=mysql_real_escape_string($_GET['ayid']);
	 
$sql = "SELECT * FROM student where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'";
$query = mysql_query($sql);
//die();
$content = '';
$title = '';
$count=1;
while($rs = mysql_fetch_array($query)) { 
	$content .= stripslashes($count). ',';
	$content .= stripslashes($rs["ss_id"]). ',';
	$content .= stripslashes($rs["admission_number"]). ',';
	$content .= stripslashes($rs["firstname"]." ".$rs["middlename"]." ".$rs["lastname"]). ',';
	$content .= "\n";
	$count++;	
}
$title .= "s.no,ssid,Admin No,student Name,Mark,Result,Remark"."\n";
echo $title;
echo $content;
?>
