<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	 $r_name=$_POST['r_name'];
	 $v_id=$_POST['v_id'];
	 $d_id=$_POST['d_id'];
	 $sd_id=$_POST['sd_id'];
	 $status=$_POST['status'];
	 $rid=$_POST['rid'];
	 $r_contact=$_POST['r_contact'];
	
		
		$sql="UPDATE route SET r_name='$r_name',v_id='$v_id',d_id='$d_id',sd_id='$sd_id',status='$status',status='$status',r_contact='$r_contact' WHERE r_id='$rid'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:route_edit.php?rid=$rid&msg=succ");
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
				<li class="no-hover"><a href="route.php" title="Home">Route Master list</a></li>
                <li class="no-hover">Edit Route Master</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Route Master Details</h1>                
			<a href="route.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Route Master Details</h1><span></span>
					</div>
                    <?php 
					$rid=$_GET['rid'];
							$stafflist=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $staff=mysql_fetch_array($stafflist);
								  $vid=$staff['v_id'];
								  $did=$staff['d_id'];
								  $sdid=$staff['sd_id'];
								  ?>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
							<p>
                                <label for="textfield">Route Master Name</label>
                                <input id="textfield" name="r_name" class="required" type="text" value="<?php echo $staff['r_name'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Vehicle No : <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT v_id,v_no FROM vehicle";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="v_id" id="v_id" class="required">';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($vid==$row1['v_id']){
                                                echo "<option value='{$row1['v_id']}' selected>Bus No : {$row1['v_no']}</option>\n";
											}else{
												echo "<option value='{$row1['v_id']}'>Bus No : {$row1['v_no']}</option>\n";
											}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Driver: <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT * FROM driver WHERE d_type='Driver'";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="d_id" id="d_id" class="required">';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($did==$row1['d_id']){
                                                echo "<option value='{$row1['d_id']}' selected>{$row1['fname']} {$row1['lname']}</option>\n";
												}else{
												echo "<option value='{$row1['d_id']}'>{$row1['fname']} {$row1['lname']}</option>\n";	
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Bus Assistant: <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT * FROM driver WHERE d_type='Non-Driver'";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="sd_id" id="sd_id" class="required">';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($sdid==$row1['d_id']){
                                                echo "<option value='{$row1['d_id']}' selected >{$row1['fname']} {$row1['lname']}</option>\n";
												}else{
												echo "<option value='{$row1['d_id']}' >{$row1['fname']} {$row1['lname']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Root Contact No <span class="error">*</span>:</label>
                                <input id="r_contact" name="r_contact"  type="text" value="<?php echo $staff['r_contact'];?>" class="required"/>
                            </p>
						</div>
                         <div class="_50">
							<p>
								<label for="select">Active Status :</label>
									<select name="status">
												<option value="1" <?php if($staff['status']=='1'){ echo 'selected'; }?>>Enabled</option>
								<option value="0" <?php if($staff['status']=='0'){ echo 'selected'; }?>>Disabled</option>
											</select>								
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="rid" value="<?php echo $_GET['rid'];?>" >
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