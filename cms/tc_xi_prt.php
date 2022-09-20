<?php 
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);

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
							$tcid=$_GET['tcid'];
							$stafflist=mysql_query("SELECT * FROM tc_xi WHERE id=$tcid"); 
								  $row=mysql_fetch_array($stafflist);
					
?>
<?php include 'print_header.php';?>

<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page     var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
          
        }
    </script>
</head>
<body>
 <div style="float:right;"><a onclick="javascript:printDiv('printablediv')" href="" title="Print this certificate"><img src="img/printer.png"></a></div>

 <div id="printablediv" style="width:195.75mm; height:335.36mm">
<div style="width:195.75mm; height:335.36mm; min-height:335.36mm; max-height:335.36mm;">
<div style="width:195.75mm; height:64.1mm; min-height:64.1mm;">

<div style="width:195.75mm; height:19mm; float:left; margin-top:2%">
<div style="text-align:left; width:45.73mm; float:left;">
<img src="img/krishschool_logo.png" style="width:50%; height:50%; margin-left:40%;" />
</div>
<div style="text-align:left; width:150.02mm; float:left;">
<h1 style="padding:0px; padding-bottom:2px; margin:0px; margin-left:17.5%; color:#ed1c24; text-shadow: 1px 1px #fff200;">SRI KRISH</h1>
<h2 style="padding:0px; padding-bottom:2px; margin:0px; color:#ed1c24; text-shadow: 1px 1px #fff200;">INTERNATIONAL SCHOOL(CBSC)</h2>
</div>
</div>
<div style="width:195.75mm; height:13mm; text-align:center; line-height:18px;">
<h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:13px; color:#ed202a;">Affiliated to CBSE, New Delhi. Affiliation No. : 1930580</h5>
<h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:13px;">An ISO 9001:2008 Certified Institution.</h5>
<h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:12px; font-weight:lighter">1/191A, Rajiv Gandhi Nagar, Kundrathur Main Road, Kovur, Chennai - 600 128</h5>
<h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:12px; font-weight:lighter">Phone No: 044-65666673, 044-65666674</h5>
<h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:12px; font-weight:lighter">E-Mail :skischoolcbse@gmail.com, www.srikrishinternationalschool.com</h5>
<h2 style="padding:0px; padding-bottom:2px; margin:0px; margin-top:1%;">TRANSFER CERTIFICATE</h2>
</div>
</div>

<div style="width:195.75mm; height:13mm; min-height:13mm;">
<div style="width:195.75mm; float:left; padding-bottom:10px; font-weight:bold">
<div style="float:left; font-size:13px; width:97.8mm;">
  <div style="width:20%; float:left; margin-top:10px;">T.C. No.: &nbsp; </div>
  <div style="width:30%; text-align:center; float:left; border:1px solid #000; padding:10px 0px; overflow:hidden"><?php echo $row['tno']; ?></div></div>
<div style="float:right; font-size:13px; width:97.8mm">
  <div style="width:30%; float:left">&nbsp;</div>
  <div style="width:30%; float:left; margin-top:10px;">Admission No.: &nbsp; </div>
  <div style="width:30%; text-align:center; float:left; border:1px solid #000; padding:10px 0px; overflow:hidden"><?php echo $row['ano']; ?></div></div>
</div>
</div>
<div style="width:195.75mm; font-size:14px; line-height:41px;">
<div style="width:195.75mm; min-height:44.1mm; height:44.1mm;">
<div style="width:195.75mm; float:left">
<div style="width:37.5mm; float:left; font-size:14px;">1)&nbsp; Name of the Pupil</div>
<div style="width:0.5%; float:left">:</div><div style=" width:154.4mm; float:left; border-bottom:1px dashed #424141; height:30px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['sname']; ?></div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:37.5mm; float:left; font-size:14px; padding-top:6px;">2)&nbsp; Gender</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:154.4mm; float:left; padding-top:6px;">&nbsp; Male <span style="border:1px solid #000; padding:4px 20px; <?php if($row['sex']=="Male"){ echo "background:url(img/check.png) no-repeat center;";}?>">&nbsp;</span>&nbsp;&nbsp;&nbsp;Female <span style="border:1px solid #000; padding:4px 20px; <?php if($row['sex']=="Female"){ echo "background:url(img/check.png) no-repeat center;";}?>">&nbsp;</span>  </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:57.5mm; float:left; font-size:14px; padding-top:6px;">3)&nbsp; Name of the Parent/Guardian</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:134.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['fname']; ?></div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:57.5mm; float:left; font-size:14px; padding-top:6px;">4)&nbsp; Name of the Mother</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:134.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['mname']; ?></div>
</div>
</div>


<div style="width:195.75mm; height:60.1mm; min-height:60.1mm;">
<div style="width:195.75mm; float:left">
<div style="width:57.5mm; float:left; font-size:14px; padding-top:6px;">5)&nbsp; Nationality</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:134.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['nation']; ?></div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:57.5mm; float:left; font-size:14px; padding-top:6px;">6)&nbsp; Religion, Caste & Community</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:134.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['religion']; ?> </div>
</div>

<div style="width:195.75mm; float:left;">
<div style="width:195.75mm; font-size:14px; padding-top:6px;">7)&nbsp; Date of Birth as entered in the admission register</div>

</div>
<div style="width:195.75mm; float:left; line-height:20px; padding-top:8px; height:30px;">
<div style="width:25.1mm; font-size:14px; margin-left:6%; float:left">
<b style="margin-left:-2%; font-weight:lighter;">(a) </b>
<b style="font-weight:lighter">In figures:</b>
</div>
<div style="width:156.1mm; float: left; line-height:20px; padding-top:0px; border-bottom:1px dashed #424141;">
&nbsp;<?php echo $row['dobfigure']; ?>
</div>

</div>

<div style="width:195.75mm; float:left; line-height:20px; padding-top:15px;">
<div style="width:25.1mm; font-size:14px; margin-left:6%; float:left">
<b style="margin-left:-2%; font-weight:lighter;">(b) </b>
<b style="font-weight:lighter">In words:</b>
</div>
<div style="width:156.1mm; float: left; line-height:20px; padding-top:0px; border-bottom:1px dashed #424141;">
&nbsp;<?php echo $row['dobword']; ?>
</div>

</div>


<div style="width:195.75mm; float:left">
<div style="width:130.5mm; float:left; font-size:14px; padding-top:6px;">8)&nbsp; Standard in which the pupil was studying at the time of leaving (In words)</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:61.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px; overflow:hidden;"> &nbsp;&nbsp;&nbsp; <?php echo $row['leaving']; ?></div>
</div>

<div style="width:195.75mm; float:left;">
<div style="width:195.75mm; font-size:14px; padding-top:6px;">9)&nbsp; In the case of pupils of higher standards</div>

</div>
<div style="width:195.75mm; float:left; line-height:20px; padding-top:8px; height:30px">
<div style="width:40.1mm; font-size:14px; margin-left:6%; float:left">
<b style="margin-left:-2%; font-weight:lighter;">(a) </b>
<b style="font-weight:lighter">Language studied:</b>
</div>
<div style="width:141.1mm; float: left; line-height:20px; padding-top:0px; border-bottom:1px dashed #424141;">
&nbsp;<?php echo $row['high_language']; ?>
</div>

</div>

<div style="width:195.75mm; float:left; line-height:20px; padding-top:15px;">
<div style="width:35.1mm; font-size:14px; margin-left:6%; float:left">
<b style="margin-left:-2%; font-weight:lighter;">(b) </b>
<b style="font-weight:lighter">Elective studied:</b>
</div>
<div style="width:146.1mm; float: left; line-height:20px; padding-top:0px; border-bottom:1px dashed #424141;">
&nbsp;<?php echo $row['high_elective']; ?>
</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:47.5mm; float:left; font-size:14px; padding-top:6px;">10)&nbsp; Medium of Instruction</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:144.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp;  <?php echo $row['med_ins1']; ?> </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:107.5mm; float:left; font-size:14px; padding-top:6px;">11)&nbsp; Date of admission or promotion to that class or standard</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:84.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['doa']; ?>  </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:97.5mm; float:left; font-size:14px; padding-top:6px;">12)&nbsp; Whether qualified for promotion to higher standard</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:94.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['q_std']; ?>  </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:77.5mm; float:left; font-size:14px; padding-top:6px;">13)&nbsp; Whether the pupil has paid all the fees</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:114.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['due_school']; ?>  </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:77.5mm; float:left; font-size:14px; padding-top:6px;">14)&nbsp; Date of pupil’s last attendance of School</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:114.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['last_att']; ?>  </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:87.5mm; float:left; font-size:14px; padding-top:6px;">15)&nbsp; Date of application for TC by Parent/Guardian</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:104.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['dtc1']; ?>  </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:47.5mm; float:left; font-size:14px; padding-top:6px;">16)&nbsp; Date of issue of TC</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:144.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp; <?php echo $row['dtc']; ?>  </div>
</div>


<div style="width:195.75mm; float:left; margin-top:13%; line-height:41px; height:60px;">
<div style="width:47.5mm; float:left; font-size:14px; padding-top:6px;">17)&nbsp; Reasons for leaving</div>
<div style="width:0.5%; float:left; padding-top:6px;">:</div><div style=" width:144.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp;<?php echo $row['purpose']; ?> </div>
</div>

</div>


<div style="width:195.75mm; height:65.1mm; min-height:65.1mm; margin-top:5%; line-height:41px;">

<div style="width:195.75mm; float:left">
<div style="width:77.5mm; float:left; font-size:14px; ;">18)&nbsp; No. of School days the pupil attended</div>
<div style="width:0.5%; float:left;">:</div><div style=" width:114.5mm; float:left; border-bottom:1px dashed #424141; font-weight:bold; text-align:center "> &nbsp; <?php echo $row['no_day_att']; ?></div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:47.5mm; float:left; font-size:14px; padding-top:8px;">19) The Pupil's Conduct</div>
<div style="width:0.5%; float:left; padding-top:8px;">:</div><div style=" width:144.5mm; float:left; border-bottom:1px dashed #424141; padding-top:8px;"> &nbsp;&nbsp;&nbsp;  <?php echo $row['conduct']; ?> </div>
</div>

<div style="width:195.75mm; float:left;">
<div style="width:195.75mm; font-size:14px; padding-top:6px;">20) Course of Study<br>
</div>
</div>

</div>


</div>

</div>

<div style="width:195.75mm; height:335.36mm; min-height:335.36mm; max-height:335.36mm; font-size:14px; font-weight:lighter; line-height:16.5px;">

<div style="width:195.75mm; font-weight:lighter;">
<table style="border:1px solid #999; border-collapse:collapse; font-size:14px; width:195.75mm; float:left; font-weight:lighter; margin:3% 0%">
    <tr style="width:195.75mm;border:1px solid #999; border-collapse:collapse; height:50px;">
    <th style="width:40%;border:1px solid #999; border-collapse:collapse;">Name of the School</th>
    <th style="width:15%;border:1px solid #999; border-collapse:collapse;">Academic Year(s)</th>
    <th style="width:15%;border:1px solid #999; border-collapse:collapse;">Standard(s)</th>
    <th style="width:15%;border:1px solid #999; border-collapse:collapse;">First Language</th>
    <th style="width:15%;border:1px solid #999; border-collapse:collapse;">Medium of Instruction</th>
    </tr>

    <tr style="width:195.75mm; height:100px;">
    <th style="width:40%; border-right:1px solid #999; font-weight:bold; font-size:14px; line-height:21px; display: table-cell; vertical-align: middle">SCHOOL/COLLEGE MANAGEMENT SYSTEM </th>
    <th style="width:15%; border-right:1px solid #999;"><?php echo $row['academic_year']; ?></th>
    <th style="width:15%; border-right:1px solid #999;"><?php echo $row['standard']; ?></th>
    <th style="width:15%; border-right:1px solid #999;"><?php echo $row['first_lan']; ?></th>
    <th style="width:15%; border-right:1px solid #999;"><?php echo $row['med_ins']; ?></th>
    </tr>

</table>
</div>

<div style="padding-bottom:10px; width:195.75mm; float:left; height:13%;">
<div style="width:137mm; font-size:14px; padding-top:6px;">21)&nbsp; <b style="margin-left:0mm; font-weight:lighter; font-size:14px;">Signature of the Headmaster with Date and with School Seal</b></div>
</div>



<div style="width:195.75mm;cell-padding:1px;font-size:14px;line-height:41px; ">
<div style="width:195.75mm; float:left">Note&nbsp;&nbsp; :<br>
</div>

<div style="width:195.75mm; float:left;">
<div style="width:195.75mm; float:left; padding-bottom:1%; font-size:14px;">
1) <b style="margin-left:4mm; font-weight:lighter;">Erasures and unauthenticated or Fraudulent alterations in the Certificate will lead to its Cancellation.</b><br>
2) <b style="margin-left:4mm; font-weight:lighter;">They should be signed in ink by the Head of the institution who will be held responsible for the correctness of the entries.</b><br>
</div>
</div>
</div>

<div style="font-size:14px;line-height:18px; width:195.75mm; float:left; line-height:41px; ">
<h4>DECLARATION BY THE PARENT OR GUARDIAN</h4>
I hereby declare that the particulars mentioned above are correct and that no change will be demanded by me in future.<br>
<div style="width:195.75mm; float:left; padding-top:15%;">
<p><span style=" float:left; font-weight:lighter; margin-right:6%;"><b style=" font-size:14px; font-weight:lighter;">Student's Signature with date</span></p>
<p><span style=" float:right; font-weight:lighter; margin-right:6%;"><b style=" font-size:14px; font-weight:lighter;">Signature of the Parent/Guardian with date</span></p></div>
</div>
</div>
</div>

</body></html>