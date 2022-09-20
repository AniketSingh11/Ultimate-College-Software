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

 <div style="text-align:center; margin:0px auto; width:96%; margin-right:5%; font-size:18px; ">APPLICATION FOR TEACHING / NON TEACHING POSITION

</div>
<div style="width:900px;">
<div style="width:80%; float:left; line-height:42px;">
<div style="float:left; width:195px; text-align:left;">Date</div>
<div style="float:left; width:20%;">:....................................</div><br>
<div style="float:left; width:195px; text-align:left;">Post Applied For</div>
<div style="float:left; width:20%;">:.....................................</div><br>
<div style="float:left; width:195px; text-align:left;">Specialization</div>
<div style="float:left; width:20%;">:.....................................</div>
<div style="border-bottom:1px solid lightblue; width:870px; line-height:80px;">&nbsp; &nbsp; &nbsp;</div>
</div>
<div style="border:1px solid #999; width:13%; float: left; border-radius:20px; float:right;
height:140px; margin-right:3%; vertical-align:middle; line-height:130px; margin-top:1%;">Photos</div>

</div> 
<div style="width:900px;">
<div style="width:80%; float:left; line-height:36px;">
<div style="float:left; width:204px; text-align:left;">Name (in Block Letter)</div>
<div style="float:left; width:39%;">:.............................................................</div>
<div style="width:150px; float:left; text-align:center; margin-right:25px;">Date of Birth & Age</div><div style="width:50px; float:left">:...................................................</div>

<div style="float:left; width:195px; text-align:left;">Father/Husband Name</div>
<div style="float:left; width:30%;">:.........................................</div>
<div style="width:5%; float:left;">Gender</div><span style="float:left; width:10%">: M &nbsp; /</span><span style="float:left;">F</span>
<div style="float:left; width:18%;">Religion</div><div style="float:left; width:5%;">:....................................................</div><br>

<div style="float:left; width:195px; text-align:left;">Community</div>
<div style="float:left; width:320px;">:OC / BC / MBC / SC / ST / OthersCaste</div>
<div style="width:142px; float:left; text-align:center;">OtherCaste</div><div style="width:30px; float:left">:....................................................</div><br>

<div style="float:left; width:204px; text-align:left;">Marital status</div>
<div style="float:left; width:18%;">:Single/Married</div>
<div style="width:298px; float:left; text-align:center; margin-right:25px;">*If Married, Number of Children</div><div style="width:50px; float:left">:....................................................</div>

<div style="float:left; width:218px; text-align:left;">Present Address</div>
<div style="float:left; width:500px;">:.................................................................................................................................................................</div><br>
<div style="float:left; width:218px; text-align:left;">Permanent Address</div>
<div style="float:left; width:500px;">:.................................................................................................................................................................</div><br>

<div style="float:left; width:204px; text-align:left;">Phone / Mobile</div>
<div style="float:left; width:39%;">:.............................................................</div>
<div style="width:150px; float:left; text-align:center; margin-right:25px;">E - mail id</div><div style="width:50px; float:left">:...................................................</div>

<div style="width:100%; float:left; text-align:left; font-size:18px; font-weight:bold;">Educational Qualifications</div>
<div style="float:left; text-align:left; width:100%; margin-left:25%;">Certificate xeroxcopy (Degree, mark sheet) should be enclosed</div>
<table border="1" style="border-collapse:collapse; width:870px;">
<tr style="text-align:center;">
<td rowspan="2">Sl.No</td>
<td colspan="3" style="text-align:center;">Course / Branch <br>(From First Degree Onwards)</td>
<td colspan="3">Name of the Institution / University</td>
<td rowspan="2">% of Marks</td>
<td rowspan="2">Class</td>
<td rowspan="2">Month & Year of Passing</td>
</tr>
<tr style="text-align:center;">
<td>Degree</td>
<td>Specialization</td>
<td>FT/PT/D Mode</td>
<td colspan="3">&nbsp;</td>
</tr>
<tr style="line-height:36px; height:35px;">
<td></td>
<td></td>
<td></td>
<td></td>
<td colspan="3"></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="line-height:36px; height:35px;">
<td></td>
<td></td>
<td></td>
<td></td>
<td colspan="3"></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="line-height:36px; height:35px;">
<td></td>
<td></td>
<td></td>
<td></td>
<td colspan="3"></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="line-height:36px; height:35px;">
<td></td>
<td></td>
<td></td>
<td></td>
<td colspan="3"></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="line-height:36px; height:35px;">
<td></td>
<td></td>
<td></td>
<td></td>
<td colspan="3"></td>
<td></td>
<td></td>
<td></td>
</tr>
</table>
<div style="height:250px;">&nbsp;</div>
<div style="width:100%; float:left; text-align:left; font-size:18px; font-weight:bold;">Experience</div>
<div style="float:left; text-align:left; width:100%; margin-left:25%;">Experience Certificate xerox, copy Salary  proof should be enclosed</div>
<div style="width:100%; float:left; text-align:left; font-size:18px; font-weight:bold; margin-left:3%;">A. Teaching</div>
<table border="1" style="border-collapse:collapse; width:870px;">
<tr style="text-align:center;">
<td rowspan="2">Sl.No</td>
<td colspan="3" rowspan="2">Name of the School/Institution</td>
<td colspan="2" rowspan="2">Designation, Duty& Responsibility</td>
<td>Class & Subject handling</td>
<td colspan="2">Period (DD/MM/YY)</td>
<td>Total Service</td>
<td rowspan="2">Last Salary Drawn</td>
</tr>
<tr style="text-align:center;">
<td></td>
<td>From</td>
<td>To</td>
<td>Y/M</td>
</tr>
<tr style="height:35px;">
<td></td>
<td colspan="3"></td>
<td colspan="2"></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style=" height:35px;">
<td></td>
<td colspan="3"></td>
<td colspan="2"></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="height:35px;">
<td></td>
<td colspan="3"></td>
<td colspan="2"></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="height:35px;">
<td></td>
<td colspan="3"></td>
<td colspan="2"></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
</table>

<div style="width:100%; float:left; text-align:left; font-size:18px; font-weight:bold; margin-left:3%;">B. Industry</div>
<table border="1" style="border-collapse:collapse; width:870px;">
<tr style="text-align:center;">
<td rowspan="2">Sl.No</td>
<td colspan="3" rowspan="2">Name of the 
Industry /Company</td>
<td colspan="2" rowspan="2">Designation</td>
<td rowspan="2">Duty & Responsibility,
Nature of work
</td>
<td colspan="2">Period (DD/MM/YY)</td>
<td>Total Service</td>
<td rowspan="2">Last Salary Drawn</td>
</tr>
<tr style="text-align:center;">
<td>From</td>
<td>To</td>
<td>Y/M</td>
</tr>
<tr style="height:35px;">
<td></td>
<td colspan="3"></td>
<td colspan="2"></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style=" height:35px;">
<td></td>
<td colspan="3"></td>
<td colspan="2"></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="height:35px;">
<td></td>
<td colspan="3"></td>
<td colspan="2"></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr style="height:35px;">
<td></td>
<td colspan="3"></td>
<td colspan="2"></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
</table>

<div style="float:left; width:266px; text-align:left;">Extra-Curricular Activities	</div>
<div style="float:left; width:300px;">:.....................................................................................................................................................</div><br>
<div style="float:left; width:266px; text-align:left;">Award /Publication/ Social Contribution</div>
<div style="float:left; width:300px;">:.....................................................................................................................................................</div><br>
<div style="float:left; width:260px; text-align:left;">How do you know this Institution?</div>
<div style="float:left; width:460px;">:TV Add / News Paper add /Vehicle add /Through Neighbours/Others</div><br>
<div style="float:left; width:266px; text-align:left;">If you join here, How long will you work </div>
<div style="float:left; width:39%;">:.............................................................</div>
<div style="width:120px; float:left; text-align:center; margin-right:25px;">Expected Salary	</div><div style="width:20px; float:left">:...........................................</div>
<div style="width:100%; float:left; text-align:left; font-size:18px; font-weight:bold;">Declaration</div>
<div style="float:left; text-align:left; width:100%; margin-left:25%;">I hereby declare that the above statement is true to the best of my knowledge </div>




<div style="float:left; width:82px; text-align:left;">Date</div>
<div style="float:left; width:430px;">:.....................................</div><br>
<div style="float:left; width:220px; text-align:left;">Place</div>
<div style="float:left; width:100px;">:.....................................</div>
<div style="float:left; width:400px; text-align:right;">Signature</div>


</div>
</div>

<div style="font-size:18px; font-weight:bold; width:96%; float:left; text-align:left; line-height:36px; border-top:1px solid lightblue;">Office Use only</div>
<table border="1" style="border-collapse: collapse; width:96%; float:left;">
<tr style="border:1px solid #999; height:30px;">
<td>Interview Held on</td>
<td width="25%">&nbsp;</td>
<td>Communication Skill</td>
<td width="25%">&nbsp;</td>
</tr>
<tr style="border:1px solid #999; height:30px;">
<td>Subject knowledge</td>
<td>&nbsp;</td>
<td>Computer Skill</td>
<td>&nbsp;</td>
</tr>
<tr style="border:1px solid #999; height:30px;">
<td>General knowledge</td>
<td width="25%">&nbsp;</td>
<td>Any other</td>
<td width="25%">&nbsp;</td>
</tr>
<tr style="border:1px solid #999; height:30px;">
<td>Way of Teaching</td>
<td>&nbsp;</td>
<td>Computer Skill</td>
<td>&nbsp;</td>
</tr>
<tr style="border:1px solid #999; height:30px;">
<td colspan="2">Interviewer Name & Signature</td>
<td colspan="2">&nbsp;</td>
</tr>
</table>
</div>


</body></html>