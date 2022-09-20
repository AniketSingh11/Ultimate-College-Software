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

$check = $_SESSION['email'];

$query = mysql_query("select email,id from admin_login where email='$check' ");

$data = mysql_fetch_array($query);

$email = $data['email'];
$adminid = $data['id'];
$user = $_SESSION['uname'];

$sacyear = $_SESSION['acyear'];

if ($sacyear) {
    $ayear = mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
    $ay = mysql_fetch_array($ayear);
} else {
    $ayear = mysql_query("SELECT * FROM year WHERE status='1'");
    $ay = mysql_fetch_array($ayear);
}

$acyear = $ay['ay_id'];
$acyear_name = $ay['y_name'];

$syear = $ay['s_year'];
$eyear = $ay['e_year'];


if (isset($_SESSION['expiretime'])) {
    if ($_SESSION['expiretime'] < time()) {
        header("Location:../timeout.php");
    } else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}
if (!isset($check)) {
    header("Location:404.php");
}
include("checking_page/payroll.php");
?> 


<?php include 'print_header.php'; ?> 
<script>
    function hide_button() {
        document.getElementById('print').style.visibility = 'hidden';
        document.getElementById('print').style.display = 'none';
        window.print();
        // document.body.onmousemove = doneyet;
    }


</script>
</head>
<body style="background:#FFFFFF;">

    <div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
            <img src="img/printer.png"></a> 
			
   <div class="_25" style="float:left">
                <label for="select">Status :</label>
                <select name="status" onchange="redirect(this.value);" id="status">
                    <option value="All" <?php if($_GET['status']=="All"){echo 'selected';}?>>All</option>
                    <option value="Paid" <?php if($_GET['status']=="Paid"){echo 'selected';}?>>Paid</option>
                    <option value="Rejected" <?php if($_GET['status']=="Rejected"){echo 'selected';}?>>Rejected</option>
                </select>
                 </div>
    <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
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
                            $sid = $_GET['sid'];
                            $ddlterm = $_GET["ddlterm"];
                            $feesub = $_GET["fees_sub"];
                            if ($cid && $sid) {
                                $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid");
                                //	echo "SELECT * FROM class WHERE c_id=$cid";die;
                                $class = mysql_fetch_array($classlist);
                                $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$sid");
                                //echo "SELECT * FROM section WHERE s_id=$sid";die;
                                $section = mysql_fetch_array($sectionlist);
                                //echo $class['c_name']."-".$section['s_name'];
                            }
                            ?>                    
                            <h3> Bus Fees Invoice</h3><br>
                            <div class="modal-body"> 
                                <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;">


                                    <thead>
                                        <tr>
                                           <th>S.No</th>
                                    <th><center>FR No</center></th>
                                    <th>admin No</th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                    <th>Class-Section</th>
                                    <th>Route Name</th>
                                    <th>Stopping</th>
                                    <th>Inovice By</th>
                                    <th>Amount</th>
									 <th>Status</th>
                                    </tr>
									</thead>
								<tbody>
                            <?php
              if($_GET['status']) {
    
              if($_GET['status']=="All") { 
							$qry=mysql_query("SELECT * FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' ORDER BY bfi_id DESC");
						} else if($_GET['status']=="Paid"){
							$qry=mysql_query("SELECT * FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0' ORDER BY bfi_id DESC");
						} else {
							$qry=mysql_query("SELECT * FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='1' ORDER BY bfi_id DESC");
						}

					} else {
						$qry=mysql_query("SELECT * FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' ORDER BY bfi_id DESC");
					}
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$ssid=$row['ss_id'];
				$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT c_name FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $studentlist=mysql_query("SELECT admission_number FROM student WHERE ss_id=$ssid"); 
								  $student=mysql_fetch_array($studentlist);
								  
								  $sectionlist=mysql_query("SELECT s_name FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT r_id,stop_name FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $rid1=$row6['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid1"); 
								  $row5=mysql_fetch_array($qry5);
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['fr_no']; ?></center></td>
                                <td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $row['fi_name']; ?></center></td>
                                <td><center><?php echo $row['fi_day']."/".$row['fi_month']."/".$row['fi_year']; ?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo $row5['r_name']; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
                                <td><center><?php echo $row['bfi_by']; ?></center></td>
                                <td><center>Rs. <?php echo number_format($row['fi_total'],2); ?></center></td>
                                <td>
                                	<?php if($row['i_status']==1)
                                	    echo 'Rejected';
                                	  else
                                	  	echo 'Paid';
                                	?>
                                </td>
								 <?php 
							$count++;
							} ?>                               																
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
                jQuery(document).ready(function($) {
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

</form>

<!-- end scripts-->

<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
     chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7 ]>
  <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->
 <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
	});
	function redirect(val){
	
    var cid =document.getElementById('bid').value;
	//alert(cid);	
    window.location.href = 'busfeesbilling_print.php?bid='+cid+'&status='+val;   
  }
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'busfeesbilling_print.php?bid='+cid;	  
	} 
  </script>
<?php include("roll_footer.php"); ?> 
</body>
</html>
<? ob_flush(); ?>