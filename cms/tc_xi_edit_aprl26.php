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
	$personmark=mysql_real_escape_string($_POST['personmark']);
	$scholarship=mysql_real_escape_string($_POST['scholarship']);
	$scholarshipreason=mysql_real_escape_string($_POST['scholarshipreason']);
	$medicalissue=mysql_real_escape_string($_POST['medicalissue']);
	$doandclass=mysql_real_escape_string($_POST['doandclass']);
	$mreson=mysql_real_escape_string($_POST['medicalissue_reson']);
	$cert_no=mysql_real_escape_string($_POST['cert_no']);
    $reg_no=mysql_real_escape_string($_POST['reg_no']);

	
	if($standard=="XI" || $standard=="XII"){
		$offer=mysql_real_escape_string($_POST['offer']);
		$generaleducation=mysql_real_escape_string($_POST['generaleducation']);
		$vocationaleducation=mysql_real_escape_string($_POST['vocationaleducation']);
		$Languageoffer=mysql_real_escape_string($_POST['Languageoffer']);
	}

//echo $standard;
if($standard=="XI" || $standard=="XII"){

$sql="UPDATE tc_xi SET ano='$ano',tno='$tno',eno='$eno',sname='$sname',sex='$sex',fname='$fname',mname='$mname',nation='$nation',religion='$religion',dobfigure='$dobfigure',dobword='$dobword',leaving='$leaving',high_language='$high_language',high_elective='$high_elective',med_ins1='$med_ins1',doa='$doa',q_std='$q_std',due_school='$due_school',last_att='$last_att',school_left='$school_left',dtc1='$dtc1',dtc='$dtc',purpose='$purpose',no_day_att='$no_day_att',conduct='$conduct',academic_year='$academic_year',standard='$standard',first_lan='$first_lan',med_ins='$med_ins',b_id='$bid',revenueplace='$revenueplace',schoolplace='$schoolplace',AdiDravidar='$AdiDravidar',mostbackclass='$mostbackclass',convertedclass='$convertedclass',denoty='$denoty',personmark='$personmark',scholarship='$scholarship',scholarshipreason='$scholarshipreason',medicalissue='$medicalissue',backclass='$backclass',doandclass='$doandclass',offer='$offer',generaleducation='$generaleducation',vocationaleducation='$vocationaleducation',Languageoffer='$Languageoffer',medicalissue_reson='$mreson',cert_no='$cert_no',reg_no='$reg_no' WHERE id=$tcid";
} else {

$sql="UPDATE tc_xi SET ano='$ano',tno='$tno',eno='$eno',sname='$sname',sex='$sex',fname='$fname',mname='$mname',nation='$nation',religion='$religion',dobfigure='$dobfigure',dobword='$dobword',leaving='$leaving',high_language='$high_language',high_elective='$high_elective',med_ins1='$med_ins1',doa='$doa',q_std='$q_std',due_school='$due_school',last_att='$last_att',school_left='$school_left',dtc1='$dtc1',dtc='$dtc',purpose='$purpose',no_day_att='$no_day_att',conduct='$conduct',academic_year='$academic_year',standard='$standard',first_lan='$first_lan',med_ins='$med_ins',b_id='$bid',revenueplace='$revenueplace',schoolplace='$schoolplace',AdiDravidar='$AdiDravidar',mostbackclass='$mostbackclass',convertedclass='$convertedclass',denoty='$denoty',personmark='$personmark',scholarship='$scholarship',scholarshipreason='$scholarshipreason',medicalissue='$medicalissue',backclass='$backclass',doandclass='$doandclass',medicalissue_reson='$mreson',cert_no='$cert_no',reg_no='$reg_no' WHERE id=$tcid";	
}

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();
    if($result){
        header("Location:tc_xi_edit.php?bid=$bid&tcid=$tcid&msg=succ");
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
				<li class="no-hover"><a href="tc_xi.php?bid=<?php echo $bid;?>" title="Home">Transfer Certificate</a></li>
                <li class="no-hover">Edit Transfer Certificate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Transfer Certificate</h1>                
			<a href="tc_xi.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc.php?tcid=<?php echo $_GET['tcid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Edited Certificate</button></a></center>
            </div>
            <?php }
						$tcid=$_GET['tcid'];
							$stafflist=mysql_query("SELECT * FROM tc_xi WHERE id=$tcid"); 
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
                        <?php if($namereleave=="X" || $namereleave=="XII") { ?>
                        <div class="_25">
							<p>
                                <label for="textfield">Certificate Number : <span class="error">*</span></label>
                                <input id="textfield" name="cert_no" class="required" type="text" value="<?= $row['cert_no']?>"/>
                            </p>
						</div>
                        <div class="_25">
                            <p>
                                <label for="textfield">Registration Number : <span class="error">*</span></label>
                                <input id="textfield" name="reg_no" class="required" type="text" value="<?= $row['reg_no']?>" />
                            </p>
                        </div>
                        <?php }  else {?>
                        <input id="textfield" name="cert_no"  type="hidden" value="0000"/>
                        <input id="textfield" name="reg_no"  type="hidden" value="0000" />
                        <?php }	?> 
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
                                <label for="textfield">Name of the Educational District : <span class="error">*</span></label>
                                <input id="textfield" name="revenueplace" class="required" type="text" value="<?php echo $row['revenueplace'] ?>" />
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Name of the Revenue District : <span class="error">*</span></label>
                                <input id="textfield" name="schoolplace" class="required" type="text" value="<?php echo $row['schoolplace'] ?>" />
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
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Mother  :<span class="error">*</span></label>
                                <input id="textfield" name="mname"  type="text" class="required" value="<?php echo $row['mname'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Nationality : <span class="error">*</span></label>
                                <input id="textfield" name="nation" class="required" type="text" value="<?php echo $row['nation'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Religion, Caste & Community : <span class="error">*</span></label>
                                <input id="textfield" name="religion" class="required" type="text" value="<?php echo $row['religion'];?>" />
                            </p>
						</div>

						<div class="_100" style="clear: both;">
							<p>
						<label>If the pupil belongs to any one of the five categories mentioned below, choose "Yes" against the relevant Column </label>
						</p>
						</div>

						<div class="_50" style="clear: both;">
							<p>

                                <label for="textfield">a, Adi Dravidar (Scheduled Caste or Scheduled Tribe) <span class="error">*</span></label>
                                <select id="textfield" name="AdiDravidar" class="required">
                                <option>Select</option>
                                <?php if($row['AdiDravidar']=="Yes") { ?>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                                <?php } else if($row['AdiDravidar']=="No") { ?>
                                <option value="Yes">Yes</option>
                                <option value="No" selected>No</option>
                                <?php } else { ?>
								<option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <?php } ?>
                                </select>
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">b, Backward Class <span class="error">*</span></label>
                                <select id="textfield" name="backclass" class="required">
                                <option>Select</option>
                                <?php if($row['backclass']=="Yes") { ?>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                                <?php } else if($row['backclass']=="No") { ?>
                                <option value="Yes">Yes</option>
                                <option value="No" selected>No</option>
                                <?php } else { ?>
								<option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <?php } ?>
                                </select>
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">c, Most Backward Class <span class="error">*</span></label>
                                <select id="textfield" name="mostbackclass" class="required">
                                <option>Select</option>
                                <?php if($row['mostbackclass']=="Yes") { ?>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                                <?php } else if($row['mostbackclass']=="No") { ?>
                                <option value="Yes">Yes</option>
                                <option value="No" selected>No</option>
                                <?php } else { ?>
								<option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <?php } ?>
                                </select>
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">d, Converted to Christianity from Scheduled Caste <span class="error">*</span></label>
                                <select id="textfield" name="convertedclass" class="required">
                                <option>Select</option>
                                <?php if($row['convertedclass']=="Yes") { ?>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                                <?php } else if($row['convertedclass']=="No") { ?>
                                <option value="Yes">Yes</option>
                                <option value="No" selected>No</option>
                                <?php } else { ?>
								<option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <?php } ?>
                                </select>
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">e, Denotified Tribes <span class="error">*</span></label>
                                <select id="textfield" name="denoty" class="required">
                                <option>Select</option>
                                <?php if($row['denoty']=="Yes") { ?>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                                <?php } else if($row['denoty']=="No") { ?>
                                <option value="Yes">Yes</option>
                                <option value="No" selected>No</option>
                                <?php } else { ?>
								<option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <?php } ?>
                                </select>
                            </p>
						</div>
                         <div class="_50">
							<p>
                                <label for="textfield">Gender : <span class="error">*</span></label>
                                <input id="textfield" name="sex" class="required"  type="text" value="<?php echo $row['sex'];?>" />
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
						<div class="_50">
							<p>
                                <label for="textfield">Personal Marks of Identification</label>
                                <input id="textfield" name="personmark" type="text" value="<?php echo $row['personmark'];?>" />
                            </p>
						</div>
						<div class="_100">
							<p>
							
                                <label for="textfield">Date of Admission and Standard in which admitted (the year to be entered in words)  <span class="error">*</span></label>
                                <input id="textfield" name="doandclass" class="required" type="text" value="<?php echo $row['doandclass'];?>" />
                            </p>
						 </div>
                        <div class="_100">
							<p>
                                <label for="textfield">Standard in which the pupil was studying at the time of leaving (In words) : <span class="error">*</span></label>
                                <input id="textfield" name="leaving" class="required" type="text" value="<?php echo $row['leaving'];?>" />
                            </p>
						 </div>

						  <?php if($row['standard']=='XI' || $row['standard']=='XII') { ?>`
						 <div class="_50">
							<p>
                                <label for="textfield">The course offered, i.e. General Education Vocational Education : </label>
                                <input id="textfield" name="offer" class="" type="text" value="<?php echo $row['offer'];?>" />
                            </p>
						 </div>
						  <div class="_50">
							<p>
                                <label for="textfield">In the case of General Education the Subjects offered under part-III Group-A and Medium or Instruction : </label>
                                <input id="textfield" name="generaleducation" class="" type="text" value="<?php echo $row['generaleducation'];?>" />
                            </p>
						 </div>
						  <div class="_50">
							<p>
                                <label for="textfield"> In the case of Vocational Education the Vocational Subject under part-III group-B and the related subject offered under part-III Group-(A) : <span class="error">*</span></label>
                                <input id="textfield" name="vocationaleducation" class="" type="text" value="<?php echo $row['vocationaleducation'];?>" />
                            </p>
						 </div>
						 <div class="_50">
							<p>
                                <label for="textfield">Language offered under PartI : <span class="error">*</span></label>
                                <input id="textfield" name="Languageoffer" class="" type="text" value="<?php echo $row['Languageoffer']?>" />
                            </p>
						 </div>
						
						<?php }	?>

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
					<div class="_50">
							<p>
                                <label for="textfield">Whether the pupil has paid all the fees :</label>
                             <select id="textfield" name="due_school" class="required">
                                <?php if($row['due_school']!="Yes"){ ?>
                                <option value="No" selected=true>No</option>
                                <option value="Yes">Yes</option>
                                <?php } else { ?>
                                <option value="Yes" selected=true>Yes</option>
                                <option value="No">No</option>
                                <?php } ?>
                                </select>
                            </p>
						 </div>
						 <div class="_50">
							<p>
                                <label for="textfield">Whether the pupil has in receipt of any Scholarship (Nature of the Scholarship to be specified) or any Educational Concessions :</label>
                                <select id="textfield" name="scholarship" class="required" onchange="sreson(this.value)">
                               <?php if($row['s_ship']=="Yes"){
                                	echo '<option value="Yes" selected=true>Yes</option>';
                                	echo '<option value="No">No</option>';
                                }
                                if($row['s_ship']=="No"){
                                	echo '<option value="No" selected=true>No</option>';
                                	echo '<option value="Yes">Yes</option>';
                                }
                                if($row['s_ship']=="" || $row['s_ship']=="0"){
                                	echo '<option value="No">No</option>';
                                	echo '<option value="Yes">Yes</option>';
                                }
                                ?>
                                </select><br><br>
                                <?php if($row['s_ship']=="Yes") {?>
                                <span id="sreson"><input id="textfield" name="scholarshipreson"  type="text" value="<?php echo $student['s_reson'];?>" /></span>
                                <?php } ?>
                                <?php if($row['s_ship']=="No") {?>
                                <span id="sreson" style="display:none;"><input id="textfield" name="scholarshipreson"  type="text" value="" /></span>
                                <?php } ?>
                                <?php if($row['s_ship']=="" || $row['s_ship']=="0") {?>
                                <span id="sreson" style="display:none;"><input id="textfield" name="scholarshipreson"  type="text" value="" /></span>
                                <?php } ?>
                            </p>
						 </div>
						   <div class="_50">
							<p>
                                <label for="textfield">Whether the pupil has undergone Medical Inspection, if any during the academic year (First or repeat to be specified) :</label>
                                <select name="medicalissue" id="missue" onchange="mreson(this.value)">
                               <?php 
                                   	if($row['medicalissue']=="No") 
                                    	echo '<option value="No" selected>No</option>';
                                	else 
                               			echo '<option value="No">No</option>';
                               		if($row['medicalissue']=="Yes") 
                                    	echo '<option value="Yes" selected>Yes</option>';
                                	else
                                		echo '<option value="Yes">Yes</option>';	
                                
                                ?>
                                </select><br><br>
                                <?php if($row['medicalissue']=="Yes") {?>
                             <div id="mreson">

                                <span><input id="textfield" name="medicalissue_reson" type="text" value="<?= $row['medicalissue_reson']?>" /></span>
                               </div>
                               <?php } ?>
                               <?php if($row['medicalissue']=="No") {?>
                             <div id="mreson" style="display: none;">

                                <span><input id="textfield" name="medicalissue_reson" type="text" value="<?= $row['medicalissue_reson']?>" /></span>
                               </div>
                               <?php } ?>
                                
                            </p>
						 </div>
						 <div class="_25" style="clear: both;">
							<p>
                                <label for="textfield">Date of pupil’s last attendance of School: </label>
                                <input id="datepicker4" name="last_att"  type="text" value="<?php echo $row['last_att'];?>" />
                            </p>
						</div>
						<div class="_25">
							<p>
                                <label for="textfield">Date of application for TC by Parent/Guardian :</label>
                                <input id="datepicker3" name="dtc1" type="text" value="<?php echo $row['dtc1'];?>" />
                            </p>
						</div>

						<div class="_25">
							<p>
                                <label for="textfield">Date of issue of TC:</label>
                                <input id="datepicker2" name="dtc" type="text" value="<?php echo $row['dtc'];?>" />
                            </p>
						</div>

						<div class="_100">
							<p>
                                <label for="textfield">Reasons for leaving<font color="red">*</font></label>
                                <input id="purpose"  name="purpose" class="required" type="text" value="<?php echo $row['purpose'];?>" />
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">The Pupil's Conduct :</label>
                                <select id="textfield" name="conduct" class="required">
                                <option>Select</option>
                                <?php if($row['conduct']=="Excelent") { ?>
                                <option value="Excelent" selected>Excelent</option>
								<?php } else { ?>
                                <option value="Excelent">Excelent</option>
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

						<div class="_25">
							<p>
                                <label for="textfield">Academic Year : <span class="error">*</span></label>
                                <input id="textfield" name="academic_year" class="required" type="text" value="<?php echo $row['academic_year'];?>" />
                            </p>
						</div>
						 <div class="_25">
							<p>
								<label for="select">Standard(s) Studied : <span class="error">*</span></label>
                                <input id="textfield" name="standard" class="required" type="text" value="<?php echo $row['standard'];?>" />								
							</p>
						</div>
						 <div class="_50">
							<p>
								<label for="select">Second Language : </label>
                                <input id="textfield" name="first_lan" type="text" value="<?php echo $row['first_lan'];?>" />
							</p>
						</div> 

                        <div class="_50">
							<p>
                                <label for="textfield">Medium Instruction :</label>
                                <input id="textfield" name="med_ins1" type="text" value="<?php echo $row['med_ins1'];?>" />
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