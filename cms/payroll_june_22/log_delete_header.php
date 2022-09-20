<?php 
include("../includes/config.php");
$date = date_default_timezone_set('Asia/Kolkata');
session_start();

$check=$_SESSION['email'];

$user=$_SESSION['uname'];

$log_type=$_SESSION['log_type'];
if($log_type=='admin'){
$adminid=$_SESSION['u_id'];
}else{
	$adminid=$_SESSION['stid'];
}

if($log_type=="staff")
{
    $query=mysql_query("select email,staff_id,fname from staff where email='$check' ");
    $data=mysql_fetch_array($query);
    $email=$data['email'];
    $staff_id=$data['staff_id'];
    $user=$_SESSION['uname'];
    $stid=$_SESSION['stid'];
	$_SESSION['admin_type']="1";
}

/*$query=mysql_query("select email,id,roll from admin_login where email='$check' ");
$data=mysql_fetch_array($query);

$email=$data['email'];
$adminid=$data['id'];
$roll=$data['roll'];
*/
$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$syear=$ay['s_year'];
$eyear=$ay['e_year'];


if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($check))
{	
header("Location:404.php");
die;
}

function IND_money_format($money){
    $len = strlen($money);
    $m = '';
    $money = strrev($money);
    for($i=0;$i<$len;$i++){
        if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
            $m .=',';
        }
        $m .=$money[$i];
    }
    return strrev($m);
}


$ipaddress = $_SERVER['REMOTE_ADDR'];
//echo $user.'-'.$log_type.'-'.$adminid.'-'.$ipaddress;
$filename=basename($_SERVER["SCRIPT_FILENAME"], '<br>');

$timezone = new DateTimeZone("Asia/Kolkata" );
		$date = new DateTime();
		$date->setTimezone($timezone );
		$currentdate=$date->format( 'd-m-Y h:i:s A' );
		
	$sql=mysql_query("INSERT INTO log_delete (emp_id,emp_type,username,file_name,ip_address,date) VALUES
('$adminid','$log_type','$user','$filename','$ipaddress','$currentdate')");

/******************************LOG SUMMARY *******************************************/
		$logid=$_SESSION['log_id'];
		$timezone = new DateTimeZone("Asia/Kolkata" );
		$date = new DateTime();
		$date->setTimezone($timezone );
		$currentdate=$date->format( 'd-m-Y h:i:s A' );
		
		$path=$_SERVER["SCRIPT_FILENAME"];
		$sql=mysql_query("INSERT INTO log_access_summary(log_id,emp_id,emp_type,username,path,filename,ip_address,date) VALUES
		('$logid','$adminid','$log_type','$user','$path','$filename','$ipaddress','$currentdate')");
?>