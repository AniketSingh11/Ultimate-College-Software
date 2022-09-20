<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<?php
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$tcid=$_GET['tcid'];
$stafflist=mysql_query("SELECT * FROM tc_xi WHERE id=$tcid"); 
$row=mysql_fetch_array($stafflist);
$standard=$row['standard'];
?>
</head>

<body style="font-family:arial">
<div id="printablediv" style="width:195.75mm; height:335.36mm">
<div style="width:195.75mm; height:335.36mm; min-height:335.36mm; max-height:335.36mm;">
<div style="width:195.75mm; height:6mm; min-height:6mm;">
<div style="width:195.75mm; float:left; padding-bottom:10px;">
<div style="float:left; font-size:14px;">Serial No.<?= $row['tno']?></div>
<div style="float:right; font-size:14px; margin-right:20%;">Admission No. <?= $row['ano']?></div>
</div>
</div>

<div style="width:195.75mm; height:38.1mm; min-height:38.1mm;position: relative">
<div style="text-align: center; width:195.75mm; float:left;">
<h2 style="padding:0px; padding-bottom:2px; margin:0px; font-family:georgia">CHRIST MATRICULATION HR. SEC. SCHOOL</h2>
<h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:16px; font-weight:lighter">Senneerkuppam, Poonamallee, Chennai - 600 056.</h5>
<h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:15px; font-weight:lighter">(Recognised by Director of School Education)</h5>
<h2 style="padding:0px; padding-top:10px; margin:0px; font-family:georgia">TRANSFER CERTIFICATE</h2>
</div>
<div style="position:absolute;margin-top:35px;">
<?php if($row['standard']=="X" || $row['standard']=="XII") {	?>
<p style="font-size: 12px;">Certificate No:<?= $row['cert_no']?></p>
<p style="font-size: 12px;">Registration No:<?= $row['reg_no']?></p>
<?php }	?>
</div>
</div>

<div style="width:195.75mm; font-size:14px;">
<div style="width:195.75mm; min-height:57.1mm; height:57.1mm;">
<div style="width:195.75mm; float:left">
<div style="width:114.5mm; float:left; font-size:9px;">1)&nbsp; (a) பள்ளியின் பெயர்</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141; height:40px; font-weight:bold; font-size:13px; font-family:georgia; margin-top:-7mm"> &nbsp;&nbsp;&nbsp;Christ Matriculation Hr. Sec. School<br><span style=" margin-left:10mm; line-height:26px; font-size:11px; font-family:arial; text-align:center">POONAMALLEE, CHENNAI - 600 056.</span></div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:107.7mm; float:left; margin-left:8mm;"> Name of the School</div>
<div style="width:79.1mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:111.5mm; float:left; font-size:9px; margin-left:3mm;">(b) கல்வி மாவட்டத்தின் பெயர் </div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141;"><?= $row['schoolplace']?></div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:107.7mm; float:left; margin-left:8mm;"> Name of the Educational District </div>
<div style="width:79.1mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:111.5mm; float:left; font-size:9px; margin-left:3mm;">(c) வருவாய் மாவட்டத்தின் பெயர்</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141;"> <?= $row['revenueplace']?></div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:107.7mm; float:left; margin-left:8mm;"> Name of the Revenue District</div>
<div style="width:79.1mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:114.5mm; float:left; font-size:9px; padding-top:6px;">2)&nbsp; மாணவர் பெயர் [தனித்தனி எழுத்துக்களில்]</div>
<div style="width:3.5%; float:left; padding-top:6px;"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"><?= $row['sname']?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:113.5mm; float:left; margin-left:3mm;"> Name of the Pupil [In Block Letter]</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:114.5mm; float:left; font-size:9px; padding-top:6px;">3)&nbsp; தந்தை அல்லது தாயாரின் பெயர்</div>
<div style="width:3.5%; float:left; padding-top:6px;"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?= $row['fname']?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:113.5mm; float:left; margin-left:3mm;"> Name of the Father or Mother of the Pupil</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:114.5mm; float:left; font-size:9px; padding-top:6px;">4)&nbsp; தேசிய இனம், சமயம் மற்றும் சாதி</div>
<div style="width:3.5%; float:left; padding-top:6px;"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?php echo $row['nation'].' / '.$row['religion'];?>   </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:113.5mm; float:left; margin-left:3mm;"> Nationality, Religion and Caste</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>
</div>


<div style="width:195.75mm; height:56.1mm; min-height:56.1mm;">
<div style="width:195.75mm; float:left">
<div style="width:114.5mm; float:left; font-size:9px; padding-top:6px;">5)&nbsp; இனம் அவன்/அவள் பின்வரும் ஐந்து பிரிவுகளில் <br> <span style="margin-left:4mm"> எவையேனும் ஒன்றைச் சார்ந்தவரா என்பது</span>
<br><b style=" font-size:11px; font-weight:lighter; margin-left:4mm;">Community Whether he / she belongs to</b><br></div>
<div style="width:3.5%; float:left; padding-top:6px;"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> &nbsp;&nbsp;&nbsp;   </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:111.1mm; float:left; font-size:9px; margin-left:4mm;">(a)&nbsp; ஆதி திராவிடர் அல்லது பழங்குடி</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.65mm; float:left; border-bottom:1px dashed #424141;">
<?php if($row['AdiDravidar']!="Select"){echo $row['AdiDravidar'];} else { echo "&nbsp;&nbsp; -- &nbsp;&nbsp;"; } ?> </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:103.1mm; float:left; margin-left:4mm"> Adi Dravidar (Scheduled Caste or Scheduled Tribe)</div>
<div style="float:left; width:75.65mm;">&nbsp;</div>
</div>


<div style="width:195.75mm; float:left">
<div style="width:111.1mm; float:left; font-size:9px; margin-left:4mm;">(b)&nbsp; பின்தங்கிய வகுப்பு</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.65mm; float:left; border-bottom:1px dashed #424141;"> <?php if($row['backclass']!="Select"){echo $row['backclass'];} else { echo "&nbsp;&nbsp; -- &nbsp;&nbsp;"; } ?></div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:103.1mm; float:left; margin-left:4mm;"> Backward Class</div>
<div style="float:left; width:75.65mm;">&nbsp;</div>
</div>


<div style="width:195.75mm; float:left">
<div style="width:111.1mm; float:left; font-size:9px; margin-left:4mm;">(c)&nbsp; மிகவும் பின்தங்கிய வகுப்பு</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.65mm; float:left; border-bottom:1px dashed #424141;"> <?php if($row['mostbackclass']!="Select"){echo $row['mostbackclass'];} else { echo "&nbsp;&nbsp; -- &nbsp;&nbsp;"; } ?> </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:103.1mm; float:left; margin-left:4mm;"> Most Backward Class</div>
<div style="float:left; width:75.65mm;">&nbsp;</div>
</div>


<div style="width:195.75mm; float:left">
<div style="width:111mm; float:left; font-size:9px; margin-left:4mm;">(d)&nbsp; ஆதி திராவிடர் இனத்திலிருந்து கிருஸ்தவ மதத்திற்கு மாறியவர் அல்லது</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.65mm; float:left; border-bottom:1px dashed #424141;"> <?php if($row['convertedclass']!="Select"){echo $row['convertedclass'];} else { echo "&nbsp;&nbsp; -- &nbsp;&nbsp;"; } ?></div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:103.1mm; float:left; margin-left:4mm;"> Converted to Christianity from Scheduled Caste</div>
<div style="float:left; width:75.65mm;">&nbsp;</div>
</div>


<div style="width:195.75mm; float:left">
<div style="width:111mm; float:left; font-size:9px; margin-left:4mm;">(e)&nbsp; அட்டவணையிலிருந்து நீக்கப்பட்ட இனம்</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.65mm; float:left; border-bottom:1px dashed #424141;"> <?php if($row['denoty']!="Select"){echo $row['denoty'];} else { echo "&nbsp;&nbsp; -- &nbsp;&nbsp;"; } ?> </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:103.1mm; float:left; margin-left:4.5mm;"> Denotified Tribes</div>
<div style="float:left; width:75.65mm;">&nbsp;</div>
</div>
</div>


<div style="width:195.75mm; height:65.1mm; min-height:65.1mm;">
<div style="width:195.75mm">
<div style="width:195.75mm; float:left; font-size:9px; margin-left:4mm;"> மாணவர்/மாணவியர் மேற்குறிப்பிட்ட ஐந்து பிரிவுகளில் ஏதாவது  ஒன்றைச் சார்ந்தவராக இருந்தால் <br> அந்த பிரிவிற்கு எதிரே ஆம் என்று எழுத வேண்டும்<br></font>
</div>
<div style="width:195.75mm;">
<div style="width:195.75mm; float:left; margin-left:4mm;">If the pupil belongs to any one of the five categories mentioned above, write "Yes" against the relevant Column</font>
</div>

</div>

<div style="width:195.75mm; float:left">
<div style="width:115.5mm; float:left; font-size:9px; ;">6)&nbsp; பாலினம் <br> <span style="margin-left:4mm;">(Sex)</span></div>
<div style="width:3.5%; float:left;"> -- </div><div style=" width:72.5mm; float:left; border-bottom:1px dashed #424141; font-weight:bold; text-align:center "> <?= $row['sex']?></div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:115.5mm; float:left; font-size:9px; padding-top:8px;">7) பிறந்த தேதி எண்ணிலும், எழுத்திலும்<br> <span style="margin-left:4mm;"> (மாணவர் சேர்க்கை பதிவேட்டில் உள்ளபடி) </span></div>
<div style="width:3.5%; float:left; padding-top:8px;"> -- </div><div style=" width:72.5mm; float:left; border-bottom:1px dashed #424141; padding-top:8px;"> <?php echo $row['dobfigure'].' / '.$row['dobword']?>   </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:3mm;">Date of birth as entered in the Admission<br> <span style="margin-left:0mm;"> Register in figures & words</span></div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:115.5mm; float:left; font-size:9px; padding-top:8px;">8) உடலில் அமைந்த அடையாளக் குறிகள் <span style="float:right; text-align:right; margin-right:2mm;">அ. (a)</span><br> <span style="margin-left:4mm;"> Personal Marks of Identification</span></div>
<div style="width:3.5%; float:left; padding-top:8px;"> -- </div><div style=" width:72.5mm; float:left; border-bottom:1px dashed #424141; padding-top:8px;"> <?= $row['personmark']?>   </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:115.5mm; float:left; font-size:9px; padding-top:8px;">&nbsp; <span style="float:right; text-align:right; margin-right:2mm;">ஆ. (b)</span><br> <span style="margin-left:4mm;">&nbsp;</span></div>
<div style="width:3.5%; float:left; padding-top:8px;"> -- </div><div style=" width:72.5mm; float:left; border-bottom:1px dashed #424141; padding-top:8px;"> &nbsp;&nbsp;&nbsp;   </div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:115.45mm; float:left; font-size:9px; padding-top:8px;">9) பள்ளியில் சேர்க்கப்பட்ட தேதி மற்றும் சேர்க்கப்பட்ட வகுப்பு
<br><b style="margin-left:3mm; font-weight:lighter;">(வருடத்தை எழுத்தால் எழுதவும்)</b></div>
<div style="width:3.5%; float:left; padding-top:8px;"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141; padding-top:8px;"> <?= $row['doandclass']?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:117.45mm; float:left; margin-left:3mm;">Date of Admission and Standard in which admitted 
<br>(the year to be entered in words)</div>
<div style="width:75.3mm; float:left;">&nbsp;</div>
</div>
</div>


<div style="width:195.75mm; height:65.1mm; min-height:65.1mm;">
<div style="width:195.75mm; float:left">
<div style="width:115.5mm; float:left; font-size:9px; padding-top:6px;">10)&nbsp;&nbsp;(அ)&nbsp; மாணவர் பள்ளியை விட்டு நீக்கும் காலத்தில் பயின்று வந்த
<br><b style="margin-left:10mm; font-weight:lighter;"> வகுப்பு (எழுத்தில்)</b></div>
<div style="width:3.5%; float:left; padding-top:6px;"> -- </div>
<div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?= $row['leaving']?>   </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:8mm;">&nbsp; Standard in which the pupil was studying at the time of 
<br><b style="margin-left:2mm; font-weight:lighter;">leaving [in words]</b></div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<?php if($standard=="XI" || $standard=="XII") { ?>
<div style="width:195.75mm; float:left">
<div style="width:111.5mm; float:left; font-size:9px; margin-left:4mm;">(ஆ)&nbsp; தேர்ந்தெடுத்த பாடப் பிரிவு அதாவது பொதுக்கல்வி அல்லது தொழிற்கல்வி </div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141;"> <?= $row['offer'] ?> </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:8mm;">&nbsp; The course offered, i.e. General Education <br> <span style="margin-left:2mm"> or Vocational Education</span></div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:111.5mm; float:left; font-size:9px; margin-left:4mm;">(இ)&nbsp;&nbsp; பொதுக்கல்வியாயின் பகுதி-III  தொகுதி (அ)ல் தேர்ந்தெடுத்த விருப்பப் பாடங்கள்
<br><b style="margin-left:6mm; font-weight:lighter;"> மற்றும் போதனா மொழி</b></div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141;"> <?= $row['generaleducation'] ?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:8mm;">&nbsp; In the case of General Education the Subjects offered under
<br><b style="margin-left:2mm; font-weight:lighter;"> part-III Group-A and Medium or Instruction</b></div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:111.5mm; float:left; font-size:9px; margin-left:4mm;">(ஈ)&nbsp;&nbsp; தொழிற் கல்வியின் பகுதி-III  தொகுதி (ஆ)ல் தேர்ந்தெடுத்த தொழிற்பாடம் 
<br><b style="margin-left:6mm; font-weight:lighter;">பகுதி-3  தொகுதி (அ) எடுத்த தொடர்புடைய பாடம்</b></div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141;"> <?= $row['vocationaleducation'] ?>   </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:8mm;">&nbsp; In the case of Vocational Education the Vocational 
<br><b style="margin-left:2mm; font-weight:lighter;"> Subject under part-III group-B and the 
<br><b style="margin-left:2mm; font-weight:lighter;">related subject offered under part-III Group-(A)</b></b></div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left;">
<div style="width:111.5mm; float:left; font-size:9px; margin-left:4mm;">(உ)&nbsp;&nbsp; பகுதி 1ல் தேர்ந்தெடுத்த மொழி</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141;"> <?= $row['Languageoffer'] ?> </div>
</div>
<div style="width:195.75mm; float:left;">
<div style="width:112.5mm; float:left; margin-left:8mm;">&nbsp; Language offered under PartI</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:111.5mm; float:left; margin-left:4mm; font-size:9px;">(ஊ)&nbsp;&nbsp; பயிற்று மொழி</div>
<div style="width:3.5%; float:left"> -- </div><div style=" width:72.4mm; float:left; border-bottom:1px dashed #424141;"> <?= $row['med_ins1']?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:9mm; font-size:12px;">&nbsp; Medium of Study</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>
<?php } ?>

<div style="width:195.75mm; height:335.36mm; min-height:335.36mm; max-height:335.36mm; font-size:14px; font-weight:lighter;">

<div style="width:195.75mm; float:left">
<div style="width:116.45mm; float:left; font-size:9px; padding-top:6px;">11)&nbsp; மேல் வகுப்பிற்கு உயர்வு பெறத் தகுதியுடையவரா என்பது</div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?php if($row['q_std']!="Select"){ echo $row['q_std']; } else { echo "&nbsp;&nbsp;&nbsp;"; }?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:111.45mm; float:left; margin-left:4mm">Whether qualified for promotion to higher standard</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:117.5mm; float:left; font-size:9px; padding-top:6px;">12)&nbsp; பள்ளிக்குச் செலுத்த வேண்டிய கட்டண தொகை
<br><b style="margin-left:4mm; font-weight:lighter;"> அனைத்தையும் மாணவர் செலுத்திவிட்டாரா?</b></div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?= $row['due_school']?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:4mm;"> Whether the pupil has paid all the fees due to the school?</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:117.5mm; float:left; font-size:9px; padding-top:6px;">13)&nbsp; மாணவர் படிப்பதவித்தொகை (அ) கல்வி சலுகை எதுவும்
<br><b style="margin-left:4mm; font-weight:lighter"> பெற்றவரா? அதன் விவரம் குறிப்பிடு </b></div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;">   <?php echo $row['scholarship'].' - '.$row['scholarshipreson']?>    </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:4mm;"> Whether the pupil has in receipt of any Scholarship (Nature of the
<br> Scholarship to be specified) or any Educational Concessions.</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:117.5mm; float:left; font-size:9px; padding-top:6px;">14)&nbsp; மாணவர் பள்ளி வருடத்தில் மருத்துவ ஆய்விற்குச் சென்றவரா?
<br><b style="margin-left:4mm; font-weight:lighter">(முதல் தடவை அல்லது அதற்குமேல் குறிப்பிட்டு எழுதவும்)</b></div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?php if($row['medicalissue']!=""){echo $row['medicalissue'];} else { echo "&nbsp;&nbsp;--&nbsp;&nbsp;";}?>   </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:4mm;"> Whether the pupil has undergone Medical Inspection, if any
<br> during the academic year (First or repeat to be specified)</div>
<div style="width:78.3mm; float:left;"><?php if($row['medicalissue_reson']!=""){ echo $row['medicalissue_reson'];} else { echo "&nbsp;&nbsp;--&nbsp;&nbsp;"; } ?></div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:117.5mm; float:left; font-size:9px; padding-top:6px;">15)&nbsp; மாணவர் பள்ளியை விட்டு விலகிய தேதி</div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?= $row['last_attn']?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:4mm;"> Date on which the Pupil actually left the School</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:117.5mm; float:left; font-size:9px; padding-top:6px;">16)&nbsp; மாணவரின் ஒழுக்கமும் பண்பும்</div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?= $row['conduct'] ?>  </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:4mm;"> The Pupil's Conduct and Character</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left">
<div style="width:117.5mm; float:left; font-size:9px; padding-top:6px;">17)&nbsp; பெற்றோர் அல்லது பாதுகாவலர் மாணவரின் மாற்று சான்றிதழ்
<br><b style="margin-left:4mm; font-weight:lighter"> கோரி விண்ணப்பித்த தேதி</b></div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?= $row['dtc']?>    </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:4mm;"> Date on which application for Transfer Certificate was made on
<br> behalf on the pupil by his / her Parent or Guardian</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left;">
<div style="width:117.5mm; float:left; padding-top:6px; font-size:10px;">18)&nbsp; மாற்றுச்சான்றிதழ் தேதி</div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; border-bottom:1px dashed #424141; padding-top:6px;"> <?= $row['dtc1']?>    </div>
</div>
<div style="width:195.75mm; float:left; font-size:14px;">
<div style="width:111.5mm; float:left; margin-left:5mm;"> Date of the Transfer Certificate</div>
<div style="width:78.3mm; float:left;">&nbsp;</div>
</div>

<div style="width:195.75mm; float:left; font-size:10px;">
<div style="width:117.5mm; float:left; padding-top:6px; font-size:10px;">19)&nbsp; படிப்புக்காலம் <br> <b style="font-weight:lighter; font-size:14px; margin-left:5mm">(Course of Study)</b></div>
<div style="width:78.3mm; float:left; padding-top:6px;">&nbsp;</div>
</div>

<div style="width:195.75mm; font-weight:lighter;">
<table style="border:1px solid #999; border-collapse:collapse; font-size:12px; width:195.75mm; float:left; font-weight:lighter;">
    <tr style="width:195.75mm;border:1px solid #999; border-collapse:collapse;">
    <th style="width:40%;border:1px solid #999; border-collapse:collapse;">பள்ளியின் பெயர்<br>Name of the School</th>
    <th style="width:15%;border:1px solid #999; border-collapse:collapse;">கல்வி ஆண்டு<br>Academic <br> Year(s)</th>
    <th style="width:15%;border:1px solid #999; border-collapse:collapse;">படித்த வகுப்பு<br>Standard(s) <br> Studied</th>
    <th style="width:15%;border:1px solid #999; border-collapse:collapse;">இரண்டாம் மொழி<br>Second Language</th>
    <th style="width:15%;border:1px solid #999; border-collapse:collapse;">பயிற்று மொழி<br>Medium of<br> Instruction</th>
    </tr>

    <tr style="width:195.75mm;">
    <th style="width:40%; border-right:1px solid #999; font-weight:bold; font-size:14px;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    </tr>

    <tr style="width:195.75mm;">
    <th style="width:40%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    </tr>
    <tr style="width:195.75mm;">
    <th style="width:40%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    </tr>
    <tr style="width:195.75mm;">
    <th style="width:40%; border-right:1px solid #999;">CHRIST MATRICULATION <br> HR. SEC. SCHOOL</th>
    <th style="width:15%; border-right:1px solid #999;"><?php echo $row['academic_year']; ?></th>
    <th style="width:15%; border-right:1px solid #999;"><?php echo $row['standard']; ?></th>
    <th style="width:15%; border-right:1px solid #999;"><?php echo $row['first_lan']; ?></th>
    <th style="width:15%; border-right:1px solid #999;"><?php echo $row['med_ins1']; ?></th>
    </tr>

    <tr style="width:195.75mm;">
    <th style="width:40%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    </tr>
    <tr style="width:195.75mm;">
    <th style="width:40%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    </tr>
    <tr style="width:195.75mm;">
    <th style="width:40%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    </tr>

    <tr style="width:195.75mm;">
    <th style="width:40%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    <th style="width:15%; border-right:1px solid #999;">&nbsp;&nbsp;&nbsp;</th>
    </tr>
</table>
</div>
<?php 
if($standard=="XI" || $standard=="XII") { } else {?>
<div style="width:195.75mm; float:left;padding-top:100px;">
<br><br>
</div>
<?php }	?>
<div style="width:195.75mm; float:left">
<div style="width:117.5mm; float:left; font-size:9px; padding-top:6px;">20)&nbsp;பள்ளி தலைமையாசிரியரின் கையொப்பம்
<br><b style="margin-left:4mm; font-weight:lighter">தேதி மற்றும் பள்ளி முத்திரையுடன் </b></div>
<div style="width:0.5%; float:left; padding-top:6px;"></div><div style=" width:74.4mm; float:left; padding-top:6px;"> &nbsp;&nbsp;&nbsp;   </div>
</div>
<div style="width:195.75mm; float:left">
<div style="width:112.5mm; float:left; margin-left:4mm;"> Signature of the H.M. with date and
<br> with School Seal</div>
<div style="width:40.3mm; float:left; font-weight:bold; margin-left:38mm">PRINCIPAL</div>
</div>

<div style="width:195.75mm; float:left;">
&nbsp; &nbsp;
</div>
<div style="width:195.75mm; float:left; border-top:2px solid #000; padding:0mm 0mm;">
&nbsp; &nbsp;
</div>
<?php if($standard=="XI" || $standard=="XII") { } else {?>
<div style="width:195.75mm; float:left;padding-top:30px;">
<br><br>
</div>

<?php } ?>
<div style="width:195.75mm; cell-padding:1px;font-size:12.5px;line-height:20px;">
<div style="width:195.75mm; float:left">
<b style=" font-size:9px; font-weight:lighter;">குறிப்பு</b> :
1) <b style=" font-size:9px; font-weight:lighter;">தனியார் பள்ளிகளில் வழங்கப்படும் மாற்றுச் சான்றிதழில் “சென்னை பள்ளி கல்வி இயக்குநரால் அங்கீகரிக்கப்பட்டது”
<br><b style="margin-left:15mm; font-weight:lighter;"> என்ற வார்த்தைகள் அச்சிடப்பட்டிருக்க வேண்டும்</b></b><br>
<b style="margin-left:15mm; font-weight:lighter;">School under private management shall have the words "Recognised by the Director of School Educational Madras"
<br><b style="margin-left:15mm; font-weight:lighter;"> pointed in the Transfer Certificate to be issued by them.</b></b><br>
<span style="margin-left:11mm">2) <b style=" font-size:9px; font-weight:lighter;">தனியார் பள்ளிகளில் வழங்கப்படும் மாற்றுச் சான்றிதழில் “சென்னை பள்ளி கல்வி இயக்குநரால் அங்கீகரிக்கப்பட்டது”
<br><b style="margin-left:15mm; font-weight:lighter;"> என்ற வார்த்தைகள் அச்சிடப்படாவிடில் அது செல்லத்தக்கதல்ல</b></b><br>
<b style="margin-left:15mm; font-weight:lighter;">Transfer Certificate issued by the Higher Secondary School under Private management without the words
<br><b style="margin-left:15mm; font-weight:lighter;"> "Recognised by the Director of School Education, Madras" shall not be considered Valid.</b></b></span><br>
<span style="margin-left:11mm">3)<b style=" font-size:9px; font-weight:lighter;"> இச்சான்றிதழில் அழித்தல்கள் மற்றும் நம்பகமற்ற அல்லது மோசடியான திருத்தங்கள் செய்வது சான்றிதழை ரத்து செய்ய வழிவகுப்பதாகும்</b><br>
<b style="margin-left:15mm; font-weight:lighter;">Erasures and unauthent cated of fradulent alterations in the certificate will lead to its calcellation.</b></span><br>
<span style="margin-left:11mm">4)<b style=" font-size:9px; font-weight:lighter;"> பள்ளித் தலைமையாசிரியர் மையினால் கையொப்பமிட வேண்டும். பதிவு செய்யப்பட்டுள்ள விவரங்கள் சரியானவை 
<br><b style="margin-left:15mm; font-weight:lighter;">என்பதற்கு அவரே பொறுப்பானவர்</b></b><br>
<b style="margin-left:15mm; font-weight:lighter;">Should be signed in ink by the head of the institution who will be held responsible for the correctness of the entries.</b></span>
<br>
<span style="margin-left:11mm">5)<b style=" font-size:9px; font-weight:lighter;"> பெற்றோர் அல்லது பாதுகாவலர் அளிக்கும் உறுதிமொழி (DECLARATION BY PARENT OR GUARDIAN)
<br>
<b style="margin-left:15mm; font-weight:lighter;">
மேலே 2 முதல் 7 வரையிலுள்ள இனங்களுக்கெதிரே பதிவு செய்யப்பட்டுள்ள விவரங்கள் சரியானவை என்றும் <br> 
<span style="margin-left:15mm"> எதிர்காலத்தில் அவற்றில் மாற்றம் எதுவும் கேட்க மாட்டேன் என்றும் நான் உறுதியளிக்கிறேன்</span></b></b><br>
<b style="margin-left:15mm; font-weight:lighter;">I hereby declare that the particulars recorded against items 2 to 7 are correct and that no change will be <br> 
<span style="margin-left:15mm"> demanded by me in future.</span></b></span>

<br>
</div>

</div>


<div style="font-size:12.5px;line-height:18px; width:195.75mm; float:left; ">
<?php if($standard=="XI" || $standard=="XII") {  ?>
<div style="width:195.75mm; float:left; padding-top:80px;">
<?php  } else {?>
<div style="width:195.75mm; float:left; padding-top:110px;">
<?php }  ?>
<p><span style=" float:left; font-weight:lighter; margin-right:6%;"><b style=" font-size:9px; font-weight:lighter;">மாணவர் கையொப்பம்</b><br>Student Signature</span></p>
<p><span style=" float:right; font-weight:lighter; margin-right:6%;"><b style=" font-size:9px; font-weight:lighter;">பெற்றோர் அல்லது காப்பாளர் கையொப்பம்</b><br> Signature of the Parent / Guardian</span></p></div>
</div>
</div>
</div>

</body>
<script type="text/javascript">
	window.print();
</script>
</html>
