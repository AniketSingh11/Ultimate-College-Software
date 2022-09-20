<? ob_start(); ?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../includes/config.php"); 
include("header.php");
session_start();
 
 
 
 
 
$date = date_default_timezone_set('Asia/Kolkata');

$check=$_SESSION['email'];

$query=mysql_query("select email,id from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$adminid=$data['id'];
$user=$_SESSION['uname'];

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1' ");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$syear=$ay['s_year'];
$eyear=$ay['e_year'];

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:../timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}
if(!isset($check))
{	
header("Location:404.php");
}
include("checking_page/payroll.php");

$sacyear=$_SESSION['acyear'];
if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1' ");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$syear=$ay['s_year'];
$eyear=$ay['e_year'];
 ?> 
 <?php include 'print_header.php';?> 
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
	 document.getElementById('print').style.display='none';
     window.print();
    // document.body.onmousemove = doneyet;
}


</script>
  </head>
 <body style="background:#FFFFFF;">
 
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="../img/printer.png"></a>Teaching Category : <span class="error">*</span></label>
                               <select id="s_type" name="s_type" onChange="stafftype()" class="required">
                                
                                <option value="">All</option>
                                <option value="Teaching" <?php if($_GET['s_type']=="Teaching"){ echo "selected"; }?>>Teaching</option>
                                  <option value="Non-Teaching" <?php if($_GET['s_type']=="Non-Teaching"){ echo "selected"; }?>>Non Teaching</option>
							
								</select></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<!doctype html>
<html>
<head>
<style type="text/css" media="all">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-362px;
	height:200px;
	margin-left:-960px !important;
   
  }
  .block-content-invoice1{
	  width:950px;
	  margin:30px
		border-radius: 3px;
		position: relative;
		padding: 10px;
		/*border: 2px solid #a9a6a6;*/
		  }
.table td, .table th
{
	padding:5px;
	text-align:center;
}
</style></head> 
 <form action="" id="staff_form" name="staff_form" method="GET">       
<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
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
<body>
    

<h3><?php
if($s_type=="Teaching")
echo "TEACHING STAFF LIST";
else if($s_type=="Non-Teaching")
echo "NON-TEACHING STAFF LIST";
else
echo "Employee Salary Details"; 
							
							
?></h3><br>




            <div class="modal-body"> 
                <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;"><tr>
                					<th><center>SNo</center></th>
        							<th><center>Emp Code</center></th>
                                    <th><center>Emp Name</center></th>
                                     <th><center>Role</center></th>
                                  <th><center>Email</center></th>
                                    <th><center>Phone No</center></th>
                                    <th><center>Position</center></th>
                               		
                                    </tr>
                                    <?php
                                       $s_type=$_GET['s_type'];
									  
									  if($s_type)
									  {
										  
										$qry=mysql_query("SELECT * FROM staff where s_type='$s_type' and status =  '1' and relivestatus='0' ORDER BY fname ASC");	
										
									  }
									  else
									  {
										  $qry=mysql_query("SELECT * FROM staff where status =  '1' and relivestatus='0' ORDER BY fname ASC");	
									  }
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
			  
        		{ ?> 
			
                            
										 <tr>
											 <td><?php echo $count++ ;?> </td>
                                             <td><?php echo $row["staff_id"]; ?> </td>
                                             <td><?php echo $row["fname"]; ?> </td>
                                             <td><?php echo $row["s_type"]; ?> </td>
                                             <td><?php echo $row["email"]; ?> </td>
                                             <td><?php echo $row["phone_no"]; ?> </td>                                             
                                             <td><?php echo $row['position'];?></td>	
                                             
										 </tr>
								 
		
		<?php } ?>
		
	
								</table>
								
								
								
								
								
								
								
								
      </div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable({
  'iDisplayLength': 25
});
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	function change_function() { 
     var cid =document.getElementById('s_type').value;
	 window.location.href = 'emp_salary_detail_print.php?s_type='+s_type;	  
	} 
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
	
	
function stafftype()
{
	
//var s_type=$("#s_type").val();
//alert(s_type);
window.location.href="emp_salary_detail_print.php?s_type="+document.getElementById('s_type').value;
 
         }
        
</script>  

</form>

</body>
 </html>