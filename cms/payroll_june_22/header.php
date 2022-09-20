<? ob_start(); ?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../includes/config.php"); 

session_start();

$date = date_default_timezone_set('Asia/Kolkata');

$check=$_SESSION['email'];

$query=mysql_query("select email,id from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$adminid=$data['id'];
$user=$_SESSION['uname'];

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
        header("Location:../timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($check))

{
	
header("Location:../404.php");

}
//include("../checking_page/payroll.php");
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<title>Payroll Management System </title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="">
	<meta name="author" content="" />
	
	<link rel="stylesheet" href="css/googlefont/css.css" type="text/css">

	<link rel="stylesheet" href="./css/font-awesome.min.css" type="text/css" />		
	<link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css" />	
	<link rel="stylesheet" href="./js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.css" type="text/css" />
		
	<link rel="stylesheet" href="./js/plugins/icheck/skins/minimal/blue.css" type="text/css" />
	<link rel="stylesheet" href="./js/plugins/datepicker/datepicker.css" type="text/css" />
	<link rel="stylesheet" href="./js/plugins/select2/select2.css" type="text/css" />
	<link rel="stylesheet" href="./js/plugins/simplecolorpicker/jquery.simplecolorpicker.css" type="text/css" />
	<link rel="stylesheet" href="./js/plugins/timepicker/bootstrap-timepicker.css" type="text/css" />
	<link rel="stylesheet" href="./js/plugins/fileupload/bootstrap-fileupload.css" type="text/css" />
	
	<link rel="stylesheet" href="./css/App.css" type="text/css" />

	<link rel="stylesheet" href="./css/custom.css" type="text/css" />