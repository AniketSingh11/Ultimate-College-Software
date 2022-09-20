<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/subject_management.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$slid=$_POST['slid'];
	$cid=$_POST['cid'];
	$sid=$_POST['sid'];
	$stid=$_POST['stid'];
	$bid=$_POST['bid'];
	
		$sql="INSERT INTO subject (sl_id,c_id,s_id,st_id,b_id,ay_id) VALUES
('$slid','$cid','$sid','$stid','$bid','$acyear')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:subjectmng_single1.php?cid=$cid&sid=$sid&bid=$bid&msg=succ");
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
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_assoc($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_assoc($sectionlist);
							$bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_assoc($boardlist);	  
							 	 // echo $class['c_name']."-".$section['s_name'];
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select2.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="subject_mng1.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="Home">Staff Assign</a></li>
                <li class="no-hover">Assign New Staff details </li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Assign New Staff details (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			<a href="subject_mng1.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
				<div class="block-border">
					<div class="block-header">
						<h1>Assign New Staff details </h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
							<p>
								<label for="select">Subject : </label>
                                	<?php
                                            $cname=$class['c_name'];
												if($cname == 'XI STD' || $cname == 'XII STD'){ 
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
											}else{
												$qry=mysql_query("SELECT * FROM subjectlist Where c_id=$cid AND b_id=$bid AND ay_id=$acyear");
											}
                                            echo '<select name="slid" id="slid" class="required"> 
											<option value="">Select Subject</option>';
											while ($row2 = mysql_fetch_assoc($qry)): 
												$slid1=$row2['sl_id'];
												$sublist=mysql_query("SELECT sub_id FROM subject WHERE sl_id=$slid1 AND c_id=$cid AND ay_id=$acyear"); 
								  				$subcheck=mysql_num_rows($sublist);
												if($subcheck=='0'){?>
                                                <option value='<?php echo $row2['sl_id'];?>'><?php echo $row2['s_name'];?></option>
                         <?php              }
						 					endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Staff : </label>
                                	<?php
										$classl1 = "SELECT * FROM staff WHERE s_type='Teaching' AND status=1";
										$result1 = mysql_query($classl1) or die(mysql_error());
										echo '<select name="stid" id="stid" class="required"> 
										<option value="">Select Staff</option>';
										while ($row1 = mysql_fetch_assoc($result1)): ?>
											<option value='<?php echo $row1['st_id'];?>'><?php echo $row1['fname']." ".$row1['mname']." ".$row1['lname'];?></option>
					 <?php              endwhile;
										echo '</select>';
										?>
								</select>
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