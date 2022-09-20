<?php 
include("includes/config.php");
error_reporting(0);

session_start();

$check=$_SESSION['email'];

$query=mysql_query("select email from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$user=$_SESSION['uname'];

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_assoc($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_assoc($ayear);
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

if(!isset($email))

{
	
header("Location:404.php");

}

$bid=mysql_real_escape_string($_GET['bid']);
	  $ayid=mysql_real_escape_string($_GET['ayid']);
	  $type=mysql_real_escape_string($_GET['type']);
	 $roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1]; 
					$eid=$_GET['eid']; 

					//die();
					
					$studentlist=mysql_query("SELECT * FROM staff WHERE staff_id LIKE '$rollno' "); 
								  $rs=mysql_fetch_array($studentlist);
								  
								  $stid=$rs['st_id'];
								  
								  $acyear_name=$ay['s_year']."-".substr($ay['e_year'],-2);
								  
								   
		
					
?>
<?php include 'print_header.php';?>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
     window.print();
     document.body.onmousemove = doneyet;
}
/*function download_doc(ano){
	
	var url = 'http://localhost/Erp_School/'+'admin/download_cert?id='+ano+'&type=bonafide';
	window.open(url,'_blank');
}
function doneyet()
{
  document.getElementById('butt').style.visibility='visible';
}*/
</script>
 <link rel="stylesheet" href="css/idcard.css">
<style type="text/css">
#print{
	position:absolute;
	}
  img.adjusted {
    position: absolute;
    z-index: -1;
  }
</style>
</head>

<div style="position:absolute;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<body id="printablediv" onload="hide_button();">
  <?php 
$count=1;
	
	$fathername=str_replace("."," ",$rs['fathersname']);
	$gradename=$rs['d_type'];
			
		$studentname=$rs['fname']." ".$rs['lname'];
			echo '<div class="container">';		
			if($type=='Front'){
		?>
        <div class="column-left">
   		<div class="header">
        </div>
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">STAFF ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/Staff/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['staff_id'];?>"/>
        </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail">: <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?> <?php echo $rs['fname']." ".$rs['lname'];?></div></li>
                    <li><div class="title">Staff Id</div><div class="detail">: <?php echo $rs['staff_id'];?></div></li>
                     <li><div class="title">Position</div><div class="detail" <?php if(strlen($rs['position'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['position'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <!--<li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>-->
                    <li><div class="title">Father</div><div class="detail" <?php if(strlen($rs['s_pname'])>20 && strlen($rs['s_pname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['s_pname'])>23 && strlen($rs['s_pname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['s_pname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($rs['s_pname']));?></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Address</div><div class="detail">: <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address1']));?></span></div></li>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_no'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_no'];?></div></li>
                   
                </ul>
            </div>
           </div>
        <div class="footer">
        </div>
   </div>
   <?php } ?>
</div>

</body></html>