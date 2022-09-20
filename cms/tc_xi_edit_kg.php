<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];

 
 if (isset($_POST['submit']))
{	
	$ano=mysql_real_escape_string($_POST['ano']);
	$tno=mysql_real_escape_string($_POST['tno']);
	$eno=mysql_real_escape_string($_POST['eno']);
	$sname=mysql_real_escape_string($_POST['sname']);
	$fname=mysql_real_escape_string($_POST['fname']);
	$sex=mysql_real_escape_string($_POST['sex']);
	$mname=mysql_real_escape_string($_POST['mname']);
	$nation=mysql_real_escape_string($_POST['nation']);
	$religion=mysql_real_escape_string($_POST['religion']);
	$dobfigure=mysql_real_escape_string($_POST['dobfigure']);
	$dobword=mysql_real_escape_string($_POST['dobword']);
	$leaving=mysql_real_escape_string($_POST['leaving']);
	$high_language=mysql_real_escape_string($_POST['high_language']);
	$high_elective=mysql_real_escape_string($_POST['high_elective']);
	$med_ins1=mysql_real_escape_string($_POST['med_ins1']);
	$doa=mysql_real_escape_string($_POST['doa']);
	$q_std=mysql_real_escape_string($_POST['q_std']);
	$due_school=mysql_real_escape_string($_POST['due_school']);
	$last_att=mysql_real_escape_string($_POST['last_att']);
	$school_left=mysql_real_escape_string($_POST['school_left']);
	$dtc1=mysql_real_escape_string($_POST['dtc1']);
	$dtc=mysql_real_escape_string($_POST['dtc']);
	$purpose=mysql_real_escape_string($_POST['purpose']);
	$no_day_att=mysql_real_escape_string($_POST['no_day_att']);
	$conduct=mysql_real_escape_string($_POST['conduct']);
	$academic_year=mysql_real_escape_string($_POST['academic_year']);
	$standard=mysql_real_escape_string($_POST['standard']);
	$first_lan=mysql_real_escape_string($_POST['first_lan']);
	$med_ins=mysql_real_escape_string($_POST['med_ins']);
	$tcid=$_POST['tcid'];
	$bid=$_POST['bid'];

	$revenueplace=mysql_real_escape_string($_POST['revenueplace']);
	$schoolplace=mysql_real_escape_string($_POST['schoolplace']);
	$AdiDravidar=mysql_real_escape_string($_POST['AdiDravidar']);
	$backclass=mysql_real_escape_string($_POST['backclass']);
	$mostbackclass=mysql_real_escape_string($_POST['mostbackclass']);
	$convertedclass=mysql_real_escape_string($_POST['convertedclass']);
	$denoty=mysql_real_escape_string($_POST['denoty']);
	$personmark=mysql_real_escape_string($_POST['personmarka']).'*||*'.mysql_real_escape_string($_POST['personmarkb']);
	$scholarship=mysql_real_escape_string($_POST['scholarship']);
	$scholarshipreason=mysql_real_escape_string($_POST['scholarshipreason']);
	$medicalissue=mysql_real_escape_string($_POST['medicalissue']);
	$doandclass=mysql_real_escape_string($_POST['doandclass']);
	$mreson=mysql_real_escape_string($_POST['medicalissue_reson']);
	$cert_no=mysql_real_escape_string($_POST['cert_no']);
    $reg_no=mysql_real_escape_string($_POST['reg_no']);
    $tmr_no=mysql_real_escape_string($_POST['tmr_no']);
    $na_en=mysql_real_escape_string($_POST['na_en']);
     $cos=mysql_real_escape_string($_POST['cos']);
	
		$offer=mysql_real_escape_string($_POST['offer']);
		$generaleducation=mysql_real_escape_string($_POST['generaleducation']);
		$vocationaleducation=mysql_real_escape_string($_POST['vocationaleducation']);
		$Languageoffer=mysql_real_escape_string($_POST['Languageoffer']);
	

//echo $standard;


$sql="UPDATE tc_xi_kg SET ano='$ano',tno='$tno',eno='$eno',sname='$sname',sex='$sex',fname='$fname',mname='$mname',nation='$nation',religion='$religion',dobfigure='$dobfigure',dobword='$dobword',leaving='$leaving',high_language='$high_language',high_elective='$high_elective',med_ins1='$med_ins1',doa='$doa',q_std='$q_std',due_school='$due_school',last_att='$last_att',school_left='$school_left',dtc1='$dtc1',dtc='$dtc',purpose='$purpose',no_day_att='$no_day_att',conduct='$conduct',academic_year='$academic_year',standard='$standard',first_lan='$first_lan',med_ins='$med_ins',b_id='$bid',revenueplace='$revenueplace',schoolplace='$schoolplace',AdiDravidar='$AdiDravidar',mostbackclass='$mostbackclass',convertedclass='$convertedclass',denoty='$denoty',personmark='$personmark',scholarship='$scholarship',scholarshipreason='$scholarshipreason',medicalissue='$medicalissue',backclass='$backclass',doandclass='$doandclass',offer='$offer',generaleducation='$generaleducation',vocationaleducation='$vocationaleducation',Languageoffer='$Languageoffer',medicalissue_reson='$mreson',cert_no='$cert_no',reg_no='$reg_no',tmr_no='$tmr_no',na_en='$na_en',cos='$cos' WHERE id=$tcid";


$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();
    if($result){
        header("Location:tc_xi_edit_kg.php?bid=$bid&tcid=$tcid&msg=succ");
    }
    exit;
}
 ?>
</head>

<body id="top">

  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <?php include("includes/header.php");?>
    <!--! end of #header -->
    
    <div class="fix-shadow-bottom-height"></div>
	
	<!-- Begin of Sidebar -->
    <aside id="sidebar">
    	<!-- Search -->
    	    	<?php include("includes/search.php"); ?>
 <!--! end of #search-bar -->
		
		<!-- Begin of #login-details -->
		<?php include("includes/login-details.php");?>
         <!--! end of #login-details -->
    	
    	<!-- Begin of Navigation -->
    	<?php include("nav.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">    				
    	<!-- Begin of titlebar/breadcrumbs -->
        <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_tc10.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="tc_xi_kg.php?bid=<?php echo $bid;?>" title="Home">Transfer Certificate</a></li>
                <li class="no-hover">Edit Transfer Certificate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Transfer Certificate</h1>                
			<a href="tc_xi_kg.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc_kg.php?tcid=<?php echo $_GET['tcid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Edited Certificate</button></a></center>
            </div>
            <?php }
						$tcid=$_GET['tcid'];
							$stafflist=mysql_query("SELECT * FROM tc_xi_kg WHERE id=$tcid"); 
								  $row=mysql_fetch_array($stafflist);
								  
								  $ssid=$row['ss_id'];
								  $studentlist=mysql_query("SELECT c_id,s_id FROM student WHERE ss_id='$ssid'"); 
								  $student=mysql_fetch_array($studentlist);
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $attlist=mysql_query("SELECT day,month,year FROM attendance WHERE c_id=$cid AND s_id=$sid AND ss_id=$ssid AND ay_id=$acyear AND (result=1 OR result='off') ORDER BY month,day DESC LIMIT 0,1");
								  $attdate=mysql_fetch_assoc($attlist); 
								  $attlist1=mysql_query("SELECT SUM(result) as result FROM attendance WHERE c_id=$cid AND s_id=$sid AND ss_id=$ssid AND ay_id=$acyear AND result='1'");
								  $attdate1=mysql_fetch_array($attlist1);
								 $total_off=mysql_num_rows(mysql_query("SELECT att_id FROM attendance WHERE c_id=$cid AND s_id=$sid AND ss_id=$ssid AND ay_id=$acyear AND result='off'"));
								 $totalprecent=$attdate1['result']+($total_off/2);

							 $adno=$row['ano'];
							 $aclass1=mysql_query("select * from student where admission_number='$adno' order by ss_id DESC");
							 $row1=mysql_fetch_assoc($aclass1);
							 $cidr=$row1['c_id'];
							 $classreleave=mysql_query("SELECT * FROM class WHERE c_id=$cidr"); 
							 $namereleave=mysql_fetch_array($classreleave)['c_name'];
								//echo  $namereleave;
			 ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Transfer Certificate</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    
                                <input id="textfield" name="eno" class="required" type="hidden" value="<?php echo $row['eno'];?>">
                       
                        <div class="_25" style="clear: both;">
                            <p>
                                <label for="textfield">Rc.No : <span class="error">*</span></label>
                                <input id="textfield" name="na_en" class="required" type="text" value="<?= $row['na_en']?>" />
                            </p>
                        </div>
                        <div class="_25">
							<p>
                                <label for="textfield">Admission Number : <span class="error">*</span></label>
                                <input id="textfield" name="ano" class="required" type="text" value="<?php echo $row['ano'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">TC Number : <span class="error">*</span></label>
                                <input id="textfield" name="tno" class="required" type="text" value="<?php echo $row['tno'];?>" />
                            </p>
						</div>
						
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Pupil : <span class="error">*</span></label>
                                <input id="textfield" name="sname" class="required" type="text" value="<?php echo $row['sname'];?>" />
                            </p>
						</div>
                       
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Parent/Guardian  :<span class="error">*</span></label>
                                <input id="textfield" name="fname"  type="text" class="required" value="<?php echo $row['fname'];?>" />
                            </p>
						</div>
                        
                         
                        <div class="_100">
							<p>
                                <label for="textfield">Date of Birth as entered in the admission register : </label>
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">a) In figures :</label>
                                <input id="textfield" name="dobfigure" type="text" value="<?php echo $row['dobfigure'];?>" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield"> b) In words :</label>
                                <input id="textfield" name="dobword" type="text" value="<?php echo $row['dobword'];?>" />
                            </p>
						</div>
						
						<div class="_100">
							<p>
							
                                <label for="textfield">Date of Admission  <span class="error">*</span></label>
                                <input id="textfield" name="doandclass" class="required" type="text" value="<?php echo $row['doandclass'];?>" />
                            </p>
						 </div>
                        <div class="_100">
							<p>
                                <label for="textfield">Standard in which the pupil was studying at the time of leaving (In words) : <span class="error">*</span></label>
                                <input id="textfield" name="leaving" class="required" type="text" value="<?php echo $row['leaving'];?>" />
                            </p>
						 </div>

						 

						 <div class="_50" style="clear: both;">
							<p>
                                <label for="textfield">Whether qualified for promotion to higher standard :</label>
                               <select id="textfield" name="q_std" class="required">
                                <option>Select</option>
                                <?php 
                                echo $row['q_std']; 
                                if($row['q_std']=="Yes") { ?>
                                <option value="Yes" selected=true>Yes</option>
                                <option value="No">No</option>
                                <?php } else if($row['q_std']=="No") { ?>
                                <option value="Yes">Yes</option>
                                <option value="No" selected=true>No</option>
                                <?php } else { ?>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <?php } ?>
                                </select>
                            </p>
						 </div>
					
						 			 
						 <div class="_25" style="clear: both;">
							<p>
                                <label for="textfield">Date of Leaving: </label>
                                <input id="datepicker4" name="last_att"  type="text" value="<?php echo $row['last_att'];?>" />
                            </p>
						</div>
						

						

						
						<div class="_50">
							<p>
                                <label for="textfield">The Pupil's Conduct :</label>
                                <select id="textfield" name="conduct" class="required">
                                <option>Select</option>
                                <?php if($row['conduct']=="Excellent") { ?>
                                <option value="Excellent" selected>Excellent</option>
								<?php } else { ?>
                                <option value="Excellent">Excellent</option>
                                <?php } ?>
                                <?php if($row['conduct']=="Good") { ?>
                                <option value="Good" selected>Good</option>
                                <?php } else { ?>
                                <option value="Good">Good</option>
                                <?php } ?>
                                 <?php if($row['conduct']=="Poor") { ?>
                                <option value="Poor" selected>Poor</option>
                                 <?php  } else { ?>
                                 <option value="Poor">Poor</option>
                                 <?php } ?>
                                </select>
                            </p>
						</div>

						
						
						 
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="tcid" value="<?php echo $_GET['tcid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                           	<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
            
            
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  <script defer src="js/zebra_datepicker.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
   function sreson(val){
	//alert(val);
	if(val=="Yes")
		$('#sreson').show();
	else
		$('#sreson').hide();
}
function mreson(val){
    //alert(val);
    if(val=="Yes")
        $('#mreson').show();
    else
        $('#mreson').hide();
}
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
		});			
			$( "#datepicker1" ).Zebra_DatePicker({
			format: 'd/m/Y'
		});			
			$( "#datepicker2" ).Zebra_DatePicker({
			format: 'd/m/Y'
		});			
		$( "#datepicker3" ).Zebra_DatePicker({
			format: 'd/m/Y'
		});	
		$( "#datepicker4" ).Zebra_DatePicker({
			format: 'd/m/Y'
		});	
	});
	
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>