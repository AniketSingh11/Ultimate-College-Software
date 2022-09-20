<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 if (isset($_POST['submit']))
{
	//$admin_no=$_POST['admin_no'];
	$name=$_POST['name'];
	$p_name=$_POST['p_name'];
	$standard=$_POST['standard'];
	$year=$_POST['year'];
	$city=$_POST['city'];
	$dob=$_POST['dob'];
	$bid=$_POST['bid'];
	$purpose=$_POST['purpose'];
	
$sql="UPDATE bonafide SET name='$name',p_name='$p_name',standard='$standard',year='$year',dob='$dob',city='$city',purpose='$purpose' WHERE b_id='$bid'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

    if($result){		
     header("Location:bonafide_edit.php?bid=$bid&msg=succ");	   
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
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="bonafide.php" title="Home">Bonafide</a></li>
                <li class="no-hover">Edit Bonafide</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<?php
					 $bid=$_GET['bid'];
							$bonafide=mysql_query("SELECT * FROM bonafide WHERE b_id=$bid"); 
							$row=mysql_fetch_array($bonafide);
							?>
			<div class="grid_12">
				<h1>Edit Bonafide</h1>                
			<a href="bonafide.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!
            <center><a href="bonafide_prt.php?bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Edited Bonafide</button></a></center>
            </div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Bonafide</h1><span></span>
					</div>
                    <form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_50">
							<p>
                                <label for="textfield">Ref No : &nbsp; <?php echo $row['ref_number']; ?> </label>
                                
                            </p>
						</div>
						<div class="_50">
							<p>
                                <label for="textfield">Admin No : &nbsp; <?php echo $row['admin_no']; ?></label>
                                <!--  <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $row['admin_no']; ?>" />-->
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Student Name</label>
                                <input id="textfield" name="name" class="required" type="text" value="<?php echo $row['name']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Parent's Name (Father name / Mother name)</label>
                                <input id="textfield" name="p_name" class="required" type="text" value="<?php echo $row['p_name']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Standard</label>
                                <input id="textfield" name="standard" class="required" type="text" value="<?php echo $row['standard']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Year Duration</label>
                                <input id="textfield" name="year" class="required" type="text" value="<?php echo $row['year']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Date of Birth</label>
                                <input id="datepicker1"  name="dob" class="required" type="text" value="<?php echo $row['dob']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">City</label>
                                <input id="city"  name="city" class="required" type="text" value="<?php echo $row['city']; ?>" />
                            </p>
						</div>
						
						 <div class="_50">
							<p>
                                <label for="textfield">Purpose</label>
                                <input id="purpose"  name="purpose" class="required" type="text" value="<?php echo $row['purpose']; ?>" />
                            </p>
						</div>
						
						
						
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
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
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'm/d/Y'
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