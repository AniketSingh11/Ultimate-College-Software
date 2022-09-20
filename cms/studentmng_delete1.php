<? ob_start(); ?>
<?php
include("includes/config.php");

$cid = $_GET['cid'];
$ssid = $_GET['ssid'];
$bid = $_GET['bid'];

$studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
$row=mysql_fetch_array($studentlist);
 $pid=$row['p_id'];
								  if(!$pid){
									  $parentlist=mysql_query("SELECT * FROM sibling WHERE ss_id=$ssid"); 
								  	  $parent=mysql_fetch_array($parentlist);
									  $pid=$parent['p_id'];
								  }
								  if(!$pid){
									  $parentlist=mysql_query("SELECT * FROM parent WHERE ss_id=$ssid"); 
								  	  $parent=mysql_fetch_array($parentlist);
									  $pid=$parent['p_id'];									  
								  }	

$parentlist=mysql_query("SELECT * FROM parent WHERE p_id=$pid"); 
$parent=mysql_fetch_array($parentlist);
$sibling=$parent['sibling'];

 $delete="Delete from student where ss_id='$ssid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
	if($sibling=='1'){
		$delete1=mysql_query("Delete from sibling where ss_id='$ssid' AND p_id='$pid'");
		
		$siblinglist=mysql_query("SELECT * FROM sibling WHERE p_id=$pid"); 
		$sno=mysql_num_rows($siblinglist);
		$sibling1=mysql_fetch_array($siblinglist);
		$ssid1=$sibling1['ss_id'];
		
		$studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid1"); 
		$student1=mysql_fetch_array($studentlist1);
		
		$cid1=$student1['c_id'];
		$sid1=$student1['s_id'];
		$admin_no1=$student1['admission_number'];
		$bid1=$student1['b_id'];
		
		
		if($sno<2){			
			 $sql1=mysql_query("UPDATE parent SET c_id='$cid1',s_id='$sid1',admin_no='$admin_no1',b_id='$bid',sibling='0' WHERE p_id='$pid'");
		}else{
			 $sql1=mysql_query("UPDATE parent SET c_id='$cid1',s_id='$sid1',admin_no='$admin_no1',b_id='$bid' WHERE p_id='$pid'");
		}			
		
	}else{
	$delete1=mysql_query("Delete from parent where ss_id='$ssid'");
	}
header("Location:admission_imp.php?cid=$cid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>