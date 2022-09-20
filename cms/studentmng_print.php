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
                            <h3> <?php echo $class['c_name'] . "-" . $section['s_name']; ?> Student List</h3><br>
                            <div class="modal-body"> 
                                <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;">


                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                    <th>Admin No</th>
                                     <th width='90'>Roll No</th>
                                    <th><center>Student Name</center></th>
                                    
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    </tr>
									</thead>
								<tbody>
                            <?php 
                            
                            $setting_on=$_GET["order_gender"];
                            
                            if($setting_on=="male")
                            {
                                
                                $s_gen=array("M","F");
                                
                            }else if ($setting_on=="female"){
                                
                                $s_gen=array("F","M");
                            }else{
                                $s_gen=array("M","F");
                                
                            }
                            
                            $count=1;
                            for($i=0;$i<2;$i++)
                            {                            
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear AND b_id=$bid and gender='$s_gen[$i]' ORDER BY firstname ASC");							
			  while($row=mysql_fetch_array($qry))
        		{?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                 <td><center><?= $row['roll_no']?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></center></td>
                               
                                <td><center><?php echo $row['dob']; ?></center></td>
                                <td><center><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><center><?php echo $row['phone_number']; ?></center></td>
                               
                                
								
								</tr> 
                                                     <!-- Modal Box Content -->
			<div id="info-dialog<?php echo $count;?>" title="<?php echo $row['admission_number']; ?>, This student details" style="display: none;">
            <center><img src="./img/student/<?php echo $row['photo']; ?>" alt="student photo" width="60" height="60"></center>
				<p>Admin NO : <strong><?php echo $row['admission_number']; ?></strong></p>
                
                <p>application NO : <strong><?php echo $row['application']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['firstname']; ?></strong></p> 
                
                <p>Last Name : <strong><?php echo $row['lastname']; ?></strong>  </p>   
                
                <p>Father / Guardian Name: <strong><?php echo $row['fathersname']; ?></strong>  </p>   
                
                <p>Father / Guardian Occupation : <strong><?php echo $row['fathersocupation']; ?></strong>  </p> 
                
                <p>Father / Guardian Monthly Income : <strong><?php echo $row['p_income']; ?></strong>  </p> 
                
                <p>Mother's Name : <strong><?php echo $row['m_name']; ?></strong>  </p> 
                
                <p>Mother's Occupation : <strong><?php echo $row['m_occup']; ?></strong>  </p> 
                
                <p>Mother's Monthly Income : <strong><?php echo $row['m_income']; ?></strong>  </p>   
                
                <p>Date of admission :  <strong><?php echo $row['doa']; ?></strong>  </p>   
                
                <p>Date Of Birth : <strong><?php echo $row['dob']; ?></strong> </p>   
                
                <p>Gender : <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Nationality : <strong><?php echo $row['nation']; ?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong> </p>   
                
                <p>Caste : <strong><?php echo $row['caste']; ?></strong>  </p>   
                
                <p>Subcaste : <strong><?php echo $row['sub_caste']; ?></strong>  </p>   
                
                <p>Blood Group : <strong><?php echo $row['blood']; ?></strong> </p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>  
                
                <p>Phone : <strong><?php echo $row['phone_number']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong>  </p>   
                
                <p>Residence Address2 : <strong><?php echo $row['address2']; ?></strong> </p>   
                
                <p>Town or village Name : <strong><?php echo $row['city_id']; ?></strong> </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p> 
                
                <p>Pin Code : <strong><?php echo $row['pin']; ?></strong> </p>   
                
                <p>Mother Tongue : <strong><?php echo $row['mother_tongue']; ?></strong> </p>   
                
                <p>Height : <strong><?php echo $row['height']; ?></strong> </p>
                
                <p>Weight : <strong><?php echo $row['weight']; ?></strong> </p>
                
                <p>Remarks : <strong><?php echo $row['remarks']; ?></strong> </p>
                
                <p>student type : <strong><?php echo $row['stype']; ?></strong> </p>
                
                <?php 
				$fdis_id=$row['fdis_id'];
				if($fdis_id){ 
				//$rid1=$invoice['r_id'];
								  $qry6=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdis_id"); 
								  $row6=mysql_fetch_array($qry6);
				?>
                <p>Student Category  : <strong><?php echo $row6['fdis_name']; ?></strong> </p>   
                <?php } $rid=$row['r_id'];
				$spid=$row['sp_id'];
				if($rid){ 
				//$rid1=$invoice['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $row5=mysql_fetch_array($qry5);
				?>
                <p>Bus Route Name : <strong><?php echo $row5['r_name']; ?></strong> </p>   
                <?php } if($spid){
					 $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid"); 
								  $row6=mysql_fetch_array($qry6);?>				
                <p>Stopping Point : <strong><?php echo $row6['stop_name']; ?></strong> </p> 
                
                <?php } 
						$fesstypearray=array("Normal Fees","Sp.Fees","Onetime Sp.Fees");
						$busfeestype=$row['busfeestype'];
				 	 if($rid){ 
					 ?>				
                <p>Bus Fees Rate Type : <strong><?php echo $fesstypearray[$busfeestype]; ?></strong> </p> 
                <?php } ?>
                <p>Status  : <?php if($row['user_status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </p>
                </div>
                				
			</div> <!--! end of #info-dialog -->
            
                                 <?php 
                                 $count++;
							}
							
                            } ?>                               																
							</tbody>
                                </table>
                            </div>
							<?php } ?>
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
<script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'student_mng.php?bid='+cid;	  
	} 
  </script>
<!-- end scripts-->

<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
     chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7 ]>
  <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->
<script type="text/javascript">
    function showCategory(str) {
        if (str == "") {
            document.getElementById("sid").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }

function gender_order()
{
var order_gender=$("#order_gender").val();
window.location.href="student_mng.php?cid=<?=$cid?>&sid=<?=$sid?>&bid=<?=$bid?>&order_gender="+order_gender;
 

	
}
  function rollUpdate(id,ayid,roll_no){
    //alert(id);
  $.ajax({
  //type: "POST"
  url: "rollno_edit.php",
  data: {ss_id:id,ay_id:ayid,roll:roll_no},
  success: function(data) {
         alert(data);
      }
  
});

  }      
</script>  
<?php include("roll_footer.php"); ?> 
</body>
</html>
<? ob_flush(); ?>