<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 //echo $acyear;
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
				<li class="no-hover">Dashboard</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Dashboard</h1>
				<p>Here you have a quick overview of some features</p>
				<div class="alert success"><span class="hide">x</span>Hey there! Welcome to the <strong>&quot;School/College Management Solution &quot;</strong> admin Panel. I hope you enjoy your stay and please make sure, that you visit the other pages.</div>
			</div>			
			<?php include("includes/bigmenu.php"); ?>

			<!--<div class="grid_3">
				<div class="block-border">
					<div class="block-header">
						<h1>Today Birthday</h1><span></span>
					</div>
                    
					<div class="block-content">
                    <center><img src="img/student/LKGA001.jpg" alt="Student" title="Student" width="70%" / ></center>
						<ul class="block-list with-icon">
							<li class="i-16-user">LKGA001 - Kamaraj M</li>
							<li class="i-16-key">LKG - A ( Student )</li>
                            <li class="i-16-heart">Happy B'Day To Kamaraj</li>
						</ul>
					</div>
				</div>
			</div>-->
			<div class="grid_4">
				<div class="block-border">
					<div class="block-header">
						<h1>Management System</h1><span></span>
					</div>
					<div class="block-content">
						<ul class="block-list with-icon">
							<a href="library/dashboard.php"><li class="i-16-calendar">Library Management System</li></a>
							<a href="hostel/dashboard.php"><li class="i-16-application">Hostel Management System</li></a>
							<a href="hostel/dashboard.php"><li class="i-16-bookmark">Book Inventory</li></a>
							<a href="payroll/dashboard.php"><li class="i-16-chart">Payroll Management System</li></a>
							<li class="i-16-key">Vehicle management System</li>
                            <li class="i-16-drive">Front Office Module</li>
                            <li class="i-16-tick">School Needs (Stationary )</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="grid_4">
				<div class="block-border">
					<div class="block-header">
						<h1>Overview-List</h1><span></span>
					</div>
					<div class="block-content">
						<div class="alert info no-margin top">You have 12 new updated.</div>
						<ul class="overview-list">
                        <?php 
						$student=mysql_query("SELECT * FROM student WHERE ay_id=$acyear");
						$staff=mysql_query("SELECT * FROM staff");
						$event=mysql_query("SELECT * FROM event WHERE ay_id=$acyear");
						$news=mysql_query("SELECT * FROM news WHERE ay_id=$acyear");
						
						$samacheer_x=mysql_query("SELECT * FROM samacheer_x WHERE ay_id=$acyear");
						$samacheer_itox=mysql_query("SELECT * FROM samacheer_itox WHERE ay_id=$acyear");
							 ?>
							<li><a href="javascript:void(0);"><span><?php echo mysql_num_rows($student);?></span> Total Students</a></li>
							<li><a href="javascript:void(0);"><span><?php echo mysql_num_rows($staff);?></span> Total staffs</a></li>
							<li><a href="javascript:void(0);"><span><?php echo mysql_num_rows($event)+mysql_num_rows($news);?></span> News and Events</a></li>
							<li><a href="javascript:void(0);"><span><?php echo mysql_num_rows($samacheer_x);?></span> Samacheer Certificate(X)</a></li>
                            <li><a href="javascript:void(0);"><span><?php echo mysql_num_rows($samacheer_itox);?></span> Transfer Certificate(XI to XII)</a></li>
						</ul>
					</div>
				</div>
			</div>
			
            <div class="grid_4"  <?php if($user=="Principal"){?>style="display: none;" <?php }?>>
           	<div class="block-border">
					<div class="block-header">
						<h1>Create a News</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<p class="inline-mini-label">
							<label for="title">Title</label>
							<input type="text" name="title" class="required">
						</p>
						<p class="inline-mini-label">
							<label for="category">Category</label>
							<select name="category" id="category">
								<option>School Events</option>
								<option>School Achievement</option>
								<option>Other</option>
							</select>
						</p>
						<p class="inline-mini-label">
								<label for="post">News</label>
								<textarea id="post" name="post" class="required" rows="5" cols="40"></textarea>
							</p>
						</p>

						<div class="clear"></div>
						
						<!-- Buttons with actionbar  -->
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Cancel</a></li>
							</ul>
							<ul class="actions-right">
								<li><input type="submit" class="button" value="Create News"></li>
							</ul>
						</div> <!--! end of #block-actions -->
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
  <script type="text/javascript"
			src="js/jquery.min.js"></script>
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
  <script type="text/javascript">
	$().ready(function() {		
		/*
		 * Form Validation
		 */
		$.validator.setDefaults({
			submitHandler: function(e) {
				$.jGrowl("Form was successfully submitted.", { theme: 'success' });
				$(e).parent().parent().fadeOut();
				v.resetForm();
				v2.resetForm();
				v3.resetForm();
			}
		});
		var v = $("#create-user-form").validate();
		jQuery("#reset").click(function() { v.resetForm(); $.jGrowl("User was not created!", { theme: 'error' }); });
		
		var v2 = $("#write-message-form").validate();
		jQuery("#reset2").click(function() { v2.resetForm(); $.jGrowl("Message was not sent.", { theme: 'error' }); });
		
		var v3 = $("#create-folder-form").validate();
		jQuery("#reset3").click(function() { v3.resetForm(); $.jGrowl("Folder was not created!", { theme: 'error' }); });
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
	});
	
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>