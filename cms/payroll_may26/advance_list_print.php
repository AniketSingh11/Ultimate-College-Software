<? ob_start(); ?>
<?php
include("header.php");
?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../includes/config.php"); 
session_start();
     $ltype=$_GET['ltype'];	
 	   $year=$_GET['year'];
	   $tyear=date("Y");
	   $pay=$_GET['pay'];
	     $st_id=$_GET["st_id"];
		
		$o_id=$_GET["o_id"];
		 $d_id=$_GET["d_id"];
											 
	   if($pay=="P"){
		   $payment="Pending";
	   }else if($pay=="R"){
		   $payment="Received";
	   }
	 						  	$ayear1=mysql_query("SELECT * FROM year ORDER BY s_year ASC");
								$ay1=mysql_fetch_array($ayear1);
								$start=$ay1['s_year'];
								
								
								

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
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
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
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];


$syear=$_GET['syear'];
$eyear=$_GET['eyear'];


					
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
<img src="../img/printer.png"></a> 

  <?php 
							  
							   $st_id1=$_GET["st_id"];
											 $o_id1=$_GET["o_id"];
											 $d_id1=$_GET["d_id"];
											 $staff_name=$_GET['staff_name'];
							  ?>
             <div class="_25" style="float:center">
                <label for="select"> Filter by Employe</label>
				<select id="etype" name="etype" onChange="emptype()" class="required" >	
				<option  value = "<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?>">Over All</option>
				 <?php
					
				    $emp_query=mysql_query("SELECT * FROM staff_advance group BY staff_name ORDER BY staff_name ");
				 
                    while ($row_enq = mysql_fetch_array($emp_query)) {
                     $staff_name=$row_enq['staff_name'];				  
                     $st_id=$row_enq['st_id'];
				     $o_id=$row_enq['o_id'];
					 $d_id=$row_enq['d_id'];
				   
					 $emp_query1=mysql_query("select * from staff WHERE status='1' AND st_id='$st_id'  order by fname asc");
							
								      $emp_display=mysql_fetch_array($emp_query1);
									
					 $emp_query2=mysql_query("select * from others WHERE status='1' AND o_id='$o_id' order by fname asc");			 $emp_display1=mysql_fetch_array($emp_query2);
					
					$emp_query3=mysql_query("select * from driver WHERE status='1' AND d_id='$d_id' order by fname asc");
					
					 $emp_display2=mysql_fetch_array($emp_query3);
				
				
		?>  
				 <option <?php if($st_id==$st_id1||$o_id==$o_id1||$d_id==$d_id1)	{ echo "selected";	} ?> value="<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?>"><?php echo $row_enq['staff_name']; ?></option>
					<?php } ?>
                                
								</select>
                 <div class="_25" style="float:center">
                <label for="select"> Filter by Payment</label>
				<select id="pay" name="pay" onChange="Loantype()" class="required" >	
				<option value = "" <?php if(!$pay){echo "selected";}?><?php echo "Over All"?>>Over All</option>
				 <?php 
							  
							   $st_id=$_GET["st_id"];
											 $o_id=$_GET["o_id"];
											 $d_id=$_GET["d_id"];
											  $pay=$_GET['pay'];
											  $year=$_GET['year'];
							  ?>
				<option <?php if($pay=="R"){ echo "selected";}?> value='<?php echo "R";?>'>Received</option>
							   <option <?php if($pay=="P"){ echo "selected";}?> value='<?php echo "P";?>'>Pending</option>
 				
                                
								</select>
								</div>
                
                 <div class="_25" style="float:right">
                <label for="select">Filter by Year</label>
				<select id="year" name="year" onChange="yeartype()" class="required" >	
                                	<option value = ""<?php if(!$year){ echo "selected";}?>>Over All</option>
 				 <?php 
							  
							   $st_id=$_GET["st_id"];
											 $o_id=$_GET["o_id"];
											 $d_id=$_GET["d_id"];
											  $pay=$_GET['pay'];
											  $year=$_GET['year'];
							  ?>
                                	 <?php for($i=$start;$i<=$tyear;$i++){ ?>
                               <option <?php if($year==$i){  echo "selected";}?> value='<?php echo $i;?>'><?php echo $i;?></option>
                                <?php } ?> 
								</select>
                 </div>
				 </div>
				 </div>
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
		/* position: relative; */
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
   <?php

  $emp_query11="SELECT staff_name,status FROM staff_advance";
		
		  if($st_id)
		 {
			 $emp_query11.= "  where   st_id='$st_id'";
		 }
		 
		if($o_id)
		 {
			 $emp_query11.= "  where   o_id='$o_id'";
		 } 
		 if($d_id)
		 {
			 $emp_query11.= "  where   d_id='$d_id'";
		 }
		 
		// echo  $emp_query11;die;
		 $emp_result5=mysql_query($emp_query11);
		 while($emp_display5=mysql_fetch_array($emp_result5))
								{
		
		 
		   $staff_name=$emp_display5['staff_name'];
		   $status=$emp_display5['status'];
		 
		
		$emp_query12="SELECT SUM(a_amount) from staff_advance";
		$emp_result2=mysql_query($emp_query12);
		$emp_display2= mysql_fetch_array($emp_result2);
		//print_r($emp_display2);
		$a_amount=$emp_display2[0];
		//echo $a_amount;die;
	// print_r($emp_display5);die;
		if($status==1)
		
		{
			//echo $status;
			$emp_query9="SELECT SUM( a_amount ) FROM staff_advance where status=1";
			if($st_id)
		{
			$emp_query9.= "  AND st_id=$st_id"; 
			
		}
		elseif($o_id)
		{
			$emp_query9.= "   AND o_id=$o_id"; 
			
		}
		else if($d_id)
		{
			$emp_query9.= "   AND d_id=$d_id"; 
			
		}
		
			$emp_result9=mysql_query($emp_query9);
		    $emp_display9= mysql_fetch_array($emp_result9);
			//print_r($emp_display9);die;
			$recieved=$emp_display9[0];
		}
	if($status==0)
			
		{
			
		
			
			
			$emp_query14="SELECT SUM(a_amount) from staff_advance where status=0";
				if($st_id)
		{
			$emp_query14.= "  AND st_id=$st_id"; 
			
		}
		elseif($o_id)
		{
			$emp_query14.= "  AND o_id=$o_id"; 
			
		}
		elseif($d_id)
		{
			$emp_query14.= "   AND d_id=$d_id"; 
			
		}
			
			$emp_result14=mysql_query($emp_query14);
			
	      $emp_display14= mysql_fetch_array($emp_result14);
			//print_r($emp_display14);die;
			$pending=$emp_display14[0];
		}
		
	
		
		
								}
								

?>                     
<h3>  Advance Salary List <?php if($year){ echo "(".$year.")";}?></h3><br>
 <div style="float:left; margin-left:25px; padding:10px 0px;">
		
		Advance Salary Detail- Total:<?php if (!$st_id&!$o_id&!$d_id) { echo $a_amount; } else { echo $recieved+$pending;} ?>&nbsp;&nbsp;
		 Recieved:<?php if($recieved=="") { echo "0"; } else { echo $recieved; } ?>&nbsp;&nbsp;
		 Pending:<?php if($pending=="") { echo "0"; } else { echo $pending; }?>
		
		 </div>			
		  
		 
		 
		 
		<?php if($year||$staff_name){?>
		 
		 
		 
		 
		 <span style="float:right; margin-right:30px;"><b>
		 Filter by : </b>
		<?php if($year){ echo " Year = ".$year;}?><?php if($pay){ echo "| Payment = ".$payment;}?><?php if($st_id){ echo " | emp = ".$staff_name; } ?><?php if($o_id){ echo " | emp = ".$staff_name; } ?><?php if($d_id){ echo " |  emp = ".$staff_name; } ?></span><?php } ?>
                       <div class="modal-body"> 
                <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;"><tr>
								
									<thead>
										<tr>
												<th data-sortable="true">S.No</th>
											 <th data-sortable="true">Emp Code</th>
                                             									 
											 <th data-sortable="true">Emp Name</th>
											
                                             <th data-sortable="true">Date</th>
                                             <th data-sortable="true">Amount</th>
											 <th data-sortable="true">Payment</th>
											 </tr>
											 </thead>
                           <?php
										
									 $st_id=$_GET["st_id"];
											 $o_id=$_GET["o_id"];
											 $d_id=$_GET["d_id"];
                                             $type=$_GET["type"];
											$year=$_GET['year'];
                                                  if(!$st_id&!$o_id&!$d_id)	{										 
											 $emp_query="select * from staff_advance";
											//echo "select * from staff_advance where staff_id='$staff_id'";die;
											if($year || $pay){
											$emp_query .=" where ";
                                              // echo 	$emp_query;die;										
											}
												  }
												  else
												  {
													  
													 $emp_query="select * from staff_advance";
													 
													 
											if($type=="st")
											 {
												$emp_query.= "  where st_id=$st_id"; 
												
											 }
	                                        
											 
											 elseif($type=="ow")
											 {
												$emp_query.= "  where o_id=$o_id"; 
											 }
	                                        
											 else
												
											 {
												$emp_query.= "  where d_id=$d_id"; 
											 }
	                                         if($year || $pay){
											$emp_query .=" AND";
                                              // echo 	$emp_query;die;										
											}
												  }	  
											 
											 

											
											if($year){
											  $emp_query .=" year=$year";	
											//echo 	$emp_query;die;
												if($pay=="P"){
												$emp_query .=" AND status=0";
                                                 //echo 	$emp_query;die;												
												}
												if($pay=="R"){
												$emp_query .=" AND status=1";										
												}									
											}else{
												if($pay=="P"){
												$emp_query .=" status=0";										
												}
												if($pay=="R"){
												$emp_query .=" status=1";										
												}
											}
												  
											 $emp_query .=" order by a_id desc";	
										//die;	
								$emp_result=mysql_query($emp_query);
								
								$emp_count=1;
								while($emp_display=mysql_fetch_array($emp_result))
								{
									$a_id=$emp_display["a_id"];	
									$emp_id=$emp_display["st_id"];
									$emp_id1=$emp_display["o_id"];	
									$emp_id2=$emp_display["d_id"];
								    $status=$emp_display["status"];
		
			?> 					                             
										 <tr>
										<td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["staff_id"]; ?> </td>
                                             <td><?php echo $emp_display["staff_name"]; ?> </td>
                                             <td><?php echo $emp_display["a_date"]; ?> </td>
                                             <td>Rs. <?php echo $emp_display["a_amount"]; ?> </td> 
                                                <td><?php if($status==1){ ?>received<?php } else{ ?>Pending<?php } ?></td>
										 </tr>
		<?php 
        
		$emp_count++;
		
        }
        
						
		?>		
		</tr>
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
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	function emptype()
{
	 
var data = document.getElementById('etype').value;
//alert(data);
var arr = data.split('&');

var pay=document.getElementById('pay').value;
var year=document.getElementById('year').value;

window.location.href='advance_list_print.php?year='+year+"&pay="+pay+"&"+arr['0']+"&"+arr['1'];
 }

	function Loantype()
{
var data = document.getElementById('etype').value;
//alert(data);
var arr = data.split('&');

var pay=document.getElementById('pay').value;
var year=document.getElementById('year').value;

window.location.href='advance_list_print.php?year='+year+"&pay="+pay+"&"+arr['0']+"&"+arr['1'];
 }
 
 function yeartype()
{
	
var data = document.getElementById('etype').value;
//alert(data);
var arr = data.split('&');

var year=document.getElementById('year').value;
var pay=document.getElementById('pay').value;

window.location.href='advance_list_print.php?year='+year+"&pay="+pay+"&"+arr['0']+"&"+arr['1'];
 }
 

	
  </script>
  </form>
  
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>