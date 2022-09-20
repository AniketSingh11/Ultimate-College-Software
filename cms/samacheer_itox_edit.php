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
	$edu_rule=$_POST['edu_rule'];
	$scholarship=$_POST['scholarship'];
	$med_inspection=$_POST['med_inspection'];
	$school_left=$_POST['school_left'];
	$conduct=$_POST['conduct'];
	$guardian=$_POST['guardian'];
	$dtc=$_POST['dtc'];
	$course=$_POST['course'];
	$academic_year=$_POST['academic_year'];
	$standard=$_POST['standard'];
	$first_lan=$_POST['first_lan'];
	$med_ins=$_POST['med_ins'];
	$sxid=$_POST['sxid'];
	$bid=$_POST['bid'];	
		
$sql="UPDATE samacheer_itox SET ano='$ano',tno='$tno',eno='$eno',sname='$sname',fname='$fname',nation='$nation',community='$community',adidravidar='$adidravidar',bc='$bc',mbc='$mbc',convert_christ='$convert_christ',de_community='$de_community',sex='$sex',dob='$dob',identity1='$identity1',identity2='$identity2',doa='$doa',leaving='$leaving',edu_rule='$edu_rule',scholarship='$scholarship',med_inspection='$med_inspection',school_left='$school_left',conduct='$conduct',guardian='$guardian',dtc='$dtc',course='$course',course='$course',academic_year='$academic_year',standard='$standard',first_lan='$first_lan',med_ins='$med_ins',b_id='$bid' WHERE id='$sxid'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();
    if($result){
        header("Location:samacheer_itox_edit.php?sxid=$sxid&bid=$bid&msg=succ");
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
    <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>  				
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_tc1to9.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="samacheer_itox.php?bid=<?php echo $bid;?>" title="Home">I to X Samacheer Certificate</a></li>
                <li class="no-hover">Edit I to IX Samacheer Certificate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit I to IX Samacheer Certificate</h1>                
			<a href="samacheer_itox.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully edited!!!
            <center><a href="samacheer_itox_prt.php?sxid=<?php echo $_GET['sxid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Edited Certificate</button></a></center>
            </div>
            <?php } 
							$sxid=$_GET['sxid'];
							$stafflist=mysql_query("SELECT * FROM samacheer_itox WHERE id=$sxid"); 
								  $row=mysql_fetch_array($stafflist);
			?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit IX-Samacheer Certificate</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_25">
							<p>
                                <label for="textfield">EMIS Number : <span class="error">*</span></label>
                                <input id="textfield" name="eno" class="required" type="text" value="<?php echo $row['eno']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Admission Number : <span class="error">*</span></label>
                                <input id="textfield" name="ano" class="required" type="text" value="<?php echo $row['ano']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">TC Number : <span class="error">*</span></label>
                                <input id="textfield" name="tno" class="required" type="text" value="<?php echo $row['tno']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Pupil : <span class="error">*</span></label>
                                <input id="textfield" name="sname" class="required" type="text" value="<?php echo $row['sname']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Father or Mother of the Pupil  :<span class="error">*</span></label>
                                <input id="textfield" name="fname"  type="text" class="required" value="<?php echo $row['fname']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Nationality and Religion : <span class="error">*</span></label>
                                <input id="textfield" name="nation" class="required" type="text" value="<?php echo $row['nation']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Community : </label>
                                <input id="textfield" name="community" type="text" value="<?php echo $row['community']; ?>" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">a) Adi Dravidar(Scheduled Caste) or (Scheduled Tribe) :</label>
                                <input id="textfield" name="adidravidar" type="text" value="<?php echo $row['adidravidar']; ?>" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield"> b) Backward Class :</label>
                                <input id="textfield" name="bc" type="text" value="<?php echo $row['bc']; ?>" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">c) Most Backward Class :</label>
                                <input id="textfield" name="mbc" type="text" value="<?php echo $row['mbc']; ?>" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">d) Convert to Christianity from scheduled Caste or :</label>
                                <input id="textfield" name="convert_christ" type="text" value="<?php echo $row['convert_christ']; ?>" />
                            </p>
						</div>
                        <div class="_50" style="margin-left:50px;">
							<p>
                                <label for="textfield">e) Denotified Communities :</label>
                                <input id="textfield" name="de_community" type="text" value="<?php echo $row['de_community']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Gender : <span class="error">*</span></label>
                                <input id="textfield" name="sex" class="required"  type="text" value="<?php echo $row['sex']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Date of birth as entered in the Admission Register( in figures & words) :</label>
                                <input name="dob"  type="text" value="<?php echo $row['dob']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Personal marks of Identification :</label>
                                <input id="textfield" name="identity1" type="text" value="<?php echo $row['identity1']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield"> &nbsp;</label>
                                <input id="textfield" name="identity2" type="text" value="<?php echo $row['identity2']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Date of Admission and standard in which admitted( the year to be entered, in words) : <span class="error">*</span></label>
                                <input name="doa" class="required" type="text" value="<?php echo $row['doa']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Standard in which the pupil was studying at the time of leaving(in words) : </label>
                                <input id="" name="leaving" type="text" value="<?php echo $row['leaving']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Whether qualified for promotion to higher Standard  :</label>
                                <input id="textfield" name="edu_rule" type="text" value="<?php echo $row['edu_rule']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Whether the pupil was in receipt of any Scholarship (Nature of the Scholarship To be specified) :</label>
                                <input id="textfield" name="scholarship" type="text" value="<?php echo $row['scholarship']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Whether the pupil has undergone Medical Inspection if any during the academic year( First or Repeat to be specified) : </label>
                                <input id="textfield" name="med_inspection"  type="text" value="<?php echo $row['med_inspection']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Date on which the pupil actually left the school : </label>
                                <input id="datepicker1" name="school_left" type="text" value="<?php echo $row['school_left']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">The pupil's conduct and character :</label>
                                <input id="textfield" name="conduct" type="text" value="<?php echo $row['conduct']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Date on which application for Transfer certificate was made on behalf of the pupil by the parent or guardian : </label>
                                <input id="textfield" name="guardian" type="text" value="<?php echo $row['guardian']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date of the Transfer Certificate :</label>
                                <input id="datepicker2" name="dtc" type="text" value="<?php echo $row['dtc']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Course of Study : <span class="error">*</span></label>
                                <input id="textfield" name="course" class="required" type="text" value="<?php echo $row['course']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Academic Year : <span class="error">*</span></label>
                                <input id="textfield" name="academic_year" class="required" type="text" value="<?php echo $row['academic_year']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Standard(s) Studied : <span class="error">*</span></label>
                                <input id="textfield" name="standard" class="required" type="text" value="<?php echo $row['standard']; ?>" />								
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">First Language : </label>
                                <input id="textfield" name="first_lan" type="text" value="<?php echo $row['first_lan']; ?>" />
							</p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Medium Instruction :</label>
                                <input id="textfield" name="med_ins" type="text" value="<?php echo $row['med_ins']; ?>" />
                            </p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            <input type="hidden" class="medium" name="sxid" value="<?php echo $_GET['sxid'];?>" >
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
  
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
		$( "#datepicker1" ).datepicker();
		$( "#datepicker2" ).datepicker();
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