<?php 
include("includes/config.php");
error_reporting(0);

session_start();

$check=$_SESSION['email']; 

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
      <h2 style="text-align:center; padding:0px; margin:0px; color:red; font-size:2em;">SP MODERN SCHOOL</h2>
      <h5 style="text-align:center; padding:0px; margin:0px; line-height:21px; color:#017CBE; font-size:1em;">(Government Recognized &An ISO 9001:2008 Certified institution)</h5>
      <h4 style="text-align:center; padding:0px; margin:0px; font-size:14px; color:#5D5E60; font-size:16px;">SEVALPATTI, VIRUTHUNAGAR (DT)-626140</h4>
      </td>
      <td><img src="img/images2.png" style="height:70px;" /></td>
    </tr>
  </tbody>
     <table align="right" width="96%" style=" border-bottom:2px solid lightblue; margin-top:-18px; font-size:20px; margin-left:12%;">
  <tr>
  <td>
        <span style="margin-left:35%; height:22px;"><img src="img/phone.jpg" />:04562-239111</span><br>
      <span style="margin-left:25%; height:19px;"><img src="img/mail.jpg" />:www.spmodernschool.edu.in:contact@spmodernschool.edu.in</span><br>
      <span style="margin-left:25%; height:21px;"><img src="img/fb.jpg" />:www.facebook.com/page/spmodernschoolsevalpatti</span>

  </td>
  </tr>
  </table>
</table>
 <div style="text-align:center; margin:0px auto; width:96%; margin-right:5%; font-size:18px;  ">APPLICATION FOR STUDENT ADMISSION</div> 
<div style="line-height:36px; font-size:18px;">STUDENT INFORMATION</div>
<div style="width:900px;">
<div style="width:80%; float:left; line-height:36px;">
<div style="float:left; width:220px; text-align:left;">Name</div>
<div style="float:left; width:auto;">:...................................................................................................................</div><br>
<div style="float:left; width:195px; text-align:left;">Applying Standard</div>
<div style="float:left; width:20%;">:......................</div>
<div style="width:20%; float:left;">Gender</div><span style="float:left; width:10%">:<img src="img/checkbox.jpg" />Male</span><span style="float:left; width:10%"><img src="img/checkbox.jpg" />Female</span><br>
<div style="float:left; width:195px; text-align:left;">DOB</div>
<div style="float:left; width:20%;">:......................</div>
<div style="width:125px; float:left; text-align:center; margin-right:25px;">Age</div><div style="width:50px; float:left">:..........................</div>
<div style="width:100%; float:left; text-align:left;">(Birth Certificate should be attach)</div><br>
<div style="float:left; width:220px; text-align:left;">Father's Name</div>
<div style="float:left; width:100px;">:..............................................</div>
<div style="float:left; width:350px;">Mother's Name</div>
<div style="float:left; width:50px;">:...............................................</div>
<div style="float:left; width:220px; text-align:left;">Address Line1</div>
<div style="float:left; width:auto;">:.........................................................................................................................</div><br>
<div style="width:100%; text-align:left;">(Door no / street) </div>
<div style="float:left; width:217px; text-align:left;">Address Line2</div>
<div style="float:left; width:320px;">:.............................................................................</div>
<div style="width:150px; float:left; text-align:center;">District/City</div><div style="width:30px; float:left">:..........................................</div>
<div style="width:100%; float:left; text-align:left;">(Place / Village)</div><br>
<div style="float:left; width:220px; text-align:left;">State	/ Country</div>
<div style="float:left; width:220px;">:......................................................</div>
<div style="width:150px; float:left; text-align:center;">Pin Code </div><div style="width:30px; float:left">:...................................................................</div>
<div style="float:left; width:220px; text-align:left;">Home Phone no</div>
<div style="float:left; width:220px;">:......................................................</div>
<div style="width:150px; float:left; text-align:center;">Mobile numbers</div><div style="width:30px; float:left">:...................................................................</div>
<div style="float:left; width:220px; text-align:left;">E-mail id</div>
<div style="float:left; width:220px;">:......................................................</div>
<div style="width:150px; float:left; text-align:center;">Facebook id</div><div style="width:30px; float:left">:...................................................................</div>
<div style="float:left; width:320px; text-align:left;">Father's Qualification / Occupation/Income</div>
<div style="float:left; width:220px;">:........................................../.............................................../...........................................</div><br>
<div style="float:left; width:320px; text-align:left;">Mother's Qualification / Occupation / Income</div>
<div style="float:left; width:220px;">:........................................../.............................................../...........................................</div><br>
<div style="float:left; width:220px; text-align:left;">Guardian Name</div>
<div style="float:left; width:220px;">:.....................................................</div>
<div style="width:124px; float:left; text-align:center;">Blood Group</div><div style="width:30px; float:left">:.........................................................................</div>
<div style="width:100%; float:left; text-align:right;">(Blood Test Certificate should be attach)</div><br>
<div style="width:214px; text-align:left; float:left;">Differently Abled</div><span style="float:left; width:10%">:<img src="img/checkbox.jpg" />Yes</span><span style="float:left; width:10%"><img src="img/checkbox.jpg" />No</span>
<div style="float:left; width:205px; text-align:center;">*If Yes, Type of Abled</div>
<div style="float:left; width:100px;">:..........................................................................</div>
<div style="float:left; width:195px; text-align:left;">Community</div>
<div style="float:left; width:320px;">:OC / BC / MBC / SC / ST / OthersCaste</div>
<div style="width:150px; float:left; text-align:center;">Religion</div><div style="width:30px; float:left">:.................................................</div>
<div style="width:100%; float:left; text-align:left;">(Community Certificate should be attach)</div><br>
<div style="float:left; width:225px; text-align:left;">Institute last studied(With Place)</div>
<div style="float:left; width:280px;">:...............................................................................................................................................................</div><br>
<div style="float:left; width:225px; text-align:left;">Class Studied at previous institute</div>
<div style="float:left; width:235px;">:.......................................................</div>
<div style="width:150px; float:left; text-align:center;">SMS Service</div><div style="width:105px; float:left">:Tamil / English </div>
<div style="width:100%; float:left; text-align:left;">(TC should be attach from1 standard andabove)</div><br>
<div style="width:214px; text-align:left; float:left;">Mode of Transport</div><span style="float:left; width:15%">:<img src="img/checkbox.jpg" />School van</span><span style="float:left; width:16%"><img src="img/checkbox.jpg" />Own Vehicle</span>
<div style="float:left; width:195px; text-align:center;">Stage Name</div>
<div style="float:left; width:50px;">:..........................................................</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div style="width:214px; text-align:left; float:left;">Period of Payment</div>
<span style="float:left; width:11%">:<img src="img/checkbox.jpg" />Yearly</span>
<span style="float:left; width:18%"><img src="img/checkbox.jpg" />Half-yearly</span>
<span style="float:left; width:17%"><img src="img/checkbox.jpg" />Quarterly</span>
<span style="float:left; width:18%"><img src="img/checkbox.jpg" />Monthly</span>
<div style="float:left; width:240px; text-align:left;">How do you know this Institution?</div>
<div style="float:left; width:480px;">:TV Add /News Paper add / Vehicle add / From Neighbours / others</div><br>
<div style="width:210px; text-align:left; float:left;">Already My Children studying</div>
<span style="float:left; width:10%">:<img src="img/checkbox.jpg" />Yes</span>
<span style="float:left; width:10%"><img src="img/checkbox.jpg" />No</span>
<div style="float:left; width:280px; text-align:center;">* if Yes,Details of student</div>
<div style="float:left; width:50px;">:..........................................................</div>
<div style="float:left; width:82px; text-align:left;">Date</div>
<div style="float:left; width:430px;">:.....................................</div><br>
<div style="float:left; width:220px; text-align:left;">Place</div>
<div style="float:left; width:100px;">:.....................................</div>
<div style="float:left; width:350px; text-align:right;">Signature of Father/Guardian</div>


</div>
<div style="border:1px solid #999; width:15%; float: left; border-radius:20px; float:right; height:140px; margin-right:3%;
vertical-align:middle; line-height:130px;">Photos</div>
</div>

<div style="font-size:18px; font-weight:bold; width:96%; float:left; text-align:left; line-height:36px; border-top:1px solid lightblue;">Office Use only</div>
<table border="1" style="border-collapse: collapse; width:96%; float:left;">
<tr style="border:1px solid #999; height:30px;">
<td>Waiting (or)Rejected</td>
<td width="25%">&nbsp;</td>
<td>Admitted/ Admission Number</td>
<td width="25%">&nbsp;</td>
</tr>
<tr style="border:1px solid #999; height:30px;">
<td>Any Other</td>
<td>&nbsp;</td>
<td>Signature of Principal with date</td>
<td>&nbsp;</td>
</tr>
</table>
</div>


</body></html>