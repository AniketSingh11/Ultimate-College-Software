<? ob_start(); ?>
<?php

include("includes/config.php");
session_start();

$check=$_SESSION['email'];
$query=mysql_query("select email,id from admin_login where email='$check' ");
$data=mysql_fetch_array($query);



//$email=$data['email'];
//$adminid=$data['id'];
//$user=$_SESSION['uname'];

	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);


$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

/*if(!isset($email))
{	
header("Location:404.php");
}
*/


echo "<option value=''>Select Class Select</option> " ;
if(isset( $_GET['mmtid']) ) 
{
    $catParent = $_GET['mmtid'];
  $query = "SELECT * FROM class WHERE b_id = '".$catParent."' AND ay_id='$acyear'"; 
  $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) 
    {
           echo"<option  value =".$row['c_id'].">".$row['c_name']."</option>";
    }
}
?>
<? ob_flush(); ?>