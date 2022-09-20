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
<title>Seventh-Day Adventist Matric Higher Secondary School</title>
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
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-362px;
	height:400px;
	margin-left:-960px !important;
   
  }
</style>
 <table width="900" height="24" border="0" cellpadding="0" cellspacing="0" id="Table_01">
    <tbody><tr id="butt" style="visibility: visible;">
      <td></td>     
    </tr>
  </tbody></table>
<div style="max-height:500px;">
<div style="margin-top:300px;width:866px;margin-left:4px;"><font size="5" color="#2E2F65">This is to certify that <b><?php echo $row['name']; ?></b> S/o / D/o<b> <?php echo $row['p_name']; ?>  </b>is /was a bonafide student of our institution studying in standard <b> <?php echo $row['standard']; ?></b> during the School year<b> <?php echo $row['year']; ?></b>. His/Her Date of birth as per our school record is <b><?php echo $row['dob']; ?> </b>. </font></div>
<div class="Invitation">
   <img src="img/bon.png" alt="" class="adjusted">
</div>
</div>
  
  
  <p>
    <!-- End ImageReady Slices -->
  </p>
 
  <p>&nbsp;    </p>
</div>

</body></html>