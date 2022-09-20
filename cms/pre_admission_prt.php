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
							$paid=$_GET['paid'];
				$studentlist=mysql_query("SELECT * FROM pre_admission WHERE pa_id=$paid"); 
								  $row=mysql_fetch_array($studentlist);	
								  $cid=$row['c_id'];
					$bid=$row['b_id'];
					
					$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
include("checking_page/admission.php");
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
	 padding-left:20px;
}
.small{font-size:10px;}
.bgcolor{background-color:#D0D0D0;}
</style>    
</head>
<body>
<div style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv"  style="font-size:12.5px; line-height:20px;">
<center>
<img src="img/logo_sms.png" style="width:25%;">
</center>
<table style="width:100%;font-size:12px;line-height:25px;" class="profile-table">
<tbody>
<tr>
<td width="5%">1</td>
<td width="40%" class="bgcolor">Pre Admn.No </td>
<td width="50%" colspan="2"><b><?php echo $row['pa_admission_no']; ?></b></td>
</tr>
<tr>
<td width="5%">2</td>
<td width="40%" class="bgcolor">Name of Student</td>
<td width="50%" colspan="2"><b><?php echo $row['firstname']." ".$row['lastname']; ?></b></td>
</tr>
<tr>
<td width="5%">3</td>
<td width="40%" class="bgcolor">Board / Class</td>
<td width="30%"><b><?php echo $board['b_name']." / ".$class['c_name']; ?></b></td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%" >4</td>
<td width="40%" class="bgcolor">DOB <span class="small">(mm/dd/yyyy)</span></td>
<td width="30%"><b><?php echo $row['dob']; ?></b></td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%" >5</td>
<td width="40%" class="bgcolor">Father / Guardian Name</td>
<td width="30%"><b><?php echo $row['fathersname']; ?></b></td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%" >6</td>
<td width="40%" class="bgcolor">Mother's Name </td>
<td width="30%"><b><?php echo $row['m_name']; ?></b></td>
<td style="border:none;"></td>
</tr>
<tr>
<td width="5%">7</td>
<td width="40%" class="bgcolor">Gender</td>
<td width="30%">
	<b><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></b>
</td>
<td style="border:none;"></td>
</tr>
<tr> 
<td width="5%">8</td>
<td width="40%" class="bgcolor">Religion</td>
<td width="30%"><b><?php echo $row['reg']; ?></b></td>
</tr>
<tr>
<td width="5%" >9</td>
<td width="40%" class="bgcolor">House Address </td>
<td width="50%" colspan="2" height="50px"><b><?php echo $row['address1']; ?></b><br></td>
</tr><tr>
<td width="5%">10</td>
<td width="40%" class="bgcolor">City Name</td>
<td width="50%" colspan="2"><b> <?php echo $row['city_id']; ?></b><br></td>
</tr>
<tr>
<td width="5%">11</td>
<td width="40%" class="bgcolor">Father / Guardian Phone Number</td>
<td width="50%" colspan="2"><b><?php echo $row['phone_number']; ?></b><br></td>
</tr>
<tr>
<td width="5%">12</td>
<td width="40%" class="bgcolor">Additional Phone Numbers</td>
<td width="50%" colspan="2"><b><?php if($row['phone1']){ echo $row['phone1']; } if($row['phone2']){ echo " / ".$row['phone1']; } if($row['phone3']){ echo " / ".$row['phone3']; } ?></b><br></td>
</tr>
</tbody>
</table>
<h6 style="margin-top:5px;">13. Sibling Details </h6>
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
<td>&nbsp;</td>
<td align="right">Signature of Parent</td>
</tr>
</table>
</div>
</body>
</html>