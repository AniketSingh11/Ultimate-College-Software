<?php
require("includes/config.php");

$cid=mysql_real_escape_string($_GET['cid']);
	 $sid=mysql_real_escape_string($_GET['sid']);
	  $bid=mysql_real_escape_string($_GET['bid']);
	  $ayid=mysql_real_escape_string($_GET['ayid']);
	  $eid=mysql_real_escape_string($_GET['eid']);
	  $slist=0;  
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=Student-mark-report.csv");
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
		$studentlist=mysql_query("SELECT * FROM subject WHERE `c_id`='$cid' AND `s_id`='$sid' AND `ay_id`='$ayid'"); 
		$total=0;
		while($staff=mysql_fetch_array($studentlist)){
			$subid=$staff['sub_id'];
			$slid=$staff['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);	
			$paper=$slist['paper'];
			if($paper=='1'){
			$resultlist=mysql_query("SELECT * FROM result WHERE `sub_id`='$subid' AND `ss_id`='$ssid' AND `e_id`='$eid'"); 
								  $result=mysql_fetch_array($resultlist);
								   $mark=$result['mark'];
								 $mark1=$result['mark1'];
								 $tot=$mark+$mark1;
	$content .= stripslashes($mark." - ".$mark1." = ".$tot). ',';
		$total =$total + $tot;
			}else {
				$resultlist=mysql_query("SELECT * FROM result WHERE `sub_id`='$subid' AND `ss_id`='$ssid' AND `e_id`='$eid'"); 
								  $result=mysql_fetch_array($resultlist);
	$content .= stripslashes($result['mark']). ',';
		$total =$total + $result['mark'];				
			}
		}
	$content .= stripslashes($total). ',';	
	$content .= "\n";
	$count++;	
}
$title .= "s.no,Admin No,Student Name". ',';
if($slist){
$studentlist1=mysql_query("SELECT * FROM subject WHERE `c_id`='$cid' AND `s_id`='$sid' AND `ay_id`='$ayid'"); 
while($staff1=mysql_fetch_array($studentlist1)){
	$title .= stripslashes($slist['s_name']). ',';
}
}
$title .= "Total". ',';
$title .= "\n";
echo $title;
echo $content;
?>
