<?php 
include ("includes/config.php");

$stid=$_REQUEST["stid"];
$rid=$_REQUEST["rid"];
$spid=$_REQUEST["point"];
$busfeestype=$_REQUEST["bustype"];
	$stype=mysql_real_escape_string($_REQUEST['stype']);
	 	
if($rid=="0" || $spid==null){
    $spid=0;
    $busfeestype=0;
}
 
 

$sql=mysql_query("UPDATE staff SET r_id='$rid',sp_id='$spid',busfeestype='$busfeestype',s_type='$stype'  WHERE st_id='$stid'") or die(mysql_error());


?>