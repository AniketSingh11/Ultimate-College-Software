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
							$sxid=$_GET['sxid'];
							$stafflist=mysql_query("SELECT * FROM samacheer_x WHERE id=$sxid"); 
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

<div id="printablediv" style="font-size:12px; line-height:20px;">
<div style="margin-left:32px;font-size:11px;">EMIS.No :<b><?php echo $row['eno']; ?></b></div><div style="float:right;margin-right:100px;margin-top:-12px;font-size:11px;">X Marksheet No:<b><?php echo $row['xmno']; ?></b></div>
<img src="img/xsam.png" style="width:100%;">

<div style="margin-left:32px;font-size:11px;">Admn.No :<b><?php echo $row['ano']; ?></b></div><div style="float:right;margin-right:165px;margin-top:-17px;font-size:11px;">T C.No:<b><?php echo $row['tno']; ?></b></div>
<table style="width:100%;border:1px solid black;height:100%;cell-padding:1px; margin-top:10px;line-height:20px; ">

</table><table style="width:100%;font-size:12.5px;line-height:22px;">
<tbody><tr>
<td width="40%">1) a) Name of the School</td>
<td width="50%">: <b>Seventh-Day Adventist Matriculation </b></td>
</tr>
<tr>
<td width="40%">&nbsp;</td>
<td width="50%">&nbsp;&nbsp;<b>Higher Secondary School</b><br></td>
</tr>
<tr>
<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;b) Name of the Educational District </td>
<td width="50%">:<b> Madurai</b><br></td>
</tr>

<tr>
<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;c) Name of the Revenue District</td>
<td width="50%">: <b>Madurai</b><br></td>
</tr>

<tr>
<td width="40%">2) Name of the Pupil(in Block Letters)</td>
<td width="50%">:<b> <?php echo $row['sname']; ?></b><br></td>
</tr>

<tr>
<td width="40%">3) Name of the Father or Mother of the Pupil</td>
<td width="50%">: <b><?php echo $row['fname']; ?></b><br></td>
</tr>

<tr>
<td width="40%">4) Nationality, Religion and Caste</td>
<td width="50%">:<b> <?php echo $row['nation']; ?></b><br></td>
</tr>



<tr>
<td width="40%">5) Community<br>&nbsp;&nbsp;&nbsp;&nbsp;Whether he / she belongs to</td>
<td width="50%">: <b><?php echo $row['community']; ?></b><br></td>
</tr>



<tr>
<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;a) Adi Dravidar (Scheduled Caste) or<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Scheduled Tribe)</td>
<td width="50%">:<b> <?php echo $row['adidravidar']; ?></b><br></td>
</tr>


<tr>
<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;b) Backward Class</td>
<td width="50%">:<b> <?php echo $row['bc']; ?></b><br></td>
</tr>


<tr>
<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;c) Most Backward Class</td>
<td width="50%">:<b> <?php echo $row['mbc']; ?></b><br><br></td>
</tr>


<tr>
<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;d) Convert to Christianity from<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Scheduled Caste or</td>
<td width="50%">:<b> <?php echo $row['convert_christ']; ?></b><br></td>
</tr>


<tr>
<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;e) Denotified Communities</td>
<td width="50%">: <b><?php echo $row['de_community']; ?></b><br><br></td>
</tr>
</tbody></table><font style="font-size:12.5px;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If the Pupil belongs to any of the five categories mentioned above, write"Yes against the relevant item and also indicate the particular community to which he/she belongs"<br></font>
<table style="width: 100%;font-size:12.5px;line-height:22px;">
<tbody><tr>
<td width="40%">6) Sex</td>
<td width="50%"><br>: <b><?php echo $row['sex']; ?></b><br></td>
</tr>

<tr>
<td width="40%">7) Date of birth as entered in the Admission<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Register (in figures &amp; words)</td>
<td width="50%"><br>:<b> <?php echo $row['dob']; ?></b><br></td>
</tr>
<tr>
<td width="40%">8) Personal marks of Identification</td>
<td width="50%">: <b><?php echo $row['identity1']; ?></b><br></td>
</tr>

<tr>
<td width="40%">&nbsp;</td>
<td width="50%">&nbsp;&nbsp;<b><?php echo $row['identity2']; ?></b><br></td>
</tr>

<tr>
<td width="40%">9) Date of Admission and standard in which<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;admitted (the year to be entered, in words)</td>
<td width="50%"><br>:<b> <?php echo $row['doa']; ?></b><br></td>
</tr>

<tr>
<td width="40%">10) Standard in which the pupil was studying<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;at the time of leaving (in words)</td>
<td width="50%">: <b><?php echo $row['leaving']; ?></b><br><br></td>
</tr>
<tr><td width="40%">11) Whether qualified for promotion to <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Higher Standard</td>
<td width="50%"><br>: <b><?php echo $row['edu_rule']; ?></b><br></td>
</tr>
<tr>
<td width="40%">12) Whether the pupil was in receipt of any<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;scholarship (Nature of the Scholarship<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to be specified)</td>
<td width="50%"><br>:<b> Yes / No</b><br></td>
</tr>
<tr>
<td width="40%">13) Whether the pupil has undergone Medical<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inspection if any during the academic year<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(First or Repeat to be specified)</td>
<td width="50%">:<b> Yes / No</b><br></td>
</tr>
<tr>
<td width="40%">14) Date on which the pupil actually left the<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;School.</td>
<td width="50%"><br>: <b><?php echo $row['school_left']; ?></b><br></td>
</tr>


<tr>
<td width="40%">15) The pupil's conduct and character</td>
<td width="50%"><br>:<b> <?php echo $row['conduct']; ?></b><br></td>
</tr>


<tr>
<td width="40%">16) Date on which application for transfer<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;certificate was made on behalf of the pupil<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;by the parent or guardian</td>
<td width="50%">: <b><?php echo $row['guardian']; ?></b></td>
</tr>


<tr>
<td width="40%"><br>17) Date of the Transfer Certificate</td>
<td width="50%"><br>: <b><?php echo $row['dtc']; ?></b></td>
</tr>


<tr>
<td width="40%"><br>18) Course of study</td>
<td width="50%">:<b> <?php echo $row['course']; ?></b><br></td>
</tr>




</tbody></table>

<table width="100%" style="font-size:12.5px; text-align:center;border:1px solid black;line-height:22px;">
<tbody><tr>
<td style="font-weight:bold;height:40px;">Name of the School</td>
<td style="font-weight:bold;height:40px;">Academic Year(s)</td>
<td style="font-weight:bold;height:40px;">Standard (s) Studied</td>
<td style="font-weight:bold;height:40px;">First Language</td>
<td style="font-weight:bold;height:40px;">Medium of Instruction</td>
</tr>
<tr><td colspan="5"><hr></td></tr>

<tr>

<td width="5%" style="font-size:12.5px;padding:10px;font-weight:bold;"><b>Seventh-Day Adventist Matric Hr.Sec.School, Madurai -10.</b></td>
<td width="10%" style="font-size:12.5px;padding:10px;"><b><?php echo $row['academic_year']; ?></b></td>
<td width="10%" style="font-size:12.5px;padding:10px;"><b><?php echo $row['standard']; ?></b></td>
<td width="10%" style="font-size:12.5px;padding:10px;"><b>Tamil<br>Hindi</b></td>
<td width="10%" style="font-size:12.5px;padding:10px;"><b>English</b></td>

</tr>
</tbody></table> 


<table style="width:100%;cell-padding:1px;font-size:12.5px;line-height:22px; ">
<tbody><tr>
<td width="40%">20) Signature of the Headmaster<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;with date and with school seal.</td>
<td width="50%"><br>: <br><br></td>
</tr>
</tbody></table><br>
<table style="width:98%;margin-left:26px;cell-padding:1px;font-size:12.5px;line-height:18px; ">
<tbody><tr>
<td valign="top">
Note:
</td>
<td>

1) Erasures and unauthenticated or fraudulent alteration in the certificate will lead to its cancellation.<br>
2) Should be signed in ink by the head of the institution who will be held responsible for the correctness of the entries.<br>
</td>
</tr>
</tbody></table> 
<center><b style="font-weight:bold;font-size:12.5px;">DECLARATION BY PARENT OR GUARDIAN</b></center><br>
<div style="margin-left:50px;font-size:12.5px;">
I hereby declare that the particulars recorded against items 2 to 7 are correct and that no change will be demanded by me in future.<br><br>
Received the following document: 1. Std X Original Mark sheet.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Original Transfer Certificate.<br><br>

<p>Signature of the Student <span style=" float:right">Signature of the Parent / Guardian</span></p>
</div>
</div>
</body></html>