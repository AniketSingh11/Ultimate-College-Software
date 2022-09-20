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
							$stid=$_GET['stid'];
							$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
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
<div style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv"  style="font-size:12.5px; line-height:20px;">
<center>
<img src="img/st_detail_head.png" style="width:100%;">
</center>
<div style="margin-left:32px;font-size:11px;">Staff ID :<b><?php echo $row['staff_id']; ?></b></div>
<?php $image=$row['photo']; if($image =='mstaff_small.png' || $image =='fstaff_small.png'){ }else{?> 
<div align="right" style="float:right; position:absolute;left:80%;
top:150px;"><img src="./img/staff/<?php echo $row['photo'];?>" alt="staff photo" width="60" height="60"></div> <?php  } ?>
<table  style="width:100%;border:1px solid black;height:100%;cell-padding:1px; margin-top:10px;line-height:20px; ">
<table style="width:100%;font-size:12.5px;line-height:25px;">
<tr >
<td width="40%">First Name </td>
<td width="50%" >: <b><?php echo $row['fname']; ?></b></td>
</tr>
<tr >
<td width="40%">Middle Name </td>
<td width="50%">:<b><?php echo $row['mname']; ?></b></td>
</tr>
<tr  >
<td width="40%">Last Name </td>
<td width="50%">: <b><?php echo $row['lname']; ?></b></td>
</tr>
<tr>
<td width="40%">Staff Type</td>
<td width="50%">: <b><?php echo $row['s_type']; ?></b></td>
</tr>
<tr>
<td width="40%">Father's Name :</td>
<td width="50%">: <b><?php echo $row['s_pname']; ?></b></td>
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
<td width="40%">Religion</td>
<td width="50%">: <b><?php echo $row['reg']; ?></b></td>
</tr>

<tr>
<td width="40%">Blood Group</td>
<td width="50%">: <b><?php echo $row['blood']; ?></b></td>
</tr>


<tr>
<td width="40%">Position</td>
<td width="50%">: <b><?php echo $row['position']; ?></b></td>
</tr>


<tr>
<td width="40%">Expriences</td>
<td width="50%">: <b><?php echo $row['expriences']; ?></b></td>
</tr>


<tr>
<td width="40%">Email</td>
<td width="50%">: <b><?php echo $row['email']; ?></b></td>
</tr>


<tr>
<td width="40%">Phone No </td>
<td width="50%">: <b><?php echo $row['phone_no']; ?></b><br></td>
</tr></table>
<table style="width: 100%;font-size:12.5px;">
<tr>
<td width="40%">Residence Address1 </td>
<td width="50%">: <b><?php echo $row['address1']; ?></b></td>
</tr>

<tr>
<td width="40%">Residence Address2</td>
<td width="50%"><br>: <b><?php echo $row['address2']; ?></b></td>
</tr>
<tr>
<td width="40%">Town or village Name</td>
<td width="50%"><br>: <b><?php echo $row['city']; ?></b></td>
</tr>

<tr>
<td width="40%">Country</td>
<td width="50%">: <b><?php echo $row['country']; ?></b></td>
</tr>

<tr>
<td width="40%">Pin Code</td>
<td width="50%">: <b><?php echo $row['pincode']; ?></b></td>
</tr>
</table>
</div>
</body>
</html>