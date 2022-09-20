<? ob_start(); ?>
<?php
include("includes/config.php");
?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php"); 
session_start();
       
	  $ss_id = $_GET['ssid'];
    $ssid = $ss_id;

	  $bid = $_GET['bid'];
            if (!$bid) {
                $boardlist1 = mysql_query("SELECT * FROM board");
                $board1 = mysql_fetch_array($boardlist1);
                $bid = $board1['b_id'];
            }
            $boardlist = mysql_query("SELECT * FROM board WHERE b_id=$bid");
            $board = mysql_fetch_array($boardlist);
			$cid = $_GET['cid'];
                    $sid = $_GET['sid'];
                    
                    $ddlterm = $_GET["ddlterm"];
                    $feesub = $_GET["fees_sub"];
					//$order_gender = $_GET["order_gender"];
                    if ($cid && $sid) {
                        $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid");
						//echo "SELECT * FROM class WHERE c_id=$cid";die;
                        $class = mysql_fetch_array($classlist);
                        $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$sid");
                        $section = mysql_fetch_array($sectionlist);
                        //echo $class['c_name']."-".$section['s_name'];
                    }							
								

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
<img src="img/printer.png"></a> 
             
                 <div class="_25" style="float:center">
                <label for="select"> Standard :</label>
				<select id="cid" name="cid" onChange="standard()" class="required" >	
				 <?php
                                        $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id='" . $acyear . "'";
                                        $result1 = mysql_query($classl) or die(mysql_error());?>
                                        <option value="">Select Class</option>
                                        <?php echo "<option value='all'>All</option>";
                                        while ($row1 = mysql_fetch_assoc($result1)):
											$selec = ($row1['c_id']==$_GET['cid']) ? "selected" : "";
                                            echo "<option value='{$row1['c_id']}' $selec>{$row1['c_name']}</option>\n";
                                        endwhile;
                                        
                                        ?>				  
								</select>
								</div>
								<?php //echo $_GET['cid'];
								//echo $section_qry = "SELECT s_id,s_name FROM section WHERE c_id=".$_GET['cid'];
											//die; ?>
								 <div class="_25" style="float:center">
                                    <p>
                                        <label for="select">Section / Group : </label>
                                        <select name="sid" id="sid" onChange="sidtype()" class="required">
                                            <option value="">Please select</option>	
                                              <option value='all'>All</option>
												<option value='0'>New</option>											  
											<?php
											if($_GET['cid']!="all"){
											$section_qry = "SELECT s_id,s_name FROM section WHERE c_id=".$_GET['cid'];
                      } else {
                        $section_qry = "SELECT s_id,s_name FROM section";
                      }
                      $result_sec = mysql_query($section_qry) or die(mysql_error());
											while ($row_sec = mysql_fetch_assoc($result_sec)):
											$sel_sec = ($row_sec['s_id']==$_GET['sid']) ? "selected" : "";
                                            echo "<option value='{$row_sec['s_id']}' $sel_sec>{$row_sec['s_name']}</option>\n";
                                        endwhile;
                                      
										?>
                                        </select>
                                    </p>
                                </div>
               
				 
				    <div class="_25" style="float:center;">
                <label for="select"> Fees Type : </label>
				 <select name="ddlterm" id="ddlterm" onChange="ddlterm()"  class="required">
                        <option value="Books, Notes, Other Items" selected=tr>Books, Notes, Other Items</option>	
                                            
                                        </select>
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
                    $cid = $_GET['cid'];
                    $sid = $_GET['sid'];
                    $bid = $_GET['bid'];
                    $ddlterm = $_GET["ddlterm"];
                    $feesub = $_GET["fees_sub"];
                    $status=$_GET['status'];
                    if ($cid && $sid) {
                        $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid");
					//	echo "SELECT * FROM class WHERE c_id=$cid";die;
                        $class = mysql_fetch_array($classlist);
                        $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$sid");
						//echo "SELECT * FROM section WHERE s_id=$sid";die;
                        $section = mysql_fetch_array($sectionlist);
                        //echo $class['c_name']."-".$section['s_name']    
                    }

                    if(!empty($ddlterm)){ 
                                        
                                       $qry = "SELECT s.firstname,s.admission_number,s.ss_id,c.c_name,c.c_id,s.stype,s.s_id,phone_number FROM student AS s 
                                                INNER JOIN class AS c on c.c_id=s.c_id AND c.ay_id=s.ay_id AND s.b_id=c.b_id WHERE s.ay_id='" . $acyear . "' ";
                                        if ($cid != "all") {
                                            $qry = $qry . " AND s.c_id='" . $cid . "'";
                                        }
                                        if ($sid != "all" && $sid != "Old") {
                                            $qry = $qry . "  AND s.s_id='" . $sid . "'";
                                        }
                                        if ($sid == "Old") {
                                            $qry = $qry . "  AND s.s_id!=0";
                                        }
                                        $qry = $qry . " AND s.b_id='" . $bid . "' ORDER BY s.c_id ASC";
                                        
                                        $result = mysql_query($qry);
                                        //echo $qry;
                                        $oin="SELECT * FROM finvoice_others as fin";
                                        $oin1=$oin;
                                        
                                        $result1 = mysql_query($oin);
                                        //echo $oin;
                                        $detail=array();
                                        $gdetail=array();
                                        while ($allin = mysql_fetch_assoc($result1)) {
                                            $detail[]=$allin;
                                        }
                                        $grt=mysql_query($oin1);
                                        while ($all = mysql_fetch_assoc($result)) {
                                            $gdetail[]=$all;
                                        }
                                    }
                    ?>                    
<h3> <?php echo $class['c_name'] . "-" . $section['s_name']; ?> Student List</h3><br>
                      <div class="modal-body"> 
                <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;">
				
								
								<thead>
										<tr>
												<th data-sortable="true" rowspan='3'>S.No</th>
											 <th data-sortable="true" rowspan='3'>Admission No.</th>
                                             									 
											 <th data-sortable="true" rowspan='3'>Student Name</th>
											
                                             <th data-sortable="true" rowspan='3'>Class Name</th>
                                             <th data-sortable="true" rowspan='3'>Student Type</th>
											 <th rowspan='2'>Student Phone no</th>
                                             <th colspan="3">Books, Notes, Other Items</th>
											 </tr>
                                            <tr>
                                                <th>Fees</th>
                                                <th>Paid</th>
                                                <th>Pending</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $n=1;
                                    foreach ($gdetail as $tmp) { ?>
                                    <?php
                                            $cidd=$tmp['c_id'];
                                             $sid=$tmp['s_id'];

                                            $getsec=mysql_query("select * from section where s_id=$sid AND c_id=$cid");
                                            $gname=mysql_fetch_assoc($getsec)['g_name'];
                                           //echo "select * from others_bill_all where std=$cidd AND gname=$gname";
                                            $clss = mysql_query("select * from others_bill_all where std=$cidd AND gname='$gname' AND ay_id=$acyear");
                                            
                                            $ans=mysql_fetch_array($clss)['amount'];
                                            $paid=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $paid+=$sub['fi_total']+$sub['discount'];
                                                }
                                            }
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            if($disalloc['total'])
                                                $paid=$paid+$disalloc['total'];
                                            
                                            $pen=$ans-$paid;
                                            if($ans) {
                                            if($pen==0 && $status=="Fully") {
                                            ?>
                                        <tr>
                                        <td><?php echo $n;?></td>
                                        <td><?php echo $tmp['admission_number'];?></td>
                                        <td><?php echo $tmp['firstname']?></td>
                                        <td><?php echo $tmp['c_name']?></td>
                                        <td><?php echo $tmp['stype']?></td>
                                        <td><?php echo $tmp['phone_number']?></td>
                                        <td>
                                            <?php echo $ans;?>
                                        </td>
                                        <td>
                                           <?php
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                echo $paid.' ( * : '.$distot.')';
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0)
                                                    echo $paid.' ( * : '.$disapp.')';
                                                else
                                                    echo $paid;
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                          
                                          if($pen==0)
                                            echo "<center>-</center>";
                                          else
                                          echo $ans-$paid;
                                           ?> 
                                        </td>
                                        </tr>
                                        <?php } if($status=="Pending" && $pen!=0){?>
                                         <tr>
                                        <td><?php echo $n;?></td>
                                        <td><?php echo $tmp['admission_number'];?></td>
                                        <td><?php echo $tmp['firstname']?></td>
                                        <td><?php echo $tmp['c_name']?></td>
                                        <td><?php echo $tmp['stype']?></td>
                                        <td><?php echo $tmp['phone_number']?></td>
                                        <td>
                                            <?php echo $ans;?>
                                        </td>
                                        <td>
                                           <?php
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                echo $paid.' ( * : '.$distot.')';
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0)
                                                    echo $paid.' ( * : '.$disapp.')';
                                                else
                                                    echo $paid;
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                          
                                          if($pen==0)
                                            echo "<center>-</center>";
                                          else
                                          echo $ans-$paid;
                                           ?> 
                                        </td>
                                        </tr>
                                        <?php } if($status=="Select") { ?>
                                         <tr>
                                        <td><?php echo $n;?></td>
                                        <td><?php echo $tmp['admission_number'];?></td>
                                        <td><?php echo $tmp['firstname']?></td>
                                        <td><?php echo $tmp['c_name']?></td>
                                        <td><?php echo $tmp['stype']?></td>
                                        <td><?php echo $tmp['phone_number']?></td>
                                        <td>
                                            <?php echo $ans;?>
                                        </td>
                                        <td>
                                           <?php
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                echo $paid.' ( * : '.$distot.')';
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0)
                                                    echo $paid.' ( * : '.$disapp.')';
                                                else
                                                    echo $paid;
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                          
                                          if($pen==0)
                                            echo "<center>-</center>";
                                          else
                                          echo $ans-$paid;
                                           ?> 
                                        </td>
                                        </tr>
                                        <?php } ?>
                                    <?php $n++; 
                                    }
                                }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="clear height-fix"></div>
                </div>
            </div> <!--! end of #main-content -->
        </div> <!--! end of #main -->


										
				
		  	
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
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	

	function standard()
	
{

var cid=document.getElementById('cid').value;
var sid=document.getElementById('sid').value;
if(sid=="")
    sid="all";
var ddlterm=document.getElementById('ddlterm').value;
window.location.href='mstudent_feesinvoice_download_print_others.php?cid='+cid+"&sid="+sid+"&ddlterm="+ddlterm;
 }
 
 function sidtype()
{

var sid=document.getElementById('sid').value;
var cid=document.getElementById('cid').value;
if(cid=="")
    cid="all";
var ddlterm=document.getElementById('ddlterm').value;
window.location.href='mstudent_feesinvoice_download_print_others.php?sid='+sid+"&cid="+cid+"&ddlterm="+ddlterm;
 }
  function ddlterm()
{

var sid=document.getElementById('sid').value;
var cid=document.getElementById('cid').value;
var ddlterm=document.getElementById('ddlterm').value;
var fees_sub=document.getElementById('fees_sub').value;

window.location.href='mstudent_feesinvoice_download1_print.php?sid='+sid+"&cid="+cid+"&ddlterm="+ddlterm+"&fees_sub="+fees_sub;
 }
  function fees_sub()
{

var sid=document.getElementById('sid').value;
var cid=document.getElementById('cid').value;
var ddlterm=document.getElementById('ddlterm').value;
var fees_sub=document.getElementById('fees_sub').value;
window.location.href='mstudent_feesinvoice_download1_print.php?sid='+sid+"&cid="+cid+"&ddlterm="+ddlterm+"&fees_sub="+fees_sub;
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