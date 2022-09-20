<?php 
include("includes/config.php");

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
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$ssid=$_GET['ssid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	 $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $row=mysql_fetch_array($studentlist);	 
					
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Seventh-Day Adventist Matric Higher Secondary School</title>
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
<div style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv"  style="font-size:12.5px; line-height:20px;">
<center>
<img src="img/s_detail_head.png" style="width:100%;">
</center>
<div style="margin-left:32px;font-size:11px;">Admn.No :<b><?php echo $row['admission_number']; ?></b></div>
<div align="right" style="float:right; position:absolute;left:80%;
top:150px;"><img src="./img/student/<?php echo $row['photo'];?>" alt="student photo" width="60" height="60"></div>
<table  style="width:100%;border:1px solid black;height:100%;cell-padding:1px; margin-top:10px;line-height:20px; ">

<table style="width:100%;font-size:12.5px;line-height:25px;">
<tr >
<td width="40%">First Name of Pupil </td>
<td width="50%" >: <b><?php echo $row['firstname']; ?></b></td>
</tr>
<tr >
<td width="40%">Middle Name of Pupil </td>
<td width="50%">:<b><?php echo $row['lastname']; ?></b></td>
</tr>
<tr  >
<td width="40%">Last Name of Pupil </td>
<td width="50%">: <b><?php echo $row['middlename']; ?></b></td>
</tr>

<tr>
<td width="40%">Name of Parent / Guardian :</td>
<td width="50%">: <b><?php echo $row['fathersname']; ?></b></td>
</tr>

<tr>
<td width="40%">Standard & School from which pupil has come</td>
<td width="50%">: <b><?php echo $row['from_school']; ?></b></td>
</tr>

<tr>
<td width="40%">Whether an ESLC issued by the Dept. was produced on admission </td>
<td width="50%">: <b><?php echo $row['eslc']; ?></b></td>
</tr>

<tr>
<td width="40%">Whether a T.C. from a secondary school was produced on admission </td>
<td width="50%">: <b><?php echo $row['tc']; ?></b></td>
</tr>



<tr> 
<td width="40%">Date of admission</td>
<td width="50%">: <b><?php echo $row['doa']; ?></b></td>
</tr>

<tr>
<td width="40%">Date Of Birth</td>
<td width="50%">: <b><?php echo $row['dob']; ?></b></td>
</tr>


<tr>
<td width="40%">Gender</td>
<td width="50%">: <b><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></b></td>
</tr>


<tr>
<td width="40%">Whether protected from small-pox or not </td>
<td width="50%">: <b><?php echo $row['protected']; ?></b></td>
</tr>


<tr>
<td width="40%">Nationality & state to which the pupil belongs</td>
<td width="50%">: <b><?php echo $row['nation']; ?></b></td>
</tr>


<tr>
<td width="40%">Religion</td>
<td width="50%">: <b><?php echo $row['reg']; ?></b><br></td>
</tr></table>
<table style="width: 100%;font-size:12.5px;">
<tr>
<td width="40%">Caste</td>
<td width="50%">: <b><?php echo $row['caste']; ?></b></td>
</tr>

<tr>
<td width="40%">Subcaste</td>
<td width="50%"><br>: <b><?php echo $row['sub_caste']; ?></b></td>
</tr>
<tr>
<td width="40%">Blood Group</td>
<td width="50%"><br>: <b><?php echo $row['blood']; ?></b></td>
</tr>

<tr>
<td width="40%">Email</td>
<td width="50%">:<b><?php echo $row['email']; ?></b></td>
</tr>

<tr>
<td width="40%">Phone</td>
<td width="50%">: <b><?php echo $row['phone_number']; ?></b></td>
</tr>

<tr>
<td width="40%">Residence Address1</td>
<td width="50%">: <b><?php echo $row['address1']; ?></b></td>
</tr>
<tr>
<td width="40%">Residence Address2 </td>
<td width="50%">: <b><?php echo $row['address2']; ?></b></td>
</tr>
<tr>
<td width="40%">Town or village Name</td>
<td width="50%">:<b> <?php echo $row['city_id']; ?></b></td>
</tr>
<tr>
<td width="40%">Country</td>
<td width="50%">: <b><?php echo $row['country']; ?></b></td>
</tr>
<tr>
<td width="40%">Pin Code</td>
<td width="50%">: <b><?php echo $row['pin']; ?></b></td>
</tr>
<tr>
<td width="40%">Mother Tongue of the Pubil</td>
<td width="50%">: <b><?php echo $row['mother_tongue']; ?></b></td>
</tr>
<tr>
<td width="40%">Std. on leaving </td>
<td width="50%"> <?php echo $row['std_leaving']; ?></td>
</tr>
<tr>
<td width="40%">No. & Date of Transfer Certificate produced </td>
<td width="50%"><br>: <b><?php echo $row['no_date_tran']; ?></b><br></td>
</tr>
<tr>
<td width="40%">Date of leaving</td>
<td width="50%">: <b><?php echo $row['dol']; ?></b><br></td>
</tr>
<tr>
<td width="40%">Reason for leaving</td>
<td width="50%">: <b><?php echo $row['reason_leaving']; ?></b><br></td>
</tr>
<tr>
<td width="40%">School to which the pubil has gone</td>
<td width="50%">: <b><?php echo $row['school_pubil']; ?></b><br></td>
</tr>
<tr>
<td width="40%">Remarks</td>
<td width="50%">: <b><?php echo $row['remarks']; ?></b><br></td>
</tr>
</table>
</div>
</body>
</html>