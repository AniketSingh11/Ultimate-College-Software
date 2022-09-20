<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$day=$_POST['day'];
	$p1=$_POST['p1'];
	$p2=$_POST['p2'];
	$p3=$_POST['p3'];
	$p4=$_POST['p4'];
	$p5=$_POST['p5'];
	$p6=$_POST['p6'];
	$p7=$_POST['p7'];
	$p8=$_POST['p8'];
	$sid=$_POST['sid'];
	$cid=$_POST['cid'];
	$bid=$_POST['bid'];
	
		$sql="INSERT INTO timetable (d_id,p1,p2,p3,p4,p5,p6,p7,p8,c_id,s_id,b_id,ay_id) VALUES
('$day','$p1','$p2','$p3','$p4','$p5','$p6','$p7','$p8','$cid','$sid','$bid','$acyear')";


$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:tablemng_single.php?cid=$cid&sid=$sid&bid=$bid&msg=succ");
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
							// $acyear;
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	 // echo $class['c_name']."-".$section['s_name'];
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_table.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="timetable_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="Home">Class Timetable Management</a></li>
                <li class="no-hover">Add Timetable</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Timetable (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			<a href="timetable_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New Time Table</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						
                       <div class="_100">
							<p>
								<label for="select">Day : <span class="error">*</span></label>
								<select name="day" class="required">
									<option value="">Select Day</option>
                                    <?php $qry=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
									<option value="<?php echo $row['d_id'];?>"><?php echo $row['d_name'];?></option>
                                    <?php } ?>                                    
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">I period : <span class="error">*</span></label>
                                <select name="p1" class="required">
									<option value="">Select Subject</option>
									<?php $qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ 
				 $slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);?>
									<option value="<?php echo $row['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                    <?php } 
									$qry=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                                    <option value="<?php echo $row['ep_code'];?>"><?php echo $row['ep_name'];?></option>
                                    <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">II period : <span class="error">*</span></label>
                                <select name="p2" class="required">
									<option value="">Select Subject</option>
									<?php $qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{  
				 $slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);?>
									<option value="<?php echo $row['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                    <?php }  
									$qry=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                                    <option value="<?php echo $row['ep_code'];?>"><?php echo $row['ep_name'];?></option>
                                    <?php } ?>
								</select>
							</p>
						</div>
                        
                        <div class="_50">
							<p>
								<label for="select">III period : <span class="error">*</span></label>
                                <select name="p3" class="required">
									<option value="">Select Subject</option>
									<?php $qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{  
				 $slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);?>
									<option value="<?php echo $row['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                    <?php }  
									$qry=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                                    <option value="<?php echo $row['ep_code'];?>"><?php echo $row['ep_name'];?></option>
                                    <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">IV period : <span class="error">*</span></label>
                                <select name="p4" class="required">
									<option value="">Select Subject</option>
									<?php $qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{  
				 $slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);?>
									<option value="<?php echo $row['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                    <?php }  
									$qry=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                                    <option value="<?php echo $row['ep_code'];?>"><?php echo $row['ep_name'];?></option>
                                    <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">V period : <span class="error">*</span></label>
                                <select name="p5" class="required">
									<option value="">Select Subject</option>
									<?php $qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{  
				 $slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);?>
									<option value="<?php echo $row['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                    <?php } 
									$qry=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                                    <option value="<?php echo $row['ep_code'];?>"><?php echo $row['ep_name'];?></option>
                                    <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">VI period : <span class="error">*</span></label>
                                <select name="p6" class="required">
									<option value="">Select Subject</option>
									<?php $qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{  
				 $slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);?>
									<option value="<?php echo $row['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                    <?php }  
									$qry=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                                    <option value="<?php echo $row['ep_code'];?>"><?php echo $row['ep_name'];?></option>
                                    <?php } ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">VII period : <span class="error">*</span></label>
                                <select name="p7" class="required">
									<option value="">Select Subject</option>
									<?php $qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{  
				 $slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);?>
									<option value="<?php echo $row['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                    <?php }  
									$qry=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                                    <option value="<?php echo $row['ep_code'];?>"><?php echo $row['ep_name'];?></option>
                                    <?php } ?>
								</select>
                                
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">VIII period : <span class="error">*</span></label>
                                <select name="p8" class="required">
									<option value="">Select Subject</option>
									<?php $qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{  
				 $slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);?>
									<option value="<?php echo $row['sub_id'];?>"><?php echo $slist['s_name'];?></option>
                                    <?php }  
									$qry=mysql_query("SELECT * FROM extraperoid WHERE ay_id=$acyear");							
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                                    <option value="<?php echo $row['ep_code'];?>"><?php echo $row['ep_name'];?></option>
                                    <?php } ?>
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
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).datepicker();
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