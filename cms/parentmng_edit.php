<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$p_name=$_POST['p_name'];
	echo $p_occup=$_POST['p_occup'];
	$phone=$_POST['phone'];
	$sid=$_POST['sid'];
	$cid=$_POST['cid'];
	$ssid=$_POST['ssid'];
	$pid=$_POST['pid'];
	$status=$_POST['status'];
	$email=$_POST['email'];
	$bid=$_POST['bid'];
	
	
	$sql="UPDATE student SET fathersname='$p_name',phone_number='$phone',fathersocupation='$p_occup',email='$email',ay_id='$acyear' WHERE ss_id='$ssid'";
	
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$sql1="UPDATE parent SET p_name='$p_name',phone_number='$phone',user_status='$status',ocupation='$p_occup',ay_id='$acyear',email='$email',b_id='$bid'
 WHERE ss_id='$ssid'";
	
$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
    if($result && $result1){
        header("Location:parentmng_edit.php?cid=$cid&sid=$sid&ssid=$ssid&pid=$pid&bid=$bid&msg=succ");
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
							$ssid=$_GET['ssid'];
							$pid=$_GET['pid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	 // echo $class['c_name']."-".$section['s_name'];
								 $parentlist=mysql_query("SELECT * FROM parent WHERE p_id=$pid"); 
								  $row=mysql_fetch_array($parentlist);	 
								 $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $row1=mysql_fetch_array($studentlist);	 
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_parent.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="parent_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="Home">Parent Management</a></li>
                <li class="no-hover">Edit Student Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Parent Details (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			<a href="parent_mng.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Parent Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                   	 <div class="_100">
							<p>
                                <label for="textfield">Admin No :<span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $row1['admission_number']; ?>" readonly />
                            </p>
						</div>
						<div class="_100">
							<p>
                                <label for="textfield">Name of Parent / Guardian :<span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="<?php echo $row['p_name']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Phone : <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="<?php echo $row['phone_number']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Occupation of Parent or Guardian :<span class="error">*</span></label>
                                <input id="textfield" name="p_occup" class="required" type="text" value="<?php echo $row['ocupation']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Email :<span class="error">*</span></label>
                                <input id="textfield" name="email" class="required" type="text" value="<?php echo $row['email']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Active Status :</label>
									<select name="status">
												<option value="1" <?php if($row['user_status']=='1'){ echo 'selected'; }?>>Enabled</option>
								<option value="0" <?php if($row['user_status']=='0'){ echo 'selected'; }?>>Disabled</option>
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
                            <input type="hidden" class="medium" name="ssid" value="<?php echo $_GET['ssid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="pid" value="<?php echo $_GET['pid'];?>" >
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