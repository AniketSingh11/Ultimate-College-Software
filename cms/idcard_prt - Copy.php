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
					
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>School Management Solution</title>
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

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<style type="text/css">
  img.adjusted {
    position: absolute;
    z-index: -1;
  }
  .idcard{
	  background:url(img/idcard1.png) top left no-repeat;
	  text-align:left;
	  padding-bottom:10px;
	  }
.idcard1{
	  background:url(img/idcard-single-back.png) top left no-repeat;
	  text-align:left;
	  padding-bottom:10px;
	  }	  
  .Invitation {
    position: relative;
    width: 950px;
    /*margin-top:-362px;*/
	height:400px;
	margin-left:-960px !important;
   
  }
</style>
 <table width="900" border="0" cellpadding="0" cellspacing="0" id="Table_01">
    <tbody><tr id="butt" style="visibility: visible;">
      <td></td>     
    </tr>
  </tbody></table>
  
  <table width="950" border="0" cellpadding="0" cellspacing="0" id="Table_01">
    <tbody>
    <tr>
      <td width="428px" height="268px" class="idcard">
      	<table>
        <tr>
        	<td>
            <table width="305px" border="0" cellpadding="0" style="margin-left:20px; margin-top:30px; font-size:16px; font-weight:600;color:#056e9a;line-height:20px;">
        <tr>
        	<td width="100px">Admission No</td>
            <td> : </td>
            <td width="200px">LKGA001</td>
        </tr>
        <tr>
        	<td width="100px">Student Name</td>
            <td> : </td>
            <td width="200px">Kamaraj M</td>
        </tr>
        <tr>
        	<td width="100px">Class</td>
            <td> : </td>
            <td width="200px">LKG - A</td>
        </tr>
        <tr>
        	<td width="100px">Gender</td>
            <td> : </td>
            <td width="200px">Male</td>
        </tr>
        <tr>
        	<td width="100px">Parent Name</td>
            <td> : </td>
            <td width="200px">Madhesan</td>
        </tr>
        <tr>
        	<td width="100px">Board</td>
            <td> : </td>
            <td width="200px">Samacheer</td>
        </tr>
        </table>
            </td>
            <td>
            <span style="font-size:18px; color:#056e9a; font-weight:bold; text-align:center; margin-left:5px;">2014 - 2015</span>
            <img style="margin-left:10px;border:solid 2px #000;" src="img/student/LKGA001.jpg" alt="Student photo" width="75" height="92"/>           
            
            </td>
        </tr>
        </table>
      </td>
      <td width="428px" height="268px" class="idcard1">
      	<table>
        <tr>
        	<td>
            <table width="305px" border="0" cellpadding="0" style="margin-left:20px; margin-top:-60px; font-size:16px; font-weight:600;color:#056e9a;line-height:20px;">
 		<tr>
        	<td width="100px">Phone No</td>
            <td> : </td>
            <td width="200px">9751331791</td>
        </tr>            
         <tr>
        	<td width="100px">DOB</td>
            <td> : </td>
            <td width="200px">24/04/1988</td>
        </tr>
         <tr>
        	<td width="100px">Blood Group</td>
            <td> : </td>
            <td width="200px">A1B +'ve</td>
        </tr>
        <tr>
        	<td width="100px">Address</td>
            <td> : </td>
            <td width="200px">70,Kamaraj Salai Chennai</td>
        </tr>
        <tr>
        	<td width="100px">Valid Date</td>
            <td> : </td>
            <td width="200px">2014 - 2015</td>
        </tr>
        <tr>
        	<td width="100px"></td>
            <td>  </td>
            <td width="200px"></td>
        </tr>
        <tr>
        	<td colspan="3"><center><img style="margin-left:10px;" src="img/0fedzcPQ.png" alt="bar code"  width="150"/></center> </td>
        </tr>
        </table>
            </td>
            <td>
            </td>
        </tr>
        </table>
      </td>          
    </tr>    
    
  </tbody></table>
  <p>
    <!-- End ImageReady Slices -->
  </p>
 
  <p>&nbsp;    </p>
</div>

</body></html>