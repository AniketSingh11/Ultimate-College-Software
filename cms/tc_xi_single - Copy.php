<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname']; 
 if (isset($_POST['submit']))
{	
	$ano=$_POST['ano'];
	$tno=$_POST['tno'];
	$eno=$_POST['eno'];
	$sname=$_POST['sname'];
	$fname=$_POST['fname'];
	$nation=$_POST['nation'];
	$community=$_POST['community'];
	$adidravidar=$_POST['adidravidar'];
	$bc=$_POST['bc'];
	$mbc=$_POST['mbc'];
	$convert_christ=$_POST['convert_christ'];
	$de_community=$_POST['de_community'];
	$sex=$_POST['sex'];
	$dob=$_POST['dob'];
	$identity1=$_POST['identity1'];
	$identity2=$_POST['identity2'];
	$doa=$_POST['doa'];
	$leaving=$_POST['leaving'];
	$course_offer=$_POST['course_offer'];
	$education_iii=$_POST['education_iii'];
	$education_iiia=$_POST['education_iiia'];
	$language=$_POST['language'];
	$medium=$_POST['medium'];
	$edu_rule=$_POST['edu_rule'];
	$due_school=$_POST['due_school'];
	$scholarship=$_POST['scholarship'];
	$med_inspection=$_POST['med_inspection'];
	$school_left=$_POST['school_left'];
	$conduct=$_POST['conduct'];
	$guardian=$_POST['guardian'];
	$dtc=$_POST['dtc'];
	$dtc1=$_POST['dtc1'];
	$course=$_POST['course'];
	$academic_year=$_POST['academic_year'];
	$standard=$_POST['standard'];
	$first_lan=$_POST['first_lan'];
	$med_ins=$_POST['med_ins'];
	$bid=$_POST['bid'];
	$emisno1=$_POST['emisno1'];
	$tcno1=$_POST['tcno1'];
	$purpose=$_POST['purpose'];
	
	$full_details=$_POST['full_details'];
	$q_std=$_POST['q_std'];
	$r_ship=$_POST['r_ship'];
	
	$ssid=$_POST['ssid'];
	
	
	$qry1=mysql_query("select * from tc_xi where ay_id='$acyear' and a_no='$ano' and b_id='$bid' ");
	
	if(mysql_num_rows($qry1)!=0){
	    $res1=mysql_fetch_array($qry1);
	
	    $ref_number=$res1["ref_number"];
	}else{
	
	
	    $adminlist=mysql_query("SELECT * FROM certificate_count WHERE cc_id='6'");
	    $admincount=mysql_fetch_array($adminlist);
	
	    $refno=$admincount['count'];
	    $refno2=$refno+1;
	    $ref_number="Tra".str_pad($refno, 3, '0', STR_PAD_LEFT);
	
	    $sql1=mysql_query("UPDATE certificate_count SET count='$refno2' WHERE cc_id='6'");
	}
	
	$del_tc=mysql_query("update student set user_status='0' where admission_number='$ano' and b_id='$bid' and  ay_id='$acyear'");
	
		$sql="INSERT INTO tc_xi (ano,tno,eno,sname,fname,nation,community,adidravidar,bc,mbc,convert_christ,de_community,sex,dob,identity1,identity2,doa,leaving,course_offer,education_iii,education_iiia,language,medium,edu_rule,due_school,scholarship,med_inspection,school_left,conduct,guardian,dtc,course,academic_year,standard,first_lan,med_ins,ay_id,b_id,purpose,ref_number,full_details,q_std,r_ship,dtc1,ss_id) VALUES
('$ano','$tno','$eno','$sname','$fname','$nation','$community','$adidravidar','$bc','$mbc','$convert_christ','$de_community','$sex','$dob','$identity1','$identity2','$doa','$leaving','$course_offer','$education_iii','$education_iiia','$language','$medium','$edu_rule','$due_school','$scholarship','$med_inspection','$school_left','$conduct','$guardian','$dtc','$course','$academic_year','$standard','$first_lan','$med_ins','$acyear','$bid','$purpose','$ref_number','$full_details','$q_std','$r_ship','$dtc1','$ssid')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();
    if($result){
		$sql1=mysql_query("UPDATE tc_no SET count='$tcno1' WHERE id='1'");
		$sql2=mysql_query("UPDATE tc_no SET count='$emisno1' WHERE id='2'");
        header("Location:tc_xi_single.php?bid=$bid&lid=$lastid&msg=succ");
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
                <li class="no-hover">Add new Transfer Certificate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Transfer Certificate</h1>                
			<a href="tc_xi.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			<?php $msg=$_GET['msg'];
			if($msg=="succ"){
				unset($_SESSION['tc']);?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc_xi_prt.php?tcid=<?php echo $_GET['lid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Created Certificate</button></a></center>
            </div>
            <?php }
			 if($_GET['roll']){ ?>
            <a href="tc_xi_single.php?bid=<?php echo $bid;?>"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Create Another One</button></a> <?php } ?>
			</div>
            <?php if(!$_GET['roll']){ ?>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Academic Year , Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get">
                    <div class="_50">
							<p>
								<label for="select" class="requered">Academic Year : <span class="error">*</span></label>
                                	<?php
                                	$ayid=$_GET['ayid'];
											$sayid=$_SESSION['tc']['ayid'];
											if(!$sayid){ unset($_SESSION['tc']);}
                                            $classl1 = "SELECT * FROM year ORDER BY ay_id DESC LIMIT 2";
                                            $result11 = mysql_query($classl1) or die(mysql_error());
                                            echo '<select name="ayid" id="ayid" class="required"> 
											<option value="">Select Academic Year</option>';
											while ($row11 = mysql_fetch_assoc($result11)):
												if($ayid == $row11['ay_id']){
                                                echo "<option value='{$row11['ay_id']}' selected>{$row11['y_name']}</option>\n";
												}else {
													echo "<option value='{$row11['ay_id']}'>{$row11['y_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
							</p>
						</div>
						<div class="_50">
                            <p>
                            <label for="required">Student Roll No:</label>
                            <input type="text" name="roll" class="biginput" class="requered" id="autocomplete" /> 
                            </p>
                            </div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
            <?php } if($_GET['roll']){ 
			
					$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1];  
					$ayid=$_GET['ayid'];

					//die();
					
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$ayid"); 
								  $student=mysql_fetch_array($studentlist);
								  if(!$student){
									  	unset($_SESSION['tc']);
										header("location:samacheer_x_single.php?bid=$bid");
									}
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  $rid=$student['r_id'];
								  $spid=$student['sp_id'];
								  if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  $yearlist=mysql_query("SELECT * FROM year WHERE ay_id=$ayid"); 
								  $ayears=mysql_fetch_array($yearlist);	
								  
								  $tcnolist=mysql_query("SELECT * FROM tc_no where id=1"); 
								  $tcno1=mysql_fetch_array($tcnolist);
								  $tcno=$tcno1['count'];	
								  $emislist=mysql_query("SELECT * FROM tc_no where id=2"); 
								  $emis=mysql_fetch_array($emislist);	
								  $emisno=$emis['count'];
								  }
			?>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc_xi_prt.php?tcid=<?php echo $_GET['lid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Created Certificate</button></a></center>
            </div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add new Transfer Certificate</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_25">
							<p>
                                <label for="textfield">EMIS Number : <span class="error">*</span></label>
                                <input id="textfield" name="eno" class="required" type="text" value="<?php echo "EMIS".str_pad($emisno, 5, '0', STR_PAD_LEFT);?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Admission Number : <span class="error">*</span></label>
                                <input id="textfield" name="ano" class="required" type="text" value="<?php echo $student['admission_number']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">TC Number : <span class="error">*</span></label>
                                <input id="textfield" name="tno" class="required" type="text" value="<?php echo "TC".str_pad($tcno, 5, '0', STR_PAD_LEFT);?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Pupil : <span class="error">*</span></label>
                                <input id="textfield" name="sname" class="required" type="text" value="<?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Father or Mother of the Pupil  :<span class="error">*</span></label>
                                <input id="textfield" name="fname"  type="text" class="required" value="<?php echo $student['fathersname']; ?>" />
                            </p>
						</div>
						 <div class="_50">
							<p>
                                <label for="textfield">Gender : <span class="error">*</span></label>
                                <input id="textfield" name="sex" class="required"  type="text" value="<?php if($student['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?>" />
                            </p>
						</div>
						  <div class="_50">
							<p>
                                <label for="textfield">Date of birth as entered in the Admission Register( in figures & words) :</label>
                                <input name="dob"  type="text" value="<?php echo $student['dob']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Nationality and Religion : <span class="error">*</span></label>
                                <input id="textfield" name="nation" class="required" type="text" value="<?php echo $student['reg']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Community : </label>
                                <input id="textfield" name="community" type="text" value="<?php echo $student['caste']; ?>" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">a) Adi Dravidar(Scheduled Caste) or (Scheduled Tribe) :</label>
                                <input id="textfield" name="adidravidar" type="text" value="" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield"> b) Backward Class :</label>
                                <input id="textfield" name="bc" type="text" value="" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">c) Most Backward Class :</label>
                                <input id="textfield" name="mbc" type="text" value="" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">d) Convert to Christianity from scheduled Caste or :</label>
                                <input id="textfield" name="convert_christ" type="text" value="" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">e) Denotified Communities :</label>
                                <input id="textfield" name="de_community" type="text" value="" />
                            </p>
						</div>
                       
                      
                        <div class="_50">
							<p>
                                <label for="textfield">Personal marks of Identification :(a)</label>
                                <input id="textfield" name="identity1" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">(b) &nbsp;</label>
                                <input id="textfield" name="identity2" type="text" value="" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Date of Admission and standard in which admitted( the year to be entered, in words) : <span class="error">*</span></label>
                                <input name="doa" class="required" type="text" value="<?php echo $student['doa']; ?>" />
                            </p>
						</div>
						
						  <div class="_100">
							<p>
                                <label for="textfield">Class in Which Last Studied(in words) : <span class="error">*</span></label>
                                <input id="textfield" name="full_details" class="required" type="text" value="" />
                            </p>
						 </div>
						 
						  <div class="_100">
							<p>
                                <label for="textfield">Whether qualified for promotion to Higher standard :</label>
                                <input id="textfield" name="q_std" class="required" type="radio" value="YES" />YES <input id="textfield" name="q_std" type="radio" value="NO" />NO
                            </p>
						 </div>
						
						 <div class="_100">
							<p>
                                <label for="textfield">Whether pupil was in receipt of scholarship :</label>
                                <input id="textfield" name="r_ship" class="required" type="radio" value="YES" />YES <input id="textfield" name="r_ship" type="radio" value="NO" />NO
                            </p>
						 </div>
						 
						 
						  <div class="_100">
							<p>
                                <label for="textfield">Whether the pupil has paid all the fees due to the school :</label>
                                <input id="textfield" name="due_school" type="text" value="" />
                            </p>
						</div>
						
						  <div class="_100">
							<p>
                                <label for="textfield">Whether the pupil has undergone Medical Inspection if any during the academic year( First or Repeat to be specified) : </label>
                                <input id="textfield" name="med_inspection"  type="text" value="" />
                            </p>
						</div>
						
						
						  <div class="_50">
							<p>
                                <label for="textfield">Date on which the pupil actually left the school : </label>
                                <input id="datepicker1" name="school_left" type="text" value="" />
                            </p>
						</div>
						
                        <div class="_50">
							<p>
                                <label for="textfield">The pupil's conduct and character :</label>
                                <input id="textfield" name="conduct" type="text" value="" />
                            </p>
						</div>
						 
						 	<div class="_50">
							<p>
                                <label for="textfield">Date on which Parent/Guardian applied for TC :</label>
                                <input id="datepicker3" name="dtc1" type="text" value="<?php echo date("d/m/Y");?>" />
                            </p>
						</div>
						
						
                        <div class="_25">
							<p>
                                <label for="textfield">Date of the Transfer Certificate :</label>
                                <input id="datepicker2" name="dtc" type="text" value="<?php echo date("d/m/Y");?>" />
                            </p>
						</div>
						 
						 
						
						 
                        <div class="_100" style="margin-left:35px;">
							<p>
                                <label for="textfield">a) Standard in which the pupil was studying at the time of leaving(in words) : </label>
                                <input id="textfield" name="leaving" type="text" value="" />
                            </p>
						</div>
						 <!-- 
                        <div class="_100" style="margin-left:35px;">
							<p>
                                <label for="textfield">b) The course offered i.e. General Education or Vocational Education : </label>
                                <input id="textfield" name="course_offer" type="text" value="" />
                            </p>
						</div>
                        <div class="_100" style="margin-left:35px;">
							<p>
                                <label for="textfield">c) In the Case of General Education the subjects offered under part III : </label>
                                <input id="textfield" name="education_iii" type="text" value="" />
                            </p>
						</div>
                        <div class="_100" style="margin-left:35px;">
							<p>
                                <label for="textfield">d) In the Case of Vocational Education the Vocational subject offered Under Part III Group(A) : </label>
                                <input id="textfield" name="education_iiia" type="text" value="" />
                            </p>
						</div>
                        <div class="_100" style="margin-left:35px;">
							<p>
                                <label for="textfield">e) Language offered under Part I : </label>
                                <input id="textfield" name="language" type="text" value="" />
                            </p>
						</div>
                        <div class="_100" style="margin-left:35px;">
							<p>
                                <label for="textfield">f) Medium of study :</label>
                                <input id="textfield" name="medium" type="text" value="" />
                            </p>
						</div>
						 -->
                        <div class="_100">
							<p>
                                <label for="textfield">Whether qualified for promotion to higher Standard under Higher Secondary Education Rules :</label>
                                <input id="textfield" name="edu_rule" type="text" value="" />
                            </p>
						</div>
                       
                        <div class="_100">
							<p>
                                <label for="textfield">Whether the pupil was in receipt of any Scholarship (Nature of the Scholarship To be specified) :</label>
                                <input id="textfield" name="scholarship" type="text" value="" />
                            </p>
						</div>
                      
                      
						
                        <div class="_100">
							<p>
                                <label for="textfield">Date on which application for Transfer certificate was made on behalf of the pupil by the parent or guardian : </label>
                                <input id="textfield" name="guardian" type="text" value="" />
                            </p>
						</div>
						
						
					
						
						
						
						 
						 <div class="_25">
							<p>
                                <label for="textfield">Course of Study : <span class="error">*</span></label>
                                <input id="textfield" name="course" class="required" type="text" value="<?php echo $class['c_name'];?>" />
                            </p>
						</div>
						
                        <div class="_25">
							<p>
                                <label for="textfield">Academic Year : <span class="error">*</span></label>
                                <input id="textfield" name="academic_year" class="required" type="text" value="<?php echo $ayears['y_name'];?>" />
                            </p>
						</div>
						
                        <div class="_25">
							<p>
								<label for="select">Standard(s) Studied : <span class="error">*</span></label>
                                <input id="textfield" name="standard" class="required" type="text" value="<?php echo $section['s_name'];?>" />								
							</p>
						</div>
						
                        <div class="_50">
							<p>
								<label for="select">First Language : </label>
                                <input id="textfield" name="first_lan" type="text" value="" />
							</p>
						</div>
						
                        <div class="_50">
							<p>
                                <label for="textfield">Medium Instruction :</label>
                                <input id="textfield" name="med_ins" type="text" value="" />
                            </p>
						</div>
						 <div class="_100">
							<p>
                                <label for="textfield">purpose<font color="red">*</font></label>
                                <input id="purpose"  name="purpose" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            <input type="hidden" class="medium" name="emisno1" value="<?php echo $emisno+1;?>" >
                            <input type="hidden" class="medium" name="tcno1" value="<?php echo $tcno+1;?>" >
                            <input type="hidden" class="medium" name="ssid" value="<?php echo $ssid;?>" >
                           	<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
            <?php } ?>            
            
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
   <?php if($_GET['roll']){ ?><script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI --> <?php } ?>
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
  <?php if(!$_GET['roll']){ include("auto2.php"); ?>
  <script src="js/jquery-migrate-1.2.1.js"></script>
  <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
<?php }?>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		<?php if($_GET['roll']){ ?> /*
		 * Datepicker
		 */
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
		$( "#datepicker2" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
		$( "#datepicker3" ).Zebra_DatePicker({
	        format: 'd/m/Y'
	    });		
		<?php } ?>
	});
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript">
$(document).ready(function() {
    function languageChange()
    {
         var lang = $('#ayid option:selected').val();
        return lang;
    }
    $('#ayid').change(function(e) { 
var ayid=$("#ayid").val();

window.location.href='tc_xi_single.php?bid=<?=$bid?>&ayid='+ayid;
       
    	/*   var lang = languageChange();
		//alert(lang);
		//var dataString = 'lang=' + lang +'fdisid=1';
        $.ajax({
            type: "POST",
            url: "pass_value3.php",
            //data: dataString,
			data :{"lang":lang},
            dataType: 'json',
            cache: false,
            success: function(response) {
                    alert(response.message);					
                }
        });
		
		//location.reload();
		window.location.reload();
        return false;
*/
        
    });
});
</script>
</body>
</html>
<? ob_flush(); ?>