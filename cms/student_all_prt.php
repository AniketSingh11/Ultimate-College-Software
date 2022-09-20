<?php 
include("includes/config.php");

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
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$bid=$_GET['bid'];
							$ayid=$_GET['ayid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$yearlist=mysql_query("SELECT * FROM year WHERE ay_id=$ayid"); 
								  $ayear=mysql_fetch_array($yearlist);	
							 	 
					
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
    <style type="text/css">
.profile-table td{
	 border:1px solid #2D2D2D;
	 padding-left:10px;
}
.small{font-size:10px;}
.bgcolor{background-color:#D0D0D0;}
</style> 
</head>
<body>
<div style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv"  style="font-size:12.5px; line-height:20px;">
<?php 
$studentlist=mysql_query("SELECT * FROM student WHERE `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid' ORDER BY firstname ASC"); 
								  while($row=mysql_fetch_array($studentlist)){	 ?> 
<center>
<img src="img/s_profile_head.png" style="width:100%;">
</center>
<div style="margin-left:32px;font-size:11px;">Admn.No :<b><?php echo $row['admission_number']; ?></b><span style="float:right;margin-right:150px;">EMIS No:</span></div>
<div align="right" style="float:right; position:absolute;left:80%;
margin-top:60px; border:1px solid #000000;"><img src="./img/student/<?php echo strtoupper($row['photo']);?>" alt="student photo" width="100" height="100"></div>
<table style="width:100%;font-size:12px;line-height:18px;" class="profile-table">
<tbody><tr>
<td width="5%">1</td>
<td width="40%" class="bgcolor">School Code <span class="small">(DISE code to be adopted)</span></td>
<td width="50%" colspan="2"><b><?php echo $board['s_code']; ?></b></td>
</tr>
<tr>
<td width="5%">2</td>
<td width="40%" class="bgcolor">Name of Student</td>
<td width="50%" colspan="2"><b><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></b></td>
</tr>
<tr>
<td width="5%" >3</td>
<td width="40%" class="bgcolor">DOB <span class="small">(mm/dd/yyyy)</span></td>
<td width="30%"><b><?php echo $row['dob']; ?></b></td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%">4</td>
<td width="40%" class="bgcolor">Gender</td>
<td width="30%">
	<b><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></b>
</td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%">5</td>
<td width="40%" class="bgcolor">Class</td>
<td width="30%"><b><?php echo $class['c_name']."-".$section['s_name'];?></b></td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%">6</td>
<td width="40%" class="bgcolor">Medium</td>
<td width="30%"><b><?php echo $board['medium']; ?> </b></td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%">7</td>
<td width="40%" class="bgcolor">Group Code <span class="small">(for HSC only)</span></td>
<td width="30%"><b></b></td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%">8</td>
<td width="40%" class="bgcolor">Nationality</td>
<td width="50%" colspan="2"><b><?php echo $row['nation']; ?></b></td>
</tr>
<tr> 
<td width="5%">9</td>
<td width="40%" class="bgcolor">Religion</td>
<td width="50%" colspan="2"><b><?php echo $row['reg']; ?></b></td>
</tr>
<tr>
<td width="5%">10</td>
<td width="40%" class="bgcolor">Community</td>
<td width="50%" colspan="2"><b><?php echo $row['caste']; ?></b></td>
</tr>
<tr>
<td width="5%">11</td>
<td width="40%" class="bgcolor">Sub Caste</td>
<td width="50%" colspan="2"><b><?php echo $row['sub_caste']; ?></b></td>
</tr>
<tr>
<td width="5%">12</td>
<td width="40%" class="bgcolor" >Mother Tongue</td>
<td width="50%" colspan="2"><b><?php echo $row['mother_tongue']; ?></b></td>
</tr>
<tr>
<td width="5%">13</td>
<td width="40%" class="bgcolor">Mother's Name</td>
<td width="50%" colspan="2"><b><?php echo $row['m_name']; ?>  </b></td>
</tr>
<tr>
<td width="5%">14</td>
<td width="40%" class="bgcolor">Mother's Occupation</td>
<td width="50%" colspan="2"><b><?php echo $row['m_occup']; ?> </b><br></td>
</tr>
<tr>
<td width="5%">15</td>
<td width="40%" class="bgcolor">Mother's monthly income</td>
<td width="50%" colspan="2"><b><?php echo $row['m_income']; ?> </b><br></td>
</tr>
<tr>
<td width="5%">16</td>
<td width="40%" class="bgcolor">Father's Name</td>
<td width="50%" colspan="2"><b><?php echo $row['fathersname']; ?> </b><br></td>
</tr>
<tr>
<td width="5%">17</td>
<td width="40%" class="bgcolor">Father's Occupation</td>
<td width="50%" colspan="2"><b><?php echo $row['fathersocupation']; ?> </b><br></td>
</tr>
<tr>
<td width="5%">18</td>
<td width="40%" class="bgcolor">Father's monthly income</td>
<td width="50%" colspan="2"><b><?php echo $row['p_income']; ?> </b><br></td>
</tr>
<tr>
<td width="5%">19</td>
<td width="40%" style="line-height:16px;" class="bgcolor">If differently-abled-type of disability <span class="small">(tic appropriate)</span></td>
<td width="50%" colspan="2"><b>Ortho / Blind / Deaf / None of this </b><br></td>
</tr>
<td width="5%">20</td>
<td width="40%" style="line-height:16px;" class="bgcolor">If belongs to disadvaantaged group <span class="small">(tic appropriate)(Ref: G.O Ms.No.180 Dt 15-11-2011)</span></td>
<td width="50%" colspan="2"><b> Orphan / HIV Affected / Transgender / Child of a Scavenger / None of this</b><br></td>
</tr>
<tr>
<td width="5%" >21</td>
<td width="40%" class="bgcolor">House Address with pin-code</td>
<td width="50%" colspan="2" height="50px"><b><?php echo $row['address1']; ?></b><br></td>
</tr><tr>
<td width="5%">22</td>
<td width="40%" class="bgcolor">Native District</td>
<td width="50%" colspan="2"><b> <?php echo $row['city_id']; ?></b><br></td>
</tr>
<tr>
<td width="5%">24</td>
<td width="40%" class="bgcolor">Attendance status</td>
<td width="50%" colspan="2"><b></b><br></td>
</tr>
<tr>
<td width="5%">25</td>
<td width="40%" class="bgcolor">Sports participation</td>
<td width="50%" colspan="2"><b></b><br></td>
</tr>
<tr>
<td width="5%">26</td>
<td width="40%" class="bgcolor">Contact Phone Number</td>
<td width="50%" colspan="2"><b><?php echo $row['phone_number']; ?></b><br></td>
</tr>
<tr>
<td width="5%">27</td>
<td width="40%" class="bgcolor">Blood Group</td>
<td width="50%" colspan="2"><b><?php echo $row['blood']; ?></b><br></td>
</tr>
<tr>
<td width="5%">28</td>
<td width="40%" class="bgcolor">Height And Weight</td>
<td width="50%" colspan="2"><b></b><br></td>
</tr>
</tbody>
</table>
<h6 style="margin-top:5px;">29. Sibling Details </h6>
<table style="width:100%;font-size:12px;line-height:18px; margin-top:-18px;" class="profile-table">
<tbody>
<tr>
<td class="bgcolor">S.No</td>
<td width="40%" class="bgcolor" >Name</td>
<td class="bgcolor" >DOB</td>
<td class="bgcolor">Qualification</td>
<td class="bgcolor">Whether Employed (Yes/No)</td>
</tr>
<tr>
<td height="20px"></td>
<td width="40%"></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td height="20px"></td>
<td width="40%"></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td height="20px"></td>
<td width="40%"></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td height="20px"></td>
<td width="40%"></td>
<td></td>
<td></td>
<td></td>
</tr>
</tbody></table>
<table style="width:100%;font-size:12px; margin-top:40px;"> 
<tr>
<td>Signature of the Principal with Seal</td>
<td>Signature of Parent</td>
</tr>
</table>
<?php } ?>
</div>
</body>
</html>