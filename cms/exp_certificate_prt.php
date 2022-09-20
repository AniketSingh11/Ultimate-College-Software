<?php 
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);

session_start();

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

if(!isset($sacyear))

{
	
header("Location:404.php");

}
							$eid=$_GET['e_id'];
							$classlist=mysql_query("SELECT * FROM experience_certificate WHERE e_id=$eid"); 
								  $class=mysql_fetch_array($classlist);	
								 $name=$class["name"];
								 $gender=$class["gender"];
								 $position=stripslashes($class["position"]);
								 $duration_from=stripslashes($class["duration_from"]);
								 $duration_to=stripslashes($class["duration_to"]);
								 $fathername=stripslashes($class["fathername"]);
								 if(substr($gender,0,1)=="M")
								 {

								     $member_name="Mr.".$name;
								     $gen_type="he";
								     $gen="S/o";
								     
								 }else{
								     $member_name="Ms.".$name;
								     $gen_type="she";
								     $gen="D/o";
								 }
					
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
	body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto;
  background: #FFFFFF; 
  font-family: Arial, sans-serif;
}
	.title{
		font-size:27px;
		border-bottom: solid 1px #000000;
      display: inline;
      padding-bottom: 2px;}
	 .parag{
		 margin:0 auto;
		 width:100%;
		 font-size:25px;
		 line-height:60px;
		 text-align:justify;
	 }
	 .footer{
	  	  font-size:23px;
	  	  width: 100%;
		  height: 30px;
		  position: absolute;
		  bottom: 0;
		  padding-bottom:200px;
	 }
	 
	</style>
</head>
<body onload="javascript:printDiv('printablediv')">

<div style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv"  style="font-size:12.5px; line-height:20px;">
  <div style="width:236mm; margin:0px; height:40.1mm; min-height:40.1mm; border-bottom:2px solid #01a8ff; padding-bottom:20px; display:inline-block;" id="Table_01">
                            <div style="text-align:left; width:50.00mm; float:left;">
                                <div><img src="img/logo1.png" width="160px" height="160px"></div>
                            </div>
                            <div style="text-align:center;width:185.75mm; float:left; padding-top:25px;">
                                <h5 style="padding:0px; padding-bottom:3px; margin:0px; letter-spacing:2px; color:red; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:46px; ; font-weight:bold;">SCHOOL/COLLEGE MANAGEMENT SYSTEM</h5>

                                <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Hetauda, Nepal</h5>
                               <!-- <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-size:16px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Contact : 044-32429897, 26790694, Email : christischool@gmail.com, Web: www.christschool.co.in</h5>-->
                            </div>
                        </div>
<!--<center>
<table width="900" height="24" border="0" cellpadding="0" cellspacing="0" id="Table_01" style="margin-left:5%; line-height:40px;">
    <tbody><tr id="butt" style="visibility: visible; line-height:40px; min-height:150px;">
      <td><img src="img/images1.png" style="width:130px; height:110px;" /></td>     
      <td>
      <h2 style="text-align:center; padding:0px; margin:0px; color:red; font-size:2em;">SP MODERN SCHOOL</h2>
      <h5 style="text-align:center; padding:0px; margin:0px; line-height:21px; color:#017CBE; font-size:1em;">(Government Recognized &An ISO 9001:2008 Certified institution)</h5>
      <h4 style="text-align:center; padding:0px; margin:0px; font-size:14px; color:#5D5E60; font-size:16px;">SEVALPATTI, VIRUTHUNAGAR (DT)-626140</h4>
      </td>
      <td><img src="img/images2.png" style="height:70px;" /></td>
    </tr>
  </tbody>
     <table align="left" width="96%" style=" border-bottom:2px solid lightblue; margin-top:-18px; font-size:20px; margin-left:12%;">
  <tr>
  <td>
        <span style="margin-left:10%; height:22px;"><img src="img/phone.jpg" />:04562-239111</span><br>
      <span style="margin-left:10%; height:19px;"><img src="img/mail.jpg" />:www.spmodernschool.edu.in:contact@spmodernschool.edu.in</span><br>
      <span style="margin-left:10%; height:21px;"><img src="img/fb.jpg" />:www.facebook.com/page/spmodernschoolsevalpatti</span>

  </td>
  </tr>
  </table>
</table>
</center>-->
<hr>
 <br><br><br><br><br><br>
 <center><h3 class="title">CERTIFICATE OF EXPERIENCE</h3></center>
 <br>
 <br><br><br>

 <p class="parag" style="text-align:justify;">This is to certify that  <b><?=$member_name?></b>, <?=$gen?>  Mr.<b><?=$fathername?></b>,  has worked in this institution during the period between      <b><?=$duration_from?></b> and <b><?=$duration_to?></b> as a <b><?=$position?></b>. During the service period <?=$gen_type?> had no negative remarks in respect with her position.
 </p>
<div class="footer">
<strong><font style="margin-left:80px;">School Seal</font><font style="margin-right:80px; float:right;">Principal</font></strong>
</div>




</div>
</body>
</html>