<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 $aid=$_GET['aid'];
 
 if (isset($_POST['submit']))
{
	$aname=$_POST['aname'];
	$cname=$_POST['cname'];
	$add=$_POST['add'];
	$phone=$_POST['phone'];
	$status=$_POST['status'];
		
	$qry="UPDATE agency SET a_name='$aname',a_address='$add',a_person='$cname',a_mobile='$phone',status='$status' WHERE a_id='$aid'";
	$result = mysql_query($qry) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:agency_edit.php?aid=$aid&msg=succ");
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
				<li class="no-hover"><a href="agency.php" title="Home">Agency list</a></li>
                <li class="no-hover">Edit Agency</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
					<?php 
							$classlist=mysql_query("SELECT * FROM agency WHERE a_id=$aid"); 
								  $agency=mysql_fetch_array($classlist);	
							?>
			<div class="grid_12">
				<h1>Edit Agency</h1>                
			<a href="agency.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Agency</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_50">
							<p>
                                <label for="textfield">Agency Name</label>
                                <input id="textfield" name="aname" class="required" type="text" value="<?php echo $agency['a_name']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Conatct Person Name</label>
                                <input id="textfield" name="cname" class="required" type="text" value="<?php echo $agency['a_person']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Address</label>
                                <textarea name="add" rows="5" ><?php echo $agency['a_address']; ?></textarea>
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Mobile/Phone No</label>
                                <input id="textfield" name="phone" class="required" type="text" value="<?php echo $agency['a_mobile']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Active Status :</label>
									<select name="status">
												<option value="0" <?php if($agency['status']=='0'){ echo 'selected'; }?>>Enabled</option>
								<option value="1" <?php if($agency['status']=='1'){ echo 'selected'; }?>>Disabled</option>
											</select>								
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
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