<?php
require("includes/config.php");

$cid=mysql_real_escape_string($_GET['cid']);
	 $sid=mysql_real_escape_string($_GET['sid']);
	  $bid=mysql_real_escape_string($_GET['bid']);
	  $ayid=mysql_real_escape_string($_GET['ayid']);
	  $mid=mysql_real_escape_string($_GET['mid']);
	  
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=student-attendance.csv");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM student where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'";
$query = mysql_query($sql);
//die();
$content = '';
$title = '';
$count=1;
while($rs = mysql_fetch_array($query)) { 
	
	$ssid=$rs['ss_id'];   	
								   
	$content .= stripslashes($count). ',';
	$content .= stripslashes($rs["admission_number"]). ',';
	$content .= stripslashes($rs["firstname"]." ".$rs["middlename"]." ".$rs["lastname"]). ',';
		$studentlist=mysql_query("SELECT * FROM attendance WHERE `c_id`='$cid' AND `s_id`='$sid' AND `m_id`='$mid' AND `ay_id`='$ayid' AND `ss_id`='$ssid' ORDER BY day"); 
		$present=0;$absent=0;$absentoff=0;$workday=0;
		while($staff=mysql_fetch_array($studentlist)){
			$result1=$staff['result'];			
			if($result1=='1'){
		$content .= stripslashes("P"). ',';
		$present++;
			}else if($result1=='0'){
		$content .= stripslashes("A"). ',';
		$absent++;
		}else{
			$content .= stripslashes("Half"). ',';
			$absentoff++;
		}
		$workday++;
		//$total =$total + $result['mark'];
		}
		$op=$absentoff*.5;
		$persent=0;
		if($workday){
					$persent=round((($present+$op)/$workday)*100,2);
		}
	$content .= stripslashes($workday). ',';	
	$content .= stripslashes($present). ',';	
	$content .= stripslashes($absent). ',';	
	$content .= stripslashes($absentoff). ',';	
	$content .= stripslashes($persent). ',';	
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Admin No,Student Name". ',';
$studentlist1=mysql_query("SELECT distinct day FROM attendance WHERE `c_id`='$cid' AND `s_id`='$sid' AND `m_id`='$mid' AND `ay_id`='$ayid' ORDER BY day"); 
while($staff1=mysql_fetch_array($studentlist1)){
	$title .= stripslashes($staff1['day']). ',';
}
$title .= "Total Working day,Present,Absent,Halfday Absent,Percentage". ',';
$title .= "\n";
echo $title;
echo $content;
?>
