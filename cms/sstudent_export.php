<?php
require("includes/config.php");
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=student-list.csv");
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
	$content .= stripslashes($rs["firstname"]). ',';
	$content .= stripslashes($rs["middlename"]). ',';
	$content .= stripslashes($rs["lastname"]). ',';
	$content .= stripslashes($rs["fathersname"]). ',';
	$content .= stripslashes($rs["fathersocupation"]). ',';
	$content .= stripslashes($rs["from_school"]). ',';
	$content .= stripslashes($rs["eslc"]). ',';
	$content .= stripslashes($rs["tc"]). ',';
	$content .= stripslashes($rs["doa"]). ',';
	$content .= stripslashes($rs["dob"]). ',';
	$content .= stripslashes($rs["gender"]). ',';
	$content .= stripslashes($rs["protected"]). ',';
	$content .= stripslashes($rs["nation"]). ',';
	$content .= stripslashes($rs["reg"]). ',';
	$content .= stripslashes($rs["caste"]). ',';
	$content .= stripslashes($rs["sub_caste"]). ',';
	$content .= stripslashes($rs["blood"]). ',';
	$content .= stripslashes($rs["email"]). ',';
	$content .= stripslashes($rs["phone_number"]). ',';
	$content .= stripslashes($rs["address1"]). ',';
	$content .= stripslashes($rs["address2"]). ',';
	$content .= stripslashes($rs["city_id"]). ',';
	$content .= stripslashes($rs["country"]). ',';
	$content .= stripslashes($rs["pin"]). ',';
	$content .= stripslashes($rs["mother_tongue"]). ',';
	$content .= stripslashes($rs["std_leaving"]). ',';
	$content .= stripslashes($rs["no_date_tran"]). ',';
	$content .= stripslashes($rs["dol"]). ',';
	$content .= stripslashes($rs["reason_leaving"]). ',';
	$content .= stripslashes($rs["school_pubil"]). ',';
	$content .= stripslashes($rs["remarks"]). ',';
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Admin No,First Name of Pupil,Middle Name of Pupil,Last Name of Pupil ,Name of Parent / Guardian,Occupation of Parent or Guardian,Standard & School from which pupil has come,Whether an ESLC issued by the Dept. was produced on admission,Whether a T.C. from a secondary school was produced on admission,Date of admission,Date Of Birth,Gender,Whether protected from small-pox or not,Nationality & state to which the pupil belongs,Religion,Caste,Subcaste,Blood Group,Email,Phone,Residence Address1,Residence Address2,Town or village Name,Country ,Pin Code,Mother Tongue of the Pubil,Std. on leaving,No. & Date of Transfer Certificate produced ,Date of leaving,Reason for leaving,School to which the pubil has gone,Remarks"."\n";
echo $title;
echo $content;
?>
