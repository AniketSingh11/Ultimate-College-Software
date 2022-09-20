<? ob_start(); ?>
<?php 
include("../includes/config.php");

$date = date_default_timezone_set('Asia/Chennai');

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




 //// ----------------------- User Permission ---------------------------------
                            $monthno=date("m");
				 			$qry12=mysql_query("SELECT * FROM month WHERE m_no=$monthno AND ay_id=$acyear");
							$monthsw=mysql_fetch_array($qry12);
							if($_SESSION['admin_type']=="1")
							{
								
							$query1="select * from  subadmin_accesspage where subadmin_id='$_SESSION[u_id]' and log_type='admin'";
							$res1=mysql_query($query1);
							
							
							$permissions_record_delete=array();
							while($row1=mysql_fetch_array($res1))
							{
							    if($row1["record_del_page"]!=""){
							        $pagefield=explode(",",$row1["record_del_page"]);
									
							        foreach($pagefield as $val)
							        {
							            array_push($permissions_record_delete,$val);
										
							        }
							       							
							    }						   
							}
							}
							
														
							if($_SESSION['log_type']=="staff")
							{
								
							    $query1="select * from  subadmin_accesspage where log_type='$_SESSION[log_type]' and subadmin_id='$_SESSION[stid]'";
								
							    $res1=mysql_query($query1);							  
							    $permissions_record_delete=array();
								while($row1=mysql_fetch_array($res1))
								{
									if($row1["record_del_page"]!=""){
										$pagefield=explode(",",$row1["record_del_page"]);
										
										foreach($pagefield as $val)
										{
											array_push($permissions_record_delete,$val);
											
										}
																
									}						   
								}
							}
							
							
							
							if($_SESSION['log_type']=="others")
							{
								
								
							    $query1="select * from  subadmin_accesspage where log_type='$_SESSION[log_type]' and subadmin_id='$_SESSION[stid]'";
							    $res1=mysql_query($query1);
							    $permissions_record_delete=array();
								while($row1=mysql_fetch_array($res1))
								{
									if($row1["record_del_page"]!=""){
										$pagefield=explode(",",$row1["record_del_page"]);
										
										foreach($pagefield as $val)
										{
											array_push($permissions_record_delete,$val);
											
										}
																
									}						   
								}
							}
						   //// ----------------------- End User Permission ---------------------------------
?>
<? ob_flush(); ?>