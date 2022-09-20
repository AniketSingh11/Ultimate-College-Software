<?php 
include ("includes/config.php");

$ssid=$_REQUEST["sid"];
$mode=$_REQUEST['mode'];
	$rid=0;
	if($mode=="School Van"){
		$rid=1;
	}
$spid=$_REQUEST["point"];
$busfeestype=$_REQUEST["bustype"];
	$stype=mysql_real_escape_string($_REQUEST['stype']);
	$fdis_id=mysql_real_escape_string($_REQUEST['category']);	
if($rid=="0" || $spid==null){
    $spid=0;
    $busfeestype=0;
}
 
if($busfeestype==""){
    $busfeestype=0;
}

$query = "SELECT * FROM trstopping WHERE status='1' AND stop_id=$spid"; 
  $result = mysql_query($query);
  $r_id=mysql_fetch_array($result)['r_id'];
  $root=mysql_query("select * from route where r_id=$r_id");
  $route=mysql_fetch_array($root)['r_name'];
  
$sql=mysql_query("UPDATE student SET r_id='$rid',sp_id='$spid',busfeestype='$busfeestype',stype='$stype',fdis_id='$fdis_id',mode='$mode',route='$route'  WHERE ss_id='$ssid'") or die(mysql_error());


?>