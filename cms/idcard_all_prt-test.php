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

	  $bid=mysql_real_escape_string($_GET['bid']);
	  $ayid=mysql_real_escape_string($_GET['ayid']);
	  
	  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$yearlist=mysql_query("SELECT * FROM year WHERE ay_id=$ayid"); 
								  $ayear=mysql_fetch_array($yearlist);	
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
<style type="text/css">
#print{
	position:absolute;
	}
  img.adjusted {
    position: absolute;
    z-index: -1;
  }
  .idcard{
	  background:url(img/staff_idfront.jpg) top left no-repeat;
	  padding-bottom:40px;
	  }
.idcard1{
	  background:url(img/staff_idback.jpg) top left no-repeat;
	  padding-bottom:40px;
	  }	  
 
</style>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  <table width="950" border="0" cellpadding="0" cellspacing="0" id="Table_01" style="font-family:ubuntu-condensed">
    <tbody>
    <?php 
	$classl = mysql_query("SELECT c_id,c_name FROM class WHERE b_id='$bid' AND ay_id='$ayid'");
	while ($class = mysql_fetch_assoc($classl)){
		$cid=$class['c_id'];
		$sectionlist=mysql_query("SELECT * FROM section WHERE c_id='$cid' AND ay_id='$ayid'");
	while ($section=mysql_fetch_assoc($sectionlist)){
				$sid=$section['s_id'];	
		$sql = "SELECT * FROM student where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'";
$query = mysql_query($sql);
	while($rs = mysql_fetch_array($query)) { ?>
    <tr style="max-height:428px;">
      <td style="width:138px; height:428px;">&nbsp;</td>
      <td width="268px" height="428px" class="idcard">
      	<div style="width:268px; height:428px;">
              <h2 style="text-align:center; font-size:28px; margin-right:25px; padding:0px; margin:0px; margin-top:5px; color:#eafc4e;text-shadow: 3px 1px #000;">SP Modern School</h2>
              <h5 style=" font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace;
               margin-right:22px; float:right; padding:0px; margin-bottom:0px; margin-top:0px; color:#c91088;">Learn well. Fly High...</h5>
              <h3 style="text-align:center; font-size:16px; color:#834e96; margin-left:6%; ">ISO 9001 - 2008 Certified Institution</h3>
                  <div style="text-align:center; float:left; font-size:14px; margin-top:15%; font-weight:bold; margin-left:2%;">
<pre style="font-size:12px;">D.O.B
26-MAR-1960</pre>
                  </div>
                  <div style="text-align:center; float:left;">
                        <img src="img/stud.png" style=" text-align:center; width:140px; height:140px;" />
                  </div>
                  <div style="text-align:center; float:left; margin-top:20%; font-size:13px;color:#0000fe; font-weight:bold;">
                        <img src="img/blood.png" alt="blood" title="blood" />
                        <br>O +ve
                  </div>
                  <div style="width:100%; float:left; text-align:center;">
              <h3 style="padding:0px; margin:0px; color:#e00023; font-size:16px; margin-left:10%;">Mr. KALIYAPPAN S</h3>    
              <h4 style="padding:0px; margin:0px; color:#225aa5; font-size:14px; margin-left:10%;">OFFICE STAFF</h4>
              <h5 style="padding:0px; margin:0px; color:#3d0f7b; font-size:12px; margin-left:10%">EMPLOYEE ID : 15228</h5>
              <h6 style="padding:0px; margin:0px; color:#834d98; font-size:12px; margin-left:10%">D.O.Joining : 09-APR-2014</h6>
                  <img src="img/logo1.png" style="text-align:left; float:left; width:85px; height:85px; margin-top:5%;" />
                  <h3 style="padding:0px; margin:0px; margin-top:20%; margin-left:45%; font-size:17px; color:#92cc99;">S. Muthu Kumar</h3>
                  <h4 style="padding:0px; margin:0px; margin-left:45%; font-size:16px; color:black">Principal</h4>
                 </div>


<!--                  <div style=" width:100%; text-align:right;">
                  <b style="text-align:right;">S. Muthu Kumar</b><br>
                  <span style="text-align:right;">Principal</span>
                  </div>
-->        </div>
        <!--<table>
        <tr>
        	<td>
            <table width="428px" border="0" cellpadding="0" style="margin-top:30px; font-size:16px; font-weight:600;color:#056e9a;line-height:20px;">
        <tr style="width:428px;">
        	<td width="428px" style="text-align:center; font-size:36px; font-family: ubuntu-condensed; font-weight:bold;">SP Modern School</td>
        </tr>
        <tr style="width:428px;">
            <td style="text-align:right;">Learn well. Fly High...</td>
        </tr>
        <tr style="width:428px; font-size:22px;">
            <td style="text-align:center;">ISO 9001 - 2008 Certified Institution</td>
        </tr>
        <tr style="width:428px; font-size:22px;">
            <td style="text-align:right;"><img src="img/stud.png" style="margin-right:25px;" /></td>
            <td style="text-align:center;">O+ve</td>
        </tr>
        <tr style="text-align:center; font-size:26px;">
            <td>ARUN. A</td>
        </tr>
        <tr style="text-align:center; font-size:24px;">
            <td>I Std</td>
        </tr>
        <tr style="text-align:center; font-size:22px;">
            <td>D.O.B : 30-MAR-2008</td>
        </tr>
        <tr style="text-align:center; font-size:20px;">
            <td>Student Id : 14055</td>
        </tr>
        <tr style="float:left;">
            <td style="text-align:left;"><img src="img/logo1.png" /></td>
        </tr>
        <tr style="color: #5DD96F; font-size:20px; float:right; margin-top:80px; text-align:right; margin-left:105px; margin-right:-45px;">

            <td style="text-align:right;">S. Muthu Kumar</td>
        </tr>
        <tr style="float:left;">
            <td style="text-align:left;">&nbsp;</td>
        </tr>
        <tr style="color:#000; font-size:20px; float:right; margin-top:0px; text-align:right; margin-left:105px; margin-right:-15px;">
            <td style="text-align:right;">Principal</td>
         </tr>
        </table>
            </td>
        </tr>
        </table>-->
      </td>
      <td style="width:138px; height:428px;">&nbsp;</td>
      <td width="268px" height="428px" class="idcard1">
      	<table>
        <tr>
        	<td>
            <table border="0" cellpadding="0" style="margin-left:20px; margin-top:-40px; font-size:16px; font-weight:600;color:#056e9a;line-height:20px;">

                <div style="text-align:center;">
                <img src="img/images1.png" style="margin-right:15%; width:75px; height:65px;" />

      	<div style="width:100%; float:left;">
              <h2 style="text-align:center; font-size:28px; padding:0px; margin:0px; color:#fff;text-shadow: 3px 1px #000; margin-right:10%;">SP Modern School</h2>
              <h5 style=" font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace;
              margin-right:32px; float:right; padding:0px; margin-bottom:0px; margin-top:0px; color:#fff;">Learn well. Fly High...</h5><br>
              <h3 style="text-align:center; font-size:14px; color:#eafc4e; margin-right:8%; margin-bottom:0px; padding-bottom:0px; padding-top:0px; margin-top:0px; ">ISO 9001 - 2008 Certified Institution</h3>
              <h3 style="padding:0px; margin:0px; color:#462d28; font-size:13px; margin-right:10%; font-style:italic;">Sevalpatti - 626140 , Virudhunagar Dist.</h3>
              <h3 style="padding:0px; margin:0px; color:#462d28; font-size:13px; margin-right:10%; font-style:italic;">Ph : 04562 239111</h3>
              <h2 style="padding:0px; margin:0px; color:#462d28; font-size:14px; margin-right:10%; color:#edc53f;">Web : www.spmodernschool.edu.in</h2>
              <h2 style="padding:0px; margin:0px; color:#462d28; font-size:13px; margin-right:10%; color:#edc53f;">E-mail : contact@spmodernschool.edu.in</h2>
        </div>

        <div style="float:left; text-align:left; margin-left:5%; color:#fff;">
        <img src="img/home_address.png" alt="home" title="home" style="width:20px; height:20px;" />
        <h3 style="padding:0px; margin:0px; font-size:12px; min-height:70px; max-height:70px; width:160px; overflow:hidden;">S/O. IYAL RAJ
        7/69 PILLAYAR KOVIL STREET   MOORTHINAYAGANPATTI VIRUDHUNAGAR - 626140
        Ph No:8487869088
        7789416007
       </h3>
        <span style="font-weight:bold; font-size:13px; color:#5c0b7f; float:right; text-align:right; width:240px; text-align:right; ">2014 - 2015</span>
        <h3 style="padding:0px; margin:0px; font-size:12px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:12px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:12px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:10px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:10px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:10px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:14px; margin-left:0%; font-style:italic; color:#000; font-weight:bold;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:14px; font-style:italic; color:#000; font-weight:bold;">&nbsp;</h3>
        </div>


                </div>

            </table>
            </td>
 
        </tr>
        </table>
      </td>
      <td style="width:138px; height:428px;">&nbsp;</td>          
    </tr>    
    <?php } } }?>
  </tbody></table>
  <p>
    <!-- End ImageReady Slices -->
  </p>
 
  <p>&nbsp;    </p>
</div>

</body></html>