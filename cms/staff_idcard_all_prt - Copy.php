<?php 
include("includes/config.php");
error_reporting(0);

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
	  background: url(img/staff.jpg) top left no-repeat;
	  padding-bottom:40px;
	  }
.idcard1{
	  background:url(img/back.png) top left no-repeat;
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
	 
		$sql = "SELECT * FROM staff";
$query = mysql_query($sql);
	while($rs = mysql_fetch_array($query)) { ?>
    <tr>
      <td width="428px" height="576px" class="idcard">
      	<div>
              <h2 style="text-align:center; font-size:42px; padding:0px; margin:0px; color:#eafc4e;text-shadow: 3px 1px #000;">CHRIST MATRIC HIGHER SECONDARY SCHOOL</h2>
              <h5 style=" font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; margin-right:80px; float:right; padding:0px; margin-bottom:0px; margin-top:0px; color:#c91088;">Learn well. Fly High...</h5>
              <h3 style="text-align:center; font-size:23px; color:#834e96; text-shadow:-3px 1px #fff;">ISO 9001 - 2008 Certified Institution</h3>
                  <div style="width:70px; text-align:left; float:left; margin-top:10%; font-size:22px; margin-right:5%; color:#000000; font-weight:bold; margin-left:8%">
<pre>D.O.B
<?php echo date("d-M-Y",strtotime(str_replace('/', '-', $rs['dob'])));?></pre>
                        
                  </div>
                  <div style="text-align:center; float:left;">
                        <img src="img/staff/<?php echo $rs['photo']; ?>" style=" text-align:center; height:220px; width:220px;" />
                  </div>
                  <div style="width:70px; text-align:right; float:left; margin-top:20%; font-size:22px; margin-right:5%; color:#0000fe; font-weight:bold;">
                       <?php  echo $rs['blood'];?>
                  </div>
                  <div style="width:100%; float:left; text-align:center;">
              <h3 style="padding:0px; margin:0px; color:#e00023; font-size:20px;"><?php echo $rs['fname']." ".$rs['lname'];  ?></h3>    
              <h4 style="padding:0px; margin:0px; color:#225aa5; font-size:18px;"><?php echo $rs['position']; ?></h4>
              <h5 style="padding:0px; margin:0px; color:#000; font-size:16px;">EMPLOYEE ID : <?php echo $rs['staff_id']; ?></h5>
              <h6 style="padding:0px; margin:0px; color:#000; font-size:17px;">D.O.Joining : <?php echo $rs['doj']; ?></h6>
                  <img src="img/logo1.png" style="text-align:left; float:left;" />
                  <h3 style="padding:0px; margin:0px; margin-top:10%; margin-left:45%; font-size:21px; color:#92cc99;">S. Muthu Kumar</h3>
                  <h4 style="padding:0px; margin:0px; margin-left:45%; font-size:20px; color:black">Principal</h4>
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
      <td width="428px" height="268px" class="idcard1">
      	<table>
        <tr>
        	<td>
            <table width="305px" border="0" cellpadding="0" style="margin-left:20px; margin-top:-40px; font-size:16px; font-weight:600;color:#056e9a;line-height:20px;">

                <div style="text-align:center;">
                <img src="img/images1.png" style="margin-right:15%;" />

      	<div style="width:100%; float:left;">
              <h2 style="text-align:center; font-size:36px; padding:0px; margin:0px; color:#fff;text-shadow: 3px 1px #000; margin-right:10%;">SP Modern School</h2>
              <h5 style=" font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; margin-right:110px; float:right; padding:0px; margin-bottom:0px; margin-top:0px; color:#fff;">Learn well. Fly High...</h5><br>
              <h3 style="text-align:center; font-size:21px; color:#eafc4e; margin-right:10%; margin-bottom:0px; padding-bottom:0px; padding-top:0px; margin-top:0px; ">ISO 9001 - 2008 Certified Institution</h3>
              <h3 style="padding:0px; margin:0px; color:#462d28; font-size:22px; margin-right:10%; font-style:italic;">Sevalpatti - 626140 , Virudhunagar Dist.</h3>
              <h3 style="padding:0px; margin:0px; color:#462d28; font-size:18px; margin-right:10%; font-style:italic;">Ph : 04562 239111</h3>
              <h2 style="padding:0px; margin:0px; color:#462d28; font-size:18px; margin-right:10%;">Web : www.spmodernschool.edu.in</h2>
              <h2 style="padding:0px; margin:0px; color:#462d28; font-size:18px; margin-right:10%;">E-mail &nbsp;&nbsp; : contact@spmodernschool.edu.in</h2>
        </div>

        <div style="float:left; text-align:left; margin-left:5%; color:#fff;">
        <img src="img/home_address.png" />
        <h3 style="padding:0px; margin:0px; font-size:17px;"><?php if($rs['gender']=="F"){?>D/O<?php }else{?>S/O<?php }?> <?php echo $rs['s_pname'];?></h3>
        <h3 style="padding:0px; margin:0px; font-size:17px;"><?php echo $rs['address1'];?></h3>
        <!--  <h3 style="padding:0px; margin:0px; font-size:17px;">MOORTHINAYAGANPATTI</h3>
        <h3 style="padding:0px; margin:0px; font-size:17px;">VIRUDHUNAGAR - 626140</h3>-->
        <h3 style="padding:0px; margin:0px; font-size:17px; float:left; width:180px;">Ph No:<?php echo $rs['phone_no'];?></h3>
        <span style="float:left; width:150px; font-weight:bold; font-size:22px; color:#5c0b7f; margin-left:90px;"><?php echo $ayear['y_name'];?></span>
        <h3 style="padding:0px; margin:0px; font-size:17px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:17px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:17px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:22px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:22px;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:18px; margin-left:0%; font-style:italic; color:#000; font-weight:bold;">&nbsp;</h3>
        <h3 style="padding:0px; margin:0px; font-size:18px; font-style:italic; color:#000; font-weight:bold;">&nbsp;</h3>
        </div>


                </div>

            </table>
            </td>
            <td>
            </td>
        </tr>
        </table>
      </td>          
    </tr>    
    <?php } ?>
  </tbody></table>
  <p>
    <!-- End ImageReady Slices -->
  </p>
 
  <p>&nbsp;    </p>
</div>

</body></html>