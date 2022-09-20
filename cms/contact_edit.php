<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$cname=$_POST['cname'];
	$cpname=$_POST['cpname'];
	$gender=$_POST['gender'];
	$email=$_POST['email'];
	$address=$_POST['address'];
	$mobile=$_POST['mobile'];
	$phone=$_POST['phone'];
	$desc=$_POST['desc'];
	$ctid=$_POST['ctid'];
		$sql="UPDATE contact SET cname='$cname',cpname='$cpname',gender='$gender',email='$email',address='$address',mobile='$mobile',phone='$phone',desc1='$desc' WHERE ct_id='$ctid'
			";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();
    if($result){
		header("Location:contact_edit.php?ctid=$ctid&msg=succ");
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
    	<?php $ctid=$_GET['ctid']; ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="contact_details.php?ctid=<?php echo $ctid;?>" title="Home">Contact Details List</a></li>
                <li class="no-hover">Edit Contact Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Conatct Details</h1>                
			<a href="contact_details.php?ctid=<?php echo $ctid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Contact Detail</h1><span></span>
					</div>
                    <?php 
					$qry1=mysql_query("SELECT * FROM contact WHERE ct_id='$ctid'");
										  $row1=mysql_fetch_array($qry1);		
					?>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
							<p>
                                <label for="textfield">Company Name / Person Name <span class="error">*</span></label>
                                <input id="textfield" name="cname" class="required" type="text" value="<?php echo $row1['cname'];?>" />
                            </p>
						</div>
                        <div class="_100"> 
							<p>
                                <label for="textfield">Contact Person Name : <span class="error">*</span></label>
                                <input id="textfield" name="cpname" class="required" type="text" value="<?php echo $row1['cpname'];?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Gender : <span class="error">*</span></label>
								<select name="gender" class="required">
									<option value="M" <?php if($row1['gender']=='M'){ echo 'selected'; }?>>Male</option>
									<option value="F" <?php if($row1['gender']=='F'){ echo 'selected'; }?>>Female</option>
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Email : </label>
                                <input id="textfield" name="email"   type="text" value="<?php echo $row1['email'];?>" />
                            </p>
						</div>
                        <div class="_100">
							<p><label for="textarea">Address : <span class="error">*</span></label>
                            <textarea id="textarea" name="address" class="required" rows="5" cols="40"><?php echo $row1['address'];?></textarea></p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Mobile No : <span class="error">*</span></label>
                                <input id="textfield" name="mobile" class="required"  type="text" value="<?php echo $row1['mobile'];?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Phone No : </label>
                                <input id="textfield" name="phone" type="text" value="<?php echo $row1['phone'];?>" />
                            </p>
						</div>
                        <div class="_100">
							<p><label for="textarea">Description : </label>
                            <textarea id="textarea" name="desc" rows="5" cols="40"><?php echo $row1['desc1'];?></textarea></p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="ctid" value="<?php echo $ctid;?>" >
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