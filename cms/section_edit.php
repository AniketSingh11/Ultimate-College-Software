<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/standard.php");
 
			$cid=$_GET['cid'];
							 $classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  
								  $bid=$class['b_id'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								 
 if (isset($_POST['submit']))
{
	$s_name=$_POST['sname'];
	$cid=$_POST['cid'];
	$sid=$_POST['sid'];
	if($class['c_name']=="XI" || $class['c_name']=="XII"){
		$gname=$_POST['gname'];	
		$qry=mysql_query("UPDATE section SET s_name='$s_name',ay_id='$acyear',g_name='$gname' WHERE s_id='$sid'");
	} else {
		$gname='';	
		$qry=mysql_query("UPDATE section SET s_name='$s_name',ay_id='$acyear',g_name='$gname' WHERE s_id='$sid'");
	}
    if($qry){
        header("Location:section_edit.php?sid=$sid&cid=$cid&msg=succ");
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
				<li class="no-hover"><a href="board_select.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="standard.php?bid=<?php echo $bid;?>" title="Standard list">Standard list</a></li>
                <li class="no-hover"><a href="section.php?cid=<?php echo $cid; ?>" title="<?php  echo $class['c_name'];?> Section/Group list"><?php  echo $class['c_name'];?> Section/Group list</a></li>
                <li class="no-hover">Edit <?php  echo $class['c_name'];?> Section/Group</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit <?php  echo $class['c_name'];?> Section/Group</h1>                
			<a href="section.php?cid=<?php echo $cid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit <?php  echo $class['c_name'];?> Section/Group</h1><span></span>
					</div>
                    <?php 
							$sid=$_GET['sid'];
							$cid=$_GET['cid'];
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
					<?php 

						if($class['c_name']=="XI" || $class['c_name']=="XII") { ?>
						<div class="_100">
							<p>
                                <label for="textfield">Group Name</label>
                                <select name="gname">
                                <option>Please Select</option>
                                <?php if($section['g_name']=="I Group") {?>
                                <option value="I Group" selected>I Group</option>
                            	<?php } else {?>
                            	 <option value="I Group">I Group</option>
                                <?php } if($section['g_name']=="II Group") {?>
                                <option value="II Group" selected>II Group</option>
                            	<?php } else { ?>
                            	 <option value="II Group">II Group</option>
                            	 <?php } if($section['g_name']=="III Group") { ?>
                                <option value="III Group" selected>III Group</option>
                            	<?php } else { ?>
                            	 <option value="III Group">III Group</option>
                            	 <?php } if($section['g_name']=="IV Group") { ?>
                                <option value="IV Group" selected>IV Group</option>
                            	<?php } else { ?>
                            	 <option value="IV Group">IV Group</option>
                            	 <?php } if($section['g_name']=="V Group") { ?>
                                <option value="V Group" selected>V Group</option>
                            	<?php } else { ?>
                            	 <option value="V Group">V Group</option>
                            	 <?php } ?>
                                </select>
                                
                            </p>
						</div>
						<div class="_100">
							<p>
                                <label for="textfield">Section Name</label>
                                <input id="textfield" name="sname" class="required" type="text" value="<?php echo $section['s_name']; ?>" />
                            </p>
						</div>

						<?php }	else {?>
						<div class="_100">
							<p>
                                <label for="textfield">Section/Group Name</label>
                                <input id="textfield" name="sname" class="required" type="text" value="<?php echo $section['s_name']; ?>" />
                            </p>
						</div>
												<?php }	?>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $cid;?>" > 
                             <input type="hidden" class="medium" name="sid" value="<?php echo $sid;?>" > 	
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
			focusCleanup: true,
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