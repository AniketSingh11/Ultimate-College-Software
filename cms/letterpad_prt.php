<?php 
include("includes/config.php");
$date = date_default_timezone_set('Asia/Kolkata');
session_start();

$check=$_SESSION['email'];

$user=$_SESSION['uname'];

$log_type=$_SESSION['log_type'];
$adminid=$_SESSION['u_id'];

if($log_type=="staff")
{
    $query=mysql_query("select email,staff_id,fname from staff where email='$check' ");
    $data=mysql_fetch_array($query);
    $email=$data['email'];
    $staff_id=$data['staff_id'];
    $user=$_SESSION['uname'];
    $stid=$_SESSION['stid'];
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
}
							$lid=$_GET['l_id'];
							$classlist=mysql_query("SELECT * FROM letter_pad WHERE l_id=$lid"); 
								  $class=mysql_fetch_array($classlist);	
								  $titles=$class["title"];
								  $description=stripslashes($class["description"]);
					
?>
<?php include 'print_header.php';?>
</head>
<body onLoad="window.print();">
<?php echo $description; ?>
</div>
</body>
</html>