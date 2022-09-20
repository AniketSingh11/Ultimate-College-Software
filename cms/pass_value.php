<?php 
include("includes/config.php");
session_start();
$_SESSION['frate']['frid'] = $_POST['lang'];
$fdisid =$_POST['fdisid'];
$ssid1 =$_POST['ssid'];
$frid1=$_SESSION['frate']['frid'];

$fratelist=mysql_query("SELECT * FROM frate WHERE fr_id=$frid1");
									 $frate=mysql_fetch_array($fratelist);
					$ffgid=$frate['fg_id'];	 
$fgrouplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$ffgid");
									 $ffgroup=mysql_fetch_array($fgrouplist);
						$ftyid=$ffgroup['fty_id'];			 
						
$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
								  $ftype=mysql_fetch_array($ftypelist);
						$ftypevalue=$ftype['fty_value'];
		$_SESSION['frate']['ffrom'] = '1';
		$_SESSION['frate']['fto'] = $ftypevalue;		  						
$classlist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid1 AND fdis_id=$fdisid"); 
								  $class=mysql_fetch_array($classlist);
		$_SESSION['frate']['amount'] = $class['dis_value'];
//$msg="This fess already paied fully!!!";		
//$_SESSION['SESS_LANGUAGE'] = 'This is my PHP session var --->'.$_SESSION['SESS_LANGUAGE'];
//print json_encode(array('message' => $msg));
//die();
//header('Refresh: 1; url=index.php?id=1');
?>