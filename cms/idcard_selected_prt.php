<?php 
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);

session_start();

$check=$_SESSION['email'];

$query=mysql_query("select email from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$user=$_SESSION['uname'];

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

	 $cid=mysql_real_escape_string($_GET['cid']);
	 $sid=mysql_real_escape_string($_GET['sid']);
	  $bid=mysql_real_escape_string($_GET['bid']);
	  $ayid=mysql_real_escape_string($_GET['ayid']);
	  
	  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
							$yearlist=mysql_query("SELECT * FROM year WHERE ay_id=$ayid"); 
								  $ayear=mysql_fetch_array($yearlist);	
					
?>
<?php include 'print_header.php';?>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="js/jquery.js"></script>
 <link rel="stylesheet" href="css/idcard.css">
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

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  <table width="950" border="0" cellpadding="0" cellspacing="0" id="Table_01" style="font-family:ubuntu-condensed">
    <tbody>
    <?php
	$count=1;
	foreach ($_GET['ms_example'] as $selectedOption)
    { 
		$drid=$selectedOption;
			  $qry=mysql_query("SELECT * FROM student WHERE `ss_id`='$drid' AND `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'");
	 		  $rs = mysql_fetch_array($qry); 
			   
	
	$fathername=str_replace("."," ",$rs['fathersname']);
	
		$string=$class['c_name'];
			$gradename=$class['c_name']." - ".$section['s_name'];
			$spid=$rs['sp_id'];
			
			if($spid){
					 $qry6=mysql_query("SELECT stop_name FROM trstopping WHERE stop_id='$spid'"); 
								  $row6=mysql_fetch_array($qry6);
								  $stopname=$row6['stop_name'];
			}
			if(!$stopname){
				$stopname=" - ";
			}
		$studentname=$rs['firstname']." ".$rs['lastname'];
		if($count%4==1){
			echo '<div class="container">';		
		?>
        <div class="column-left">
   		<div class="header">
        </div>
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">PARENT ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/student/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['admission_number'];?>"/>
            </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail" <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?>>: <?php echo $rs['firstname']." ".$rs['lastname'];?></div></li>
                	<li><div class="title">Std & Sec</div><div class="detail">: <?php echo $gradename;?></div></li>
                    <li><div class="title">Admin No</div><div class="detail">: <?php echo $rs['admission_number'];?></div></li>
                    <li><div class="title">Parent</div><div class="detail" <?php if(strlen($rs['fathersname'])>20 && strlen($rs['fathersname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['fathersname'])>23 && strlen($rs['fathersname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['fathersname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($fathername));?></div></li>
                    <li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <li><div class="title">Address</div><div class="detail"> <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address1']));?></span></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_number'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_number'];?></div></li>
                    <li><div class="title">Bus St</div><div class="detail" <?php if(strlen($stopname)>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $stopname;?></div></li>
                    
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
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">PARENT ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/student/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['admission_number'];?>"/>
            </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail" <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?>>: <?php echo $rs['firstname']." ".$rs['lastname'];?></div></li>
                	<li><div class="title">Std & Sec</div><div class="detail">: <?php echo $gradename;?></div></li>
                    <li><div class="title">Admin No</div><div class="detail">: <?php echo $rs['admission_number'];?></div></li>
                    <li><div class="title">Parent</div><div class="detail" <?php if(strlen($rs['fathersname'])>20 && strlen($rs['fathersname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['fathersname'])>23 && strlen($rs['fathersname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['fathersname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($fathername));?></div></li>
                    <li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <li><div class="title">Address</div><div class="detail"> <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address1']));?></span></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_number'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_number'];?></div></li>
                    <li><div class="title">Bus St</div><div class="detail" <?php if(strlen($stopname)>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $stopname;?></div></li>
                    
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
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">PARENT ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/student/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['admission_number'];?>"/>
            </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail" <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?>>: <?php echo $rs['firstname']." ".$rs['lastname'];?></div></li>
                	<li><div class="title">Std & Sec</div><div class="detail">: <?php echo $gradename;?></div></li>
                    <li><div class="title">Admin No</div><div class="detail">: <?php echo $rs['admission_number'];?></div></li>
                    <li><div class="title">Parent</div><div class="detail" <?php if(strlen($rs['fathersname'])>20 && strlen($rs['fathersname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['fathersname'])>23 && strlen($rs['fathersname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['fathersname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($fathername));?></div></li>
                    <li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <li><div class="title">Address</div><div class="detail"> <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address1']));?></span></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_number'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_number'];?></div></li>
                    <li><div class="title">Bus St</div><div class="detail" <?php if(strlen($stopname)>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $stopname;?></div></li>
                    
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
        <div style="text-align:center; color:#022FFF"><span style="font-size:10px;">PARENT ID CARD :</span> <?php echo $acyear_name;?></div>
        <div style="text-align:center">
            <img src="img/student/<?php echo $rs['photo']; ?>" width="80px" height="80px" style="padding-left:5px;" alt="<?php echo $rs['admission_number'];?>"/>
            </div>
        <div class="body-content">
        	<div class="bcolumn-left">
            	<ul class="titlelist">
                	<li><div class="title">Name</div><div class="detail" <?php if(strlen($studentname)>20 && strlen($studentname)<=23){ echo 'style="font-size:11px"'; }else if(strlen($studentname)>23 && strlen($studentname)<=26){ echo 'style="font-size:10px"'; }else if(strlen($studentname)>26){ echo 'style="font-size:9.9px"'; } ?>>: <?php echo $rs['firstname']." ".$rs['lastname'];?></div></li>
                	<li><div class="title">Std & Sec</div><div class="detail">: <?php echo $gradename;?></div></li>
                    <li><div class="title">Admin No</div><div class="detail">: <?php echo $rs['admission_number'];?></div></li>
                    <li><div class="title">Parent</div><div class="detail" <?php if(strlen($rs['fathersname'])>20 && strlen($rs['fathersname'])<=23){ echo 'style="font-size:13px;"'; }else if(strlen($rs['fathersname'])>23 && strlen($rs['fathersname'])<=26){ echo 'style="font-size:12px;"'; }else if(strlen($rs['fathersname'])>26){ echo 'style="font-size:10.9px;"'; }else{ echo 'style=""';}?>>: <?php echo  ucwords(strtolower($fathername));?></div></li>
                    <li><div class="title">DOB</div><div class="detail">: <?php echo $rs['dob'];?></div></li>
                    <li><div class="title">Blood</div><div class="detail">: <?php echo $rs['blood'];?></div></li>
                    <li><div class="title">Address</div><div class="detail"> <span style="font-size:10px;text-transform: capitalize !important;"><?php echo ucwords(strtolower($rs['address1']));?></span></div></li>
                    <div class="clearfix"></div>
                    <li><div class="title">Contact</div><div class="detail" <?php if(strlen($rs['phone_number'])>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $rs['phone_number'];?></div></li>
                    <li><div class="title">Bus St</div><div class="detail" <?php if(strlen($stopname)>19){ echo 'style="font-size:12px"'; }?>>: <?php echo $stopname;?></div></li>
                    
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
	} ?>
  </tbody></table>
  <p>
    <!-- End ImageReady Slices -->
  </p>
 
  <p>&nbsp;    </p>
</div>

</body></html>