<?php
require("includes/config.php");
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=parent-list.csv");
header("Pragma: no-cache");
header("Expires: 0");

	 $cid=mysql_real_escape_string($_GET['cid']);
	 $sid=mysql_real_escape_string($_GET['sid']);
	  $bid=mysql_real_escape_string($_GET['bid']);
	  $ayid=mysql_real_escape_string($_GET['ay_id']);
	 
$sql = "SELECT * FROM student where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'";
$query = mysql_query($sql);
//die();
$content = '';
$title = '';
$count=1;
while($rs = mysql_fetch_array($query)) { 
	$content .= stripslashes($count). ',';
	$content .= stripslashes($rs["admission_number"]). ',';
	$content .= stripslashes($rs["firstname"]." ".$rs["middlename"]." ".$rs["lastname"]). ',';
	$content .= stripslashes($rs["fathersname"]). ',';
	$content .= stripslashes($rs["fathersocupation"]). ',';
	$content .= stripslashes($rs["email"]). ',';
	$content .= stripslashes($rs["phone_number"]). ',';
	$content .= stripslashes($rs["address1"]). ',';
	$content .= stripslashes($rs["address2"]). ',';
	$content .= stripslashes($rs["city_id"]). ',';
	$content .= stripslashes($rs["country"]). ',';
	$content .= stripslashes($rs["pin"]). ',';
	$content .= stripslashes($rs["mother_tongue"]). ',';
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Admin No,Student Name,Name of Parent,Occupation,Email,Phone,Residence Address1,Residence Address2,City,Country ,Pin Code,Mother Tongue"."\n";
echo $title;
echo $content;
?>
