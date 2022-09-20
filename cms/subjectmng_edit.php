<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/subject_management.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$s_code=$_POST['s_code'];
	$s_name=$_POST['s_name'];
	$cid=$_POST['cid'];
	$sid=$_POST['sid'];
	$subid=$_POST['subid'];
	$bid=$_POST['bid'];
	$paper=$_POST['paper'];
	$stype=$_POST['s_type'];
	$extra=$_POST['extra_sub'];
		/*$sql="INSERT INTO subject (s_code,s_name,c_id,s_id) VALUES
('$s_code','$s_name','$cid','$sid')";*/

	$sql="UPDATE subjectlist SET s_code='$s_code',s_name='$s_name',b_id='$bid',ay_id='$acyear',paper='$paper',s_type='$stype',extra_sub=$extra WHERE sl_id='$subid'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:subjectmng_edit.php?cid=$cid&sid=$sid&subid=$subid&bid=$bid&msg=succ");
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
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$subid=$_GET['subid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								   $subjectlist=mysql_query("SELECT * FROM subjectlist WHERE sl_id=$subid"); 
								  $row=mysql_fetch_array($subjectlist);
								  $stid=$row['st_id'];	
							$bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_assoc($boardlist);							  
					  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select1.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="subject_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="Home">Subject Management</a></li>
                <li class="no-hover">Edit Subject</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Subject details (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			<a href="subject_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Subject Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_50">
							<p>
                                <label for="textfield">Subject Code : <span class="error">*</span></label>
                                <input id="textfield" name="s_code" class="required" type="text" value="<?php echo $row['s_code']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Subject Name: <span class="error">*</span></label>
                                <input id="textfield" name="s_name" class="required" type="text" value="<?php echo $row['s_name']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mark Type: <span class="error">*</span></label>
                                <select name="s_type">
                                	<option value="0" <?php if($row['s_type']=='0'){ echo "selected";}?>>FA-SA Concept</option>
                                    <option value="1" <?php if($row['s_type']=='1'){ echo "selected";}?>>100 Marks</option>
                                </select>
                            </p>
						</div>
                        <?php if($class['c_name']=='XI STD' || $class['c_name']=='XII STD' || $class['c_name']=='XI' || $class['c_name']=='XII'){?>
                        <div class="_25">
							<p>
								<span class="label">Paper I & II</span>
								<label><input type="radio" name="paper" value="0" <?php if($row['paper']=='0'){ echo "Checked";}?> /> None</label>
								<label><input type="radio" name="paper" value="1" <?php if($row['paper']=='1'){ echo "Checked";}?> /> Two Paper</label>
							</p>
						</div>
                        <?php } ?>
                         <div class="_25">
							<p>
								<span class="label">Extra Subject</span>
								<?php if($row['extra_sub']==0) { ?>
								<label><input type="radio" name="extra_sub" value="0" checked/> No</label>
								<?php } else { ?>
								<label><input type="radio" name="extra_sub" value="0"/> No</label>
								<?php } if($row['extra_sub']==1) { ?>
								<label><input type="radio" name="extra_sub" value="1" checked/> Yes</label>
								<?php } else { ?>
								<label><input type="radio" name="extra_sub" value="1" /> Yes</label>
								<?php } ?>
							</p>
						</div>
                         <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="subid" value="<?php echo $_GET['subid'];?>" >
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