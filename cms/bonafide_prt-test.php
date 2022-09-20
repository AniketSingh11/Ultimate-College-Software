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
							$bid=$_GET['bid'];
							$bonafide=mysql_query("SELECT * FROM bonafide WHERE b_id=$bid"); 
							$row=mysql_fetch_array($bonafide);
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
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
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

  <table width="900" height="24" border="0" cellpadding="0" cellspacing="0" id="Table_01" style="margin-left:5%; line-height:40px;">
    <tbody><tr id="butt" style="visibility: visible; line-height:40px; min-height:150px;">
      <td><img src="img/images1.png" style="width:130px; height:110px;" /></td>     
      <td>
      <h2 style="text-align:center; padding:0px; margin:0px; color:red; font-size:2em;">SRI KRISH INTERNATIONAL SCHOOL</h2>
      <h5 style="text-align:center; padding:0px; margin:0px; line-height:21px; color:#017CBE; font-size:1em;">(Government Recognized &An ISO 9001:2008 Certified institution)</h5>
      <h4 style="text-align:center; padding:0px; margin:0px; font-size:14px; color:#5D5E60; font-size:16px;">SEVALPATTI, VIRUTHUNAGAR (DT)-626140</h4>
      </td>
      <td><img src="img/images2.png" style="height:70px;" /></td>
    </tr>
  </tbody>
     <table align="left" width="96%" style=" border-bottom:2px solid lightblue; margin-top:-18px; font-size:20px; margin-left:12%;">
  <tr>
  <td>
        <span style="margin-left:10%; height:22px;"><img src="img/phone.jpg" />:04562-239111</span><br>
      <span style="margin-left:10%; height:19px;"><img src="img/mail.jpg" />:www.spmodernschool.edu.in:contact@spmodernschool.edu.in</span><br>
      <span style="margin-left:10%; height:21px;"><img src="img/fb.jpg" />:www.facebook.com/page/spmodernschoolsevalpatti</span>

  </td>
  </tr>
  </table>
</table>

  
<div style="max-height:500px;">
<div style="width:100%; float:left; line-height:36px;">
<div style="float:left; width:50%; text-align:left; margin-left:5%; font-size:21px; ">SPMS/BC/14-15/007908989</div>
<div style="float:left; width:40%; text-align:right; margin-right:3%; font-size:21px;">Date: 12.05.15</div>
</div>
<h2 style="line-height:46px; font-size:30px;">Bonafide Certificate</h2>
<div style="margin-top:85px;width:866px;margin-left:4px; line-height:60px;">
<font color="#2E2F65" style="font-size:28px;">This is to certify that 
<b><?php echo $row['name']; ?></b> S/o / D/o
<b> <?php echo $row['p_name']; ?>  </b> is /was a bonafide student of our institution studying in standard 
<b> <?php echo $row['standard']; ?></b> during the School year
<b> <?php echo $row['year']; ?></b>. His/Her Date of birth as per our school record is 
<b><?php echo $row['dob']; ?> </b>. </font></div>
<div class="Invitation">
   <img src="img/bona.png" alt="" class="adjusted">
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
<div style="height:650px;">&nbsp;</div>
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
<!-- <table width="900" height="24" border="0" cellpadding="0" cellspacing="0" id="Table_01" style="margin-left:5%; border-bottom:1px solid lightblue">
    <tbody><tr id="butt" style="visibility: visible;">
      <td><img src="img/images1.png" /></td>     
      <td>
      <h2 style="text-align:center; padding:0px; margin:0px; color:red;">SP MODERN SCHOOL</h2>
      <h5 style="text-align:center; padding:0px; margin:0px; line-height:21px; color:#017CBE;">(Government Recognized &An ISO 9001:2008 Certified institution)</h5>
      <h4 style="text-align:center; padding:0px; margin:0px; font-size:14px; color:#5D5E60">SEVALPATTI, VIRUTHUNAGAR (DT)-626140</h4>
      </td>
      <td><img src="img/images2.png" /></td>
    </tr>
  </tbody></table>
-->

<div style="float:left; margin:0px auto; width:100%;">
<div style="float:left; width:30%; font-size:21px;">SPMS/BC/14-15/007</div>
<div style="float:left; width:64%; text-align:right; margin-right:3%; font-size:21px;">Date: 12.05.15</div>

<h2 style="line-height:46px; font-size:30px;">Bonafide Certificate</h2>
<div style="margin-top:85px;width:866px;margin-left:4px; line-height:60px;">
<font color="#2E2F65" style="font-size:28px;">This is to certify that 
<b><?php echo $row['name']; ?></b> S/o / D/o
<b> <?php echo $row['p_name']; ?>  </b> is /was a bonafide student of our institution studying in standard 
<b> <?php echo $row['standard']; ?></b> during the School year
<b> <?php echo $row['year']; ?></b>. His/Her Date of birth as per our school record is 
<b><?php echo $row['dob']; ?> </b>. </font></div>
<div class="Invitation">
   <img src="img/bona.png" alt="" class="adjusted">
</div>

</div>
<div style="width:100%; float:right; text-align:right; margin-right:5%; margin-top:3%;">
<h2 style="font-size:1.8em;">Principal</h2>
</div>
<div style="width:100%; float:left; text-align:left; margin-left:5%; margin-top:2%;">
<h2 style="font-size:1.8em;">O/C</h2>
</div>
  
  
  <p>
    <!-- End ImageReady Slices -->
  </p>
 
  <p>&nbsp;    </p>
</div>
</body></html>