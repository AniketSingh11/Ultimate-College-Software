<?php 
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);
session_start();

$check=$_SESSION['email'];

$query=mysql_query("select email from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$user=$_SESSION['uname'];
$sacyear=$_SESSION['acyear'];
if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

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
							$yearlist=mysql_query("SELECT * FROM year WHERE ay_id=$sacyear"); 
								  $ayear=mysql_fetch_array($yearlist);	
								  
								  $acyear_name=$ayear['s_year']."-".substr($ayear['e_year'],-2);
?>
<?php include 'print_header.php';?>
 <link rel="stylesheet" href="css/idcard.css"> 
<style type="text/css">
/*.profile-table td{
	 border:1px solid #2D2D2D;
	 padding-left:10px;
}
.small{font-size:10px;}
.bgcolor{background-color:#D0D0D0;}
.column {
float: left;
    margin: 20px;
    padding-bottom: 1000px;
    margin-bottom: -1000px;
}*/
</style>    
</head>
<div style="position:absolute;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<body id="printablediv" onload="hide_button();">
<?php 
$count=1;
		$sql = "SELECT * FROM driver where status='1'";
$query = mysql_query($sql);
	while($rs = mysql_fetch_assoc($query)) { 
	
	$fathername=str_replace("."," ",$rs['fathersname']);
	$gradename=$rs['d_type'];
			
		$studentname=$rs['fname']." ".$rs['lname'];
		if($count%4==1){
			echo '<div class="container">';		
		?>
        <div class="column-left">
   		<div class="header">
        </div>
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">DRIVER ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/driver/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['driver_id'];?>"/>
        </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail">: <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?> <?php echo $rs['fname']." ".$rs['lname'];?></div></li>
                    <li><div class="title">Driver Id</div><div class="detail">: <?php echo $rs['driver_id'];?></div></li>
                     <li><div class="title">Position</div><div class="detail" <?php if(strlen($rs['position'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['position'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <!--<li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>-->
                    <li><div class="title">Father</div><div class="detail" <?php if(strlen($rs['d_pname'])>20 && strlen($rs['d_pname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['d_pname'])>23 && strlen($rs['d_pname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['d_pname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($rs['d_pname']));?></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Address</div><div class="detail">: <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address']));?></span></div></li>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_number'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_no'];?></div></li>
                   
                </ul>
            </div>
           </div> 
        <div class="footer">
        </div>
   </div>
   <?php }else if($count%4==2){?>
        <div class="column-center">
   		<div class="header">
        </div>
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">DRIVER ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/driver/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['driver_id'];?>"/>
        </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail">: <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?> <?php echo $rs['fname']." ".$rs['lname'];?></div></li>
                    <li><div class="title">Driver Id</div><div class="detail">: <?php echo $rs['driver_id'];?></div></li>
                     <li><div class="title">Position</div><div class="detail" <?php if(strlen($rs['position'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['position'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <!--<li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>-->
                    <li><div class="title">Father</div><div class="detail" <?php if(strlen($rs['d_pname'])>20 && strlen($rs['d_pname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['d_pname'])>23 && strlen($rs['d_pname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['d_pname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($rs['d_pname']));?></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Address</div><div class="detail">: <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address']));?></span></div></li>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_number'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_no'];?></div></li>
                   
                </ul>
            </div>
           </div> 
        <div class="footer">
        </div>
   </div>
   <?php }else if($count%4==3){?>
   <div class="column-right">
   		<div class="header">
        </div>
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">DRIVER ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/driver/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['driver_id'];?>"/>
        </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail">: <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?> <?php echo $rs['fname']." ".$rs['lname'];?></div></li>
                    <li><div class="title">Driver Id</div><div class="detail">: <?php echo $rs['driver_id'];?></div></li>
                     <li><div class="title">Position</div><div class="detail" <?php if(strlen($rs['position'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['position'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <!--<li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>-->
                    <li><div class="title">Father</div><div class="detail" <?php if(strlen($rs['d_pname'])>20 && strlen($rs['d_pname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['d_pname'])>23 && strlen($rs['d_pname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['d_pname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($rs['d_pname']));?></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Address</div><div class="detail">: <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address']));?></span></div></li>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_number'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_no'];?></div></li>
                   
                </ul>
            </div>
           </div> 
        <div class="footer">
        </div>
   </div>
   <?php }else if($count%4==0){?>
   <div class="column-right">
   		<div class="header">
        </div>
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">DRIVER ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/driver/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['driver_id'];?>"/>
        </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail">: <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?> <?php echo $rs['fname']." ".$rs['lname'];?></div></li>
                    <li><div class="title">Driver Id</div><div class="detail">: <?php echo $rs['driver_id'];?></div></li>
                     <li><div class="title">Position</div><div class="detail" <?php if(strlen($rs['position'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['position'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <!--<li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>-->
                    <li><div class="title">Father</div><div class="detail" <?php if(strlen($rs['d_pname'])>20 && strlen($rs['d_pname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['d_pname'])>23 && strlen($rs['d_pname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['d_pname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($rs['d_pname']));?></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Address</div><div class="detail">: <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address']));?></span></div></li>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_number'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_no'];?></div></li>
                   
                </ul>
            </div>
           </div> 
        <div class="footer">
        </div>
   </div>
        <?php
   }
		if($count%4==0){
			echo '</div> <div class="clearfix"></div>';		
		}
		
	$count++;
	}?>
</div>
</body>
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
</html>