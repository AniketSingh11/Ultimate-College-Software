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
							$contid=$_GET['contid'];
							$conduct=mysql_query("SELECT * FROM conduct WHERE con_id=$contid"); 
							$row=mysql_fetch_array($conduct);
					
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
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="margin-top:2%;">
<div style="float:right;" id="print"> 
<b style="color:red;"><input  type="checkbox" <?php if($_GET['show']=="hide"){?>checked="checked" <?php }?> name="show" id="show" value="full">Without Background</b>
<a onclick="hide_button();"  title="Print this certificate">
<img src="img/printer.png" style="margin-top:-30%; margin-bottom:-20%;"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<style type="text/css">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-360px;
	height:400px;
	margin-left:-960px !important;
   
  }
</style>
 <?php if($_GET['show']!="hide"){?>
  <div style="width:236mm; margin:0px; height:40.1mm; min-height:40.1mm; border-bottom:2px solid #01a8ff; padding-bottom:20px; display:inline-block;" id="Table_01">
                            <div style="text-align:left; width:50.00mm; float:left;">
                                <div><img src="img/logo1.png" width="160px" height="160px"></div>
                            </div>
                            <div style="text-align:center;width:185.75mm; float:left; padding-top:25px;">
                                <h5 style="padding:0px; padding-bottom:3px; margin:0px; letter-spacing:2px; color:red; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:46px; ; font-weight:bold;">SCHOOL/COLLEGE MANAGEMENT SYSTEM</h5>

                                <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Hetauda, Nepal</h5>
                               <!-- <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-size:16px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Contact : 044-32429897, 26790694, Email : christischool@gmail.com, Web: www.christschool.co.in</h5>-->
                            </div>
                        </div>
 <!--<table width="900" height="24" border="0" cellpadding="0" cellspacing="0" id="Table_01" style="margin-left:5%; line-height:40px;">
    <tbody><tr id="butt" style="visibility: visible; line-height:40px; min-height:150px;">
      <td><img src="img/images1.png" style="width:130px; height:110px;" /></td>     
      <td>
      <h2 style="text-align:center; padding:0px; margin:0px; color:red; font-size:2em;">SP MODERN SCHOOL</h2>
      <h5 style="text-align:center; padding:0px; margin:0px; line-height:21px; color:#017CBE; font-size:1em;">(Government Recognized &An ISO 9001:2008 Certified institution)</h5>
      <h4 style="text-align:center; padding:0px; margin:0px; font-size:14px; color:#5D5E60; font-size:16px;">SEVALPATTI, VIRUTHUNAGAR (DT)-626140</h4>
      </td>
      <td><img src="img/images2.png" style="height:70px;" /></td>
    </tr>
  </tbody>
     <table align="left" style="border-bottom:2px solid lightblue; margin-top:-18px; font-size:20px; margin-left:5%; width:94%;">
  <tr>
  <td>
        <span style="margin-left:38%; height:22px;"><img src="img/phone.jpg" />:04562-239111</span><br>
      <span style="margin-left:18%; height:19px;"><img src="img/mail.jpg" />:www.spmodernschool.edu.in:contact@spmodernschool.edu.in</span><br>
      <span style="margin-left:18%; height:21px;"><img src="img/fb.jpg" />:www.facebook.com/page/spmodernschoolsevalpatti</span>

  </td>
  </tr>
  </table>
</table>-->
<?php }?>

  <?php 
	$contid=$_GET['contid'];
							$conduct=mysql_query("SELECT * FROM conduct WHERE con_id=$contid"); 
							$row=mysql_fetch_array($conduct);
					
  ?>
<div style="max-height:500px;">
 <div style="width:100%; float:left; line-height:36px;">
<div style="float:left; width:50%; text-align:left; margin-left:5%; font-size:21px;"><?php echo "SPMS/COC/".$acyear_name."/".$row['ref_number']; ?></div>
<div style="float:left; width:40%; text-align:right; margin-right:3%; font-size:21px;">Date: <?=$row['c_date']?></div>
</div>

<h2 style="line-height:46px; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:30px;">CONDUCT CERTIFICATE</h2>
<div style="margin-top:85px;width:866px;margin-left:4px; line-height:60px; text-align:justify;">
<font color="#2E2F65" style="font-size:28px;">This is to certify that <b><?php echo $row['name']." (".$row['admin_no'].")"; ?></b> is /was a bonafide 

student of our institution studying in standard <b> <?php echo $row['standard']; ?></b> during the academic year <b> <?php echo $row['year']; ?> </b>His/Her character and conduct are <b> <?php echo $row['character1']; ?></b> and His/Her Date of birth as per our school record is <b> <?php echo $row['dob']; ?> </b>.
</font></div>
<div class="Invitation">
   <?php if($_GET['show']!="hide"){?>
   <!--  <img src="img/bona.png" alt="" class="adjusted"> 
   -->
   <?php }?>
</div>

</div>

<div style="width:100%; float:right; text-align:right; margin-right:5%; margin-top:3%;">
<h2 style="font-size:1.8em;">Principal</h2>
</div>

<p>
    <!-- End ImageReady Slices -->
  </p>
 
  <p>&nbsp;    </p>
</div>
 <script>
$().ready(function() {

	$("#show").change(function(){
		if(this.checked) {
	 
		window.location.href='conduct_prt.php?contid=<?=$contid?>&show=hide';
		}else{
			window.location.href='conduct_prt.php?contid=<?=$contid?>&show=show';
		}
	
	});	
});
 	 
</script>
</body></html>